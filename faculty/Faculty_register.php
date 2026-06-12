<?php
include("../config/db.php");

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already registered";
    } else {
        $query = "INSERT INTO users (name,email,password,role) 
                  VALUES ('$name','$email','$password','faculty')";
        mysqli_query($conn, $query);
        header("Location: faculty_login.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Faculty Register</title>
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
<h2>Faculty Register</h2>
<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
<form method="post">
<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="register">Register</button>
<p>Already registered? <a href="faculty_login.php">Login</a></p>
</form>
</div>

</body>
</html>
