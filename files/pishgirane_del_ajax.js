
function delpishgirane(){
	if(confirm('از حذف این مورد مطمئن هستید؟')) {
	showPageinfo('در حال حذف','show');

    var result =$("input:checked").get(); 
    var columns = $.map(result, function(element) {
        return $(element).attr("value");
    });
    var items=columns.join(",");
	
		$.post("files/pishgirane_ajax_del.php", { items: items, status: status },
		function(){
			eval(command);
			showPageinfo('','hide');
			shBtm();
		});
	}
}