const config = require('./config');

const express = require('express');
const cors = require('cors')

const router = require('./router');
const { log , ip } = require('./middlewares');

// Init server
let app = express();

// Proxy Nginx
app.set('trust proxy', true)

// Add cors
app.use(cors())

// Body Parser configuration
app.use(express.json());

// Ip block
app.use(ip);

// Log
app.use(log);

// robots.txt
app.use('/robots.txt', function (req, res) {
    res.sendFile(__dirname + '/robots.txt');
});

// Router
app.use('/v' + config.application.version + '/' , router);

// Catch Error
app.use(function(err, req, res, next) {
    if (err instanceof SyntaxError && err.status === 400) {
        return res.status(400).json({'error': err.message});
    }
});

// Launch server
app.listen(config.server.port, config.server.host, function(){
    console.info('Server listen on http://' + config.server.host + ':' + config.server.port);
});