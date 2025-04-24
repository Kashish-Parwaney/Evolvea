<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'learner') {
    header("Location: ../Frontend/login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "evolvea_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current user’s ID
$username = $_SESSION['username'];
$user_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
$user_query->bind_param("s", $username);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
$user_id = $user['id'];

// Get courses and progress
$sql = "
    SELECT c.title, c.description, e.progress
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    WHERE e.user_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Learner Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Miltonian+Tattoo&family=Oxygen:wght@300;400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alegreya:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="global.css">
  
    <style>
        h1 {
            font-family: 'Miltonian Tattoo', serif;
        }
        h2 {
            font-family: 'Bree Serif', serif;
            font-size: 2.75rem;
        }
        h3, h4 {
            font-family: 'Arial', sans-serif;
            word-spacing: 3px;
        }
        p {
            font-family: 'Alegreya', serif;
        }
        .btn {
            font-family: 'Montserrat', sans-serif;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            color: #fff;
        }
        .btn1 {
            background-color: blueviolet;
        }
        .btn1:hover {
            background-color: rgb(0, 179, 255);
            cursor: pointer;
        }
        #profile-btn img {
            transition: 0.3s ease-in-out;
        }
        #profile-btn:hover img {
            transform: scale(1.1);
        }
        .dashboard {
            max-width: 700px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
        }
        .course {
            background: #f9f9f9;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
        }
        .progress-bar {
            background: #ddd;
            border-radius: 20px;
            overflow: hidden;
        }
        .progress {
            height: 20px;
            background: #5cb85c;
            text-align: center;
            color: white;
            width: 0;
            line-height: 20px;
            font-size: 12px;
        }
        .logout {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            float: right;
        }
    </style>
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-end align-items-center">
            <h1 class="h1 me-auto">EVOLVEA</h1>
            <nav class="d-flex">
                <a href="index.html" class="btn btn-outline-light me-3">Home</a>
                <a href="Courses.html" target="_blank" class="btn btn-outline-light me-3">Courses</a>
                <a href="About.html" target="_blank" class="btn btn-outline-light me-3">About Us</a>
                <a href="Careers.html#Contact" target="_blank" class="btn btn-outline-light">Contact</a>
            </nav>
            <a href="login.html">
                <button class="btn btn rounded-circle ms-3" id="profile-btn">
                    <img src="eIMAGES/Profile.png" alt="Profile" width="40">
                </button>
            </a>
        </div>
    </header>

    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Here’s your course progress:</p>

        <?php if (count($courses) === 0): ?>
            <p>You are not enrolled in any courses yet.</p>
        <?php else: ?>
          <table class="course-table">
    <thead>
        <tr>
            <th>Course Title</th>
            <th>Description</th>
            <th>Progress</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo htmlspecialchars($course['title']); ?></td>
                <td><?php echo htmlspecialchars($course['description']); ?></td>
                <td>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $course['progress']; ?>%;">
                            <?php echo $course['progress']; ?>%
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <?php endif; ?>

        <a href="../Backend/logout.php" class="logout">Logout</a>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
                <!-- ABOUT Section -->
                <div class="col">
                    <h5>ABOUT</h5>
                    <ul class="list-unstyled">
                        <li><a href="About.html" target="_blank" class="text-white text-decoration-none">About Us</a></li>
                        <li><a href="Careers.html" target="_blank" class="text-white text-decoration-none">Careers</a></li>
                        <li><a href="Careers.html#Contact" target="_blank" class="text-white text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <!-- Technical Courses Section -->
                <div class="col">
                    <h5>Technical Courses</h5>
                    <ul class="list-unstyled">
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Web Development</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Data Science</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Cloud Computing</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Cyber Security</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">DevOps</a></li>
                    </ul>
                </div>
                <!-- Non-Technical Courses Section -->
                <div class="col">
                    <h5>Non-Technical Courses</h5>
                    <ul class="list-unstyled">
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Communication</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Cooking & Baking</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Creative Writing</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Fashion Designing</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Crochet & Stitching</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Fitness & Yoga</a></li>
                    </ul>
                </div>
                <!-- Specialization Section -->
                <div class="col">
                    <h5>Specialization</h5>
                    <ul class="list-unstyled">
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Photography</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Web Development 101</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Music Production</a></li>
                        <li><a href="course-desc.html" class="text-white text-decoration-none">Digital Marketing</a></li>
                    </ul>
                </div>
                <!-- Legal Section -->
                <div class="col">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="Copyright.html" class="text-white text-decoration-none" target="_blank">Copyrights</a></li>
                        <li><a href="Copyright.html#Attributions" class="text-white text-decoration-none" target="_blank">Attributions</a></li>
                    </ul>
                </div>
                <!-- Help Section -->
                <div class="col">
                    <h5>Help</h5>
                    <ul class="list-unstyled">
                        <li><a href="FAQs.html" class="text-white text-decoration-none" target="_blank">FAQs</a></li>
                        <li><a href="FAQs.html#Feedback" target="_blank" class="text-white text-decoration-none">Feedback</a></li>
                    </ul>
                </div>
            </div>
            <hr class="custom-hr my-4">
            <br>
            <div class="d-flex justify-content-center align-items-center position-relative">
                <!-- EVOLVEA Centered -->
                <h1 class="h3 mb-0 position-absolute top-50 start-50 translate-middle">EVOLVEA</h1>
                <!-- Social Media Icons Aligned to the Right -->
                <div class="position-absolute end-0">
                    <a href="#"> <img src="eIMAGES/Screenshot 2025-03-29 190727.png" class="img-fluid rounded me-3" width="55" alt="YouTube"></a>
                    <a href="#"> <img src="eIMAGES/Screenshot 2025-03-29 175145.png" class="img-fluid rounded me-3" width="45" alt="Instagram"></a>
                    <a href="#"> <img src="eIMAGES/Screenshot 2025-03-29 190831.png" class="img-fluid rounded" width="40" alt="Facebook"></a>
                </div>
            </div>
            <div class="text-center mt-3">
                <p class="mb-0">&copy; 2025 Evolvea. All Rights Reserved</p>
            </div>
        </div>
    </footer>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>