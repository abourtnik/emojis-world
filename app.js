const config = require('./config');
const express = require('express');
const Sequelize = require('sequelize');
const Op = Sequelize.Op;


const sequelize = new Sequelize(config.database.name, config.database.username, config.database.password, {
    dialect: config.database.type,
    port: config.database.port,
    dialectOptions: {
        socketPath: config.database.socket
    }
});


sequelize.authenticate()
    .then(() => {
        console.log('Connection has been established successfully.');
    })
    .catch(err => {
        console.error('Unable to connect to the database:', err);
    });


// Models

const Emojis = require('./models/Emojis');
const Category = require('./models/Category');
const SubCategory = require('./models/SubCategory');

// Associations
Emojis.belongsTo(Category , {as : 'categories' , foreignKey:'category_id'});
Emojis.belongsTo(SubCategory , {as : 'sub_categories' , foreignKey:'sub_category_id'});

Category.hasMany(SubCategory , {as : 'sub_categories' , foreignKey:'sub_category_id'});
SubCategory.belongsTo(Category , {as : 'categories' , foreignKey:'category_id'});

var app = express();
var router = express.Router();

// ------------------ ENDPOINTS -------------------------------

// SEARCH
router.route('/search')

    .get(function(req,res){

        Emojis.findAll({

            attributes: ['id', 'name' , 'emoji' , 'unicode'],

            where: {
                name: {
                    [Op.like]: '%' + ( (req.query.q) ? req.query.q : '' ) + '%'
                },

                category_id: req.query.category,
                sub_category_id : req.query.sub_category_id
            },

            include: [
                {
                    model: Category,
                    as : 'categories'
                },

                {
                    model: SubCategory,
                    as : 'sub_categories'
                }
            ],

            order: [
                ['score', 'DESC']
            ],

            limit: (req.query.limit) ? parseInt(req.query.limit) : 50

        }).then(emojis => {
            res.json({emojis : emojis});
        })
    });

// TRENDING (tendance)
router.route('/trending')

    .get(function(req,res){

        Emojis.findAll({

            include: [
                {
                    model: Category,
                    as : 'categories'
                },

                {
                    model: SubCategory,
                    as : 'sub_categories'
                }
            ],

            order: [
                ['score', 'DESC']
            ],

            limit: (req.query.limit) ? parseInt(req.query.limit) : 50

        }).then(emojis => {
            res.json({emojis : emojis});
        })
    });

// RANDOM
router.route('/random')

    .get(function(req,res){

        Emojis.findAll({

            include: [
                {
                    model: Category,
                    as : 'categories'
                },

                {
                    model: SubCategory,
                    as : 'sub_categories'
                }
            ],

            order: [
                ['score', 'DESC']
            ],

            limit: (req.query.limit) ? parseInt(req.query.limit) : 50

        }).then(emojis => {
            res.json({emojis : emojis});
        })
    });

// ALL CATEGORIES AND SUB_CATEGORIES
router.route('/categories')

    .get(function(req,res){
        //res.json({message : "Liste toutes les emojis", methode : req.method});

        Category.findAll({

            include: [
                {
                    model: SubCategory,
                    as : 'sub_categories'
                },
            ],

        }).then(users => {
            res.json({emojis : users});
        })
    });

// SEARCH SUGGESTION
router.route('/search_suggestion')

    .get(function(req,res){
        //res.json({message : "Liste toutes les emojis", methode : req.method});

        Emojis.findAll().then(users => {
            res.json({emojis : users});
        })
    });

// GET GIF BY ID
router.route('/gif')

    .get(function(req,res){
        //res.json({message : "Liste toutes les emojis", methode : req.method});

        Emojis.findAll().then(users => {
            res.json({emojis : users});
        })
    });

app.use(router);

app.listen(config.server.port, config.server.host, function(){
    console.log("Mon serveur fonctionne sur http://"+ config.server.host +":"+config.server.port);
});