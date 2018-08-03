const config = require('../config');
const elasticsearch = require('elasticsearch');
const elasticsearch_client = new elasticsearch.Client({
    host: config.elasticsearch.host + ':' + config.elasticsearch.port
});

module.exports = (router) => {

    router.route('/random').get(function(req,res){

        var limit = req.query.limit;
        var category_id = req.query.category;
        var sub_category_id = req.query.sub_category;

        // Limit is not int
        if (limit && !Number.isInteger(parseInt(limit)))
            res.json({'error' : 'Error : limit is not valid int'});

        if (category_id && !Number.isInteger(parseInt(category_id)) )
            res.json({'error' : 'Error : category is not valid int'});

        if (sub_category_id && !Number.isInteger(parseInt(sub_category_id)) )
            res.json({'error' : 'Error : sub_category is not valid int'});

        elasticsearch_client.search({
            index: 'emojis-world',
            type: 'emojis',
            filter_path: 'hits.hits._source,hits.total',
            body: {
                size: ( (limit && parseInt(limit) <= 50 ) ? parseInt(req.query.limit) : 50 ),
                query: {
                    function_score: {
                        functions : [{
                            random_score : {
                                seed: + new Date()
                            }
                        }]

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

            res.json({'totals' : results.length , 'results' : results});

        }, function (err) {
            console.trace(err.message);
        });

    });
};
