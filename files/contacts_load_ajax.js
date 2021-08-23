
function loadcontact(page,uid='0'){
	showPageinfo('در حال بارگذاری','show');
		$.post("files/contacts_ajax_load.php", { page: page, status: status, uid:uid},
		function(data){
			$('#rows_container').html(data.rows);
			$('#paging_container').html(data.paging);
			$('#total_items').html(data.num);
			command=data.command;
			showPageinfo('','hide');
			shBtm();
		}, "json");
	}
	