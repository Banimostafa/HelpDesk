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
			$filter .= "AND `user_id`='".$_REQUEST['uid']."'";
		}			

		$query="SELECT * FROM `admin_contact` WHERE `status`!='deleted' ".$filter;
		$result=$db->select($query);
		$n= mysql_num_rows($result); 
		$t_num=$n;	$paging='';

			for($i=0;$i<ceil($n/20);$i++) {
				$paging.='<div class="pageNum ';
				if($i==$page) { 
					$paging.='pactive"';
				} else { 
					$paging.='" onclick="loadcontact('.$i.')"';
				}
				$paging.='>'.farsiNum($i+1).'</div>';
			 }
		
		$query="SELECT * FROM `admin_contact` WHERE `status`!='deleted' ".$filter." order by `id` desc LIMIT ".($page*20).",20  ";
		$result=$db->select($query);
		$j=0;	$rowData='';
		while($row=mysql_fetch_assoc($result)) {
			$user=$db->record('users','*','id',$row['user_id']);
			if($row['status']=='unread') { $bold='font-weight:bold;'; } else { $bold=''; }
			$id=$row['id'];
			$rowData.='<div class="gridRow " id="row'.$id.'"  style="width:450px; '.$bold.'" >';
			$rowData.='<span style="width:20px;" id="col-0'.$id.'"><input id="check'.$id.'" type="checkbox" onclick="selRow('.$id.'); shBtm();" value="'.$id.'" /></span>';
			$rowData.='<span style="width:250px;" id="col-1'.$id.'">'.$user['lname'].'</span>';
			$rowData.='<span style="width:100px;" id="col-1'.$id.'">'.$row['date'].'</span>';
			$rowData.='</div>';

			}
			
 $command="loadcontact('".$page."');";
 echo json_encode(array("rows"=>$rowData,"paging"=>$paging,"command"=>$command,"num"=>farsiNum($t_num)));	
?>