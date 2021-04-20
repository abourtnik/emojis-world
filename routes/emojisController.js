const config  = require('../config');

const { Sequelize } = require('sequelize');

const Emoji = require('../models/Emoji');
const Category = require('../models/Category');
const SubCategory = require('../models/SubCategory');

const { Op } = require("sequelize");

// Routes

module.exports = {

    index:function (req, res) {
        return res.status(200).json({message : "Welcome on Emojis World API (version " + config.application.version  + ") !!"});
    },

    search: async function (req, res) {

        // Required
        let query = req.query.q;

        // Optional
        let limit = req.query.limit;
        let category_id = req.query.category;
        let sub_category_id = req.query.sub_category;

        if (!query)
            return res.status(400).json({'error' : 'query is not defined'});

        // limit is not int
        if (limit && !Number.isInteger(parseInt(limit)))
            return res.status(400).json({'error' : 'limit must be a valid integer'});

        // category_id is not int
        if (category_id && !Number.isInteger(parseInt(category_id)) )
            return res.status(400).json({'error' : 'category must be a valid integer'});

        // sub_category_id is not int
        if (sub_category_id && !Number.isInteger(parseInt(sub_category_id)) )
            return res.status(400).json({'error' : 'sub_category must be a valid integer'});

        try {
            let emojis = await Emoji.findAll({
                attributes: ['id', 'name', 'emoji', 'unicode'],
                where : {
                    name : {
                        [Op.like]: '%' + query + '%',
                    },
                    parent_id : null
                },
                limit : parseInt(limit) || 50,
                include: [
                    {
                        model: Category,
                        attributes:['id', 'name']
                    },
                    {
                        model: SubCategory,
                        attributes:['id', 'name']
                    },
                    {
                        model: Emoji,
                        as: 'children',
                        attributes:['id', 'name', 'emoji', 'unicode']
                    }
                ],
            });

            return res.status(200).json({
                totals : emojis.length,
                results : emojis
            })
        }

        catch (e) {
            console.error(e.message)
            return res.status(500).json({'error' : 'internal server error'});
        }

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

            let results = [];

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

    random: async function (req, res) {

        let limit = req.query.limit;
        let category_id = req.query.category;
        let sub_category_id = req.query.sub_category;

        // Limit is not int
        if (limit && !Number.isInteger(parseInt(limit)))
            return res.status(400).json({'error' : 'Limit is not valid int'});

        if (category_id && !Number.isInteger(parseInt(category_id)) )
            return res.status(400).json({'error' : 'Category is not valid int'});

        if (sub_category_id && !Number.isInteger(parseInt(sub_category_id)) )
            return res.status(400).json({'error' : 'Sub_category is not valid int'});

        // Filter by category OR sub_category
        let filters = {};
        (category_id) ? filters.category_id = category_id : null;
        (sub_category_id) ? filters.sub_category_id = sub_category_id : null;

        try {
            let emojis = await Emoji.findAll({
                attributes: ['id', 'name', 'emoji', 'unicode'],
                where : { parent_id : null, ...filters},
                limit : parseInt(limit) || 50,
                include: [
                    {
                        model: Category,
                        attributes:['id', 'name']
                    },
                    {
                        model: SubCategory,
                        attributes:['id', 'name']
                    },
                    {
                        model: Emoji,
                        as: 'children',
                        attributes:['id', 'name', 'emoji', 'unicode']
                    }
                ],
                order: Sequelize.literal('rand()')
            });

            return res.status(200).json({
                totals : emojis.length,
                results : emojis
            });
        }

        catch (e) {
            console.error(e.message)
            return res.status(500).json({'error' : 'internal server error'});
        }
    },

    emojis: async function (req, res) {

        let id = req.params.id;

        // Limit is not int
        if (id && !Number.isInteger(parseInt(id)))
            return res.status(400).json({'error' : 'Id is not a valid int'});

        try {
            let emoji = await Emoji.findOne({
                attributes: ['id', 'name', 'emoji', 'unicode'],
                where : {
                    id : parseInt(id)
                },
                include: [
                    {
                        model: Category,
                        attributes:['id', 'name']
                    },
                    {
                        model: SubCategory,
                        attributes:['id', 'name']
                    },
                    {
                        model: Emoji,
                        as: 'children',
                        attributes:['id', 'name', 'emoji', 'unicode']
                    },
                    {
                        model: Emoji,
                        as: 'parent',
                        attributes:['id', 'name', 'emoji', 'unicode']
                    }
                ]
            });

            // Add parent

            return res.status(200).json(emoji);
        }

        catch (e) {
            console.error(e.message)
            return res.status(500).json({'error' : 'internal server error'});
        }
    },

    categories: async function (req, res) {

        try {
            let categories = await Category.findAll({
                attributes: ['id', 'name'],
                include: [
                    {
                        model: Emoji,
                        attributes:['id'],
                    },
                    {
                        model: SubCategory,
                        attributes:['id', 'name'],
                        include: [
                            {
                                model: Emoji,
                                attributes:['id'],
                            }
                        ]
                    }
                ]
            });

            return res.status(200).json({
                totals : categories.length,
                results : categories.map(category => ({
                    id : category.id,
                    name : category.name,
                    emojis_count : category.emojis.length,
                    sub_categories : category.sub_categories.map(sub_category => ({
                        id : sub_category.id,
                        name : sub_category.name,
                        emojis_count : sub_category.emojis.length,
                    }))
                }))
            });
        }

        catch (e) {
            console.error(e.message)
            return res.status(500).json({'error' : 'internal server error'});
        }
    }
};