<?php 
session_start();
if(!isset($_SESSION["store_validated_user"]))	Header('Location: login.php');

include('files/farsi_num.php');
include('files/date.class.php');
//db files
include('files/config.php');
include('files/dbu.class.php');

	$farsidate = new shamsidate;

	$db = new dbu();
	$db->setup($user,$pass,$database,$host);
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>صفحه اصلی</title>

<link rel='stylesheet' href='css/styles.css' type='text/css' />
<link rel='stylesheet' href='css/grid.css' type='text/css' />

<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="files/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="files/jquery-ui-1.8.21.custom.min.js"></script>
<script src="files/jquery_002.js" type="text/javascript"></script>
<script>
	$(function() {
		var availableTags = [
		<?php 
			$query="SELECT * FROM `people` WHERE `status`!='del' AND `group`='customer' ";
			$result=$db->select($query);
			while($customer=mysql_fetch_assoc($result)) {
				echo "'".$customer['name']."',";
			} ?>
		];
		$("#customer").autocomplete({
			source: availableTags,
			minLength: 2
		});	
	});
</script>

<script>
	$(function() {
		$( "input:submit, input:button" ).button();
		//$( "a", ".demo" ).click(function() { return false; });
	});
</script>

	 <script>
		var status='0';
		var str=window.location.hash;
		if(str!='') status=str.substring(1,str.length);
	 </script>
	 
	 <script>
	  function sub_form(id) {
	  	switch(id) {
			case 'order_form':
				$('#'+id).submit();
				break;
			default:
				$('#'+id).submit();
				break;
		}
	  }
	 </script>
	 
	<script>
		var direction=new Array();
	 </script>
	 
	 <script>
	  function sub_repair(part) {
	  	var flag=false;
		var sys_id=$('#system_id').val();
		var req_id=$('#request_id').val();
		var partid=$('#'+part+'_id').val();
		var status=$('#'+part+'_status').val();
		var storage=$('#'+part+'_storage').val();
		if(partid=='') {
			if(storage=='0') {
				alert('اطلاعات کامل نیست.');
			} else {
				flag=true;
			}
		} else {
			if(storage=='0') {
				if(status=='0') {
					alert('اطلاعات کامل نیست.');
				} else {
					flag=true;
				}
			} else {
				flag=true;
			}
		}
		if(flag) {
			window.location='process.php?repair=1&sys_id='+sys_id+'&partid='+partid+'&status='+status+'&storage='+storage;
		}
	  }
	 </script>	 
	 
	 <script src="files/sort_ajax.js"></script> 
	 <script src="files/load_sortRes.js"></script>	 
	 
	 <script src="files/pr_functions.js"></script>
	 
	 <script src="files/pr_page_load_ajax.js"></script>
	 <script src="files/pr_del_ajax.js"></script> 
	 <script>
		var command="loadPage('0');";
	 </script>
	 
	
	<script src="files/chart_load_ajax.js"></script>
	<script src="files/chart_del_ajax.js"></script> 
	
	<script src="files/system_load_ajax.js"></script>
	<script src="files/system_del_ajax.js"></script> 
	
	<script src="files/software_load_ajax.js"></script>
	<script src="files/software_del_ajax.js"></script> 
	
	<script src="files/pishgirane_load_ajax.js"></script>
	<script src="files/pishgirane_del_ajax.js"></script> 		
	
	<script src="files/request_load_ajax.js"></script>
	<script src="files/request_del_ajax.js"></script>
	
	<script src="files/contacts_load_ajax.js"></script>
	<script src="files/contacts_del_ajax.js"></script>	
	
	<script src="files/storage_load_ajax.js"></script>
	<script src="files/storage_del_ajax.js"></script>		 	
	
	 <script src="files/user_page_load_ajax.js"></script>
	 <script src="files/user_del_ajax.js"></script> 			
</head>


<body>
<div class="header">
<div style="float:right; width:200px; padding-right:10px; color:#FFF; direction:rtl;">
<small><?php echo $preName.' '.$_SESSION['name']; ?>، سلام !</small> 
</div>
<div style="float:left; width:80px;">
<a href="index.php?action=logout" style="color:#FFFFFF;"><small>خروج</small></a>
</div>

</div>
<div class="menu">
<?php $page=$_GET['page']; ?>
<?php if($_SESSION['level']=='1') { ?>
<div <?php if($page=='chart' || $page=='add_chart') echo 'class="active"'; ?>><a href="?page=chart">چارت سازمانی</a></div>
<div <?php if($page=='users' || $page=='add_user') echo 'class="active"'; ?>><a href="?page=users">کاربران</a></div>
<div <?php if($page=='software' || $page=='add_software') echo 'class="active"'; ?>><a href="?page=software">نرم افزارها</a></div>
<div <?php if($page=='systems' || $page=='add_system') echo 'class="active"'; ?>><a href="?page=systems">سیستم ها</a></div>
<div <?php if($page=='requests' || $page=='request_det') echo 'class="active"'; ?>><a href="?page=requests">درخواست ها</a></div>
<div <?php if($page=='repair') echo 'class="active"'; ?>><a href="?page=repair">تعمیر</a></div>
<div <?php if($page=='contacts') echo 'class="active"'; ?>><a href="?page=contacts">پیام ها</a></div>
<div <?php if($page=='storage' || $page=='add_storage') echo 'class="active"'; ?>><a href="?page=storage">انبار</a></div>
<div <?php if($page=='pishgirane' || $page=='add_pishgirane') echo 'class="active"'; ?>><a href="?page=pishgirane">پیشگیرانه</a></div>
<?php } ?>
<?php if($_SESSION['level']=='3') { ?>
<div <?php if($page=='requests' || $page=='add_requests') echo 'class="active"'; ?>><a href="?page=requests">درخواست ها</a></div>
<div <?php if($page=='contacts' || $page=='contacts') echo 'class="active"'; ?>><a href="?page=contacts">پیام</a></div>
<div <?php if($page=='profile') echo 'class="active"'; ?>><a href="?page=profile">تنظیمات</a></div>
<?php } ?>
<?php if($_SESSION['level']=='2') { ?>
<div <?php if($page=='repair') echo 'class="active"'; ?>><a href="?page=repair">تعمیر</a></div>
<div <?php if($page=='profile') echo 'class="active"'; ?>><a href="?page=profile">تنظیمات</a></div>
<?php } ?>

</div>
<div id="wrapper" align="center">
<div style="height:100px;"></div>

<?php 
if(isset($_REQUEST['msg'])) { 
	echo '<div class="message" style="width:400px;">';
	switch($_REQUEST['msg']) {
		case 'addtrue':
			echo 'مورد جدید با موفقیت ثبت شد.';
			break;
		case 'addfalse':
			echo 'متاسقانه مورد جدید ثبت نشد.';
			break;	
		case 'editfalse':
			echo 'متاسقانه ویرایش مورد نطر انجام نشد.';
			break;	
		case 'edittrue':
			echo 'ویرایش مورد نظر با موفقیت انجام شد.';
			break;									
	}	
	echo '</div>';
 } ?>

<?php
	if(isset($_GET['page']) && file_exists('part/'.$_GET['page'].'.php'))
		{
			include 'part/'.$_GET['page'].'.php';
		} else {
			echo 'صفحه مورد نظر یافت نشد.';
		} ?>
</div>

</body>
</html>