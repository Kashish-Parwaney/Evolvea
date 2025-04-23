<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'learner') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Learner Dashboard | Evolvea</title>
</head>
<body>
  <h1>Welcome, <?php echo $_SESSION['username']; ?> (Learner)</h1>
  <p>This is your dashboard. Learn and grow!</p>
  <a href="../Backend/logout.php">Logout</a>
</body>
</html>
