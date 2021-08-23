
function loadstore(page){
	showPageinfo('در حال بارگذاری','show');
		$.post("files/storage_ajax_load.php", { page: page, status: status},
		function(data){
			$('#rows_container').html(data.rows);
			$('#paging_container').html(data.paging);
			$('#total_items').html(data.num);
			command=data.command;
			showPageinfo('','hide');
			shBtm();
		}, "json");
	}
	