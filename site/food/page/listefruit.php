<?php
session_start();
include("../inc/fonction.php");
$name = isset($_SESSION['name']) ;
$produits = selectFruit();  
$totalProduits = count($produits);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodmart Vegetables</title>
</head>
<body>
    <h1>Welcome, <?php echo $name; ?></h1>
    <h2>Fruits</h2>
    <ul>
        <?php 
        for ($i = 0; $i < $totalProduits; $i++) {
            echo "<li>";
            echo $produits[$i]['name'] . " - $" . $produits[$i]['price'];
            echo "<br>";
            echo "<img src='../images/" . $produits[$i]['image_url'] . "' alt='" . $produits[$i]['name'] . "' width='100' height='100'>";
            echo "</li>";
        }
        ?>
    </ul>
</body>
</html>
