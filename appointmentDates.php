<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    if(isset($_GET["carId"])){

        $query = "SELECT startDate , endDate FROM appointments WHERE carId = :carId;";
        $statment = $pdo->prepare($query);
        $statment->bindParam(":carId",$_GET["carId"]);
        $statment->execute();
        $dates = $statment->fetchAll(PDO::FETCH_ASSOC);

        if($dates){
            echo json_encode($dates);
        }
        else{
            echo '{"status" : "noDates"}';
        }

    }

?>