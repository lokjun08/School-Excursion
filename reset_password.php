<?php
require 'db_connect.php';

$message = '';
$messageClass = ''; // CSS class for message styling

if (isset($_GET['token']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_GET['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Verify the token and expiry using MySQLi
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Update the password and clear the token
        $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
        $stmt->bind_param("si", $new_password, $user['id']);
        $stmt->execute();
        
        $message = "Password has been reset successfully.";
        $messageClass = "message-success";
    } else {
        $message = "Invalid or expired token.";
        $messageClass = "message-error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <title>Reset Password</title>
</head>
<body>
    <div class="reset-container">
        <h1>Reset Your Password</h1>
        <p>Enter a new password below to reset your account password.</p>
        <form method="POST" action="">
        <div class="input-group">
            <input type="password" name="new_password" placeholder="Enter New Password" required>
            <span class="toggle-password" onclick="togglePassword('new_password')"><i class="fa fa-eye"></i></span>
            <div class="error" id="password-error"></div> <!-- Error div for new password -->
        </div>

        <div class="input-group">
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <span class="toggle-password" onclick="togglePassword('confirm_password')"><i class="fa fa-eye"></i></span>
            <div class="error1" id="confirm-error"></div> <!-- Error div for confirm password -->
        </div>

            <button type="submit">Reset Password</button>
        </form>

        <!-- Success/Error Message Display -->
        <?php if ($message): ?>
            <div class="<?php echo $messageClass; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <p><a href="login.html" class="back-link">Back to Login</a></p>
    </div>
    <script>
       function togglePassword(fieldName) {
    const passwordField = document.querySelector(`input[name="${fieldName}"]`);
    const eyeIcon = passwordField.nextElementSibling.querySelector('i'); // 确保选择到图标
    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);

    // 更换图标样式
    eyeIcon.classList.toggle("fa-eye-slash");
    eyeIcon.classList.toggle("fa-eye");
}



        document.querySelector("form").addEventListener("submit", function(event) {
            const password = document.querySelector('input[name="new_password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            const passwordCriteria = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            let valid = true;

            // Check password criteria
            if (!passwordCriteria.test(password)) {
                document.getElementById("password-error").textContent = "*Password must contain at least 8 characters, including a capital letter, a symbol, a lowercase letter, and a number.";
                valid = false;
            } else {
                document.getElementById("password-error").textContent = "";
            }

            // Check if passwords match
            if (password !== confirmPassword) {
                document.getElementById("confirm-error").textContent = "*Passwords do not match.";
                valid = false;
            } else {
                document.getElementById("confirm-error").textContent = "";
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
