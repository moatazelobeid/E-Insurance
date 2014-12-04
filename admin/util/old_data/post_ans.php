<?php
include_once('../../config/config.php');
include_once("../../config/tables.php");
include_once("../../config/functions.php");

$ans=$_POST['ans'];
$pid=$_POST['pid'];
$date = date("Y-m-d h:i:s");

if($ans==''){
    echo "Error2";
  }else{
  $sql="insert into vv_answers (ques_id,answer,answered_on) values ('$pid','$ans','$date')";
  $qry=mysql_query($sql);
  
  if(mysql_affected_rows()>0)
  {
  	echo "OK";
  }
  }

?>