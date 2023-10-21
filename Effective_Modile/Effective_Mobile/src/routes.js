const express = require("express");
const route = new express();
const controller = require('./routeControllers');

route.post('/update', controller.userUpdate);

route.post('/login', controller.login);

route.get('/users/:username', controller.getUsers);
route.get('/users/', controller.getUsers);

module.exports = route;