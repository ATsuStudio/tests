const express = require("express");
const route = new express();
const controller = require('./routeControllers');

route.post('/event/', controller.createEventLog);
route.get('/event/', controller.getUsers);

module.exports = route;