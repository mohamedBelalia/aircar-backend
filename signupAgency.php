<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $agencyData = json_decode(file_get_contents("php://input"));

    $agencyName = $agencyData->agencyName ;
    $agencyAdresse = $agencyData->agencyAdresse ;
    $email = $agencyData->email ;
    $pwd = $agencyData->pwd ;
    $phoneNbr = $agencyData->phoneNbr ;

    echo $phoneNbr ;

    $errors = [] ;

    if(empty($agencyName) || empty($agencyAdresse) || empty($email) || empty($pwd) || empty($phoneNbr))
    {
        $errors["inputsEmpty"] = "Fill Out All The Fields !" ;
    }

    if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
        $errors["emailInvalide"] = "Enter a Validate Email !" ;
    }

    if(strlen($pwd) < 8){
        $errors["shortPwd"] = "Enter a Strong Password !";
    }


    if($errors){
        $output = "{" ;

        foreach($errors as $errorKey => $error){
            $output .= '"' . $errorKey . '":"' . $error . '",';
        }

        $output .= '"status" : "unvalideData"}';

        echo $output ;

    }

    else{

        $pwd = password_hash($pwd , PASSWORD_DEFAULT);
        $token = md5(uniqid().rand(1000000000, 9999999999) . $email) ;

        $query = "INSERT INTO agencies(name,address,email,phoneNbr,pwd,token) VALUES (:name,:address,:email,:phoneNbr,:pwd,:token);";
        $statmet = $pdo->prepare($query);

        $statmet->bindParam(":name" , $agencyName);
        $statmet->bindParam(":address" , $agencyAdresse);
        $statmet->bindParam(":email" , $email);
        $statmet->bindParam(":phoneNbr" , $phoneNbr);
        $statmet->bindParam(":pwd" , $pwd);
        $statmet->bindParam(":token" , $token);

        $statmet->execute();
    }

?>