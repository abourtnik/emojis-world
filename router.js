const express = require('express');
const users = require('./routes/users');
const emojis = require('./routes/emojis');

const { auth, filter } = require('./middlewares');

const router = express.Router();

// Users routes
router.post('/login', users.login);
router.get('/admin', [auth], users.admin);

// Emojis routes
router.get('/', emojis.index);
router.get('/search', [filter], emojis.search);
router.get('/random', [filter], emojis.random);
router.get('/popular', [filter], emojis.popular);
router.get('/categories', emojis.categories);
router.get('/emojis/:id', emojis.emojis);

// 404
router.get('*', function(req, res){
    res.status(404).json({'error' : 'Not found'});
});

// Router
module.exports = router