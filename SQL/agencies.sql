CREATE TABLE agencies(
	id INT AUTO_INCREMENT PRIMARY KEY ,
    name VARCHAR(155) NOT NULL ,
    address VARCHAR(255) NOT NULL ,
    email VARCHAR(155) NOT NULL ,
    phoneNbr INT NOT NULL ,
    pwd TEXT NOT NULL ,
    logoImg TEXT DEFAULT "agencyLogo.png"
)