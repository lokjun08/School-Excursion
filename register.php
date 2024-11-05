<?php
// Start the session
session_start();

// Include the database connection file
include 'db_connect.php'; // Ensure the path is correct

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! You can now sign in.";
            header("Location: login.html"); // Redirect to login page
            exit();
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error; // Capture error
        }
        $stmt->close(); // Close the statement
    } else {
        $_SESSION['error'] = "Please fill in all fields with valid data."; // Error message
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <?php
    // Display error messages if any
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']); // Clear the error message
    }
    ?>
</body>
</html>
