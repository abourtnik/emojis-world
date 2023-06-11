const config = require('./config');
const jwt = require('jsonwebtoken');

const Log = require('./models/Log');
const Ip = require('./models/Ip');

const { Op } = require('sequelize');

const moment = require('moment');

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
                user_agent: req.get('User-Agent').slice(0, 254),
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
    },

    limit : async function (req, res, next) {

        let ip = req.headers['x-real-ip'] || req.ip;

        const count = await Log.findAll({
            where : {
                ip : ip,
                date : {
                    [Op.gte]: moment().subtract(1, config.application.limit.unity),
                    [Op.lte]: moment()
                }
            },
            limit: config.application.limit.value,
            order: [['date', 'DESC']],
            raw: true
        });

        res.set('X-Rate-Limit-Limit', config.application.limit.value);
        res.set('X-Rate-Limit-Remaining', count.length);

        if (count.length >= config.application.limit.value) {
            res.set('X-Rate-Limit-Reset', moment(count[config.application.limit.value - 1].date).add(1, config.application.limit.unity));
            return res.status(429).end();
        }

        else {
            return next();
        }
    },

    ip : async function (req, res, next) {

        let ip = req.headers['x-real-ip'] || req.ip;

        const find = await Ip.findOne({
            where : {
                ip : ip,
                enabled : true
            }
        });

        return (find) ? res.status(403).end() : next()
    },

    filter : async function (req, res, next) {

        // Optional
        let limit = req.query.limit;
        let categories = req.query.categories;
        let sub_categories = req.query.sub_categories;
        let versions = req.query.versions;

        // limit is not int
        if (limit && (isNaN(limit) || limit <= 0 || limit > Number.MAX_SAFE_INTEGER ))
            return res.status(400).json({'error' : 'limit must be an unsigned integer'});

        // categories not valid
        if (categories && !categories.split(',').every(id => !isNaN(id) && id >= 1 && id <= 10 ))
            return res.status(400).json({'error' : 'categories must be list of unsigned integers between 1 and 10'});

        // sub_categories not valid
        if (sub_categories && !sub_categories.split(',').every(id => !isNaN(id) && id >= 1 && id <= 100))
            return res.status(400).json({'error' : 'sub_categories must be list of unsigned integers between 1 and 79'});

        // versions not valid
        const valid_versions = ['0.6', '0.7', '1.0', '2.0', '3.0', '4.0', '5.0', '11.0', '12.0', '12.1', '13.0', '13.1', '14.0', '15.0'];

        if (versions && !versions.split(',').every(version => !isNaN(version) && valid_versions.includes(version)))
            return res.status(400).json({'error' : 'versions must be list of floats in this list : ' + valid_versions.join(', ')});

        if (parseInt(limit) > 50)
            req.query.limit = 50

        return next();
    }
}