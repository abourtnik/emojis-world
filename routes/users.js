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
                attributes: ['method', [Sequelize.fn('COUNT', 'method'), 'count']],
            });

            const urls = await Log.findAll({
                group: ['url'],
                attributes: ['url', [Sequelize.fn('COUNT', 'url'), 'count']],
                having : Sequelize.literal('count >= 10'),
                order: [[Sequelize.literal('count'), 'DESC']]
            });

            const days = await Log.findAll({
                attributes: [[Sequelize.literal('DATE_FORMAT(ANY_VALUE(date), \'%d-%m-%Y\')'), 'date'] , [Sequelize.fn('COUNT', 'date'), 'count']],
                group: [Sequelize.literal('DATE_FORMAT(date, \'%d-%m-%Y\')')],
            });

            return res.status(200).json({
                'methods' : methods,
                'popular_url' : urls,
                'days' : days
            });
        }
        catch (e) {
            console.error(e.message)
            return res.status(500).json({'error' : 'Internal server error'});
        }
    }
};