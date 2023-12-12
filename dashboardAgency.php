<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    if(isset($_GET["idAgency"])){

        $agencyId = $_GET["idAgency"] ;

        
        $carsCount = selectCarsCount($pdo , $agencyId) ;
        $carsIDs = selectCarsIds($pdo , $agencyId) ;
        $clientsCount = 0 ;
        $incomeTotal = 1000 ;
        $clientsInfo = "" ;

        if($carsIDs){
            foreach($carsIDs as $key => $id){
                $clientsCount += selectClientsCount($pdo , $id["id"]) ;
                $clientsInfo .= json_encode(selectClientsInfo($pdo , $id["id"])) . "<br/>" ;
            }
        }
        
        $output = '{"status" : "ok" , "carsCount" : "' . $carsCount . 
            '" , "clientsCount" : "' . $clientsCount .'" , "incomeTotal" : "' . $incomeTotal . '"}' ;
        echo $output ;

    }
    else{
        echo '{"status" : "noId"}';
    }



    function selectCarsCount(PDO $pdo , $id){
        $query = "SELECT COUNT(*) FROM carsinformation WHERE agency_ref = :agency_ref ;";
        $statment = $pdo->prepare($query);
        $statment->bindParam(":agency_ref" , $id);
        $statment->execute();

        return  $statment->fetchColumn();
    }

    function selectCarsIds(PDO $pdo , $id){
        $query = "SELECT id FROM carsinformation WHERE agency_ref = :agency_ref ;";
        $statment = $pdo->prepare($query);
        $statment->bindParam(":agency_ref" , $id);
        $statment->execute();

        return  $statment->fetchAll(PDO::FETCH_ASSOC);
    }

    function selectClientsCount(PDO $pdo , $id){
        $query = "SELECT COUNT(*) FROM appointments WHERE carId = :carId ;";
        $statment = $pdo->prepare($query);
        $statment->bindParam(":carId" , $id);
        $statment->execute();

        return  (int)$statment->fetchColumn();
    }

    function selectClientsInfo(PDO $pdo , $id){
        $query = "SELECT * FROM appointments 
                JOIN carsinformation ON appointments.carId = carsinformation.id
                JOIN users ON appointments.clientId = users.id
        WHERE appointments.carId = :carId ;";

        $statment = $pdo->prepare($query);
        $statment->bindParam(":carId" , $id);
        $statment->execute();

        return  $statment->fetchAll(PDO::FETCH_ASSOC) ;
    }

?>