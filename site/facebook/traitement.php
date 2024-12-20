<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSCRIPTION</title>
</head>
<body>
<?php
$bdd=mysqli_connect('localhost','root','','facebook');
$nom=$_GET['Nom'];

$sql="select  * from Membres where Nom ='$nom' ";
echo $sql;
$resultat=mysqli_query($bdd,$sql);

while($donnees=mysqli_fetch_assoc($resultat))
{
 ?> 
    <?php echo $nom;?>
    <?php echo "yes";?>  
<?php } 
if(mysqli_num_rows($resultat)==0){

    echo  "erreur";
}
?>
</body>
</html>