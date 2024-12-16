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
  <style>
    /* Class Item Styles */
    .class-item {
      background: rgba(172, 54, 172, 0.637);
      border-radius: 5px;
      padding: 30px;
      margin: 30px 0px 20px 0px;
    }

    .class-item h4 {
      margin-bottom: 10px;
    }

    .class-item p {
      margin: 5px 0;
    }

    .class-item .btn {
      margin-right: 10px;
      margin-top: 10px;
    }
  </style>
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
  <div class="row justify-content-center">
    <div class="col-lg-10 stretch-card">
      <div class="card bg-gradient-dark text-light shadow-lg">
        <div class="card-body">
          <h1 class="text-center mb-4">Your Classes</h1>
          <div id="classes-list">
            <?php
            $selecting_students_course = mysqli_query($connect, "SELECT * FROM `student_course` WHERE student_id=$student_id");
            $registered_course = [];
            while ($fetching_students_course = mysqli_fetch_assoc($selecting_students_course)) {
              array_push($registered_course, $fetching_students_course["course_id"]);
            }
            $registered_course = implode(",", $registered_course);

            $selecting_classes = mysqli_query($connect, "SELECT * FROM `class` INNER JOIN `course` ON `class`.course_id = `course`.course_id WHERE `class`.course_id IN ($registered_course) ORDER BY class_date, class_time");

            while ($fetching_classes = mysqli_fetch_assoc($selecting_classes)) {
              $class_id = $fetching_classes["class_id"];
              $course_code = $fetching_classes["course_code"];
              $course_title = $fetching_classes["course_title"];
              $class_date = $fetching_classes["class_date"];
              $class_time = $fetching_classes["class_time"];
              $online_link = $fetching_classes["online_link"];

              echo "
              <div class='class-item border-bottom py-3'>
                <h4 class='fw-bold'>$course_title</h4>
                <p><strong>Course Code:</strong> $course_code</p>
                <p><strong>Date & Time:</strong> $class_date at $class_time</p>
                <button class='btn btn-outline-light' data-bs-toggle='modal' data-bs-target='#class-modal-$class_id'>
                  Join Online Class
                </button>
              </div>";

              ## Modal Structure
              echo "
              <div class='modal fade' id='class-modal-$class_id' tabindex='-1'>
                <div class='modal-dialog modal-dialog-centered modal-lg'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title'>$course_title</h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                      <div class='ratio ratio-16x9'>
                        <iframe src='$online_link' allowfullscreen></iframe>
                      </div>
                    </div>
                  </div>
                </div>
              </div>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- partial -->
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

