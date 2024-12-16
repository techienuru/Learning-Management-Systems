<?php
include_once "../includes/connect.php";

if (isset($_GET["student_id"])) {
    $student_id = $_GET["student_id"];
    $status = $_GET["status"];

    switch ($status) {
        case 1:
            insertIntoDB($connect, $student_id, 1, 'Student approved');
            break;

        case 0:
            insertIntoDB($connect, $student_id, 0, 'Student declined');
            break;
    }
}


function insertIntoDB($connect, $student_id, $changed_status, $alert_message)
{
    $sql = mysqli_query($connect, "UPDATE `student` SET `is_approved?` = '$changed_status' WHERE student_id = $student_id");
    if ($sql) {
        echo "
            <script>
                alert(`$alert_message`);
                window.location.href = './students.php';
            </script>
        ";
    }
}
