<?php 
@session_start();

include('farsi_num.php');
//db files
include('config.php');
include('dbu.class.php');

	$db = new dbu();
	$db->setup($user,$pass,$database,$host);

		$page=$_REQUEST['page'];
		
		if($_REQUEST['status']!='0') {
			$filter="AND `status`='".$_REQUEST['status']."'";
		}		

		$query="SELECT * FROM `storage` WHERE `status`!='deleted' ".$filter;
		$result=$db->select($query);
		$n= mysql_num_rows($result); 
		$t_num=$n;	$paging='';

			for($i=0;$i<ceil($n/20);$i++) {
				$paging.='<div class="pageNum ';
				if($i==$page) { 
					$paging.='pactive"';
				} else { 
					$paging.='" onclick="loadstore('.$i.')"';
				}
				$paging.='>'.farsiNum($i+1).'</div>';
			 }
		
		$query="SELECT * FROM `storage` WHERE `status`!='deleted' ".$filter." ORDER BY `id` DESC LIMIT ".($page*20).",20  ";
		$result=$db->select($query);
		$j=0;	$rowData='';
		while($row=mysql_fetch_assoc($result)) {
			$id=$row['id'];
			$rowData.='<div class="gridRow " id="row'.$id.'"  style="width:450px;" >';
			$rowData.='<span style="width:20px;" id="col-0'.$id.'"><input id="check'.$id.'" type="checkbox" onclick="selRow('.$id.'); shBtm();" value="'.$id.'" /></span>';
			$rowData.='<span style="width:100px;" id="col-1'.$id.'">'.$row['part_title'].'</span>';
			$rowData.='<span style="width:300px;" id="col-1'.$id.'">'.$row['part_desc'].'</span>';
			$rowData.='</div>';

			}
			
 $command="loadstore('".$page."');";
 echo json_encode(array("rows"=>$rowData,"paging"=>$paging,"command"=>$command,"num"=>farsiNum($t_num)));	
?>