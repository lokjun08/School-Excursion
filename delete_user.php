<?php
// delete_user.php

// Include your database connection
include('db_connect.php');

// Check if the ID is set
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if ($id) {
        // Delete the user with the given ID
        $query = "DELETE FROM users WHERE id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                echo "User deleted successfully!";
            } else {
                echo "Error deleting user: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "User ID is required!";
    }
}

$conn->close();
?>
