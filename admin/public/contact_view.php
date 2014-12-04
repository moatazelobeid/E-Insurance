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

$sql="select * from ".CONTACTS." where id=".$id;
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
?>


<div style=" padding: 5px; color: #DDEEFF; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; line-height: 18px; height: 290px; overflow:auto;">

<table width="100%" border="0">

<tr><td colspan="2">&nbsp;</td></tr>

<tr>

    <td  class="right_txt" colspan="2" align="center"></td> 

  </tr>

  <tr>

  <td width="22%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Full Name: </span></td>

  <td width="78%" align="left"><span style="color:#553FAA;"><?php echo stripslashes($row->name); ?></span></td>

  </tr>

  <tr>

  <td width="35%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Email Id:</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo stripslashes($row->email); ?></span></td>

  </tr>
  

  <tr>

  <td width="25%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Telephone:</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo ucwords(stripslashes($row->phone)); ?></span></td>

  </tr>
  
   <tr>

  <td width="22%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Current Location: </span></td>

  <td width="78%" align="left"><span style="color:#553FAA;"><?php echo stripslashes($row->current_location); ?></span></td>

  </tr>

  <tr>

  <td width="25%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Permanent Location:</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo stripslashes($row->permanent_location); ?></span></td>

  </tr>

  <tr>

  <td width="25%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">State:</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo stripslashes($row->state); ?></span></td>

  </tr>

  <tr>

  <td width="25%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Subject:</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo stripslashes($row->subject); ?></span></td>

  </tr>

  <tr>

  <td width="25%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Comments :</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo stripslashes($row->comments); ?></span></td>

  </tr>

  

</table>

</div>
