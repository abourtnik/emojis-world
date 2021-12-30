const config = require('../config');

const { Sequelize } = require('sequelize');

const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');

const User = require('../models/User');
const Log = require('../models/Log');

// Routes

module.exports = {

    login: async function (req, res) {

        // Params
        let username = req.body.username;
        let password = req.body.password;

        if (username == null || password == null)
            return res.status(400).json({'error' : 'Missing parameters'});

        try {

            const user = await User.findOne({
                where: {
                    username: username
                },
                raw: true
            });

            if (user) {

                const check = await bcrypt.compare(password, user.password);

                if (check) {

                    const token = jwt.sign({
                        id: user.id
                    }, config.jwt.secret, {expiresIn: '356d', algorithm: "HS256"});

                    return res.status(200).json({'id': user.id, 'token': token});
                } else {
                    return res.status(401).json({'error': 'Invalid username or password'});
                }
            } else {
                return res.status(401).json({'error': 'Invalid username or password'});
            }
        }
        catch (e) {
            console.error(e.message)
            return res.status(500).json({'error' : 'Internal server error'});
        }
    },

    admin: async function (req, res) {

        try {
            const methods = await Log.findAll({
                group: ['method'],
                attributes: [
                    'method',
                    [Sequelize.fn('COUNT', 'method'), 'count'],
                    [Sequelize.literal('(COUNT(*) / (SELECT COUNT(*) FROM logs) * 100)'), 'percentage'],
                ],
                order: [[Sequelize.literal('count'), 'DESC']],
            });

            const urls = await Log.findAll({
                group: ['url'],
                attributes: ['url', [Sequelize.fn('COUNT', 'url'), 'count']],
                having : Sequelize.literal('count >= 10'),
                order: [[Sequelize.literal('count'), 'DESC']],
                limit: 15
            });

            const response_status = await Log.findAll({
                group: ['response_status'],
                attributes: [
                    'response_status',
                    [Sequelize.fn('COUNT', 'response_status'), 'count'],
                    [Sequelize.literal('(COUNT(*) / (SELECT COUNT(*) FROM logs) * 100)'), 'percentage'],
                ],
                order: [[Sequelize.literal('count'), 'DESC']],
            });

            const response_time = await Log.findAll({
                attributes: [[Sequelize.fn('AVG', Sequelize.col('response_time')), 'avg']],
                plain: true,
                raw: true
            });

            const longest_response_time = await Log.findAll({
                order: [[Sequelize.literal('response_time'), 'DESC']],
                limit: 20
            });

            const most_count_days = await Log.findAll({
                attributes: [[Sequelize.literal('DATE_FORMAT(ANY_VALUE(date), \'%d-%m-%Y\')'), 'date'] , [Sequelize.fn('COUNT', 'date'), 'count']],
                group: [Sequelize.literal('DATE_FORMAT(date, \'%d-%m-%Y\')')],
                order: [[Sequelize.literal('count'), 'DESC']],
                limit: 15
            });

            const most_count_ip = await Log.findAll({
                group: ['ip'],
                attributes: ['ip', [Sequelize.fn('COUNT', 'ip'), 'count']],
                order: [[Sequelize.literal('count'), 'DESC']],
                limit: 15
            });

            return res.status(200).json({
                'methods' : methods,
                'populars_urls' : urls,
                'response_status' : response_status,
                'response_time' : {
                    'avg' : response_time.avg,
                    'longest_response_time' : longest_response_time,
                },
                'most_count_days' : most_count_days,
                'most_count_ip' : most_count_ip,
            });
        }
        catch (e) {
            console.error(e.message)
            return res.status(500).json({'error' : 'Internal server error'});
        }
    }
};