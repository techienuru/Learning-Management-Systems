<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
  header("location:../signin.php");
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
            <div class="col-12 m-auto stretch-card grid-margin">
              <div class="card bg-gradient-warning text-white">
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
                        <label for="edit-level">Course</label>
                        <select class="form-control" id="edit-level" name="course_id" required>
                          <option value="">Select course</option>
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


                      <button type="submit" class="btn btn-primary btn-block">Assign Course</button>
                    </form>

                    <h2 class="mt-5">Assigned Courses</h2>
                    <table class="table table-bordered mt-3">
                      <thead>
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
                        $sql = mysqli_query($connect, "SELECT * FROM `course_assignment` INNER JOIN lecturer INNER JOIN course ON course_assignment.lecturer_id = lecturer.lecturer_id AND course_assignment.course_id = course.course_id");
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
                                  <a href='?assignment_id=$assignment_id' class='btn btn-danger btn-sm'>Delete</button>
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


        <!-- partial -->
      </div>
      <!-- row-offcanvas ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

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