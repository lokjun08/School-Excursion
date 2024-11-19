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

        // Display a success alert and redirect based on role
        echo "<script>
            alert('Login successful!');

            // Redirect based on the user's role
            switch ('{$user['role']}') {
                case 'admin':
                    window.location.href = 'adminpage.php';
                    break;
                case 'teacher':
                    window.location.href = 'teacherpage.php';
                    break;
                case 'parent':
                    window.location.href = 'parentpage.php';
                    break;
                default:
                    window.location.href = 'login.html'; // Redirect to homepage if role is undefined
                    break;
            }
        </script>";
        exit();
    } else {
        // Invalid login
        echo "<script>alert('Invalid email or password.');</script>";
        echo "<script>window.location.href = 'login.html';</script>"; // Redirect to login page
        exit();
    }
    $stmt->close();
}
$conn->close();
?>
