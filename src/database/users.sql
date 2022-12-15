CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,

    address VARCHAR(100),
    city VARCHAR(50),
    post_code VARCHAR(10),
    country VARCHAR(50),

    admin_level INT DEFAULT 0,

    PRIMARY KEY (id)
);

ALTER TABLE users ADD address VARCHAR(100);
ALTER TABLE users ADD city VARCHAR(50);
ALTER TABLE users ADD post_code VARCHAR(10);
ALTER TABLE users ADD country VARCHAR(50);


/****************************************************************
    * 
    *  INSERT INTO users
    * 
****************************************************************/

INSERT INTO users (`full_name`, `username`, `email`, `password`, `admin_level`) 
VALUES ('Admin Account', 'Admin', 'admin@audioly.com', '$2y$10$4Xv1HD3ki.e7PMPAli18Uun6sg4eP.sYINK5QqeeB25yNDl0Co7aS', 1)