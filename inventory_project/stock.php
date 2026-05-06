<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username'])){
header("Location: login.php");
exit();
}

/* ADD STOCK MOVEMENT */

if(isset($_POST['add_stock'])){

$product_id = $_POST['product_id'];
$type = $_POST['type'];
$qty = $_POST['quantity'];
$note = $_POST['note'];

/* GET CURRENT STOCK */

$result = mysqli_query($conn,"SELECT stock FROM products WHERE id=$product_id");
$row = mysqli_fetch_assoc($result);
$currentStock = $row['stock'];

/* STOCK IN */

if($type == "IN"){

mysqli_query($conn,"
UPDATE products
SET stock = stock + $qty
WHERE id=$product_id
");

}

/* STOCK OUT */

if($type == "OUT"){

if($currentStock < $qty){
die("Not enough stock available");
}

mysqli_query($conn,"
UPDATE products
SET stock = stock - $qty
WHERE id=$product_id
");

}

/* INSERT MOVEMENT */

mysqli_query($conn,"
INSERT INTO stock_movements(product_id,type,quantity,note)
VALUES('$product_id','$type','$qty','$note')
");

/* REDIRECT */

header("Location: stock.php");
exit();

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Stock Movements</title>
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

<h1>Stock Movements</h1>

<!-- ADD MOVEMENT -->

<form method="POST">

<select name="product_id">

<?php

$result = mysqli_query($conn,"SELECT * FROM products");

while($row=mysqli_fetch_assoc($result)){

echo "<option value='".$row['id']."'>".$row['product_name']."</option>";

}

?>

</select>

<select name="type">
<option value="IN">Stock IN</option>
<option value="OUT">Stock OUT</option>
</select>

<input type="number" name="quantity" placeholder="Quantity" required>

<input type="text" name="note" placeholder="Note">

<button type="submit" name="add_stock">Record Movement</button>

</form>

<br>

<!-- MOVEMENT TABLE -->

<table>

<tr>
<th>Date</th>
<th>Product</th>
<th>Type</th>
<th>Qty</th>
<th>Note</th>
</tr>

<?php

$query = mysqli_query($conn,"
SELECT stock_movements.*, products.product_name
FROM stock_movements
JOIN products ON products.id = stock_movements.product_id
ORDER BY date DESC
");

while($row=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?php echo $row['date']; ?></td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['type']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td><?php echo $row['note']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>