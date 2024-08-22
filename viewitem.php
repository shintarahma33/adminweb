<?php
require 'function.php';
require 'cek.php';

// Ensure that the item ID is provided
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];
    // Fetch item details from the database using $itemId
    $query = "SELECT * FROM item WHERE id = $itemId";
    $result = mysqli_query($conn, $query);
    $item = mysqli_fetch_assoc($result);
} else {
    // Redirect back to index.php or display an error message
    header('location:index.php');
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Item - Jglow Tyara Cimahi Tengah</title>
    <!-- Add your CSS and JS files here -->
</head>

<body>
    <h1>Item Details</h1>
    <p>Name: <?= $item['name']; ?></p>
    <p>Description: <?= $item['description']; ?></p>
    <p>Quantity: <?= $item['quantity']; ?></p>
    <p>Point: <?= $item['point']; ?></p>
    <p>Normal Price: <?= $item['normal_price']; ?></p>
    <p>Reseller Price: <?= $item['reseller_price']; ?></p>
</body>

</html>