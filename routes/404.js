module.exports = (router) => {

    router.route('*').get(function(req, res){
        res.json({'error' : 'No result'});
    });
};