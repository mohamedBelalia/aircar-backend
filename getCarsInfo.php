<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $errors = [] ;

    $query = "SELECT * FROM carsinformation";

    $statment = $pdo->prepare($query);

    $statment->execute();

    $carsInfo = $statment->fetchAll(PDO::FETCH_ASSOC);

    if($carsInfo){
        
        echo json_encode($carsInfo);
        
    }
    else{
        echo '{"status" : "noData" }' ;
    }

?>