<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $rateInfo = json_decode(file_get_contents("php://input"));

    $userId = $rateInfo->userId ;
    $agencyId = $rateInfo->agencyId ;
    $starsCount = $rateInfo->starsCount ;

    if(isset($userId) && isset($agencyId) && isset($starsCount)){

        $query = "" ;

        if(isUserRated($pdo , $userId , $agencyId)){
            $query = "UPDATE agencyRate SET starsNbr = :starsNbr WHERE agencyId = :agencyId AND userRater = :userRater;";
        }
        else{
            $query = "INSERT INTO agencyRate (starsNbr,agencyId,userRater) VALUES (:starsNbr,:agencyId,:userRater);";
        }

        $statement = $pdo->prepare($query) ;
        $statement->bindParam(":starsNbr",$starsCount);
        $statement->bindParam(":agencyId",$agencyId);
        $statement->bindParam(":userRater",$userId);

        if($statement->execute()){
            echo '{"status" : "ok"}' ;
        }
        else{
            echo '{"status" : "somethingWrong"}' ;
        }
    
    }
    else{
        echo '{"status" : "somethingWrong"}' ;
    }


    function isUserRated(PDO $pdo , $userId , $agencyId){
        $query = "SELECT * FROM agencyRate WHERE userRater = :userRater AND agencyId = :agencyId ;";
        $statment = $pdo->prepare($query);
        $statment->bindParam(":userRater" , $userId);
        $statment->bindParam(":agencyId" , $agencyId);
        $statment->execute() ;

        $record = $statment->fetch(PDO::FETCH_ASSOC);

        if($record){
            return true ;
        }
        return false ;
    }

?>