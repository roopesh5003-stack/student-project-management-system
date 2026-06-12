<?php
include("includes/db.php");

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $roll = $_POST['roll'];
    $password = md5($_POST['password']);

    $query = "INSERT INTO students(name,email,roll_no,password)
              VALUES('$name','$email','$roll','$password')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registration Successful');window.location='login.php';</script>";
    } else {
        echo "Error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<form method="post">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="roll" placeholder="Roll No" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button name="register">Register</button>
</form>
</body>
</html>
