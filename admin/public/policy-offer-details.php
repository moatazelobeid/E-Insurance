<?php 
session_start();
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
if(siteAuth($_SESSION['atype']) == 2){
	header("location:index.php?log=1");
}
$id=$_GET['id'];	
$policy = mysql_fetch_assoc(mysql_query("select * from ".OFFERS." where id=".$id));

if($policy['policy_type'] == 'travel')
	$table=TRAVELPOLICY;
	
if($policy['policy_type'] == 'comprehensive')
	$table=AUTOPOLICY;
	
if($policy['policy_type'] == 'medical')
	$table=HEALTHPOLICY;
	
if($policy['policy_type'] == 'malpractice')
	$table=MALPRACTICEPOLICY;
	
$policy_title = array_shift(mysql_fetch_array(mysql_query("SELECT * FROM ".$table." WHERE comp_policy_id = '".$policy['comp_policy_id']."'")));
?>
<style>
#Menu li
{
  z-index:0;
}
.welcomearea_cd th, .welcomearea_cd td
{
	padding:4px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
</style>


<table width="50%" class="welcomearea_cd" style="width:450px;">
    <tr>
		<th colspan="3" style="font-size:14px;"> <strong>OFFER DETAILS</strong></th>
	</tr>

    <tr>
		<th width="39%" align="right">Offer ID</th>
		<td width="4%">:</td>
		<td width="57%"><?php echo $policy['offer_id'];?></td>
	</tr>
	
	<tr>
		<th width="39%" align="right">Offer Title</th>
		<td width="4%">:</td>
		<td width="57%"><?php echo $policy['title'];?></td>
	</tr>
	<tr>
		<th align="right">Policy Type </th>
		<td>:</td>
		<td><?php echo ucfirst($policy['policy_type']);?></td>
	</tr>
	<tr>
		<th align="right">Policy ID </th>
		<td>:</td>
		<td><?php echo $policy_title."  (".$policy['comp_policy_id'].")";?></td>
	</tr>
	
	<tr>
      <th align="right">offer Provided From: </th>
	  <td>:</td>
	  <td><?php echo $policy['from_date'];?> &nbsp;  <strong> &nbsp; To: &nbsp;&nbsp; </strong> <?php echo $policy['to_date'];?></td>
  </tr>
  
  <tr>
      <th align="right">Discount Amount(in %) </th>
	  <td>:</td>
	  <td><?php echo $policy['deduct_percentage'];?></td>
  </tr>
  
  </table>
