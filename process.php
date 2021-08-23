<?php
session_start();
if(!isset($_SESSION["store_validated_user"]))	Header('Location: login.php');

include('files/date.class.php');
include('files/farsi_num.php');
//db files
include('files/config.php');
include('files/dbu.class.php');

	$db = new dbu();
	$db->setup($user,$pass,$database,$host);

	$farsidate = new shamsidate;

function removemessages($link){
	$res = str_replace("deltrue","",$link);
	$res = str_replace("delfalse","",$res);
	$res = str_replace("addtrue","",$res);
	$res = str_replace("addfalse","",$res);
	$res = str_replace("edittrue","",$res);
	$res = str_replace("editfalse","",$res);
	$res = str_replace("&msg=","",$res);
	return $res;
}

$ref= removemessages($_SERVER['HTTP_REFERER']);
$msg= '';
//---------------------------------------------------------------------------
//process admin forms

if(isset($_REQUEST['addsystem'])) {

	if(!isset($_REQUEST['id'])) {
		$system_id = $db->insert("systems","name,status","'".$_POST['name']."','active'");					
	} else {
		$update="`name`='".$_POST['name']."'";
		$res=$db->update('products',$update,'id',$_REQUEST['id']);	
		$system_id=$_REQUEST['id'];
	}
		$db->del("system_parts",'system_id',$system_id);
			//add internal
		if (is_array($_POST['internal']))
			foreach($_POST['internal'] as $internal) {
				$res = $db->insert("system_parts","system_id,part_type,part_title,part_desc","'".$system_id."','1','".$internal."','".$_POST[$internal]."'");
			}
		else
			$res = $db->insert("system_parts","system_id,part_type,part_title,part_desc","'".$system_id."','1','".$_POST['internal']."','".$_POST[$_POST['internal']]."'");
			
			//add external
		if (is_array($_POST['external']))
			foreach($_POST['external'] as $external) {
				$res = $db->insert("system_parts","system_id,part_type,part_title,part_desc","'".$system_id."','2','".$external."','".$_POST[$external]."'");
			}
		else
			$res = $db->insert("system_parts","system_id,part_type,part_title,part_desc","'".$system_id."','2','".$_POST['external']."','".$_POST[$_POST['external']]."'");		
			
			//add software
		if (is_array($_POST['software']))
			foreach($_POST['software'] as $software) {
				$res = $db->insert("system_parts","system_id,part_type,part_title,part_desc","'".$system_id."','3','".$software."','".$_POST[$software]."'");
			}
		else
			$res = $db->insert("system_parts","system_id,part_type,part_title,part_desc","'".$system_id."','3','".$_POST['software']."','".$_POST[$_POST['software']]."'");		
			
		if ($res > 0)
			$msg = '&msg=addtrue';
		else
			$msg = '&msg=addfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Add Software
if(isset($_REQUEST['addsoftware'])) {

	if(!isset($_REQUEST['id'])) {
		$res = $db->insert("software","title,status","'".$_POST['name']."','active'");					
	} else {
		$update="`title`='".$_POST['title']."'";
		$res=$db->update('software',$update,'id',$_REQUEST['id']);	
	}
	
	if ($res > 0)
		$msg = '&msg=addtrue';
	else
		$msg = '&msg=addfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Change request status
if(isset($_REQUEST['request_statusdet'])) {

	$update="`status`='".$_POST['status']."'";
	$res=$db->update('requests',$update,'id',$_REQUEST['id']);	
	
	if ($res > 0)
		$msg = '&msg=edittrue';
	else
		$msg = '&msg=editfalse';			
}


///////////////////////////////////////////////////////////////////////////////////// Sub request report
if(isset($_REQUEST['tech_report'])) {

	$update="`tech_report`='".$_POST['report']."'";
	$res=$db->update('requests',$update,'id',$_REQUEST['id']);	
	
	if ($res > 0)
		$msg = '&msg=edittrue';
	else
		$msg = '&msg=editfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Setup Software
if(isset($_REQUEST['setup_software'])) {

	$res=$db->insert('system_parts',"`system_id`,`part_type`,`part_title`,`part_desc`,`setup_date`","'".$_REQUEST['system_id']."','3','".$_REQUEST['part_title']."','".$_REQUEST['part_dest']."','".date('Y-m-d')."'");	
	
	if ($res > 0)
		$msg = '&msg=edittrue';
	else
		$msg = '&msg=editfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Del Software
if($_REQUEST['action']=='delsoft') {

	$update="`status`='deleted'";
	$res=$db->update('system_parts',$update,'id',$_REQUEST['softid']);	
	
	if ($res > 0)
		$msg = '&msg=edittrue';
	else
		$msg = '&msg=editfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Repairation
if(isset($_REQUEST['repair'])) {
	
	if($_REQUEST['partid']=='') {
		if($_REQUEST['storage']=='0') {
			$res=0;
		} else {
			//delete from storage
			$update="`status`='deleted'";
			$res=$db->update('storage',$update,'id',$_REQUEST['storage']);
			//add to system parts
			$part_sys=$db->record('storage','*','id',$_REQUEST['storage']);
			$res = $db->insert("system_parts","system_id,part_type,part_title,part_desc,setup_date","'".$_REQUEST['sys_id']."','".$part_sys['part_type']."','".$part_sys['part_title']."','".$part_sys['part_desc']."','".date('Y-m-d')."'");	
		}
	} else {
		if($_REQUEST['storage']=='0') {
			if($_REQUEST['storage']=='0') {
				$res=0;
			} else {
				$update="`status`='".$_REQUEST['storage']."'";
				$res=$db->update('storage',$update,'id',$_REQUEST['storage']);				
			}
		} else {
			//add to storage
			$sys_part=$db->record('system_parts','*','id',$_REQUEST['partid']);
			$res = $db->insert("storage","part_type,part_title,part_desc,date,status","'".$sys_part['part_type']."','".$sys_part['part_title']."','".$sys_part['part_desc']."','".date('Y-m-d')."','".$_REQUEST['status']."'");	
			//delete from storage
			$update="`status`='deleted'";
			$res=$db->update('storage',$update,'id',$_REQUEST['storage']);
			//delete from system part
			$update="`status`='deleted'";
			$res=$db->update('system_parts',$update,'id',$_REQUEST['partid']);			
			//add to system parts
			$part_sys=$db->record('storage','*','id',$_REQUEST['storage']);
			$res = $db->insert("system_parts","system_id,part_type,part_title,part_desc,setup_date","'".$_REQUEST['sys_id']."','".$part_sys['part_type']."','".$part_sys['part_title']."','".$part_sys['part_desc']."','".date('Y-m-d')."'");				
		}
	}
	
	if ($res > 0)
		$msg = '&msg=edittrue';
	else
		$msg = '&msg=editfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Add into Storage
if(isset($_REQUEST['addstore'])) {
	if(!isset($_REQUEST['id'])) {
		$res = $db->insert("storage","part_title,part_desc,part_type,date,status","'".$_POST['title']."','".$_POST['desc']."','".$_POST['part_type']."','".date('Y-m-d')."','".$_POST['status']."'");					
	} else {
		$update="`part_title`='".$_POST['title']."',`part_desc`='".$_POST['desc']."',`part_type`='".$_POST['part_type']."',`status`='".$_POST['status']."'";
		$res=$db->update('storage',$update,'id',$_REQUEST['id']);	
	}
	if ($res > 0)
		$msg = '&msg=addtrue';
	else
		$msg = '&msg=addfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Add Request
if(isset($_REQUEST['addrequest'])) {

	$res = $db->insert("requests","title,user_id,system_id,message,date","'".$_POST['title']."','".$_SESSION['uid']."','".$_POST['system_id']."','".$_POST['desc']."','".date('Y-m-d')."'");					
		
	if ($res > 0)
		$msg = '&msg=addtrue';
	else
		$msg = '&msg=addfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Add Contact
if(isset($_REQUEST['addcontact'])) {

	$res = $db->insert("admin_contact","user_id,message,date","'".$_SESSION['uid']."','".$_POST['desc']."','".date('Y-m-d')."'");					
	$page_url='main.php?page=contacts';
	if ($res > 0)
		$msg = '&msg=addtrue';
	else
		$msg = '&msg=addfalse';			
}
///////////////////////////////////////////////////////////////////////////////////// Add Pishgirane Act
if(isset($_REQUEST['addpishgiri'])) {
	if(!isset($_REQUEST['id'])) {
		$res = $db->insert("pishgirane_act","act_title,act_desc,date","'".$_POST['title']."','".$_POST['desc']."','".date('Y-m-d')."'");					
	} else {
		$update="`act_title`='".$_POST['title']."',`act_desc`='".$_POST['desc']."'";
		$res=$db->update('pishgirane_act',$update,'id',$_REQUEST['id']);	
	}
	if ($res > 0)
		$msg = '&msg=addtrue';
	else
		$msg = '&msg=addfalse';			
}


///////////////////////////////////////////////////////////////////////////////////// Edit Request status
if(isset($_REQUEST['requestdet'])) {
	if(isset($_REQUEST['id'])) {
		$update="`tech_id`='".$_POST['tech_id']."',`status`='".$_POST['status']."'";
		$res=$db->update('requests',$update,'id',$_REQUEST['id']);	
	}
	if ($res > 0)
		$msg = '&msg=edittrue';
	else
		$msg = '&msg=editfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Edit Password
if(isset($_REQUEST['editpass'])) {

		$update="`password`='".$_POST['password']."'";
		$res=$db->update('users',$update,'id',$_REQUEST['id']);	

	if ($res > 0)
		$msg = '&msg=edittrue';
	else
		$msg = '&msg=editfalse';			
}

///////////////////////////////////////////////////////////////////////////////////// Add chart item
if(isset($_REQUEST['addchart'])) {
	
	if(!isset($_REQUEST['id'])) {
		$res = $db->insert("chart_item","title,up_level_id,status","'".$_POST['title']."','".$_POST['up_level_id']."','active'");
		if ($res > 0)
			$msg = '&msg=addtrue';
		else
			$msg = '&msg=addfalse';
	} else {
		$update="`title`='".$_POST['title']."',`up_level_id`='".$_POST['up_level_id']."'";
		$res=$db->update('chart_item',$update,'id',$_REQUEST['id']);
		if ($res > 0)
			$msg = '&msg=edittrue';
		else
			$msg = '&msg=editfalse';	
	}
}


///////////////////////////////////////////////////////////////////////////////////// Add User
if(isset($_REQUEST['adduser'])) {

	if (is_array($_POST['systems']))
		$system_id=implode(',',$_POST['systems']);
	else
		$system_id=$_POST['systems'];
		
	if(!isset($_REQUEST['id'])) {
		$res = $db->insert("users","fname,lname,username,password,title_id,system_id,level","'".$_POST['fname']."','".$_POST['lname']."','".$_POST['username']."','".$_POST['password']."','".$_POST['title']."','".$system_id."','".$_POST['level']."'");
		$page_url='main.php?page=users';
		if ($res > 0)
			$msg = '&msg=addtrue';
		else
			$msg = '&msg=addfalse';
	} else {
		$update="`fname`='".$_POST['fname']."',`lname`='".$_POST['lname']."',`username`='".$_POST['username']."',`password`='".$_POST['password']."',`title_id`='".$_POST['title']."',`system_id`='".$system_id."',`level`='".$_POST['level']."'";
		$res=$db->update('users',$update,'id',$_REQUEST['id']);
		if ($res > 0)
			$msg = '&msg=edittrue';
		else
			$msg = '&msg=editfalse';	
	}
}

///////////////////////////////////////////////////////////////////////////////////// Edit User
if(isset($_REQUEST['edituser'])) {
		$update="`us_name`='".$_POST['us_name']."',`us_pass`='".$_POST['us_pass']."',`fname`='".$_POST['fname']."',`lname`='".$_POST['lname']."'";
		$res=$db->update('users',$update,'uid',$_SESSION['id']);
		if ($res > 0)
			$msg = '&msg=edittrue';
		else
			$msg = '&msg=editfalse';	
}

//-------------------------------------------------------------------------------
if ($page_url<>'')
	$ref=$page_url;
if ($msg<>'')
	header("Location: $ref".$msg);
else
	header("Location: $ref");
?>