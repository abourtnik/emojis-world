const config = require('./config');
const express = require('express');
const elasticsearch = require('elasticsearch');
const mongoose = require('mongoose');
const responseTime = require('response-time');

// Elastic Search

var elasticsearch_client = new elasticsearch.Client({
    host: config.elasticsearch.host + ':' + config.elasticsearch.port
});

elasticsearch_client.ping({requestTimeout: 1000}, function (error) {
    if (error) console.error('Failed to connect to ElasticSearch !');
     else console.info('Connect to ElasticSearch successfully');
});

// MongoDB

var options_monogdb = {
    keepAlive: 300000,
    connectTimeoutMS: 30000,
    useNewUrlParser: true
};

var url_mongodb = config.mongodb.type + '://' + ( (config.mongodb.username) ? (config.mongodb.username + ':' + config.mongodb.password + '@' ) : '' ) + config.mongodb.host + ':' + config.mongodb.port + '/' + config.mongodb.database;

mongoose.connect(url_mongodb, options_monogdb);

var monogdb = mongoose.connection;
monogdb.on('error', console.error.bind(console, 'Failed to connect to MonogDB !'));
monogdb.once('open', function (){console.info("Connect to MonogDB successfully");});

var Connection = require('./models/connection.js');

var app = express();
app.use(responseTime(function(req, res, time) {
    res.header('X-Response-Time', time);
}));

var router = express.Router();


function store_user_data (req, res, next) {

    if (req.method === 'GET') {

        // keep executing the router middleware
        next();

        var connection = new Connection();

        connection.ip = req.client.remoteAddress;
        connection.date = Date.now();
        connection.request = req.url;
        connection.duration =  res.getHeaders()['x-response-time'];

        connection.save(function(err){
            if(err) console.error(err);
        });
    }
}

app.use(function (req, res, next) {

    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
    res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
    res.setHeader('Access-Control-Allow-Credentials', true);

    next();
});

app.use(store_user_data);


// ------------------ ENDPOINTS -------------------------------

// SEARCH
require('./routes/search')(router);

// RANDOM EMOJIS
require('./routes/random')(router);

// ALL CATEGORIES AND SUB_CATEGORIES
require('./routes/categories')(router);

// EMOJI BY Category ID
require('./routes/category')(router);

// EMOJI BY Sub Category ID
require('./routes/sub_category')(router);

// EMOJI BY ID
require('./routes/emoji')(router);

// INDEX
require('./routes/index')(router);

// 404
require('./routes/404')(router);

app.use('/v1' , router);

app.listen(config.server.port, config.server.host, function(){
    console.info("Server listen on http://"+ config.server.host +":"+config.server.port);
});