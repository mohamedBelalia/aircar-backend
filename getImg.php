<?php

$folderPath = 'Images'; 


$files = scandir($folderPath);

$imageFiles = array_filter($files, function($file) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    return in_array(strtolower($extension), $allowedExtensions);
});


echo "Image files in the folder:\n";
foreach ($imageFiles as $image) {
    echo $image . "<br/>";
}

?>
