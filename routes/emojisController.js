const config  = require('../config');
const elasticsearch = require('elasticsearch');
const elasticsearch_client = new elasticsearch.Client({
    host: config.elasticsearch.host + ':' + config.elasticsearch.port
});

// Routes

module.exports = {

    index:function (req, res) {
        return res.status(200).json({message : "Welcome on Emojis World API (version " + config.application.version  + ") !!"});
    },

    all:function (req, res) {

        elasticsearch_client.search({
            index: 'emojis-world',
            type: 'emojis',
            filter_path: 'hits.hits._source,hits.total',
            body: {
                query: {
                    match_all : {

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

            return res.status(200).json({'totals' : results.length  , 'results' : results});

        }, function (error) {
            return res.status(500).json({'error' : error.message});
        });
    },

    search:function (req, res) {

        var limit = req.query.limit;
        var query = req.query.q;
        var category_id = req.query.category;
        var sub_category_id = req.query.sub_category;

        if (!query)
            return res.status(400).json({'error' : 'Query is not defined'});

        // Limit is not int
        if (limit && !Number.isInteger(parseInt(limit)))
            return res.status(400).json({'error' : 'Limit is not valid int'});

        if (category_id && !Number.isInteger(parseInt(category_id)) )
            return res.status(400).json({'error' : 'Category is not valid int'});

        if (sub_category_id && !Number.isInteger(parseInt(sub_category_id)) )
            return res.status(400).json({'error' : 'Sub_category is not valid int'});


        // Filter by Categorie OR sub categories
        filters = [];
        (category_id) ? filters.push({ "term":  { "category.id": category_id }}) : null;
        (sub_category_id) ? filters.push({ "term":  { "sub_category.id": sub_category_id }}) : null;

        elasticsearch_client.search({
            index: 'emojis-world',
            type: 'emojis',
            filter_path: 'hits.hits._source,hits.total',
            body: {
                size: ( (limit && parseInt(limit) <= 50 ) ? parseInt(req.query.limit) : 50 ),
                query: {
                    bool : {
                        must : [
                            {
                                multi_match: {
                                    query : query,
                                    fields: ['name^2' , 'category.name' , 'sub_category.name'],
                                }
                            }
                        ],
                        filter: filters
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

            return res.status(200).json({'totals' : results.length  , 'results' : results});

        }, function (error) {
            return res.status(500).json({'error' : error.message});
        });
    },

    random:function (req, res) {

        var limit = req.query.limit;
        var category_id = req.query.category;
        var sub_category_id = req.query.sub_category;

        // Limit is not int
        if (limit && !Number.isInteger(parseInt(limit)))
            return res.status(400).json({'error' : 'Limit is not valid int'});

        if (category_id && !Number.isInteger(parseInt(category_id)) )
            return res.status(400).json({'error' : 'Category is not valid int'});

        if (sub_category_id && !Number.isInteger(parseInt(sub_category_id)) )
            return res.status(400).json({'error' : 'Sub_category is not valid int'});

        // Filter by Categorie OR sub categories
        filters = [];
        (category_id) ? filters.push({ "term":  { "category.id": category_id }}) : null;
        (sub_category_id) ? filters.push({ "term":  { "sub_category.id": sub_category_id }}) : null;

        elasticsearch_client.search({
            index: 'emojis-world',
            type: 'emojis',
            filter_path: 'hits.hits._source,hits.total',
            body: {
                size: ( (limit && parseInt(limit) <= 50 ) ? parseInt(req.query.limit) : 50 ),
                query: {
                    bool: {
                        must: [
                            {
                                function_score: {
                                    functions : [{
                                        random_score : {
                                            seed: + new Date()
                                        }
                                    }]
                                }
                            }
                        ],
                        filter: filters
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

            return res.status(200).json({'totals' : results.length , 'results' : results});

        }, function (error) {
            return res.status(500).json({'error' : error.message});
        });

    },

    emoji:function (req, res) {

        var id = req.params.id;

        // Limit is not int
        if (id && !Number.isInteger(parseInt(id)))
            return res.status(400).json({'error' : 'Id is not a valid int'});

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

            return res.status(200).json({'totals' : results.length  , 'results' : results});

        }, function (error) {
            return res.status(500).json({'error' : error.message});
        });

    },

    categories:function (req, res) {

        elasticsearch_client.search({
            index: 'emojis-world',
            type: 'emojis',
            filter_path: 'aggregations.category.buckets',
            body: {
                size: 0,
                aggs : {
                    category : {
                        terms : {
                            field : "category.name.keyword"
                        },
                        aggs : {
                            first_category_emoji: {
                                top_hits: {
                                    sort: [{id: {order: "asc"}}],
                                    size: 1
                                }
                            },

                            sub_category : {
                                terms: {
                                    field: "sub_category.name.keyword"
                                },
                                aggs: {
                                    first_sub_category_emoji: {
                                        top_hits: {
                                            sort: [{id: {order: "asc"}}],
                                            size: 1
                                        }
                                    },
                                }
                            }
                        }
                    }
                }
            }
        }).then(function (resp) {

            var results = [];

            if (resp.aggregations.category.buckets)  {
                resp.aggregations.category.buckets.forEach(function(category) {

                    var sub_categories = [];

                    category.sub_category.buckets.forEach(function (sub_category) {
                        sub_categories.push({ 'id' : sub_category.first_sub_category_emoji.hits.hits[0]._source.sub_category.id , 'name' : sub_category.key , 'emojis_count' : sub_category.doc_count , 'first_emoji' : sub_category.first_sub_category_emoji.hits.hits[0]._source});
                    });

                    // Order by ID
                    sub_categories.sort(function(a,b) {return (a.id > b.id) ? 1 : ((b.id > a.id) ? -1 : 0);} );

                    results.push({ id : category.first_category_emoji.hits.hits[0]._source.category.id , 'name' : category.key , 'emojis_count' : category.doc_count , 'first_emoji' : category.first_category_emoji.hits.hits[0]._source , 'sub_categories' : sub_categories });

                });
            };

            // Order by ID
            results.sort(function(a,b) {return (a.id > b.id) ? 1 : ((b.id > a.id) ? -1 : 0);} );

            return res.status(200).json({'totals' : results.length  , 'results' : results});

        }, function (error) {
            return res.status(500).json({'error' : error.message});
        });

    },

    category:function (req, res) {

        var id = req.params.id;
        var limit = req.query.limit;

        // ID is not int
        if (id && !Number.isInteger(parseInt(id)))
            return res.status(400).json({'error' : 'Id is not a valid int'});

        // Limit is not int
        if (limit && !Number.isInteger(parseInt(limit)))
            return res.status(400).json({'error' : 'Limit is not valid int'});

        elasticsearch_client.search({
            index: 'emojis-world',
            type: 'emojis',
            filter_path: 'hits.hits._source,hits.total',
            body: {
                size : (limit) ? parseInt(req.query.limit) : 6000,
                query: {
                    term : { "category.id" : id }
                },
                sort : [
                    {id : {order : "asc"}}
                ]
            }
        }).then(function (resp) {

            var results = [];

            if (resp.hits.hits)  {
                resp.hits.hits.forEach(function(element) {
                    results.push(element._source);
                });
            }

            return res.status(200).json({'totals' : results.length  , 'results' : results});

        }, function (error) {
            return res.status(500).json({'error' : error.message});
        });

    },

    subCategory:function (req, res) {

        var id = req.params.id;
        var limit = req.query.limit;

        // Limit is not int
        if (id && !Number.isInteger(parseInt(id)))
            res.status(400).json({'error' : 'Id is not valid int'});

        // Limit is not int
        if (limit && !Number.isInteger(parseInt(limit)))
            res.status(400).json({'error' : 'Limit is not valid int'});

        elasticsearch_client.search({
            index: 'emojis-world',
            type: 'emojis',
            filter_path: 'hits.hits._source,hits.total',
            body: {
                size : (limit) ? parseInt(req.query.limit) : 6000,
                query: {
                    term : { "sub_category.id" : id }
                },
                sort : [
                    {id : {order : "asc"}}
                ]
            }
        }).then(function (resp) {

            var results = [];

            if (resp.hits.hits)  {
                resp.hits.hits.forEach(function(element) {
                    results.push(element._source);
                });
            }

            res.status(200).json({'totals' : results.length  , 'results' : results});

        }, function (error) {
            return res.status(500).json({'error' : error.message});
        });

    }
};