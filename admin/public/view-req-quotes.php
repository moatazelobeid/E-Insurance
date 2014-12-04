<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/message.php");

$id=$_GET['id'];
$sql="select * from ".REQUESTQUOTES." where id=".$id;
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
?>
<table width="100%" cellpadding="2" cellspacing="2">
	<tr height="20" style="background:#000000; font-weight:bold; font-size:14px; color:#FFFFFF">
		<td colspan="2">Request Quote Details</td>
	</tr>
	<tr>
		<td><strong> Name </strong></td>
		<td><?php echo $row->name;?></td>
	</tr>
	<tr>
		<td><strong> Email </strong></td>
		<td><?php echo $row->email;?></td>
	</tr>
	<tr>
		<td><strong> Mobile Number </strong> </td>
		<td><?php echo $row->mobile_number ;?></td>
	</tr>
	<tr>
		<td><strong> Policy Type  </strong></td>
		<td><?php echo ucwords($row->policy_type);?></td>
	</tr>
	<?php 
	if($row->policy_type=='auto')
	{?>
		<tr>
			<td><strong> Coverage Type </strong> </td>
			<td><?php if($row->coverage_type_auto=='comp')echo 'Comprehensive'; if($row->coverage_type_auto=='tpl')echo 'TPL';?></td>
		</tr>
		<?php 
		if($row->coverage_type_auto=='comp')
		{?>
			<tr>
				<td><strong> Vehicle Make </strong> </td>
				<td><?php echo $row->vehicle_make_comp;?></td>
			</tr>
			<tr>
				<td><strong> Vehicle Model </strong> </td>
				<td><?php echo $row->vehicle_model_comp;?></td>
			</tr>
			<tr>
				<td><strong> Vehicle Type </strong> </td>
				<td><?php echo $row->vehicle_type_comp;?></td>
			</tr>
			<tr>
				<td><strong> Agency Repair </strong> </td>
				<td><?php if($row->is_agancy_repair_comp=='0')echo 'No'; else echo 'Yes';?></td>
			</tr>
			<tr>
				<td><strong> Number Of NCD</strong> </td>
				<td><?php echo $row->no_of_ncd_comp;?></td>
			</tr>
		<?php }
		if($row->coverage_type_auto=='tpl')
		{?>
			<tr>
				<td><strong> Vehicle Type </strong> </td>
				<td><?php echo $row->vehicle_type_tpl;?></td>
			</tr>
			<tr>
				<td><strong> Vehicle Cylender </strong> </td>
				<td><?php echo $row->vehicle_cylender_tpl;?></td>
			</tr>
			<tr>
				<td><strong> Vehicle Weight </strong> </td>
				<td><?php echo $row->vehicle_weight_tpl;?></td>
			</tr>
			<tr>
				<td><strong> Vehicle Seats </strong> </td>
				<td><?php echo $row->vehicle_seats_tpl;?></td>
			</tr>
		<?php }
	} 
	if($row->policy_type=='travel')
	{?>
		<tr>
			<td><strong> Trip Type </strong> </td>
			<td><?php echo $row->trip_type_travel;?></td>
		</tr>
		<?php if($row->trip_type_travel=='Multi')
		{?>
			<tr>
				<td><strong> Period Of Travel </strong> </td>
				<td><?php echo $row->period_of_travel;?></td>
			</tr>
		<?php } ?>
		<tr>
			<td><strong> Geographic Coverage </strong> </td>
			<td><?php echo getCoverageType($row->geo_coverage);?></td>
		</tr>
	<?php } 
	if($row->policy_type=='medical')
	{?>
		<tr>
			<td><strong> Emirate </strong> </td>
			<td><?php echo $row->emirate_medical;?></td>
		</tr>
		<tr>
			<td><strong> Coverage Type </strong> </td>
			<td><?php echo $row->coverage_type_medical;?></td>
		</tr>
	<?php }
	if($row->policy_type=='malpractice')
	{?>
		<tr>
			<td><strong> Period Of Insurance </strong> </td>
			<td><?php echo $row->period_malpractice;?></td>
		</tr>
	<?php }?>
</table>