CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    admin_level INT DEFAULT 0,

    PRIMARY KEY (id)
);


/****************************************************************
    * 
    *  INSERT INTO users
    * 
****************************************************************/