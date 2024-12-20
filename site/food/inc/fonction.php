<?php
function connexion(){
    return $bdd=mysqli_connect("localhost","root","","foodmart");
}

function insererMembres($nom,$email){
    $bdd=connexion();
    $requete="INSERT INTO users(name,email)
    values('$nom','$email')";
    $membres=mysqli_query($bdd,$requete);
    header('location:../page/index.php');
    }
   
    
  

    function recherche($a) {
        $bdd = connexion();
        $requete = "SELECT * FROM products WHERE name LIKE '%$a%'";
        $resultat = mysqli_query($bdd, $requete);
        $produits = array();
        $i = 0;
        while ($res = mysqli_fetch_assoc($resultat)) {
            $produits[$i]['product_id'] = $res['product_id'];
            $produits[$i]['name'] = $res['name'];
            $produits[$i]['price'] = $res['price'];
            $i++;
        }
        return $produits;
    }
    
    $searchResults = [];
    if (isset($_GET['query'])) {
        $searchTerm = $_GET['query'];
        $searchResults = recherche($searchTerm);
    }


    

    function getMembreparId($id){
        $bdd=connexion();
        $requete="SELECT * FROM users WHERE user_id=$id";
        $resultat=mysqli_query($bdd,$requete);
        while($res=mysqli_fetch_assoc($resultat)){
            $membres['user_id']=$res['user_id'];
            $membres['name']=$res['name'];
            $membres['email']=$res['email'];
        }
        return $membres;
    }

    function selectVegetables(){
        $bdd=connexion();
        $requete="SELECT * FROM products where category_id=5";
        $resultat=mysqli_query($bdd,$requete);
        $produits=array();
        $i=0;
        while($res=mysqli_fetch_assoc($resultat)){
            $produits[$i]['name']=$res['name'];
            $produits[$i]['price']=$res['price'];
            $produits[$i]['rating']=$res['rating'];
            $produits[$i]['image_url']=$res['image_url'];


            $i++;
    
        }
        return $produits;

    }

    function selectFruit(){
        $bdd=connexion();
        $requete="SELECT * FROM products where category_id=4";
        $resultat=mysqli_query($bdd,$requete);
        $produits=array();
        $i=0;
        while($res=mysqli_fetch_assoc($resultat)){
            $produits[$i]['name']=$res['name'];
            $produits[$i]['price']=$res['price'];
            $produits[$i]['rating']=$res['rating'];
            $produits[$i]['image_url']=$res['image_url'];

            $i++;
    
        }
        return $produits;
    }

    function selectGrocerie(){
        $bdd=connexion();
        $requete="SELECT * FROM products where category_id=1";
        $resultat=mysqli_query($bdd,$requete);
        $produits=array();
        $i=0;
        while($res=mysqli_fetch_assoc($resultat)){
            $produits[$i]['name']=$res['name'];
            $produits[$i]['price']=$res['price'];
            $produits[$i]['rating']=$res['rating'];
            $produits[$i]['image_url']=$res['image_url'];

            $i++;
    
        }
        return $produits;
    }


    function selectDrinks(){
        $bdd=connexion();
        $requete="SELECT * FROM products where category_id=2";
        $resultat=mysqli_query($bdd,$requete);
        $produits=array();
        $i=0;
        while($res=mysqli_fetch_assoc($resultat)){
            $produits[$i]['name']=$res['name'];
            $produits[$i]['price']=$res['price'];
            $produits[$i]['rating']=$res['rating'];
            $produits[$i]['image_url']=$res['image_url'];

            $i++;
    
        }
        return $produits;
    }

    function selectChocolates(){
        $bdd=connexion();
        $requete="SELECT * FROM products where category_id=3";
        $resultat=mysqli_query($bdd,$requete);
        $produits=array();
        $i=0;
        while($res=mysqli_fetch_assoc($resultat)){
            $produits[$i]['name']=$res['name'];
            $produits[$i]['price']=$res['price'];
            $produits[$i]['rating']=$res['rating'];
            $produits[$i]['image_url']=$res['image_url'];

            $i++;
    
        }
        return $produits;
    }

        
    function selectProductById($product_id) {
    $bdd=connexion();
    $product_id = (int) $product_id; 
    $result = mysqli_query($bdd, "SELECT * FROM products WHERE product_id = 21");
    return mysqli_fetch_assoc($result);
    }


    function populaire() {
        $bdd = connexion();
        
        $requete = "SELECT p.name, p.price, p.image_url, AVG(a.rating) as average_rating
            FROM products p
            INNER JOIN avis_clients a ON p.product_id = a.product_id
            GROUP BY p.product_id
            ORDER BY average_rating DESC
            LIMIT 5
        ";
        
        $resultat = mysqli_query($bdd, $requete);
        $produits = array();
        
        while ($res = mysqli_fetch_assoc($resultat)) {
            $produits[] = array(
                'name' => $res['name'],
                'price' => $res['price'],
                'rating' => number_format($res['average_rating'], 1),
                'image_url' => $res['image_url']
            );
        }
        
        return $produits;
    }

    








?>

