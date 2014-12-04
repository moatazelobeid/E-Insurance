<?php
include_once("../../config/config.php");
require_once("../../config/tables.php");
include_once("../../config/functions.php");

$pg = $_POST["page"];
$mnm = $_POST['mnid'];
$cond = $_POST["cond"];

if($cond=="chk_pgnm")
{
  $rs=mysql_query("select * from ".ACCMENUTBL." WHERE page ='".$pg."'");
  
  if(mysql_num_rows($rs)>0)
  {
	  echo "1";
  }
  else
  {
	  echo "0";
  }
}

if($cond=="find_submenu")

{
  
  $rs=mysql_query("select * from ".ACCMENUTBL." WHERE submenu_name ='".$pg."' and menu_id='".$mnm."'");
  
  if(mysql_num_rows($rs)>0)
  {
	  echo "2";
  }
  else
  {
	  echo "3";
  }
  
}
 
  
?> 
	