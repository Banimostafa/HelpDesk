<?php
if(isset($_REQUEST['id'])) {
	$item=$db->record('chart_item','*','id',$_REQUEST['id']);
	$edit=true;
}
?>
 <div style="width:400px;">
<div class="windowTitle">
<?php if($edit) { echo 'ویرایش '; } else { echo 'اضافه کردن مورد جدید'; } ?>
</div>
<form action="process.php" id="addchart_form" method="post">
<input type="hidden" name="addchart" value="1" />
<?php if($edit) { ?>
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<?php } ?>
<div class="window" >


<table width="98%" border="0">
  <tr>
    <td width="40%" align="left">عنوان سمت یا گروه کاربری : </td>
    <td width="60%"><input class="textbox" value="<?php if($edit) echo $item['title']; ?>" name="title" /></td>
  </tr>
  <tr>
    <td align="left">گروه کاربری : </td>
    <td>
	<select name="up_level_id" class="textbox">
		<option value="0"></option>
		  <?php
		  $res=$db->select("select * from `chart_item` where `status`!='deleted' and `up_level_id`='0'");
		  while($cat=mysql_fetch_assoc($res)) {
		  ?>
		  <option value="<?php echo $cat['id']; ?>" <?php if($edit && $cat['id']==$item['up_level_id']) echo 'selected="selected"'; ?>><?php echo $cat['title']; ?></option>
		  <?php } ?>		
	</select>
	</td>
  </tr>        
</table>


<div class="nav" align="right">

<input type="button" value="ثبت اطلاعات" onclick="sub_form('addchart_form')" style="float:right;" />
<input type="button" value="بازگشت" onclick="window.location='?page=chart'" style="float:right;" />

</div>
</div>  
</form>
</div>