<?php

$startDate = "" ;
$endDate = "" ;


    $idsQuery = "SELECT carId FROM appointments WHERE NOT((appointments.startDate > $startDate OR appointments.endDate < $startDate) 
    AND (appointments.startDate > $endDate OR appointments.endDate < $endDate));";

    $statmentID = $pdo->prepare($idsQuery);

    $statmentID->execute();

    $ids = $statmentID->fetchAll(PDO::FETCH_ASSOC);



?>