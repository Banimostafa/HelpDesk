<?php
if(isset($_REQUEST['id'])) {
	$soft=$db->record('pishgirane_act','*','id',$_REQUEST['id']);
	$edit=true;
}
?>
 <div style="width:600px;">
<div class="windowTitle">
<?php if($edit) { echo 'ویرایش فعالیت'; } else { echo 'اضافه کردن فعالیت'; } ?>
</div>
<form action="process.php" id="addact_form" method="post">
<input type="hidden" name="addpishgiri" value="1" />
<?php if($edit) { ?>
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<?php } ?>
<div class="window" >


<table width="98%" border="0">
  <tr>
    <td width="22%" align="left">عنوان فعالیت : </td>
    <td width="70%"><input class="textbox" value="<?php if($edit) echo $soft['act_title']; ?>" name="title" /></td>
</tr>
<tr>
	<td width="4%" align="left" valign="top">متن فعالیت : </td>
	<td width="4%"><textarea name="desc" class="textbox" style="width:300px;"><?php if($edit) echo $soft['act_desc']; ?></textarea></td>
  </tr>       
</table>

<div class="nav" align="right">

<input type="button" value="ثبت اطلاعات" onclick="sub_form('addact_form')" style="float:left;" />
<input type="button" value="بازگشت" onclick="window.location='?page=pishgirane'" style="float:left;" />
</div>
</div>  
</form>
</div>