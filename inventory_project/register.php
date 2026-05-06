<?php
include 'db.php';

if(isset($_POST['register'])){

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO users (username,email,password)
VALUES ('$username','$email','$password')";

if(mysqli_query($conn,$sql)){
echo "Account created successfully";
}else{
echo "Error creating account";
}

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Create Account</title>
<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container">

<div class="login-card">

<h2>Create Account</h2>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="register">Register</button>

</form>

<p class="link">
Already have an account?
<a href="login.php">Login</a>
</p>

</div>

</div>

</body>
</html>