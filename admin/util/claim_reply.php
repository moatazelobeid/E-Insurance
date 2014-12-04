<?php  
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");

if(isset($_REQUEST['reply']))  
{

    if($_REQUEST['type']=='travel')
		$table = CLAIMTRAVEL;
		
	if($_REQUEST['type']=='auto')
		$table = CLAIMAUTO;
		
	if($_REQUEST['type']=='medical')
	    $table = CLAIMMEDICAL;
	
	if($_REQUEST['type']=='malpractice')
		$table = CLAIMMALPRACTICE;


	$id 	= $_REQUEST['id'];
	$reply = $_REQUEST['reply'];
	$query = mysql_query("update ".$table." set admin_reply = '".addslashes($reply)."' where id = '".$id."'");
	$data= mysql_fetch_assoc(mysql_query("select * from ".$table." where id = '".$id."'"));
	if(mysql_affected_rows() > 0)
	{
	  	$user = mysql_fetch_assoc(mysql_query("select * from ".USERTBL." where id = '".$data['uid']."'"));
	  //mail to user when admin gives reply to his claim
		$to = $user['email'];
		$email_data=getEmailTemplate(31);
		$subject = $email_data['0'];
		$message= setMailContent(array($user['fname'], '', ''), $email_data['1']);
		sendMail($to,$subject,$message);
		
	 	echo 'Successfully Replied..';
	}else{
	  echo 'Can not Reply at this time..';
	}
}

if(isset($_POST['status']))
{
  $id = $_POST['id'];
  $type = $_POST['pol_type'];
  
    if($type=='travel')
		$table = CLAIMTRAVEL;
		
	if($type=='auto')
		$table = CLAIMAUTO;
		
	if($type=='medical')
	    $table = CLAIMMEDICAL;
	
	if($type=='malpractice')
		$table = CLAIMMALPRACTICE;
		
	$query = mysql_query("update ".$table." set status = '".$_POST['status']."' where id = '".$id."'");
	if(mysql_affected_rows() > 0)
	{
	  echo 'OK';
	}else{
	  echo 'ERROR';
	}
}
?>