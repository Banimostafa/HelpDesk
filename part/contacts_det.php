<?php
if(isset($_REQUEST['id'])) {
	$request=$db->record('admin_contact','*','id',$_REQUEST['id']);
	if($_SESSION['level']=='1') {
		$res=$db->update('admin_contact',"`status`='readed'",'id',$_REQUEST['id']);	
	}
	$edit=true;
}
?>
 <div style="width:600px;">
<div class="windowTitle">
جزئیات پیام
</div>
<div class="window" >

<table width="98%" border="0">
  <tr>
    <td width="10%" align="left"><strong>کاربر : </strong></td>
	<?php $user=$db->record('users','*','id',$request['user_id']); ?>
    <td width="50%"><?php if($edit) echo $user['lname']; ?></td>
	<td width="10%" align="left"><strong>تاریخ : </strong></td>
	<td width="30%"><?php if($edit) echo $request['date']; ?></td>
  </tr>  
  <tr>
    <td align="left" valign="top"><strong>متن : </strong></td>
    <td colspan="3"><?php if($edit) echo $request['message']; ?></td>
  </tr>           
</table>


<div class="nav" align="right">
	<input type="button" value="بازگشت" onclick="window.location='?page=contacts'" style="float:left;" />
</div>
</div></div>  