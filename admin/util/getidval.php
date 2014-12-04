<?php
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");
include_once("../../classes/dbFactory.php");
$db = new dbFactory();

// get master value
// get the name/title of a paricular id parameter
if(isset($_POST['table_name']) && isset($_POST['id']) && isset($_POST['data_val'])){
	// get value
	if(isset($_POST['code_field']))
	$record = $db->recordFetch($_POST['id'],constant($_POST['table_name']).":".$_POST['code_field']);
	else
	$record = $db->recordFetch($_POST['id'],constant($_POST['table_name']).":".'id');
	echo getElementVal($_POST['data_val'],$record);
}
if(isset($_POST['userid']) && isset($_POST['data_val']) && isset($_POST['data_val2'])){
	// get value
	$record = $db->recordFetch($_POST['userid'],'ksa_user'.":".'customer_code');
	
	echo getElementVal($_POST['data_val'],$record).' '.getElementVal($_POST['data_val2'],$record);
}
?>