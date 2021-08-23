<?php
if(isset($_REQUEST['id'])) {
	$request=$db->record('requests','*','id',$_REQUEST['id']);
	$edit=true;
}
?>
 <div style="width:600px;">
<div class="windowTitle">
جزئیات درخواست
</div>
<form action="process.php" id="request_form" method="post">
<input type="hidden" name="requestdet" value="1" />
<?php if($edit) { ?>
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<?php } ?>
<div class="window" >

<fieldset style="text-align:right;" id="div_part1"><legend>جزئیات گزارش</legend>
<table width="98%" border="0">
  <tr>
    <td width="20%" align="left"><strong>کاربر : </strong></td>
	<?php $user=$db->record('users','*','id',$request['user_id']); ?>
    <td width="39%"><?php if($edit) echo $user['lname']; ?></td>
	<td width="20%" align="left"><strong>سیستم : </strong></td>
	<?php $sys=$db->record('systems','*','id',$request['system_id']); ?>
	<td width="21%"><?php if($edit) echo $sys['name']; ?></td>
  </tr>  
  <tr>
    <td align="left"><strong>عنوان : </strong></td>
    <td><?php if($edit) echo $request['title']; ?></td>
	<td align="left"><strong>تاریخ : </strong></td>
	<td><?php if($edit) echo $request['date']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>متن : </strong></td>
    <td colspan="3"><?php if($edit) echo $request['message']; ?></td>
  </tr>  
  <?php if($_SESSION['level']!='3') { ?>
  <tr>
	<td align="left"><strong>تکنسین : </strong></td>
	<td>
	<select name="tech_id" class="textbox">
		<option value="0"></option>
	<?php
		$user_res=$db->select("select * from `users` where (`level`='2' or `level`='1') and `status`!='deleted'");
		while($user=mysql_fetch_assoc($user_res)) {
	?>	
		<option value="<?php echo $user['id']; ?>" <?php if($edit) { if($user['level']==$request['tech_id']) echo 'selected="selected"'; } ?>><?php echo $user['fname'].' '.$user['lname']; ?></option>
	<?php } ?>
	</select>	
	</td>
    <td align="left"><strong>وضعیت : </strong></td>
    <td>
	<select name="status" class="textbox" style="width:auto;">
	  <option value="wait" <?php if($edit) { if($request['status']=='wait') echo 'selected="selected"'; } ?>>در انتظار تایید</option>
	  <option value="admin_do" <?php if($edit) { if($request['status']=='admin_do') echo 'selected="selected"'; } ?>>در دست انجام مدیر</option>
	  <option value="tech_do" <?php if($edit) { if($request['status']=='tech_do') echo 'selected="selected"'; } ?>>ارجاع به تکنسین</option>
	  <option value="done" <?php if($edit) { if($request['status']=='done') echo 'selected="selected"'; } ?>>انجام شده</option>
	</select>	
	</td>	
  </tr>   
  <?php } ?>         
</table>
</fieldset>

<fieldset style="display:none; text-align:right;" id="div_part2"><legend>گزارش تعمیر</legend>
<table width="98%" border="0">
  <tr>
    <td align="left" valign="top" width="20%"><strong>تاریخ گزارش : </strong></td>
    <td colspan="3"><?php if($edit) echo $request['report_date']; ?></td>
  </tr> 
  <tr>
    <td align="left" valign="top"><strong>متن گزارش : </strong></td>
    <td colspan="3"><?php if($edit) echo $request['tech_report']; ?></td>
  </tr> 
</table>
</fieldset>

<div class="nav" align="right">
<div align="center" class="parts" id="part1">جزئیات گزارش</div>
<div align="center" class="parts" id="part2">گزارش تعمیر</div>

<input type="button" value="ثبت اطلاعات" onclick="sub_form('request_form')" style="float:left;" />
<input type="button" value="بازگشت" onclick="window.location='?page=requests'" style="float:left;" />

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