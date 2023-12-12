CREATE TABLE `carsInformation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(30) NOT NULL,
  `seats_nbr` int(11) NOT NULL,
  `brand` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `model` varchar(100) NOT NULL,
  `fuel_type` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `transmission` varchar(20) NOT NULL,
  `price_per_day` varchar(20) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `agency_ref` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)



SELECT * FROM `cars_information`

INSERT INTO carsinformation(city,seats_nbr,brand,category,model,fuel_type,color,transmission,price_per_day,img_path,agency_ref)
    VALUES
	
	('Marrakech'	'6'	'BMW'	'Voiture de Luxe'	'BMW 2024'	'electric'	'#808080'	'manual'	'899'	'653cf21ba1bce.jpg'	'0'	)	
	('Rabat'	'4'	'Bentley'	'SUV'	'BMW 89'	'Petrol'	'#A52A2A'	'manual'	'544'	'653cf2660203d.jpg'	'0'	)	
	('Marrakech'	'2'	'Fiat'	'Petite Voiture'	'Fiat 500 éule'	'electric'	'#00FF00'	'Automatic'	'455'	'653cfcfa62bd7.jpg'	'0'	)	
	('Meknes'	'4'	'Tesla'	'SUV'	'Tesla Model X Dual Motor restylé'	'electric'	'#808080'	'Automatic'	'150'	'653cfe2d31b2e.jpg'	'0'	)	
	('Marrakech'	'5'	Dacia	Voiture Moyenne	Dacia Sandero	electric	#808080	Automatic	688	653cff3f9431f.jpg	0	)	
	('Marrakech'	'5'	BMW	Voiture de Luxe	BMW Serie 8 Gran Coupe	electric	#808080	manual	299	653d094dcf3df.jpg	0	)	
	('Rabat'	'7'	Nissan	Grande Voiture	Nissan e-NV200	Petrol	#0000FF	manual	789	653d0ade86bc0.jpg	0	)	
    ('Marrakech'	'5'	Dacia	Voiture Moyenne	Dacia Spring	electric	#0000FF	manual	781	654ba777679a4.jpg	0	)	
