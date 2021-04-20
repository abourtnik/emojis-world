const config = require('../config');
const axios = require('axios');
const fs = require('fs');

const Emoji = require('../models/Emoji');
const Category = require('../models/Category');
const SubCategory = require('../models/SubCategory');

const typesense = axios.create({
    baseURL: 'http://' + config.typesense.host + ':' + config.typesense.port,
    timeout: 1000,
});

(async function(){

    let data = fs.readFileSync('./jsons/emojis.json');
    let emojis = JSON.parse(data);

    for (let i = 0 ; i < emojis.length ; i ++) {

        let emoji = emojis[i];

        console.log(i);

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
            }
        }
    }

    process.exit();

    //const response = await typesense.get('/').catch(e => console.error(e.response.data));

})();


