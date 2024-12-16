<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["lecturer_id"])) {
  header("location:../signin.php");
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
            <a class="nav-link nav-profile" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
            <a href="logout.php" target="_blank" class="btn btn-lg btn-block purchase-button">Logout</a>
          </div>
        </nav>
        <!-- partial -->
        <div class="content-wrapper">

          <div class="row mt-4">
            <div class="col-md-12 stretch-card grid-margin">
              <div class="card bg-gradient-warning text-white">
                <div class="card-body">


                  <div class="container-fluid">
                    <h1 class="mt-4">Course Materials</h1>
                    <div class="card">
                      <div class="card-body" id="label">
                        <h5 class="card-title">Upload Course Materials</h5>
                        <form action="" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="course">Select Course</label>
                            <select class="form-control" id="course" name="course_id" required>
                              <option value="">Select Course</option>
                              <?php
                              $selecting_courses = mysqli_query($connect, "SELECT * FROM `course_assignment` INNER JOIN course ON course_assignment.course_id = course.course_id WHERE lecturer_id=$lecturer_id");

                              while ($row = mysqli_fetch_assoc($selecting_courses)) {
                                $course_id = $row["course_id"];
                                $course_code = $row["course_code"];
                                $course_title = $row["course_title"];
                                $course_level = $row["course_level"];
                                echo "
                                    <option value='$course_id'>$course_code</option>
                                    ";
                              }
                              ?>
                            </select>
                          </div>

                          <h4>Video</h4>
                          <div class="form-group">
                            <label for="materialType">Material Type</label>
                            <select class="form-control" id="materialType" name="material_type_1">
                              <option value="">Select Material Type</option>
                              <option value="video">Video</option>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="materialTitle">Title</label>
                            <input type="text" class="form-control" id="materialTitle" name="material_title_1">
                          </div>
                          <div class="form-group">
                            <label for="materialFile">Upload File</label>
                            <input type="file" class="form-control-file" id="materialFile" name="material_file_1">
                          </div>

                          <h4>Pdf</h4>
                          <div class="form-group">
                            <label for="materialType">Material Type</label>
                            <select class="form-control" id="materialType" name="material_type_2">
                              <option value="">Select Material Type</option>
                              <option value="pdf">PDF</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="materialTitle">Title</label>
                            <input type="text" class="form-control" id="materialTitle" name="material_title_2">
                          </div>
                          <div class="form-group">
                            <label for="materialFile">Upload File</label>
                            <input type="file" class="form-control-file" id="materialFile" name="material_file_2">
                          </div>
                          <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                      </div>
                    </div>

                    <h2 class="mt-4">Available Course Materials</h2>

                    <?php
                    // Selecting Courses assigned to lecturer
                    $selecting_course_assignment = mysqli_query($connect, "SELECT * FROM `course_assignment` WHERE lecturer_id=$lecturer_id");

                    while ($row = mysqli_fetch_assoc($selecting_course_assignment)) {
                      $course_id = $row["course_id"];

                      // Selecting Course Materials that tally with the fetched course_id
                      $selecting_course_materials = mysqli_query($connect, "SELECT * FROM `course_material` INNER JOIN `course` ON `course_material`.course_id = `course`.course_id WHERE `course_material`.course_id=$course_id");

                      while ($row = mysqli_fetch_assoc($selecting_course_materials)) {
                        $material_id = $row["material_id"];

                        $course_code = $row["course_code"];
                        $course_title = $row["course_title"];

                        $material_type_1 = $row["material_type_1"];
                        $title_1 = $row["title_1"];
                        $file_1 = $row["file_1"];

                        $material_type_2 = $row["material_type_2"];
                        $title_2 = $row["title_2"];
                        $file_2 = $row["file_2"];

                        echo "
                          <div class='card text-dark'>
                            <div class='card-body'>
                              <h5 class='card-title'>$course_code ($course_title)</h5>
                              <p><strong>Video:</strong></p>
                              <ul>
                                <li><a href='$file_1' target='_blank'>$title_1</a></li>
                              </ul>
                              <p><strong>PDF:</strong></p>
                              <ul>
                                <li><a href='$file_2' target='_blank'>$title_2</a></li>
                              </ul>
                            </div>
                          </div>
                      ";
                      }
                    }
                    ?>


                  </div>
                </div>
                <!-- /#page-content-wrapper -->
              </div>
              <!-- /#wrapper -->

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
  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    const courseMaterials = {
      'Course 1': {
        videos: [{
            title: 'Introduction to Computer Science',
            url: 'https://www.youtube.com/watch?v=Q6QMO4h2tjY'
          },
          {
            title: 'Basic Programming Concepts',
            url: 'https://www.youtube.com/watch?v=Z1Yd7upQsXY'
          }
        ],
        pdfs: [{
            title: 'Computer Science Syllabus',
            url: 'https://example.com/syllabus1.pdf'
          },
          {
            title: 'Programming Basics',
            url: 'https://example.com/programming_basics.pdf'
          }
        ]
      },
      'Course 2': {
        videos: [{
            title: 'Introduction to Data Science',
            url: 'https://www.youtube.com/watch?v=ua-CiDNNj30'
          },
          {
            title: 'Data Analysis Techniques',
            url: 'https://www.youtube.com/watch?v=xC-c7E5PK0Y'
          }
        ],
        pdfs: [{
            title: 'Data Science Syllabus',
            url: 'https://example.com/syllabus2.pdf'
          },
          {
            title: 'Data Analysis Notes',
            url: 'https://example.com/data_analysis.pdf'
          }
        ]
      },
      'Course 3': {
        videos: [{
            title: 'Introduction to Machine Learning',
            url: 'https://www.youtube.com/watch?v=GwIo3gDZCVQ'
          },
          {
            title: 'Machine Learning Algorithms',
            url: 'https://www.youtube.com/watch?v=HZGCoVF3YvM'
          }
        ],
        pdfs: [{
            title: 'Machine Learning Syllabus',
            url: 'https://example.com/syllabus3.pdf'
          },
          {
            title: 'Machine Learning Notes',
            url: 'https://example.com/machine_learning.pdf'
          }
        ]
      }
    };

    function showMaterials(courseName) {
      const courseTitle = document.getElementById('course-title');
      const courseMaterialsDiv = document.getElementById('course-materials');
      const videoResources = document.getElementById('video-resources');
      const pdfResources = document.getElementById('pdf-resources');

      courseTitle.innerText = courseName + ' Materials';
      videoResources.innerHTML = '';
      pdfResources.innerHTML = '';

      const materials = courseMaterials[courseName];

      materials.videos.forEach(video => {
        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.innerHTML = `<a href="${video.url}" target="_blank">${video.title}</a>`;
        videoResources.appendChild(li);
      });

      materials.pdfs.forEach(pdf => {
        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.innerHTML = `<a href="${pdf.url}" target="_blank">${pdf.title}</a>`;
        pdfResources.appendChild(li);
      });

      courseMaterialsDiv.style.display = 'block';
    }
  </script>
</body>

</html>