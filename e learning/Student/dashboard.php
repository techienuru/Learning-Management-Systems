<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["student_id"])) {
    header("location:../login.php");
} else {
    $student_id = $_SESSION["student_id"];

    $selecting_user_details = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id=$student_id");
    $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);
    $fullname = "$fetching_user_details[firstname]  $fetching_user_details[lastname]";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>E learning || Platform</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
      </div>
      
    </nav>
    <!-- partial -->
    
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close typcn typcn-times"></i>
        <div class="tab-content" id="setting-content">
          <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
          </div>
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="courses.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">My Courses</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="course-material.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">My Resources</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="classes.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Class Notification</span>
            </a>
          </li>
    
          <li class="nav-item">
            <a class="nav-link" href="assignment.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Home Work</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="grade.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">My scores</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">logout</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

        <div class="container-fluid py-5">
  <div class="row">
    <div class="col-12 mb-4">
      <h2 class="text-uppercase text-center fw-bold">Dashboard</h2>
      <p class="text-muted text-center">Your one-stop overview of courses, notifications, and materials</p>
    </div>
  </div>

  <div class="row g-4">
    <!-- Course Overview Card -->
    <div class="col-md-4">
      <div class="card bg-gradient-primary text-white shadow-sm h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <h4 class="fw-bold">Course Overview</h4>
          <p class="mb-4">Overview of all your registered courses.</p>
          <a href="./courses.php" class="btn btn-outline-light w-100">View Courses</a>
        </div>
      </div>
    </div>

    <!-- Class Notification Card -->
    <div class="col-md-4">
      <div class="card bg-gradient-info text-white shadow-sm h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <h4 class="fw-bold">Class Notification</h4>
          <p class="mb-4">Get notified about new class updates and alerts.</p>
          <a href="./classes.php" class="btn btn-outline-light w-100">Check Notifications</a>
        </div>
      </div>
    </div>

    <!-- Available Materials Card -->
    <div class="col-md-4">
      <div class="card bg-gradient-success text-white shadow-sm h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <h4 class="fw-bold">Available Materials</h4>
          <p class="mb-4">Access all course-related materials here.</p>
          <a href="./course-material.php" class="btn btn-outline-light w-100">View Materials</a>
        </div>
      </div>
    </div>
  </div>
</div>

          
          

          

        </div>
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="../vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

