<?php
include 'db_connect.php';

$id = $_GET['id'];
$query = "SELECT * FROM excursions WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode($result->fetch_assoc());

$stmt->close();
$conn->close();
?>
