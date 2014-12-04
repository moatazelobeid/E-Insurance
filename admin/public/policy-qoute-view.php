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

$sql="select * from ".POLICYQUOTES." where id='$id'";

$result=mysql_query($sql);

$row=mysql_fetch_object($result);
function getDriverAge($id)
{
	$res = mysql_fetch_object(mysql_query("select age from ".DRIVERAGE." where id=".$id));
	return $res->age;
}
function getVehicleUse($type_id)
{
	//$res = mysql_fetch_object(mysql_query("select a.age from ".DRIVERAGE." as a inner join ".VTYPE." as b on a.id=b.vehicle_use where b.id=".$type_id));
	$res = mysql_fetch_object(mysql_query("select name from ".POLICYUSE." where id=".$type_id));
	return $res->name;
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
                    <td width="51%"><?php
                      $typeid = $row->policy_type_id;
                       $policytype = mysql_fetch_array(mysql_query("select * from ".POLICYTYPES." where id='$typeid'"));
                      
                      echo $policytype['policy_type']; ?></td>
                  </tr>
                <tr>
                <td width="49%"><strong>Policy class:</strong></td>
                <td width="51%"><?php
					  $classid = $row->policy_class_id;
					   $policyclass = mysql_fetch_array(mysql_query("select * from ".POLICIES." where id='$classid'"));
					   echo $policyclass['title']; ?></td>
                </tr>
                
                <tr>
                <td width="49%"><strong>Driver Age:</strong></td>
                <td width="51%"><?php echo (!empty($row->driver_age))?getDriverAge($row->driver_age):'N/A'; ?></td>
                </tr>
                
                
                <tr>
                <td width="49%"><strong>Driver License issuing Date:</strong></td>
                <td width="51%"><?php echo (!empty($row->driver_license_issue_date))?date('d/m/Y',strtotime($row->driver_license_issue_date)):'N/A'; ?></td>
                </tr>
               
				<?php if($row->policy_type_id == 1)
						{ ?>
                 <tr>
                    <td width="49%"><strong>Vehicle type:</strong></td>
                    <td width="51%"><?php
					  $vtypeid = $row->vehicle_type_tpl;
					   $vehicletype = mysql_fetch_array(mysql_query("select * from ".VTYPE." where id='$vtypeid'"));
					   echo $vehicletype['type_name']; ?></td>
                </tr>
                <tr>
                <td width="49%"><strong>Vehicle use:</strong></td>
                <td width="51%"><?php echo (!empty($row->vehicle_use))?getVehicleUse($row->vehicle_use):'N/a'; ?></td>
                </tr>
				<tr>
                <td width="49%"><strong>Claim Paid:</strong></td>
                <td width="51%"><?php echo (!empty($row->vehicle_ncd))?$row->vehicle_ncd:'N/a'; ?></td>
                </tr>
                <tr>
                <td width="49%"><strong>Mobile Number:</strong></td>
                <td width="51%"><?php echo (!empty($row->mobile_no))?$row->mobile_no:'N/a'; ?></td>
                </tr>
                
					<?php }elseif($row->policy_type_id == 2) 
					{?>
                 <tr>
                <td width="49%"><strong>Vehicle Make:</strong></td>
                <td width="51%"><?php 
				 $vmakeid = $row->vehicle_make;
					   $vehicletype = mysql_fetch_array(mysql_query("select * from ".VMAKE." where id='$vmakeid'"));
					echo (!empty($row->vehicle_make))?$vehicletype['make']:'N/a'; ?></td>
                </tr>
                   
                   <tr>
                <td width="49%"><strong>Vehicle Model:</strong></td>
                <td width="51%"><?php  $vmodelid = $row->vehicle_model;
					   $vehiclemodel = mysql_fetch_array(mysql_query("select * from ".VMODEL." where id='$vmodelid'"));
					echo (!empty($row->vehicle_model))?$vehiclemodel['model']:'N/a';  ?></td>
                </tr>
                <tr>
                <td width="49%"><strong>Vehicle Agency Repair:</strong></td>
                <td width="51%"><?php echo (!empty($row->vehicle_agency_repair))?$row->vehicle_agency_repair:'N/a'; ?></td>
                </tr>
                <tr>
                <td width="49%"><strong>Claim Paid:</strong></td>
                <td width="51%"><?php echo (!empty($row->vehicle_ncd))?$row->vehicle_ncd:'N/a'; ?></td>
                </tr>
              <tr>
                <td width="49%"><strong>Mobile Number:</strong></td>
                <td width="51%"><?php echo (!empty($row->mobile_no))?$row->mobile_no:'N/a'; ?></td>
                </tr>
                    <?php } ?>
			</table>
		</td>
    </tr>
</table>
<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Drivers Details:</strong>
	</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
      	<td style="padding: 5px;">
        <table width="100%" border="0" cellspacing="6" cellpadding="0" style="margin-bottom: 0px;">
        <tr>
        <td width="42%"><strong>First Name:</strong></td>
        <td width="58%"><?php echo (!empty($row->first_name))?$row->first_name:'N/a'; ?></td>
        </tr>
        <tr>
            <td><strong>Last Name:</strong></td>
            <td><?php echo (!empty($row->last_name))?$row->last_name:'N/a'; ?></td>
        </tr>
        <tr>
            <td><strong>Date Of Birth:</strong></td>
            <td><?php echo (!empty($row->dob))?date('d/m/y',strtotime($row->dob)):'N/a'; ?></td>
        </tr>
       
        <tr>
            <td><strong>Email:</strong></td>
            <td><?php echo (!empty($row->email))?$row->email:'N/a'; ?></td>
        </tr>
        <tr>
            <td><strong>Mobile no:</strong></td>
            <td><?php echo (!empty($row->mobile_no))?$row->mobile_no:'N/a'; ?></td>
        </tr>
        <tr>
            <td><strong>Country:</strong></td>
            <td><?php echo (!empty($row->country))?$row->country:'N/a'; ?></td>
        </tr>
        <tr>
            <td><strong>Send date:</strong></td>
            <td><?php echo (!empty($row->created_date))?date('d/m/y',strtotime($row->created_date)):'N/a'; ?></td>
        </tr>
         <tr>
            <td><strong>Status:</strong></td>
            <td><?php echo (!empty($row->status))?$row->status:'N/a'; ?></td>
        </tr>
        </table>
        </td>
       </tr>
</table><?php */?>


	 
    </tr>
</table>