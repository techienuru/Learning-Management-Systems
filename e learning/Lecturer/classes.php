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


  function checkDateAndTime()
  {
    global $class_date, $class_time;
    date_default_timezone_set("AFRICA/LAGOS");
    $current_date = date("Y-m-d");
    $current_time = date("H:i");

    if (($class_date < $current_date) || ($class_date === $current_date && $class_time < $current_time)) {
      return false;
    }
    return true;
  }

  
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


  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = $_POST["course_id"];
    $class_date = $_POST["class_date"];
    $class_time = $_POST["class_time"];
    $online_link = $_POST["online_link"];

    if (checkDateAndTime()) {
      $sql = mysqli_query($connect, "INSERT INTO `class` (`course_id`, `class_date`, `class_time`, `online_link`) VALUES ($course_id, '$class_date','$class_time','$online_link')");

      if ($sql) {
        echo "
            <script>
                alert('Success');
                location.href='classes.php';
            </script>
        ";
      }
    } else {
      echo "
      <script>
          alert('Error in date/time selection');
          location.href='classes.php';
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
    /* Class Item Styles */
    .class-item {
      background: rgba(172, 54, 172, 0.637);
      border-radius: 5px;
      padding: 30px;
      margin: 30px 0px 20px 0px;
    }

    .class-item h4 {
      margin-bottom: 10px;
    }

    .class-item p {
      margin: 5px 0;
    }

    .class-item .btn {
      margin-right: 10px;
      margin-top: 10px;
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
                      <div class="content-wrapper">
    <div class="row mt-4">
        <div class="col-12 stretch-card grid-margin">
            <div class="card bg-gradient-warning text-white">
                <div class="card-body">

                    <h1 class="text-center mb-4">Manage Classes</h1>
                    
                    <div id="classes-list">
                        <div class="class-item">
                            <div class="container-fluid">
                                <div class="card mt-4 border-0 shadow-sm">
                                    <div class="card-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <div class="form-group">
                                                <label for="courseSelect" class="font-weight-bold">Select Course:</label>
                                                <select class="form-control" name="course_id" required>
                                                    <option value="">Select Course</option>
                                                    <?php
                                                    $selecting_courses = mysqli_query($connect, 
                                                        "SELECT * FROM `course_assignment` 
                                                         INNER JOIN course 
                                                         ON course_assignment.course_id = course.course_id 
                                                         WHERE lecturer_id=$lecturer_id"
                                                    );

                                                    while ($row = mysqli_fetch_assoc($selecting_courses)) {
                                                        $course_id = $row["course_id"];
                                                        $course_code = $row["course_code"];
                                                        $course_title = $row["course_title"];
                                                        echo "<option value='$course_id'>$course_code - $course_title</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="classDate" class="font-weight-bold">Class Date:</label>
                                                <input type="date" class="form-control" name="class_date" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="classTime" class="font-weight-bold">Class Time:</label>
                                                <input type="time" class="form-control" name="class_time" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="onlineLink" class="font-weight-bold">Online Session Link:</label>
                                                <input type="text" class="form-control" name="online_link" required placeholder="Enter link for online session">
                                            </div>
                                            <button type="submit" class="btn btn-light btn-block mt-3">Schedule Class</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Optional: Section to Display Existing Classes -->
                                <div class="mt-5">
                                    <h4 class="text-center font-weight-bold mb-3">Existing Classes</h4>
                                    <div class="row">
                                        <?php
                                        // Fetch and display existing classes (if needed)
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

