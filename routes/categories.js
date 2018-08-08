const config = require('../config');
const elasticsearch = require('elasticsearch');
const elasticsearch_client = new elasticsearch.Client({
    host: config.elasticsearch.host + ':' + config.elasticsearch.port
});

module.exports = (router) => {

    /*
    {
 	"size": 0,
	 "aggs" : {
		   "category" : {
		       "terms" : {
		           "field" : "category.name.keyword"
		       },
		       "aggs": {
            		"top-categories_hits": {
	                    "top_hits": {
	                    	"sort": [{"id": {"order": "asc"}}],
	                        "size" : 1
	                    }
                	},

                	"sub_category" : {
		    			"terms" : {
		        			"field" : "sub_category.name.keyword"
		    			},
		    			"aggs": {
            				"top-categories_hits": {
                    			"top_hits": {
                    				"sort": [{"id": {"order": "asc"}}],
                        			"size" : 1
                    			}
                			}
		        		}
            		}
		       }
		  }
	}
 }
     */

    router.route('/categories').get(function(req,res){

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
                        sub_categories.push({'name' : sub_category.key , 'emojis_count' : sub_category.doc_count , 'first_emoji' : sub_category.first_sub_category_emoji.hits.hits[0]._source});
                    });

                    results.push({'name' : category.key , 'emojis_count' : category.doc_count , 'first_emoji' : category.first_category_emoji.hits.hits[0]._source , 'sub_categories' : sub_categories });

                });
            };

            res.json({'totals' : results.length  , 'results' : results});

        }, function (err) {
            console.trace(err.message);
        });

    });
};

