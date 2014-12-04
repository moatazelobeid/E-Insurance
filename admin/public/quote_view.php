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
$id=$_GET['id'];

$sql="select * from ".QUOTETBL." where id=".$id;
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
?>
<div style=" padding: 5px; color: #DDEEFF; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; line-height: 18px; height: 290px;">

<table width="400" border="0">

<tr><td colspan="2">&nbsp;</td></tr>

<tr>

    <td  class="right_txt" colspan="2" align="center"></td> 

  </tr>

  <tr>

  <td width="62%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Company Name: </span></td>

  <td width="38%" align="left" valign="top"><span style="color:#553FAA;"><?php echo stripslashes($row->company_name); ?></span></td>

  </tr>

  <tr>

  <td width="62%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Number Of Employees:</span></td>

  <td align="left"  valign="top"><span style="color:#336699;"><?php echo stripslashes($row->no_of_emp); ?></span></td>

  </tr>
  

  <tr>

  <td width="62%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Type Of Insurance:</span></td>

  <td align="left"  valign="top"><span style="color:#336699;"><?php echo ucwords(stripslashes($row->insurance_type)); ?></span></td>

  </tr>
  
   <tr>

  <td width="62%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Address: </span></td>

  <td width="38%" align="left" valign="top"><span style="color:#553FAA;"><?php echo stripslashes($row->address); ?></span></td>

  </tr>

  <tr>

  <td width="62%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Email:</span></td>

  <td align="left"  valign="top"><span style="color:#336699;"><?php echo stripslashes($row->email); ?></span></td>

  </tr>

  <tr>

  <td width="62%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Contact Person:</span></td>

  <td align="left"  valign="top"><span style="color:#336699;"><?php echo stripslashes($row->contact_person); ?></span></td>

  </tr>

  <tr>

  <td width="62%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Phone Number:</span></td>

  <td align="left"  valign="top"><span style="color:#336699;"><?php echo stripslashes($row->phone_no); ?></span></td>

  </tr>

  <tr>

  <td width="62%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Comment :</span></td>

  <td align="left"  valign="top"><span style="color:#336699;"><?php echo stripslashes($row->comments); ?></span></td>

  </tr>

  

</table>

</div>
