<?php
include("db.php");

if (isset($_POST['register'])) {

    $name = $_POST['full_name'];
    $regno = $_POST['register_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check duplicate email
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already exists');</script>";
    } else {

        $query = "INSERT INTO users 
        (full_name, register_no, email, password, role)
        VALUES 
        ('$name', '$regno', '$email', '$hashedPassword', '$role')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration Successful'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registration Failed');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-bg">
<div class="page-center">
<div class="login-box">
    <h2>Register</h2><img src="assets/images/logo.png" class="logo" alt="College Logo">


    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="register_no" placeholder="Register Number" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <select name="role" required>
    <option value="" disabled selected>Select Role</option>
    <option value="student">Student</option>
    <option value="faculty">Faculty</option>
</select>


        <button type="submit" name="register">Register</button>
    </form>

    <p>
        Already have an account?
        <a href="login.php">Login</a>
    </p>
</div>

</body>
</html>
