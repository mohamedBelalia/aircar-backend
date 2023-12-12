SELECT 
    users.first_name , 
    users.last_name , 
    users.email , 
    users.createdDate , 
    users.profilePath , 
    cars_information.* 
    FROM users inner join cars_information ON users.id = cars_information.owner_id -- join condition
    WHERE users.id = 30 ;



-- Comments

SELECT 
    comments.starsCount , 
    comments.comment , 
    comments.datePosted , 
    users.first_name , 
    users.profilePath 
    FROM comments inner join users ON comments.userId = users.id 
    WHERE comments.carId = 15