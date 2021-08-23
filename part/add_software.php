<?php
if(isset($_REQUEST['id'])) {
	$soft=$db->record('software','*','id',$_REQUEST['id']);
	$edit=true;
}
?>
 <div style="width:600px;">
<div class="windowTitle">
<?php if($edit) { echo 'ویرایش نرم افزار'; } else { echo 'اضافه کردن نرم افزار'; } ?>
</div>
<form action="process.php" id="addsoftware_form" method="post">
<input type="hidden" name="addsoftware" value="1" />
<?php if($edit) { ?>
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<?php } ?>
<div class="window" >


<table width="98%" border="0">
  <tr>
    <td width="22%" align="left">نام نرم افزار : </td>
    <td width="70%"><input class="textbox" value="<?php if($edit) echo $soft['title']; ?>" name="title" /></td>
	<td width="4%" align="left"></td>
	<td width="4%">	</td>
  </tr>       
</table>

<div class="nav" align="right">

<input type="button" value="ثبت اطلاعات" onclick="sub_form('addsoftware_form')" style="float:left;" />
<input type="button" value="بازگشت" onclick="window.location='?page=software'" style="float:left;" />
</div>
</div>  
</form>
</div>