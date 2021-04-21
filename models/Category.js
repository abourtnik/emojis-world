const { DataTypes} = require('sequelize');

const sequelize = require('../databases/mysql');

const Emoji = require('./Emoji');
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
    },
    created_at : {
        type: DataTypes.DATE,
        allowNull: false,
        defaultValue: Date.now()
    }
}, {
    timestamps: false
});

Category.hasMany(SubCategory, { foreignKey: 'category_id' });

module.exports = Category;