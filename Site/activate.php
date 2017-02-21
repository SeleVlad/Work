<?php
	//Start session
	session_start();
 
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['sess_numeCont']) || (trim($_SESSION['sess_numeCont']) == '')) {
		header("location: login.php");
		exit();
		
		
	}
	$msg = '';
	
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		
		
		include 'functions.php';
		require 'includes/connection.php';
		//Receive the inc. var.
		
		$id =(int)filterdata($_GET['id']);
		$username =filterdata($_GET['username']);
		$salt =filterdata($_GET['salt']);
		

			//Validate email adress and Sanitize
		$email = filterdata($_POST['email']);
		
		// Remove all illegal characters from email
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		// Validate e-mail
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			die("$email is a not valid email address");
		} 
		//Check for any Empty data
		if(empty($id) || empty($username) || empty($email)){
		die('Please Fill all the Fields');	
			}
			
		
		echo $msg = "<script>alert('Your Account has been activated');</script>";
		header('refresh:0;url=index.php');
		exit();
		
		
			
	
	
		}else{
	
			$msg = 'Invalid Request Method';
		
	}
	
		
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
            </div><!--End of main -->
        </div><!--End of main wrap -->
        <?php include_once('includes/footer.php')?>
    </body>
</html>
