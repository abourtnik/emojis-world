module.exports = (router) => {

    router.route('*').get(function(req, res){
        res.status(404).json({'error' : 'Not found'});
    });
};