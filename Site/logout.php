
<?php		
//Start session
session_start();

//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['sess_numeCont']) || (trim($_SESSION['sess_numeCont']) == '')) {
  header("location: login.php");
  exit();
}

session_destroy();
unset($_SESSION['sess_numeCont']);
header('Location: login.php');
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
