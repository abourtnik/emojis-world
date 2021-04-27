const { DataTypes} = require('sequelize');

const sequelize = require('../databases/mysql');

const SubCategory = require('./SubCategory');

const Category = sequelize.define('categories', {
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
    count : {
        type: DataTypes.INTEGER,
        allowNull: false
    }
}, {
    timestamps: false
});

Category.hasMany(SubCategory, { foreignKey: 'category_id' });

module.exports = Category;