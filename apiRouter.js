const express               = require('express');
const usersController       = require('./routes/usersController');
const emojisController      = require('./routes/emojisController');
const logsController      = require('./routes/logsController');

// Router
exports.router = (function () {
    var apiRouter = express.Router();
    
    // All routes

    apiRouter.route('/*').get(function (req, res, next) {
        /*
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
        res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
        res.setHeader('Access-Control-Allow-Credentials', true);
        */
        res.setHeader('Access-Control-Allow-Origin' , '*' );

        next();
    });
    

    // Users routes
    apiRouter.route('/login/').post(usersController.login);
    apiRouter.route('/users/').get(usersController.getAll);

    // Emojis routes
    apiRouter.route('/').get(emojisController.index);
    apiRouter.route('/all').get(emojisController.all);
    apiRouter.route('/search').get(emojisController.search);
    apiRouter.route('/random').get(emojisController.random);
    apiRouter.route('/categories').get(emojisController.categories);
    apiRouter.route('/category/:id').get(emojisController.category);
    apiRouter.route('/sub_category/:id').get(emojisController.subCategory);
    apiRouter.route('/emoji/:id').get(emojisController.emoji);

    // View Logs routes
    apiRouter.route('/logs').get(logsController.get);

    // 404
    apiRouter.route('*').get(function(req, res){
        res.status(404).json({'error' : 'Not found'});
    });

    return apiRouter;
})();