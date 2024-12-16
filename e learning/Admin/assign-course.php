<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
  header("location:../login.php");
} else {
  include_once "./process-assign-course.php";
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
                <h5 class="mb-2 text-titlecase mb-4">Dashboard</h5>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                      <div class="content-wrapper">

                      <div class="row mt-4">
  <div class="col-12 m-auto stretch-card grid-margin">
    <div class="card bg-gradient-success text-white">
      <div class="card-body">

        <div class="container-fluid">
          <h1 class="mt-4 mb-5 text-center">Assign Courses to Lecturers</h1>
          <form action="assign-course.php" method="POST">
            <div class="form-group">
              <label for="lecturer">Lecturer</label>
              <select class="form-control" id="lecturer" name="lecturer_id" required>
                <option value="">Select Lecturer</option>
                <?php
                $selecting_lecturers = mysqli_query($connect, "SELECT * FROM `lecturer`");
                while ($row = mysqli_fetch_assoc($selecting_lecturers)) {
                  $lecturer_id = $row["lecturer_id"];
                  $firstname = $row["firstname"];
                  $surname = $row["surname"];
                  $fullname = "$firstname $surname";
                  $faculty = $row["faculty"];
                  $department = $row["department"];
                  echo "
<option value='$lecturer_id' data-faculty='$faculty' data-department='$department'>$fullname</option>
";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="faculty">Faculty</label>
              <input type="text" class="form-control" id="faculty" readonly>
            </div>
            <div class="form-group">
              <label for="department">Department</label>
              <input type="text" class="form-control" id="department" readonly>
            </div>

            <div class="form-group">
              <label for="course">Course</label>
              <select class="form-control" id="course" name="course_id" required>
                <option value="">Select Course</option>
                <?php
                $selecting_courses = mysqli_query($connect, "SELECT * FROM `course`");
                while ($row = mysqli_fetch_assoc($selecting_courses)) {
                  $course_id = $row["course_id"];
                  $course_code = $row["course_code"];
                  $course_title = $row["course_title"];
                  $course_level = $row["course_level"];
                  echo "
<option value='$course_id' data-course-level='$course_level'>$course_code ($course_title)</option>
";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="level">Level</label>
              <input type="text" class="form-control" id="level" readonly>
            </div>

            <button type="submit" class="btn btn-warning btn-block">Assign Course</button>
          </form>

          <h2 class="mt-5 text-center">Assigned Courses</h2>
          <table class="table table-bordered mt-3 table-striped">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Lecturer</th>
                <th scope="col">Faculty</th>
                <th scope="col">Department</th>
                <th scope="col">Level</th>
                <th scope="col">Course</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = mysqli_query($connect, "SELECT * FROM `course_assignment` INNER JOIN lecturer ON course_assignment.lecturer_id = lecturer.lecturer_id INNER JOIN course ON course_assignment.course_id = course.course_id");
              if (!mysqli_num_rows($sql) > 0) {
                echo '
                                              <tr>
                                                  <td colspan="6" class="text-center">No assigned Course</td>
                                              </tr>
                                          ';
              } else {
                while ($row = mysqli_fetch_assoc($sql)) {
                  $assignment_id = $row["assignment_id"];
                  $firstname = $row["firstname"];
                  $surname = $row["surname"];
                  $fullname = "$firstname $surname";
                  $faculty = $row["faculty"];
                  $department = $row["department"];
                  $course_level = $row["course_level"];
                  $course_code = $row["course_code"];
                  $course_title = $row["course_title"];
                  $course = "$course_code ($course_title)";

                  echo "
                    <tr>
                      <td>$fullname</td>
                      <td>$faculty</td>
                      <td>$department</td>
                      <td>$course_level</td>
                      <td>$course</td>
                      <td>
                        <a href='?assignment_id=$assignment_id' class='btn btn-danger btn-sm'>Delete</a>
                      </td>
                    </tr>
                                              ";
                }
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

  <script>
    document.getElementById('lecturer').addEventListener('change', function() {
      var selectedOption = this.options[this.selectedIndex];
      var faculty = selectedOption.getAttribute('data-faculty');
      var department = selectedOption.getAttribute('data-department');

      document.getElementById('faculty').value = faculty;
      document.getElementById('department').value = department;
    });

    document.getElementById('edit-level').addEventListener('change', function() {
      var selectedOption = this.options[this.selectedIndex];
      var courseLevel = selectedOption.getAttribute('data-course-level');

      document.getElementById('level').value = courseLevel;
    });
  </script>

</body>

</html>

