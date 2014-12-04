<?php
include_once('../../config/config.php');
include_once("../../config/tables.php");
include_once("../../config/functions.php");

$id = $_POST['id'];
$type=$_POST['type'];
$text=$_POST['text'];

  $sql="update ".ARTDET." set is_framing = '1',f_type = '$type', f_cost = '$text' where id = '$id' ";
  $qry=mysql_query($sql);
  
  if(mysql_affected_rows()>0)
  {
  	  echo "OK";
  }
  else
  {
	  echo "ERROR";
  }

?>