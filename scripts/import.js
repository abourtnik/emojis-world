const fs = require('fs');
const cliProgress = require('cli-progress');

const Emoji = require('../models/Emoji');
const Category = require('../models/Category');
const SubCategory = require('../models/SubCategory');

const typesense = require('../databases/typesense');

category_count = (array, category_id) => {

    let index = array.findIndex(category => category.id === category_id)

    if (index !== -1){
        array[index]['count'] ++;
    }

    else {
        array.push({
            id : category_id,
            count : 1,
        })
    }
}

update_count = async (array, model) => {
    for (let k = 0; k < array.length ; k ++) {
        await model.update({count: array[k]['count']}, {
            where: {
                id: array[k]['id']
            }
        });
    }
}

(async function(){

    let data = fs.readFileSync('./emojis.json');
    let emojis = JSON.parse(data);

    let categories_count = [];
    let sub_categories_count = [];

    // Create Typesense emojis Collection
    await typesense.post('collections' , {
        'name': 'emojis',
        'fields': [
            {'name': 'id', 'type': 'string' },
            {'name': 'name', 'type': 'string' },
            {'name': 'emoji', 'type': 'string' },
            {'name': 'unicode', 'type': 'string'},
            {'name': 'category', 'type': 'int32'},
            {'name': 'sub_category', 'type': 'int32'}
        ],
        'default_sorting_field': 'category'
    }).catch(e => console.log(e.response.data.message || e.response.code));

    const bar = new cliProgress.SingleBar({}, cliProgress.Presets.shades_classic);

    bar.start(emojis.length, 0);

    for (let i = 0 ; i < emojis.length ; i ++) {

        let emoji = emojis[i];

        let category = await Category.findOrCreate({
            where : {
                id : emoji['category']['id']
            },
            defaults: {
                name : emoji['category']['name']
            },
            raw: true
        });


        let sub_category = await SubCategory.findOrCreate({
            where : {
                id : emoji['sub_category']['id']
            },
            defaults: {
                name : emoji['sub_category']['name'],
                category_id : category[0]['id']
            },
            raw: true
        });

        let emoji_parent = await Emoji.findOrCreate({
            where: {
                id: emoji['id']
            },
            defaults: {
                name: emoji['name'],
                emoji: emoji['emoji'],
                unicode: emoji['unicode'],
                category_id: category[0]['id'],
                sub_category_id: sub_category[0]['id']
            },
            raw: true
        });

        // Create Typesense document emoji

        await typesense.post('collections/emojis/documents' , {
            id: emoji_parent[0]['id'].toString(),
            name: emoji_parent[0]['name'],
            emoji :  emoji_parent[0]['emoji'],
            unicode :  emoji_parent[0]['unicode'],
            category: category[0]['id'],
            sub_category: sub_category[0]['id']
        }).catch(e => console.log(e.response.data.message || e.response.code));

        category_count(categories_count, category[0]['id']);
        category_count(sub_categories_count, sub_category[0]['id']);

        if (emoji['childrens'].length) {

            for (let j = 0; j < emoji['childrens'].length; j++) {

                let children = emoji['childrens'][j];

                await Emoji.findOrCreate({
                    where: {
                        id: children['id']
                    },
                    defaults: {
                        name: children['name'],
                        emoji: children['emoji'],
                        unicode: children['unicode'],
                        category_id: category[0]['id'],
                        sub_category_id: sub_category[0]['id'],
                        parent_id: emoji_parent[0]['id']
                    },
                    raw: true
                });

                category_count(categories_count, category[0]['id']);
                category_count(sub_categories_count, sub_category[0]['id']);
            }
        }

        bar.increment();
    }

    bar.stop();

    // Update category count
    await update_count(categories_count, Category)

    // Update sub_category count
    await update_count(sub_categories_count, SubCategory)

    process.exit();

})();


