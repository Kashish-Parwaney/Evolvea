document.addEventListener("DOMContentLoaded", function () {
    const enrollButtons = document.querySelectorAll(".enroll-btn");
  
    enrollButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const courseTitle = this.getAttribute("data-course");
  
        // Get previous courses from localStorage
        let enrolledCourses = JSON.parse(localStorage.getItem("enrolledCourses")) || [];
  
        // Add new course
        enrolledCourses.push(courseTitle);
  
        // Save back to localStorage
        localStorage.setItem("enrolledCourses", JSON.stringify(enrolledCourses));
  
        // Redirect to dashboard
        window.location.href = "dashboard.html";
      });
    });
  });
  