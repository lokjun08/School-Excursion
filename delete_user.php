<?php
include 'db_connect.php';

$id = $_POST['id'];

$sql = "DELETE FROM users WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "User deleted successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
