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
        /* Sidebar Styles */
        #wrapper {
            display: flex;
            width: 100%;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            margin-left: -250px;
            transition: margin 0.25s ease-out;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        #page-content-wrapper {
            width: 100%;
            padding: 20px;
        }

        .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        .list-group-item {
            border: none;
            padding: 20px 30px;
        }

        .list-group-item-action {
            transition: all 0.25s ease;
        }

        .list-group-item-action:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }

        /* Navbar Styles */
        .navbar {
            padding: 10px 20px;
            border-bottom: 1px solid #e3e6f0;
        }

        /* Table Styles */
        .table-hover tbody tr:hover {
            background-color: #f8f9faa2;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn {
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

                    <div class="col-8 stretch-card grid-margin">
                        <div class="card bg-gradient-warning text-white">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <h1 class="mt-4">Assigned Courses</h1>
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table">
                                                <thead>
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
                                                        $course_id = $row["course_id"];
                                                        $course_code = $row["course_code"];
                                                        $course_title = $row["course_title"];
                                                        $course_level = $row["course_level"];
                                                        echo "
                                                            <tr>
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
    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        function registerCourse() {
            const selectedCourse = document.querySelector('input[name="course"]:checked');
            if (selectedCourse) {
                const courseName = selectedCourse.value;
                const registeredCourses = document.getElementById('registered-courses');

                // Check if the course is already registered
                const existingCourse = Array.from(registeredCourses.children).find(
                    row => row.querySelector('td').innerText.trim() === courseName
                );

                if (!existingCourse) {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${courseName}</td>
                        <td><button class="btn btn-danger btn-sm" onclick="unregisterCourse(this)">Remove</button></td>
                    `;
                    registeredCourses.appendChild(newRow);
                } else {
                    alert('Course is already registered.');
                }
            } else {
                alert('Please select a course to register.');
            }
        }

        function unregisterCourse(button) {
            const row = button.parentElement.parentElement;
            row.remove();
        }
    </script>

</body>

</html>