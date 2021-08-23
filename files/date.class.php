<?php
class shamsidate{
	function showdate($type,$maket="now"){
	 	 //set 1 if you want translate number to farsi or if you don't like set 0
		 $transnumber=1;
		 ///set your timezone
		 date_default_timezone_set("Asia/Tehran");
		 ///chosse your timezone
		 $TZhours=0;
		 $TZminute=0;
		 if($maket=="now"){
			  $year=date("Y");
			  $month=date("m");
			  $day=date("d");
			  list( $jyear, $jmonth, $jday ) = self::gregorian_to_jalali($year, $month, $day);
			  $maket=self::jmaketime(date("h")+$TZhours,date("i")+$TZminute,date("s"),$jmonth,$jday,$jyear);
		 }else{
			  $maket+=$TZhours*3600+$TZminute*60;
			  $date=date("Y-m-d",maket);
			  list( $year, $month, $day ) = preg_split ( '/-/', $date );
			  list( $jyear, $jmonth, $jday ) = self::gregorian_to_jalali($year, $month, $day);
		  }
		 $result = "";
		 $need= $maket;
		 $year=date("Y",$need);
		 $month=date("m",$need);
		 $day=date("d",$need);
		 $i=0;
		 while($i<strlen($type)){
			  $subtype=substr($type,$i,1);
			  switch ($subtype){
			   case "d":
				list( $jyear, $jmonth, $jday ) = self::gregorian_to_jalali($year, $month, $day);
				if($jday<10)$result1="0".$jday;
				else  $result1=$jday;
			//    if($transnumber==1) $result.=Convertnumber2farsi($result1);
			//    else 
				$result.=$result1;
				break;
			   case "m":
				list( $jyear, $jmonth, $jday ) = self::gregorian_to_jalali($year, $month, $day);
				if($jmonth<10) $result1="0".$jmonth;
				else $result1=$jmonth;
			//    if($transnumber==1) $result.=Convertnumber2farsi($result1);
			//    else 
				$result.=$result1;
				break;
			   case "Y":
				list( $jyear, $jmonth, $jday ) = self::gregorian_to_jalali($year, $month, $day);
				$result1=$jyear;
			//    if($transnumber==1) $result.=Convertnumber2farsi($result1);
			//    else 
				$result.=$result1;
				break;  
			   default:
				$result.=$subtype;
			  }
			 $i++;
		 }
		 return $result;
	}
	
	function showtime($param = "H:i:s"){
		putenv("TZ=Asia/Tehran");
		return date($param);
	}
	 
	function jmaketime($hour,$minute,$second,$jmonth,$jday,$jyear){
		 list( $year, $month, $day ) = self::jalali_to_gregorian($jyear, $jmonth, $jday);
		 $i=mktime($hour,$minute,$second,$month,$day,$year); 
		 return $i;
	}
	///Find Day Begining Of Month
	function mstart($month,$day,$year){
		 list( $jyear, $jmonth, $jday ) = self::gregorian_to_jalali($year, $month, $day);
		 list( $year, $month, $day ) = self::jalali_to_gregorian($jyear, $jmonth, "1");
		 $timestamp=mktime(0,0,0,$month,$day,$year);
		 return date("w",$timestamp);
	}
	//Find Number Of Days In This Month
	function lastday($month,$day,$year){
		 $lastdayen=date("d",mktime(0,0,0,$month+1,0,$year));
		 list( $jyear, $jmonth, $jday ) = self::gregorian_to_jalali($year, $month, $day);
		 $lastdatep=$jday;
		 $jday=$jday2;
		 while($jday2!="1")
		 {
		  if($day<$lastdayen)
		  {
		   $day++;
		   list( $jyear, $jmonth, $jday2 ) = self::gregorian_to_jalali($year, $month, $day);
		   if($jdate2=="1") break;
		   if($jdate2!="1") $lastdatep++;
		  }
		  else
		  { 
		   $day=0;
		   $month++;
		   if($month==13) 
		   {
			 $month="1";
			 $year++;
		   }
		  }
		 }
		 return $lastdatep-1;
	}
	
	function div($a,$b) {
		return (int) ($a / $b);
	}
	function gregorian_to_jalali ($g_y, $g_m, $g_d) {
		$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);     
		 
	   $gy = $g_y-1600; 
	   $gm = $g_m-1; 
	   $gd = $g_d-1; 
	   $g_day_no = 365*$gy+self::div($gy+3,4)-self::div($gy+99,100)+self::div($gy+399,400); 
	   for ($i=0; $i < $gm; ++$i) 
		  $g_day_no += $g_days_in_month[$i]; 
	   if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0))) 
		  /* leap and after Feb */ 
		  $g_day_no++; 
	   $g_day_no += $gd; 
	   $j_day_no = $g_day_no-79; 
	   $j_np = self::div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */ 
	   $j_day_no = $j_day_no % 12053; 
	   $jy = 979+33*$j_np+4*self::div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */ 
	   $j_day_no %= 1461; 
	   if ($j_day_no >= 366) { 
		  $jy += self::div($j_day_no-1, 365); 
		  $j_day_no = ($j_day_no-1)%365; 
	   } 
	   for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) 
		  $j_day_no -= $j_days_in_month[$i]; 
	   $jm = $i+1; 
	   $jd = $j_day_no+1; 
	   //return array($jy, $jm, $jd);
	   if(strlen($jm)==1) $jm='0'.$jm;
	   if(strlen($jd)==1) $jd='0'.$jd;
	   return $jd.'/'.$jm.'/'.$jy;  
	   
	} 
	
	function persianday(){
		$persian_day_names=array(
		'6'=>'&#1588;&#1606;&#1576;&#1607;',
		'0'=>'&#1740;&#1705;&#1588;&#1606;&#1576;&#1607;',
		'1'=>'&#1583;&#1608;&#1588;&#1606;&#1576;&#1607;',
		'2'=>'&#1587;&#1607; &#1588;&#1606;&#1576;&#1607;',
		'3'=>'&#1670;&#1607;&#1575;&#1585;&#1588;&#1606;&#1576;&#1607;',
		'4'=>'&#1662;&#1606;&#1580;&#1588;&#1606;&#1576;&#1607;',
		'5'=>'&#1570;&#1583;&#1740;&#1606;&#1607;'
		);
		return $persian_day_names[date("w")];
	}
	function jalali_to_gregorian($j_y, $j_m, $j_d) { 
		$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
			   
	   $jy = $j_y-979; 
	   $jm = $j_m-1; 
	   $jd = $j_d-1; 
	   $j_day_no = 365*$jy + self::div($jy, 33)*8 + self::div($jy%33+3, 4); 
	   for ($i=0; $i < $jm; ++$i) 
		  $j_day_no += $j_days_in_month[$i]; 
	   $j_day_no += $jd; 
	   $g_day_no = $j_day_no+79; 
	   $gy = 1600 + 400*self::div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */ 
	   $g_day_no = $g_day_no % 146097; 
	   $leap = true; 
	   if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */ 
	   { 
		  $g_day_no--; 
		  $gy += 100*self::div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */ 
		  $g_day_no = $g_day_no % 36524; 
		  if ($g_day_no >= 365) 
			 $g_day_no++; 
		  else 
			 $leap = false; 
	   } 
	   $gy += 4 * self::div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */ 
	   $g_day_no %= 1461; 
	   if ($g_day_no >= 366) { 
		  $leap = false; 
		  $g_day_no--; 
		  $gy += self::div($g_day_no, 365); 
		  $g_day_no = $g_day_no % 365; 
	   } 
	   for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++) 
		  $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap); 
	   $gm = $i+1; 
	   $gd = $g_day_no+1; 
	   
	   if ($gm < 10) $gm = "0".$gm;
	   if ($gd < 10) $gd = "0".$gd;
	 
	   //return array($gy, $gm, $gd);
	   return $gy.'-'.$gm.'-'.$gd; 
	}
	//Part2
	/*
	$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
	$g_month_name = array("", "January", "February", "March", "April",
						  "May", "June", "July", "August", "September",
						  "October", "November", "December");
	$g_week_name = array("", "Monday", "Tuesday", "Wednesday",
		   "Thursday", "Friday", "Saturday", "Sunday");
		   */
	function gregorian_week_day($g_y, $g_m, $g_d)
	{
	   global $g_days_in_month;
	   $gy = $g_y-1600;
	   $gm = $g_m-1;
	   $gd = $g_d-1;
	   $g_day_no = 365*$gy+self::div($gy+3,4)-self::div($gy+99,100)+self::div($gy+399,400);
	   for ($i=0; $i < $gm; ++$i)
		  $g_day_no += $g_days_in_month[$i];
	   if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
		  /* leap and after Feb */
		  ++$g_day_no;
	   $g_day_no += $gd;
	   return ($g_day_no + 5) % 7 + 1;
	}
	
	function jalali_week_day($j_y, $j_m, $j_d)
	{
	   global $j_days_in_month;
	   $jy = $j_y-979;
	   $jm = $j_m-1;
	   $jd = $j_d-1;
	   $j_day_no = 365*$jy + self::div($jy, 33)*8 + self::div($jy%33+3, 4);
	   for ($i=0; $i < $jm; ++$i)
		  $j_day_no += $j_days_in_month[$i];
	   $j_day_no += $jd;
	   return ($j_day_no + 2) % 7 + 1;
	}
	function jcheckdate($j_m, $j_d, $j_y)
	{
	   global $j_days_in_month;
	   if ($j_y < 0 || $j_y > 32767 || $j_m < 1 || $j_m > 12 || $j_d < 1 || $j_d >
			   ($j_days_in_month[$j_m-1] + ($j_m == 12 && !(($j_y-979)%33%4))))
		   return false;
	   return true;
	}
	function totimestamp($jalalidate="",$tehrantime=""){
		$date = $this->showdate('Y/m/d');
		$time = $this->showtime();
		if ($jalalidate!='') $date = $jalalidate;
		if ($tehrantime!='') $time = $tehrantime;
		$datearray = explode("/",$date);
		$a = $this->jalali_to_gregorian($datearray[0],$datearray[1],$datearray[2]);
		$timearray = explode(":",$time);
		return mktime($timearray[0],$timearray[1],$timearray[2],$a[2],$a[1],$a[0]);
	}
 
}
?>