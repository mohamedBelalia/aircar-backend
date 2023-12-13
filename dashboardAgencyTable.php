<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    if(isset($_GET["idAgency"])){

        $agencyId = $_GET["idAgency"] ;

        $carsIDs = selectCarsIds($pdo , $agencyId) ;

        
        if($carsIDs){
            $idConditions = " appointments.carId = " .  $carsIDs[0]["id"] ;
            foreach($carsIDs as $key => $id){
                $idConditions .= " || appointments.carId = " . $id["id"] ;
            }
        
        

        $query = "SELECT users.first_name , users.email , carsinformation.model 
                , appointments.pickUpTime , appointments.dropOffTime 
                , appointments.startDate , appointments.endDate , appointments.daysPrice FROM appointments 
                JOIN carsinformation ON appointments.carId = carsinformation.id
                JOIN users ON appointments.clientId = users.id
        WHERE $idConditions ;";

        $statment = $pdo->prepare($query);
  
        $statment->execute();

        echo json_encode($statment->fetchAll(PDO::FETCH_ASSOC));
    }else{
        echo '{"status" : "noId"}';
    }

    }
    else{
        echo '{"status" : "noId"}';
    }

    function selectCarsIds(PDO $pdo , $id){ //
        $query = "SELECT id FROM carsinformation WHERE agency_ref = :agency_ref ;";
        $statment = $pdo->prepare($query);
        $statment->bindParam(":agency_ref" , $id);
        $statment->execute();

        return  $statment->fetchAll(PDO::FETCH_ASSOC); 
    }




?>