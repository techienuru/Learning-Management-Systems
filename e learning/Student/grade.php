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
                        <a class="nav-link" href="dashboard.php">
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