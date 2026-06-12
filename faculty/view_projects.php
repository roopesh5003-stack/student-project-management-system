<?php
session_start();
include("../db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'faculty') {
    header("Location: ../login.php");
    exit();
}

/* HANDLE APPROVE / REJECT WITH FEEDBACK */
if(isset($_POST['action'])){

    $project_id = $_POST['project_id'];
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
    $status = $_POST['action'];

    $update_query = "UPDATE projects 
                     SET status='$status', feedback='$feedback' 
                     WHERE id='$project_id'";

    mysqli_query($conn, $update_query);
}

/* FETCH PROJECTS */
$query = "
SELECT projects.*, users.full_name 
FROM projects 
JOIN users ON projects.student_id = users.id
ORDER BY projects.submitted_at DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty - Review Projects</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="dashboard-wrapper">

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-logo">
        <img src="../assets/images/logo.png">
        <h3>SPMS Faculty</h3>
    </div>

    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li class="active"><a href="view_projects.php">Review Projects</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

<div class="top-navbar">
    <div>
        <h2>Student Project Submissions</h2>
        <p class="subtitle">
            Review, preview PDF and manage student submissions
        </p>
    </div>

    <div class="user-info">
        Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>
    </div>
</div>

<div class="content-card">

<div class="card-header">
    <h3>All Submitted Projects</h3>
    <p>Latest submissions appear first</p>
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
    <th>File</th>
    <th>Action + Feedback</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($result) > 0) { ?>

<?php $serial = 1; ?>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<!-- SERIAL -->
<td><?php echo $serial++; ?></td>

<!-- STUDENT -->
<td><?php echo htmlspecialchars($row['full_name']); ?></td>

<!-- TITLE -->
<td><?php echo htmlspecialchars($row['project_title']); ?></td>

<!-- TECHNOLOGY -->
<td><?php echo htmlspecialchars($row['technology']); ?></td>

<!-- STATUS -->
<td>
<span class="status-pill status-<?php echo strtolower($row['status']); ?>">
    <?php echo htmlspecialchars($row['status']); ?>
</span>
</td>

<!-- FILE -->
<td>
<?php if(!empty($row['file_name']) && file_exists("../student/uploads/" . $row['file_name'])) { ?>
    <a href="../student/uploads/<?php echo htmlspecialchars($row['file_name']); ?>"
       target="_blank"
       class="btn btn-view">
       View
    </a>
<?php } else { ?>
    <span class="text-muted">No File</span>
<?php } ?>
</td>

<!-- ACTION + FEEDBACK -->
<td>
<form method="POST">

<input type="hidden" name="project_id" value="<?php echo $row['id']; ?>">

<textarea name="feedback" 
          placeholder="Enter feedback..." 
          rows="2"
          style="width:150px;"><?php echo htmlspecialchars($row['feedback'] ?? ''); ?></textarea>

<br><br>

<button type="submit" name="action" value="Approved" class="btn btn-approve">
    Approve
</button>

<button type="submit" name="action" value="Rejected" class="btn btn-reject">
    Reject
</button>

</form>
</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>
<td colspan="7" class="empty-row">
    No projects available
</td>
</tr>

<?php } ?>

</tbody>

</table>
</div>

<div class="card-footer">
<a href="dashboard.php" class="back-btn">
← Back to Dashboard
</a>
</div>

</div>

</div>

</div>

</body>
</html>