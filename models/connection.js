const mongoose = require('mongoose');

const conectionSchema = mongoose.Schema({
    ip: String,
    date: Date,
    request: String,
    duration: Number
});

module.exports = mongoose.model('Connection', conectionSchema);