<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    if($_GET["carId"]){

        $carId = $_GET["carId"] ;


        $query = "SELECT comments.starsCount , comments.comment , comments.datePosted , 
                users.first_name , users.userImg 
                FROM comments inner join users ON comments.userId = users.id 
                WHERE comments.carId = :carId ORDER BY datePosted DESC ;";

        $statment = $pdo->prepare($query);

        $statment->bindParam(":carId" , $carId);

        $statment->execute();

        $comments = $statment->fetchAll(PDO::FETCH_ASSOC);

        if($comments){
            echo json_encode($comments) ;
        }
        else{
            echo '{"status" : "noComments"}' ;
        }

    }

?>