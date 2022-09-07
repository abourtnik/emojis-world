const { DataTypes} = require('sequelize');

const sequelize = require('../databases/mysql');

const Category = require('./Category');
const SubCategory = require('./SubCategory');

const Emoji = sequelize.define('emojis', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true,
        unique: true,
        allowNull: false,
        get() {
            return this.getDataValue('id')
        }
    },
    name: {
        type: DataTypes.STRING,
        unique: true,
        allowNull: false,
        get() {
            return this.getDataValue('name')
        }
    },
    emoji: {
        type: DataTypes.STRING,
        unique: true,
        allowNull: false,
        get() {
            return this.getDataValue('emoji')
        }
    },
    unicode: {
        type: DataTypes.STRING,
        unique: true,
        allowNull: false,
        get() {
            return this.getDataValue('unicode')
        }
    },
    category_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
        references: {
            model: Category,
            key: "category_id"
        }
    },
    sub_category_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
        references: {
            model: SubCategory,
            key: "sub_category_id"
        }
    },
    count: {
        type: DataTypes.INTEGER,
        allowNull: false,
        defaultValue: 0

    },
    version: {
        type: DataTypes.DOUBLE,
        allowNull: false,
        get() {
            return this.getDataValue('version').toFixed(1)
        }

    }
}, {
    timestamps: false
});

Emoji.belongsTo(Category, { foreignKey: 'category_id' });
Emoji.belongsTo(SubCategory, { foreignKey: 'sub_category_id' });
Emoji.hasMany(Emoji, { as : 'children', foreignKey: 'parent_id', useJunctionTable: false});
Emoji.belongsTo(Emoji, { as : 'parent', foreignKey: 'parent_id', useJunctionTable: false});

Category.hasMany(Emoji, {foreignKey: 'category_id' });
SubCategory.hasMany(Emoji, {foreignKey: 'sub_category_id' });

module.exports = Emoji;

