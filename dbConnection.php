<?php

    $hostname = "localhost" ;
    $dbName = "aircar" ;
    $userName = "root" ;
    $password = "" ;


    $dsn = "mysql:host=$hostname;dbname=$dbName";

    try {

        $pdo = new PDO($dsn,$userName,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        
    } catch (PDOException $exception) {
        die("Connection faild : " . $exception->getMessage());
    }

?>