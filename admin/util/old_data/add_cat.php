<?php
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');
$catname=$_POST['catname'];
 $sq5 = "insert into ".FAQADMINTBL." (category_title,status) values('".$catname."',1)";
 $rs5 = mysql_query($sq5);
if($rs5){
echo 'Added';}
else{
echo 'Not Added';;
}
?>