CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY ,
    startDate VARCHAR(20) NOT NULL ,
    endDate VARCHAR(20) NOT NULL ,
    pickUpTime VARCHAR(10) NOT NULL ,
    dropOffTime VARCHAR(10) NOT NULL ,
    daysPrice FLOAT ,
    clientId INT ,
    FOREIGN KEY(clientId) REFERENCES users(id) ON DELETE CASCADE ,
    carId INT ,
    FOREIGN KEY(carId) REFERENCES carsInformation(id) ON DELETE CASCADE
)