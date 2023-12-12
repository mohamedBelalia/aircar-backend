<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $agencyData = json_decode(file_get_contents("php://input"));

    $agencyEmail = $agencyData->email;
    $agencyPwd = $agencyData->pwd;
    $agencyPhoneNbr = $agencyData->phoneNbr;

    $errors = [] ;

    if(empty($agencyEmail) || empty($agencyPwd) || empty($agencyPhoneNbr)){
        $errors["emptyFields"] = "emptyFields";
    }

    if(!filter_var($agencyEmail , FILTER_VALIDATE_EMAIL)){
        $errors["invalideEmail"] = "Enter a Validate Email !" ;
    }

    if($errors){
        $output = "{";
        
        foreach($errors as $errorKey => $error){
            $output .= '"' . $errorKey . '":"' . $error . '",' ;
        }

        $output .= '"status":"unvalideLogin"}';

        echo $output ;
    }
    else{
        $query = "SELECT * FROM agencies WHERE email = :email AND phoneNbr = :phoneNbr";
        $statment = $pdo->prepare($query);

        $statment->bindParam(":email" , $agencyEmail);
        $statment->bindParam(":phoneNbr" , $agencyPhoneNbr);

        $statment->execute();

        $records = $statment->fetch(PDO::FETCH_ASSOC);

        if($records){
            if(password_verify($agencyPwd ,$records["pwd"])){

                $agencyToken = '{"token" : "' . $records["token"] . '","status":"successLogin"}';
                echo $agencyToken ;

            }
            else{
                echo '{"status" : "wrongData" }' ;
            }
        }
        else{
            echo '{"status" : "wrongData" }' ;
        }
    }


?>