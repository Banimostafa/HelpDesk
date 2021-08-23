 <div style="width:500px;">
<div class="windowTitle">
لیست سیستم ها
</div>
<div class="window" >


<div class="toolbar" align="center">

<div class="btm" id="newMessage" onclick="window.location='?page=add_software'">
نرم افزار جدید
</div>

<div class="btm" id="delBtm" onclick="delsoftware()" style="display:none;">
حذف
</div>

<div class="btm" id="viewBtm" onclick="setAction('add_software')" style="display:none;">
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
<span style="width:400px;">نام نرم افزار </span>
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

<script>
loadsoftware('0');
</script>
</div>
</div>  
</div>