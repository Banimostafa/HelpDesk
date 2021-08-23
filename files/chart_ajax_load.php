<?php 
@session_start();

include('farsi_num.php');
//db files
include('config.php');
include('dbu.class.php');

	$db = new dbu();
	$db->setup($user,$pass,$database,$host);

		$page=$_REQUEST['page'];

		$query="SELECT * FROM `chart_item` WHERE `status`!='deleted' ";
		$result=$db->select($query);
		$n= mysql_num_rows($result); 
		$paging='';

			for($i=0;$i<ceil($n/20);$i++) {
				$paging.='<div class="pageNum ';
				if($i==$page) { 
					$paging.='pactive"';
				} else { 
					$paging.='" onclick="loadchart('.$i.')"';
				}
				$paging.='>'.farsiNum($i+1).'</div>';
			 }
		$t_num=0;
		$query="SELECT * FROM `chart_item` WHERE `status`!='deleted' AND `up_level_id`='0' LIMIT ".($page*20).",20  ";
		$result=$db->select($query);
		$j=0;	$rowData='';
		while($row=mysql_fetch_assoc($result)) {
			$t_num++;		
			$id=$row['id'];
			$rowData.='<div class="gridRow " id="row'.$id.'"  style="width:450px;" >';
			$rowData.='<span style="width:20px;" id="col-0'.$id.'"><input id="check'.$id.'" type="checkbox" onclick="selRow('.$id.'); shBtm();" value="'.$id.'" /></span>';
			$rowData.='<span style="width:400px;" id="col-1'.$id.'">'.$row['title'].'</span>';
			$rowData.='</div>';
				$sql="SELECT * FROM `chart_item` WHERE `status`!='deleted' AND `up_level_id`='".$id."' ";
				$sub_res=$db->select($sql);
				while($item=mysql_fetch_assoc($sub_res)) {
				$t_num++;
					$id=$item['id'];
					$rowData.='<div class="gridRow " id="row'.$id.'"  style="width:450px;" >';
					$rowData.='<span style="width:20px;" id="col-0'.$id.'"><input id="check'.$id.'" type="checkbox" onclick="selRow('.$id.'); shBtm();" value="'.$id.'" /></span>';
					$rowData.='<span style="width:400px;" id="col-1'.$id.'">'.$row['title'].'&nbsp; &raquo; &nbsp;'.$item['title'].'</span>';
					$rowData.='</div>';				
				}

			}
			
 $command="loadchart('".$page."');";
 echo json_encode(array("rows"=>$rowData,"paging"=>$paging,"command"=>$command,"num"=>farsiNum($t_num)));	
?>