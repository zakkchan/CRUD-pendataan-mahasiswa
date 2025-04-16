<?php

$servername = "localhost"; 
$namalengkap = "root";        
$password = "";            
$dbname = "dbcrud_modal";  

$koneksi = new mysqli($servername, $namalengkap, $password, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
