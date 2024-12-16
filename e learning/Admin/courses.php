<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
    header("location:../login.php");
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
  <style>
    .card {
    border-radius: 15px;
}

.modal-content {
    border-radius: 15px;
}

.table th, .table td {
    vertical-align: middle;
}

  </style>
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

                      <div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-gradient-success text-white text-center">
                    <h2 class="font-weight-bold">Add New Course</h2>
                </div>
                <div class="card-body">
                    <form id="add-course-form" action="courses.php" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="course-code">Course Code</label>
                                <input type="text" class="form-control" id="course-code" name="course_code" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="course-title">Course Title</label>
                                <input type="text" class="form-control" id="course-title" name="course_title" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="course-level">Course Level</label>
                                <select class="form-control" id="course-level" name="course_level" required>
                                    <option value="">Select Level</option>
                                    <option value="100">100 Level</option>
                                    <option value="200">200 Level</option>
                                    <option value="300">300 Level</option>
                                    <option value="400">400 Level</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="add_course" class="btn btn-success btn-block">Add Course</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow mt-4">
                <div class="card-header bg-gradient-primary text-white text-center">
                    <h2 class="font-weight-bold">Manage Courses</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
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
                                                    <a href='?course_id=$course_id' class='btn btn-danger btn-sm'>Delete</a>
                                                    <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editCourseModal'>Edit</button>
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
                                <button type="submit" class="btn btn-success btn-block">Save Changes</button>
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

