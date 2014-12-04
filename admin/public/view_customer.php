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

//$user  = mysql_fetch_assoc(mysql_query("SELECT a.id as 'id',a.fname as 'fname',a.lname as 'lname',a.cust_id as 'cust_id',b.ag_fname as 'ag_fname',b.ag_lname as 'ag_lname',b.ag_code as 'ag_code',a.phone1 as 'phone1',a.email as 'email',a.created_date as 'created_date',c.is_active as 'is_active',c.uname as 'uname',c.pwd as 'pwd' FROM ".USERTBL." a,".AGENTTBL." b,".LOGINTBL." c where a.agent_id=b.id and a.id=c.uid and c.user_type='U' and a.id=".$id));

$user  = mysql_fetch_assoc(mysql_query("SELECT a.*, c.uname as 'uname',c.pwd as 'pwd' FROM ".USERTBL." a inner join ".LOGINTBL." as c where a.id=c.uid and c.user_type='U' and a.id=".$id));
?>

<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
  <tr>
    <td width="41%" bgcolor="#CCCCCC"><strong>Name:</strong></td>
    <td width="59%" bgcolor="#CCCCCC"><?php echo $user["fname"]." ".$user["lname"]; ?></td>
  </tr>
  <tr>
    <td><strong>Email:</strong></td>
    <td><?php echo $user['email']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>Phone:</strong></td>
    <td bgcolor="#CCCCCC"><?php echo $user["phone1"]; ?></td>
  </tr>
  <tr>
    <td><strong>Username:</strong></td>
    <td><?php echo $user["uname"]; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>Password:</strong></td>
    <td bgcolor="#CCCCCC"><?php echo base64_decode($user["pwd"]); ?></td>
  </tr>
  <tr>
    <td ><strong>Join Date:</strong></td>
    <td ><?php echo date("d/m/Y",strtotime($user['created_date'])); ?></td>
  </tr>
</table>