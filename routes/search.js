const config = require('../config');
const elasticsearch = require('elasticsearch');
const elasticsearch_client = new elasticsearch.Client({
    host: config.elasticsearch.host + ':' + config.elasticsearch.port
});

module.exports = (router) => {

    router.route('/search').get(function(req,res) {

        var limit = req.query.limit;
        var query = req.query.q;
        var category_id = req.query.category;
        var sub_category_id = req.query.sub_category;

        if (!query)
            res.json({'error' : 'Error : query is not defined'});

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
                    bool : {
                        must : [
                            (!category_id && !sub_category_id) ? '' : ( (category_id) && {term : { "category.id" : category_id }} , (sub_category_id) && {term : { "sub_category.id" : sub_category_id }} ),
                            {
                                multi_match: {
                                    query : query,
                                    fields: ['name^2' , 'category.name' , 'sub_category.name'],
                                }
                            }
                        ]
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