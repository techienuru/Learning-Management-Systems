<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
    header("location:../signin.php");
} else {
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
                        <a class="nav-link  nav-profile" id="profileDropdown" aria-expanded="false">
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

                                    <div class="container-fluid">
                                        <h1 class="mt-4 mb-5 text-center">Registered Lecturers</h1>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">First Name</th>
                                                    <th scope="col">Surname</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Faculty</th>
                                                    <th scope="col">Department</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $selecting_lecturers = mysqli_query($connect, "SELECT * FROM `lecturer`");
                                                if (!mysqli_num_rows($selecting_lecturers) > 0) {
                                                    echo '
                                                        <tr>
                                                            <td colspan="6" class="text-center">No registered Lecturer</td>
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
                                                                    <button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editLecturerModal$lecturer_id'>Edit</button>
                                                                    <a href='modify-lecturer.php?action=delete&lecturer_id=$lecturer_id' class='btn btn-danger btn-sm'>Delete</a>
                                                                </td>
                                                            </tr>
                                                                    ";

                                                        echo "
                                            <div class='modal fade text-dark' id='editLecturerModal$lecturer_id' tabindex='-1' aria-labelledby='editLecturerModalLabel' aria-hidden='true'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <form action='modify-lecturer.php?action=edit' method='POST'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='editLecturerModalLabel'>Edit Lecturer</h5>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>