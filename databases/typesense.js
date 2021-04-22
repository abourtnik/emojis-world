const config = require('../config');

const axios = require('axios');

module.exports = typesense = axios.create({
    baseURL: 'http://' + config.typesense.host + ':' + config.typesense.port,
    timeout: 1000,
    headers : {
        'x-typesense-api-key' : config.typesense.api_key
    }
});