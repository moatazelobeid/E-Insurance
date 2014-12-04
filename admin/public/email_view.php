<?php

include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
if(siteAuth($_SESSION['atype']) == 2){
	header("location:index.php?log=1");
}
$id=$_GET['id'];

$sql="select * from ".EMAILTEMP." where id='$id'";

$result=mysql_query($sql);

$row=mysql_fetch_object($result);

$email_name=$row->email_name;

$subject=$row->subject;

$body=stripslashes($row->body);



?>


<table width="100%" border="0">

<tr><td colspan="2">&nbsp;</td></tr>
<tr>
    <td  class="right_txt" colspan="2" align="center"></td> 

  </tr>

  
  <tr>

  <td width="24%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Subject:</span></td>

  <td width="76%" align="left"><span style="color:#553FAA;"><strong><?php echo $subject; ?></strong></span></td>

  </tr>

  <tr>

  <td width="24%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Message:</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo $body; ?></span></td>

  </tr>

</table>

