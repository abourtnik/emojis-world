const { DataTypes} = require('sequelize');

const sequelize = require('../databases/mysql');

const Category = require('./Category');

const SubCategory = sequelize.define('sub_categories', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true,
        unique: true,
        allowNull: false
    },
    name: {
        type: DataTypes.STRING,
        unique: true,
        allowNull: false
    },
    category_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
        references: {
            model: Category,
            key: "category_id"
        }
    },
    count : {
        type: DataTypes.INTEGER,
        allowNull: false
    }
}, {
    timestamps: false
});

module.exports = SubCategory;