<?php
if(isset($_REQUEST['id'])) {
	$user=$db->record('users','*','id',$_REQUEST['id']);
	$edit=true;
}
?>
 <div style="width:600px;">
<div class="windowTitle">
<?php if($edit) { echo 'ویرایش اطلاعات'; } else { echo 'اضافه کردن مورد جدید'; } ?>
</div>
<form action="process.php" id="adduser_form" method="post">
<input type="hidden" name="adduser" value="1" />
<?php if($edit) { ?>
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<?php } ?>
<div class="window" >

<fieldset style="text-align:right;" id="div_part1"><legend>اطلاعات اولیه</legend>
<table width="98%" border="0">
  <tr>
    <td align="left">نام : </td>
    <td><input class="textbox" value="<?php if($edit) echo $user['fname']; ?>" name="fname" /></td>
	<td align="left">نام خانوادگی : </td>
	<td><input class="textbox" value="<?php if($edit) echo $user['lname']; ?>" name="lname" /></td>
  </tr>  
  <tr>
    <td align="left">نام کاربری : </td>
    <td><input class="textbox" value="<?php if($edit) echo $user['username']; ?>" name="username" /></td>
	<td align="left">رمز عبور : </td>
	<td><input class="textbox" value="<?php if($edit) echo $user['password']; ?>" name="password" /></td>
  </tr>
  <tr>
	<td align="left">سطح : </td>
	<td>
	<select name="level" class="textbox">
		<option value="1" <?php if($edit) { if($user['level']=='1') echo 'selected="selected"'; } ?>>مدیر سیستم</option>
		<option value="2" <?php if($edit) { if($user['level']=='2') echo 'selected="selected"'; } ?>>تکنسین</option>
		<option value="3" <?php if($edit) { if($user['level']=='3') echo 'selected="selected"'; } ?>>کاربر</option>
	</select>	
	</td>
    <td align="left">سمت : </td>
    <td>
	<select name="title" class="textbox" style="width:auto;">
	<?php
		$gres=$db->select("select * from `chart_item` where `up_level_id`='0' and `status`!='deleted'");
		while($group=mysql_fetch_assoc($gres)) {
			$tres=$db->select("select * from `chart_item` where `up_level_id`='".$group['id']."' and `status`!='deleted'");
			$title=mysql_fetch_assoc($tres);
	?>
		<option value="<?php echo $title['id']; ?>" <?php if($edit) { if($user['title_id']==$title['id']) echo 'selected="selected"'; } ?>><?php echo $group['title'].'&nbsp;&raquo;&nbsp;'.$title['title']; ?></option>
	<?php } ?>
	</select>	
	</td>	
  </tr>
  </tr>             
</table>
</fieldset>

<fieldset style="display:none; text-align:right;" id="div_part2"><legend>سیستم ها</legend>
<?php 
	$user_sys=explode(',',$user['system_id']);
	$sys_res=$db->select("select * from `systems` where `status`!='deleted'");
	while($system=mysql_fetch_assoc($sys_res)) {
?>
<div style="width:150px; float:right">
	<input type="checkbox" id="sys<?php echo $system['id']; ?>" name="systems[]" value="<?php echo $system['id']; ?>" <?php if($edit && (in_array($system['id'],$user_sys))) { echo 'checked="checked"'; } ?> /><label for="sys<?php echo $system['id']; ?>"><?php echo $system['name']; ?></label>
</div>
<?php } ?>
</fieldset>

<fieldset style="display:none; text-align:right;" id="div_part3"><legend>درخواست ها</legend>
<?php
	$request_res=$db->select("select * from `requests` where `user_id`='".$_REQUEST['id']."' and `status`!='deleted'");
	while($request=mysql_fetch_assoc($request_res)) {
?>
<strong>تاریخ درخواست : </strong><?php echo $request['date']; ?><br />
<strong>درخواست : </strong><?php echo $request['message']; ?><br />
<hr />
<?php } ?>
</fieldset>

<div class="nav" align="right">
<div align="center" class="parts" id="part1">اطلاعات اولیه</div>
<div align="center" class="parts" id="part2">سیستم ها</div>
<div align="center" class="parts" id="part3">درخواست ها</div>

<input type="button" value="ثبت اطلاعات" onclick="sub_form('adduser_form')" style="float:left;" />
<input type="button" value="بازگشت" onclick="window.location='?page=users'" style="float:left;" />

<script>
$(".parts").click(function(){
	$('fieldset').css("display", "none");
	$('#div_'+this.id).fadeIn("fast");
});
</script>
</div>
</div>  
</form>
</div>