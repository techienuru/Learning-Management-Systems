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



    function checkErrorInDate()
    {
        global $due_date;
        date_default_timezone_set("AFRICA/LAGOS");
        $current_date = date("Y-m-d");

        if (($due_date < $current_date)) {
            return false;
        }
        return true;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $course_id = $_POST["course_id"];
        $due_date = $_POST["due_date"];
        $assignment_file = $_FILES["assignment_file"];

        if (checkErrorInDate()) {

            // Processing File
            $file_real_name = $assignment_file["name"];
            $file_real_temporary_name = $assignment_file["tmp_name"];

            $file_path = "assignments/$file_real_name";

            if (move_uploaded_file($file_real_temporary_name, $file_path)) {
                $sql = mysqli_query($connect, "INSERT INTO `assignment` (`course_id`, `lecturer_id`, `due_date`, `assignment_file`) VALUES ($course_id, '$lecturer_id','$due_date','$file_path')");

                if ($sql) {
                    echo "
                    <script>
                        alert('Success');
                        location.href='assignment.php';
                    </script>
                ";
                }
            }
        } else {
            echo "
          <script>
              alert('Error in date/time selection');
              location.href='assignment.php';
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
  .custom-select {
    padding: 10px;
    border-radius: 30px;
    border: 2px solid #17a2b8;
  }

  .content-wrapper {
    background-color: #f8f9fa;
    padding: 40px;
  }

  .card-header h2 {
    font-family: 'Roboto', sans-serif;
    font-weight: 700;
  }

  .form-control {
    padding: 15px;
    font-size: 16px;
  }

  .form-group label {
    font-size: 1.2em;
  }

  .btn-lg {
    font-size: 1.2em;
    font-weight: bold;
  }

  .card-body {
    transition: all 0.4s ease-in-out;
  }

  .card-body:hover {
    transform: translateY(-5px);
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
    <div class="col-md-8">
      <div class="card shadow-lg border-0 rounded-lg bg-gradient-info">
        <div class="card-header bg-dark text-white text-center">
          <h2 class="mb-0">Assignment Management</h2>
          <p class="lead">Easily upload and manage your course assignments</p>
        </div>
        <div class="card-body bg-light">
          <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data" class="p-4">
            <div class="form-group mb-4">
              <label for="courseSelect" class="font-weight-bold">Select Course</label>
              <select class="custom-select" name="course_id" required>
                <option value="">Select Course</option>
                <?php
                $selecting_courses = mysqli_query($connect, "SELECT * FROM `course_assignment` INNER JOIN course ON course_assignment.course_id = course.course_id WHERE lecturer_id=$lecturer_id");
                while ($row = mysqli_fetch_assoc($selecting_courses)) {
                  $course_id = $row["course_id"];
                  $course_code = $row["course_code"];
                  echo "<option value='$course_id'>$course_code</option>";
                }
                ?>
              </select>
            </div>

            <div class="form-group mb-4">
              <label for="dueDate" class="font-weight-bold">Assignment Due Date</label>
              <input type="date" class="form-control rounded-pill" name="due_date" required>
            </div>

            <div class="form-group mb-4">
              <label for="assignmentFile" class="font-weight-bold">Upload Assignment File</label>
              <input type="file" class="form-control-file" id="assignmentFile" name="assignment_file">
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-success btn-lg rounded-pill px-5">Upload Assignment</button>
            </div>
          </form>
        </div>

        <!-- Assignments list section, if needed -->
        <div class="card-footer text-center bg-gradient-primary text-white mt-4">
          <h4>Uploaded Assignments</h4>
          <!-- Display list here if needed -->
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