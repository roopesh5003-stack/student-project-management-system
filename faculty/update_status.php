<?php
session_start();
include("../db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'faculty') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {

    $project_id = $_GET['id'];
    $status = $_GET['status'];

    // Security: Allow only valid values
    if ($status == "Approved" || $status == "Rejected") {

        $query = "UPDATE projects SET status='$status' WHERE id='$project_id'";
        mysqli_query($conn, $query);

    }
}

// Redirect back
header("Location: view_projects.php");
exit();
?>

