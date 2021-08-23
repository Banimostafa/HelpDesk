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
		
		if($_REQUEST['uid']!='0') {
			$filter .= "AND (`tech_id`='".$_REQUEST['uid']."' OR `user_id`='".$_REQUEST['uid']."')";
		}				

		$query="SELECT * FROM `requests` WHERE `status`!='deleted' ".$filter;
		$result=$db->select($query);
		$n= mysql_num_rows($result); 
		$t_num=$n;	$paging='';

			for($i=0;$i<ceil($n/20);$i++) {
				$paging.='<div class="pageNum ';
				if($i==$page) { 
					$paging.='pactive"';
				} else { 
					$paging.='" onclick="loadreq('.$i.','.$_REQUEST['uid'].')"';
				}
				$paging.='>'.farsiNum($i+1).'</div>';
			 }
		
		$query="SELECT * FROM `requests` WHERE `status`!='deleted' ".$filter." order by `id` desc LIMIT ".($page*20).",20  ";
		$result=$db->select($query);
		$j=0;	$rowData='';
		while($row=mysql_fetch_assoc($result)) {
			$sys=$db->record('systems','*','id',$row['system_id']);
			$id=$row['id'];
			$rowData.='<div class="gridRow " id="row'.$id.'"  style="width:750px;" >';
			$rowData.='<span style="width:20px;" id="col-0'.$id.'"><input id="check'.$id.'" type="checkbox" onclick="selRow('.$id.'); shBtm();" value="'.$id.'" /></span>';
			$rowData.='<span style="width:400px;" id="col-1'.$id.'">'.$row['title'].'</span>';
			$rowData.='<span style="width:150px;" id="col-1'.$id.'">'.$sys['name'].'</span>';
			$rowData.='<span style="width:100px;" id="col-1'.$id.'">'.$row['date'].'</span>';
			$rowData.='</div>';

			}
			
 $command='loadreq('.$i.','.$_REQUEST['uid'].');';
 echo json_encode(array("rows"=>$rowData,"paging"=>$paging,"command"=>$command,"num"=>farsiNum($t_num)));	
?>