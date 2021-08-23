//confirm for an act
function actConfirm(url,text) {
	var a=confirm(text);
	if(a==true) {
		window.location=url;
	} else {
		return false;
	}
}

//show or hide bottoms
function shBtm() {
	var n = $("input:checked").length;

	if(n==1) { $('#viewBtm').fadeIn('fast'); } else { $('#viewBtm').fadeOut('fast'); }
	if(n>0) {
		if(status!='sent') {
			$('#delBtm').fadeIn('fast'); 
		} else {
			var sent_flag=0;
			var result =$("input:checked").get(); 
    		var columns = $.map(result, function(element) {
        		if($(element).attr("title")=='readed') { sent_flag=1; }
   			});
			if(sent_flag==0) { $('#delBtm').fadeIn('fast'); } else { $('#delBtm').fadeOut('fast'); }
		}
	} else { $('#delBtm').fadeOut('fast'); }
}

//show or hide sell product info
function sell_prinfo(id,price) {
	var n = $("input:checked").length;

	$('#selrow_price').val(price);
	$('#selrow_id').val(id);
	
	if(n==1) { $('#item_info').fadeIn('fast'); } else { $('#item_info').fadeOut('fast'); }
	if(n>0) {

	} else { $('#item_info').fadeOut('fast'); }
}

//select a row with checkbox
function selRow(id) {
		if($('#check'+id).is(':checked')) {
			document.getElementById('row'+id).style.background='#d4edf7';
		} else {
			document.getElementById('row'+id).style.background='#e8f5fa';
		}
}

//show/hide showInfo box
function showPageinfo(text,type) {
	$('#showInfo').text(text);
	if(type=='show') {
		$(".gridRow").css("opacity","0.6");
		$('#showInfo').fadeIn('fast');
	} else {
		$(".gridRow").css("opacity","1");
		$('#showInfo').fadeOut('fast');
	}
}


//going to update or renew
function setAction(page) {
	var n = $("input:checked").val();
	//var pr_id=$('#check'+n).val();
	window.location='?page='+page+'&id='+n;
}


//switch between sections
$("#section").live('change', function(e) {
	status=$("#section").val();
	//loadPage('0');
	window.location='#'+status;			 
});
