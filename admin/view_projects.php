<?php
session_start();
include("../db.php");

/* Admin protection */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/* FILTER LOGIC */
$status_filter = $_GET['status'] ?? 'all';

if($status_filter == 'approved'){
    $condition = "WHERE projects.status = 'Approved'";
} elseif($status_filter == 'rejected'){
    $condition = "WHERE projects.status = 'Rejected'";
} else {
    $condition = "WHERE projects.status != 'Pending'";
}

/* FETCH PROJECTS */
$query = "
SELECT projects.*, users.full_name 
FROM projects 
JOIN users ON projects.student_id = users.id
$condition
ORDER BY projects.submitted_at DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

/* ACTIVE BUTTON STYLE */
$class_all = ($status_filter == 'all') ? 'btn btn-view' : 'btn';
$class_approved = ($status_filter == 'approved') ? 'btn btn-approve' : 'btn';
$class_rejected = ($status_filter == 'rejected') ? 'btn btn-delete' : 'btn';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Student Projects</title>
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

<!-- MAIN CONTENT -->
<div class="main-content">

<div class="top-navbar">
<div>
<h2>All Student Projects</h2>
<p class="subtitle">View and manage submitted student projects</p>
</div>
</div>

<div class="content-card">

<div class="card-header">
<h3>Project List</h3>
<p class="subtitle">Latest submissions appear first</p>
</div>

<!-- 🔥 FILTER BUTTONS -->
<div style="margin-bottom:15px;">
<a href="?status=all" class="<?php echo $class_all; ?>">All</a>
<a href="?status=approved" class="<?php echo $class_approved; ?>">Approved</a>
<a href="?status=rejected" class="<?php echo $class_rejected; ?>">Rejected</a>
</div>

<div class="table-wrapper">

<table class="modern-table">

<thead>
<tr>
<th>S.No</th>
<th>Student</th>
<th>Project Title</th>
<th>Technology</th>
<th>Status</th>
<th>Project File</th>
<th>Submitted Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php $serial = 1; ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $serial++; ?></td>

<td>
<?php 
echo !empty($row['full_name']) 
    ? htmlspecialchars($row['full_name']) 
    : "ID " . htmlspecialchars($row['student_id']);
?>
</td>

<td><?php echo htmlspecialchars($row['project_title']); ?></td>

<td><?php echo htmlspecialchars($row['technology']); ?></td>

<td>
<span class="status-badge status-<?php echo strtolower($row['status']); ?>">
<?php echo htmlspecialchars($row['status']); ?>
</span>
</td>

<td>
<?php if(!empty($row['file_name']) && file_exists("../student/uploads/" . $row['file_name'])) { ?>
    <a href="../student/uploads/<?php echo htmlspecialchars($row['file_name']); ?>" 
       target="_blank" 
       class="btn btn-view">
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
<td colspan="8" style="text-align:center; color:#64748b;">
No projects available
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