const { json } = require("body-parser");
const {Pool} = require("pg");
const {_DB} = require("../appConfig");
const e = require("express");
const pool = new Pool(_DB);

class routeController {
    async createEventLog(req, res) {
        let {
            name: reqName,
            description: reqDescrip,
            uid: reqUid,
            time: reqTime,
        } = req.body;
        if (!reqName || !reqUid) {
            res.status(401).json({
                message: "Not filled all field (Name,Object,Time)",
            });
        }

        try {
            const now = new Date();
            let dateNow = now.getHours()+":"+ now.getMinutes() +":"+ now.getSeconds();
            let createdDate = !reqTime ? dateNow: reqTime;
            let sqlquery = `INSERT INTO eventlog(event_name, ${!reqDescrip?'' : 'event_descrip,'} uid, event_created) VALUES('${reqName}', ${!reqDescrip?'': `'${reqDescrip}',`} '${reqUid}','${createdDate}')`;
            console.log("User query: " +  sqlquery);
            pool.query(sqlquery, (error, results) => {
                if (error) {
                    console.log(error);
                }else{
                    res.status(201).json({ message: "Log added successfuly" });
                }
                
            });
        } catch (error) {
            console.log(error);
            res.status(401).json({
                message: JSON.stringify(error),
            });
        }
    }
    async getUsers(req, res) {
        try {
            let URLquery = req.query.uid;
            let sqlquery = !URLquery?`SELECT * FROM eventlog ORDER BY event_id ASC `
            : `SELECT * FROM eventlog WHERE uid = '${URLquery}' ORDER BY event_id ASC`;
            console.log("User query: " +  sqlquery);
            pool.query(sqlquery, (error, results) => {
                if (error) {
                    res.status(400).json({ message: error });
                }else{
                    res.status(200).json({ message: results.rows });
                }
                
            });
        } catch (error) {
            res.status(400).json({ message: error});
        }
    }
}
module.exports = new routeController();