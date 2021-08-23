 <div style="width:500px;">
<div class="windowTitle">
چارت سازمانی
</div>
<div class="window" >


<div class="toolbar" align="center">

<div class="btm" id="newMessage" onclick="window.location='?page=add_chart'">
مورد جدید
</div>

<div class="btm" id="delBtm" onclick="delchart()" style="display:none;">
حذف
</div>

<div class="btm" id="viewBtm" onclick="setAction('add_chart')" style="display:none;">
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
<span style="width:400px;" onclick="loadCats('0','title')">عنوان</span>
</div>

<div class="gridStain" id="rows_container"  style="width:470px;">

</div>

<div id="showInfo">در حال بارگذاری</div>

<div class="nav" align="right">

<div class="paging">
<div style="float:right; width:50px;">صفحه : </div>
<div id="paging_container">

</div>
<script>
	loadchart('0');
</script>
</div>  
</div>