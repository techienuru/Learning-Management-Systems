<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["lecturer_id"])) {
    header("location:../signin.php");
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


    // If grade changes is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $grade_id = $_POST["grade_id"];
        $grade_score = $_POST["grade_score"];

        $sql = mysqli_query($connect, "UPDATE `grade` SET grade_score = $grade_score WHERE grade_id = $grade_id");
        if ($sql) {
            echo "
                <script>
                    alert('success');
                    window.location.href='grade.php';
                </script>
            ";
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
                        <a class="nav-link count-indicator dropdown-toggle text-danger" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            Schedules
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                            <h6 class="p-3 mb-0">Class</h6>
                            <div class="dropdown-divider"></div>
                            <?php selectClasses(); ?>
                        </div>
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
                            <a class="nav-link" href="viewassignment.php">
                                <span class="menu-title">Assignment response</span>
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
                                                    <th scope="col">Student</th>
                                                    <th scope="col">Course</th>
                                                    <th scope="col">Course Code</th>
                                                    <th scope="col">Lecturer</th>
                                                    <th scope="col">Score</th>
                                                    <th scope="col">Grade</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="grades-table-body">
                                                <?php
                                                // Selecting Course assigned to the Lecturer
                                                $selecting_assigned_course = mysqli_query($connect, "SELECT * FROM `course_assignment` WHERE lecturer_id = $lecturer_id");


                                                // Looping through the courses that the lecturer was assigned to and storing them in a variable
                                                $assigned_courses = [];
                                                while ($fetching_assigned_course = mysqli_fetch_assoc($selecting_assigned_course)) {
                                                    $course_id = $fetching_assigned_course["course_id"];
                                                    array_push($assigned_courses, $course_id);
                                                }

                                                // Converting the array that stores the courses into a string
                                                $assigned_courses = ($assigned_courses) ? implode(",", $assigned_courses) : 0;


                                                // Selecting Grades
                                                $selecting_grades = mysqli_query($connect, "SELECT * FROM `grade` INNER JOIN `uploaded_assignment` ON `grade`.ua_id = `uploaded_assignment`.ua_id INNER JOIN `course` ON `grade`.course_id = `course`.course_id WHERE `grade`.course_id IN ($assigned_courses)");

                                                while ($fetching_grades = mysqli_fetch_assoc($selecting_grades)) {
                                                    $grade_id = $fetching_grades["grade_id"];
                                                    $student_id = $fetching_grades["student_id"];
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
                                                    $course_code = $fetching_grades["course_code"];
                                                    $course_title = $fetching_grades["course_title"];

                                                    // Fetching student name
                                                    $selecting_student_info = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id = $student_id");
                                                    $fetching_student_info = mysqli_fetch_assoc($selecting_student_info);
                                                    $student_fullname = "$fetching_student_info[firstname] $fetching_student_info[lastname]";
                                                    echo "
                                                        <tr>
                                                            <td>$fullname</td>
                                                            <td>$course_title</td>
                                                            <td>$course_code</td>
                                                            <td>$fullname</td>
                                                            <td>$grade_score</td>
                                                            <td>$grade</td>
                                                            <td>
                                                                <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editGradeModal-$grade_id'>Edit</button>
                                                            </td>
                                                        </tr>  
                                                    ";

                                                    // Bootrap Modal for editing Students grade
                                                    echo "
                            <div class='modal fade' id='editGradeModal-$grade_id' tabindex='-1' role='dialog' aria-labelledby='editGradeModalLabel' aria-hidden='true'>
                                <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title text-black' id='editGradeModalLabel'>Edit Grade</h5>
                                            <button type='button' class='close' data-bs-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <form action='grade.php' method='POST'>
                                            <div class='modal-body'>

                                                <div class='form-group'>
                                                    <input type='text' class='form-control' value='$grade_id' name='grade_id' hidden>
                                                </div>

                                                <div class='form-group'>
                                                    <label for='student-name' class='text-black'>Student Name</label>
                                                    <input type='text' class='form-control' value='$fullname' readonly>
                                                </div>
                                                <div class='form-group'>
                                                    <label for='course-code' class='text-black'>Course Code</label>
                                                    <input type='text' class='form-control' value='$course_code' readonly>
                                                </div>
                                                <div class='form-group'>
                                                    <label for='grade' class='text-black'>Grade</label>
                                                    <input type='number' class='form-control' value='$grade_score' name='grade_score' min='0' max='100'>
                                                </div>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                <button type='submit' class='btn btn-primary'>Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
        <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
        <script src="node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
        <!-- endinject -->
        <!-- End plugin js for this page-->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/misc.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="js/dashboard.js"></script>
        <!-- End custom js for this page-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>

</html>