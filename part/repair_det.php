<?php
if(isset($_REQUEST['id'])) {
	$request=$db->record('requests','*','id',$_REQUEST['id']);
	$edit=true;
}
?>
 <div style="width:600px;">
<div class="windowTitle">
تعمیر سیستم
</div>

<div class="window" >

<fieldset style="text-align:right;" id="div_part1"><legend>جزئیات گزارش</legend>
<form action="process.php" id="request_status_form" method="post">
<input type="hidden" name="request_statusdet" value="1" />
<?php if($edit) { ?>
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<?php } ?>
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
  <tr>
    <td align="left"><strong>وضعیت : </strong></td>
    <td>
	<select name="status" class="textbox" style="width:auto;">
	  <option value="wait" <?php if($edit) { if($request['status']=='wait') echo 'selected="selected"'; } ?>>در انتظار تایید</option>
	  <option value="admin_do" <?php if($edit) { if($request['status']=='admin_do') echo 'selected="selected"'; } ?>>در دست انجام مدیر</option>
	  <option value="tech_do" <?php if($edit) { if($request['status']=='tech_do') echo 'selected="selected"'; } ?>>ارجاع به تکنسین</option>
	  <option value="done" <?php if($edit) { if($request['status']=='done') echo 'selected="selected"'; } ?>>انجام شده</option>
	</select>	
	</td>	
	<td align="left"></td>
	<td><input type="button" value="ثبت اطلاعات" onclick="sub_form('request_status_form')" style="float:left;" /></td>	
  </tr>            
</table>
</form>
</fieldset>

<fieldset style="display:none; text-align:right;" id="div_part2"><legend>تعمیر تجهیزات</legend>
<input type="hidden" id="system_id" value="<?php echo $sys['id']; ?>" />
<input type="hidden" id="request_id" value="<?php echo $request['id']; ?>" />
<table width="98%" border="0">
  <tr>
    <td align="right" valign="top" colspan="5"><strong>تجهیزات داخلی </strong></td>
  </tr>
  <tr style="font-weight:bold;" align="center">
  	<td></td>
	<td>شرح</td>
	<td>وضعیت</td>
	<td>معاوضه با</td>
	<td></td>
  </tr>
  	<?php
		$part_status='<option value="0"></option> <option value="weak">ضعیف</option> <option value="useable">خراب : قابل تعمیر</option> <option value="outofuse">خراب : اسقاطی</option>';
		$parts_array=array( 'cpu'=>'CPU', 'motherboard'=>'MotherBoard', 'ram'=>'RAM', 'hdd'=>'HDD', 'vga'=>'VGA', 'power'=>'Power', 'driver'=>'Driver', 'card'=>'Card');

		foreach($parts_array as $part => $title) {
	?>
  <tr>
    <td align="left" valign="top" width="20%"><strong><?php echo $title; ?> : </strong></td>
	<?php
		$sys_part_res=$db->select("select * from `system_parts` where `system_id`='".$sys['id']."' and `part_title`='".$part."' and `status`!='deleted'");
		$sys_part=mysql_fetch_assoc($sys_part_res);
	?>
    <td align="center" valign="top" width="20%">
		<input id="<?php echo $part; ?>_id" value="<?php echo $sys_part['id']; ?>" type="hidden" />
		<?php echo $sys_part['part_desc']; ?>
	</td>
	<td align="center" valign="top" width="20%">
	<select id="<?php echo $part; ?>_status" class="textbox" style="width:auto;">
		<?php echo $part_status; ?>
	</select>
	</td>
	<td align="center" valign="top" width="30%">
	<select id="<?php echo $part; ?>_storage" class="textbox">
		<option value="0"></option>
	<?php 
		$part_res=$db->select("select * from `storage` where `part_title`='".$part."' and (`status`='0' or `status`='weak')");
		while($store_part=mysql_fetch_assoc($part_res)) {
	?>
	  <option value="<?php echo $store_part['id']; ?>"><?php echo $store_part['part_desc']; ?></option>
	<?php } ?>
	</select>	
	</td>
	<td align="left" valign="top" width="10%"><input type="button" value="ثبت" onclick="sub_repair('<?php echo $part; ?>')" /></td>
  </tr>
    <?php } ?>
  <tr>
    <td align="right" valign="top" colspan="5"><strong>تجهیزات خارجی </strong></td>
  </tr>	
  	<?php
		$parts_array=array( 'printer'=>'Printer', 'scanner'=>'Scanner', 'mouse'=>'Mouse', 'keyboard'=>'Keyboard', 'lcd'=>'LCD');

		foreach($parts_array as $part => $title) {
	?>
  <tr>
    <td align="left" valign="top" width="20%"><strong><?php echo $title; ?> : </strong></td>
	<?php
		$sys_part_res=$db->select("select * from `system_parts` where `system_id`='".$sys['id']."' and `part_title`='".$part."' and `status`!='deleted'");
		$sys_part=mysql_fetch_assoc($sys_part_res);
	?>
    <td align="center" valign="top" width="20%">
		<input id="<?php echo $part; ?>_id" value="<?php echo $sys_part['id']; ?>" type="hidden" />
		<?php echo $sys_part['part_desc']; ?>	
	</td>
	<td align="center" valign="top" width="20%">
	<select id="<?php echo $part; ?>_status" class="textbox" style="width:auto;">
		<?php echo $part_status; ?>
	</select>
	</td>
	<td align="center" valign="top" width="30%">
	<select id="<?php echo $part; ?>_storage" class="textbox">
		<option value="0"></option>
	<?php 
		$part_res=$db->select("select * from `storage` where `part_title`='".$part."' and (`status`='0' or `status`='weak')");
		while($store_part=mysql_fetch_assoc($part_res)) {
	?>
	  <option value="<?php echo $store_part['id']; ?>"><?php echo $store_part['part_desc']; ?></option>
	<?php } ?>
	</select>	
	</td>
	<td align="left" valign="top" width="10%">
	<input type="button" value="ثبت" onclick="sub_repair('<?php echo $part; ?>')" />
	</td>
  </tr>
    <?php } ?>  
</table>

</fieldset>

<fieldset style="display:none; text-align:right;" id="div_part3"><legend>نصب نرم افزار</legend>
	<table width="98%" border="0">
	<?php 
		$soft_res=$db->select("select * from `system_parts` where `system_id`='".$sys['id']."' and `part_type`='3' and `status`!='deleted'");
		while($soft_part=mysql_fetch_assoc($soft_res)) {
	?>	
		<tr>
			<td align="left"><strong><?php echo $soft_part['part_title']; ?></strong> : </td>
			<td><?php echo $soft_part['part_desc']; ?></td>
			<td><input type="button" value="حذف" onclick="window.location='process.php?softid=<?php echo $soft_part['id']; ?>&action=delsoft'" /></td>
		</tr>
	<?php } ?>
	</table>
	<form action="process.php" id="setup_software" method="post">
	<input type="hidden" name="system_id" value="<?php echo $sys['id']; ?>" />
	<input type="hidden" name="setup_software" value="1" />
	<table width="98%" border="0">
		<tr>
			<td colspan="3" align="right" style="border-top:1px dashed #000;"><strong>نصب نرم افزار جدید</strong></td>
		</tr>
		<tr>
			<td align="right">
			نرم افزار : 
			<select name="part_title" class="textbox">
			<?php 
			$soft_res=$db->select("select * from `software` where `status`!='deleted'"); 
			while($software=mysql_fetch_assoc($soft_res)) {
			?>			
				<option value="<?php echo $software['title']; ?>"><?php echo $software['title']; ?></option>
			<?php } ?>
			</select>
			</td>
			<td> ورژن : <input type="text" name="part_dest" class="textbox" /></td>
			<td><input type="button" value="نصب" onclick="sub_form('setup_software')" /></td>
		</tr>	
	</table>
	</form>
</fieldset>

<fieldset style="display:none; text-align:right;" id="div_part4"><legend>گزارش تعمیر</legend>
<form action="process.php" id="report_form" method="post">
<input type="hidden" name="tech_report" value="1" />
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<table width="98%" border="0">
  <tr>
    <td align="left" valign="top"><strong>متن گزارش : </strong></td>
    <td colspan="3">
	<textarea name="report" class="textbox" style="width:300px;"><?php if($edit) echo $request['tech_report']; ?></textarea>
	</td>
  </tr> 
  <tr>
    <td></td>
    <td colspan="3" align="right"><input type="button" value="ثبت اطلاعات" onclick="sub_form('report_form')" /></td>
  </tr>   
</table>
</form>
</fieldset>

<div class="nav" align="right">
<div align="center" class="parts" id="part1">جزئیات گزارش</div>
<div align="center" class="parts" id="part2">تعمیر تجهیزات</div>
<div align="center" class="parts" id="part3">نصب نرم افزار</div>
<div align="center" class="parts" id="part4">گزارش تعمیر</div>
	<input type="button" value="بازگشت" onclick="window.location='?page=repair'" style="float:left;" />
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