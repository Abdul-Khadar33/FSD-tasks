<?php
include "db.php";

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$name = $_POST['name'];
$category = $_POST['category'];
$supplier = $_POST['supplier'];
$price = $_POST['price'];
$stock = $_POST['stock'];

/* IMAGE */

$image = $_FILES['image']['name'];

if($image!=""){

move_uploaded_file($_FILES['image']['tmp_name'],"uploads/".$image);

mysqli_query($conn,"
UPDATE products
SET product_name='$name',
category='$category',
supplier='$supplier',
price='$price',
stock='$stock',
image='$image'
WHERE id=$id
");

}else{

mysqli_query($conn,"
UPDATE products
SET product_name='$name',
category='$category',
supplier='$supplier',
price='$price',
stock='$stock'
WHERE id=$id
");

}

header("Location: products.php");

}
?>

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" value="<?php echo $product['product_name']; ?>">

<input type="text" name="category" value="<?php echo $product['category']; ?>">

<input type="text" name="supplier" value="<?php echo $product['supplier']; ?>">

<input type="number" name="price" value="<?php echo $product['price']; ?>">

<input type="number" name="stock" value="<?php echo $product['stock']; ?>">

<br><br>

Current Image:

<br>

<img src="uploads/<?php echo $product['image']; ?>" width="80">

<br><br>

Upload New Image:

<input type="file" name="image">

<br><br>

<button name="update">Update Product</button>

</form>