 <div style="width:500px;">
<div class="windowTitle">
لیست پیام ها
</div>
<div class="window" >


<div class="toolbar" align="center">

<?php if($_SESSION['level']=='3') { ?>
<div class="btm" id="newMessage" onclick="window.location='?page=add_contact'" style="width:auto;">
پیام جدید
</div>
<?php } ?>

<div class="btm" id="delBtm" onclick="delcontact()" style="display:none;">
حذف
</div>

<div class="btm" id="viewBtm" onclick="setAction('contacts_det')" style="display:none;">
جزئیات
</div>

<!--<div class="btm" id="renewBtm" onclick="setAction('renew')" style="display:none;">
تمدید
</div>-->

<div class="pageInfo" id="spam">
<span id="total_items" style="font-size:14px;"><?php //echo farsiNum(imap_num_msg($mbx)); ?></span> مورد یافته شده
</div>

</div>

<div class="gridTitlebar"  style="width:450px;">
<span style="width:20px;">&nbsp;</span>
<span style="width:250px;">نام کاربر </span>
<span style="width:100px;">تاریخ</span>
</div>

<div class="gridStain" id="rows_container"  style="width:470px;">

</div>

<div id="showInfo">در حال بارگذاری</div>

<div class="nav" align="right">

<div class="paging">
<div style="float:right; width:50px;">صفحه : </div>
<div id="paging_container">


</div>
<!--<div class="pageNum" onclick="showPageinfo('','hide')">2</div>
<div class="pageNum">3</div>-->
</div>

<div style="float:left; width:210px; margin-top:3px;">
<label> وضعیت :</label>
<select id="section" class="textbox">
  <option value="0">همه پیام ها</option>
  <option value="readed">خوانده شده</option>
  <option value="unread">خوانده نشده</option>
</select>
</div>
<script>
<?php if($_SESSION['level']=='3') { ?>
loadcontact('0','<?php echo $_SESSION['uid']; ?>');
<?php } else { ?>
loadcontact('0');
<?php } ?>
$('#section').val(status);
window.onhashchange = function () {
	var str=window.location.hash;
	if(str!='') status=str.substring(1,str.length);
<?php if($_SESSION['level']=='3') { ?>
loadcontact('0','<?php echo $_SESSION['uid']; ?>');
<?php } else { ?>
loadcontact('0');
<?php } ?>
	$('#section').val(status);
}
</script>
</div>
</div>  
</div>