<?php
session_start();
include("../db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

/* FETCH PROJECT DATA */
$query = "SELECT * FROM projects WHERE id='$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

/* UPDATE PROJECT */
if(isset($_POST['update'])){

    $title = $_POST['title'];
    $technology = $_POST['technology'];
    $description = $_POST['description'];

    if(!empty($_FILES['file']['name'])){
        $file_name = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];

        move_uploaded_file($tmp_name, "uploads/" . $file_name);

        $update = "UPDATE projects 
                   SET project_title='$title',
                       technology='$technology',
                       description='$description',
                       file_name='$file_name',
                       status='Pending'
                   WHERE id='$id'";
    } else {
        $update = "UPDATE projects 
                   SET project_title='$title',
                       technology='$technology',
                       description='$description',
                       status='Pending'
                   WHERE id='$id'";
    }

    mysqli_query($conn, $update);

    header("Location: view_status.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Project</title>
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
                <h2>Edit Project</h2>
                <p style="color:#64748b;font-size:14px;">
                    Update your project details and re-submit
                </p>
            </div>

            <div>
                Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>
            </div>
        </div>

        <!-- FORM CARD -->
        <div class="table-container">

            <form method="POST" enctype="multipart/form-data">

                <!-- ROW -->
                <div style="display:flex; gap:20px; margin-bottom:20px;">

                    <!-- TITLE -->
                    <div style="flex:1;">
                        <label style="font-weight:600; display:block; margin-bottom:6px;">
                            Project Title
                        </label>
                        <input type="text" name="title"
                               value="<?php echo htmlspecialchars($data['project_title']); ?>"
                               placeholder="Enter project title"
                               style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:6px;"
                               required>
                    </div>

                    <!-- TECHNOLOGY -->
                    <div style="flex:1;">
                        <label style="font-weight:600; display:block; margin-bottom:6px;">
                            Technology Used
                        </label>
                        <input type="text" name="technology"
                               value="<?php echo htmlspecialchars($data['technology']); ?>"
                               placeholder="Eg: PHP, MySQL, HTML, CSS"
                               style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:6px;"
                               required>
                    </div>

                </div>

                <!-- DESCRIPTION -->
                <div style="margin-bottom:20px;">
                    <label style="font-weight:600; display:block; margin-bottom:6px;">
                        Project Description
                    </label>
                    <textarea name="description" rows="4"
                              placeholder="Brief project description"
                              style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:6px;"
                              required><?php echo htmlspecialchars($data['description']); ?></textarea>
                </div>

                <!-- FILE -->
                <div style="margin-bottom:20px;">
                    <label style="font-weight:600; display:block; margin-bottom:6px;">
                        Upload New Project PDF (optional)
                    </label>
                    <input type="file" name="file"
                           style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;">

                    <!-- CURRENT FILE -->
                    <?php if(!empty($data['file_name'])) { ?>
                        <p style="margin-top:8px; color:#64748b; font-size:13px;">
                            Current File:
                            <a href="uploads/<?php echo $data['file_name']; ?>" target="_blank">
                                <?php echo $data['file_name']; ?>
                            </a>
                        </p>
                    <?php } ?>
                </div>

                <!-- BUTTON -->
                <button type="submit" name="update"
                        style="background:#2563eb; color:white; padding:12px 20px; border:none; border-radius:6px; cursor:pointer;">
                    Update Project
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>