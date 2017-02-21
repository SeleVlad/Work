<?php 

	//Start session
	session_start();
 
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['sess_numeCont']) || (trim($_SESSION['sess_numeCont']) == '')) {
		header("location: login.php");
		exit();
		
		
	}
	
	

//if(isset($_POST['search'])){
	//$searchq = $_POST['search'];
	
	//$query = mysql_query("SELECT * FROM 'model' WHERE numeModel LIKE '%$searchq%' ") or die("could not search");
	
//}
 

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
    	<?php include_once('includes/header.php')?>
        
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
                            	<span>Pret:560€</span>
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
                            	<span>Pret:520€</span>
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