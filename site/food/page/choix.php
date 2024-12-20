<?php
session_start();
include("../inc/fonction.php");
$bdd = connexion();

if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']); 

    switch ($category_id) {
        case "1":
            header("Location: listeGrocerie.php");
            exit;
        case "2":
            header("Location: listeProduits.php");
            exit;
        case "3":
            header("Location: listeChoco.php");
            exit;
        default:
            header("Location: ../index.php");
            exit;
    }
    
}
?>
