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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Trainer Dashboard | Evolvea</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/global.css">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .content {
      margin-left: 0;
      margin-top: 1rem;
      padding: 1rem;
      flex: 1;
    }
  </style>
</head>
<body>
  <div id="header"></div>

  <!-- Main content -->
  <main class="content">
    <div class="container-fluid">
      <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
      <p class="lead mb-4">This is your personal dashboard to manage your trainings and schedule. Share your skills and keep growing!</p>

      <div class="row mb-4">
        <!-- Cards -->
        <div class="col-md-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
              <h3 class="card-title mb-0">5</h3>
              <p class="card-text">Upcoming Trainings</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
          <div class="card text-white bg-success h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
              <h3 class="card-title mb-0">12</h3>
              <p class="card-text">Registered Learners</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
              <h3 class="card-title mb-0">3</h3>
              <p class="card-text">Pending Requests</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
          <div class="card text-white bg-info h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
              <h3 class="card-title mb-0">8</h3>
              <p class="card-text">Skills Shared</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Video Upload Form -->
      <div class="card mb-4">
        <div class="card-header custom-bg2">
          <h5 class="mb-0">Upload Training Video</h5>
        </div>
        <div class="card-body">
          <form action="upload_video.php" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-12">
              <label for="videoFile" class="form-label">Choose a video file</label>
              <input class="form-control" type="file" id="videoFile" name="videoFile" accept="video/*" required>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary">Upload Video</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Uploaded Courses Section -->
     <div class="card custom-bg2">
    <div class="card-header">
        <h5 class="mb-0">Uploaded Courses</h5>
    </div>
    <div class="card-body custom-bg">
        <ul class="list-group">
            <li class="list-group-item d-flex align-items-center custom-bg">
                <img src="eIMAGES\Web d.png" 
                     alt="Course Title 1" 
                     class="thumbnail me-3" style="width: 300px; height: auto;">
                <div class="flex-grow-1">
                    <h6>Course Title 1</h6>
                    <p class="mb-1">Views: 100</p>
                    <a href="link/to/your/video1" class="btn btn-link" target="_blank">Watch Video</a>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-center custom-bg">
                <img src="eIMAGES\digitaLMARK.png" 
                     alt="Course Title 2" 
                     class="thumbnail me-3" style="width: 300px; height: auto;">
                <div class="flex-grow-1">
                    <h6>Course Title 2</h6>
                    <p class="mb-1">Views: 200</p>
                    <a href="link/to/your/video2" class="btn btn-link" target="_blank">Watch Video</a>
                </div>
            </li>
            <!-- Add more courses as needed -->
        </ul>
    </div>
</div>

  </main>

  <!-- Footer and Scripts -->
  <div id="footer"></div>
  <script src="js/Learner.js"></script>
  <script src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>