<?php
if(isset($_REQUEST['id'])) {
	$sys=$db->record('systems','*','id',$_REQUEST['id']);
		$pres=$db->select("select * from `system_parts` where `system_id`='".$_REQUEST['id']."'");
		while($parts=mysql_fetch_assoc($pres)) {
			$part_arr[$parts['part_title']]=$parts['part_desc'];
		}
	$edit=true;
}
?>
 <div style="width:600px;">
<div class="windowTitle">
<?php if($edit) { echo 'ویرایش سیستم'; } else { echo 'اضافه کردن سیستم'; } ?>
</div>
<form action="process.php" id="addsystem_form" method="post">
<input type="hidden" name="addsystem" value="1" />
<?php if($edit) { ?>
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<?php } ?>
<div class="window" >

<fieldset id="div_part1"><legend>اطلاعات اولیه</legend>
<table width="98%" border="0">
  <tr>
    <td width="22%" align="left">نام سیستم : </td>
    <td width="70%"><input class="textbox" value="<?php if($edit) echo $sys['name']; ?>" name="name" /></td>
	<td width="4%" align="left"></td>
	<td width="4%">	</td>
  </tr>       
</table>
</fieldset>

<fieldset style="display:none; text-align:right;" id="div_part2"><legend>تجهیزات </legend>
<strong>تجهیزات داخلی</strong><br />

<input type="checkbox" id="cpu" name="internal[]" value="cpu" <?php if($edit && $part_arr['cpu']!='') { echo 'checked="checked"'; } ?> />
<label for="cpu">CPU : </label>
<input type="text" name="cpu" class="textbox" value="<?php  if($edit) { echo $part_arr['cpu']; } ?>" /><br />

<input type="checkbox" id="motherboard" name="internal[]" value="motherboard" <?php if($edit && $part_arr['motherboard']!='') { echo 'checked="checked"'; } ?> />
<label for="motherboard">MotherBoard : </label>
<input type="text" name="motherboard" class="textbox" value="<?php  if($edit) { echo $part_arr['motherboard']; } ?>" /><br />

<input type="checkbox" id="ram" name="internal[]" value="ram" <?php if($edit && $part_arr['ram']!='') { echo 'checked="checked"'; } ?> />
<label for="ram">RAM : </label>
<input type="text" name="ram" class="textbox" value="<?php  if($edit) { echo $part_arr['ram']; } ?>" /><br />

<input type="checkbox" id="hdd" name="internal[]" value="hdd" <?php if($edit && $part_arr['hdd']!='') { echo 'checked="checked"'; } ?> />
<label for="hdd">HDD : </label>
<input type="text" name="hdd" class="textbox" value="<?php  if($edit) { echo $part_arr['hdd']; } ?>" /><br />

<input type="checkbox" id="vga" name="internal[]" value="vga" <?php if($edit && $part_arr['vga']!='') { echo 'checked="checked"'; } ?> />
<label for="vga">VGA : </label>
<input type="text" name="vga" class="textbox" value="<?php  if($edit) { echo $part_arr['vga']; } ?>" /><br />

<input type="checkbox" id="driver" name="internal[]" value="driver" <?php if($edit && $part_arr['driver']!='') { echo 'checked="checked"'; } ?> />
<label for="driver">Driver : </label>
<input type="text" name="driver" class="textbox" value="<?php  if($edit) { echo $part_arr['driver']; } ?>" /><br />

<input type="checkbox" id="power" name="internal[]" value="power" <?php if($edit && $part_arr['power']!='') { echo 'checked="checked"'; } ?> />
<label for="power">Power : </label>
<input type="text" name="power" class="textbox" value="<?php  if($edit) { echo $part_arr['power']; } ?>" /><br />

<input type="checkbox" id="card" name="internal[]" value="Card" <?php if($edit && $part_arr['card']!='') { echo 'checked="checked"'; } ?> />
<label for="card">Card : </label>
<input type="text" name="card" class="textbox" value="<?php  if($edit) { echo $part_arr['card']; } ?>" /><br />

<strong>تجهیزات خارجی</strong><br />

<input type="checkbox" id="printer" name="external[]" value="printer" <?php if($edit && $part_arr['printer']!='') { echo 'checked="checked"'; } ?> />
<label for="printer">Printer : </label>
<input type="text" name="printer" class="textbox" value="<?php  if($edit) { echo $part_arr['printer']; } ?>" /><br />

<input type="checkbox" id="scanner" name="external[]" value="scanner" <?php if($edit && $part_arr['scanner']!='') { echo 'checked="checked"'; } ?> />
<label for="scanner">Scanner : </label>
<input type="text" name="scanner" class="textbox" value="<?php  if($edit) { echo $part_arr['scanner']; } ?>" /><br />

<input type="checkbox" id="mouse" name="external[]" value="mouse" <?php if($edit && $part_arr['mouse']!='') { echo 'checked="checked"'; } ?> />
<label for="mouse">Mouse : </label>
<input type="text" name="mouse" class="textbox" value="<?php  if($edit) { echo $part_arr['mouse']; } ?>" /><br />

<input type="checkbox" id="keyboard" name="external[]" value="keyboard" <?php if($edit && $part_arr['keyboard']!='') { echo 'checked="checked"'; } ?> />
<label for="keyboard">Keyboard : </label>
<input type="text" name="keyboard" class="textbox" value="<?php  if($edit) { echo $part_arr['keyboard']; } ?>" /><br />

<input type="checkbox" id="lcd" name="external[]" value="lcd" <?php if($edit && $part_arr['lcd']!='') { echo 'checked="checked"'; } ?> />
<label for="lcd">LCD : </label>
<input type="text" name="lcd" class="textbox" value="<?php  if($edit) { echo $part_arr['lcd']; } ?>" /><br />
</fieldset>

<fieldset style="display:none; text-align:right;" id="div_part3"><legend>نرم افزار ها</legend>
<?php 
$soft_res=$db->select("select * from `software` where `status`!='deleted'"); 
while($software=mysql_fetch_assoc($soft_res)) {?>
<input type="checkbox" id="<?php echo $software['title']; ?>" name="software[]" value="<?php echo $software['title']; ?>" <?php if($edit && $part_arr[$software['title']]!='') { echo 'checked="checked"'; } ?> />
<label for="<?php echo $software['title']; ?>"><?php echo $software['title']; ?> : </label>
<input type="text" name="<?php echo $software['title']; ?>" class="textbox" value="<?php  if($edit) { echo $part_arr[$software['title']]; } ?>" /><br />
<?php } ?>
</fieldset>

<fieldset style="display:none; text-align:right;" id="div_part4"><legend>سوابق تعمیر</legend>
<?php
	$request_res=$db->select("select * from `requests` where `system_id`='".$_REQUEST['id']."' and `status`!='deleted'");
	while($request=mysql_fetch_assoc($request_res)) {
?>
<strong>تاریخ تعمیر : </strong><?php echo $request['report_date']; ?><br />
<strong>مشکل : </strong><?php echo $request['message']; ?><br />
<strong>گزارش تکنسین : </strong><?php echo $request['tech_report']; ?><br />
<hr />
<?php } ?>
</fieldset>

<div class="nav" align="right">
<div align="center" class="parts" id="part1">اطلاعات اولیه</div>
<div align="center" class="parts" id="part2">تجهیزات</div>
<div align="center" class="parts" id="part3">نرم افزار</div>
<div align="center" class="parts" id="part4">سوابق تعمیر</div>

<input type="button" value="ثبت اطلاعات" onclick="sub_form('addsystem_form')" style="float:left;" />
<input type="button" value="بازگشت" onclick="window.location='?page=systems'" style="float:left;" />

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