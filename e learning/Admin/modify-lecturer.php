<?php
session_start();
require_once "../includes/connect.php";

if (!isset($_SESSION["admin_id"])) {
    header("location:../login.php");
} else {
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
        switch ($action) {
            case 'edit':
                $sql = mysqli_query($connect, "UPDATE `lecturer` SET firstname='$_POST[firstname]', surname='$_POST[surname]', faculty='$_POST[faculty]', department='$_POST[department]', password='$_POST[password]' WHERE lecturer_id = $_POST[lecturer_id]");
                if ($sql) {
                    echo "
                        <script>
                            alert(`Update Successful`);
                            location.href='./view-lecturer.php';
                        </script>
                    ";
                    die();
                }
                break;

            case 'delete':
                $deleting_lecturer = mysqli_query($connect, "DELETE FROM `lecturer`WHERE lecturer_id = $_GET[lecturer_id]");
                if ($deleting_lecturer) {
                    echo "
                        <script>
                            alert(`Delete Successful`);
                            location.href='./view-lecturer.php';
                        </script>
                    ";
                    die();
                }
                break;
        }
    }
}
