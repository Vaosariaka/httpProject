<?php
session_start();
include("../inc/fonction.php");
$name = isset($_SESSION['name']) ;
$produits = selectChocolates();  
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
<div class="swiper-slide">
                      <div class="row banner-content p-5">
                        <div class="content-wrapper col-md-7">
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
    </div>
                      </div>
                    </div>
</body>
</html>
