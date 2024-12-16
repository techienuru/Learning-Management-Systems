<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["lecturer_id"])) {
  header("location:../authentication-login.php");
} else {
  $lecturer_id = $_SESSION["lecturer_id"];

  $selecting_user_details = mysqli_query($connect, "SELECT * FROM `lecturer` WHERE lecturer_id=$lecturer_id");
  $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);
  $fullname = "$fetching_user_details[firstname]  $fetching_user_details[surname]";

  function selectClasses()
  {
    global $connect, $lecturer_id;

    // Selecting Courses assigned to lecturer
    $selecting_course_assignment = mysqli_query($connect, "SELECT * FROM `course_assignment` WHERE lecturer_id=$lecturer_id");

    while ($row = mysqli_fetch_assoc($selecting_course_assignment)) {
      $course_id = $row["course_id"];

      // Selecting Class that tally with the fetched course_id
      $selecting_class = mysqli_query($connect, "SELECT * FROM `class` INNER JOIN `course` ON `class`.course_id = `course`.course_id WHERE `class`.course_id=$course_id");

      while ($row = mysqli_fetch_assoc($selecting_class)) {
        $class_id = $row["class_id"];
        $class_date = $row["class_date"];
        $class_time = $row["class_time"];

        $course_code = $row["course_code"];
        $course_title = $row["course_title"];

        echo "
              <a class='dropdown-item preview-item'>
                <div class='preview-thumbnail'>
                  <img src='images/faces/face4.jpg' alt='image' class='profile-pic'>
                </div>
                <div class='preview-item-content d-flex align-items-start flex-column justify-content-center'>
                  <h6 class='preview-subject ellipsis mb-1 font-weight-normal'>$course_code</h6>
                  <p class='text-gray mb-1'>
                    $class_date 
                  </p>
                  <p class='text-gray mb-0'>
                    Time: $class_time
                  </p>
                </div>
              </a>
              <div class='dropdown-divider'></div>        
        ";
      }
    }
  }


  // If Grade is submitted
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ua_id = $_POST["ua_id"];
    $course_id = $_POST["course_id"];
    $grade_score = $_POST["grade"];

    $sql = mysqli_query($connect, "INSERT INTO `grade` (`ua_id`,`course_id`, `grade_score`) VALUES ($ua_id, $course_id , $grade_score)");

    if ($sql) {
      echo "
                <script>
                    alert('Success');
                    location.href='viewassignment.php';
                </script>
            ";
    }
  }
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
<style>
  .content-wrapper {
    background-color: #f1f1f1;
    padding: 50px;
  }

  .card-header h2 {
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    letter-spacing: 1px;
  }

  .table {
    border-collapse: separate;
    border-spacing: 0 15px;
  }

  .table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.1);
    transition: background-color 0.3s ease-in-out;
  }

  .table-bordered th,
  .table-bordered td {
    border: 2px solid #343a40;
    vertical-align: middle;
  }

  th {
    font-size: 1.2em;
    padding: 15px;
    text-transform: uppercase;
  }

  td {
    font-size: 1.1em;
    padding: 12px;
  }

  .form-control {
    border-radius: 30px;
    padding: 10px;
    border: 2px solid #17a2b8;
  }

  .btn-success {
    background-color: #28a745;
    border: none;
    border-radius: 30px;
    padding: 10px 20px;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
  }

  .btn-success:hover {
    background-color: #218838;
    transform: scale(1.05);
  }

  .card-body {
    transition: transform 0.4s ease;
  }

  .card-body:hover {
    transform: translateY(-5px);
  }

  .table a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
  }

  .table a:hover {
    text-decoration: underline;
    color: #0056b3;
  }

  .card-footer h5 {
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
  }
</style>
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

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="classes.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Schedule Class</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="assignment.php" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Add To do</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="viewassignment.php" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Todo Replies</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="courses.php" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span class="hide-menu">View allocated Course(s)</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="course-material.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Add Materails</span></a></li>

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
  <div class="row justify-content-center mt-5">
    <div class="col-12 stretch-card grid-margin">
      <div class="card shadow-lg border-0 rounded-lg bg-gradient-primary text-white">
        <div class="card-header bg-dark text-white text-center">
          <h2 class="mb-0">All Submissions appear here</h2>
          <p class="lead">Review and Grade Assignments Seamlessly</p>
        </div>
        <div class="card-body bg-light">
          <div class="table-responsive">
            <table class="table table-hover table-bordered text-center">
              <thead class="bg-gradient-dark text-dark">
                <tr>
                  <th>Student Name</th>
                  <th>Assignment  Attachment</th>
                  <th>Date of Submission</th>
                  <!-- <th>Grade</th> -->
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Selecting assignments
                $selecting_assignments = mysqli_query($connect, "SELECT * FROM `assignment` WHERE lecturer_id = $lecturer_id");

                // Looping through the assignments that the lecturer dropped and storing them in a variable
                $assignments = [];
                while ($fetching_assignments = mysqli_fetch_assoc($selecting_assignments)) {
                  $assignment_id = $fetching_assignments["assignment_id"];
                  array_push($assignments, $assignment_id);
                }

                // Converting the array that stores the assignments into a string
                $assignments = ($assignments) ? implode(",", $assignments) : 0;

                // Selecting Uploaded Assignments
                $selecting_uploaded_assignments = mysqli_query($connect, "SELECT * FROM `uploaded_assignment` INNER JOIN `assignment` ON `uploaded_assignment`.assignment_id = `assignment`.assignment_id INNER JOIN `student` ON `uploaded_assignment`.student_id = `student`.student_id WHERE `uploaded_assignment`.assignment_id IN ($assignments)");

                while ($fetching_uploaded_assignments = mysqli_fetch_assoc($selecting_uploaded_assignments)) {
                  $ua_id = $fetching_uploaded_assignments["ua_id"];
                  $course_id = $fetching_uploaded_assignments["course_id"];
                  $assignment_id = $fetching_uploaded_assignments["assignment_id"];
                  $firstname = $fetching_uploaded_assignments["firstname"];
                  $lastname = $fetching_uploaded_assignments["lastname"];
                  $othername = $fetching_uploaded_assignments["othername"] ?? null;
                  $fullname = "$firstname $lastname $othername";
                  $ua_file = $fetching_uploaded_assignments["ua_file"];
                  $date_submitted = $fetching_uploaded_assignments["date_submitted"];

                  echo "
                    <tr>
                      <form action='viewassignment.php' method='POST'>
                        <td>$fullname</td>
                        <td>
                          <a href='../student/$ua_file' target='_blank'>View</a>
                        </td>
                        <td>$date_submitted</td>
                        <td>
                          <input type='number' class='form-control' name='grade' min='0' max='100'>
                        </td>
                        <input type='text' value='$ua_id' name='ua_id' hidden>
                        <input type='text' value='$course_id' name='course_id' hidden>
                        <td>
                          <button type='submit' class='btn btn-success'>Upload</button>
                        </td>
                      </form>
                    </tr>
                  ";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer bg-gradient-secondary text-white text-center">
          <h5 class="mb-0">Assignment Review Panel</h5>
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

</body>

</html>