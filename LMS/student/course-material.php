<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["student_id"])) {
  header("location:../signin.php");
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
  <style>
    /* Sidebar Styles */
    #wrapper {
      display: flex;
      width: 100%;
    }

    #sidebar-wrapper {
      min-height: 100vh;
      width: 250px;
      margin-left: -250px;
      transition: margin 0.25s ease-out;
      background: #343a40;
      color: white;
    }

    #wrapper.toggled #sidebar-wrapper {
      margin-left: 0;
    }

    #page-content-wrapper {
      width: 100%;
      padding: 20px;
    }

    .sidebar-heading {
      padding: 0.875rem 1.25rem;
      font-size: 1.2rem;
      text-align: center;
      background: #343a40;
      color: white;
    }

    .list-group-item {
      border: none;
      padding: 15px 20px;
      background: #343a40;
      color: white;
      transition: all 0.25s ease;
    }

    .list-group-item:hover,
    .list-group-item:focus {
      background-color: #495057;
      color: white;
    }

    .list-group-item-action {
      transition: all 0.25s ease;
    }

    /* Navbar Styles */
    .navbar {
      padding: 10px 20px;
      border-bottom: 1px solid #e3e6f0;
      background: #f8f9fa;
    }

    .nav-link {
      color: #343a40;
      transition: color 0.25s ease;
    }

    .nav-link:hover {
      color: #007bff;
    }

    /* Course Material Styles */
    #course-list .list-group-item {
      cursor: pointer;
      background: #f8f9fa;
      color: #343a40;
    }

    #course-list .list-group-item:hover {
      background-color: #e9ecef;
      color: #007bff;
    }

    #course-materials ul {
      margin-bottom: 20px;
    }

    #course-materials h5 {
      margin-top: 20px;
    }

    .list-group-item a {
      color: #007bff;
      text-decoration: none;
    }

    .list-group-item a:hover {
      text-decoration: underline;
    }
  </style>
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
            <a class="nav-link nav-profile" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="d-none d-lg-inline"><?php echo $fullname; ?></span>
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
              <a class="nav-link" href="courses.php">
                <span class="menu-title">Courses</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="course-material.php">
                <span class="menu-title">Course Material</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="classes.php">
                <span class="menu-title">My classes</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="assignment.php">
                <span class="menu-title">Assignment</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li>


            <li class="nav-item">
              <a class="nav-link" href="grade.php">
                <span class="menu-title">Grade</span>
                <i class="mdi mdi-contacts menu-icon"></i>
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
            <div class="col-md-12 stretch-card grid-margin">
              <div class="card bg-gradient-warning text-white">
                <div class="card-body">

                  <div class="container-fluid">
                    <h1 class="mt-4">Course Material</h1>
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
                <!-- /#page-content-wrapper -->
              </div>
              <!-- /#wrapper -->

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
  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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