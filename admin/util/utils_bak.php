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
	<select name="model_id" id="model_id" style="width: 193px; font-weight: normal;">
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
		echo 'No Model For This Model. <a href="'.BASE_URL.'account.php?page=vehicle&view=model">Add</a>';
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
?>