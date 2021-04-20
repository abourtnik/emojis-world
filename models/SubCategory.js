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
    created_at : {
        type: DataTypes.DATE,
        allowNull: false,
        defaultValue: Date.now()
    }
}, {
    timestamps: false
});

//SubCategory.belongsTo(Category);

module.exports = SubCategory;