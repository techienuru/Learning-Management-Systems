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
                window.location.href="./signin.php";
            </script>
        ';
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LMS | Sign-up</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="./Bootstrap/bootstrap.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-center flex-column mb-3">
                            <a href="#" class="text-decoration-none">
                                <h3 class="text-primary">LMS</h3>
                            </a>
                            <h3>Sign Up</h3>
                        </div>
                        <form action="signup.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" name="firstname" class="form-control" id="floatingText" placeholder="First Name" required>
                                <label for="floatingText">First Name</label>
                                <p class="text-danger"><?php echo $firstname_err; ?></p>
                            </div>


                            <div class="form-floating mb-3">
                                <input type="text" name="lastname" class="form-control" id="floatingText" placeholder="Last Name" required>
                                <label for="floatingText">Last Name</label>
                                <p class="text-danger"><?php echo $lastname_err; ?></p>

                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="othername" class="form-control" id="floatingText" placeholder="Other Name">
                                <label for="floatingText">Other Name</label>
                                <p class="text-danger"><?php echo $othername_err; ?></p>

                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                <label for="floatingInput">Email address</label>
                                <p class="text-danger"><?php echo $email_err; ?></p>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="matricno" class="form-control" id="floatingInput" placeholder="Matric Number" required>
                                <label for="floatingInput">Matric Number</label>
                                <p class="text-danger"><?php echo $matric_err; ?></p>

                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                                <p class="text-danger"><?php echo $password_err; ?></p>

                            </div>

                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                        </form>
                        <p class="text-center mb-0">Already have an Account? <a href="./signin.php">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>