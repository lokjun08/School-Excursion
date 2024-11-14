<?php
include 'db_connect.php';

$id = $_POST['id'];

$query = "DELETE FROM excursions WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Excursion deleted successfully.";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
