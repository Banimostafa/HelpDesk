<?php 
include('config.php');
include('dbu.class.php');

	$db = new dbu();
	$db->setup($user,$pass,$database,$host);

		$del_items_id=$_POST['items'];
				
		$query="UPDATE `software` SET `status`='deleted' WHERE `id` IN (".$del_items_id.") ";
		$db->select($query);

?>