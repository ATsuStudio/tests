module.exports = {
    _PORT: 8024,
    _DB:{
        host: '127.0.0.1',
        port: '5432',
        user: "reactUser",
        password: "admin",
        database: "effective_modile_db"
    }
};

// PGSQL requests
// 
// CREATE Table users (
// 	uid serial PRIMARY KEY,
// 	login varchar(50) NOT NULL ,
// 	password varchar(255) NOT NULL,
// 	email varchar(255) NOT NULL,
// 	age integer
// )
//
// CREATE Table eventlog (
// 	event_id serial PRIMARY KEY,
// 	event_name varchar(255) NOT NULL ,
// 	event_descrip varchar(255),
// 	uid integer NOT NULL,
// 	enent_created time NOT NULL
// )