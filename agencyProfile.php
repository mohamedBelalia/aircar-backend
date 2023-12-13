<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    if(isset($_GET["agencyName"]) && isset($_GET["agencyId"])){
        $agencyId = $_GET["agencyId"] ;
        $agencyName = $_GET["agencyName"] ;

        $query = "SELECT * FROM agencies WHERE id = :id AND name = :name ;" ;
        $statement = $pdo->prepare($query);
        $statement->bindParam(":id" , $agencyId);
        $statement->bindParam(":name" , $agencyName);
        $statement->execute();
        $records = $statement->fetch(PDO::FETCH_ASSOC);

        if($records){
            echo json_encode($records);
        }
        else{
            echo '{"status" : "wrongData"}' ;
        }
    }


?>
