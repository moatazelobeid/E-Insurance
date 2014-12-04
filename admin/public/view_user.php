<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');
if(siteAuth($_SESSION['atype']) == 2){
	header("location:index.php?log=1");
}

$id = $_GET["id"];


$user  = mysql_fetch_array(mysql_query("SELECT * FROM ".USRTBL." WHERE id = '".$id."'"));
$login = mysql_fetch_array(mysql_query("SELECT * FROM ".LOGINTBL." WHERE uid = '".$id."' and user_type = 'S'"));

?>

<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
  <tr>
    <td width="41%" bgcolor="#CCCCCC"><strong>Name:</strong></td>
    <td width="59%" bgcolor="#CCCCCC"><?php echo $user['salutation']." ".$user["fname"]." ".$user["lname"]; ?></td>
  </tr>
  <tr>
    <td><strong>Email:</strong></td>
    <td><?php echo $user['mail_id']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>Phone:</strong></td>
    <td bgcolor="#CCCCCC"><?php echo $user["mobile_phone"]; ?></td>
  </tr>
  <tr>
    <td><strong>Username:</strong></td>
    <td><?php echo $login["uname"]; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>Password:</strong></td>
    <td bgcolor="#CCCCCC"><?php echo base64_decode($login["pwd"]); ?></td>
  </tr>
  <tr>
    <td ><strong>Join Date:</strong></td>
    <td ><?php echo date("d/m/Y",strtotime($user['create_date'])); ?></td>
  </tr>
</table>