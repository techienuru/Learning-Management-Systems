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



    function checkErrorInDate()
    {
        global $due_date;
        date_default_timezone_set("AFRICA/LAGOS");
        $current_date = date("Y-m-d");

        if (($due_date < $current_date)) {
            return false;
        }
        return true;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $course_id = $_POST["course_id"];
        $due_date = $_POST["due_date"];
        $assignment_file = $_FILES["assignment_file"];

        if (checkErrorInDate()) {

            // Processing File
            $file_real_name = $assignment_file["name"];
            $file_real_temporary_name = $assignment_file["tmp_name"];

            $file_path = "assignments/$file_real_name";

            if (move_uploaded_file($file_real_temporary_name, $file_path)) {
                $sql = mysqli_query($connect, "INSERT INTO `assignment` (`course_id`, `lecturer_id`, `due_date`, `assignment_file`) VALUES ($course_id, '$lecturer_id','$due_date','$file_path')");

                if ($sql) {
                    echo "
                    <script>
                        alert('Success');
                        location.href='assignment.php';
                    </script>
                ";
                }
            }
        } else {
            echo "
          <script>
              alert('Error in date/time selection');
              location.href='assignment.php';
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
  /* Custom Styles */
  body {
    background-color: #f4f7fa; /* Light background for the body */
  }

  .card {
    background-color: #ffffff; /* White background for cards */
    border-radius: 15px; /* Rounded corners */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effects */
  }

  .card:hover {
    transform: translateY(-5px); /* Lift effect on hover */
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); /* Enhanced shadow on hover */
  }

  .bg-gradient-warning {
    background: linear-gradient(45deg, #ffcc00, #ff9900); /* Gradient background for card */
    color: #ffffff; /* White text color */
  }

  h1 {
    color: #ff5722; /* Vibrant header color */
  }

  .btn-primary {
    background-color: #007bff; /* Vibrant blue */
    border-color: #007bff; /* Border matches button color */
    transition: background-color 0.3s ease; /* Transition for button color */
  }

  .btn-primary:hover {
    background-color: #0056b3; /* Darker shade on hover */
    border-color: #0056b3; /* Matching border on hover */
  }

  .form-control {
    border-radius: 10px; /* Rounded input fields */
    transition: border-color 0.3s ease; /* Transition for input focus */
  }

  .form-control:focus {
    border-color: #ff5722; /* Vibrant border color on focus */
    box-shadow: 0 0 5px rgba(255, 87, 34, 0.5); /* Shadow effect on focus */
  }

  .form-control-file {
    border-radius: 10px; /* Rounded file input */
  }

  .label-text {
    font-weight: bold; /* Make labels bold */
    color: #333; /* Dark color for labels */
  }

  /* Style for existing assignments display (if needed) */
  .existing-assignments {
    margin-top: 20px; /* Space above existing assignments */
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
        <div class="card shadow-lg border-0">
            <div class="card-body bg-gradient-warning text-white">
                <h1 class="text-center mt-4 font-weight-bold">Manage Assignments</h1>

                <div class="card mt-4 border-0 shadow-sm">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
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
                                        $course_id = $row['course_id'];
                                        $course_code = $row['course_code'];
                                        $course_title = $row['course_title'];

                                        echo "<option value='$course_id'>$course_code - $course_title</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="dueDate" class="font-weight-bold">Due Date:</label>
                                <input type="date" class="form-control" name="due_date" required>
                            </div>

                            <div class="form-group">
                                <label for="assignmentFile" class="font-weight-bold">Upload Assignment:</label>
                                <input type="file" class="form-control-file" id="assignmentFile" name="assignment_file" required>
                            </div>

                            <button type="submit" class="btn btn-light btn-block mt-3">Upload Assignment</button>
                        </form>
                    </div>
                </div>

                <!-- Optional: Section to Display Existing Assignments -->
                <div class="mt-5">
                    <h4 class="text-center font-weight-bold mb-3">Existing Assignments</h4>
                    <div class="row">
                        <?php
                        // Fetch and display existing assignments (if needed)
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

