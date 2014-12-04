<?php  
include_once("../config/session.php");
include_once("../config/config.php");
include_once("../config/functions.php");
include_once("../config/tables.php");
include_once("../classes/dbFactory.php");
if(isset($_REQUEST['vehicle_id']) && !empty($_REQUEST['vehicle_id']))
{
	$vehicle_id = $_REQUEST['vehicle_id'];
	$rs=mysql_query("select * from ".VMODEL." where make_id='".$vehicle_id."' and status ='1' ");

	$make='';
	if(mysql_num_rows($rs) > 0)
	{
		$make.= '<p><label for="Vehicle model">Vehicle Model</label><select name="vehicle_model" id="vehicle_model" onchange="getType(this.value)"  style="width:60%;"><option value="">-Select type-</option>';
		while($row = mysql_fetch_array($rs)):
		$make.= '<option value="'.$row['id'].'">'.$row['model'].'</option>';
		endwhile;
		$make.="</select></p>";
		if($make <> '')
		{
			echo $make;	
		}
	}
	else{
		echo 0;
	}
}
if(isset($_REQUEST['vehicle_modelid']) && !empty($_REQUEST['vehicle_modelid']))
{
	$vehiclemodel_id = $_REQUEST['vehicle_modelid'];
	$rs=mysql_query("select * from ".VTYPE." where make_id='".$vehiclemodel_id."' and status ='1' ");

	$type='';
	if(mysql_num_rows($rs) > 0)
	{
		$type.= '<p><label for="Vehicle type">Vehicle Type</label><select name="vehicle_type" id="vehicle_type"  style="width:60%;"><option value="">-Select type-</option>';
		while($row = mysql_fetch_array($rs)):
		$type.= '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
		endwhile;
		$type.="</select></p>";
		if($type <> '')
		{
			echo $type;	
		}
	}
	else{
		echo 0;
	}
}
if(isset($_REQUEST['uname']) && !empty($_REQUEST['paswd']))
{
	
	$username= $_REQUEST['uname'];
	$paswd = $_REQUEST['paswd'];
	$policyid = $_REQUEST['policy_id'];
	$check_user = mysql_query("select * from ".LOGINTBL." WHERE user_type ='U' and uname ='".$username."' AND pwd = '".base64_encode($paswd)."' ");

	if(mysql_num_rows($check_user) >0)
	{
		$userlogininfo = mysql_fetch_object($check_user);

		$userinfo = mysql_fetch_object(mysql_query("select * from ksa_user where id='".$userlogininfo->uid."' limit 1 "));
		$todaytime = date('Y-m-d H:i:s');
		//$update_login = $db->recordUpdate(array("uid" => $userlogininfo->uid,"user_type"=>'U'),array('last_login'=>$todaytime,'login_status'=>'1'),LOGINTBL);
		$_SESSION['uid'] =  $userinfo->id;
		$_SESSION['uname'] =  $userinfo->fname;
		$_SESSION['uemail'] =  $userinfo->email;
		echo $policyid;
	}else{
			
		echo 0;
	}
	
}

?>