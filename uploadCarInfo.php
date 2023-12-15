<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: image/jpeg, image/png");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

    require_once("dbConnection.php");

    $errors = [] ;


    if(!empty($_POST["city"]) && !empty($_POST["address"]) && !empty($_POST["seats_number"]) && !empty($_POST["brand"]) && !empty($_POST["category"]) &&
    !empty($_POST["model"]) && !empty($_POST["fuel_type"]) && !empty($_POST["transmission"]) && !empty($_POST["price_per_day"]) &&
    !empty($_POST["owner_id"]) && !empty($_POST["color"]) && !empty($_FILES["carImg"]) && !empty($_POST["description"])){

        $address = $_POST["address"] ;
        $city = $_POST["city"] ;
        $seats_number = $_POST["seats_number"];
        $brand = $_POST["brand"];
        $category = $_POST["category"];
        $model = $_POST["model"];
        $fuel_type = $_POST["fuel_type"];
        $color = $_POST["color"];
        $transmission = $_POST["transmission"];
        $price_per_day = $_POST["price_per_day"];
        $description = $_POST["description"];
        $owner_id = $_POST["owner_id"];


        $img = $_FILES["carImg"];

        $fileName = $img["name"];
        $temp_location = $img["tmp_name"];
        $uploadersError = $img["error"];

        $splitedName = explode("." , $fileName);
        $imgExtension = strtolower(end($splitedName));

        $allowedExtensions = ["png" , "jpeg" , "jpg"];

        if(in_array($imgExtension , $allowedExtensions)){

            if($uploadersError === 0){

                $new_img_name = uniqid() . "." . $imgExtension ;
                $img_destination = "Images/" . $new_img_name ;

                if(move_uploaded_file($temp_location , $img_destination)){

                    
                    $query = "INSERT INTO carsinformation (adresse,city,seats_nbr,brand,category,model,fuel_type,color,transmission,price_per_day,img_path,agency_ref,description) 
                            VALUES (:adresse,:city,:seats_nbr,:brand,:category,:model,:fuel_type,:color,:transmission,:price_per_day,:img_path,:agency_ref,:description);" ;

                    $statment = $pdo->prepare($query);
                    
                    $statment->bindParam(":adresse" , $address);
                    $statment->bindParam(":city" , $city);
                    $statment->bindParam(":seats_nbr" , $seats_number);
                    $statment->bindParam(":brand" , $brand);
                    $statment->bindParam(":category" , $category);
                    $statment->bindParam(":model" , $model);
                    $statment->bindParam(":fuel_type" , $fuel_type);
                    $statment->bindParam(":color" , $color);
                    $statment->bindParam(":transmission" , $transmission);
                    $statment->bindParam(":price_per_day" , $price_per_day);
                    $statment->bindParam(":img_path" , $new_img_name);
                    $statment->bindParam(":agency_ref" , $owner_id);
                    $statment->bindParam(":description" , $description);

                    $statment->execute();

                    echo '{"status" : "ok"}';
                } 
                else{
                    echo '{"status" : "fileUploadingError"}';
                }

            }
            else{
                echo '{"status" : "fileUploadingError"}';
            }

        }
        else{
            echo '{"status" : "extensionNotAllawed"}';
        }
    }
    else{
        echo '{"status" : "emptyFields"}' ;
    }


?>