<?php
	$user=$db->record('users','*','id',$_SESSION['uid']);
	$edit=true;
?>
 <div style="width:600px;">
<div class="windowTitle">
ویرایش اطلاعات
</div>
<form action="process.php" id="profile_form" method="post">
<input type="hidden" name="editpass" value="1" />
<?php if($edit) { ?>
<input type="hidden" name="id" value="<?php echo $_SESSION['uid']; ?>" />
<?php } ?>
<div class="window" >

<fieldset style="text-align:right;" id="div_part1"><legend>اطلاعات اولیه</legend>
<table width="98%" border="0">
  <tr>
    <td align="left">نام : </td>
    <td><?php if($edit) echo $user['fname']; ?></td>
	<td align="left">نام خانوادگی : </td>
	<td><?php if($edit) echo $user['lname']; ?></td>
  </tr>  
  <tr>
    <td align="left">نام کاربری : </td>
    <td><?php if($edit) echo $user['username']; ?></td>
	<td align="left">رمز عبور : </td>
	<td><input class="textbox" value="<?php if($edit) echo $user['password']; ?>" name="password" /></td>
  </tr>
  <tr>
	<td align="left">سطح : </td>
	<td><?php if($edit) { if($user['level']=='2') echo 'تکنسین'; } ?>
		<?php if($edit) { if($user['level']=='3') echo 'کاربر'; } ?>	
	</td>
    <td align="left">سمت : </td>
    <td>
	<?php
		$gres=$db->select("select * from `chart_item` where `up_level_id`='0' and `status`!='deleted'");
		while($group=mysql_fetch_assoc($gres)) {
			$tres=$db->select("select * from `chart_item` where `up_level_id`='".$group['id']."' and `status`!='deleted'");
			$title=mysql_fetch_assoc($tres);
	?>
		<?php if($edit) { if($user['title_id']==$title['id']) echo $group['title'].'&nbsp;&raquo;&nbsp;'.$title['title']; } ?>
	<?php } ?>
	</td>	
  </tr>
  </tr>             
</table>
</fieldset>


<div class="nav" align="right">

<input type="button" value="ویرایش اطلاعات" onclick="sub_form('profile_form')" style="float:left;" />

</div>
</div>  
</form>
</div>