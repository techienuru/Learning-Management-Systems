<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = $_POST["course_id"];

    $material_type_1 = $_POST["material_type_1"] ?? null;
    $material_title_1 = $_POST["material_title_1"] ?? null;
    $material_file_1 = $_FILES["material_file_1"] ?? null;

    $material_type_2 = $_POST["material_type_2"] ?? null;
    $material_title_2 = $_POST["material_title_2"] ?? null;
    $material_file_2 = $_FILES["material_file_2"] ?? null;

    $file_path_1 = null;
    $file_path_2 = null;

    // If any of the material type is submitted (Video or Pdf)
    if ($material_file_1 || $material_file_2) {
        if ($material_file_1) {
            processFile($material_file_1, "video");
        }
    
        if ($material_file_2) {
            processFile($material_file_2, "pdf");
        }
        // Insert into DB and refresh the page
        redirection($connect);
    }
}



function processFile($material_file, $location)
{
    global $file_path_1, $file_path_2;

    $file_real_name = $material_file["name"];
    $file_real_temporary_name = $material_file["tmp_name"];
    // $path_info_array = pathinfo($file_real_name, PATHINFO_ALL);
    // $file_size = $material_file["size"];
    // $file_extension = strtolower($path_info_array["extension"]);

    $file_path = "course-materials/$location/$file_real_name";
    if (move_uploaded_file($file_real_temporary_name, $file_path)) {
        switch ($location) {
            case 'video':
                $file_path_1 = $file_path;
                break;

            case 'pdf':
                $file_path_2 = $file_path;
                break;
        }
        return true;
    }
    return false;
}

function redirection($connect)
{
    global $course_id, $material_type_1, $material_title_1, $file_path_1, $material_type_2, $material_title_2, $file_path_2;

    $sql = mysqli_query($connect, "INSERT INTO `course_material`(`course_id`, `material_type_1`, `title_1`, `file_1`, `material_type_2`, `title_2`, `file_2`) VALUES ($course_id, '$material_type_1','$material_title_1','$file_path_1','$material_type_2','$material_title_2','$file_path_2')");

    if ($sql) {
        echo "
            <script>
                alert('Success');
                location.href='course-material.php';
            </script>
        ";
    }
}
