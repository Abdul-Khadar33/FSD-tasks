<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username'])){
header("Location: login.php");
exit();
}

/* DASHBOARD DATA */

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM products"))['total'] ?? 0;
$totalSuppliers = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM suppliers"))['total'] ?? 0;
$totalStock = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(stock) AS total FROM products"))['total'] ?? 0;
$lowStock = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM products WHERE stock<=5"))['total'] ?? 0;


/* PRODUCT DATA FOR CHARTS */

$productLabels = [];
$productStock = [];

$result = mysqli_query($conn,"SELECT product_name,stock FROM products");

while($row=mysqli_fetch_assoc($result)){
$productLabels[] = $row['product_name'];
$productStock[] = $row['stock'];
}


/* TOP PRODUCTS */

$topProducts = [];
$topStock = [];

$top = mysqli_query($conn,"SELECT product_name,stock FROM products ORDER BY stock DESC LIMIT 5");

while($row=mysqli_fetch_assoc($top)){
$topProducts[] = $row['product_name'];
$topStock[] = $row['stock'];
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Inventory Dashboard</title>

<link rel="stylesheet" href="css/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<div class="container">

<!-- SIDEBAR -->

<div class="sidebar">

<h2>StockTrack</h2>

<ul>
<li><a href="dashboard.php">📊 Dashboard</a></li>
<li><a href="products.php">📦 Products</a></li>
<li><a href="stock.php">📈 Stock Movements</a></li>
<li><a href="suppliers.php">🏢 Suppliers</a></li>
<li><a href="logout.php">🚪 Logout</a></li>
</ul>

</div>


<!-- MAIN CONTENT -->

<div class="main">

<h1>Dashboard</h1>

<!-- EXPORT BUTTON -->

<a href="export_excel.php">
<button style="padding:8px 15px;background:#4CAF50;color:white;border:none;border-radius:5px;margin-bottom:20px;">
Download Excel Report
</button>
</a>


<!-- NOTIFICATIONS -->

<h2>Notifications</h2>

<div class="alerts">

<?php

$alerts = mysqli_query($conn,"SELECT product_name,stock FROM products WHERE stock<=5");

while($row=mysqli_fetch_assoc($alerts)){

$product = htmlspecialchars($row['product_name']);
$stock = $row['stock'];

if($stock == 0){

echo "<p style='color:red;'>⚠ $product is OUT OF STOCK</p>";

}else{

echo "<p style='color:orange;'>⚠ $product stock is LOW ($stock left)</p>";

}

}

?>

</div>


<!-- DASHBOARD CARDS -->

<div class="cards">

<div class="card">
<h3>Total Products</h3>
<p><?php echo $totalProducts; ?></p>
</div>

<div class="card">
<h3>Total Suppliers</h3>
<p><?php echo $totalSuppliers; ?></p>
</div>

<div class="card">
<h3>Total Stock</h3>
<p><?php echo $totalStock; ?></p>
</div>

<div class="card">
<h3>Low Stock</h3>
<p><?php echo $lowStock; ?></p>
</div>

</div>


<!-- CHARTS -->

<div class="charts">

<div class="chart-box large-chart">
<h3>Stock by Product</h3>
<canvas id="barChart"></canvas>
</div>

<div class="chart-box">
<h3>Stock Trend</h3>
<canvas id="lineChart"></canvas>
</div>

<div class="chart-box pie-chart">
<h3>Stock by Category</h3>
<canvas id="pieChart"></canvas>
</div>

<div class="chart-box">
<h3>Top Products</h3>
<canvas id="topProductsChart"></canvas>
</div>

</div>


<!-- LOW STOCK TABLE -->

<h2>Low Stock Alert</h2>

<table>

<tr>
<th>Product</th>
<th>Stock</th>
</tr>

<?php

$result = mysqli_query($conn,"SELECT product_name,stock FROM products WHERE stock<=5");

while($row=mysqli_fetch_assoc($result)){

$product = htmlspecialchars($row['product_name']);
$stock = $row['stock'];

echo "<tr>";
echo "<td>$product</td>";
echo "<td>$stock</td>";
echo "</tr>";

}

?>

</table>

</div>

</div>


<!-- PASS DATA TO JAVASCRIPT -->

<script>

let productLabels = <?php echo json_encode($productLabels); ?>;
let productStock = <?php echo json_encode($productStock); ?>;

let topProducts = <?php echo json_encode($topProducts); ?>;
let topStock = <?php echo json_encode($topStock); ?>;

</script>

<script src="js/chart.js"></script>


<footer class="footer">
© 2026 StockTrack | Inventory Management System  
Version 1.0 | VelTech University Project | Developed by AbdulKhadar
</footer>

</body>

</html>