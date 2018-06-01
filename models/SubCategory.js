const config = require('../config');
const Sequelize = require('sequelize');

const sequelize = new Sequelize(config.database.name, config.database.username, config.database.password, {
    dialect: config.database.type,
    port: config.database.port,
    dialectOptions: {
        socketPath: config.database.socket
    }
});

module.exports = sequelize.define('sub_categories',

    {
        name: Sequelize.STRING,

    } ,

    {
        timestamps: false
    }

);