<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    if(isset($_GET["agencyId"])){
    $agencyId = $_GET["agencyId"] ;

    $query = "SELECT * FROM carsinformation WHERE agency_ref = :agency_ref ;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":agency_ref" , $agencyId);
    $statement->execute() ;

    $records = $statement->fetchAll(PDO::FETCH_ASSOC);

    if($records){
        echo json_encode($records);
    }
    else{
        echo '{"status" : "zeroCars"}';
    }
    
    }
    else{
        echo '{"status" : "zeroCars"}';
    }
?>