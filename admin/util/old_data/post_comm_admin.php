<?php
include_once('../../config/config.php');
include_once("../../config/tables.php");
include_once("../../config/functions.php");

$comm=$_POST['comm'];
$bid=$_POST['bid'];
$date = date("Y-m-d h:i:s");

if($comm==''){
    echo "Error2";
  }else{
  $sql="insert into vv_blog_comments (blog_id,comments,created_date,posted_by,posted_type,status) values ('$bid','$comm','$date','Admin','S','1')";
  $qry=mysql_query($sql);
  
  if(mysql_affected_rows()>0)
  {
  	echo "OK";
  }
  }

?>