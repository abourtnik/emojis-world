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
        let user_id = - 1;
        let token = module.exports.parseAuthorization(authorization);

        if (token != null) {
            try {
                let jwtToken = jwt.verify(token , config.jwt.secret);

                if (jwtToken != null)
                    user_id = jwtToken.userId;
            } catch (error) {
                
            }
        }

        return user_id;
    }
};