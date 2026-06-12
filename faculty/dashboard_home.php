
<?php
include("../db.php");

/* Pending Projects (students only) */
$pending_query = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM projects
JOIN users ON projects.student_id = users.id
WHERE LOWER(projects.status)='pending'
AND users.role='student'
");
$pending = mysqli_fetch_assoc($pending_query)['total'];

/* Approved Projects (students only) */
$approved_query = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM projects
JOIN users ON projects.student_id = users.id
WHERE LOWER(projects.status)='approved'
AND users.role='student'
");
$approved = mysqli_fetch_assoc($approved_query)['total'];

/* Rejected Projects (students only) */
$rejected_query = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM projects
JOIN users ON projects.student_id = users.id
WHERE LOWER(projects.status)='rejected'
AND users.role='student'
");
$rejected = mysqli_fetch_assoc($rejected_query)['total'];
?>

<div class="data-card">

<h3>Project Review Panel</h3>
<p style="color:#64748b;">
Approve or reject student submissions
</p>

<br>

<div class="stats-box">

<div class="stat-card">
<h3><?php echo $pending; ?></h3>
<p>Pending Reviews</p>
</div>

<div class="stat-card">
<h3><?php echo $approved; ?></h3>
<p>Approved Projects</p>
</div>

<div class="stat-card">
<h3><?php echo $rejected; ?></h3>
<p>Rejected Projects</p>
</div>

</div>

<br>

<a href="view_projects.php" class="dashboard-link">
Review Projects
</a>

</div>

