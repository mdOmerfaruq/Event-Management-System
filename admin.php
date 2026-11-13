<?php
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Admin Dashboard - Event Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="owl.carousel.min.css">
    <link rel="stylesheet" href="owl.theme.default.min.css">
    <link rel="stylesheet" href="magnific-popup.css">
    <link rel="stylesheet" href="aos.css">
    <link rel="stylesheet" href="ionicons.min.css">
    <link rel="stylesheet" href="bootstrap-datepicker.css">
    <link rel="stylesheet" href="jquery.timepicker.css">
    <link rel="stylesheet" href="flaticon.css">
    <link rel="stylesheet" href="icomoon.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <!-- Admin Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
        <a class="navbar-brand" href="admin_dashboard.html">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="feedback_db.php" class="nav-link">help email</a></li>
            <li class="nav-item"><a href="#manage-event" class="nav-link">Manage Events</a></li>
            <li class="nav-item"><a href="All_event.php" class="nav-link">view Events</a></li>
            <li class="nav-item"><a href="admin_action.php" class="nav-link">Faculty Info</a></li>
            <li class="nav-item"><a href="#manage-users" class="nav-link">Manage Users</a></li>
            <li class="nav-item"><a href="#reports" class="nav-link">Reports</a></li>
            <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
              <li class="nav-item text-black mt-2 mr-3">
                <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>
              </li>
            <?php endif; ?>

            <li class="nav-item cta mr-md-2"><a href="logout_db.php" class="nav-link">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Admin Dashboard Section -->
    <section class="hero-wrap js-fullheight" style="background-image: url('images/admin_bg.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-xl-12 ftco-animate">
            <h1 class="mb-4">Welcome, Admin</h1>
            <p>Manage your events, users, and reports effectively from this dashboard.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Manage Events Section -->
    <section class="section" id="manage-events">
      <div class="container">
        <h2 class="text-center mb-4">Manage Events</h2>
        <p class="text-center">Create, update, or delete events seamlessly.</p>
        <div class="text-center">
          <a href="admin_add_event.php" class="btn btn-primary">Go to Events</a>
        </div>
      </div>
    </section>
    <section class="section" id="manage-users">
      <div class="container">
        <h2 class="text-center mb-4">Manage Users</h2>
        <p class="text-center">View, add, or remove users from the system.</p>
        <div class="text-center">
          <a href="admin_users_add.php" class="btn btn-primary">Go to Users</a>
        </div>
      </div>
    </section>
    <section class="section" id="reports">
      <div class="container">
        <h2 class="text-center mb-4">View Reports</h2>
        <p class="text-center">Generate and view event reports for analysis.</p>
        <div class="text-center">
          <a href="admin_reports.php" class="btn btn-primary">Go to Reports</a>
        </div>
      </div>
    </section>
    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
