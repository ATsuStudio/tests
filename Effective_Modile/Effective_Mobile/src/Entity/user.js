const {Pool} = require("pg");
const {_DB} = require("../../appConfig");
const pool = new Pool(_DB);
class User {
    constructor(login = 'default', password= 'default', email = 'empty@empty.com', age ='1') {
        this._login = login;
        this._password = password;
        this._email = email;
        this._age = age;
    }
    async Update(){
        if(this._login  == 'default'){
            throw new Error('that user is default'); 
        }
        let sqlquery = `UPDATE public.users SET password = '${this._password}',  email = '${this._email}', age = ${this._age} WHERE login = '${this._login}'`;
        console.log("User query: " +  sqlquery);
        pool.query(sqlquery, (error, results) => {
            if (error) {
                console.log(error);
            }
            console.log("User saved successful");
        });

    }   
    async Save(){
        if(this._login  == 'default'){
            throw new Error('that user is default'); 
        }

        let sqlquery = 'INSERT INTO users(login, password, email, age) VALUES(\''+ this._login + '\', \'' + this._password + '\', \''+ this._email  +'\', \''+ this._age  +'\')';
        console.log("User query: " +  sqlquery);
        pool.query(sqlquery, (error, results) => {
            if (error) {
                console.log(error);
            }
            console.log("User saved successful");
        });

    }   
    async getUser(login){
        return new Promise((resolve, reject) => {
            let sqlquery = !login? `SELECT *  FROM Users` : `SELECT * FROM Users WHERE Users.login = '${login}'`;
            console.log("Query> " + sqlquery);
            pool.query(sqlquery, (error, results) => {
                if (error) {
                  reject(error);
                }
                console.log('findUserjson: '+  JSON.stringify(results.rows));

                resolve (results.rows);
              });
        });
    }
}

module.exports = User;