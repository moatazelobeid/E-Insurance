<?php  
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");

if(isset($_REQUEST['status']))   // policy status
{
	$email_data='';
    if($_POST['type']=='')
		$table=USERPOLICY;

    if($_POST['type']=='travel')
		$table=TRAVELPOLICY;
		
	if($_POST['type']=='auto')
		$table=AUTOPOLICY;
		
	if($_POST['type']=='medical')
	    $table=HEALTHPOLICY;
	
	if($_POST['type']=='malpractice')
		$table=MALPRACTICEPOLICY;


	$id 	= $_REQUEST['id'];
	$status = $_REQUEST['status'];
	
	$query = mysql_query("update ".$table." set status = '".$status."' where id = '".$id."'");
	
	if($query)
	{
	    $sdff = mysql_fetch_array(mysql_query("SELECT * FROM ".$table." WHERE id = '".$id."'"));
		
		if($_POST['type']=='')
		{
			$sdff_user = mysql_fetch_array(mysql_query("SELECT * FROM ".USERTBL." WHERE id = '".$sdff['uid']."'"));
			$to = $sdff_user['email'];
			if($status == '1') // Active
				$email_data=getEmailTemplate(34);
			if ($status == '2')  // Cancelled
				$email_data=getEmailTemplate(35);
			$name=$sdff_user['fname'];
		}
		else
		{
			$sdff_comp = mysql_fetch_array(mysql_query("SELECT * FROM ".COMPANYTBL." WHERE id = '".$sdff['comp_id']."'"));
			$to = $sdff_comp['comp_email'];
			if($status == '1') // approved
				$email_data=getEmailTemplate(14);
			if ($status == '2')  // Rejected
				$email_data=getEmailTemplate(32);
			$name=$sdff_comp['comp_contact_person'];
		}
		
		// Send an Email
		$subject = $email_data['0'];
		$message= setMailContent(array($name, '', ''), $email_data['1']);
		sendMail($to,$subject,$message);
	    echo 'OK';
	}
	else
	{
		echo 'ERROR';
	}
}


if(isset($_REQUEST['offer_status']))   // offer status 
{
    $id 	= $_REQUEST['id'];
	$status = $_REQUEST['offer_status'];
	
	$query = mysql_query("update ".OFFERS." set status = '".$status."' where id = '".$id."'");
	
	if($query)
	{
	            $sdff = mysql_fetch_array(mysql_query("SELECT * FROM ".OFFERS." WHERE id = '".$id."'"));
				$sdff_comp = mysql_fetch_array(mysql_query("SELECT * FROM ".COMPANYTBL." WHERE id = '".$sdff['comp_id']."'"));
				//echo "SELECT * FROM ".COMPANYTBL." WHERE comp_id = '".$sdff['comp_id']."'";
				
			    $to = $sdff_comp['comp_email'];
	    // Send an Email to Company Email
		if($status == '1') // approved
		{
			$email_data=getEmailTemplate(15);
			$subject = $email_data['0'];
			$message= setMailContent(array($sdff_comp['comp_contact_person'], '', ''), $email_data['1']);
			sendMail($to,$subject,$message);
				
		}else if ($status == '2')  // Rejected
		{
			$email_data=getEmailTemplate(33);
			$subject = $email_data['0'];
			$message= setMailContent(array($sdff_comp['comp_contact_person'], '', ''), $email_data['1']);
			sendMail($to,$subject,$message);
		}
		echo 'OK';
	}
	else
	{
		echo 'ERROR';
	}
}

if($_GET['make_id'])
{
	$make_id=$_GET['make_id'];
	$sql=mysql_query("select * from ".VMODEL." where make_id='".$make_id."'"); 
	if(mysql_num_rows($sql))
	{?>
	<select name="model_id" id="model_id" style="width:193px; font-weight: normal;" onchange="return getType(this.value);">
    <option value="">Select Vehicle Model</option>
	<?php 
	while($model=mysql_fetch_array($sql))
	{?>
		<option value="<?php echo $model['id'];?>"><?php echo $model['model'];?></option>
	<?php 
	}?>
	</select>
	<?php }
	else
	{
		echo 'No Model For This Model.';
	}
}


if($_GET['makeid_val'])
{
	$make_id=$_GET['makeid_val'];
	$sql=mysql_query("select * from ".VMODEL." where make_id='".$make_id."'"); 
	if(mysql_num_rows($sql))
	{?>
	<select name="vehicle_model_comp" id="vehicle_model_comp" style="width:335px; font-weight: normal;" onchange="return getType(this.value);">
    <option value="">Select Vehicle Model</option>
	<?php 
	while($model=mysql_fetch_array($sql))
	{?>
		<option value="<?php echo $model['id'];?>"><?php echo $model['model'];?></option>
	<?php 
	}?>
	</select>
	<?php }
	else
	{
		echo 'No Model For This Model.';
	}
}


if($_GET['model_id'])
{
	$model_id=$_GET['model_id'];
	$sql=mysql_query("select * from ".VTYPE." where model_id='".$model_id."'"); 
	if(mysql_num_rows($sql))
	{?>
	<select name="vehicle_type_comp" id="vehicle_type_comp" style="width: 335px; font-weight: normal;">
    <option value="">Select Vehicle Type</option>
	<?php 
	while($type=mysql_fetch_array($sql))
	{?>
		<option value="<?php echo $type['id'];?>"><?php echo $type['type_name'];?></option>
	<?php 
	}?>
	</select>
	<?php }
	else
	{
		echo 'No Model For This Model.';
	}
}

if($_GET['task']=='setStatus' && $_GET['status']!='' && $_GET['reqid']!='')
{
	$status=$_GET['status'];
	$id=$_GET['reqid'];
	mysql_query("update ".REQUESTQUOTES." set status='".$status."' where id='".$id."'");
}
if($_GET['quote_id']!='')
{
	$quote_id=$_GET['quote_id'];
	$note=addslashes($_GET['note']);
	mysql_query("update ".QUOTETBL." set emp_note='".$note."' where id='".$quote_id."'");
}
if($_GET['quote_id']!='')
{
	$quote_id=$_GET['quote_id'];
	$note=addslashes($_GET['note']);
	mysql_query("update ".QUOTETBL." set emp_note='".$note."' where id='".$quote_id."'");
}
if($_GET['task']=='setCommision' && $_GET['id']!='')
{
	$id=$_GET['id'];
	$commision=$_GET['commision'];
	$tbl=$_GET['tbl'];
	mysql_query("update ".$tbl." set commision='".$commision."' where id='".$id."'");
}


// NEW UTILS
// Get Next Date
if($_POST['call_type'] == "gettermdates"){
	if($_POST['term'] != "" && $_POST['term_type'] != "" && $_POST['st_date'] != ""){
		echo date("d-m-Y",strtotime(getNextDate($_POST['term'],$_POST['term_type'],$_POST['st_date'])));
	}
}
if(isset($_REQUEST['policy_classid']) && !empty($_REQUEST['policy_classid']))
{
	$policy_classid = $_REQUEST['policy_classid'];
	$rs=mysql_query("select * from ".POLICYTYPES." where policy_id='".$policy_classid."' and status ='1' ");

	$make='';
	if(!empty($_REQUEST['addpol']) && $_REQUEST['addpol']==1){ $name= 'name="policy_type_id"'; $onchange='onchange="select_package(this.value);"';}else{ $name= 'name="policy_type"'; $onchange='';}
	if(mysql_num_rows($rs) > 0)
	{
		$make.= '<select '.$name.' id="policy_type"  '.$onchange.' style="width: 150px; font-weight: normal; padding: 3px 3px 3px 3px;"><option value="">Select Type</option>';
		while($row = mysql_fetch_array($rs)):
		$make.= '<option value="'.$row['id'].'" >'.$row['policy_type'].'</option>';
		endwhile;
		$make.="</select>";
		if($make <> '')
		{
			echo $make;	
		}
	}
	else{
		echo 0;
	}
}
if(isset($_REQUEST['request_id']) && !empty($_REQUEST['statusvalue'] ) && !empty($_REQUEST['tablename'] )){
	
	$status = $_REQUEST['statusvalue'];
	
	$tablename= $_REQUEST['tablename'];
	
	$resultq=mysql_query("update ".$tablename." set status='".$status."' where id='".$_REQUEST['request_id']."'");
	if($resultq)
	{
		echo 1;	
	}
	else
	{
		echo 0;	
	}
}

/*if(isset($_REQUEST['request_id']) && !empty($_REQUEST['statusvalue'])){
	
	$status = $_REQUEST['statusvalue'];
	
	$resultq=mysql_query("update ".POLICYQUOTES." set status='".$status."' where id='".$_REQUEST['request_id']."'");
	if($resultq)
	{
		echo 1;	
	}
	else
	{
		echo 0;	
	}
}*/
if(isset($_REQUEST['policytypeid']) && !empty($_REQUEST['policytypeid']))
{
	$policytypeid = $_REQUEST['policytypeid'];
	$rs=mysql_query("select * from ".PACKAGE." where policy_type_id='".$policytypeid."' and status ='1' ");

	$make='';
	
	if(mysql_num_rows($rs) > 0)
	{
		$make.= '<select  id="package_no" name="package_no"  style="width: 205px; font-weight: normal; padding: 3px 3px 3px 3px;"><option value="">Select Package</option>';
		while($row = mysql_fetch_array($rs)):
		$make.= '<option value="'.$row['package_no'].'" >'.$row['package_title'].'</option>';
		endwhile;
		$make.="</select>";
		if($make <> '')
		{
			echo $make;	
		}
	}
	else{
		echo 0;
	}
}

?>