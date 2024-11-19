<?php
header('Content-Type: application/json'); // Ensure JSON response header

$id = $_GET['id'] ?? null;

// Debugging to see what ID is being received
if (!$id) {
    echo json_encode(['error' => 'Invalid ID', 'received_id' => $_GET['id'] ?? null]);
    exit;
}

$id = intval($id);

include('db_connect.php');

$query = "SELECT id, name, email, role FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $user['role'] = strtolower($user['role']);
    echo json_encode($user);
} else {
    echo json_encode(['error' => 'User not found']);
}

$stmt->close();
$conn->close();

?>
