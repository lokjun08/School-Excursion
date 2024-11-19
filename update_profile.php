<?php
session_start();
include 'db_connect.php';

$user_id = $_POST['user_id'];
$name = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$profile_picture = $_FILES['profile_picture'];

// Process profile picture upload
$profilePicturePath = '';
if (!empty($profile_picture['name'])) {
    $targetDir = "uploads/profile_pictures/";
    $profilePicturePath = $targetDir . basename($profile_picture["name"]);
    move_uploaded_file($profile_picture["tmp_name"], $profilePicturePath);
}

// Update user information in the database
$sql = "UPDATE users SET name=?, email=?, profile_picture=?";
$params = [$name, $email, $profilePicturePath ?: null];

if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql .= ", password=?";
    $params[] = $hashedPassword;
}

$sql .= " WHERE id=?";
$params[] = $user_id;

$stmt = $conn->prepare($sql);
$stmt->execute($params);

if ($stmt->affected_rows > 0) {
    echo "Profile updated successfully.";
} else {
    echo "Error updating profile.";
}
?>
