CREATE TABLE carsinformation (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    adresse varchar(30) NOT NULL, -- Changed
    seats_nbr int(11) NOT NULL,
    brand varchar(30) NOT NULL,
    category varchar(30) NOT NULL,
    model varchar(100) NOT NULL,
    fuel_type varchar(20) NOT NULL,
    color varchar(20) NOT NULL,
    transmission varchar(20) NOT NULL,
    price_per_day varchar(20) NOT NULL,
    img_path varchar(255) NOT NULL,
    agency_ref int(11) NOT NULL,
    FOREIGN KEY(agency_ref) REFERENCES agencies(id) ON DELETE CASCADE
)