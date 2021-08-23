<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>سامانه ثبت و پیگیری درخواست های Helpdesk</title>

		<link rel='stylesheet' href='css/styles.css' type='text/css' />
		<link rel='stylesheet' href='css/grid.css' type='text/css' />
		
		<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="files/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="files/jquery-ui-1.8.21.custom.min.js"></script>
		<script>
			$(function() {
				$( "input:submit, input:button" ).button();
				//$( "a", ".demo" ).click(function() { return false; });
			});
		</script>

</head>

<body>
<div id="wrapper" align="center">
<div style="height:100px;"></div>

<?php if($_REQUEST['action']=='wronglog') echo '<div class="message" style="width:300px;">نام کاربری یا رمز عبور اشتباه است </div><br />'; ?>
<?php //if($_REQUEST['action']=='wrongconfirm') echo '<div class="message" style="width:300px;">کد احراز هویت صحیح نیست.</div><br />'; ?>
<?php if($_REQUEST['action']=='logout') echo '<div class="message" style="width:300px;">شما با موفقیت خارج شدید </div><br />'; ?>
<?php //if($_REQUEST['action']=='confirmlogin') echo '<div class="message" style="width:300px;">کد احراز هویت برای شما یامک شد..</div><br />'; ?>
<div  style="width:300px; color:">
<div class="windowTitle">
سامانه ثبت و پیگیری درخواست های Helpdesk
</div>
<div class="window" >
<form action="index.php" method="post" id="form1">
<table width="100%" border="0">
  <tr align="right">
    <td width="20%"><label for="us_name">نام کاربری</label></td>
    <td width="80%">
		<input type="text" class="textbox" id="us_name" name="us_name" />
    </td>
  </tr>
  <tr align="right">
    <td ><label for="us_pass">رمز عبور</label></td>
    <td >
		<input type="password" class="textbox" id="us_pass" name="us_pass" />
    </td>
  </tr>
  <tr align="left">
    <td>&nbsp;</td>
    <td>
    <input type="submit" class="button" value="ورود" />
    </td>
  </tr>
</table>
</form>
</div>
</div>

</div>
</body>
</html>