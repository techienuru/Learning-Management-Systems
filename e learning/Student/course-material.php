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

          <div class="row">
            <div class="col-12 grid-margin stretch-card flex-column">
                <h5 class="mb-2 text-titlecase mb-4">Dashboard</h5>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                      <div class="row">
                      <div class="col-lg-4">
                        <h4>Available Courses</h4>
                        <ul class="list-group" id="course-list">
                          <?php
                          $selecting_registered_courses = mysqli_query($connect, "SELECT * FROM `student_course` INNER JOIN `course` ON `student_course`.course_id = `course`.course_id WHERE student_id = $student_id");
                          while ($row = mysqli_fetch_assoc($selecting_registered_courses)) {
                            $student_course_id = $row["student_course_id"];
                            $course_id = $row["course_id"];
                            $course_code = $row["course_code"];
                            $course_title = $row["course_title"];
                            echo "
                              <a href='course-material.php?student_course_id=$student_course_id'>
                                <li class='list-group-item'>$course_code ($course_title)</li>
                              </a>
                            ";
                          }
                          ?>
                        </ul>
                      </div>
                      <div class="col-lg-8">
                        <?php
                        if (isset($_GET["student_course_id"])) {

                          echo "
                              <h4 id='course-title'>Course Materials</h4>
                          ";

                          $student_course_id = $_GET["student_course_id"];

                          $selecting_the_passed_course_detail = mysqli_query($connect, "SELECT * FROM `student_course` WHERE student_course_id=$student_course_id");
                          $fetching_the_passed_course_detail = mysqli_fetch_assoc($selecting_the_passed_course_detail);
                          $course_id = $fetching_the_passed_course_detail["course_id"];

                          $selecting_course_material = mysqli_query($connect, "SELECT * FROM `course_material` WHERE `course_material`.course_id=$course_id");

                          if (!mysqli_num_rows($selecting_course_material) > 0) {
                            echo "                            
                              <div id='course-materials'
                                <ul class='list-group' id='video-resources'>
                                  <li class='list-group-item'>
                                    No resource available.
                                  </li>
                                </ul>
                              </div>
                          ";
                          }

                          while ($fetching_course_material = mysqli_fetch_assoc($selecting_course_material)) {
                            $material_type_1 = $fetching_course_material["material_type_1"];
                            $title_1 = $fetching_course_material["title_1"];
                            $file_1 = $fetching_course_material["file_1"];
                            $material_type_2 = $fetching_course_material["material_type_2"];
                            $title_2 = $fetching_course_material["title_2"];
                            $file_2 = $fetching_course_material["file_2"];

                            echo "                            
                              <div id='course-materials'>
                                <h5>Resources</h5>
                                <ul class='list-group' id='video-resources'>
                                  <li class='list-group-item'>
                                    <a href='../lecturer/$file_1' target='_blank'>$title_1</a>
                                    <a href='$file_2' target='_blank'>$title_2</a>
                                  </li>
                                </ul>
                              </div>
                          ";
                          }
                        } else {
                          echo "
                              <h4 id='course-title'>Select a course to view materials</h4>
                            ";
                        }

                        ?>
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

