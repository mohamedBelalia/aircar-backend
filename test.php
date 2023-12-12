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
    $endDate = $carsInfo->endDate ?? false ; ;
    
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
    
    $query = "SELECT * FROM carsinformation WHERE $queryCondition;";

    $statment = $pdo->prepare($query);
    $statment->execute();

    $carsResult = $statment->fetchAll(PDO::FETCH_ASSOC);

    
    echo json_encode($carsResult);
    




?><?php

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
    $endDate = $carsInfo->endDate ?? false ; ;
    
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
    
    $query = "SELECT * FROM carsinformation WHERE $queryCondition;";

    $statment = $pdo->prepare($query);
    $statment->execute();

    $carsResult = $statment->fetchAll(PDO::FETCH_ASSOC);

    
    echo json_encode($carsResult);
    




?>