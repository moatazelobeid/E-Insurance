<?php
if($_GET['view'] != "" && $_GET['view'] == "policy-type"){
	include_once("policy-type.php");
}elseif($_GET['view'] != "" && $_GET['view'] == "policy_details"){
	include_once("policy_details.php");
}elseif($_GET['view'] != "" && $_GET['view'] == "policy-attachments"){
	include_once("policy-attachments.php");
}
elseif($_GET['view'] != "" && $_GET['view'] == "policy-covers"){
	include_once("policy-cover.php");
}
else{
	include_once("policy-class.php");
}
?>