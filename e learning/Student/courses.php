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

    include_once "./process-courses.php";
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
      <h2 class="text-uppercase text-center fw-bold">Courses Management</h2>
      <p class="text-muted text-center">Register and manage your courses with ease.</p>
    </div>
  </div>

  <div class="row g-4">
    <!-- Available Courses Section -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-primary text-white text-center">
          <h4 class="mb-0">Available Courses</h4>
        </div>
        <div class="card-body">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class="table table-striped table-hover align-middle">
              <thead class="table-dark">
                <tr>
                  <th scope="col">Select</th>
                  <th scope="col">Course Name</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $selecting_reg_courses = mysqli_query($connect, "SELECT * FROM `student_course` WHERE `student_course`.student_id = $student_id");
                $registered_courses = [];
                while ($row = mysqli_fetch_assoc($selecting_reg_courses)) {
                  $course_id = $row["course_id"];
                  array_push($registered_courses, $course_id);
                }
                $registered_courses_str = implode(",", $registered_courses);

                $query = $registered_courses_str ?
                  "SELECT * FROM `course` WHERE course_id NOT IN ($registered_courses_str)" :
                  "SELECT * FROM `course`";

                $selecting_courses = mysqli_query($connect, $query);

                while ($row = mysqli_fetch_assoc($selecting_courses)) {
                  $course_id = $row["course_id"];
                  $course_code = $row["course_code"];
                  $course_title = $row["course_title"];

                  echo "
                    <tr>
                      <td><input type='radio' name='course' value='$course_id'></td>
                      <td>$course_code ($course_title)</td>
                    </tr>";
                }
                ?>
              </tbody>
            </table>
            <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Registered Courses Section -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-success text-white text-center">
          <h4 class="mb-0">Registered Courses</h4>
        </div>
        <div class="card-body">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">Course Name</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $selecting_courses = mysqli_query($connect, "SELECT * FROM `student_course` INNER JOIN `course` ON `student_course`.`course_id` = `course`.course_id WHERE `student_course`.student_id = $student_id");

              while ($row = mysqli_fetch_assoc($selecting_courses)) {
                $student_course_id = $row["student_course_id"];
                $course_code = $row["course_code"];
                $course_title = $row["course_title"];

                echo "
                  <tr>
                    <td>$course_code ($course_title)</td>
                    <td>
                      <a href='process-courses.php?student_course_id=$student_course_id' 
                        class='btn btn-danger btn-sm'>
                        Unregister
                      </a>
                    </td>
                  </tr>";
              }
              ?>
            </tbody>
          </table>
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

