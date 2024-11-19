<?php
// get_teachers.php

require 'db_connect.php'; // Your DB connection file

$query = "SELECT * FROM teachers";
$result = mysqli_query($conn, $query);
$teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return teachers as an array
echo json_encode($teachers);
?>
