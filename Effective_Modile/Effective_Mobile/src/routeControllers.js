const User = require('./Entity/user');
const { json } = require("body-parser");
const {_LOGHOST} =require("../appConfig");
const axios = require('axios');
class routeController {
    async login(req, res) {
        let {
            login: reqLogin,
            password: reqPassword,
            email: reqEmail,
            age: reqAge,
        } = req.body;
        if (!reqLogin || !reqPassword || !reqEmail || !reqAge) {
            res.status(401).json({
                message: "Not filled all field (Login,Password,Email,Age)",
            });
        }
        let loginUser = new User();
        try {
            if ((await loginUser.getUser(reqLogin)) == false) {
                loginUser = new User(reqLogin, reqPassword, reqEmail, reqAge);
                await loginUser.Save();
                res.status(201).json({ message: "Logined successfuly" });
                let user = await loginUser.getUser(reqLogin);
                sendLog('Create', `User ${reqLogin} was created`, user[0].uid);
            } else {
                res.status(401).json({
                    message: "User with that login is exist",
                });
            }
        } catch (error) {
            console.log(error);
        }
    }
    async userUpdate(req, res) {
        let {
            login: reqLogin,
            password: reqPassword,
            email: reqEmail,
            age: reqAge,
        } = req.body;
        if (!reqLogin || !reqPassword || !reqEmail || !reqAge) {
            res.status(401).json({
                message: "Not filled all field (Login,Password,Email,Age)",
            });
        }
        let updateUser = new User();
        try {
            if ((await updateUser.getUser(reqLogin))) {
                updateUser = new User(reqLogin, reqPassword, reqEmail, reqAge);
                await updateUser.Update();
                res.status(200).json({ message: "Updated successfuly" });
                let user = await updateUser.getUser(reqLogin);
                sendLog('Update', `User ${reqLogin} was updated`, user[0].uid);
            } else {
                res.status(401).json({ message: "User not found" });
            }
        } catch (error) {
            console.log(error);
        }
    }
    async getUsers(req, res) {
        try {
            let userInstance = new User();
            let userQuery = req.params.username;
            res.status(200).json({ message: await userInstance.getUser(userQuery)});
        } catch (error) {
            res.status(200).json({ message: error});
        }
    }
}
let sendLog = (type, descriprion, uid)=>{
    try {
        
        axios.post(_LOGHOST + '/event', {
            "name": type,
            "description": descriprion,
            "uid": uid
        });
    } catch (error) {
        console.log("Axios request error> "+ error);
    }
    
}
module.exports = new routeController();