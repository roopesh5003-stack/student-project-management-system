<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'faculty') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Dashboard</title>
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
            <li><a href="view_projects.php">Review Projects</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="top-navbar">
            <h2>Faculty Dashboard</h2>
            <p>Welcome, <?php echo $_SESSION['name']; ?></p>
        </div>

        <!-- DASHBOARD CONTENT -->
        <?php include("dashboard_home.php"); ?>

    </div>

</div>

</body>
</html>