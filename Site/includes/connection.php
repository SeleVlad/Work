<?php

	//1.Establishing the Connection to MySQL
	$conn = mysql_connect('localhost','root','');
	confirm_query($conn);
	
	//2.Select mySQL DB
	$db_select = mysql_select_db('proiect');
	confirm_query($db_select);
?>