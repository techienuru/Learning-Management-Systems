<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["lecturer_id"])) {
  header("location:../login.php");
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


  // If Grade is submitted
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ua_id = $_POST["ua_id"];
    $course_id = $_POST["course_id"];
    $grade_score = $_POST["grade"];

    $sql = mysqli_query($connect, "INSERT INTO `grade` (`ua_id`,`course_id`, `grade_score`) VALUES ($ua_id, $course_id , $grade_score)");

    if ($sql) {
      echo "
                <script>
                    alert('Success');
                    location.href='viewassignment.php';
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
                      <div class="content-wrapper">

<div class="content-wrapper">
    <div class="row mt-4">
        <div class="col-12 stretch-card grid-margin">
            <div class="card shadow-lg rounded">
                <div class="card-body bg-light">

                    <h1 class="text-center text-primary mb-4">Submitted Assignments</h1>
                    
                    <div class="table-responsive">
                        <div class="card border-0">
                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Submitted File</th>
                                            <th>Submission Date</th>
                                            <th>Grade</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Selecting assignments
                                        $selecting_assignments = mysqli_query($connect, "SELECT * FROM `assignment` WHERE lecturer_id = $lecturer_id");

                                        // Looping through the assignments that the lecturer dropped and storing them in a variable
                                        $assignments = [];
                                        while ($fetching_assignments = mysqli_fetch_assoc($selecting_assignments)) {
                                            $assignment_id = $fetching_assignments["assignment_id"];
                                            array_push($assignments, $assignment_id);
                                        }

                                        // Converting the array that stores the assignments into a string
                                        $assignments = ($assignments) ? implode(",", $assignments) : 0;

                                        // Selecting Uploaded Assignments
                                        $selecting_uploaded_assignments = mysqli_query($connect, "SELECT * FROM `uploaded_assignment` INNER JOIN `assignment` ON `uploaded_assignment`.assignment_id = `assignment`.assignment_id INNER JOIN `student` ON `uploaded_assignment`.student_id = `student`.student_id WHERE `uploaded_assignment`.assignment_id IN ($assignments)");

                                        while ($fetching_uploaded_assignments = mysqli_fetch_assoc($selecting_uploaded_assignments)) {
                                            $ua_id = $fetching_uploaded_assignments["ua_id"];
                                            $course_id = $fetching_uploaded_assignments["course_id"];
                                            $assignment_id = $fetching_uploaded_assignments["assignment_id"];
                                            $firstname = $fetching_uploaded_assignments["firstname"];
                                            $lastname = $fetching_uploaded_assignments["lastname"];
                                            $othername = $fetching_uploaded_assignments["othername"] ?? '';
                                            $fullname = trim("$firstname $lastname $othername");
                                            $ua_file = $fetching_uploaded_assignments["ua_file"];
                                            $date_submitted = $fetching_uploaded_assignments["date_submitted"];

                                            echo "
                                            <tr>
                                                <form action='viewassignment.php' method='POST'>
                                                    <td>$fullname</td>
                                                    <td>
                                                        <a href='../student/$ua_file' class='btn btn-outline-info' target='_blank'>View</a>
                                                    </td>
                                                    <td>$date_submitted</td>
                                                    <td>
                                                        <input type='number' class='form-control' name='grade' min='0' max='100' required>
                                                    </td>
                                                    <input type='hidden' value='$ua_id' name='ua_id'>
                                                    <input type='hidden' value='$course_id' name='course_id'>
                                                    <td>
                                                        <button type='submit' class='btn btn-success'>Submit Grade</button>
                                                    </td>
                                                </form>
                                            </tr>";
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

