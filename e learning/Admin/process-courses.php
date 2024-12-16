<?php
if (isset($_POST["add_course"])) {
    $course_code = $_POST["course_code"];
    $course_title = $_POST["course_title"];
    $course_level = $_POST["course_level"];

    $sql = mysqli_query($connect, "INSERT INTO `course` (course_code,course_title,course_level) VALUES('$course_code','$course_title','$course_level')");

    if ($sql) {
        echo "
            <script>
                alert('success');
                window.location.href='./courses.php';
            </script>
        ";
    }
}

if (isset($_GET["course_id"])) {
    $course_id = $_GET["course_id"];

    $sql = mysqli_query($connect, "DELETE FROM `course` WHERE course_id = $course_id");

    if ($sql) {
        echo "
            <script>
                alert('deleted!');
                window.location.href='./courses.php';
            </script>
        ";
    }
}
