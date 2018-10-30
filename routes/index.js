const config = require('../config');

module.exports = (router) => {

    router.route('/').get(function(req,res){
        res.json({message : "Welcome on Emojis World API ( version " + config.application.version  + ") !!"});
    });
};