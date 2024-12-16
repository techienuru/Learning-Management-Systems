<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
    header("location:../signin.php");
} else {
    include_once "./process-courses.php";
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
                        <a class="nav-link nav-profile" id="profileDropdown" aria-expanded="false">
                            <span class="d-none d-lg-inline">Admin</span>
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
                            <a class="nav-link" href="students.php">
                                <span class="menu-title">Students</span>
                                <i class="mdi mdi-home menu-icon"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="add-lecturer.php">
                                <span class="menu-title">Add Lecturer</span>
                                <i class="mdi mdi-home menu-icon"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="view-lecturer.php">
                                <span class="menu-title">View Lecturers</span>
                                <i class="mdi mdi-home menu-icon"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="courses.php">
                                <span class="menu-title">Courses</span>
                                <i class="mdi mdi-home menu-icon"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="assign-course.php">
                                <span class="menu-title">Assign Course</span>
                                <i class="mdi mdi-home menu-icon"></i>
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

                                    <div class="container">
                                        <h1 class="mt-4 mb-5 text-center">Add Courses</h1>
                                        <form id="add-course-form" action="courses.php" method="post">
                                            <div class="form-group">
                                                <label for="course-code">Course Code</label>
                                                <input type="text" class="form-control" id="course-code" name="course_code" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="course-title">Course Title</label>
                                                <input type="text" class="form-control" id="course-title" name="course_title" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="course-level">Course Level</label>
                                                <select class="form-control" id="course-level" name="course_level" required>
                                                    <option value="">Select Level</option>
                                                    <option value="100">100 Level</option>
                                                    <option value="200">200 Level</option>
                                                    <option value="300">300 Level</option>
                                                    <option value="400">400 Level</option>
                                                </select>
                                            </div>
                                            <button type="submit" name="add_course" class="btn btn-primary btn-block">Add Course</button>
                                        </form>
                                    </div>


                                    <div class="container-fluid">
                                        <h1 class="mt-4 mb-5 text-center">Manage Courses</h1>
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Level</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = mysqli_query($connect, "SELECT * FROM `course`");
                                                if (!mysqli_num_rows($sql) > 0) {
                                                    echo '
                                                        <tr>
                                                            <td colspan="4" class="text-center">No registered Course</td>
                                                        </tr>
                                                    ';
                                                } else {
                                                    while ($row = mysqli_fetch_assoc($sql)) {
                                                        $course_id = $row["course_id"];
                                                        $course_code = $row["course_code"];
                                                        $course_title = $row["course_title"];
                                                        $course_level = $row["course_level"];

                                                        echo "
                                                            <tr>
                                                                <td>$course_code</td>
                                                                <td>$course_title</td>
                                                                <td>$course_level</td>
                                                                <td>
                                                                    <a href='?course_id=$course_id' class='btn btn-danger btn-sm'>Delete</button>
                                                                </td>
                                                            </tr>
                                                        ";
                                                    }
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Edit Course Modal -->
                                    <div class="modal fade text-dark" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-course-form">
                                                        <div class="form-group">
                                                            <label for="edit-course-code">Course Code</label>
                                                            <input type="text" class="form-control" id="edit-course-code" name="edit_course_code" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="edit-course-title">Course Title</label>
                                                            <input type="text" class="form-control" id="edit-course-title" name="edit_course_title" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="edit-course-level">Course Level</label>
                                                            <select class="form-control" id="edit-course-level" name="edit_course_level" required>
                                                                <option value="">Select Level</option>
                                                                <option value="100">100 Level</option>
                                                                <option value="200">200 Level</option>
                                                                <option value="300">300 Level</option>
                                                                <option value="400">400 Level</option>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
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