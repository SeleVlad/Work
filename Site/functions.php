<?php
	function filterdata($data){
		$data=mysql_real_escape_string($data);
		$data=strip_tags($data);
		return $data;	
	}
	function confirm_query($result){
		if(!$result){
				die('Database Query failed'.mysql_error());	
			}
	
	} 
?>