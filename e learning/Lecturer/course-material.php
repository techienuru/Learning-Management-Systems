<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["lecturer_id"])) {
  header("location:../login.php");
} else {
  $lecturer_id = $_SESSION["lecturer_id"];
  include_once "./process-course-materials.php";

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
      background: #343a40;
      color: white;
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
      text-align: center;
      background: #343a40;
      color: white;
    }

    .list-group-item {
      border: none;
      padding: 15px 20px;
      background: #343a40;
      color: white;
      transition: all 0.25s ease;
    }

    .list-group-item:hover,
    .list-group-item:focus {
      background-color: #495057;
      color: white;
    }

    .list-group-item-action {
      transition: all 0.25s ease;
    }

    /* Navbar Styles */
    .navbar {
      padding: 10px 20px;
      border-bottom: 1px solid #e3e6f0;
      background: #f8f9fa;
    }

    .nav-link {
      color: #343a40;
      transition: color 0.25s ease;
    }

    .nav-link:hover {
      color: #007bff;
    }

    /* Card Styles */
    .card {
      margin-top: 20px;
      padding: 15px;
    }

    .card-title {
      font-size: 1.5rem;
      margin-bottom: 20px;
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
            <a class="nav-link" href="courses.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Assigned Courses</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="course-material.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Add Resources</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="classes.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Create Class</span>
            </a>
          </li>
    
          <li class="nav-item">
            <a class="nav-link" href="assignment.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Drop Assignment</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="viewassignment.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Check assignemnts</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="grade.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Scores</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Logout</span>
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
                            <!-- Additional Content if Needed -->
                        </div>

                        <div class="content-wrapper">
                            <div class="row mt-4">
                                <div class="col-md-12 stretch-card grid-margin">
                                    <div class="card shadow-lg" style="background: linear-gradient(135deg, #f4a261, #e76f51);">
                                        <div class="card-body text-white">
                                            <div class="container-fluid">
                                                <h1 class="text-center mb-5" style="font-weight: bold; text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">Upload & Manage Course Materials</h1>

                                                <!-- Upload Materials Section -->
                                                <div class="card mb-5 border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h4 class="card-title text-dark">Upload Course Materials</h4>
                                                        <form action="" method="post" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="course">Select Course</label>
                                                                    <select class="form-control" id="course" name="course_id" required>
                                                                        <option value="">Choose a Course</option>
                                                                        <?php
                                                                        $selecting_courses = mysqli_query(
                                                                            $connect, 
                                                                            "SELECT * FROM `course_assignment` 
                                                                            INNER JOIN course ON course_assignment.course_id = course.course_id 
                                                                            WHERE lecturer_id=$lecturer_id"
                                                                        );
                                                                        while ($row = mysqli_fetch_assoc($selecting_courses)) {
                                                                            echo "<option value='{$row["course_id"]}'>{$row["course_code"]} - {$row["course_title"]}</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <!-- Video Material Upload -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="materialType1">Material Type</label>
                                                                    <select class="form-control" id="materialType1" name="material_type_1">
                                                                        <option value="">Select Type</option>
                                                                        <option value="video">Video</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="materialTitle1">Video Title</label>
                                                                    <input type="text" class="form-control" id="materialTitle1" name="material_title_1" placeholder="Enter video title">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="materialFile1">Upload Video</label>
                                                                    <input type="file" class="form-control-file" id="materialFile1" name="material_file_1">
                                                                </div>

                                                                <!-- PDF Material Upload -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="materialType2">Material Type</label>
                                                                    <select class="form-control" id="materialType2" name="material_type_2">
                                                                        <option value="">Select Type</option>
                                                                        <option value="pdf">PDF</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="materialTitle2">PDF Title</label>
                                                                    <input type="text" class="form-control" id="materialTitle2" name="material_title_2" placeholder="Enter PDF title">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="materialFile2">Upload PDF</label>
                                                                    <input type="file" class="form-control-file" id="materialFile2" name="material_file_2">
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary btn-block mt-4">Upload Material</button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Display Uploaded Materials -->
                                                <h3 class="text-center mb-4" style="font-weight: 600; text-shadow: 1px 1px 5px rgba(0,0,0,0.3);">Uploaded Course Materials</h3>
                                                <div class="row">
                                                    <?php
                                                    $assigned_courses = mysqli_query($connect, 
                                                        "SELECT * FROM `course_assignment` WHERE lecturer_id=$lecturer_id"
                                                    );

                                                    while ($course_row = mysqli_fetch_assoc($assigned_courses)) {
                                                        $course_id = $course_row["course_id"];
                                                        $materials = mysqli_query($connect, 
                                                            "SELECT * FROM `course_material` 
                                                            INNER JOIN `course` ON `course_material`.course_id = course.course_id 
                                                            WHERE `course_material`.course_id=$course_id"
                                                        );

                                                        while ($material = mysqli_fetch_assoc($materials)) {
                                                            echo "
                                                                <div class='col-md-6 mb-4'>
                                                                    <div class='card border-0 shadow'>
                                                                        <div class='card-body'>
                                                                            <h5 class='card-title'>{$material["course_code"]} - {$material["course_title"]}</h5>
                                                                            <p><strong>Video:</strong> <a href='{$material["file_1"]}' target='_blank'>{$material["title_1"]}</a></p>
                                                                            <p><strong>PDF:</strong> <a href='{$material["file_2"]}' target='_blank'>{$material["title_2"]}</a></p>
                                                                            <form action='delete_material.php' method='post'>
                                                                                <input type='hidden' name='material_id' value='{$material["material_id"]}'>
                                                                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            ";
                                                        }
                                                    }
                                                    ?>
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

