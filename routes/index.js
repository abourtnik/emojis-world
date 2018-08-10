const config = require('../config');

module.exports = (router) => {

    router.route('/') .all(function(req,res){
        res.json({message : "Welcome on Emojis World API ( version " + config.application.version  + ") !!"});
    });
};