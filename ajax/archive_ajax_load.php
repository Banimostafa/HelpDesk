<?php 
session_start();
include('../files/setting.php');
include('../files/farsi_num.php');
include('../files/jalali_calendar.php');

		$link= mysql_connect($setting['hostdb'],$setting['userdb'],$setting['passdb']);		mysql_select_db($setting['namedb'],$link);
		$page=$_REQUEST['page'];
		
		$query="SELECT * FROM `archive` WHERE `status`!='del' AND `base_en`='".$_SESSION['base_en']."' ORDER BY `date` ";
		mysql_query('SET NAMES "UTF8"');	$result= mysql_query($query, $link);	$n= mysql_num_rows($result); 
		$t_num=$n;	$paging='';

			for($i=0;$i<ceil($n/20);$i++) {
				$paging.='<div class="pageNum ';
				if($i==$page) { 
					$paging.='pactive"';
				} else { 
					$paging.='" onclick="loadPage('.$i.')"';
				}
				$paging.='>'.farsiNum($i+1).'</div>';
			 }
		
		$p=$page*20;	$j=0;	$lri=$n;
		while($row=mysql_fetch_assoc($result)) {
			if($j<$p) {
				$j++;
			}
			else {
				$lri=$row['ar_id']; //last row id
				break;
			}
		}
		
		$query="SELECT * FROM `archive` WHERE `status`!='del' AND `base_en`='".$_SESSION['base_en']."' AND `ar_id`>='$lri' ORDER BY `date` ";
		mysql_query('SET NAMES "UTF8"');	$result= mysql_query($query, $link);	$n= mysql_num_rows($result);	
		$j=0;	$rowData='';
		while($row=mysql_fetch_assoc($result)) {
			if($j<20) {
			$date=$row['date'];
				list($year, $month, $day) = split('[/.-]', $date);
				$b=GregorianToJalali($year, $month, $day);
				$date=$b[0].'/'.$b[1].'/'.$b[2];
			$format=$row['format'];
			$size=$row['size'];
			$path=$row['path'];
									
			$ar_id=$row['ar_id'];
			$rowData.='<div class="gridRow " id="row'.$ar_id.'"  style="width:550px; " >';
			$rowData.='<span style="width:20px;" id="col-0'.$ar_id.'"><input id="check'.$ar_id.'" title="'.$ar_id.'" type="checkbox" onclick="selRow('.$ar_id.'); shBtm();" value="'.$path.'" /></span>';
			$rowData.='<span style="width:240px;" id="col-1'.$ar_id.'">'.$row['title'].'</span>';
			$rowData.='<span style="width:80px;" id="col-2'.$ar_id.'">'.$format.'</span>';
			$rowData.='<span style="width:80px;" id="col-2'.$ar_id.'">'.farsiNum($size).'</span>';
			$rowData.='<span style="width:100px;" id="col-3'.$ar_id.'" >'.farsiNum($date).'</span>';
			$rowData.='</div>';
			} $j++; }
			
 echo json_encode(array("rows"=>$rowData,"paging"=>$paging,"command"=>$command,"num"=>farsiNum($t_num)));	
?>