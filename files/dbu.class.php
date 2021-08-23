<?php
@session_start();
class dbu{

  var $dbHost = '';
  var $dbUser = '';
  var $dbPass = '';
  var $dbName = '';
  var $uniqeid = 0;
	
	function setup($user,$pass,$db,$host='localhost'){
		$this->dbHost = $host;
		$this->dbUser = $user;
		$this->dbPass = $pass;
		$this->dbName = $db;	
	}
	
	
	 function del($table,$field='',$val=''){
		$con = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);   	    
		@mysql_select_db($this->dbName,$con);
		$sqlx='';
		if ($field!='' and $val!=''){$sqlx=" where `".$field."`=".$val."";}
		$sql= "delete from ".$table.$sqlx;	 	
		if (mysql_query($sql)){			
			$res = mysql_affected_rows();
			@mysql_close($con);
			return $res;
		}else{
			@mysql_close($con);
			return false;
		}		
	 } 

	function insert($table,$fields,$values){
		$con = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);   	    
		@mysql_select_db($this->dbName,$con);
		$sql="insert into `".$table."` (".$fields.") values (".$values.")";
		mysql_query('SET NAMES "UTF8"');
		if (mysql_query($sql)){
			$this->uniqeid = mysql_insert_id(); 
			$res = mysql_insert_id();
//			echo mysql_error();
			@mysql_close($con);
			return $res;
		}else{
//			echo mysql_error();
			@mysql_close($con);
			return 0;
		}
		
	}

	function update($table,$updates,$uniqfield='',$uniqval=''){
		$con = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);   	    
		@mysql_select_db($this->dbName,$con);

		$sqlx='';
		if ($uniqfield!='' and $uniqval!=''){$sqlx=" where `".$uniqfield."`='".$uniqval."'";}

		$sql="update `".$table."` set ".$updates.$sqlx;
		mysql_query('SET NAMES "UTF8"');
		$res = mysql_query($sql);
		
		if ($res){
			$res = mysql_affected_rows();
			@mysql_close($con);
			return $res;
		}else{
			@mysql_close($con);
			return 0;
		}		
	}
	
	function select($sql){
		$con = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);   	    
		$temp = mysql_select_db($this->dbName,$con);
		mysql_query('SET NAMES "UTF8"');
		$res = mysql_query($sql);
		@mysql_close($con);
		return $res;
	}	

	function record($table,$fields='*',$uniqfield='',$uniqval=''){
		$sqlx='';
		if ($uniqfield!='' and $uniqval!=''){$sqlx=" where `".$uniqfield."`='".$uniqval."'";}

		$sql="select ".$fields." from `".$table."`".$sqlx;
		
		return mysql_fetch_assoc(self::select($sql));
	}	

}
	
?>
