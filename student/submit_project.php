<?php
session_start();
include("../db.php");

/* Student protection */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

$message = "";

if(isset($_POST['submit_project'])){

    $student_id = $_SESSION['user_id'] ?? 0;
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $technology = mysqli_real_escape_string($conn,$_POST['technology']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);

    if(isset($_FILES['project_file']) && $_FILES['project_file']['error'] == 0){

        $file_name = $_FILES['project_file']['name'];
        $tmp_name = $_FILES['project_file']['tmp_name'];

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if($ext !== "pdf"){
            $message = "Only PDF files allowed.";
        } else {

            $new_name = time() . "_" . basename($file_name);
            $upload_path = "uploads/" . $new_name;

            if(move_uploaded_file($tmp_name,$upload_path)){

                $query = "INSERT INTO projects
                (student_id, project_title, technology, description, file_name, status, submitted_at)
                VALUES
                ('$student_id','$title','$technology','$description','$new_name','Pending',NOW())";

                if(mysqli_query($conn,$query)){
                    $message = "Project submitted successfully.";
                } else {
                    $message = "Database error.";
                }

            } else {
                $message = "File upload failed.";
            }
        }

    } else {
        $message = "Please upload a PDF file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Submit Project</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="dashboard-wrapper">

<!-- SIDEBAR -->
<div class="sidebar">
<div class="sidebar-logo">
<img src="../assets/images/logo.png">
<h3>SPMS Student</h3>
</div>

<ul>
<li><a href="dashboard.php">Dashboard</a></li>
<li class="active"><a href="submit_project.php">Submit Project</a></li>
<li><a href="view_status.php">View Status</a></li>
<li><a href="../logout.php">Logout</a></li>
</ul>
</div>

<div class="main-content">

<div class="top-navbar">
<div>
<h2>Submit Project</h2>
<p class="subtitle">Upload your final year project details and PDF file</p>
</div>
</div>

<div class="content-card">

<!-- MESSAGE -->
<?php if(!empty($message)){ ?>
<p style="margin-bottom:15px;color:#2563eb;font-weight:600;">
<?php echo htmlspecialchars($message); ?>
</p>
<?php } ?>

<form method="POST" enctype="multipart/form-data" class="project-form">

<div class="form-grid">

<div class="form-group">
<label>Project Title</label>
<input type="text" name="title" placeholder="Enter project title" required>
</div>

<div class="form-group">
<label>Technology Used</label>
<input type="text" name="technology" placeholder="Eg: PHP, MySQL, HTML, CSS" required>
</div>

<div class="form-group full-width">
<label>Project Description</label>
<textarea name="description" rows="4" placeholder="Brief project description"></textarea>
</div>

<div class="form-group full-width">
<label>Upload Project PDF</label>

<!-- FILE INPUT + VIEW BUTTON -->
<div style="display:flex; align-items:center; gap:10px;">

<input type="file" name="project_file" id="fileInput" accept=".pdf" required>

<button type="button" id="viewBtn"
        style="display:none; padding:6px 12px; background:#2563eb; color:white; border:none; border-radius:5px; cursor:pointer;">
    View
</button>

</div>

<p id="fileName" style="margin-top:8px; color:#64748b; font-size:13px;">
No file selected
</p>

</div>

</div>

<div class="form-submit">
<button type="submit" name="submit_project" class="btn btn-view">
Submit Project
</button>
</div>

</form>

</div>

</div>
</div>

<!-- 🔥 JS FOR VIEW BUTTON -->
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