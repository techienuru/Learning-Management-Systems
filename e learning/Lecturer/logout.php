<?php
session_start();
require_once "../includes/connect.php";

if (isset($_SESSION["lecturer_id"])) {
    session_unset();
    session_destroy();
    header("location:../login.php");
}
