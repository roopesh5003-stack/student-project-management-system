<?php
session_start();
include("../db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['upload'])) {

    $title = $_POST['title'];
    $technology = $_POST['technology'];
    $year = $_POST['year'];

    $file_name = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    move_uploaded_file($tmp_name, "../student/uploads/".$file_name);

    $query = "INSERT INTO projects
    (student_id, project_title, technology, file_name, project_year, status)
    VALUES
    ('0','$title','$technology','$file_name','$year','Approved')";

    mysqli_query($conn,$query);

    echo "<script>alert('Old Project Added Successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Old Project</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="main-content">

<div class="data-card" style="max-width:600px">

<h3>Add Old Student Project</h3>

<form method="POST" enctype="multipart/form-data">

<label>Project Title</label>
<input type="text" name="title" required>

<label>Technology</label>
<input type="text" name="technology" required>

<label>Project Year</label>
<input type="number" name="year" placeholder="2022" required>

<label>Upload PDF</label>
<input type="file" name="file" accept=".pdf" required>

<button name="upload">Upload Project</button>

</form>

</div>

</div>

</body>
</html>
