<?php
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');
$id=$_POST['pid'];
 $sq5 = "delete FROM ".FAQADVICECAT." where id='".$id."'";
 $rs5 = mysql_query($sq5);
if($rs5){
echo 'Deleted';}
else{
echo 'Not Delete';;
}
?>