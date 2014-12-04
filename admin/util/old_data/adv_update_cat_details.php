<?php
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');
$catid=$_POST['catid'];
 $sq5 = "select * from ".FAQADVICECAT." where id='".$catid."'";
 $rs5 = mysql_query($sq5) or die(mysql_error());
 $result=mysql_fetch_array($rs5);
if($rs5){
echo $result['category_title'];}
else{
echo 'Not Added';;
}
?>