const config        = require('./config');
const express       = require('express');
const bodyParser    = require('body-parser');
const elasticsearch = require('elasticsearch');
const mongoose      = require('mongoose');
const favicon       = require('serve-favicon');
const path          = require('path');
const apiRouter     = require('./apiRouter').router;
const morgan        = require('morgan');
const fs            = require('fs');

// Inititate server
var app = express();

// Morgan Log Configuration
var connectionLogStream = fs.createWriteStream(path.join(__dirname, 'connections.log'), { flags: 'a' });
app.use(morgan(':method :url :status :response-time ms :date :remote-addr :user-agent' , { stream: connectionLogStream }));

// Body Parser configuration
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));

// Elastic Search configuration
var elasticsearch_client = new elasticsearch.Client({
    host: config.elasticsearch.host + ':' + config.elasticsearch.port
});

elasticsearch_client.ping({requestTimeout: 1000}, function (error) {
    if (error) console.error('Failed to connect to ElasticSearch !');
    else console.info('Connect to ElasticSearch successfully');
});

// MongoDB configuration
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

// Favicon
app.use(favicon(path.join(__dirname, 'favicon.ico')));

// Router
app.use('/v' + config.application.version + '/' , apiRouter);

// Launch server
app.listen(config.server.port, config.server.host, function(){
    console.info("Server listen on http://"+ config.server.host +":"+config.server.port);
});