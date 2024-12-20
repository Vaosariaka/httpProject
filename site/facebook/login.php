<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
$bdd=mysqli_connect('localhost','root','','facebook');
$mail=$_GET['email'];
$pwd=$_GET['pwd'];
$sql="select Email ,Motdepasse from Membres where Motdepasse ='$pwd'and Email='$mail'";


echo $sql;
$resultat=mysqli_query($bdd,$sql);

//fonction if ts ao anaty mysql dia afficher erreur
if(mysqli_num_rows($resultat)==0){

    echo"erreur";
    
//Recherche sur tous les membres
//a. Demande d’amis sur un membre
//b. Acceptation 
}
else{
}
//Recherche sur tous les membres
//a. Demande d’amis sur un membre
//b. Acceptation 


?>
  <form action="traitement.php" method="get">
<p><input type="text" name="Nom" />
<input type="submit" value="recherche" />  </p>
<?php
$liste="select * from Membres";
//echo $liste;
$resultat=mysqli_query($bdd,$liste); 
while($donnees=mysqli_fetch_assoc($resultat))
{
 ?> 
    <?php echo $donnees['Nom'];?>
<?php } 
?>
</body>
</html>