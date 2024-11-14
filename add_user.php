<?php
include 'db_connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash("Password123!", PASSWORD_BCRYPT); // Set default password
$role = $_POST['role'];

$sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    echo "User added successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
