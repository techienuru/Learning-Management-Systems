<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["lecturer_id"])) {
  header("location:../signin.php");
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
    #label {
      color: black;
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
              Schedules
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <h6 class="p-3 mb-0">Class</h6>
              <div class="dropdown-divider"></div>
              <?php selectClasses(); ?>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link  nav-profile" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="d-none d-lg-inline"><?php echo $fullname; ?></span>
            </a>
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
              <a class="nav-link" href="viewassignment.php">
                <span class="menu-title">Assignment response</span>
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
                    <h1 class="mt-4">Submitted Assignments</h1>
                    <div class="card text-dark">
                      <div class="card-body">
                        <table class="table table-bordered">
                          <thead>
                            <tr id="label">
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
                              $othername = $fetching_uploaded_assignments["othername"] ?? null;
                              $fullname = "$firstname $lastname $othername";
                              $ua_file = $fetching_uploaded_assignments["ua_file"];
                              $date_submitted = $fetching_uploaded_assignments["date_submitted"];


                              echo "
                                    <tr>
                                      <form action='viewassignment.php' method='POST'>
                                          <td>$fullname</td>
                                          <td>
                                            <a href='../student/$ua_file' target='_blank'>View</a>
                                          </td>
                                          <td>$date_submitted</td>
                                          <td>
                                            <input type='number' class='form-control' name='grade' min='0' max='100'>
                                          </td>
                                            <input type='text' value='$ua_id' name='ua_id' hidden>
                                            <input type='text' value='$course_id' name='course_id' hidden>
                                          <td>
                                            <button type='submit' class='btn btn-success'>Upload</button>
                                          </td>
                                        </form>
                                      </tr>  
                                ";
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
    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
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
</body>

</html>