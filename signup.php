<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $userData = json_decode(file_get_contents("php://input"));

    $first_name = $userData->first_name;
    $last_name = $userData->last_name;
    $email = $userData->email;
    $pwd = $userData->pwd;

    $errors = [] ;


    if(empty($first_name) || empty($last_name) || empty($email) || empty($pwd)){
        $errors["allFieldsRequired"] = "Fill out all the Fields !";
    }

    if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
        $errors ["unValideEmail"] = "Enter a validate email";
    }

    if(strlen($pwd) < 8){
        $errors ["unValidePwd"] = "Enter a validate Password";
    }

    if($errors){ 
        
        $output = "{";

        foreach($errors as $key => $value){
            $output .= '"'.$key .'":"' . $value . '",' ;
        }

        $output .= '"status" : "unvalideData"}' ;

        echo $output ;

    }
    else{

    $pwd = password_hash($pwd , PASSWORD_DEFAULT) ;
    $token = md5(uniqid().rand(1000000000, 9999999999) . $email) ;
    $query = "INSERT INTO users (first_name,last_name,email,pwd,token) VALUES (:first_name,:last_name,:email,:pwd,:token);";
        
    $statment = $pdo->prepare($query);

    $statment->bindParam(":first_name",$first_name);
    $statment->bindParam(":last_name",$last_name);
    $statment->bindParam(":email",$email);
    $statment->bindParam(":pwd",$pwd);
    $statment->bindParam(":token",$token);

    $statment->execute();
    }

?>