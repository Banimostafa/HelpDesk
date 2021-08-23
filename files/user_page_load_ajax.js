
function loaduser(page){
	showPageinfo('در حال بارگذاری','show');
		$.post("files/user_ajax_load.php", { page: page, level: status},
		function(data){
			$('#rows_container').html(data.rows);
			$('#paging_container').html(data.paging);
			$('#total_items').html(data.num);
			command=data.command;
			showPageinfo('','hide');
			shBtm();
		}, "json");
	}
	