const config = require('./config');
const jwt = require('jsonwebtoken');
const Log = require('./models/Log');

module.exports = {
    log : async function (req, res, next) {

        let start = new Date;

        res.on('finish', async function() {

            let duration = new Date - start;

            await Log.create({
                method: req.method,
                url: req.url,
                response_status: res.statusCode,
                response_time: duration,
                ip: req.headers['x-real-ip'] || req.ip,
                user_agent: req.get('User-Agent'),
            });
        });

        return next()
    },

    auth : async function (req, res, next) {

        let token = req.headers['authorization'];

        if (token) {

            try {
                await jwt.verify(token.replace('Bearer ', '') , config.jwt.secret);
            } catch(e) {
                console.log(e.message);
                return res.status(401).json({ error: 'Unauthorized' });
            }

            return next();
        }

        else {
            return res.status(401).json({ error: 'Token not provided' })
        }
    }
}