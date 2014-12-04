<?php
// class library for database activity
class dbFactory {
	
	// vars
	public $flag;
	
	// methods
	// insert and update
	public function recordInsert( $datas, $table, $exist = '', $extra = array(), $files = array() ){
		// refine args
		$fieldArr = array();
		$dataArr = array();
		
		if($exist != "")
		{
			if(dbFactory::isExists($exist,$datas,$table))
			return $this->flag = 3;
		}
		
		// file upload
		//foreach ($files as $filefield => $file)
		//{
			
		//}
		
		if(is_array($datas)){	// check array
		foreach ($datas as $field => $data){
		// make all fields and datas separate
		array_push($fieldArr,$field);
		array_push($dataArr,"'".$data."'");
		}
		
		// load extra fields and datas to array
		foreach($extra as $field => $data)
		{
			array_push($fieldArr,$field);
			array_push($dataArr,"'".$data."'");
		}
		
		// attributes and values
		$attributes = implode(",",$fieldArr);
		$$datas = implode(",",$dataArr);
		
		// save and insert record
		mysql_query("INSERT INTO $table (".$attributes.") VALUES(".$$datas.")") or die(mysql_error());
	//	echo "INSERT INTO $table (".$attributes.") VALUES(".$$datas.")";
		// set flag
		if(mysql_affected_rows() > 0)
		return $this->flag = 1;		// success
		else
		return $this->flag = 2;		// fail
		}
		else
		return $this->flag = 2;		// fail
	}
	
	public function recordUpdate( $ids, $datas, $table, $extra = array(), $file = '' ){
		// refine args
		$args = array();
		$conditions = array();
		
		if(is_array($datas)){	// check array
		foreach ($datas as $field => $data){
		// make all fields and datas separate
		array_push($args,"$field = '".$data."'");
		}
		
		// load extra fields and datas to array
		foreach($extra as $field => $data)
		{
			array_push($args,"$field = '".$data."'");
		}
		
		// attributes and values
		$attributes = implode(",",$args);
		
		$total = count($ids);
		$i = 0;
		foreach ($ids as $key => $val)
		{
			$i++;
			if($i < $total){
				$keyword = ' AND ';
			}
			array_push($conditions,"$key = '".$val."'".$keyword);
		}
		
		$cond = implode(",",$conditions);
		// save and insert record
		mysql_query("UPDATE $table SET ".$attributes." WHERE ".$cond);
		
		// set flag
		if(mysql_affected_rows() > 0)
		return $this->flag = 1;		// success
		else
		return $this->flag = 2;		// fail
		}
		else
		return $this->flag = 3;
	}
	
	// delete record
	public function recordDelete( $idval, $tables = array() ){
		// get all tables and their attributes on the basis of which the data will be deleted
		if($idval != "" && count($tables) != 0)
		{
			foreach( $tables as $table => $field )
			{
				mysql_query("DELETE FROM $table WHERE $field = '".$idval."'");
			}
			if(mysql_affected_rows() > 0)
			{
				return 1;
			}else{
				return 2;
			}
		}else{
			return 2;
		}
	}
	
	// fetch all data from a table based on a key
	public function recordFetch( $idval, $table ){
		if($idval != "" && $table != "")
		{
			$dataList = array();
			$table = explode(":",$table);
			$sq = mysql_query("SELECT * FROM $table[0] WHERE $table[1] = '$idval'");
			$dataList = mysql_fetch_assoc($sq);
			return $dataList;
		}else{
			return 2;
		}
	}
	
	// fetch all records
	public function fetchAll( $table, $orderBy = '', $limitStart = '', $limitEnd = '' ){
		if($table != "")
		{
			if($limitStart != "" && $limitEnd != ""){
				$limit = " LIMIT ".$limitStart.",".$limitEnd;
			}
			$sq = mysql_query("SELECT * FROM $table ".$orderBy.$limit);
			$dataList = mysql_fetch_assoc($sq);
			return $dataList;
		}else{
			return 2;
		}
	}
	
	// check for existing record
	public function isExists( $fieldval, $datas, $table, $id = '', $field = '' ){
		if($id != "")
		$sq = mysql_query("SELECT * FROM $table WHERE $fieldval = '".$datas[$fieldval]."' AND $field != '".$id."'");
		else
		$sq = mysql_query("SELECT * FROM $table WHERE $fieldval = '".$datas[$fieldval]."'");
		
		if(mysql_num_rows($sq) > 0)
		return true;
		else
		return false;
	}
	
	// get data array from a table based on a key with limit and order by option
	public function recordArray( $idval, $table, $orderBy = '', $limitStart = '', $limitEnd = '' ){
		if($idval != "" && $table != "")
		{
			if($limitStart != "" && $limitEnd != "")
			{
				$limit = " LIMIT ".$limitStart.",".$limitEnd;
			}
			
			$dataList = array();
			$table = explode(":",$table);
			$sq = mysql_query("SELECT * FROM $table[0] WHERE $table[1] = '$idval' $orderBy $limit");
			//$dataList = mysql_fetch_assoc($sq);
			if(mysql_num_rows($sq) > 0)
			{
				return $sq;
			}
			
		}else{
			return 2;
		}
	}

	
	public function fetchItem($cond, $table , $orderby='')
	{
		 // disabled record
		 $order = '';
		 if($orderby != '')
		 {
		 	$order = $orderby;
		 }
		 else
		 {
			 $order ='';
		 }
		 if(count($cond) > 0 && $table!= '')
		 foreach ($cond as $con => $key)
		 {
		 	$string .= $con ." = '".$cond[$con]."' AND ";
		 	
		 }
		 $string = substr($string, 0, -4); 
		 $sel = mysql_query("select * from $table where $string $order ");
		 //echo "select * from $table where $string $order ";
		 if(isset($sel))
		 {
			 if(mysql_num_rows($sel) > 0)
			 {
				return  $sel;
			 }
			 
		  }
		 
		 
	}
	// get data array from a table based on multiple keys with limit and order by option
	public function multipleRecords($cond, $table , $orderby='', $limitStart = '0', $limitEnd = '' )
	{
		 
		 $order = '';
		 if($orderby != '')
		 {
		 	$order = $orderby;
		 }
		 else
		 {
			 $order ='';
		 }
		
		
		 if(($limitEnd != ""))
		 {
			 $limit = " LIMIT ".$limitStart.",".$limitEnd;
		 }
		 if(count($cond) > 0 && $table!= '')
		 foreach ($cond as $con => $key)
		 {
		 	$string .= $con ." = '".$cond[$con]."' AND ";
		 	
		 }
		 $string = substr($string, 0, -4); 
		 $sel = mysql_query("select * from $table where $string $order $limit");
		//echo "select * from $table where $string $order $limit";
		 if(isset($sel))
		 {
			 if(mysql_num_rows($sel) > 0)
			 {
				return  $sel;
			 }
		  }
		 
	}
	
	public function delete_item($cond, $table)
	{
		 // disabled record
		
		 if(count($cond) > 0 && $table!= '')
		 foreach ($cond as $con => $key)
		 {
		 	$string .= $con ." = '".$cond[$con]."' AND ";
		 	
		 }
		 $string = substr($string, 0, -4); 
		 $sel = mysql_query("select * from $table where $string");
		 if(mysql_num_rows($sel) > 0)
		 {
		 	$del = mysql_query("delete from $table where $string");
			return 1;
		 }
		 
		 
	}
	
    // fetch all records
	public function fetchAllRecords( $table, $orderBy = '', $limitStart = '', $limitEnd = '' )
	{
	  if($table != "")
	  {
	   if($limitStart != "" && $limitEnd != "")
	   {
		 $limit = " LIMIT ".$limitStart.",".$limitEnd;
	   }
	   $sq = mysql_query("SELECT * FROM $table ".$orderBy.$limit);
	  // echo "SELECT * FROM $table ".$orderBy.$limit;
	   $dataList = mysql_fetch_assoc($sq);
	   return $dataList;
	   }else{
		return 2;
	   }
	} 
	
		// fetch all records
	public function fetchAllData( $table, $cond = '', $orderBy = '', $limitStart = '', $limitEnd = '' ){
		if($table != "")
		{
			if($limitStart != "" && $limitEnd != ""){
				$limit = " LIMIT ".$limitStart.",".$limitEnd;
			}
			if($cond != '')
			{
			  foreach($cond as $key => $val)
			  {
			   $condition = "WHERE ".$key." = ".$val." AND ";
			  }
			   $condition = substr($condition, 0, -4);
			}else{
			  $condition = "";
			}
			$sq = mysql_query("SELECT * FROM $table ".$condition.$orderBy.$limit);
			echo "SELECT * FROM $table ".$condition.$orderBy.$limit;
			return $sq;
		}else{
			return 2;
		}
	}	
}
?>