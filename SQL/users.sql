CREATE TABLE users(
	id INT AUTO_INCREMENT PRIMARY KEY ,
    first_name VARCHAR(155) NOT NULL ,
    last_name VARCHAR(155) NOT NULL ,
    email VARCHAR(155) NOT NULL ,
    pwd TEXT NOT NULL ,
    userImg TEXT DEFAULT "userImg.png" ,
    token TEXT NOT NULL 
)