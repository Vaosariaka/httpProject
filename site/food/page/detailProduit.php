<?php
session_start();
include("../inc/fonction.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$produit = selectProductById($id);  

if (!$produit) {
    echo "Produit introuvable.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Détails du Produit</title>
</head>
<body>
    <h1><?php echo $produit['name']; ?></h1>
    <p>Prix : $<?php echo $produit['price']; ?></p>
    <p>Quantité en stock : <?php echo $produit['stock_quantity']; ?> <?php echo $produit['unit']; ?></p>
    <p>Évaluation : <?php echo $produit['rating']; ?> étoiles</p>
    <img src="<?php echo "../images/".$produit['image_url']; ?>" alt="<?php echo $produit['name']; ?>" style="width:200px;">
</body>
</html>
