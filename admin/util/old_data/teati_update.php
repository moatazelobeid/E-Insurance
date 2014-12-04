<?php
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');
$catname=$_POST['catname'];
$update_id=$_POST['update_id'];
 $sq5 = "update  ".TESTIMONIALCAT." set category_title='".$catname."' where `id`='".$update_id."'";
 $rs5 = mysql_query($sq5) or die(mysql_error());
if($rs5){
echo 'updated';}
else{
echo 'Not updated';
}
?>