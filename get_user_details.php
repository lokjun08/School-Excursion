<?php
session_start();
include 'db_connect.php';

// Assuming user ID is stored in session after login
$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT name, email, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode($user);
} else {
    echo json_encode(['error' => 'User not found']);
}
?>
