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

        #label {
            color: black;
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

                    <div class="row mt-4">
                        <div class="col-12 stretch-card grid-margin">
                            <div class="card bg-gradient-warning text-white">
                                <div class="card-body">

                                    <div class="container-fluid">
                                        <h1 class="mt-4">Manage Assignments</h1>
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label id="label" for="courseSelect">Select Course:</label>
                                                        <select class="form-control" name="course_id" required>
                                                            <option value="">Select Course</option>
                                                            <?php
                                                            $selecting_courses = mysqli_query($connect, "SELECT * FROM `course_assignment` INNER JOIN course ON course_assignment.course_id = course.course_id WHERE lecturer_id=$lecturer_id");

                                                            while ($row = mysqli_fetch_assoc($selecting_courses)) {
                                                                $course_id = $row["course_id"];
                                                                $course_code = $row["course_code"];
                                                                $course_title = $row["course_title"];
                                                                $course_level = $row["course_level"];
                                                                echo "
                                    <option value='$course_id'>$course_code</option>
                                    ";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label id="label" for="dueDate">Due Date:</label>
                                                        <input type="date" class="form-control" name="due_date" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label id="label" for="assignmentFile">Upload File:</label>
                                                        <input type="file" class="form-control-file" id="assignmentFile" name="assignment_file">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Upload</button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Display existing assignments here if needed -->

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
</body>

</html>