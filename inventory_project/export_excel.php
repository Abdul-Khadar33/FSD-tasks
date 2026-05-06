<?php
include "db.php";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=inventory_report.xls");

echo "Product Name\tCategory\tSupplier\tPrice\tStock\n";

$result = mysqli_query($conn,"SELECT * FROM products");

while($row=mysqli_fetch_assoc($result)){

echo $row['product_name']."\t".
     $row['category']."\t".
     $row['supplier']."\t".
     $row['price']."\t".
     $row['stock']."\n";

}
?>