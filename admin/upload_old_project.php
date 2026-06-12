
<?php
session_start();
include("../db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$year = $_GET['year'];

if(isset($_POST['upload'])) {

    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $technology = mysqli_real_escape_string($conn, $_POST['technology']);

    /* Get student ID from name */
    $getStudent = mysqli_query($conn, "
        SELECT id FROM users 
        WHERE full_name LIKE '%$student_name%' 
        AND role='student'
        LIMIT 1
    ");

    if(mysqli_num_rows($getStudent) > 0){
        $studentData = mysqli_fetch_assoc($getStudent);
        $student_id = $studentData['id'];
    } else {
        die("❌ Student not found!");
    }

    /* File upload */
    $file_name = $_FILES['pdf']['name'];
    $tmp = $_FILES['pdf']['tmp_name'];

    move_uploaded_file($tmp, "../student/uploads/".$file_name);

    /* Insert with student_id */
    $query = "
    INSERT INTO projects 
    (student_id, project_title, technology, file_name, project_year)
    VALUES
    ('$student_id','$title','$technology','$file_name','$year')
    ";

    mysqli_query($conn, $query);

    header("Location: view_year_projects.php?year=".$year);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Old Project</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="page-center">

<div class="login-box">

<h2>Upload <?php echo $year; ?> Project</h2>

<form method="POST" enctype="multipart/form-data">

<!-- NEW FIELD -->
<input type="text" name="student_name" placeholder="Enter Student Name" required>

<input type="text" name="title" placeholder="Project Title" required>

<input type="text" name="technology" placeholder="Technology Used" required>

<input type="file" name="pdf" accept=".pdf" required>

<button type="submit" name="upload">
Upload Project
</button>

</form>

</div>

</div>

</body>
</html>

