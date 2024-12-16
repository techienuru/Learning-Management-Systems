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

    // If assignment is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $assignment_id = $_POST["assignment_id"];
        $assignment_file = $_FILES["assignment_file"];

        // Processing File
        $file_real_name = $assignment_file["name"];
        $file_real_temporary_name = $assignment_file["tmp_name"];

        $file_path = "assignments/$file_real_name";

        if (move_uploaded_file($file_real_temporary_name, $file_path)) {
            $sql = mysqli_query($connect, "INSERT INTO `uploaded_assignment` (`assignment_id`, `student_id`, `ua_file`) VALUES ($assignment_id, $student_id,'$file_path')");

            if ($sql) {
                echo "
                <script>
                    alert('Success');
                    location.href='assignment.php';
                </script>
            ";
            }
        }
    }
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
    <style>
        /* Assignment Item Styles */
        .assignment-item {
            background: rgba(172, 54, 172, 0.637);
            border-radius: 5px;
            padding: 30px;
            margin: 30px 0px 20px 0px;
        }

        .assignment-item h4 {
            margin-bottom: 10px;
        }

        .assignment-item p {
            margin: 5px 0;
        }

        .assignment-item .btn {
            margin-right: 10px;
            margin-top: 10px;
        }
    </style>
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
                                        <h1 class="mt-4">Assignments</h1>
                                        <?php
                                        // Selecting courses that the student had registered
                                        $selecting_students_course = mysqli_query($connect, "SELECT * FROM `student_course` WHERE student_id=$student_id");

                                        // Loop through the fetch courses registered by the student and store the courses in a variable
                                        $registered_course = [];
                                        while ($fetching_students_course = mysqli_fetch_assoc($selecting_students_course)) {
                                            $course_id = $fetching_students_course["course_id"];
                                            array_push($registered_course, $course_id);
                                        }
                                        $registered_course = implode(",", $registered_course) ?? null;

                                        // Selecting assignment 
                                        $selecting_assignment = ($registered_course) ? mysqli_query($connect, "SELECT * FROM `assignment` INNER JOIN `course` ON `assignment`.course_id = `course`.course_id INNER JOIN `lecturer` ON `assignment`.`lecturer_id` = `lecturer`.lecturer_id WHERE `assignment`.course_id IN ($registered_course) ORDER BY due_date;") : null;

                                        if ($selecting_assignment) {
                                            while ($fetching_assignment = mysqli_fetch_assoc($selecting_assignment)) {
                                                $assignment_id = $fetching_assignment["assignment_id"];
                                                $given_date = $fetching_assignment["date_created"];
                                                $due_date = $fetching_assignment["due_date"];
                                                $assignment_file = $fetching_assignment["assignment_file"];
                                                $course_code = $fetching_assignment["course_code"];
                                                $course_title = $fetching_assignment["course_title"];
                                                $firstname = $fetching_assignment["firstname"];
                                                $surname = $fetching_assignment["surname"];
                                                $fullname = "$firstname $surname";

                                                echo "
                                                <div class='assignment-item'>
                                                    <h4>$course_code: $course_title</h4>
                                                    <p><strong>Given Date:</strong> $given_date</p>
                                                    <p><strong>Deadline Date:</strong> $due_date</p>
                                                    <p>Complete the exercises in the attached document and upload your solutions.</p>
                                                    <a href='../lecturer/$assignment_file' class='btn btn-info' download>Download Attachment</a>
                                                    <div class='mt-3'>
                                                        <form action='assignment.php' method='POST' enctype='multipart/form-data'>
                                                            <input type='text' name='assignment_id' value='$assignment_id' hidden>

                                                            <label>Upload your assignment:</label>
                                                            <input type='file' name='assignment_file' class='form-control-file' required>

                                                            <button type='submit' class='btn btn-success mt-2'>Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            ";
                                            }
                                        }else {
                                            echo "No available assignment";
                                        }
                                        ?>
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