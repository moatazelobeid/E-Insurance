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

$sql="select * from ".MEDICALQUOTES." where id='$id'";

$result=mysql_query($sql);

$row=mysql_fetch_object($result);
function getNetorkClassName($id)
{
	$res = mysql_fetch_array(mysql_query("select nw_class from ".NETWORKCLASS." where id=".$id));
	return stripslashes($res['nw_class']);
}
?>

  

<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
    <tr>
      	<td width="50%" valign="top" style="padding-right: 10px;"> 
		
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    
  </table>		
		
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Quote Details:</strong>
	</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
    	<td style="padding: 5px;">
        	<table width="100%" border="0" cellspacing="6" cellpadding="0" style="margin-bottom: 0px;">
            	<tr>
                <td width="49%"><strong>Quote Key: </strong></td>
                <td width="51%"><?php echo (!empty($row->quote_key))?$row->quote_key:'N/a'; ?></td>
                </tr>
                  <tr>
                    <td width="49%" align="left" style="border-bottom: 0px solid #99C;"><strong>Insurance type:</strong></td>
                    <td width="51%">Medical</td>
                  </tr>
                <tr>
                <td width="49%"><strong>Policy class:</strong></td>
                <td width="51%"><?php
					  $classid = $row->policy_class_id;
					   $policyclass = mysql_fetch_array(mysql_query("select * from ".POLICIES." where id='$classid'"));
					   echo $policyclass['title']; ?></td>
                </tr>
                
                <tr>
                <td width="49%"><strong>Date Of Birth:</strong></td>
                <td width="51%"><?php echo (!empty($row->dob))?date('d-m-Y',strtotime($row->driver_age)):'N/A'; ?></td>
                </tr>
                
                
                <tr>
                <td width="49%"><strong>Gender:</strong></td>
                <td width="51%"><?php echo ($row->gender==1)?'Female':'Male'; ?></td>
                </tr>
                
                <tr>
                <td width="49%"><strong>Network Class:</strong></td>
                <td width="51%"><?php echo (!empty($row->network_class))?getNetorkClassName($row->network_class):'N/A'; ?></td>
                </tr>
               
                
                <tr>
                <td width="49%"><strong>Pre- Existing / Chronoc Diseases:</strong></td>
                <td width="51%"><?php echo (!empty($row->chronoc_diseases))?$row->chronoc_diseases:'N/A'; ?></td>
                </tr>
               
                 
                <tr>
                <td width="49%"><strong>Mobile Number:</strong></td>
                <td width="51%"><?php echo (!empty($row->mobile_no))?$row->mobile_no:'N/A'; ?></td>
                </tr>
               
              
			</table>
		</td>
    </tr>
</table>
	 
    </tr>
</table>