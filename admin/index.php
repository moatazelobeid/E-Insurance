<?php
// includes
include_once("../config/session.php");
include_once("../config/config.php");
include_once("../config/tables.php");
include_once("../config/functions.php");

// check logout
if($_GET['st'] == "logout"){
	setLogout($_SESSION['atype']);
	unset($_SESSION['emp_type']);
	header("location:?log=1");	
}
// set logout message 
if($_GET['log'] ==1)
$msg = "Logout Successfully";
// check login
if(isset($_POST['login']))
{
	$msg = "";
	if(setLogin($_POST['un'],$_POST['pa'],$_POST['utype']) == 1){
	
	if($_SESSION['atype'] =='E')
	{
		$emp_type_id=mysql_fetch_assoc(mysql_query("select a.emp_type_id from ".EMPLOYEETBL." as a inner join ".LOGINTBL." as b on a.id=b.uid where b.user_type = '".$_SESSION['atype']."'"));
		$_SESSION['emp_type']=$emp_type_id['emp_type_id'];
	}
	// redirect to account page
	header("location:account.php");
	}else{
	$msg = "Invalid user id or password";}
}
// check page status
if(siteAuth('S') == 1){
	header("location:account.php");
}
// forgot pass
if(isset($_POST['forgot']))
{
	$email=$_POST['email'];
    //select user table
	$sq = mysql_query("SELECT id FROM ".USRTBL." WHERE mail_id = '".$email."'");
	if(mysql_num_rows($sq) > 0){
	$rs=mysql_fetch_array($sq);
	$uid=$rs['id'];
	//select login table
	$sqq = mysql_query("SELECT * FROM ".LOGINTBL." WHERE uid = '".$uid."' and user_type='S'");
	$res = mysql_fetch_object($sqq);
   // $un = $res->uname;
//	$pwd=base64_decode($res->pwd);
	// message body
    $sendmsg = "Dear User,<br><br>Your requested password info is given below.<br>--------------------------------------<br>userid: ".$res->uname."<br>Password: ".base64_decode($res->pwd)."<br>--------------------------------------<br><br>Best Regards,<br>".$config['teamtitle'];
	sendMail($email,"Password Recovery - ".$config['msgsub_suffix'],$sendmsg);
	if(sendMail)
	{
	$msgg = "Password Sent Successfully";
	}else{
	$msgg = "Password Sent Failed";
	}
	}else{
	$msgg = "Invalid Email Id";}
}
include_once("login.php");

