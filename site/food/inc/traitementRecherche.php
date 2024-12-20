<?php

session_start();
include("../inc/fonction.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de produits</title>
</head>
<body>
    <?php if (!empty($searchResults)): ?>
        <h2>Résultats pour "<?php echo $searchTerm; ?>"</h2>
        <ul>
            <?php foreach ($searchResults as $produit): ?>
                <li><?php echo $produit['name'] . " - " . $produit['price']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php elseif (isset($_GET['query'])): ?>
        <p>Aucun produit trouvé pour "<?php echo $searchTerm; ?>"</p>
    <?php endif; ?>
</body>
</html>


