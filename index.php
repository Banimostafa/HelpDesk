<?php
session_start();
if(isset($_SESSION["store_validated_user"]))	Header('Location: main.php');

include('files/config.php');
include('files/dbu.class.php');

	$db = new dbu();
	$db->setup($user,$pass,$database,$host);

	if ((isset($_REQUEST['action']) ) &&($_REQUEST['action']=='logout') )	{	
	
		session_destroy();		
		Header('Location: login.php?action=logout');	
		
	} else if ( isset($_REQUEST['us_name']) && isset($_REQUEST['us_pass']) ) {
	
		$us_pass=$_REQUEST['us_pass'];
		$us_name=$_REQUEST['us_name'];
		$query= "SELECT *  FROM `users` WHERE `username`='$us_name' AND `password`='$us_pass' ";
		$result=$db->select($query);
		if (mysql_num_rows($result) >0){
			$row = mysql_fetch_assoc($result) ;
			
			 $_SESSION['store_validated_user'] =$us_name.rand();
			 $_SESSION['uid']=$row['id'];
			 $_SESSION['name']=$row['fname'].' '.$row['lname'];
			 $_SESSION['level']=$row['level'];
			 if($row['level']==1) {
			  Header('Location: main.php?page=chart');
			 } elseif($row['level']==2){
			  Header('Location: main.php?page=repair');
			 } elseif($row['level']==3){
			  Header('Location: main.php?page=requests');
			 }

		} else { Header('Location: login.php?action=wronglog');

				}
	}  else { Header('Location: login.php'); }

?>