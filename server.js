const config = require('./config');

const express = require('express');
const cors = require('cors')

const router = require('./router');
const { log } = require('./middlewares');

// Init server
let app = express();

// Proxy Nginx
app.set('trust proxy', true)

// Add cors
app.use(cors())

// Body Parser configuration
app.use(express.json());

// Log
app.use(log);

// Router
app.use('/v' + config.application.version + '/' , router);

// Launch server
app.listen(config.server.port, config.server.host, function(){
    console.info('Server listen on http://' + config.server.host + ':' + config.server.port);
});