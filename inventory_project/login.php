<?php
session_start();
include "db.php";

/* LOGIN */

if(isset($_POST['login'])){

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND password='$password'");

if(mysqli_num_rows($query) == 1){

$_SESSION['username'] = $username;
header("Location: dashboard.php");
exit();

}else{

$error = "Invalid Username or Password";

}

}


/* REGISTER */

if(isset($_POST['register'])){

$username = $_POST['new_username'];
$email = $_POST['email'];
$password = $_POST['new_password'];

mysqli_query($conn,"
INSERT INTO users(username,email,password)
VALUES('$username','$email','$password')
");

$success = "Account created successfully! You can login now.";

}
?>
<!DOCTYPE html>
<html>
<head>

<title>StockTrack Login</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
margin:0;
}

.container{
background:white;
padding:40px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
width:350px;
}

h2{
text-align:center;
margin-bottom:20px;
}

input{
width:100%;
padding:10px;
margin:8px 0;
border:1px solid #ccc;
border-radius:5px;
}

button{
width:100%;
padding:10px;
background:#2196F3;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
}

button:hover{
background:#1976D2;
}

.tabs{
display:flex;
margin-bottom:20px;
}

.tabs button{
flex:1;
background:#eee;
color:black;
}

.tabs button.active{
background:#2196F3;
color:white;
}

.form{
display:none;
}

.form.active{
display:block;
}

.message{
text-align:center;
color:red;
}

.success{
color:green;
}

</style>

<script>

function showForm(form){

document.getElementById("loginForm").classList.remove("active");
document.getElementById("registerForm").classList.remove("active");

document.getElementById(form).classList.add("active");

}

</script>

</head>

<body>

<div class="container">

<h2>StockTracking</h2>

<div class="tabs">

<button onclick="showForm('loginForm')" class="active">Login</button>
<button onclick="showForm('registerForm')">New User?</button>

</div>

<?php if(isset($error)) echo "<p class='message'>$error</p>"; ?>
<?php if(isset($success)) echo "<p class='message success'>$success</p>"; ?>

<!-- LOGIN FORM -->

<form method="POST" id="loginForm" class="form active">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

</form>


<!-- REGISTER FORM -->

<form method="POST" id="registerForm" class="form">

<input type="text" name="new_username" placeholder="Username" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="new_password" placeholder="Password" required>

<button type="submit" name="register">Create Account</button>

</form>

</div>

</body>
</html>

