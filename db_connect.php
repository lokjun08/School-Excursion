<?php
// db_connect.php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "school_excursion"; 


$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
