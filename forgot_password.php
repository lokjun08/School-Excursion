<?php
// Start the session
session_start();

// Include the database connection file
include 'db_connect.php'; // Ensure your database connection file is correct

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure this path is correct

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate the email address
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the email exists
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

        if (mysqli_num_rows($result) > 0) {
            // Generate a unique token
            $token = bin2hex(random_bytes(50));
            $expiry = date("Y-m-d H:i:s", strtotime("+8 hour"));

            // Update the database with the token
            $stmt = $conn->prepare("UPDATE users SET reset_token=?, token_expiry=? WHERE email=?");
            $stmt->bind_param("sss", $token, $expiry, $email);
            $stmt->execute();
            $stmt->close();

            // Send the reset link via email using PHPMailer
            $resetLink = "http://localhost/School Excursion/reset_password.php?token=$token";
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth   = true; // Enable SMTP authentication
                $mail->Username   = 'aujenlee6544@gmail.com'; // SMTP username
                $mail->Password   = 'jurj sgjp wpaz xkit'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                $mail->Port       = 587; // TCP port to connect to

                // Recipients
                $mail->setFrom('schoolexcursion@gmail.com', 'School Excursion'); // Your email and name
                $mail->addAddress($email); // Add a recipient

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Click this link to reset your password: <a href='$resetLink'>$resetLink</a>";

                $mail->send();
                $_SESSION['success'] = "Reset link sent to your email.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['error'] = "Email not found.";
        }
    } else {
        $_SESSION['error'] = "Invalid email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forgot.css">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="">
    <h2>Reset Your Password</h2>
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send Reset Link</button>
</form>

    <?php
    // Display success/error messages
    if (isset($_SESSION['success'])) {
        echo "<p class='success-message'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>
    <a href="login.html" class="back-link">Back to Login</a>
</body>
</html>

