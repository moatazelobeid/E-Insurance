<?php
include_once("../../config/session.php");
include_once("../../config/functions.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');
if(siteAuth($_SESSION['atype']) == 2){
	header("location:index.php?log=1");
}

$id=$_GET['id'];

$sql="select * from ".JOBOPPORTUNITY." where id='$id'";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);

$title = stripslashes($row->title);
$title_ar = stripslashes($row->title_ar);
$description    = stripslashes($row->description);
$description_ar = stripslashes($row->description_ar);
$skills    = stripslashes($row->skills);
$skills_ar = stripslashes($row->skills_ar);
$display_date = date('d-m-Y', strtotime($row->display_date));
$expiry_date = date('d-m-Y', strtotime($row->expiry_date));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<title>Podcast Details</title>

</head>

<link href="css/style.css" rel="stylesheet" type="text/css"/>

<body>

<div style=" padding: 5px; color: #DDEEFF; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; line-height: 18px; height: 250px;">

<table width="300px" border="0" align="center">

<tr><td colspan="2">&nbsp;</td></tr>

<tr>

    <td  class="right_txt" colspan="2" align="center"></td> 

  </tr>

  <tr>

  <td width="46%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Title (En) </span></td>
  <td style="color:#2A1FAA;font-weight:bold">:</td>

  <td width="54%" align="left"><span style="color:#553FAA;"><strong><?php echo $title; ?></strong></span></td>

  </tr>

  <tr>

  <td width="46%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Description (En)</span></td>
<td style="color:#2A1FAA;font-weight:bold">:</td>
  <td align="left" ><span style="color:#336699;"><?php echo $description; ?></span></td>

  </tr>
  

  <tr>

  <td width="46%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Skills (En)</span></td>
<td style="color:#2A1FAA;font-weight:bold">:</td>
  <td align="left" ><span style="color:#336699;"><?php echo $skills; ?></span></td>

  </tr>
  
   <tr>

  <td width="46%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Title (Ar) </span></td>
	<td style="color:#2A1FAA;font-weight:bold">:</td>
  <td width="54%" align="left"><span style="color:#553FAA;"><strong><?php echo $title_ar; ?></strong></span></td>

  </tr>

  <tr>

  <td width="46%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Description (Ar)</span></td>
	<td style="color:#2A1FAA;font-weight:bold">:</td>
  <td align="left" ><span style="color:#336699;"><?php echo $description_ar; ?></span></td>

  </tr>

  <tr>

  <td width="46%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Skills (Ar)</span></td>
	<td style="color:#2A1FAA;font-weight:bold">:</td>
  <td align="left" ><span style="color:#336699;"><?php echo $skills_ar; ?></span></td>

  </tr>

  <tr>

  <td width="46%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Display Date</span></td>
	<td style="color:#2A1FAA;font-weight:bold">:</td>
  <td align="left" ><span style="color:#336699;"><?php echo $display_date; ?></span></td>

  </tr>

  <tr>

  <td width="46%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Expiry Date</span></td>
	<td style="color:#2A1FAA;font-weight:bold">:</td>
  <td align="left" ><span style="color:#336699;"><?php echo $expiry_date; ?></span></td>

  </tr>

  

</table>

</div>

</body>



</html>