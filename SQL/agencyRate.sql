CREATE TABLE agencyRate (
    id INT PRIMARY KEY AUTO_INCREMENT,
    starsNbr INT NOT NULL ,
    agencyId INT NOT NULL ,
    FOREIGN KEY (agencyId) REFERENCES agencies(id) ON DELETE CASCADE ,
    userRater INT NOT NULL ,
    FOREIGN KEY (userRater) REFERENCES users(id) ON DELETE CASCADE
)