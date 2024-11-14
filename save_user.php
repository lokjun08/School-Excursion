<?php
include 'db_connect.php';

$id = $_POST['id'] ?? '';
$name = $_POST['name'];
$email = $_POST['email'];
$role = $_POST['role'];

if ($id) {
    // Update existing user
    $query = "UPDATE users SET name = '$name', email = '$email', role = '$role' WHERE id = $id";
} else {
    // Insert new user
    $query = "INSERT INTO users (name, email, role) VALUES ('$name', '$email', '$role')";
}

mysqli_query($conn, $query);

echo json_encode(["success" => true]);
?>
