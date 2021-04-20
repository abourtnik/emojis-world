const config        = require('./config');
const express       = require('express');
const apiRouter     = require('./apiRouter').router;

const Log = require('./models/Log');

// Init server
let app = express();

// Body Parser configuration
app.use(express.json());

// Log
app.use(async (req, res, next) => {

    let start = new Date;

    res.on('finish', async function() {

        let duration = new Date - start;

        await Log.create({
            method: req.method,
            url: req.url,
            response_status: res.statusCode,
            response_time: duration,
            ip: req.ip,
            user_agent: req.get('User-Agent'),
        });
    });

    next()
});

// Router
app.use('/v' + config.application.version + '/' , apiRouter);

// Launch server
app.listen(config.server.port, config.server.host, function(){
    console.info('Server listen on http://' + config.server.host + ':' +config.server.port);
});