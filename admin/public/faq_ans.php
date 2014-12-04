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

$sql="select * from ".TBLFAQ." where rid='$id'";

$result=mysql_query($sql);

$row=mysql_fetch_object($result);

$quest     = stripslashes($row->quest);
$quest_ar  = stripslashes($row->quest_ar);
$ans       = stripslashes($row->ans);
$ans_ar    = stripslashes($row->ans_ar);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<title>Podcast Details</title>

</head>

<link href="css/style.css" rel="stylesheet" type="text/css"/>

<body>

<div style=" padding: 5px; color: #DDEEFF; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; line-height: 18px; height: 290px;">

<table width="100%" border="0">

<tr><td colspan="2">&nbsp;</td></tr>

<tr>

    <td  class="right_txt" colspan="2" align="center"></td> 

  </tr>

  <tr>

  <td width="22%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Question (En): </span></td>

  <td width="78%" align="left"><span style="color:#553FAA;"><strong><?php echo $quest; ?> ?</strong></span></td>

  </tr>

  <tr>

  <td width="22%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Answer (En):</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo $ans; ?></span></td>

  </tr>
  
  
   <tr>

  <td width="22%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Question (Ar): </span></td>

  <td width="78%" align="left"><span style="color:#553FAA;"><strong><?php echo $quest_ar; ?> ?</strong></span></td>

  </tr>

  <tr>

  <td width="22%" align="right" valign="top"><span style="color:#2A1FAA;font-weight:bold">Answer (Ar):</span></td>

  <td align="left" ><span style="color:#336699;"><?php echo $ans_ar; ?></span></td>

  </tr>

  

</table>

</div>

</body>



</html>