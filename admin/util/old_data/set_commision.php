<?php 

include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");

$id = $_POST['id'];
$value = $_POST['value'];

$update = mysql_query("update ".ARTISTPROFILE." set commision = '$value' where id = '$id'");

?>