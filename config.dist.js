module.exports = {
    application : {
        name : 'API Emojis World',
        version : 1,
        limit : {
            value : 5,
            unity : 'minutes'
        }
    },
    server : {
        host : 'localhost',
        port : 3001
    },
    mysql : {
        host : 'localhost',
        username : 'root',
        password : '',
        port : 3306,
        database : 'emojis_world',
        options : {
            supportBigNumbers: true,
            bigNumberStrings: true,
            timezone : 'local'
        },
        log : true,
        timezone: 'Europe/Paris'
    },
    typesense : {
        host : 'localhost',
        port : 8108,
        api_key: 'typeseseapikey',
    },
    jwt : {
        secret : ''
    }
};