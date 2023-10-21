const { prototype } = require("events");
const now = new Date();
const express = require("express");
const {_PORT} = require('./appConfig');

const PORT = process.env.PORT || _PORT;
const routes = require('./src/routes');
const app = express();

app.use(express.json());
app.use('/', routes);

const start = ()=>{
    try{
        app.listen(PORT, ()=>{
            console.log("Server started on "+ PORT + " port, time: " + now.getMinutes() + " : "+ now.getSeconds());

        });
    }
    catch(e){
        console.log(e);
    }
}
start();