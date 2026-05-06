<?php
include "db.php";

$labels = [];
$data = [];

$result = mysqli_query($conn,"SELECT product_name, stock FROM products");

while($row = mysqli_fetch_assoc($result)){
$labels[] = $row['product_name'];
$data[] = $row['stock'];
}

echo json_encode([
"labels"=>$labels,
"data"=>$data
]);