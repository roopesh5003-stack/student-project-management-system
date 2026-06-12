<?php
session_start();
include("../db.php");

$student_id = $_SESSION['user_id'];

$total = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM projects WHERE student_id='$student_id'"));

$approved = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM projects WHERE student_id='$student_id' AND status='Approved'"));

$pending = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM projects WHERE student_id='$student_id' AND status='Pending'"));
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/style.css">
</head>

<body style="padding:20px;background:#f1f5f9;">

<!-- STATS -->
<div class="stats-box">

<div class="stat-card">
<h3><?php echo $total['total']; ?></h3>
<p>Total Submissions</p>
</div>

<div class="stat-card">
<h3><?php echo $approved['total']; ?></h3>
<p>Approved Projects</p>
</div>

<div class="stat-card">
<h3><?php echo $pending['total']; ?></h3>
<p>Pending Reviews</p>
</div>

</div>

<!-- ACTION PANEL -->

<div class="data-card">

<h3>Project Actions</h3>
<p>Submit and track your final year project</p>

<br>

<a href="submit_project.php" target="studentFrame" class="dashboard-link">
Submit Project →
</a>

<br><br>

<a href="view_status.php" target="studentFrame" class="dashboard-link">
View Status →
</a>

</div>

</body>
</html>

