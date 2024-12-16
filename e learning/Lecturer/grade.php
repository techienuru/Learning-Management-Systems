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


    // If grade changes is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $grade_id = $_POST["grade_id"];
        $grade_score = $_POST["grade_score"];

        $sql = mysqli_query($connect, "UPDATE `grade` SET grade_score = $grade_score WHERE grade_id = $grade_id");
        if ($sql) {
            echo "
                <script>
                    alert('success');
                    window.location.href='grade.php';
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

                    <h1 class="text-center text-dark mb-4">Grades Overview</h1>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Student</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Course Code</th>
                                    <th scope="col">Lecturer</th>
                                    <th scope="col">Score</th>
                                    <th scope="col">Grade</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="grades-table-body">
                                <?php
                                // Selecting courses assigned to the lecturer
                                $selecting_assigned_course = mysqli_query($connect, "SELECT * FROM `course_assignment` WHERE lecturer_id = $lecturer_id");
                                $assigned_courses = [];

                                while ($fetching_assigned_course = mysqli_fetch_assoc($selecting_assigned_course)) {
                                    $course_id = $fetching_assigned_course["course_id"];
                                    array_push($assigned_courses, $course_id);
                                }

                                $assigned_courses = ($assigned_courses) ? implode(",", $assigned_courses) : 0;

                                // Selecting grades
                                $selecting_grades = mysqli_query($connect, "SELECT * FROM `grade` INNER JOIN `uploaded_assignment` ON `grade`.ua_id = `uploaded_assignment`.ua_id INNER JOIN `course` ON `grade`.course_id = `course`.course_id WHERE `grade`.course_id IN ($assigned_courses)");

                                while ($fetching_grades = mysqli_fetch_assoc($selecting_grades)) {
                                    $grade_id = $fetching_grades["grade_id"];
                                    $student_id = $fetching_grades["student_id"];
                                    $grade_score = $fetching_grades["grade_score"];
                                    $grade = calculateGrade($grade_score); // Using a function to determine the grade

                                    $course_code = $fetching_grades["course_code"];
                                    $course_title = $fetching_grades["course_title"];

                                    // Fetching student name
                                    $selecting_student_info = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id = $student_id");
                                    $fetching_student_info = mysqli_fetch_assoc($selecting_student_info);
                                    $fullname = "$fetching_student_info[firstname] $fetching_student_info[lastname]";

                                    echo "
                                    <tr>
                                        <td>$fullname</td>
                                        <td>$course_title</td>
                                        <td>$course_code</td>
                                        <td>$fullname</td>
                                        <td>$grade_score</td>
                                        <td>$grade</td>
                                        <td>
                                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editGradeModal-$grade_id'>Edit</button>
                                        </td>
                                    </tr>  
                                    ";

                                    // Bootstrap Modal for editing student's grade
                                    echo "
                                    <div class='modal fade' id='editGradeModal-$grade_id' tabindex='-1' role='dialog' aria-labelledby='editGradeModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog' role='document'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title text-dark' id='editGradeModalLabel'>Edit Grade</h5>
                                                    <button type='button' class='close' data-bs-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>
                                                <form action='grade.php' method='POST'>
                                                    <div class='modal-body'>
                                                        <input type='hidden' value='$grade_id' name='grade_id'>
                                                        <div class='form-group'>
                                                            <label for='student-name' class='text-dark'>Student Name</label>
                                                            <input type='text' class='form-control' value='$fullname' readonly>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='course-code' class='text-dark'>Course Code</label>
                                                            <input type='text' class='form-control' value='$course_code' readonly>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='grade' class='text-dark'>Grade</label>
                                                            <input type='number' class='form-control' value='$grade_score' name='grade_score' min='0' max='100'>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                        <button type='submit' class='btn btn-primary'>Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    ";
                                }

                                // Function to calculate the grade based on score
                                function calculateGrade($score) {
                                    if ($score >= 70) return "A";
                                    if ($score >= 60) return "B";
                                    if ($score >= 50) return "C";
                                    if ($score >= 45) return "D";
                                    if ($score >= 40) return "E";
                                    return "F";
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


<!-- partial -->
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

