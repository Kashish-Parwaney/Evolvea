<?php
session_start();
$conn = new mysqli("localhost", "root", "", "evolvea_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

// Get user from DB
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // ✅ Use password_verify instead of direct comparison
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'learner') {
            header("Location: ../Frontend/learner_dashboard.php");
        } elseif ($user['role'] === 'trainer') {
            header("Location: ../Frontend/trainer_dashboard.php");
        } else {
            echo "Unknown role.";
        }
        exit();
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "No user found.";
}

$conn->close();
?>
