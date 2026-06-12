<?php
session_start();
include("../db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

$query = "
SELECT * FROM projects
WHERE student_id = '$student_id'
ORDER BY submitted_at DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Project Status</title>
    <link rel="stylesheet" href="../css/style.css?v=3">
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
            <li><a href="view_status.php" style="color:white;">View Status</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP BAR -->
        <div class="top-navbar">
            <div>
                <h2>My Project Status</h2>
                <p style="color:#64748b;font-size:14px;">
                    Track your submitted projects and approval status
                </p>
            </div>

            <div>
                Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="table-container">

            <div style="margin-bottom:15px;">
                <h3 style="margin-bottom:5px;">All Submissions</h3>
                <p style="color:#64748b;font-size:13px;">
                    Latest submissions appear first
                </p>
            </div>

            <table class="project-table">

                <thead>
                    <tr>
                        <th>Project Title</th>
                        <th>Technology</th>
                        <th>Status</th>
                        <th>Faculty Feedback</th>
                        <th>File</th>
                        <th>Action</th>
                        <th>Submitted Date</th>
                    </tr>
                </thead>

                <tbody>

                <?php if(mysqli_num_rows($result) > 0) { ?>

                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                        <tr>

                            <td><?php echo htmlspecialchars($row['project_title']); ?></td>

                            <td><?php echo htmlspecialchars($row['technology']); ?></td>

                            <td>
                                <span class="status-badge status-<?php echo strtolower($row['status']); ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>

                            <!-- FEEDBACK -->
                            <td>
                                <?php 
                                    if(!empty($row['feedback'])){
                                        echo htmlspecialchars($row['feedback']);
                                    } else {
                                        echo "<span style='color:#94a3b8;'>No feedback yet</span>";
                                    }
                                ?>
                            </td>

                            <!-- VIEW FILE -->
                            <td>
                                <?php if(!empty($row['file_name'])) { ?>
                                    <a href="uploads/<?php echo $row['file_name']; ?>" 
                                       target="_blank" 
                                       class="btn btn-view">
                                       View
                                    </a>
                                <?php } else { ?>
                                    <span style="color:#94a3b8;">No File</span>
                                <?php } ?>
                            </td>

                            <!-- EDIT BUTTON -->
                            <td>
                                <?php if($row['status'] == 'Rejected') { ?>
                                    <a href="edit_project.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-edit">
                                       Edit
                                    </a>
                                <?php } else { ?>
                                    <span style="color:#94a3b8;">Locked</span>
                                <?php } ?>
                            </td>

                            <!-- DATE -->
                            <td>
                                <?php echo date("d M Y, h:i A", strtotime($row['submitted_at'])); ?>
                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>
                        <td colspan="7" style="text-align:center;color:#64748b;">
                            No project submissions found
                        </td>
                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>