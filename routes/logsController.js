const jwtUtils = require('../utils/jwt.utils');
const user = require('../models/user');
const path = require('path');

// Routes

module.exports = {

    get: function (req, res) {

        let headerAuth = req.headers['authorization'];
        let user_id = jwtUtils.getUserId(headerAuth);

        if (user_id < 0)
            return res.status(400).json({'error' : 'invalid token'});
        else {
            user.find({}, function(error, users) {
                if (error)
                    return res.status(500).json({'error' : error});
                else
                    return res.status(200).sendFile(path.resolve('connections.log'));
            });
        }
    }

};