const config = require('../config');

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
        let categories = req.query.categories;
        let sub_categories = req.query.sub_categories;
        let limit = req.query.limit;

        if (!query)
            return res.status(400).json({'error' : 'query is not defined'});

        // Filter by category OR/AND sub_category
        let filters = '';
        let and = (categories) ? ' && ' : '';

        (categories) ? filters = 'category:=[' + categories + ']' : '';
        (sub_categories) ? filters += and + 'sub_category:=[' + sub_categories + ']' : '';

        try {

            let results = await typesense.get('collections/emojis/documents/search', {
                params: {
                    q : query,
                    query_by : 'name,sub_category_name,category_name',
                    query_by_weights : '600,1,1',
                    filter_by : filters,
                    per_page : parseInt(limit) || 50,
                    include_fields : 'id',
                    num_typos: 2,
                    drop_tokens_threshold: 0,
                    typo_tokens_threshold: 1,
                    prefix: true
                }
            });

            let ids = results.data.hits.map(hit => hit.document.id);

            if (ids.length) {
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
                    order: Sequelize.literal('FIELD(emojis.id,' + ids.join(',') + ')')
                });

                // Increment count

                await Emoji.increment('count', {
                    where: {
                        id : {
                            [Op.in]: ids,
                        }
                    }
                });

                return res.status(200).json({
                    totals : emojis.length,
                    results : emojis
                });
            }

            else {
                return res.status(200).json({
                    totals : 0,
                    results : []
                });
            }
        }

        catch (e) {
            console.error(e.message)
            return res.status(500).json({'error' : 'Internal server error'});
        }
    },

    random: async function (req, res) {

        let categories = req.query.categories;
        let sub_categories = req.query.sub_categories;
        let limit = req.query.limit;

        // Filter by category OR/AND sub_category
        let filters = {};

        if (categories) {
            filters.category_id = {
                [Op.in]: categories.split(',')
            }
        }

        if (sub_categories) {
            filters.sub_category_id = {
                [Op.in]: sub_categories.split(',').map(id => parseInt(id))
            }
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

        // id is not int
        if (id && !Number.isInteger(parseInt(id)))
            return res.status(400).json({'error' : 'id is not a valid integer'});

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

            if (emoji) {

                await Emoji.increment('count', {
                    where: {
                        id: emoji.id
                    }
                });

                return res.status(200).json(emoji);
            }
            else {
                return res.status(404).json({'error' : 'Emoji id not found'});
            }
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
    },

    popular: async function (req, res) {

        let categories = req.query.categories;
        let sub_categories = req.query.sub_categories;
        let limit = req.query.limit;

        // Filter by category OR/AND sub_category
        let filters = {};

        if (categories) {
            filters.category_id = {
                [Op.in]: categories.split(',')
            }
        }

        if (sub_categories) {
            filters.sub_category_id = {
                [Op.in]: sub_categories.split(',').map(id => parseInt(id))
            }
        }

        try {
            let emojis = await Emoji.findAll({
                attributes: ['id', 'name', 'emoji', 'unicode', 'count'],
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
                order: [['count', 'desc']]
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
    }
};