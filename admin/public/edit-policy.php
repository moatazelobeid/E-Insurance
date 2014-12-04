<?php
// Edit existing policy
// get parameters
$policy_no = $_GET['policy_no'];
$action = $_GET['action'];
$step = $_GET['step'];

// get editable policy details
$policy_deatil = $db->recordFetch($policy_no,POLICYMASTER.":".'policy_no');
// check for valid policy no
if(count($policy_deatil) > 0){
	// get policy class
	$policy_class = getElementVal('policy_class_id',$policy_deatil);
	$policy_type_id = getElementVal('policy_type_id',$policy_deatil);
	$customer_id = getElementVal('customer_id',$policy_deatil);
	$policy_no = getElementVal('policy_no',$policy_deatil);
	$package_no = getElementVal('package_no',$policy_deatil);
	
	// load page based on policy class
	if(is_numeric($policy_class) && !empty($policy_class)){
		switch($policy_class){
			case '1':
				// load motor insurance steps
				if($step == 1) include_once("add-policy.php");
				if($step == 2) include_once("motor-setp2.php");
				if($step == 3) include_once("motor-setp3.php");
				if($step == 4) include_once("motor-setp4.php");
			break;
			default:
			// silence is golden
			echo "<strong>Policy Open for Motor Insurance Only</strong>";
			break;
		}
	}
	
}else{
	echo "<strong>Invlaid Policy No</strong>";
}