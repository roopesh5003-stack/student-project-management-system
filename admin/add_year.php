<?php
session_start();
include("../db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['add_year'])){

$year = $_POST['year'];

$query = "INSERT INTO project_years (year) VALUES ('$year')";
mysqli_query($conn,$query);

header("Location: dashboard.php");
exit();

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Year</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="page-center">

<div class="login-box">

<h2>Add Project Year</h2>

<form method="POST">

<input type="number" name="year" placeholder="Enter Year (Ex: 2027)" required>

<button type="submit" name="add_year">Add Year</button>

</form>

</div>

</div>

</body>
</html>