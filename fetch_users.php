<?php
// Include your database connection
include('db_connect.php');

// Check if filters are set
$name = $_GET['name'] ?? '';
$email = $_GET['email'] ?? '';
$role = $_GET['role'] ?? '';

// Construct the SQL query
$query = "SELECT id, name, email, role FROM users WHERE 1=1";
$params = [];
$types = '';

if ($name) {
    $query .= " AND name LIKE ?";
    $params[] = "%$name%";
    $types .= 's';
}
if ($email) {
    $query .= " AND email LIKE ?";
    $params[] = "%$email%";
    $types .= 's';
}
if ($role) {
    $query .= " AND role = ?";
    $params[] = $role;
    $types .= 's';
}

// Prepare and execute the query
if ($stmt = $conn->prepare($query)) {
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Return the data as JSON
    echo json_encode($users);

    $stmt->close();
} else {
    // Output error for debugging
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();

?>
