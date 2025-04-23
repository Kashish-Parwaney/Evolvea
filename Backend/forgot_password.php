<?php
// forgot_password.php
session_start();
$conn = new mysqli("localhost", "root", "", "evolvea_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, generate a reset token
        $token = bin2hex(random_bytes(50)); // Unique reset token
        
        // Store the token in the database temporarily with expiration time
        $expire = time() + 3600; // 1 hour expiration time
        $sql = "UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $token, $expire, $email);
        $stmt->execute();

        // Send password reset email with the token
        $reset_link = "http://yourdomain.com/Frontend/reset_password.php?token=" . $token;
        
        // Use PHP's mail() function or an email service (like PHPMailer) to send the email
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: " . $reset_link;
        mail($email, $subject, $message);

        echo "Check your email for the password reset link.";
    } else {
        echo "No account found with that email.";
    }
}
$conn->close();
?>
