
<?php
	//Start session
	session_start();
 
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['sess_numeCont']) || (trim($_SESSION['sess_numeCont']) == '')) {
		header("location: login.php");
		exit();
		
		
	}

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
        <script type= type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
    	<?php include_once('includes/header.php')?>
        <div class ="main_wrap">
        	<div class = "main">
            	
                <p>&nbsp;</p>
            	<p><b>Nume Prenume : </b><?php 
				include 'functions.php';
				require 'includes/connection.php';
				$cnt = $_SESSION["sess_numeCont"];
				$nume = "SELECT * FROM utilizator WHERE numeCont='$cnt'";
				$query_run = mysql_query($nume);
				
				
			
				while($emp = mysql_fetch_assoc($query_run))
				{
						echo $emp['nume'];
						echo ' ';
						echo $emp['prenume'];
				}

				?></p> 
           	 	<p>&nbsp;</p>
            	<p><b>Telefon Mobil : </b><?php 
				
				require 'includes/connection.php';
				$cnt = $_SESSION["sess_numeCont"];
				$nume = "SELECT * FROM utilizator WHERE numeCont='$cnt'";
				$query_run = mysql_query($nume);
				
				
			
				while($emp = mysql_fetch_assoc($query_run))
				{
						echo $emp['telefon'] . ' ';
						echo ' ';
					
				}

				?> <a href="editNumber.php">Update</a>
                </p>
            	<p>&nbsp;</p>
            	<p><b>Adresa de livrare : </b><?php 
				
				require 'includes/connection.php';
				$cnt = $_SESSION["sess_numeCont"];
				$nume = "SELECT * FROM utilizator WHERE numeCont='$cnt'";
				$query_run = mysql_query($nume);
				
				
			
				while($emp = mysql_fetch_assoc($query_run))
				{
						echo $emp['adresa'];
						echo ' ';
				}

				?><a href="editAdress.php">Update</a></p>
                
                
            	<p>&nbsp;</p>
            	<p><b>Oras : </b><?php 
				
				require 'includes/connection.php';
				$cnt = $_SESSION["sess_numeCont"];
				$nume = "SELECT * FROM utilizator WHERE numeCont='$cnt'";
				$query_run = mysql_query($nume);
				
				
			
				while($emp = mysql_fetch_assoc($query_run))
				{
						echo $emp['Oras'];
						echo ' ';
				}

				?><a href="editOras.php">Update</a></p>
                
            	<p>&nbsp;</p>
                <p><b>Judet : </b><?php 
				
				require 'includes/connection.php';
				$cnt = $_SESSION["sess_numeCont"];
				$nume = "SELECT * FROM utilizator WHERE numeCont='$cnt'";
				$query_run = mysql_query($nume);
				
				
			
				while($emp = mysql_fetch_assoc($query_run))
				{
						echo $emp['Judet'];
						echo ' ';
				}

				?><a href="editJudet.php">Update</a></p>
            	<p>&nbsp;</p>
                <p><b>eMail : </b><?php 
				
				require 'includes/connection.php';
				$cnt = $_SESSION["sess_numeCont"];
				$nume = "SELECT * FROM utilizator WHERE numeCont='$cnt' ";
				$query_run = mysql_query($nume);
				
				
			
				while($emp = mysql_fetch_assoc($query_run))
				{
						echo $emp['email'];

				}

				?></p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            	<p><b>Istoric : </b><br><br>
                <?php 
                require 'includes/connection.php';
				$cnt = $_SESSION["sess_numeCont"];
				$nume = "SELECT * FROM utilizator WHERE numeCont='$cnt' ";
				$id = mysql_query($nume);
				$id2;
				while($emp1 = mysql_fetch_assoc($id))
				{
						$id2 =$emp1['idUtilizator'];

				}
                $comanda = "SELECT * FROM comanda,coscumparaturi,produs,model,marca WHERE idUtilizator ='$id2' AND comanda.idCosCumparaturi = coscumparaturi.idCosCumparaturi AND coscumparaturi.idProdus = produs.idProdus AND produs.idModel = model.idModel AND produs.idMarca = marca.idMarca
				ORDER BY comanda.idComanda ASC ";
				
				
				$query_run = mysql_query($comanda);
				$ron = "RON";
				while($emp = mysql_fetch_assoc($query_run))
				{		$qty = $emp['cantitate'];
						 $finalPrice = $qty * $emp['pret'];
						echo $emp['dataComanda'].' '.$emp['numeMarca'].' '.$emp['numeModel'].'---Q:'.$qty.'---'.$finalPrice.' '.$ron."<br>";
						

				}
				
                ?>
                </p>

        	</div><!--End of main -->
        </div><!--End of main wrap -->
        <?php include_once('includes/footer.php')?>
    </body>
</html>
