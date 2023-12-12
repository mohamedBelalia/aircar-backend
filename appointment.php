<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $appappointmentInfo = json_decode(file_get_contents("php://input"));

    $startDate = $appappointmentInfo -> startDate ;
    $endDate = $appappointmentInfo -> endDate ;
    $pickUpTime = $appappointmentInfo -> pickUpTime ;
    $dropOffTime = $appappointmentInfo -> dropOffTime ;
    $carId = $appappointmentInfo -> carId ;
    $clientId = $appappointmentInfo -> clientId ;
    $priceDay = $appappointmentInfo -> priceDay ;

    $start = new DateTime($startDate) ;
    $end = new DateTime($endDate) ;

    $daysPrice = ($start->diff($end))->days * (float)$priceDay ;

    if(!empty($startDate) && !empty($endDate) && !empty($pickUpTime) 
    && !empty($dropOffTime) && !empty($carId) && !empty($clientId)){

        $query = "INSERT INTO appointments (startDate, endDate, pickUpTime, dropOffTime, clientId, carId , daysPrice) VALUES (:startDate, :endDate, :pickUpTime, :dropOffTime, :clientId, :carId , :daysPrice)";
        $statement = $pdo->prepare($query);
        
        $statement->bindParam(":startDate", $startDate);
        $statement->bindParam(":endDate", $endDate);
        $statement->bindParam(":pickUpTime", $pickUpTime);
        $statement->bindParam(":dropOffTime", $dropOffTime);
        $statement->bindParam(":clientId", $clientId);
        $statement->bindParam(":carId", $carId);
        $statement->bindParam(":daysPrice", $daysPrice);


        if($statement->execute()){
            // require("generatePdf.php");
            echo '{"status" : "done"}';
        }
        else{
            echo '{"status" : "appointmentFaild"}';
        }
        
    }
    else{
        echo '{"status" : "appointmentFaild"}';
    }






?>