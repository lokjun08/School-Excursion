<?php
require 'db_connect.php';

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
        echo "Password has been reset successfully.";
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!-- HTML Form for Resetting Password -->
<form method="POST" action="">
    <input type="password" name="new_password" placeholder="Enter New Password" required>
    <button type="submit">Reset Password</button>
</form>
