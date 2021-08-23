
 <div style="width:600px;">
<div class="windowTitle">
ثبت پیام برای مدیر 
</div>
<form action="process.php" id="addreq_form" method="post">
<input type="hidden" name="addcontact" value="1" />

<div class="window" >


<table width="98%" border="0">
<tr>
	<td width="4%" align="left" valign="top">متن پیام : </td>
	<td width="4%"><textarea name="desc" class="textbox" style="width:300px;"></textarea></td>
  </tr>       
</table>

<div class="nav" align="right">

<input type="button" value="ثبت اطلاعات" onclick="sub_form('addreq_form')" style="float:left;" />
<input type="button" value="بازگشت" onclick="window.location='?page=user_contects'" style="float:left;" />

</div>
</div>  
</form>
</div>