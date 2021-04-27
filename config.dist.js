module.exports = {
    application : {
        name : 'API Emojis World',
        version : 1
    },
    server : {
        host : 'localhost',
        port : 3001
    },
    mysql : {
        host : 'localhost',
        username : 'root',
        password : 'root',
        port : 3306,
        database : 'emojis_world',
        options : {
            socketPath: '/Applications/MAMP/tmp/mysql/mysql.sock',
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
        api_key: '',
    },
    jwt : {
        secret : ''
    }
};