const config = require('./config');
const express = require('express');
const elasticsearch = require('elasticsearch');
const mongoose = require('mongoose');
const responseTime = require('response-time');

// Elastic Search

var elasticsearch_client = new elasticsearch.Client({
    host: config.elasticsearch.host + ':' + config.elasticsearch.port
});

// Mongo DB

var options_monogdb = {
    keepAlive: 300000,
    connectTimeoutMS: 30000
};

var url_mongodb = config.mongodb.type + '://' + ( (config.mongodb.username) ? (config.mongodb.username + ':' + config.mongodb.password + '@' ) : '' ) + config.mongodb.host + ':' + config.mongodb.port + '/' + config.mongodb.database;
console.log(url_mongodb);

mongoose.connect(url_mongodb, options_monogdb);

var monogdb = mongoose.connection;
monogdb.on('error', console.error.bind(console, 'Erreur lors de la connexion a Mongodb'));
monogdb.once('open', function (){console.log("Connexion a Mongodb OK");});

var app = express();
app.use(responseTime(function(req, res, time) {
    res.header('X-Response-Time', time);
}));
var router = express.Router();


var conectionSchema = mongoose.Schema({
    ip: String,
    date: Date,
    request: String,
    duration: Number
});

var Connection = mongoose.model('Connection', conectionSchema);


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
            if(err){
                console.error(err);
            }
            console.log('Save');
        })
    }
}



app.use(function (req, res, next) {
    // Website you wish to allow to connect
    res.setHeader('Access-Control-Allow-Origin', 'http://emojis.local');

    // Request methods you wish to allow
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');

    // Request headers you wish to allow
    res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');

    // Set to true if you need the website to include cookies in the requests sent
    // to the API (e.g. in case you use sessions)
    res.setHeader('Access-Control-Allow-Credentials', true);

    // Pass to next layer of middleware
    next();
});

app.use(store_user_data);


// ------------------ ENDPOINTS -------------------------------

// SEARCH
router.route('/search').get(function(req,res) {

    var limit = req.query.limit;
    var query = req.query.q;
    
    if (!query)
        res.json("Error : query is not defined");

    if (limit)
        if (!Number.isInteger(limit))
            res.json({'error' : 'Error : limit is not valid int'});

    elasticsearch_client.search({
        index: 'emojis-world',
        type: 'emojis',
        filter_path: 'hits.hits._source,hits.total',
        body: {
            size: ( (limit && limit <= 49 ) ? req.query.limit : 50 ),
            query: {
                multi_match: {
                    query : query,
                    fields: ['name' , 'category.name' , 'sub_category.name'],
                    fuzziness: "AUTO",
                }
            }
        }
    }).then(function (resp) {

        var results = [];

        if (resp.hits.hits)  {
            resp.hits.hits.forEach(function(element) {
                results.push(element._source);
            });
        }

        res.json({'totals' : resp.hits.total  , 'results' : results});

    }, function (err) {
        console.trace(err.message);
    });

});

// TRENDING (tendance)
router.route('/trending')

    .get(function(req,res){


    });

// RANDOM
router.route('/random')

    .get(function(req,res){


    });

// ALL CATEGORIES AND SUB_CATEGORIES
router.route('/categories')

    .get(function(req,res){
        //res.json({message : "Liste toutes les emojis", methode : req.method});


    });

// SEARCH SUGGESTION
router.route('/search_suggestion')

    .get(function(req,res){
        //res.json({message : "Liste toutes les emojis", methode : req.method});


    });

// GET GIF BY ID
router.route('/gif')

    .get(function(req,res){
        //res.json({message : "Liste toutes les emojis", methode : req.method});

    });

router.route('/')

    .all(function(req,res){
        res.json({message : "Bienvenue sur l'API Emoji ", methode : req.method});
    });

app.use(router);

app.listen(config.server.port, config.server.host, function(){
    console.log("Mon serveur fonctionne sur http://"+ config.server.host +":"+config.server.port);
});