const bcrypt = require('bcrypt');
const jwtUtils = require('../utils/jwt.utils');
const user = require('../models/user');

// Routes

module.exports = {

    login:function (req, res) {

        // Params
        let email = req.body.email;
        let password = req.body.password;

        if (email == null || password == null)
            return res.status(400).json({'error' : 'missing parameters'});

        user.findOne( {email: email}, function (error, user) {
            if (error) {
                return res.status(500).json({'error' : error});
            }
            else {
                if (!user)
                    return res.status(404).json({'error' : 'user not found'});
                else
                    bcrypt.compare(password, user.password, function (error, result) {
                        if (result)
                            return res.status(200).json({'id' : user.id , 'token' : jwtUtils.generateToken(user)});
                        else
                            return res.status(401).json({'error' : 'invalid password'})

                    });
            }
        })
    },

    getAll: function (req, res) {

        let headerAuth = req.headers['authorization'];
        let user_id = jwtUtils.getUserId(headerAuth);

        if (user_id < 0)
            return res.status(400).json({'error' : 'invalid token'});
        else {
            user.find({}, function(error, users) {
                if (error)
                    return res.status(500).json({'error' : error});
                else
                    return res.status(200).json(users);
            });
        }
    }

};