module.exports = (router) => {

    router.route('/') .all(function(req,res){
        res.json({message : "Welcome on Emojis World API !!"});
    });
};