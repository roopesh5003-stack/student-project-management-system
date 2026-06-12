<?php
session_start();
include("../db.php");

/* Check admin login */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/* Get year safely */
$year = isset($_GET['year']) ? intval($_GET['year']) : 0;

/* Fetch ONLY approved projects */
$query = "
SELECT projects.*, users.full_name
FROM projects
LEFT JOIN users ON projects.student_id = users.id
WHERE projects.project_year = '$year'
AND projects.status = 'Approved'
ORDER BY projects.submitted_at DESC
";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo htmlspecialchars($year); ?> Projects</title>
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
<li><a href="dashboard.php">Dashboard</a></li>
<li class="active"><a href="view_projects.php">All Projects</a></li>
<li><a href="../logout.php">Logout</a></li>
</ul>
</div>

<div class="main-content">

<!-- TOP NAVBAR -->
<div class="top-navbar">
<div>
<h2><?php echo htmlspecialchars($year); ?> Student Projects</h2>
<p class="subtitle">Archive projects uploaded in <?php echo htmlspecialchars($year); ?></p>
</div>

<a href="upload_project.php" class="btn btn-view">+ Upload Project</a>
</div>

<div class="content-card">

<div class="card-header">
<h3>Project Archive</h3>
<p class="subtitle">All approved projects in <?php echo htmlspecialchars($year); ?></p>
</div>

<div class="table-wrapper">

<table class="modern-table">

<thead>
<tr>
<th>S.No</th>
<th>Student</th>
<th>Project Title</th>
<th>Technology</th>
<th>PDF</th>
<th>Submitted Date</th>
<th>Action</th> <!-- ✅ NEW -->
</tr>
</thead>

<tbody>

<?php if($result && mysqli_num_rows($result) > 0){ ?>

<?php $sno = 1; ?>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $sno++; ?></td>

<td>
<?php 
echo !empty($row['full_name']) 
    ? htmlspecialchars($row['full_name']) 
    : "ID: " . htmlspecialchars($row['student_id']);
?>
</td>

<td><?php echo htmlspecialchars($row['project_title']); ?></td>

<td><?php echo htmlspecialchars($row['technology']); ?></td>

<td>
<?php if(!empty($row['file_name']) && file_exists("../student/uploads/" . $row['file_name'])){ ?>
<a href="../student/uploads/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank" class="btn btn-view">
View PDF
</a>
<?php } else { ?>
<span style="color:#94a3b8;">No File</span>
<?php } ?>
</td>

<td>
<?php 
echo !empty($row['submitted_at']) 
? date("d M Y, h:i A", strtotime($row['submitted_at'])) 
: "-";
?>
</td>

<!-- ✅ DELETE BUTTON -->
<td>
<a href="delete_project.php?id=<?php echo $row['id']; ?>" 
   onclick="return confirm('Are you sure you want to delete this project?');"
   class="btn btn-delete">
   Delete
</a>
</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>
<td colspan="7" style="text-align:center; color:#64748b;">
No approved projects found for <?php echo htmlspecialchars($year); ?>
</td>
</tr>

<?php } ?>

</tbody>
</table>

</div>

<div class="card-footer">
<a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

</div>

</div>
</div>

</body>
</html>