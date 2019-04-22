const config = require('../config');
const jwt = require('jsonwebtoken');

module.exports = {

    generateToken: function (user) {
        return jwt.sign({
            payload: {
                id : user.id,
                admin : user.admin
            }
        }, config.jwt.secret, {
            expiresIn: '1h',
            algorithm: "HS256"
        })
    },

    parseAuthorization: function (authorization) {
        return (authorization != null) ? authorization.replace('Bearer ' , '') : null;
    },
    getUserId: function (authorization) {
        var user_id = - 1;
        var token = module.exports.parseAuthorization(authorization);

        if (token != null) {
            try {
                var jwtToken = jwt.verify(token , config.jwt.secret);

                if (jwtToken != null)
                    user_id = jwtToken.userId;
            } catch (error) {
                
            }
        }

        return user_id;
    }
};