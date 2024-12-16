<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["lecturer_id"])) {
  header("location:../signin.php");
} else {
  $lecturer_id = $_SESSION["lecturer_id"];
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
        /* Card Styles */
        .card {
            margin-top: 20px;
            padding: 15px;
            background: rgba(172, 54, 172, 0.637);
            border-radius: 5px;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        /* Modal Styles */
        .modal-content {
            padding: 20px;
        }

        .form-control {
            margin-bottom: 10px;
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
                            Messages
                            <!-- <span class="count"></span> -->
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                            <h6 class="p-3 mb-0">Messages</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                                    <p class="text-gray mb-0">
                                        1 Minutes ago
                                    </p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                                    <p class="text-gray mb-0">
                                        15 Minutes ago
                                    </p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                                    <p class="text-gray mb-0">
                                        18 Minutes ago
                                    </p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <h6 class="p-3 mb-0 text-center">4 new messages</h6>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-profile" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-lg-inline">Daniel Russiel</span>
                        </a>
                        <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="profile.php">
                                <i class="mdi mdi-cached mr-2 text-success"></i>
                                View Profile
                            </a>
                            <!-- <div class="dropdown-divider"></div> -->
                        </div>
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
                                        <h1 class="mt-4">Profile</h1>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Personal Information</h5>
                                                <?php
                                                // Sample user data, replace with actual database retrieval
                                                $user = [
                                                    'firstName' => 'John',
                                                    'surname' => 'Doe',
                                                    'otherName' => 'Smith',
                                                    'level' => '200',
                                                    'matricNumber' => 'CS123456',
                                                    'email' => 'john.doe@example.com',
                                                    'phoneNumber' => '123-456-7890',
                                                    'dob' => '1999-01-01',
                                                    'password' => '********'
                                                ];

                                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                    // Update user data with posted values
                                                    $user['firstName'] = $_POST['firstName'];
                                                    $user['surname'] = $_POST['surname'];
                                                    $user['otherName'] = $_POST['otherName'];
                                                    $user['level'] = $_POST['level'];
                                                    $user['matricNumber'] = $_POST['matricNumber'];
                                                    $user['email'] = $_POST['email'];
                                                    $user['phoneNumber'] = $_POST['phoneNumber'];
                                                    $user['dob'] = $_POST['dob'];
                                                    $user['password'] = $_POST['password'];

                                                    // In a real application, save the updated user data to the database
                                                }
                                                ?>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>First Name:</strong> <?php echo $user['firstName']; ?></p>
                                                        <p><strong>Surname:</strong> <?php echo $user['surname']; ?></p>
                                                        <p><strong>Other Name:</strong> <?php echo $user['otherName']; ?></p>
                                                        <p><strong>Level:</strong> <?php echo $user['level']; ?></p>
                                                        <p><strong>Matriculation Number:</strong> <?php echo $user['matricNumber']; ?></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                                                        <p><strong>Phone Number:</strong> <?php echo $user['phoneNumber']; ?></p>
                                                        <p><strong>Date of Birth:</strong> <?php echo $user['dob']; ?></p>
                                                        <p><strong>Change Password:</strong> <?php echo $user['password']; ?></p>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">Update Profile</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- edit profile -->


                                    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content bg-gradient-warning">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editProfileForm" method="POST" action="">
                                                        <div class="form-group">
                                                            <label for="editFirstName">First Name</label>
                                                            <input type="text" class="form-control" id="editFirstName" name="firstName" value="<?php echo $user['firstName']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editSurname">Surname</label>
                                                            <input type="text" class="form-control" id="editSurname" name="surname" value="<?php echo $user['surname']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editOtherName">Other Name</label>
                                                            <input type="text" class="form-control" id="editOtherName" name="otherName" value="<?php echo $user['otherName']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editLevel">Level</label>
                                                            <input type="text" class="form-control" id="editLevel" name="level" value="<?php echo $user['level']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editMatricNumber">Matriculation Number</label>
                                                            <input type="text" class="form-control" id="editMatricNumber" name="matricNumber" value="<?php echo $user['matricNumber']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editEmail">Email</label>
                                                            <input type="email" class="form-control" id="editEmail" name="email" value="<?php echo $user['email']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editPhoneNumber">Phone Number</label>
                                                            <input type="text" class="form-control" id="editPhoneNumber" name="phoneNumber" value="<?php echo $user['phoneNumber']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editDob">Date of Birth</label>
                                                            <input type="date" class="form-control" id="editDob" name="dob" value="<?php echo $user['dob']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editPassword">Change Password</label>
                                                            <input type="password" class="form-control" id="editPassword" name="password" value="<?php echo $user['password']; ?>">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </form>
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

        <!-- Bootstrap core JavaScript -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
        <!-- Menu Toggle Script -->
        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        </script>
</body>

</html>