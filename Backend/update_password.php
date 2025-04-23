<?php
// update_password.php
if (isset($_POST['token']) && isset($_POST['password'])) {
    $token = $_POST['token'];
    $new_password = $_POST['password'];
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password

    // Update the password in the database
    $conn = new mysqli("localhost", "root", "", "evolvea_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Your password has been updated successfully. You can now log in with your new password.";
    } else {
        echo "Failed to update password.";
    }

    $conn->close();
}
?>
