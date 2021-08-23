<?php
	$user=$db->record('users','*','id',$_REQUEST['id']);
?>
 <div style="width:600px;">
<div class="windowTitle">
ثبت درخواست
</div>
<form action="process.php" id="addreq_form" method="post">
<input type="hidden" name="addrequest" value="1" />
<input type="hidden" name="user_id" value="<?php echo $user['id']; ?>" />

<div class="window" >


<table width="98%" border="0">
<tr>
    <td width="22%" align="left">عنوان درخواست : </td>
    <td width="70%"><input class="textbox" name="title" /></td>
</tr>
<tr>
    <td width="22%" align="left">سیستم : </td>
    <td width="70%">
	<select name="system_id" class="textbox" style="width:auto;">
<?php 
	$sys_res=$db->select("select * from `systems` where `status`!='deleted' and `id` in (".$user['system_id'].")");
	while($system=mysql_fetch_assoc($sys_res)) {
?>	
	<option value="<?php echo $system['id']; ?>"><?php echo $system['name']; ?></option>
	<?php } ?>
	</select>
	</td>
</tr>
<tr>
	<td width="4%" align="left" valign="top">متن درخواست : </td>
	<td width="4%"><textarea name="desc" class="textbox" style="width:300px;"></textarea></td>
  </tr>       
</table>

<div class="nav" align="right">

<input type="button" value="ثبت اطلاعات" onclick="sub_form('addreq_form')" style="float:left;" />
<input type="button" value="بازگشت" onclick="window.location='?page=requests'" style="float:left;" />

</div>
</div>  
</form>
</div>