<?php
include_once "../includes/connect.php";


// Processing Register course
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = $_POST["course"];

    $insert_into_DB = mysqli_query($connect, "INSERT INTO `student_course` (student_id,course_id) VALUES ($student_id,$course_id)");

    if ($insert_into_DB) {
        header("location:courses.php");
    }
}


// Processing Unregister course
if (isset($_GET["student_course_id"])) {
    $student_course_id = $_GET["student_course_id"];

    $unregister_course = mysqli_query($connect, "DELETE FROM `student_course` WHERE student_course_id=$student_course_id");

    if ($unregister_course) {
        header("location:courses.php");
    }
}
