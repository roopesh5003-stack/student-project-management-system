<?php
session_start();
include("db.php");

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['full_name'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'student') {
                header("Location: student/dashboard.php");
            } elseif ($row['role'] == 'faculty') {
                header("Location: faculty/dashboard.php");
            } else {
                header("Location: admin/dashboard.php");
            }
            exit();

        } else {
            echo "<script>alert('Wrong Password');</script>";
        }

    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<!-- ✅ FIX APPLIED HERE -->
<body class="auth-bg">

<div class="page-center">
<div class="login-box">

    <img src="assets/images/logo.png" class="logo">

    <h2>Login</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <p>
        New user?
        <a href="register.php">Register</a>
    </p>

</div>
</div>

</body>
</html>
