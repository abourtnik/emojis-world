const config  = require('../config');

const { Sequelize } = require('sequelize');

const Emoji = require('../models/Emoji');
const Category = require('../models/Category');
const SubCategory = require('../models/SubCategory');

const { Op } = require("sequelize");

const typesense = require('../databases/typesense');

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
        let categories = req.query.categories;
        let sub_categories = req.query.sub_categories;

        if (!query)
            return res.status(400).json({'error' : 'query is not defined'});

        // limit is not int
        if (limit && !Number.isInteger(parseInt(limit)))
            return res.status(400).json({'error' : 'limit must be a valid integer'});

        // categories not valid
        if (categories && !categories.split(',').every(id => Number.isInteger(parseInt(id))))
            return res.status(400).json({'error' : 'categories is not valid'});

        // sub_categories not valid
        if (sub_categories && !sub_categories.split(',').every(id => Number.isInteger(parseInt(id))))
            return res.status(400).json({'error' : 'sub_categories is not valid'});

        // Filter by category OR/AND sub_category
        let filters = null;
        let and = (categories) ? ' &&' : null;

        (categories) ? filters = 'category:=[' + categories + ']' : null;
        (sub_categories) ? filters += and + 'sub_category:=[' + sub_categories + ']' : null;

        try {

            let results = await typesense.get('collections/emojis/documents/search', {
                params: {
                    q : query,
                    query_by : 'name',
                    filter_by : filters,
                    par_page : parseInt(limit) || 50,
                    include_fields : 'id',
                    num_typos: 2,
                    drop_tokens_threshold: 0,
                }
            });

            let ids = results.data.hits.map(hit => hit.document.id);

            let emojis = await Emoji.findAll({
                attributes: ['id', 'name', 'emoji', 'unicode'],
                where : {
                    id : {
                        [Op.in]: ids,
                    },
                    parent_id : null
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
            return res.status(500).json({'error' : 'Internal server error'});
        }
    },

    random: async function (req, res) {

        let limit = req.query.limit;
        let categories = req.query.categories;
        let sub_categories = req.query.sub_categories;

        // Limit is not int
        if (limit && !Number.isInteger(parseInt(limit)))
            return res.status(400).json({'error' : 'Limit is not valid int'});

        // categories not valid
        if (categories && !categories.split(',').every(id => Number.isInteger(parseInt(id))))
            return res.status(400).json({'error' : 'categories is not valid'});

        // sub_categories not valid
        if (sub_categories && !sub_categories.split(',').every(id => Number.isInteger(parseInt(id))))
            return res.status(400).json({'error' : 'sub_categories is not valid'});

        // Filter by category OR sub_category
        let filters = [];

        if (categories) {
            filters.push({
                category_id : {
                    [Op.in]: categories.split(',').map(id => parseInt(id))
                }
            })
        }

        if (sub_categories) {
            filters.push({
                sub_category_id : {
                    [Op.in]: sub_categories.split(',').map(id => parseInt(id))
                }
            })
        }

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
            return res.status(500).json({'error' : 'Internal server error'});
        }
    },

    emojis: async function (req, res) {

        let id = req.params.id;

        // Limit is not int
        if (id && !Number.isInteger(parseInt(id)))
            return res.status(400).json({'error' : 'id is not a valid int'});

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
            return res.status(500).json({'error' : 'Internal server error'});
        }
    },

    categories: async function (req, res) {

        try {
            let categories = await Category.findAll({
                attributes: ['id', 'name', ['count' , 'emojis_count']],
                include: [
                    {
                        model: SubCategory,
                        attributes:['id', 'name', ['count' , 'emojis_count']]
                    }
                ]
            });

            return res.status(200).json({
                totals : categories.length,
                results : categories
            });
        }

        catch (e) {
            console.error(e.message)
            return res.status(500).json({'error' : 'Internal server error'});
        }
    }
};