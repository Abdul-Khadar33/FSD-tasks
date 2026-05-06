<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username'])){
header("Location: login.php");
exit();
}

/* ADD PRODUCT */

if(isset($_POST['add_product'])){

$name = $_POST['name'];
$category = $_POST['category'];
$supplier = $_POST['supplier'];
$price = $_POST['price'];
$stock = $_POST['stock'];

/* IMAGE UPLOAD */

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

if($image != ""){
move_uploaded_file($tmp,"uploads/".$image);
}

mysqli_query($conn,"
INSERT INTO products(product_name,category,supplier,price,stock,image)
VALUES('$name','$category','$supplier','$price','$stock','$image')
");

}

/* DELETE PRODUCT */

if(isset($_GET['delete'])){

$id = intval($_GET['delete']);

mysqli_query($conn,"DELETE FROM products WHERE id=$id");

header("Location: products.php");
exit();

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Products</title>

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

<h1>Products</h1>

<!-- ADD PRODUCT -->

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" placeholder="Product Name" required>

<select name="category" required>

<?php
$c = mysqli_query($conn,"SELECT name FROM categories");

while($cat=mysqli_fetch_assoc($c)){
echo "<option>".$cat['name']."</option>";
}
?>

</select>

<input type="text" name="supplier" placeholder="Supplier" required>

<input type="number" name="price" placeholder="Price" required>

<input type="number" name="stock" placeholder="Stock" required>

<input type="file" name="image">

<button type="submit" name="add_product">Add Product</button>

</form>

<br>

<input type="text" id="search" placeholder="Search product..." onkeyup="searchProduct()">

<br><br>

<!-- PRODUCT TABLE -->

<table>

<tr>
<th>Image</th>
<th>Product</th>
<th>Category</th>
<th>Supplier</th>
<th>Price</th>
<th>Stock</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php

$result = mysqli_query($conn,"SELECT * FROM products");

while($row = mysqli_fetch_assoc($result)){

$stock = $row['stock'];

if($stock == 0){
$status = "Out";
}
elseif($stock <=5){
$status = "Low";
}
else{
$status = "OK";
}

?>

<tr>

<td>

<?php
if($row['image']!=""){
echo "<img src='uploads/".$row['image']."' width='50'>";
}
?>

</td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['category']; ?></td>

<td><?php echo $row['supplier']; ?></td>

<td>₹<?php echo number_format($row['price'],2); ?></td>

<td><?php echo $row['stock']; ?></td>

<td class="
<?php
if($status=='OK') echo 'status-ok';
if($status=='Low') echo 'status-low';
if($status=='Out') echo 'status-out';
?>
">

<?php echo $status; ?>

</td>

<td>

<a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a> |

<a href="products.php?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this product?');">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<script>

function searchProduct(){

let input = document.getElementById("search").value.toLowerCase();

let rows = document.querySelectorAll("table tr");

rows.forEach((row,i)=>{

if(i===0) return;

let text = row.innerText.toLowerCase();

row.style.display = text.includes(input) ? "" : "none";

});

}

</script>

</body>

</html>