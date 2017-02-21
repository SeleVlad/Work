
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
            	<?php echo $msg; ?>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                
             <center><p><strong>Inregistrare comenzi, anulare si modificari comenzi</strong></p></center>
	<center><p>T*: 021 200.52.00</p></center>
	<center><p>M*: 0722.25.00.00</p></center>
	<center><p>Program: Luni – Duminica: 24/24</p></center>
	<center><p>*linii telefonice cu tarif normal</p></center>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
                <center><p><strong>Urmarire comanda</strong></p></center>
<center><p>Accesati : <a href="http://www2.fancourier.ro/en/awb-tracking/">http://www2.fancourier.ro/en/awb-tracking/</a></p></center>
<center><p>Accesati : <a href="http://www2.fancourier.ro/en/awb-tracking/">https://www.ups.com/WebTracking/track?loc=en_US</a></p></center>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
		 <center> <p><strong>Service produse</strong></p>
<p>Daca ti s-a stricat un produs pe care l-ai cumparat de la eGSM (vandut de eGSM) te rugam trimite un mail la adresa:</p>
<p><a href="service@egsm.ro">service@egsm.ro</a></p>
 <p>&nbsp;</p>
<p>Daca produsul este inca in garantie, beneficiezi gratuit de ridicarea acestuia de catre curier si repararea de catre Depanero, partener de service eMAG.</p>
 <p>&nbsp;</p>
<p>Adresa Depanero: Soseaua Orhideelor, nr. 27-29, sector 1, Oradea</p>
<p>M: 0742.726.843 (07GARANTIE); *4114 (apelabil doar in retelele mobile)</p>
<p>Program service: Luni – Vineri: 09:00 – 20:00; Sambata: 10:00 – 14:00</p>
<p>Program relatii clienti: Luni – Vineri: 08:00 – 20:00; Sambata: 10:00 – 14:00</p>
 <p>&nbsp;</p>
<p>Daca produsul care ti s-a stricat a fost cumparat de la unul dintre partenerii eGSM Marketplace, pentru repararea produsului te rugam sa il contactezi direct pe acesta.</p></center>
              <p>&nbsp;</p>
                 <center> <p><strong>Showroom-uri si puncte de livrare</strong></p>
                   <p>&nbsp;</p>

<p>Showroom Oradea</p>
<p>Punct de livrare Baneasa</p>
<p>Showroom Iasi</p>
<p>Showroom Galati</p>
<p>Showroom Constanta</p>
<p>Showroom Ploiesti</p>
<p>Showroom Pitesti</p>
<p>Showroom Brasov</p>
<p>Showroom Craiova</p>
<p>Showroom Timisoara</p>
<p>Showroom Bucuresti</p>
<p>Showroom Cluj</p>

 <p>&nbsp;</p>
<p>Punct de livrare – Oficiul Postal 7 Buzau (Alexandru Marghiloman)</p>
<p>Punct de livrare – Oficiul Postal 4 Targoviste (Turnul Chindiei)</p>

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d21747.472630940716!2d21.91742424861257!3d47.051334683151424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x474647e6274fc649%3A0x755521cf97bf7fb3!2sPasajul+Vulturul+Negru%2C+Oradea!5e0!3m2!1sro!2sro!4v1482868752052" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe></center>


                <p></p>
        	</div><!--End of main -->
        </div><!--End of main wrap -->
        <?php include_once('includes/footer.php')?>
       
    </body>
</html>
