<?php
session_start();
include 'db_connect.php'; // Assumes you have a database connection setup here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user based on the email provided
    $query = "SELECT id, name, role, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Store user information in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                header("Location: adminpage.php");
                break;
            case 'teacher':
                header("Location: teacherpage.php");
                break;
            case 'parent':
                header("Location: parentpage.php");
                break;
            default:
                header("Location: login.html"); // Redirect to homepage if role is undefined
                break;
        }
        exit();
    } else {
        // Invalid login
        echo "Invalid email or password.";
    }
    $stmt->close();
}
$conn->close();
?>
