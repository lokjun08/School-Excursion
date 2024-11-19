<?php
// Include database connection
include('db_connect.php');

// Check if the user is updating
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['id'];
    $userName = $_POST['name'];
    $userEmail = $_POST['email'];
    $userRole = $_POST['role'];

    // Update the user in the database
    $query = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $userName, $userEmail, $userRole, $userId);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'User updated successfully']);
    } else {
        echo json_encode(['message' => 'Failed to update user']);
    }

    $stmt->close();
    $conn->close();
}
?>
