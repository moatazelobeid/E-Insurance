<?php
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");

function getSubject($a,$b)
{
	$data = mysql_fetch_array(mysql_query("select * from ".ORDERQUERYTBL." where id='$a' and custid='$b'"));
	$sub = $data['subject'];
	return $sub;
}

$id = $_POST['id'];
$custid = $_POST['custid'];

$data=mysql_query("select * from ".CUSTOMER." where id='$custid'");
$res=mysql_fetch_array($data);
$name=stripslashes($res['fname']." ".$res['lname']);

echo $email=$res['email'];

$sub = getSubject($id , $custid);
echo $subject = "Reply For ".$sub;

$message = '';
$message.='Dear'.$name.',<br> Thanks For Contacting Us.<br>';
echo $message.=$_POST['message'];

$query = "update ".ORDERQUERYTBL." set status = '1' where id='$id' ";
//$suc = mysql_query($query);

if($suc)
{
	sendMail($email,$subject,$message,$from = SITE_EMAIL);
	echo "OK";		
}
else
{
	echo "ERROR";	
}

?>