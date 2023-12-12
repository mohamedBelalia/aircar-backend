<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $userData = json_decode(file_get_contents("php://input"));

    $email = $userData->email ;
    $pwd = $userData->pwd ;

    $errors = [] ;

    if(empty($email) || empty($pwd)){
        $errors["emptyFields"] = "emptyFields";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors["unvalidEmail"] = "Please enter a valide email" ;
    }

    if($errors){
        $output = "{";

            foreach($errors as $key => $value){
                $output .= '"'.$key .'":"' . $value . '",' ;
            }
    
            $output .= '"status" : "unvalideLogin"}' ;
    
            echo $output ;
    }
    else{
        $query = "SELECT * FROM users WHERE email = :email ;";

        $statment = $pdo->prepare($query);
        $statment->bindParam(":email",$email);

        $statment->execute();

        $result = $statment->fetch(PDO::FETCH_ASSOC);

        if($result){

            if(password_verify($pwd , $result["pwd"])){

                $userData = '{"token" :"' . $result["token"] . '",' ;
                $userData .= '"status" : "successLogin"}';

                echo $userData ;

            }
            else{
                $response = '{"status" : "wrongData" }';
                echo $response ;
            }
        }
        else{
            $response = '{"status" : "wrongData" }';
            echo $response ;
        }

    }

?>