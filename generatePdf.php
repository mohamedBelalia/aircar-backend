<?php
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Headers: access");
 header("Access-Control-Allow-Methods: POST");
 header("Content-Type: application/json; charset=UTF-8");
 header("Access-Control-Allow-Headers: Content-Type,Access-Controle-Allow-Headers, Autorization, X-Requested-With");

 require_once("dbConnection.php");

 use Dompdf\Dompdf ;

    if(isset($_GET["clientId"]) && $_GET["carId"] && $_GET["pickupDate"] && $_GET["dropOffDate"] ){

        if(carInfor($_GET["carId"] , $pdo) && clientInfo($_GET["clientId"] , $pdo)){
         
    $clientInfo = clientInfo($_GET["clientId"] , $pdo);
    $clientName = $clientInfo[0]["first_name"] . " " . $clientInfo[0]["last_name"];

    $pdfName = $clientInfo[0]["first_name"] . "_" . $clientInfo[0]["last_name"] . "_appointment.pdf";

    $carInfo = carInfor($_GET["carId"] , $pdo);

    $carImg = $carInfo[0]["img_path"];
    $city = $carInfo[0]["adresse"];
    $seats_nbr = $carInfo[0]["seats_nbr"];
    $brand = $carInfo[0]["brand"];
    $category =  $carInfo[0]["category"];
    $model = $carInfo[0]["model"];
    $fuel_type = $carInfo[0]["fuel_type"];
    $color = $carInfo[0]["color"];
    $transmission = $carInfo[0]["transmission"];
    $price_per_day = $carInfo[0]["price_per_day"];
    $carOwner = $carInfo[0]["name"];

    $pickupDate = $_GET["pickupDate"] ;
    $dropOffDate = $_GET["dropOffDate"] ;

    $signature = "client:". $clientName ."_idClient:" . $_GET["clientId"] . "_rented:" . $brand . "_" . $model . "_idCar:" . $_GET["carId"] ; 
    $digital_signature = md5($signature);

    require __DIR__ . "/vendor/autoload.php";

    $dompdf = new Dompdf([
        "chroot" => __DIR__
    ]);


    $html = '

    <div style="font-family: Arial, Helvetica, sans-serif;">
        <h1 style="color: rgb(0, 65, 140); ">Renting Evidence :</h1>
        <img style="width: 60%; margin-left: auto; margin-left: auto; height: 200px; object-fit: cover;" src="./Images/'. $carImg .'" alt="">
        <p>Client : <span style="color: rgb(0, 65, 140);">'. $clientName .'</span></p>
        <p>Digital Signituer : <span style="color: rgb(0, 65, 140);;">'. $digital_signature .'</span></p>
        <h4 style="color: rgb(0, 65, 140);">Date :</h4>
        <p>Pickup Date : <span style="color: rgb(0, 65, 140);;">'. $pickupDate .'</span></p>
        <p>DropOff Date : <span style="color: rgb(0, 65, 140);;">' . $dropOffDate . '</span></p>
        <h4 style="color: rgb(0, 65, 140);">Car Information :</h4>
        <p>City : <span style="color: rgb(0, 65, 140);;">' . $city . '</span></p>
        <p>Brand : <span style="color: rgb(0, 65, 140);;">' . $brand . '</span></p>
        <p>Model : <span style="color: rgb(0, 65, 140);;">' . $model . '</span></p>
        <p>Category : <span style="color: rgb(0, 65, 140);;">'. $category .'</span></p>
        <p>Fuel Type : <span style="color: rgb(0, 65, 140);;">'. $fuel_type .'</span></p>
        <p>Transmission : <span style="color: rgb(0, 65, 140);;">' . $transmission . '</span></p>
        <p>Seats Nomber : <span style="color: rgb(0, 65, 140);;">' . $seats_nbr . '</span></p>
        <div style="display: flex;">
            <div>Color : </div>
            <div style="margin-left: 6px; width: 20px; height: 20px; background-color: '. $color .'; border-radius: 50%;"></div>
        </div>      
        <div style="display: flex; justify-content: end;">
                <p>Car Owner : <span style="color: rgb(0, 65, 140);;">' . $carOwner . '</span></p>
        </div>  
</div>
' ;


    $dompdf->load_html($html);

    $dompdf->render();

    $dompdf->stream($pdfName);

    $query = "INSERT INTO signatures(clientId,carId,digital_signature) VALUES (:clientId,:carId,:digital_signature);";
    $statment = $pdo->prepare($query);
    $statment->bindParam(":clientId" , $_GET["clientId"]);
    $statment->bindParam(":carId" , $_GET["carId"]);
    $statment->bindParam(":digital_signature" , $digital_signature);

    $statment->execute();

    }
    else{
        echo '{"status" : "noDate"}' ;
    }

}
else{
    echo '{"status" : "noDate"}' ;
}

    function clientInfo(string $clientId , PDO $pdo){
        $query = "SELECT * FROM users WHERE id = :id;" ;
        $statment = $pdo->prepare($query);
        $statment->bindParam(":id" , $clientId);

        $statment->execute();

        $clientInfo = $statment->fetchAll(PDO::FETCH_ASSOC);
        
        if($clientInfo){
            return $clientInfo ;
        }

        return false ;
    }


    function carInfor($carId , PDO $pdo){
        $query = "SELECT carsinformation.* , agencies.name 
        FROM carsinformation inner join agencies ON agencies.id = carsinformation.agency_ref 
        WHERE carsinformation.id = :id;";

        $statment = $pdo->prepare($query);
        $statment->bindParam(":id" , $carId);

        $statment->execute();

        $carInfo = $statment->fetchAll(PDO::FETCH_ASSOC);
        
        if($carInfo){
            return $carInfo ;
        }
        
        return false ;
    }


?>