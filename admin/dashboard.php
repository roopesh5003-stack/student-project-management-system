
<?php
session_start();
include("../db.php");

/* Admin protection */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/* ===== STATISTICS ===== */

/* Students count */
$student_count = 0;
$q1 = mysqli_query($conn,"SELECT COUNT(*) AS total FROM users WHERE role='student'");
if($q1){
$data = mysqli_fetch_assoc($q1);
$student_count = $data['total'];
}

/* Projects count (ONLY approved projects) */
$project_count = 0;
$q2 = mysqli_query($conn,"SELECT COUNT(*) AS total FROM projects WHERE status='Approved'");
if($q2){
$data = mysqli_fetch_assoc($q2);
$project_count = $data['total'];
}

/* Faculty count */
$faculty_count = 0;
$q3 = mysqli_query($conn,"SELECT COUNT(*) AS total FROM users WHERE role='faculty'");
if($q3){
$data = mysqli_fetch_assoc($q3);
$faculty_count = $data['total'];
}

/* ===== RECENT PROJECTS (ONLY approved) ===== */
$recent_query = "
SELECT projects.*, users.full_name
FROM projects
LEFT JOIN users ON projects.student_id = users.id
WHERE projects.status='Approved'
ORDER BY projects.submitted_at DESC
LIMIT 5
";

$recent_result = mysqli_query($conn,$recent_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="dashboard-wrapper">

<!-- SIDEBAR -->
<div class="sidebar">

<div class="sidebar-logo">
<img src="../assets/images/logo.png">
<h3>SPMS Admin</h3>
</div>

<ul>
<li class="active"><a href="dashboard.php">Dashboard</a></li>
<li><a href="view_projects.php">All Projects</a></li>
<li><a href="../logout.php">Logout</a></li>
</ul>

</div>

<!-- MAIN CONTENT -->
<div class="main-content">

<!-- TOP NAVBAR -->
<div class="top-navbar">

<div>
<h2>Admin Dashboard</h2>
<p class="subtitle">Manage student projects and system records</p>
</div>

<div>
Welcome, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong>
</div>

</div>

<!-- STAT CARDS -->
<div class="stats-box">

<div class="stat-card">
<h3><?php echo $student_count; ?></h3>
<p>Total Students</p>
</div>

<div class="stat-card">
<h3><?php echo $project_count; ?></h3>
<p>Total Approved Projects</p>
</div>

<div class="stat-card">
<h3><?php echo $faculty_count; ?></h3>
<p>Total Faculty</p>
</div>

</div>

<!-- PROJECTS BY YEAR -->
<div class="content-card">

<div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">

<div>
<h3>Projects By Year</h3>
<p class="subtitle">Browse approved project archives by year</p>
</div>

<a href="add_year.php" class="btn btn-view">
➕ Add New Year
</a>

</div>

<div class="stats-box">

<?php

$query = "SELECT year FROM project_years ORDER BY year DESC";
$result = mysqli_query($conn, $query);

if($result && mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

$year = $row['year'];

/* Count ONLY approved projects in that year */
$countQuery = "
SELECT COUNT(*) AS total 
FROM projects 
WHERE project_year='$year' 
AND status='Approved'
";

$countResult = mysqli_query($conn, $countQuery);

$totalProjects = 0;

if($countResult){
$countData = mysqli_fetch_assoc($countResult);
$totalProjects = $countData['total'];
}
?>

<a href="view_year_projects.php?year=<?php echo $year; ?>" class="year-card">

<div>
<div style="font-size:22px;font-weight:700;"><?php echo $year; ?></div>
<div style="font-size:13px;margin-top:4px;"><?php echo $totalProjects; ?> Projects</div>
</div>

</a>

<?php
}

}else{

echo "<p style='color:#64748b;'>No years available</p>";

}
?>

</div>

</div>

<!-- RECENT PROJECTS -->
<div class="content-card" style="margin-top:25px;">

<div class="card-header">
<h3>Recent Projects</h3>
<p class="subtitle">Latest approved student projects</p>
</div>

<table class="modern-table">

<thead>
<tr>
<th>S.No</th>
<th>Student</th>
<th>Project Title</th>
<th>Technology</th>
<th>PDF</th>
<th>Date</th>
</tr>
</thead>

<tbody>

<?php if($recent_result && mysqli_num_rows($recent_result) > 0){ ?>

<?php $sno = 1; ?>

<?php while($row = mysqli_fetch_assoc($recent_result)){ ?>

<tr>

<td><?php echo $sno++; ?></td>

<td>
<?php
if(!empty($row['full_name'])){
echo htmlspecialchars($row['full_name']);
}else{
echo "ID ".htmlspecialchars($row['student_id']);
}
?>
</td>

<td><?php echo htmlspecialchars($row['project_title']); ?></td>

<td><?php echo htmlspecialchars($row['technology']); ?></td>

<td>
<a href="../student/uploads/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank" class="btn btn-view">
View PDF
</a>
</td>

<td><?php echo date("d M Y",strtotime($row['submitted_at'])); ?></td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>
<td colspan="6">No recent approved projects</td>
</tr>

<?php } ?>

</tbody>

</table>

<br>

<a href="view_projects.php" class="btn btn-view">View All Projects</a>

</div>

</div>
</div>

</body>
</html>

