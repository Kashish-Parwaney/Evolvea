<?php
$conn = new mysqli("localhost", "root", "", "evolvea_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (email, username, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $email, $username, $hashedPassword, $role);

if ($stmt->execute()) {
    // ✅ Redirect to login page
    header("Location: ../Frontend/login.html");
    exit(); // always exit after a redirect
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
