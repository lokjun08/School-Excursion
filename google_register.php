<?php
// Include the database connection
include('db_connect.php');

// Get the JSON input from the fetch request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['name']) && isset($data['email'])) {
    $name = $data['name'];
    $email = $data['email'];

    // Check if the email already exists in the database
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists, return success without inserting again
        echo json_encode(['success' => true, 'message' => 'User already exists.']);
    } else {
        // Insert new user into the database
        $password = password_hash('defaultPassword123', PASSWORD_DEFAULT); // Generate a hashed password
        $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('sss', $name, $email, $password);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User registered successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error registering user.']);
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>

