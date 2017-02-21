
<?php
	
	//Start session
	session_start();
	include 'functions.php';
	require('includes/connection.php');
	
	include_once("config.php");
 
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['sess_numeCont']) || (trim($_SESSION['sess_numeCont']) == '')) {
		header("location: login.php");
		exit();
		
		
	}
	

	
	//current URL of the Page. cart_update.php redirects back to this URL
	$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

	$msg = '';
	//Check if user pressed the submit button?
	//User registration
	if(isset($_GET['zz'])){
		include 'functions.php';
		require('includes/connection.php');
		//Receiving data as super global var and=var
		$fname = filterdata($_POST['fname']);
		$lname = filterdata($_POST['lname']);
		$uname = filterdata($_POST['uname']);
		$pass  = filterdata($_POST['pass']);
		$cpass = filterdata($_POST['cpass']);
		
		$telephone = filterdata($_POST['telephone']);
		$adress = filterdata($_POST['adress']);
		$postalc = filterdata($_POST['postalc']);
		$region = filterdata($_POST['region']);
		$city = filterdata($_POST['city']);
		
		//Validate email adress and Sanitize
		$email = filterdata($_POST['email']);
	
		// Remove all illegal characters from email
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		// Validate e-mail
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			die("$email is a not valid email address");
		} 
		
	
	
		//Check for any Empty data
		if(empty($fname) || empty($lname) || empty($uname) || empty($pass) || empty($cpass) || empty($email) || empty($telephone) || empty($adress) || empty($postalc) || empty($region) || empty($city)){
		die('Please Fill all the Fields');	
			}
			
		//Check if pass = cpass
		if($pass != $cpass){
			die('Password does not match');
		}
		//Check of username is available
		$query = "SELECT * FROM utilizator WHERE numeCont='#uname' LIMIT 1";
		$query_run = mysql_query($query);
		confirm_query($query_run);
		$num_rows = mysql_num_rows($query_run);
		if($num_rows != 1){
			//creating pseudo random salt
			$salt = sha1($pass.microtime());
			//Generated the pseudo random pass from the salt
			$pass_hash = sha1($pass.$salt);
			//3.Perform the Querry
			$query = "INSERT INTO utilizator(numeCont,parola,nume,prenume,email,telefon,adresa,codPostal,Judet,Oras)VALUES('$uname','$pass_hash','$lname','$fname','$email','$telephone','$adress','$postalc','$region','$city')";
			$query_run = mysql_query($query);
			confirm_query($query_run);
										
			//Confirmation email :
			$id = mysql_insert_id();							
																														$to = $email;
			$subject = "Email Verification for eGSM account";
			
			$message = "
			<!doctype html>
			<html>
				<head>
					<title>HTML email</title>
				</head>
				<body>
					<p>Activate Your Account By Clicking the Activation Link</p>
					<table>
						<tr>
							<td><h1 style=\"background:red;color:#fff\">
							<a href=\"http://www.eGSM.com/activate.php?id=$id&username=$uname&email=$email&salt=$salt\">Activate</a></h1>
							</td>
						</tr>
					</table>
				</body>
			</html>
			";
			
			
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			// More headers
			$headers .= 'From: <sele@eGSM.com>' . "\r\n";
	
			
			$mail_sent=mail($to,$subject,$message,$headers);
			if($mail_sent){$msg ='Email Verification link is sent to your email'.$email;}else{ $msg ='We were unable to sent the email';}
										
			
			include 'includes/mysql_close.php';
		}else{
			$msg = 'Username Already Taken';
			include 'includes/mysql_close.php';
		}
				
				
	
				
				
			
			
	}
	//User Authen.
	if(isset($_POST['lgsmbt'])){
		//echo'ok';	
		//Receive data and filter
		include 'functions.php';
		require 'includes/connection.php';
		
		$uname = filterdata($_POST['uname']);
		$password = filterdata($_POST['password']);
		
		//Check if uname exists in DB
		
		$query="SELECT * FROM utilizator WHERE numeCont='$uname' LIMIT 1";
		$query_run = mysql_query($query);
		confirm_query($query_run);
		
		$num_rows = mysql_num_rows($query_run);
		
		if($num_rows == 0){
			echo 'Invalid Username';
				
		}else{
			

			$query = "SELECT * FROM utilizator WHERE numeCont='$uname' and parola='$password' ";
			$query_run = mysql_query($query);
			confirm_query($query_run);
			$num_rows = mysql_num_rows($query_run);
			if($num_rows == 0){
			echo 'Invalid Username and/or Password';
			}else{echo 'Welcome';}
		}
		
		
		
	};
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>eGSM</title>
        <link rel="shortcut icon" href="favicon (1).ico">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <script type= type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
    	 <?php include_once('includes/header.php')?>
         
        <div class ="main_wrap">
        	<div class = "main">
            	<?php/* echo $msg; */?>
                <?php
				/*if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0)
				{/*
					echo '<div class="cart-view-table-front" id="view-cart">';
					echo '<h3>Your Shopping Cart</h3>';
					echo '<form method="post" action="cart_update2.php">';
					echo '<table width="100%"  cellpadding="6" cellspacing="0">';
					echo '<tbody>';
				
					$total =0;
					$b = 0;
					foreach ($_SESSION["cart_products"] as $cart_itm)
					{
						$nume="Iphone 5";
						$product_name = $cart_itm["idModel"];
						$product_qty = $cart_itm["product_qty"];
						$product_price = $cart_itm["pret"];
						$product_code = $cart_itm["idProdus"];
						//$product_color = $cart_itm["product_color"];
						$bg_color = ($b++%2==1) ? 'odd' : 'even'; //zebra stripe
						echo '<tr class="'.$bg_color.'">';
						echo '<td>Qty <input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
						echo '<td>'.$nume.'</td>';
						echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /> Remove</td>';
						echo '</tr>';
						$subtotal = ($product_price * $product_qty);
						$total = ($total + $subtotal);
					}
					echo '<td colspan="4">';
					echo '<button type="submit">Update</button><a href="view_cart2.php" class="button">Checkout</a>';
					echo '</td>';
					echo '</tbody>';
					echo '</table>';
					
					$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
					echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
					echo '</form>';
					echo '</div>';
				
				}
				*/?>
				<!-- View Cart Box End -->
                
        <center>        
                
                <!-- Products List Start -->
<?php

	
$results = $mysqli->query("SELECT numeMarca,numeModel, pret, imagine, culoare, spatiu, dimensiune, memorieRAM,idProdus, procesor, camera,stoc
						FROM produs, marca, model ,specificatii, culoare, spatiustocare
						WHERE produs.idMarca = marca.idMarca AND produs.idProdus=2
						AND produs.idModel = model.idModel
						AND produs.idSpecificatii = specificatii.idSpecificatii
						AND specificatii.idCuloare = culoare.idCuloare
						AND specificatii.idSpatiuStocare = spatiustocare.idSpatiuStocare");
if($results){ 
$products_item = '<ul class="products">';
//fetch results set as object and output HTML

while($obj = $results->fetch_object())
{
if($obj->stoc > 0){
$products_item .= <<<EOT
	<li class="product">
	<form method="post" action="cart_update2.php">
	<div class="product-content"><h3>Iphone {$obj->numeModel}</h3>
	<div>Spatiu: 16</div>
  	<div>Dimensiune: 4.3</div>
  	<div>Memorie Ram: 1 GB</div>
 	<div>Model Procesor: Dual-core 1.3 GHz Swift</div>
  	<div>Camera: 8 MP</div>
	<div>OS: iOS</div>
	<div class="product-thumb"><img src="{$obj->imagine}"></div>
	<div name="product_color"><h4>Culoare: {$obj->culoare}</h4></div>
	<div class="product-info">
	<h4>Pret {$obj->pret}{$currency}</h4> 
	
	<fieldset>
	
	
	<label>
		<span>Quantity</span>
		<input type="text" size="2" maxlength="2" name="product_qty" value="1" />
	</label>
	
	</fieldset>
	<input type="hidden" name="idProdus" value="{$obj->idProdus}" />
	<input type="hidden" name="type" value="add" />
	<input type="hidden" name="return_url" value="{$current_url}" />
	<div align="center"><button type="submit" class="add_to_cart">Add</button></div>
	</div></div>
	</form>
	</li>
EOT;
}
else
	{
		echo "<center><p><strong>Produs Indisponibil Momentat , stoc insuficient<strong></p></center>";
		
	}	
}
$products_item .= '</ul>';
echo $products_item;
}
?>    
<!-- Products List End -->
        </center>        
               
            </div><!--End of main -->
        </div><!--End of main wrap -->
        <?php include_once('includes/footer.php')?>
    </body>
</html>
