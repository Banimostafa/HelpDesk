<?php 
include('../files/setting.php');

		$link= mysql_connect($setting['hostdb'],$setting['userdb'],$setting['passdb']);		mysql_select_db($setting['namedb'],$link);
		$ar_id=$_POST['ar_id'];
		$title=$_POST['title'];
		
		$query="UPDATE `archive` SET `title`='$title' WHERE `ar_id`='$ar_id'";
		mysql_query('SET NAMES "UTF8"');	$result= mysql_query($query, $link);
		
?>
