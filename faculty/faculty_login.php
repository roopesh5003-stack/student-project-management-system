<?php
session_start();
include("../config/db.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, 
        "SELECT * FROM users WHERE email='$email' AND role='faculty'");

    if (mysqli_num_rows($query) == 1) {
        $row = mysqli_fetch_assoc($query);
        if (password_verify($password, $row['password'])) {
            $_SESSION['faculty_id'] = $row['id'];
            $_SESSION['faculty_name'] = $row['name'];
            header("Location: faculty_dashboard.php");
        } else {
            $error = "Wrong password";
        }
    } else {
        $error = "Faculty not found";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Faculty Login</title>
<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#0aa4c2;
    font-family:Arial;
}
.box{
    background:#fff;
    width:350px;
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.3);
}
input,button{
    width:100%;
    padding:10px;
    margin:10px 0;
}
button{
    background:#0aa4c2;
    color:#fff;
    border:none;
    cursor:pointer;
}
.error{color:red;}
</style>
</head>
<body>

<div class="box">
<h2>Faculty Login</h2>
<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
<form method="post">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
<p>No account? <a href="faculty_register.php">Register</a></p>
</form>
</div>

</body>
</html>
