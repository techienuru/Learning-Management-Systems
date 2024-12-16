<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
    header("location:../authentication-login.php");
} else {
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
    /* Animate table rows */
    .animate-table tbody tr {
        transition: background-color 0.3s, transform 0.2s;
    }
    
    .animate-table tbody tr:hover {
        background-color: #f5f5f5;
        transform: scale(1.02);
    }
    
    /* Button styles */
    .btn-outline-info:hover, .btn-outline-danger:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* Modal customizations */
    .modal .modal-header {
        background-color: #343a40;
        color: #ffffff;
    }
    
    .modal .modal-footer button {
        border-radius: 20px;
    }

    .table-hover thead th {
        letter-spacing: 1px;
    }

    /* Form elements */
    .form-control, .form-select {
        border-radius: 10px;
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
    <div class="row mt-4">
        <div class="col-12 stretch-card">
            <div class="card bg-dark text-light shadow-lg rounded">
                <div class="card-body p-5">
                    <div class="container-fluid">
                        <h2 class="display-4 text-center mb-5 font-weight-bold">Added Lecturers</h2>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered text-dark text-center align-middle animate-table">
                                <thead class="bg-gradient-primary text-white">
                                    <tr>
                                        <th>Given Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Faculty</th>
                                        <th>Department</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-light">
                                    <?php
                                    $selecting_lecturers = mysqli_query($connect, "SELECT * FROM `lecturer`");
                                    if (!mysqli_num_rows($selecting_lecturers) > 0) {
                                        echo '
                                            <tr>
                                                <td colspan="6" class="text-center font-italic">No lecturers have been registered yet.</td>
                                            </tr>
                                        ';
                                    } else {
                                        while ($row = mysqli_fetch_assoc($selecting_lecturers)) {
                                            $lecturer_id = $row["lecturer_id"];
                                            $firstname = $row["firstname"];
                                            $surname = $row["surname"];
                                            $email = $row["email"];
                                            $faculty = $row["faculty"];
                                            $department = $row["department"];
                                            $password = $row["password"];

                                            echo "
                                                <tr>
                                                    <td>$firstname</td>
                                                    <td>$surname</td>
                                                    <td>$email</td>
                                                    <td>$faculty</td>
                                                    <td>$department</td>
                                                    <td>
                                                        <button class='btn btn-outline-info btn-sm shadow-sm' data-toggle='modal' data-target='#editLecturerModal$lecturer_id'>Edit</button>
                                                        <a href='modify-lecturer.php?action=delete&lecturer_id=$lecturer_id' class='btn btn-outline-danger btn-sm shadow-sm'>Delete</a>
                                                    </td>
                                                </tr>
                                                ";

                                            echo "
                                                <div class='modal fade' id='editLecturerModal$lecturer_id' tabindex='-1' aria-labelledby='editLecturerModalLabel' aria-hidden='true'>
                                                    <div class='modal-dialog modal-dialog-centered'>
                                                        <div class='modal-content'>
                                                            <form action='modify-lecturer.php?action=edit' method='POST'>
                                                                <div class='modal-header'>
                                                                    <h5 class='modal-title' id='editLecturerModalLabel'>Update Lecturer Information</h5>
                                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                    <input type='hidden' value='$lecturer_id' name='lecturer_id'>
                                                                    <div class='form-group'>
                                                                        <label for='edit-first-name'>First Name</label>
                                                                        <input type='text' class='form-control' value='$firstname' name='firstname' required>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='edit-surname'>Surname</label>
                                                                        <input type='text' class='form-control' value='$surname' name='surname' required>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='edit-faculty'>Faculty</label>
                                                                        <select class='form-control' name='faculty' required>
                                                                            <option value='$faculty'>$faculty</option>
                                                                            <option value='Science'>Science</option>
                                                                            <option value='Engineering'>Engineering</option>
                                                                            <option value='Business'>Business</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='edit-department'>Department</label>
                                                                        <select class='form-control' name='department' required>
                                                                            <option value='$department'>$department</option>
                                                                            <option value='Computer Science'>Computer Science</option>
                                                                            <option value='Electrical Engineering'>Electrical Engineering</option>
                                                                            <option value='Management'>Management</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='edit-password'>Password</label>
                                                                        <input type='password' class='form-control' value='$password' name='password' required>
                                                                    </div>
                                                                </div>
                                                                <div class='modal-footer'>
                                                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                                    <button type='submit' class='btn btn-primary'>Update Lecturer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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