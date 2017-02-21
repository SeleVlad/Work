


<div class ="header_wrap">

    <div class = "header_top_wrap">
        <div class = "header_top">

			<form class="srcfrm" method="get" action="http://www.google.com/search">
	
    			<input type="text" name="q" size="25" maxlength="255" value="" placeholder="Search on Google" /> 
            	<input type="submit" value=" " />            
			</form>


            <ul class="header_top_menu">
                <li><a href="myAcc.php">My Account</a></li>
                <li><a href="wishlist.php">My Wishlist</a></li>
                <li><a href="view_cart.php">My Cart</a></li>
                
               
               <li>Welcome, <?php echo $_SESSION["sess_numeCont"] ?></a></li>
        		<li><a href = "logout.php">Log out</a></li>
            </ul>
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
                            	<li><a href="samsungS5.php">Galaxy S5</a></li>
                                <li><a href="samsungS6.php">Galaxy S6</a></li>
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