<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
  header("location:../login.php");
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
            <a class="nav-link" href="students.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Students request</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="add-lecturer.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Create tutors </span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="view-lecturer.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">View tutors</span>
            </a>
          </li>
    
          <li class="nav-item">
            <a class="nav-link" href="courses.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Create Courses</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="assign-course.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Course Assingment</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Sign out</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

        <div class="row">
    <div class="col-12 grid-margin stretch-card flex-column">
        <h5 class="mb-2 text-titlecase mb-4">Dashboard Overview</h5>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <!-- Additional Content if Needed -->
                        </div>

                        <div class="content-wrapper">
                            <div class="row mt-4">
                                <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card shadow-lg rounded bg-gradient-primary text-white">
                                        <div class="card-body">
                                            <h4 class="font-weight-bold mb-3">Lecturer Overview</h4>
                                            <p class="card-text">Total registered lecturers on the platform</p>
                                            <h3 class="display-4"><?php echo $no_of_lecturers; ?></h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card shadow-lg rounded bg-gradient-info text-white">
                                        <div class="card-body">
                                            <h4 class="font-weight-bold mb-3">Pending Registration Requests</h4>
                                            <p class="card-text">Students awaiting approval for registration</p>
                                            <h3 class="display-4"><?php echo $no_of_pending_requests; ?></h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card shadow-lg rounded bg-gradient-success text-white">
                                        <div class="card-body">
                                            <h4 class="font-weight-bold mb-3">Total Registered Students</h4>
                                            <p class="card-text">Count of all students registered on this platform</p>
                                            <h3 class="display-4"><?php echo $no_of_students; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




                    </div>
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

