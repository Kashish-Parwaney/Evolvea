<?php
// reset_password.php
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    // Verify if the token exists and is still valid (not expired)
    $conn = new mysqli("localhost", "root", "", "evolvea_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE reset_token = ? AND token_expiry > ?";
    $stmt = $conn->prepare($sql);
    $current_time = time();
    $stmt->bind_param("si", $token, $current_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, show the password reset form
        ?>
        <form action="../Backend/update_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <label for="password">New Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Reset Password</button>
        </form>
        <?php
    } else {
        echo "Invalid or expired token.";
    }
    $conn->close();
}
?>
