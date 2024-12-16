<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
  header("location:../signin.php");
} else {
  // For Number Of registered Lecturers
  $selecting_no_of_lecturers = mysqli_query($connect, "SELECT COUNT(lecturer_id) AS no_of_lecturers FROM `lecturer`");
  $fetching_no_of_lecturers = mysqli_fetch_assoc($selecting_no_of_lecturers);
  $no_of_lecturers = $fetching_no_of_lecturers["no_of_lecturers"];

  // For Number Of pending Students requests
  $selecting_no_of_pending_requests = mysqli_query($connect, "SELECT COUNT(student_id) AS no_of_pending_requests FROM `student` WHERE `is_approved?` IS NULL");
  $fetching_no_of_pending_requests = mysqli_fetch_assoc($selecting_no_of_pending_requests);
  $no_of_pending_requests = $fetching_no_of_pending_requests["no_of_pending_requests"];

  // For Number Of registered Students
  $selecting_no_of_students = mysqli_query($connect, "SELECT COUNT(student_id) AS no_of_students FROM `student`");
  $fetching_no_of_students = mysqli_fetch_assoc($selecting_no_of_students);
  $no_of_students = $fetching_no_of_students["no_of_students"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>LMS</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="node_modules/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="node_modules/jquery-bar-rating/dist/themes/css-stars.css">
  <link rel="stylesheet" href="node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" />
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo justify-content-center" href="index.html">
          <h1>LMS</h1>
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link nav-profile" id="profileDropdown" aria-expanded="false">
              <span class="d-none d-lg-inline">Admin</span>
            </a>
          </li>
          <li class="nav-item nav-logout d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-power"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="row row-offcanvas row-offcanvas-right">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="students.php">
                <span class="menu-title">Students</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="add-lecturer.php">
                <span class="menu-title">Add Lecturer</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="view-lecturer.php">
                <span class="menu-title">View Lecturers</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="courses.php">
                <span class="menu-title">Courses</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="assign-course.php">
                <span class="menu-title">Assign Course</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>

          </ul>


          <div class="wrapper upgrade-button">
            <a href="logout.php" class="btn btn-lg btn-block purchase-button">Logout</a>
          </div>
        </nav>
        <!-- partial -->
        <div class="content-wrapper">

          <div class="row mt-4">
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Lecturer Overview</h4>

                  <p class="card-text">overview of all registered Lecturers</p>
                  <h3><?php echo $no_of_lecturers; ?></h3>
                </div>
              </div>
            </div>

            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Pending request to Join Platform</h4>

                  <p class="card-text">Student waiting for approval to be registered</p>
                  <h3><?php echo $no_of_pending_requests; ?></h3>
                </div>
              </div>
            </div>

            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Total number of registered students</h4>

                  <p class="card-text">All student registered on this platform</p>
                  <h3><?php echo $no_of_students; ?></h3>
                </div>
              </div>
            </div>

          </div>
        </div>


        <!-- partial -->
      </div>
      <!-- row-offcanvas ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="node_modules/chart.js/dist/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>