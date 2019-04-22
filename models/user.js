const mongoose = require('mongoose');

const userSchema = mongoose.Schema({
    email: {type:String , required:true},
    username: {type:String , required:true},
    password: {type:String , required:true},
    admin: {type:Boolean , required:true}
});

module.exports = mongoose.model('User', userSchema);