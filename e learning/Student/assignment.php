<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["student_id"])) {
    header("location:../login.php");
} else {
    $student_id = $_SESSION["student_id"];

    $selecting_user_details = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id=$student_id");
    $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);
    $fullname = "$fetching_user_details[firstname]  $fetching_user_details[lastname]";

    // If assignment is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $assignment_id = $_POST["assignment_id"];
        $assignment_file = $_FILES["assignment_file"];

        // Processing File
        $file_real_name = $assignment_file["name"];
        $file_real_temporary_name = $assignment_file["tmp_name"];

        $file_path = "assignments/$file_real_name";

        if (move_uploaded_file($file_real_temporary_name, $file_path)) {
            $sql = mysqli_query($connect, "INSERT INTO `uploaded_assignment` (`assignment_id`, `student_id`, `ua_file`) VALUES ($assignment_id, $student_id,'$file_path')");

            if ($sql) {
                echo "
                <script>
                    alert('Success');
                    location.href='assignment.php';
                </script>
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
            <a class="nav-link" href="dashboard.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">My Courses</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="course-material.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">My Resources</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="classes.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Class Notification</span>
            </a>
          </li>
    
          <li class="nav-item">
            <a class="nav-link" href="assignment.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Home Work</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="grade.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">My scores</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">logout</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
      <div class="content-wrapper">

<div class="row mt-4">
    <div class="col-12 stretch-card grid-margin">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">

                <div class="container-fluid">
                    <h1 class="mt-4">Assignments</h1>
                    <?php
                    // Selecting courses that the student had registered
                    $selecting_students_course = mysqli_query($connect, "SELECT * FROM `student_course` WHERE student_id=$student_id");

                    // Loop through the fetch courses registered by the student and store the courses in a variable
                    $registered_course = [];
                    while ($fetching_students_course = mysqli_fetch_assoc($selecting_students_course)) {
                        $course_id = $fetching_students_course["course_id"];
                        array_push($registered_course, $course_id);
                    }
                    $registered_course = implode(",", $registered_course);

                    // Selecting assignment 
                    $selecting_assignment = mysqli_query($connect, "SELECT * FROM `assignment` INNER JOIN `course` ON `assignment`.course_id = `course`.course_id INNER JOIN `lecturer` ON `assignment`.`lecturer_id` = `lecturer`.lecturer_id WHERE `assignment`.course_id IN ($registered_course) ORDER BY due_date;");

                    while ($fetching_assignment = mysqli_fetch_assoc($selecting_assignment)) {
                        $assignment_id = $fetching_assignment["assignment_id"];
                        $given_date = $fetching_assignment["date_created"];
                        $due_date = $fetching_assignment["due_date"];
                        $assignment_file = $fetching_assignment["assignment_file"];
                        $course_code = $fetching_assignment["course_code"];
                        $course_title = $fetching_assignment["course_title"];
                        $firstname = $fetching_assignment["firstname"];
                        $surname = $fetching_assignment["surname"];
                        $fullname = "$firstname $surname";

                        echo "
                            <div class='assignment-item'>
                                <h4>$course_code: $course_title</h4>
                                <p><strong>Given Date:</strong> $given_date</p>
                                <p><strong>Deadline Date:</strong> $due_date</p>
                                <p>Complete the exercises in the attached document and upload your solutions.</p>
                                <a href='../lecturer/$assignment_file' class='btn btn-info' download>Download Attachment</a>
                                <div class='mt-3'>
                                    <form action='assignment.php' method='POST' enctype='multipart/form-data'>
                                        <input type='text' name='assignment_id' value='$assignment_id' hidden>

                                        <label>Upload your assignment:</label>
                                        <input type='file' name='assignment_file' class='form-control-file' required>

                                        <button type='submit' class='btn btn-success mt-2'>Submit</button>
                                    </form>
                                </div>
                            </div>
                        ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- partial -->
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

