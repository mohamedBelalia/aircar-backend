<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $carsInfo = json_decode(file_get_contents("php://input"));


    $pricePerDay = $carsInfo->pricePerDay ?? false ;
    $seatsNbr = $carsInfo->seatsNbr ?? false ;
    $transmission = $carsInfo->transmission ?? false ;
    $fuelType = $carsInfo->fuelType ?? false ;
    $brands = $carsInfo->brands ?? false ;
    $startDate = $carsInfo->startDate ?? false ;
    $endDate = $carsInfo->endDate ?? false ;
    $typeCar = $carsInfo->typeCar ?? false ;
    $locationRegion = $carsInfo->locationRegion ;
    
    $queryCondition = " 1 " ;

    if($pricePerDay){
        if(!str_contains($pricePerDay , "-")){
            $queryCondition .= " AND price_per_day >= '$pricePerDay' ";
        }
        else {
            $priceRange = explode("-" , $pricePerDay);
            $minPrice = (float)$priceRange[0] ;
            $maxPrice = (float)$priceRange[1] ;
            $queryCondition .= " AND price_per_day BETWEEN '$minPrice' AND '$maxPrice' ";
        }
        
    }

    if($seatsNbr){
        if(!str_contains($seatsNbr , "-")){
            $queryCondition .= " AND seats_nbr >= '$seatsNbr' " ;
        }
        else{
            $seatsRange = explode("-" , $seatsNbr);
            $firstNbr = $seatsRange[0];
            $secondNbr = $seatsRange[1];
            $queryCondition .= " AND seats_nbr BETWEEN  '$firstNbr' AND '$secondNbr' " ;
        }
        
    }

    if($transmission){
        $queryCondition .= " AND transmission = '$transmission' " ;
    }

    if($fuelType){
        $queryCondition .= " AND fuel_type = '$fuelType' " ;
    }

    if($brands){
        if($brands != "other"){
            $queryCondition .= " AND brand = '$brands' " ;
        }
    }

    if($typeCar){
        $queryCondition .= " AND category = '$typeCar' " ;
    }

    if($startDate && $endDate){
        $idsQuery = "SELECT carId FROM appointments WHERE NOT((appointments.startDate > :startDate OR appointments.endDate < :startDate) 
        AND (appointments.startDate > :endDate OR appointments.endDate < :endDate));";

        $statmentID = $pdo->prepare($idsQuery);
        $statmentID->bindParam(":startDate" , $startDate);
        $statmentID->bindParam(":endDate" , $endDate);

        $statmentID->execute();

        $ids = $statmentID->fetchAll(PDO::FETCH_ASSOC);
        foreach($ids as $id){
            $queryCondition .= " AND carsinformation.id <> " . $id["carId"] ;
        }
    }

    if(strlen($locationRegion) > 0){
        $queryCondition .= " AND carsinformation.city = '$locationRegion' ";
    }
    
    $query = "SELECT carsinformation.* , agencies.name FROM carsinformation inner join agencies ON carsinformation.agency_ref = agencies.id WHERE $queryCondition;";
    $statment = $pdo->prepare($query);
    $statment->execute();


    $carsResult = $statment->fetchAll(PDO::FETCH_ASSOC);

    
    echo json_encode($carsResult);
    




?>