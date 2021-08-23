<?php
if(isset($_REQUEST['id'])) {
	$store=$db->record('storage','*','id',$_REQUEST['id']);
	$edit=true;
}
?>
 <div style="width:600px;">
<div class="windowTitle">
<?php if($edit) { echo 'ویرایش کالا'; } else { echo 'اضافه کردن مورد جدید'; } ?>
</div>
<form action="process.php" id="addstore_form" method="post">
<input type="hidden" name="addstore" value="1" />
<?php if($edit) { ?>
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<?php } ?>
<div class="window" >

<table width="98%" border="0">
  <tr>
	<td align="left">قطعه : </td>
	<td>
	<select name="title" class="textbox">
		<optgroup label="تجهیزات داخلی">
			<option value="cpu" <?php if($edit) { if($store['part_title']=='cpu') echo 'selected="selected"'; } ?>>CPU</option>
			<option value="motherboard" <?php if($edit) { if($store['part_title']=='motherboard') echo 'selected="selected"'; } ?>>Mother board</option>
			<option value="ram" <?php if($edit) { if($store['part_title']=='ram') echo 'selected="selected"'; } ?>>RAM</option>
			<option value="hdd" <?php if($edit) { if($store['part_title']=='hdd') echo 'selected="selected"'; } ?>>HDD</option>
			<option value="vga" <?php if($edit) { if($store['part_title']=='vga') echo 'selected="selected"'; } ?>>VGA</option>
			<option value="driver" <?php if($edit) { if($store['part_title']=='driver') echo 'selected="selected"'; } ?>>Driver</option>
			<option value="card" <?php if($edit) { if($store['part_title']=='card') echo 'selected="selected"'; } ?>>Card</option>
		</optgroup>
		<optgroup label="تجهیزات خارجی">
			<option value="keyboard" <?php if($edit) { if($store['part_title']=='keyboard') echo 'selected="selected"'; } ?>>Keyboard</option>
			<option value="mouse" <?php if($edit) { if($store['part_title']=='mouse') echo 'selected="selected"'; } ?>>Mouse</option>
			<option value="lcd" <?php if($edit) { if($store['part_title']=='keyboard') echo 'selected="selected"'; } ?>>LCD</option>
			<option value="printer" <?php if($edit) { if($store['part_title']=='printer') echo 'selected="selected"'; } ?>>Printer</option>
			<option value="scanner" <?php if($edit) { if($store['part_title']=='scanner') echo 'selected="selected"'; } ?>>Scanner</option>
		</optgroup>
	</select>	
	</td>
    <td align="left">شرح : </td>
    <td><input class="textbox" value="<?php if($edit) echo $store['part_desc']; ?>" name="desc" /></td>	
  </tr>
  <tr>
	<td align="left">نوع : </td>
	<td>
	<select name="part_type" class="textbox">
		<option value="1" <?php if($edit) { if($store['part_type']=='1') echo 'selected="selected"'; } ?>>تجهیزات داخلی</option>
		<option value="2" <?php if($edit) { if($store['part_type']=='2') echo 'selected="selected"'; } ?>>تجهیزات خارجی</option>
	</select>	
	</td>
    <td align="left">وضعیت : </td>
    <td>
	<select name="status" class="textbox">
		<option value="0" <?php if($edit) { if($store['status']=='0') echo 'selected="selected"'; } ?>>سالم</option>
		<option value="weak" <?php if($edit) { if($store['status']=='weak') echo 'selected="selected"'; } ?>>ضعیف</option>
		<option value="useable" <?php if($edit) { if($store['status']=='useable') echo 'selected="selected"'; } ?>>خراب: قابل تعمیر</option>
		<option value="outofuse" <?php if($edit) { if($store['status']=='outofuse') echo 'selected="selected"'; } ?>>خراب : اسقاطی</option>
	</select>		
	</td>	
  </tr>  
</table>


<div class="nav" align="right">

<input type="button" value="ثبت اطلاعات" onclick="sub_form('addstore_form')" style="float:left;" />
<input type="button" value="بازگشت" onclick="window.location='?page=storage'" style="float:left;" />

</div>
</div>  
</form>
</div>