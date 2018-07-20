const config = require('./config');
const express = require('express');

var elasticsearch = require('elasticsearch');

var elasticsearch_client = new elasticsearch.Client({
    host: config.elasticsearch.host + ':' + config.elasticsearch.port
});

var app = express();
var router = express.Router();


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