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
                        <div class="col-12 stretch-card grid-margin">
                            <div class="card bg-gradient-warning text-white">
                                <div class="card-body">

                                    <div class="container-fluid">
                                        <h1 class="mt-4 mb-5">Grades</h1>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Course</th>
                                                    <th scope="col">Course Code</th>
                                                    <th scope="col">Score</th>
                                                    <th scope="col">Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody id="grades-table-body">
                                                <?php
                                                // Selecting assignments that the student dropped
                                                $selecting_uploaded_assignment = mysqli_query($connect, "SELECT * FROM `uploaded_assignment` WHERE student_id=$student_id");

                                                // Loop through the fetch uploaded assignments and store the courses in a variable(Array)
                                                $uploaded_assignment = [];
                                                while ($fetching_uploaded_assignment = mysqli_fetch_assoc($selecting_uploaded_assignment)) {
                                                    $ua_id = $fetching_uploaded_assignment["ua_id"];
                                                    array_push($uploaded_assignment, $ua_id);
                                                }

                                                // Convertig the array to string
                                                $uploaded_assignment = implode(",", $uploaded_assignment);


                                                // Selecting Grades 
                                                $selecting_grades = mysqli_query($connect, "SELECT * FROM `grade` INNER JOIN `uploaded_assignment` ON `grade`.ua_id = `uploaded_assignment`.ua_id INNER JOIN `course` ON `grade`.course_id = `course`.course_id WHERE `grade`.ua_id IN ($uploaded_assignment)");

                                                while ($fetching_grades = mysqli_fetch_assoc($selecting_grades)) {
                                                    $course_title = $fetching_grades["course_title"];
                                                    $course_code = $fetching_grades["course_code"];
                                                    $grade_score = $fetching_grades["grade_score"];
                                                    if ($grade_score >= 70) {
                                                        $grade = "A";
                                                    } else if ($grade_score >= 60) {
                                                        $grade = "B";
                                                    } else if ($grade_score >= 50) {
                                                        $grade = "C";
                                                    } else if ($grade_score >= 45) {
                                                        $grade = "D";
                                                    } else if ($grade_score >= 40) {
                                                        $grade = "E";
                                                    } else {
                                                        $grade = "F";
                                                    }

                                                    echo "
                                                        <tr>
                                                            <td>$course_title</td>
                                                            <td>$course_code</td>
                                                            <td>$grade_score</td>
                                                            <td>$grade</td>
                                                        </tr>  
                                                    ";
                                                }
                                                ?>

                                            </tbody>
                                        </table>
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