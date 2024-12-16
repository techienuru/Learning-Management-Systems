<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lecturer_id = $_POST["lecturer_id"];
    $course_id = $_POST["course_id"];

    $sql = mysqli_query($connect, "INSERT INTO `course_assignment` (lecturer_id,course_id) VALUES($lecturer_id,$course_id)");

    if ($sql) {
        echo "
            <script>
                alert('success');
                window.location.href='./assign-course.php';
            </script>
        ";
    }
}

if (isset($_GET["assignment_id"])) {
    $assignment_id = $_GET["assignment_id"];

    $sql = mysqli_query($connect, "DELETE FROM `course_assignment` WHERE assignment_id = $assignment_id");

    if ($sql) {
        echo "
            <script>
                alert('deleted!');
                window.location.href='./assign-course.php';
            </script>
        ";
    }
}
