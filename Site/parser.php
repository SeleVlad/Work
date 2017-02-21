
<?php

	
	$msg = '';
	//Check if user pressed the submit button?
	//User registration
	if(isset($_POST['zz'])){
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
		
	
	
		/*//Check for any Empty data
		if(empty($fname) || empty($lname) || empty($uname) || empty($pass) || empty($cpass) || empty($email) || empty($telephone) || empty($adress) || empty($postalc) || empty($region) || empty($city)){
		die('Please Fill all the Fields');	
			}*/
			
		//Check if pass = cpass
		if($pass != $cpass){
			die('Password does not match');
		}
		//Check of username is available
		$query = "SELECT * FROM utilizator WHERE numeCont='$uname' LIMIT 1";
		$query_run = mysql_query($query);
		confirm_query($query_run);
		$num_rows = mysql_num_rows($query_run);
		if($num_rows != 1){
			//creating pseudo random salt
			$salt = sha1($pass.microtime());
			//Generated the pseudo random pass from the salt
			$pass_hash = sha1($pass.$salt);
			//3.Perform the Querry
			$query = "INSERT INTO utilizator(numeCont,parola,nume,prenume,email,telefon,adresa,codPostal,Judet,Oras)VALUES('$uname','$pass','$lname','$fname','$email','$telephone','$adress','$postalc','$region','$city')";
			$query_run = mysql_query($query);
			confirm_query($query_run);
										
			//Confirmation email :
			$id = mysql_insert_id();							
			$to = $email;
			$subject = "Email Verification for eGSM account";
			
			//echo "activate.php?id=$id&username=$uname&email=$email&salt$salt"
			
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
			if($mail_sent){$msg ='Email Verification link is sent to your email '.$email;}else{ $msg ='We were unable to sent the email ';}
										
			
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
		ob_start();
		session_start();
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
			$result = mysql_query($query);
			$userData = mysql_fetch_array($result, MYSQL_ASSOC);
			$num_rows = mysql_num_rows($query_run);

			if($num_rows == 0){
			echo 'Invalid Username and/or Password';
			}else{
				echo 'Welcome';
				session_regenerate_id();
				$_SESSION['sess_numeCont'] = $userData['numeCont'];
				$_SESSION['sess_parola'] = $userData['parola'];
				session_write_close();
				header('Location: index.php');
				
			}
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
    	
<div class ="header_wrap">
    <div class = "header_top_wrap">
        <div class = "header_top">
            <form class="srcfrm">
                <input type="text" name="search" placeholder="Type in Here">
                <input type="submit" name="cc" value=" ">
            </form>
            <ul class="header_top_menu">
                <li><a href="#">My Account</a></li>
                <li><a href="#">My Wishlist</a></li>
                
                <li>
                	<a href="#" id="supanchor">SingUp</a>
                    <form class="Login sign_up" id="supfrm" action="parser.php" method="post">
                    	<div class="triangle"></div>
                    	<input type="button" value="X" id="x2">
                    	<table height="420" width="90%" style="margin:auto">
                        	<tr>
                            	<td>
                            		<label for="fn">First Name</label><br />
                                    <input required placeholder="Enter your Name" id="fn" class="inp inp2" type="text" name="fname">
                                </td>
                                <tr>
                                <td>
                            		<label for="ln">Last Name</label><br />
                                    <input required placeholder="Enter your Last Name" id="ln" class="inp inp2" type="text" name="lname">
                                </td>
                                </tr>
                                <tr>
                                <td>
                            		<label for="uname">Username</label><br />
                                    <input required placeholder="Enter your Username" id="uname" class="inp inp2" type="text" name="uname">
                                </td>
                                </tr>
                                <tr>
                                <td>
                            		<label for="p">Password</label><br />
                                    <input required placeholder="Enter your Password" id="p" class="inp inp2" type="password" name="pass">
                                </td>
                                </tr>
                                <tr>
                                <td>
                            		<label for="cp">Confirm Password</label><br />
                                    <input required placeholder="Enter your Confirmed Password" id="cp" class="inp inp2" type="password" name="cpass">
                                </td>
                            	</tr>
                                <tr>
                                <td>
                            		<label for="em">Email</label><br />
                                    <input required placeholder="Enter your Email" id="em" class="inp inp2" type="email" name="email">
                                </td>
                                </tr>
                                <tr>
                                <td>
                            		<label for="tel">Telephone</label><br />
                                    <input required placeholder="Enter your Mobile Number" id="tel" class="inp inp2" type="tel" name="telephone">
                                </td>
                                </tr>
                                <tr>
                                <td>
                            		<label for="adr">Adress</label><br />
                                    <input required placeholder="Enter your Adress" id="adr" class="inp inp2" type="text" name="adress">
                                </td>
                                </tr>
                                <tr>
                                <td>
                            		<label for="pcd">Postal Code</label><br />
                                    <input required placeholder="Enter your Postal Code" id="pcd" class="inp inp2" type="text" name="postalc">
                                </td>
                                </tr>
                                <tr>
                                <td>
                            		<label for="reg">Region</label><br />
                                    <input required placeholder="Enter your Region" id="reg" class="inp inp2" type="text" name="region">
                                </td>
                                </tr>
                                <tr>
                                <td>
                            		<label for="city">City</label><br />
                                    <input required placeholder="Enter your City" id="city" class="inp inp2" type="text" name="city">
                                </td>
                                </tr>
                           		<tr>
                                <td>
                                    <input class="inp submit" type="submit" name="zz" value="Register">
                                </td>
                            	</tr>
                        </table>
                    </form>
                </li>
                <li>
                	<a href="#" id="loginanchor">Login</a>
                    <form action="parser.php" method="post" class="Login" id="login">
                    	<div class="triangle tri2"></div>
                    	<input type="button" value="X" id="x">
                    	<table height="98%" width="85%" style="margin:auto">
                        	<tr>
                            	<td>
                                <label for="unam">Username</label><br />
                                <input required placeholder="Enter your Username" class="inp inp2" id="unam" type="text" name="uname">
                                </td> 
                            </tr>
                            <tr>
                            	<td>
                                 <label for="pw">Password</label><br />
                                <input required placeholder="Enter your password" class="inp inp2" id="pw" type="password" name="password">
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<input class="inp submit" type="submit" value="Login" name="lgsmbt"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </li>
 
            </ul>
        </div>
    </div><!--End of header top wrap-->
    <div class = "header_middle_wrap">
        <div class = "header_middle">
        	<img src="img/logo.jpg" style="margin-top:25px">
            
        </div>
    </div>
    <div class = "header_bottom_wrap">
        <div class = "header_bottom">
            <ul class = "bottom_menu">
                <li><a href="index.php">Home</a><li>
                <li>
                    <a href="#" onClick="return false;">Products</a>
                    <ul class="Submenu">
                        <li>
                            <a href="#" onClick="return false;" class="ip">Iphone</a>
                            <ul class="Submenu n_submenu">
                                <li><a href="iphone5.php">5</a></li>
                                <li><a href="iphone5S.php">5S</a></li>
                                <li><a href="iphone6.php">6</a></li>
                            </ul>
                         </li>
                        <li>
                            <a href="#" onClick="return false;">HTC</a>
                            <ul class="Submenu n_submenu">
                                <li><a href="htcOne.php">One</a></li>
                                <li><a href="htcM7.php">M7</a></li>
                                <li><a href="htcM8.php">M8</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" onClick="return false;" class="ss">Samsung</a>
                            <ul class="Submenu n_submenu">
                                <li><a href="samsungS6.php">Galaxy S6</a></li>
                                <li><a href="samsungS5.php">Galaxy S5</a></li>
                                <li><a href="samsungS6E.php">Galaxy S6 Edge</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="about.php">About</a><li>
                <li><a href="contact.php">Contact</a><li>
            </ul>
        </div>
    </div><!--End of header bottom wrap -->
</div><!--End of header wrap -->
        <div class ="main_wrap">
        	<div class = "main">
            	<?php echo $msg; ?>
            </div><!--End of main -->
        </div><!--End of main wrap -->
        <?php include_once('includes/footer.php')?>
    </body>
</html>
