<?php

$hostName = "localhost";  
$dbUser = "root";
$dbPassword = "";
$dbName = "dbcrud_modal";


$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);


if (!$conn) {
    die("Something went wrong: " . mysqli_connect_error()); 
}

?>
