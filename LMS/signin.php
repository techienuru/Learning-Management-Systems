<?php
session_start();
include_once "includes/connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $selecting_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE email = '$email' AND password = '$password'");

    $selecting_lecturer = mysqli_query($connect, "SELECT * FROM `lecturer` WHERE email = '$email' AND password = '$password'");

    $selecting_student = mysqli_query($connect, "SELECT * FROM `student` WHERE email = '$email' AND password = '$password' AND `is_approved?` = '1'");


    if (!mysqli_num_rows($selecting_admin) > 0 && !mysqli_num_rows($selecting_student) > 0 && !mysqli_num_rows($selecting_lecturer) > 0) {
        $error_message = '
            <div class="alert alert-danger position-absolute js-invalid-credential" style="z-index: 1; top:0;right:0;">
                Invalid Credential
            </div>
            ';

        echo '
        <script>
            setInterval(()=>{
                document.querySelector(".js-invalid-credential").style.display = "none";
            },3000);
        </script>
    ';
    } else {
        if (mysqli_num_rows($selecting_admin) > 0) {
            $row = mysqli_fetch_assoc($selecting_admin);
            $_SESSION["admin_id"] = $row["admin_id"];
            header("location:./admin/dashboard.php");
            die();
        } elseif (mysqli_num_rows($selecting_student) > 0) {
            $row = mysqli_fetch_assoc($selecting_student);
            $_SESSION["student_id"] = $row["student_id"];
            header("location:./student/dashboard.php");
            die();
        } elseif (mysqli_num_rows($selecting_lecturer) > 0) {
            $row = mysqli_fetch_assoc($selecting_lecturer);
            $_SESSION["lecturer_id"] = $row["lecturer_id"];
            header("location:./lecturer/dashboard.php");
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LMS | Login</title>
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
    <?php
    if (isset($error_message)) {
        echo $error_message;
    }
    ?>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-center flex-column mb-3">
                            <a href="#" class="text-decoration-none">
                                <h3 class="text-primary">LMS</h3>
                            </a>
                            <h3>Sign In</h3>
                        </div>
                        <form action="signin.php" method="POST">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-envelope user-icon"></i></span>
                                <input type="email" name="email" class="form-control p-3" id="floatingInput" placeholder="Email Address">
                                <!-- <label for="floatingInput">Email address</label> -->
                            </div>

                            <div class="input-group mb-4">
                                <span class="input-group-text"><i class="fas fa-lock user-icon"></i></span>
                                <input type="password" name="password" class="form-control p-3" id="floatingPassword" placeholder="Password">
                                <!-- <label for="floatingPassword">Password</label> -->
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        </form>
                        <p class="text-center mb-0">Don't have an Account? <a href="./signup.php">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>