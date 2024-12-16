<?php
include("includes/connect.php");

$firstname_err = null;
$lastname_err = null;
$othername_err = null;
$email_err = null;
$matric_err = null;
$password_err = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $othername = $_POST["othername"];
    $email = $_POST["email"];
    $matricno = $_POST["matricno"];
    $password = $_POST["password"];

    $sql = mysqli_query($connect, "INSERT INTO `student` (firstname,lastname,othername,email,matricno,password) VALUES('$firstname','$lastname','$othername','$email','$matricno','$password')");

    if ($sql) {
        echo '
            <script>
                alert("Account creation submitted!\n\nAdmin validation permit users login, please check back later");
                window.location.href="./login.php";
            </script>
        ';
        die();
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
  <link rel="stylesheet" href="./vendors/typicons/typicons.css">
  <link rel="stylesheet" href="./vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="./css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="./images/favicon.png" />
  <link rel="shortcut icon" href="./images/faces/" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
              <form class="pt-3" action="register.php" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputFirstname" name="firstname" placeholder="First name">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputLastname" name="lastname" placeholder="Last name">
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputOthername" name="othername" placeholder="Other name">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail" name="email" placeholder="Email">
                </div>
                
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputMatricno" name="matricno" placeholder="Matric No">
                </div>

                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="login.php" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
