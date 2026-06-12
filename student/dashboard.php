<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>
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
            <li><a href="submit_project.php">Submit Project</a></li>
            <li><a href="view_status.php">View Status</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP NAVBAR -->
        <div class="top-navbar">
            <h2>Student Dashboard</h2>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></p>
        </div>

        <!-- STATS CARDS -->
        <div class="stats-box">

            <div class="stat-card">
                <h3>My Project</h3>
                <p>Submission Status</p>
            </div>

            <div class="stat-card">
                <h3>Upload</h3>
                <p>Submit New Project</p>
            </div>

            <div class="stat-card">
                <h3>Status</h3>
                <p>Approval Tracking</p>
            </div>

        </div>

        <!-- QUICK ACTIONS -->
        <div class="data-card">

            <h3>Project Actions</h3>
            <p>Manage your final year project easily</p>

            <br>

            <a href="submit_project.php" class="dashboard-link">
                Submit Project
            </a>

            <a href="view_status.php" class="dashboard-link">
                View Status
            </a>

        </div>

    </div>

</div>

</body>
</html>
