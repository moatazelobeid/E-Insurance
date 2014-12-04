<?php 
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");

if(isset($_POST['email']))
{
$no=$_REQUEST['email'];
$ses = $_REQUEST['ses'];
$rs=mysql_query("select * from ".ARTISTPROFILE." where email='$no' and id !='$ses'");

if(mysql_num_rows($rs)==1)
{
	echo 'ERROR';
}
else{
	echo 'OK';
}
}
?>