<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    if(isset($_GET["token"])){
        
        $query = "SELECT * FROM users WHERE token = :token ;";

        $statment = $pdo->prepare($query);
        $statment->bindParam(":token" , $_GET["token"]);

        $statment->execute();

        $userInfo = $statment->fetchAll(PDO::FETCH_ASSOC);

        if($userInfo){
            echo json_encode($userInfo);
        }
        else{
            echo '{"status" : "unvalidUser"}';
        }

    }


?>