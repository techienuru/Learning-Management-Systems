<?php
include_once "../includes/connect.php";
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
    <div class="col-12 m-auto stretch-card grid-margin">
        <div class="card bg-gradient-info text-white border-0 shadow">
            <div class="card-body">

                <div class="container-fluid">
                    <h1 class="text-center mb-4 font-weight-bold">Student Approval Management</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Other Name</th>
                                    <th>Matric No.</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selecting_students = mysqli_query($connect, "SELECT * FROM `student` WHERE `is_approved?` IS NULL");
                                if (!mysqli_num_rows($selecting_students) > 0) {
                                    echo '
                                        <tr>
                                            <td colspan="5" class="text-center">No pending students</td>
                                        </tr>
                                    ';
                                } else {
                                    while ($row = mysqli_fetch_assoc($selecting_students)) {
                                        $student_id = $row["student_id"];
                                        $firstname = $row["firstname"];
                                        $lastname = $row["lastname"];
                                        $othername = $row["othername"];
                                        $matricno = $row["matricno"];

                                        echo "
                                            <tr>
                                                <td>$firstname</td>
                                                <td>$lastname</td>
                                                <td>$othername</td>
                                                <td>$matricno</td>
                                                <td>
                                                    <a href='./processing.php?student_id=$student_id&status=1' class='btn btn-success btn-sm'>Approve</a>
                                                    <a href='./processing.php?student_id=$student_id&status=0' class='btn btn-danger btn-sm'>Reject</a>
                                                </td>
                                            </tr>  
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

