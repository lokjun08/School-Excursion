<?php
include 'db_connect.php';

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$role = $_POST['role'];

$sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "User updated successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
