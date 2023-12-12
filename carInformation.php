<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    
    if(isset($_GET["id"])){

    $id = $_GET["id"];


    $query = "SELECT agencies.name , agencies.email , agencies.created_at , agencies.logoImg
        , carsinformation.* FROM agencies inner join carsinformation 
        ON carsinformation.agency_ref = agencies.id
        WHERE carsinformation.id = :id";


    $statment = $pdo->prepare($query);

    $statment->bindParam(":id" , $id);

    $statment->execute();

    $carInfromation = $statment->fetchAll(PDO::FETCH_ASSOC);

    if($carInfromation){
        $validCarInformation = json_encode($carInfromation);
        echo $validCarInformation ;
    }
    else{
        echo '{"status" : "noData" }' ;
    }

}

?>