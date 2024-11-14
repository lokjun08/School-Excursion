<?php
include 'db_connect.php';

$name = isset($_GET['name']) ? trim($_GET['name']) : '';
$date = isset($_GET['date']) ? trim($_GET['date']) : '';
$teacher = isset($_GET['teacher']) ? trim($_GET['teacher']) : '';

$query = "SELECT excursions.*, teachers.name AS teacher_name FROM excursions 
          LEFT JOIN teachers ON excursions.teacher_id = teachers.id 
          WHERE 1=1";

if (!empty($name)) {
    $name = $conn->real_escape_string($name); // Sanitize input
    $query .= " AND excursions.name LIKE '%$name%'";
}
if (!empty($date)) {
    $date = $conn->real_escape_string($date); // Sanitize input
    $query .= " AND excursions.date = '$date'";
}
if (!empty($teacher)) {
    $teacher = $conn->real_escape_string($teacher); // Sanitize input
    $query .= " AND excursions.teacher_id = '$teacher'";
}

// Debugging: Output the final query (comment this out after testing)
error_log("Query: $query");

$result = $conn->query($query);
if (!$result) {
    error_log("Error in query: " . $conn->error); // Log any SQL errors
    echo json_encode([]);
    exit();
}

$excursions = [];
while ($row = $result->fetch_assoc()) {
    $excursions[] = $row;
}

header('Content-Type: application/json');
echo json_encode($excursions);

$conn->close();
?>
