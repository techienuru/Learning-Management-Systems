<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
  header("location:../authentication-login.php");
} else {
  include_once "./process-assign-course.php";
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Campus Management System</title>
    <!-- Custom CSS -->
    <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-10">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <h3>CMS</h3>
                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>



                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">




                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="Profile.php"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>

                                <a class="dropdown-item" href="logout.php"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="courses.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Manage Courses</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="add-lecturer.php" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Manage tutors</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="view-lecturer.php" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span class="hide-menu">View tutors</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="assign-course.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Allocate Courses</span></a></li>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                            <div class="content-wrapper">
  <div class="row mt-5">
    <div class="col-12 m-auto">
      <div class="card shadow-lg p-3 mb-5 bg-white rounded">
        <div class="card-body">
          <div class="container-fluid">
            <h2 class="text-center mb-4 text-primary">Assign Lecturers to Courses</h2>
            <form action="assign-course.php" method="POST" class="form-row">
              <!-- Lecturer Field -->
              <div class="col-md-6 mb-3">
                <label for="lecturer" class="text-secondary">Lecturer</label>
                <select class="form-control custom-select" id="lecturer" name="lecturer_id" required>
                  <option value="">Select Lecturer</option>
                  <?php
                  $lecturers = mysqli_query($connect, "SELECT * FROM `lecturer`");
                  while ($row = mysqli_fetch_assoc($lecturers)) {
                    $lecturer_id = $row["lecturer_id"];
                    $fullname = "{$row['firstname']} {$row['surname']}";
                    $faculty = $row["faculty"];
                    $department = $row["department"];
                    echo "<option value='$lecturer_id' data-faculty='$faculty' data-department='$department'>$fullname</option>";
                  }
                  ?>
                </select>
              </div>
              <!-- Faculty Field -->
              <div class="col-md-6 mb-3">
                <label for="faculty" class="text-secondary">Faculty</label>
                <input type="text" class="form-control" id="faculty" readonly>
              </div>
              <!-- Department Field -->
              <div class="col-md-6 mb-3">
                <label for="department" class="text-secondary">Department</label>
                <input type="text" class="form-control" id="department" readonly>
              </div>
              <!-- Course Selection -->
              <div class="col-md-6 mb-3">
                <label for="course" class="text-secondary">Course</label>
                <select class="form-control custom-select" id="course" name="course_id" required>
                  <option value="">Select Course</option>
                  <?php
                  $courses = mysqli_query($connect, "SELECT * FROM `course`");
                  while ($row = mysqli_fetch_assoc($courses)) {
                    $course_id = $row["course_id"];
                    $course_code = $row["course_code"];
                    $course_title = $row["course_title"];
                    echo "<option value='$course_id'>$course_code - $course_title</option>";
                  }
                  ?>
                </select>
              </div>
              <!-- Submit Button -->
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-lg btn-info mt-3">Assign Course</button>
              </div>
            </form>

            <!-- Assigned Courses Table -->
            <div class="mt-5">
              <h3 class="text-dark">List of Assigned Courses</h3>
              <table class="table table-hover borderless mt-3">
                <thead class="thead-light">
                  <tr>
                    <th>Lecturer</th>
                    <th>Faculty</th>
                    <th>Department</th>
                    <th>Level</th>
                    <th>Course</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $assignments = mysqli_query($connect, "SELECT * FROM `course_assignment`
                    INNER JOIN lecturer ON course_assignment.lecturer_id = lecturer.lecturer_id
                    INNER JOIN course ON course_assignment.course_id = course.course_id");

                  if (!mysqli_num_rows($assignments)) {
                    echo "<tr><td colspan='6' class='text-center'>No assigned courses available</td></tr>";
                  } else {
                    while ($row = mysqli_fetch_assoc($assignments)) {
                      $lecturer = "{$row['firstname']} {$row['surname']}";
                      $course = "{$row['course_code']} ({$row['course_title']})";
                      echo "<tr class='fadeIn'>
                        <td>$lecturer</td>
                        <td>{$row['faculty']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['course_level']}</td>
                        <td>$course</td>
                        <td><a href='?assignment_id={$row['assignment_id']}' class='btn btn-sm btn-danger'>Delete</a></td>
                      </tr>";
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




                                <!-- Content falls here -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                Campus Management System
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!-- <script src="dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script src="../assets/libs/flot/excanvas.js"></script>
    <script src="../assets/libs/flot/jquery.flot.js"></script>
    <script src="../assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="../assets/libs/flot/jquery.flot.time.js"></script>
    <script src="../assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="../assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="../assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="../dist/js/pages/chart/chart-page-init.js"></script>

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