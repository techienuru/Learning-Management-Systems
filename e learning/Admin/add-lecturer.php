<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
    header("location:../signin.php");
} else {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $firstname = $_POST["firstname"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $faculty = $_POST["faculty"];
        $department = $_POST["department"];
        $password = $_POST["password"];

        $sql = mysqli_query($connect, "INSERT INTO `lecturer` (firstname,surname,email,faculty,department,password) VALUES('$firstname','$surname','$email','$faculty','$department','$password')");

        if ($sql) {
            echo '
            <script>
                alert(`Lecturer Added`);          
            </script>
        ';
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
    <div class="col-lg-6 col-md-8 col-sm-10 m-auto stretch-card grid-margin">
        <div class="card shadow-lg rounded bg-gradient-light">
            <div class="card-body p-5">

                <h1 class="mt-4 mb-4 text-center font-weight-bold">Add New Lecturer</h1>
                <form action="add-lecturer.php" method="POST">
                    <div class="form-group">
                        <label for="first-name" class="font-weight-semibold">First Name</label>
                        <input type="text" class="form-control" name="firstname" placeholder="Enter First Name" required>
                    </div>
                    <div class="form-group">
                        <label for="surname" class="font-weight-semibold">Surname</label>
                        <input type="text" class="form-control" name="surname" placeholder="Enter Surname" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="font-weight-semibold">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class="form-group">
                        <label for="faculty" class="font-weight-semibold">Faculty</label>
                        <select class="form-control" name="faculty" required>
                            <option value="">Select Faculty</option>
                            <option value="Science">Applied Science</option>
                            <option value="Engineering">Admin Faculty</option>
                            <option value="Business">Social Science</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department" class="font-weight-semibold">Department</label>
                        <select class="form-control" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Electrical Engineering">Statistics</option>
                            <option value="Management">Mathematics</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password" class="font-weight-semibold">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4">Add Lecturer</button>
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

