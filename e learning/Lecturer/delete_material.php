<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../includes/connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $material_id = $_POST['material_id'];

    // Prepare a SQL statement to delete the material
    $delete_sql = "DELETE FROM course_material WHERE material_id = ?";
    $stmt = $connect->prepare($delete_sql);
    $stmt->bind_param("i", $material_id);

    if ($stmt->execute()) {
        echo "Material deleted successfully.";
        header("Location: course-material.php"); // Ensure this path is correct
        exit();
    } else {
        echo "Error deleting material: " . $stmt->error;
    }

    $stmt->close();
}
?>
