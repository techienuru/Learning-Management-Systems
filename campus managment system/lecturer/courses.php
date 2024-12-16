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
    background-color: #f5f5f5;
    padding: 50px 0;
  }

  .card {
    border-radius: 20px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .card::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, rgba(255, 193, 7, 0.5), rgba(255, 87, 34, 0.5));
    transform: rotate(45deg);
    transition: all 0.6s ease;
  }

  .card:hover::before {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  .card-header {
    background: #343a40;
    color: #fff;
    border-bottom: 4px solid #ffc107;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
  }

  .card-header h2 {
    letter-spacing: 1px;
    text-transform: uppercase;
    font-family: 'Roboto', sans-serif;
    font-weight: 700;
  }

  .table {
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
  }

  .table th, .table td {
    vertical-align: middle;
    padding: 15px;
    border-bottom: 1px solid #dee2e6;
  }

  .table th {
    background: #ffc107;
    color: #343a40;
    text-transform: uppercase;
    font-size: 0.9rem;
    font-weight: bold;
  }

  .table td {
    font-size: 1.1rem;
    color: #495057;
    transition: background-color 0.3s ease;
  }

  .table-hover tbody tr:hover td {
    background-color: rgba(255, 193, 7, 0.2);
    cursor: pointer;
  }

  .table-bordered td, .table-bordered th {
    border: 2px solid #007bff;
  }

  .course-row {
    transition: all 0.3s ease;
  }

  .course-row:hover {
    background-color: rgba(255, 87, 34, 0.1);
    transform: scale(1.02);
  }

  .card-footer {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    background-color: #343a40;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    padding: 15px;
  }

  .card-footer h5 {
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    letter-spacing: 1px;
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
  <div class="col-10 stretch-card grid-margin mx-auto">
    <div class="card shadow-lg border-0 bg-gradient-warning text-white rounded-lg">
      <div class="card-header bg-dark text-center py-4">
        <h2 class="mb-0 font-weight-bold text-uppercase">Assigned Courses</h2>
        <p class="lead">Courses currently assigned to you</p>
      </div>
      <div class="card-body bg-light">
        <div class="table-responsive">
          <table class="table table-hover table-bordered text-center">
            <thead class="bg-warning text-dark font-weight-bold">
              <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Course Level</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $selecting_courses = mysqli_query($connect, "SELECT * FROM `course_assignment` INNER JOIN course ON course_assignment.course_id = course.course_id WHERE lecturer_id=$lecturer_id");

              while ($row = mysqli_fetch_assoc($selecting_courses)) {
                $course_code = $row["course_code"];
                $course_title = $row["course_title"];
                $course_level = $row["course_level"];

                echo "
                  <tr class='course-row'>
                    <td>$course_code</td>
                    <td>$course_title</td>
                    <td>$course_level</td>
                  </tr>  
                ";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer bg-dark text-white text-center">
        <h5 class="mb-0">Manage Your Courses Effectively</h5>
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