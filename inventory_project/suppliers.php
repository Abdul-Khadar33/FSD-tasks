<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username'])){
header("Location: login.php");
exit();
}

/* ADD SUPPLIER */

if(isset($_POST['add_supplier'])){

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

mysqli_query($conn,"INSERT INTO suppliers(name,email,phone,address)
VALUES('$name','$email','$phone','$address')");

}

/* DELETE SUPPLIER */

if(isset($_GET['delete'])){

$id = $_GET['delete'];

mysqli_query($conn,"DELETE FROM suppliers WHERE id=$id");

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Suppliers</title>
<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container">

<!-- SIDEBAR -->

<div class="sidebar">

<h2>StockTrack</h2>

<ul>

<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="products.php">Products</a></li>
<li><a href="stock.php">Stock Movements</a></li>
<li><a href="suppliers.php">Suppliers</a></li>
<li><a href="logout.php">Logout</a></li>

</ul>

</div>

<!-- MAIN -->

<div class="main">

<h1>Suppliers</h1>

<!-- ADD SUPPLIER -->

<form method="POST">

<input type="text" name="name" placeholder="Supplier Name" required>

<input type="email" name="email" placeholder="Email">

<input type="text" name="phone" placeholder="Phone">

<input type="text" name="address" placeholder="Address">

<button type="submit" name="add_supplier">Add Supplier</button>

</form>

<br>

<!-- SUPPLIERS TABLE -->

<table>

<tr>

<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Address</th>
<th>Action</th>

</tr>

<?php

$result = mysqli_query($conn,"SELECT * FROM suppliers");

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['address']; ?></td>

<td>

<a href="suppliers.php?delete=<?php echo $row['id']; ?>">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>