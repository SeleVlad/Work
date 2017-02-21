<?php
session_start();
include 'functions.php';
require('includes/connection.php');
include_once("config.php");

//add product to session or create new one
if(isset($_POST["type"]) && $_POST["type"]=='add' && $_POST["product_qty"]>0)
{
	foreach($_POST as $key => $value){ //add all post vars to new_product array
		$new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
    }
	//remove unecessary vars
	unset($new_product['type']);
	unset($new_product['return_url']); 
	
 	//we need to get product name and price from database.
    $statement = $mysqli->prepare("SELECT idModel,pret FROM produs WHERE idProdus=? LIMIT 1");
	
	
    $statement->bind_param('s', $new_product["idProdus"]);
    $statement->execute();
    $statement->bind_result($product_name, $price);
	

	
	while($statement->fetch()){
		
		//fetch product name, price from db and add to new_product array
        $new_product["idModel"] = $product_name; 
        $new_product["pret"] = $price;
		
        
        if(isset($_SESSION["cart_products"])){  //if session var already exist
            if(isset($_SESSION["cart_products"][$new_product["idProdus"]])) //check item exist in products array
            {
                unset($_SESSION["cart_products"][$new_product["idProdus"]]); //unset old array item
            }           
        }
        $_SESSION["cart_products"][$new_product["idProdus"]] = $new_product; //update or create product session with new item  
    } 
}

$q1 =  "SELECT idUtilizator from Utilizator
									WHERE numeCont ='".$_SESSION["sess_numeCont"]."';";
$res = mysql_query($q1);


 while ( $db_field = mysql_fetch_assoc($res) ){
 if (isset($_POST ['sub1'])){
	 							$i = 7;
	 							$update = mysql_query("UPDATE produs SET stoc = stoc - '1' WHERE idProdus = '$i';");
								$insert=mysql_query("INSERT INTO coscumparaturi  VALUES('', '1', '7' )");
								
								$q2 = "SELECT * FROM coscumparaturi order by idCosCumparaturi;";
								$res1 = mysql_query($q2);
								while ( $db_field1 = mysql_fetch_assoc($res1)){
									$idc = $db_field1['idCosCumparaturi'];
								}
								$insert1=mysql_query("INSERT INTO comanda VALUES('','".date('Y-m-d')."' , '".$db_field['idUtilizator']."' , '".$idc."' )");
								header('Location: index.php');}
							}
                            
               


//update or remove items 
if(isset($_POST["product_qty"]) || isset($_POST["remove_code"]))
{
	//update item quantity in product session
	if(isset($_POST["product_qty"]) && is_array($_POST["product_qty"])){
		foreach($_POST["product_qty"] as $key => $value){
			if(is_numeric($value)){
				$_SESSION["cart_products"][$key]["product_qty"] = $value;
			}
		}
	}
	//remove an item from product session
	if(isset($_POST["remove_code"]) && is_array($_POST["remove_code"])){
		foreach($_POST["remove_code"] as $key){
			unset($_SESSION["cart_products"][$key]);
		}	
	}
}

//back to return url
$return_url = (isset($_POST["return_url"]))?urldecode($_POST["return_url"]):''; //return url
header('Location:'.$return_url);

?>
 <script>
			function myFunc() {
				alert("Comanda a fost executata!");
			}
</script>