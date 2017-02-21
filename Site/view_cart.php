<?php
session_start();
include 'functions.php';
require('includes/connection.php');
include_once("config.php");
//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['sess_numeCont']) || (trim($_SESSION['sess_numeCont']) == '')) {
		header("location: login.php");
		exit();
		
		
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View shopping cart</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
<body>
<h1 align="center">View Cart</h1>
<div class="cart-view-table-back">
<form method="post" action="cart_update.php">
<table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantity</th><th>Name</th><th>Price</th><th>Total</th><th>Remove</th></tr></thead>
  <tbody>
 	<?php
	$vr=0;
	if(isset($_SESSION["cart_products"])) //check session var
    {
		global $vr;
		$vr=10;
		$total = 0; //set initial total value
		$b = 0; //var for zebra stripe table 
		foreach ($_SESSION["cart_products"] as $cart_itm)
        {
			//$nume="Iphone";
			
			//set variables to use in content below
			$product_name = $cart_itm["idModel"];
			$product_qty = $cart_itm["product_qty"];
			$product_price = $cart_itm["pret"];
			$product_code = $cart_itm["idProdus"];
			global $vr;
			$vr = $product_code;
			if($product_name == 1 ){$nume="HTC One"; /*$id=1;*/ }
			if($product_name == 2 ){$nume="Iphone 5";/*$id=2;*/ }
			if($product_name == 3 ){$nume="Iphone 5S"; /*$id=3;*/}
			if($product_name == 4 ){$nume="Iphone 6"; /* $id=4; */}
			if($product_name == 5 ){$nume="Samsung S6"; /* $id=5; */}
			if($product_name == 6 ){$nume="HTC M7";/*  $id=6; */}
			if($product_name == 7 ){$nume="HTC M8"; /* $id=7; */}
			if($product_name == 8 ){$nume="Samsung S5"; /* $id=8; */}
			if($product_name == 9 ){$nume="Samsung S6E"; /* $id=9; */}
			
			
			$subtotal = ($product_price * $product_qty); //calculate Price x Qty
			
		   	$bg_color = ($b++%2==1) ? 'odd' : 'even'; //class for zebra stripe 
		    echo '<tr class="'.$bg_color.'">';
			echo '<td>'.$product_qty.'</td>';
			echo '<td>'.$nume.'</td>';
			echo '<td>'.$product_price.$currency.'</td>';
			echo '<td>'.$subtotal.$currency.'</td>';
			echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /></td>';
            echo '</tr>';
			$total = ($total + $subtotal); //add subtotal to total var 
			
        }
		
/* 		$grand_total = $total + $shipping_cost; //grand total including shipping cost
		foreach($taxes as $key => $value){ //list and calculate all taxes in array
				$tax_amount     = round($total * ($value / 100));
				$tax_item[$key] = $tax_amount;
				$grand_total    = $grand_total + $tax_amount;  //add tax val to grand total
		}
		
		$list_tax       = '';
		foreach($tax_item as $key => $value){ //List all taxes
			$list_tax .= $key. ' : '. $currency. sprintf("%01.2f", $value).'<br />';
		} */
		//$shipping_cost = ($shipping_cost)?'Shipping Cost : '.$currency. sprintf("%01.2f", $shipping_cost).'<br />':'';
		//$shipping_cost = ($shipping_cost)?'Shipping Cost : '.$currency. sprintf("%01.2f", 15.0).'<br />':'';
		$grand_total = $total  + 15.0;
		/*if(!(isset($grand_total)))
			$grand_total =0;*/
	
			
	}
    ?>
    <?php if(!(isset($grand_total)))
		{
			$grand_total =0;
		} 
			
		?>
    <tr><td colspan="5"><span style="float:right;text-align: right;"><?php echo 'Shipping Cost : '.$currency.sprintf("%01.2f", 15.0).'<br/>'; ?>Amount Payable : <?php echo sprintf("%01.2f", $grand_total) . $currency;?></span></td></tr>
    <tr><td colspan="5">
     <span style="float:right;text-align: right;"><form>
  		<input type="radio" name="sender" value="FanCourier" checked> FanCourier
  		<input type="radio" name="sender" value="UPS"> UPS<br>
	</form></span></td></tr>
    <tr><td colspan="5"><button type="submit" name="sub1" onclick="myFunc()" value="BUY">Order</button><a href="index.php" class="button">Add More Items</a><button type="submit">Update</button></td></tr>
    
  </tbody>
</table>
<input type="hidden" name="return_url" value="<?php 
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
echo $current_url; ?>" />
</form>

<?php
$date_array = array();
$qty_array = array();
if(isset($_SESSION["cart_products"])){
foreach ($_SESSION["cart_products"] as $rez)
{
	$product_code = $rez["idProdus"];
	 $date_array[] = $product_code;
	
	$qty = $rez["product_qty"];
	 $qty_array[] = $qty ;
}
}

$q1 =  "SELECT idUtilizator from Utilizator
									WHERE numeCont ='".$_SESSION["sess_numeCont"]."';";
$res = mysql_query($q1);

 while ( $db_field = mysql_fetch_assoc($res) ){
 if (isset($_POST ['sub1'])){	
 								$q3 = "SELECT * FROM coscumparaturi order by idCosCumparaturi;";
								$res2 = mysql_query($q3);
								while ( $db_field2 = mysql_fetch_assoc($res2)){
									$idc1 = $db_field2['idCosCumparaturi'];
								}
								
								global $date_array;
								//$insert=mysql_query("INSERT INTO coscumparaturi VALUES('', '".$qty_array[0]."', '".$date_array[0]."')");
								$arrlength = count($date_array);
								for($x = 0; $x < $arrlength; $x++){
								$insert=mysql_query("INSERT INTO coscumparaturi VALUES('', '".$qty_array[$x]."', '".$date_array[$x]."')");}
								
								$q2 = "SELECT * FROM coscumparaturi order by idCosCumparaturi;";
								$res1 = mysql_query($q2);
								while ( $db_field1 = mysql_fetch_assoc($res1)){
									$idc = $db_field1['idCosCumparaturi'];
								}
								$dif = $idc - $idc1;
								for($x1 = 1; $x1 <= $dif; $x1++){
									$ids = $idc1 + $x1;
								$insert1=mysql_query("INSERT INTO comanda VALUES('','".date('Y-m-d')."' , '".$db_field['idUtilizator']."' , '".$ids."' )");}
								
								//$insert1=mysql_query("INSERT INTO comanda VALUES('','".date('Y-m-d')."' , '".$db_field['idUtilizator']."' , '".$idc."' )");
								header('Location: index.php');}
							}?>
                            
                            <script>
			function myFunc() {
				alert("Comanda a fost executata!");
			}
		</script>
</div>

</body>
</html>
