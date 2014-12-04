<?php 
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");

if(isset($_POST['uname']))
{
$no = $_REQUEST['uname'];
$ses = $_REQUEST['ses'];
$rs=mysql_query("select * from ".LOGINTBL." where uname='$no' and uid != '$ses' and user_type = 'A'");

if(mysql_num_rows($rs)==1)
{
	echo 'ERROR';
}
else{
	echo 'OK';
}
}
?>