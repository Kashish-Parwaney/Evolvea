// Load Header
fetch('header.html')
  .then(response => response.text())
  .then(data => {
    document.getElementById('header').innerHTML = data;
  });

// Load Footer
fetch('footer.html')
  .then(response => response.text())
  .then(data => {
    document.getElementById('footer').innerHTML = data;
  });


  document.addEventListener('DOMContentLoaded', function () {
    const loginLink = document.getElementById('login-link');
    const dashboardLink = document.getElementById('dashboard-link');
    const logoutLink = document.getElementById('logout-link');

    // Read login state from localStorage
    const user = JSON.parse(localStorage.getItem('user'));

    if (user && user.loggedIn) {
        // Hide login, show dashboard + logout
        loginLink.style.display = 'none';
        dashboardLink.style.display = 'block';
        logoutLink.style.display = 'block';

        // Set dashboard link based on role
        if (user.role === 'trainer') {
            dashboardLink.href = 'dashboard_trainer.html';
        } else if (user.role === 'learner') {
            dashboardLink.href = 'dashboard_learner.html';
        }
    } else {
        // Not logged in
        loginLink.style.display = 'block';
        dashboardLink.style.display = 'none';
        logoutLink.style.display = 'none';
    }

    // Logout handler
    logoutLink.addEventListener('click', function () {
        localStorage.removeItem('user');
        window.location.href = 'login.html';
    });
});
