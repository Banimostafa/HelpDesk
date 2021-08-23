 <div style="width:500px;">
<div class="windowTitle">
لیست کاربران
</div>
<div class="window" >


<div class="toolbar" align="center">

<div class="btm" id="newMessage" onclick="window.location='?page=add_user'">
کاربر جدید
</div>

<div class="btm" id="delBtm" onclick="deluser()" style="display:none;">
حذف
</div>

<div class="btm" id="viewBtm" onclick="setAction('add_user')" style="display:none;">
ویرایش
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
<span style="width:100px;">نام </span>
<span style="width:150px;">نام خانوادگی</span>
<span style="width:100px;">نام کاربری</span>
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
<label> گروه :</label>
<select id="section" class="textbox">
  <option value="0">همه افراد</option>
  <option value="3">کاربران</option>
  <option value="2">تکنسین ها</option>
</select>
</div>
<script>
loaduser('0');
$('#section').val(status);
window.onhashchange = function () {
	var str=window.location.hash;
	if(str!='') status=str.substring(1,str.length);
	loaduser('0');
	$('#section').val(status);
}
</script>
</div>
</div>  
</div>