<?php
session_start();
include("../db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if(isset($_GET['id'])){

$id = intval($_GET['id']);

/* get file name */
$q = mysqli_query($conn,"SELECT file_name FROM projects WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if($data){
$file = "../student/uploads/".$data['file_name'];

if(file_exists($file)){
unlink($file);
}
}

/* delete record */
mysqli_query($conn,"DELETE FROM projects WHERE id='$id'");
}

header("Location: view_projects.php");
exit();
?>