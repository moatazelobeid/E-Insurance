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

$sql="select * from ".TESTIMONIALS." where id='$id'";

$result=mysql_query($sql);

$row=mysql_fetch_object($result);

$name     = stripslashes($row->name);
$name_ar  = stripslashes($row->name_ar);
$designation       = stripslashes($row->designation);
$designation_ar    = stripslashes($row->designation_ar);
$testimonial       = stripslashes($row->testimonial);
$testimonial_ar    = stripslashes($row->testimonial_ar);
$image='../upload/testimonials/'.$row->image;?>

<div style=" padding: 5px; color: #DDEEFF; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; line-height: 18px; height: 290px;">

<table width="100%" border="0">

<tr><td colspan="2">&nbsp;</td></tr>

<tr>

    <td  class="right_txt" colspan="2" align="center"></td> 

  </tr>

  <tr>

  <td width="22%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Name (En): </span></td>

  <td width="78%" align="left"><span style="color:#553FAA;"><strong><?php echo $name; ?></strong></span></td>

  </tr>

  <tr>

  <td width="22%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Designation (En):</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo $designation; ?></span></td>

  </tr>
  

  <tr>

  <td width="25%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Testimonial (En):</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo $testimonial; ?></span></td>

  </tr>
  
   <tr>

  <td width="22%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Name (Ar): </span></td>

  <td width="78%" align="left"><span style="color:#553FAA;"><strong><?php echo $name_ar; ?></strong></span></td>

  </tr>

  <tr>

  <td width="25%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Designation (Ar):</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo $designation_ar; ?></span></td>

  </tr>

  <tr>

  <td width="25%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Testimonial (Ar):</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo $testimonial_ar; ?></span></td>

  </tr>

  

</table>

</div>
