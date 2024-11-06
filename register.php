<?php
// Include the database connection
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Server-side validation: Check if the email exists
    $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>
                alert('Email already exists.');
                window.location.href = 'login.html';
              </script>";
        exit();
    } elseif ($password !== $confirmPassword) {
        // Passwords do not match
        echo "<script>
                alert('Passwords do not match.');
                window.location.href = 'login.html';
              </script>";
        exit();
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $password)) {
        // Password does not meet strength requirements
        echo "<script>
                alert('Password must be at least 8 characters, with uppercase, lowercase, number, and special character.');
                window.location.href = 'login.html';
              </script>";
        exit();
    } else {
        // Proceed with registration (insert user into the database)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Encrypt password
        $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('sss', $name, $email, $hashedPassword);
        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration successful.');
                    window.location.href = 'login.html';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Error: Could not register user.');
                    window.location.href = 'login.html';
                  </script>";
            exit();
        }
    }

    $conn->close();
}
?>
