<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Prepare and execute SQL statement to find the user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['login_success'] = true;
            header("Location: logged.html"); // Redirect to dashboard or desired page
            exit();
        } else {
            $_SESSION['login_success'] = false;
            $_SESSION['error'] = "Incorrect password. Please try again.";
            header("Location: login.html?status=failed"); // Redirect with failure status
            exit();
        }
    } else {
        $_SESSION['login_success'] = false;
        $_SESSION['error'] = "No account found with that email.";
        header("Location: login.html?status=failed"); // Redirect with failure status
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.html"); // Redirect if accessed directly
    exit();
}
?>
