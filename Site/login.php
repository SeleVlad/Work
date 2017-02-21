<?php		
	
	
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
        <script>
			function _(x){
				return document.getElementById(x);
				
			}
			window.onload = function(){
				_('loginanchor').onclick = function(){
					_('loginanchor').style.backgroundColor = '#3195c9';
					_('loginanchor').style.color = '#fff';
					_('supanchor').style.background = 'none';
					_('supanchor').style.color = '#434343';
					_('login').style.display = "block";
					_('supfrm').style.display = 'none';
					return false;
					}
					_('supanchor').onclick = function(){
					_('supanchor').style.backgroundColor = '#3195c9';
					_('supanchor').style.color = '#fff';
					_('loginanchor').style.background = 'none';
					_('loginanchor').style.color = '#434343';
					_('supfrm').style.display = "block";
					_('login').style.display = 'none';
					return false;
					}
					
					_('x').onclick = function() {
						_('loginanchor').style.background = 'none';
						_('loginanchor').style.color = '#434343';
						_('login').style.display = 'none';
						}
					_('x2').onclick = function() {
						_('supanchor').style.background = 'none';
						_('supanchor').style.color = '#434343';
						_('supfrm').style.display = 'none';
						}
			}
        </script>
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
                                    <input  class="inp submit" type="submit" name="zz" value="Register">
                                </td>
                            	</tr>
                        </table>
                    </form>
                </li>
                <li>
                	<a href="#" id="loginanchor">Login</a>
                    <form action="login.php" method="post" class="Login" id="login">
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
                </li

            ></ul>
        </div>
    </div><!--End of header top wrap-->
    <div class = "header_middle_wrap">
        <div class = "header_middle">
        	<img src="img/logo.jpg" style="margin-top:25px">
            <div class="cart">
            	
            </div>
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
            	<div class="sliderBox">
                	<div class="slider">
                    	<ul>
                        	<li><a href="#"><img src="img/slider/slide1.jpg"></a></li>
                            <li><a href="#"><img src="img/slider/slide2.jpg"></a></li>
                            <li><a href="#"><img src="img/slider/slide3.jpg"></a></li>
                            <li><a href="#"><img src="img/slider/slide4.jpg"></a></li>
                            <li><a href="#"><img src="img/slider/slide5.jpg"></a></li>
                            <li><a href="#"><img src="img/slider/slide6.jpg"></a></li>
                            <li><a href="#"><img src="img/slider/slide7.jpg"></a></li>
                            <li><a href="#"><img src="img/slider/slide8.jpg"></a></li>
                            <li><a href="#"><img src="img/slider/slide9.jpg"></a></li>
                            <li><a href="#"><img src="img/slider/slide10.jpg"></a></li>
                        </ul>
                    </div>
                </div><!--End of slider box -->
                <div class="main_middle">
                	 <p>&nbsp;</p>
               <p>&nbsp;</p>
                    <i><center><p>Technology is nothing. </p>
                    <p>What's important is that you have a faith in people, </p>
                    <p>that they're basically good and smart, </p>
                   <p> and if you give them tools, </p>
                   <p> they'll do wonderful things with them.</p>
                    <p>-Steve Jobs-</p></center></i>
                </div><!--End of main middle -->
                <div class="main_bottom">
                	<h1>NEW PRODUCTS</h1>
                    <div class="product_container">
                    	<div class="products">
                        	<a href="iphone6.php">
                            	<img src="img/newp.jpg">
                                <span>Iphone 6</span>
                            	<span>Pret:620€</span>
                            </a>
                        </div>
                        <div class="products">
                        	<a href="iphone5.php">
                            	<img src="img/iph5.jpg">
                                <span>Iphone 5</span>
                            	<span>Pret:300€</span>
                            </a>
                        </div>
                        <div class="products">
                        	<a href="samsungS6E.php">
                            	<img src="img/samsgS6E.jpg">
                                <span>Samsung S6 Edge</span>
                            	<span>Pret:600€</span>
                            </a>
                        </div>
                        <div class="products">
                        	<a href="htcM8.php">
                            	<img src="img/htcM8.jpg">
                                <span>HTC One M8</span>
                            	<span>Pret:300€</span>
                            </a>
                        </div>
                    </div>
                </div><!--End of main bottom -->
            </div><!--End of main -->
        </div><!--End of main wrap -->
        <?php include_once('includes/footer.php')?>
    </body>
</html>