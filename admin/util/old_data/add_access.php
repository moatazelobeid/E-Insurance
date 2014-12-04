<?php
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');
$feature_name=$_POST['feature_name'];
$feature_benifit=$_POST['feature_benifit'];
 $sq5 = "insert into ".ACCESSFEATURE." (feature_name,feature_benifit,status) values('".$feature_name."','".$feature_benifit."',1)";
 $rs5 = mysql_query($sq5);
if($rs5){
echo 'Added';}
else{
echo 'Not Added';;
}
?>