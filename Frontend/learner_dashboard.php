<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'learner') {
    header("Location: login.html");
    exit();
}

$courses = [
    [
        'title' => 'Introduction to Programming',
        'instructor' => 'John Doe',
        'enrollment_date' => '2023-01-15',
        'progress' => 75,
        'status' => 'In Progress'
    ],
    [
        'title' => 'Web Development Basics',
        'instructor' => 'Jane Smith',
        'enrollment_date' => '2023-02-10',
        'progress' => 50,
        'status' => 'In Progress'
    ],
    [
        'title' => 'Data Science Fundamentals',
        'instructor' => 'Alice Johnson',
        'enrollment_date' => '2023-03-05',
        'progress' => 100,
        'status' => 'Completed'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Learner Dashboard | Evolvea</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Miltonian+Tattoo&family=Oxygen:wght@300;400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/global.css">
  <style>
    body {
      font-family: 'Oxygen', sans-serif;
    }

    .course-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .course-card {
      background-color: #D4BB98;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      transition: transform 0.2s ease-in-out;
    }

    .course-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
    }

    .circular-progress {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      position: relative;
      margin: 20px auto;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #e0e0e0;
    }

    .inner-circle {
      position: absolute;
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background-color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .percentage {
      position: relative;
      font-weight: bold;
      font-size: 1rem;
      color: #333;
    }

    a {
      display: inline-block;
      margin-top: 30px;
      text-decoration: none;
      font-weight: bold;
      color: #dc3545;
    }

    a:hover {
      text-decoration: underline;
    }

    .streak-wrapper {
      display: flex;
      justify-content: center;
      margin-top: 40px;
    }

    .streak-tracker {
      background-color: #fff8e1;
      border: 1px solid #ffb300;
      padding: 25px;
      border-radius: 16px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(255, 179, 0, 0.2);
      max-width: 400px;
    }

    .day-circles {
      display: flex;
      justify-content: space-between;
      margin: 15px 0;
    }

    .day {
      width: 35px;
      height: 35px;
      background-color: #eee;
      border-radius: 50%;
      line-height: 35px;
      font-weight: bold;
      color: #555;
      transition: background-color 0.3s ease;
    }

    .day.completed {
      background-color: #ffb300;
      color: white;
    }

    h2, h3, h4 {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div id="header"></div>

<div class="container mt-4 text-center">
  <h2 class="fw-bold">Welcome, <?php echo $_SESSION['username']; ?> (Learner)</h2>
  <h4>This is your dashboard. Learn and grow!</h4>
</div>

<div class="container">
  <div class="streak-wrapper">
    <div class="streak-tracker">
      <h4>Your Weekly Streak 🔥</h4>
      <div class="day-circles">
        <div class="day completed">S</div>
        <div class="day completed">M</div>
        <div class="day completed">T</div>
        <div class="day">W</div>
        <div class="day">T</div>
        <div class="day">F</div>
        <div class="day">S</div>
      </div>
      <p id="streak-count">Loading...</p>
    </div>
  </div>
</div>

<div class="container">
  <section class="courses text-center">
    <h3>Your Enrolled Courses</h3>
    <div class="course-list">
      <?php foreach ($courses as $course): ?>
        <div class="course-card">
          <h3><?php echo $course['title']; ?></h3>
          <p>Instructor: <?php echo $course['instructor']; ?></p>
          <p>Enrollment Date: <?php echo $course['enrollment_date']; ?></p>
          <div class="circular-progress" 
               data-percentage="<?php echo $course['progress']; ?>" 
               data-progress-color="#007bff" 
               data-bg-color="#e0e0e0" 
               style="background: conic-gradient(#007bff <?php echo $course['progress'] * 3.6; ?>deg, #e0e0e0 <?php echo $course['progress'] * 3.6; ?>deg);">
            <div class="inner-circle">
              <p class="percentage"><?php echo $course['progress']; ?>%</p>
            </div>
          </div>
          <p>Status: <?php echo $course['status']; ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</div>

<div class="d-flex justify-content-center mt-4">
  <a href="../Backend/logout.php" class="btn btn-danger">Logout</a>
</div>

<div id="footer"></div>

<script>
// Helper function to format date as YYYY-MM-DD
function getTodayDate() {
    const today = new Date();
    return today.toISOString().split('T')[0];
}

const today = getTodayDate();
const lastLogin = localStorage.getItem("lastLoginDate");
let streak = parseInt(localStorage.getItem("loginStreak") || "0");

if (lastLogin === today) {
    document.getElementById("streak-count").textContent = `${streak} day streak`;
} else {
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    const yesterdayStr = yesterday.toISOString().split('T')[0];

    if (lastLogin === yesterdayStr) {
        streak += 1;
    } else {
        streak = 1;
    }

    localStorage.setItem("lastLoginDate", today);
    localStorage.setItem("loginStreak", streak);
    document.getElementById("streak-count").textContent = `${streak} day streak`;
}
</script>

<script src="js/Learner.js"></script>
<script src="js/main.js"></script>
</body>
</html>