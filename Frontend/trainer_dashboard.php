<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'trainer') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Trainer Dashboard | Evolvea</title>
</head>
<body>
  <h1>Welcome, <?php echo $_SESSION['username']; ?> (Trainer)</h1>
  <p>This is your dashboard. Share your skills!</p>
  <a href="../Backend/logout.php">Logout</a>
</body>
</html>
