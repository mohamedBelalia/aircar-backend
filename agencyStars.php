<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    if(isset($_GET["agencyId"])){

        $id = $_GET["agencyId"] ;

        $query = "SELECT * FROM agencyRate WHERE agencyId = :id;";
        $statement = $pdo->prepare($query);

        $statement->bindParam(":id" , $id);

        $statement->execute() ;

        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($records);
    }



?>