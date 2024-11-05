<?php
// Start the session
session_start();

// Include the database connection file
include 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Prepare and execute SQL statement to find the user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verify if a user exists with that email
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, create session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['success'] = "You are now signed in!";
            header("Location: login1.html?status=success"); // Redirect to login page with success status
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password. Please try again.";
            header("Location: login1.html?status=failed"); // Redirect with failure status
            exit();
        }
    } else {
        $_SESSION['error'] = "No account found with that email.";
        header("Location: login1.html?status=failed"); // Redirect with failure status
        exit();
    }

    // Close statement
    $stmt->close();
}

header("Location: login1.html"); // Redirect to login page if directly accessed
exit();
?>
