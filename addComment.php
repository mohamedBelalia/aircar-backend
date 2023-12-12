<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $commentInfo = json_decode(file_get_contents("php://input"));

    $carId = $commentInfo->carId ;
    $commentText = $commentInfo->commentText ;
    $starsCount = $commentInfo->starsCount ;
    $userId = $commentInfo->userId ;

    if(!empty($carId) && !empty($commentText) && !empty($starsCount) && !empty($userId) ){

        $query = "INSERT INTO comments (userId,carId,starsCount,comment) VALUES(:userId,:carId,:starsCount,:comment);";
        $statment = $pdo->prepare($query);

        $statment->bindParam(":userId" , $userId);
        $statment->bindParam(":carId" , $carId);
        $statment->bindParam(":starsCount" , $starsCount);
        $statment->bindParam(":comment" , $commentText);

        $statment->execute();

    }
    else{
        echo '{"status" : "dataNotComplated"}' ;
    }

    
?>