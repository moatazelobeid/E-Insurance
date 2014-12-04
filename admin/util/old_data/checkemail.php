<?php 
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");

if(isset($_POST['email']))
{
$no=$_REQUEST['email'];
$rs=mysql_query("select * from esc_escort where email='$no'");

if(mysql_num_rows($rs)==1)
{
	echo 'ERROR';
}
else{
	echo 'OK';
}
}
?>