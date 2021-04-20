const { DataTypes} = require('sequelize');

const sequelize = require('../databases/mysql');

module.exports = sequelize.define('logs', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true,
        unique: true,
        allowNull: false
    },
    method: {
        type: DataTypes.STRING,
        allowNull: false
    },
    url : {
        type: DataTypes.STRING,
        allowNull: false
    },
    response_status : {
        type: DataTypes.INTEGER,
        allowNull: false
    },
    response_time : {
        type: DataTypes.INTEGER,
        allowNull: false
    },
    date : {
        type: DataTypes.DATE,
        defaultValue: Date.now(),
        allowNull: false
    },
    ip : {
        type: DataTypes.STRING,
        allowNull: false
    },
    user_agent : {
        type: DataTypes.STRING,
        allowNull: false
    }
}, {
    timestamps: false
});
