const config = require('../config');
const elasticsearch = require('elasticsearch');
const elasticsearch_client = new elasticsearch.Client({
    host: config.elasticsearch.host + ':' + config.elasticsearch.port
});

module.exports = (router) => {

    router.route('/emoji/:id').get(function(req,res){

        var id = req.params.id;

        // Limit is not int
        if (id && !Number.isInteger(parseInt(id)))
            res.json({'error' : 'Error : id is not valid int'});

        elasticsearch_client.search({
            index: 'emojis-world',
            type: 'emojis',
            filter_path: 'hits.hits._source,hits.total',
            body: {
                size: 1,
                query: {
                    constant_score: {
                        filter: {
                            term: {
                                id : id
                            }
                        }
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

            res.json({'totals' : results.length  , 'results' : results});

        }, function (err) {
            console.trace(err.message);
        });

    });
};

