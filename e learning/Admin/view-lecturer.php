<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
    header("location:../login.php");
} else {
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
            <a class="nav-link" href="students.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Students request</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="add-lecturer.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Create tutors </span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="view-lecturer.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">View tutors</span>
            </a>
          </li>
    
          <li class="nav-item">
            <a class="nav-link" href="courses.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Create Courses</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="assign-course.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Course Assingment</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Sign out</span>
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
        <div class="card border-0 shadow">
            <div class="card-header bg-gradient-secondary text-white text-center">
                <h2 class="font-weight-bold">Registered Lecturers</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
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
                                        <td colspan="6" class="text-center">No registered Lecturers</td>
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
                                                <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editLecturerModal$lecturer_id'>Edit</button>
                                                <a href='modify-lecturer.php?action=delete&lecturer_id=$lecturer_id' class='btn btn-danger btn-sm'>Delete</a>
                                            </td>
                                        </tr>
                                    ";

                                    echo "
                                        <div class='modal fade' id='editLecturerModal$lecturer_id' tabindex='-1' aria-labelledby='editLecturerModalLabel' aria-hidden='true'>
                                            <div class='modal-dialog modal-lg'>
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
                                                            <div class='form-row'>
                                                                <div class='form-group col-md-6'>
                                                                    <label for='edit-first-name'>First Name</label>
                                                                    <input type='text' class='form-control' value='$firstname' name='firstname' required>
                                                                </div>
                                                                <div class='form-group col-md-6'>
                                                                    <label for='edit-surname'>Surname</label>
                                                                    <input type='text' class='form-control' value='$surname' name='surname' required>
                                                                </div>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='edit-email'>Email</label>
                                                                <input type='email' class='form-control' value='$email' name='email' required>
                                                            </div>
                                                            <div class='form-row'>
                                                                <div class='form-group col-md-6'>
                                                                    <label for='edit-faculty'>Faculty</label>
                                                                    <select class='form-control' name='faculty' required>
                                                                        <option value='$faculty'>$faculty</option>
                                                                        <option value='Science'>Science</option>
                                                                        <option value='Engineering'>Engineering</option>
                                                                        <option value='Business'>Business</option>
                                                                    </select>
                                                                </div>
                                                                <div class='form-group col-md-6'>
                                                                    <label for='edit-department'>Department</label>
                                                                    <select class='form-control' name='department' required>
                                                                        <option value='$department'>$department</option>
                                                                        <option value='Computer Science'>Computer Science</option>
                                                                        <option value='Electrical Engineering'>Electrical Engineering</option>
                                                                        <option value='Management'>Management</option>
                                                                    </select>
                                                                </div>
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

