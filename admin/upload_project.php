<?php
session_start();
include("../db.php");

/* Admin protection */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/* Upload project */
if (isset($_POST['upload_project'])) {

    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $technology = mysqli_real_escape_string($conn, $_POST['technology']);
    $year = mysqli_real_escape_string($conn, $_POST['project_year']);

    /* File upload */
    if(isset($_FILES['project_file']) && $_FILES['project_file']['error'] == 0){

        $file_name = $_FILES['project_file']['name'];
        $tmp_name = $_FILES['project_file']['tmp_name'];

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($ext !== "pdf") {

            echo "<script>alert('Only PDF files allowed');</script>";

        } else {

            $new_name = time() . "_" . basename($file_name);
            $upload_path = "../student/uploads/" . $new_name;

            if (move_uploaded_file($tmp_name, $upload_path)) {

                $query = "INSERT INTO projects
                (student_id, project_title, technology, file_name, project_year, status, submitted_at)
                VALUES
                ('$student_id', '$title', '$technology', '$new_name', '$year', 'Approved', NOW())";

                if (mysqli_query($conn, $query)) {

                    header("Location: view_year_projects.php?year=" . $year);
                    exit();

                } else {

                    echo "<script>alert('Database Error');</script>";
                }

            } else {

                echo "<script>alert('File upload failed');</script>";
            }
        }

    } else {
        echo "<script>alert('Please select a file');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Upload Project</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="page-center">

<div class="login-box">

<h2>Upload Project (Admin)</h2>

<form method="POST" enctype="multipart/form-data">

<input type="number" name="student_id" placeholder="Student ID" required>

<input type="text" name="title" placeholder="Project Title" required>

<input type="text" name="technology" placeholder="Technology Used" required>

<input type="number" name="project_year" placeholder="Project Year (Ex: 2025)" required>

<!-- 🔥 FILE INPUT + VIEW BUTTON -->
<div style="display:flex; align-items:center; gap:10px; margin-top:10px;">

<input type="file" name="project_file" id="fileInput" accept=".pdf" required>

<button type="button" id="viewBtn"
        style="display:none; padding:6px 12px; background:#0ea5e9; color:white; border:none; border-radius:5px; cursor:pointer;">
    View
</button>

</div>

<p id="fileName" style="margin-top:8px; color:#64748b; font-size:13px;">
No file selected
</p>

<button type="submit" name="upload_project">Upload Project</button>

</form>

</div>

</div>

<!-- 🔥 JAVASCRIPT -->
<script>
const fileInput = document.getElementById("fileInput");
const fileNameText = document.getElementById("fileName");
const viewBtn = document.getElementById("viewBtn");

let fileURL = "";

fileInput.addEventListener("change", function(){

    const file = this.files[0];

    if(file){
        fileNameText.textContent = file.name;

        fileURL = URL.createObjectURL(file);

        viewBtn.style.display = "inline-block";
    } else {
        fileNameText.textContent = "No file selected";
        viewBtn.style.display = "none";
    }
});

viewBtn.addEventListener("click", function(){
    if(fileURL){
        window.open(fileURL, "_blank");
    }
});
</script>

</body>
</html>