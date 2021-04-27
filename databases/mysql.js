const config = require('../config');

const { Sequelize} = require('sequelize');

module.exports = new Sequelize(config.mysql.database, config.mysql.username, config.mysql.password, {
    host: config.mysql.host,
    dialect: 'mysql',
    logging: config.mysql.log,
    port: config.mysql.port,
    timezone: config.mysql.timezone,
    dialectOptions: config.mysql.options
});