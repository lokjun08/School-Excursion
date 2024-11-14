<?php
include 'db_connect.php';

$id = $_POST['id'];
$name = $_POST['name'];
$type = $_POST['type'];
$date = $_POST['date'];
$location = $_POST['location'];
$teacher_id = $_POST['teacher_id'];

if ($id) {
    $sql = "UPDATE excursions SET name=?, type=?, date=?, location=?, teacher_id=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $type, $date, $location, $teacher_id, $id);
} else {
    $sql = "INSERT INTO excursions (name, type, date, location, teacher_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $type, $date, $location, $teacher_id);
}

if ($stmt->execute()) {
    echo "success"; // Just a simple success message for AJAX response
} else {
    echo "error"; // Simple error message
}
$stmt->close();
$conn->close();
?>
