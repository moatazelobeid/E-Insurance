<?php
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");


$id = $_POST['id'];
$sql = mysql_query("update ".ARTDET." set is_framing = '0', f_type = '0',f_cost = '' where id = '$id'");

if($sql)
{
//echo "Art was deleted";
}
else
{
echo "Art deletion failed.";	
}

?>