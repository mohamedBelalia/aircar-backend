CREATE TABLE signatures (
    id INT AUTO_INCREMENT PRIMARY KEY ,
    digital_signature TEXT NOT NULL ,
    clientId INT ,
    FOREIGN KEY(clientId) REFERENCES users(id) ON DELETE CASCADE ,
    carId INT ,
    FOREIGN KEY(carId) REFERENCES carsInformation(id) ON DELETE CASCADE
)