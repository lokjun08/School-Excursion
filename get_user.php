<?php
include 'db_connect.php';

$id = $_GET['id'];

$sql = "SELECT id, name, email, role FROM users WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode($user);
} else {
    echo json_encode(["error" => "User not found"]);
}

$conn->close();
?>
