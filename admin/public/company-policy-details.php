<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
if(siteAuth($_SESSION['atype']) == 2){
	header("location:index.php?log=1");
}
$id=$_GET['id'];
if($_GET['type']=='travel')
	$table=TRAVELPOLICY;
if($_GET['type']=='auto')
	$table=AUTOPOLICY;
if($_GET['type']=='medical')
	$table=HEALTHPOLICY;
if($_GET['type']=='malpractice')
	$table=MALPRACTICEPOLICY;
	
$policy=mysql_fetch_assoc(mysql_query("select * from ".$table." where id=".$id));
if($_GET['type']=='auto')
{
  if($policy['coverage_type'] == 'tpl'){$pol_type = '(TPL)';}elseif($policy['coverage_type'] == 'comp'){$pol_type = '(Comprehensive)';}
}
?>
<style>
.welcomearea_cd th, .welcomearea_cd td
{
	padding:5px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
}
</style>
<div style="height:480px;">

              <div  style="margin-left:7px; margin-right:7px;">
              <div class="heading_blue" style="float:left; font-weight:bold;padding:5px;">Policy Type: <?php echo strtoupper($_GET['type']); if($_GET['type']=='auto') echo $pol_type;?></div>
			  </div>
            
<?php if($_GET['type']=='travel')
{?>
<table width="100%">
<tr>
		<th width="20%">Policy  ID</th>
		<td width="1%">:</td>
		<td width="79%"><?php echo $policy['comp_policy_id'];?></td>
  </tr>
	<tr>
		<th width="20%">Title</th>
		<td width="1%">:</td>
		<td width="79%"><?php echo $policy['title'];?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td>:</td>
		<td><?php echo $policy['description'];?></td>
	</tr>
	<tr>
		<th>Policy Amount</th>
		<td>:</td>
		<td><?php echo $policy['policy_amount'];?></td>
	</tr>
	<tr>
		<th>Trip Type</th>
		<td>:</td>
		<td><?php echo $policy['trip_type'];?></td>
	</tr>
	<?php if($policy['trip_type']=='Multi')
	{?>
		<tr>
			<th>Trip Type</th>
			<td>:</td>
			<td><?php echo $policy['perid_of_travel'];?>&nbsp;Months</td>
		</tr>
	<?php }?>
	<tr>
      <th>Geographic Coverage</th>
	  <td>:</td>
	  <td><?php if($policy['geo_coverage']=='1') echo 'Worldwide excluding US and Canada';
			 if($policy['geo_coverage']=='2') echo 'Worldwide including US and Canada';
			 if($policy['geo_coverage']=='3') echo 'Schengen';
			 if($policy['geo_coverage']=='4') echo 'GCC and Jordan';?>
      </td>
  </tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<!--<tr>
				<th colspan="4">OPTIONAL COVERS </th>
			</tr>-->
			<tr style="background-color:#94DEF7; height:25px;">
				<th width="37%">OPTIONAL COVERS</th>
				<th width="12%" align="center">Status</th>
				<th width="9%" align="center">Amount</th>
				<th width="42%">Coverage</th>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Optional Covers</td>
				<td align="center"><?php if($policy['optional_covers']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['optional_covers_amt'])echo $policy['optional_covers_amt']; else echo '-';?></td>
				<td><?php if($policy['optional_covers_note'])echo $policy['optional_covers_note']; else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Adventurous Sports</td>
				<td align="center"><?php if($policy['adv_sports']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['adv_sports_amt'])echo $policy['adv_sports_amt']; else echo '-';?></td>
				<td><?php if($policy['adv_sports_note'])echo $policy['adv_sports_note']; else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Sports Activities</td>
				<td align="center"><?php if($policy['sports_activities']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['sports_activities_amt'])echo $policy['sports_activities_amt'];else echo '-';?></td>
				<td><?php if($policy['sports_activities_note'])echo $policy['sports_activities_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Hazardous Sports</td>
				<td align="center"><?php if($policy['hazard_sports']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['hazard_sports_amt']) echo $policy['hazard_sports_amt'];else echo '-';?></td>
				<td><?php if($policy['hazard_sports_note']) echo $policy['hazard_sports_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Scuba Diving</td>
				<td align="center"><?php if($policy['scuba_diving']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['scuba_diving_amt']) echo $policy['scuba_diving_amt'];else echo '-';?></td>
				<td><?php if($policy['scuba_diving_note']) echo $policy['scuba_diving_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Ski Cover</td>
				<td align="center"><?php if($policy['ski_cover']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['ski_cover_amt']) echo $policy['ski_cover_amt'];else echo '-';?></td>
				<td><?php if($policy['ski_cover_note']) echo $policy['ski_cover_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Terrorism Extension</td>
				<td align="center"><?php if($policy['terrorism_xtension']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['terrorism_xtension_amt']) echo $policy['terrorism_xtension_amt'];else echo '-';?></td>
				<td><?php if($policy['terrorism_xtension_note']) echo $policy['terrorism_xtension_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Winter Sports</td>
				<td align="center"><?php if($policy['winter_sports']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['winter_sports_amt']) echo $policy['winter_sports_amt'];else echo '-';?></td>
				<td><?php if($policy['winter_sports_note']) echo $policy['winter_sports_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Medical Cover Removal</td>
				<td align="center"><?php if($policy['medical_cover_removal']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['medical_cover_removal_amt']) echo $policy['medical_cover_removal_amt'];else echo '-';?></td>
				<td><?php if($policy['medical_cover_removal_note']) echo $policy['medical_cover_removal_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Travel Inconvenience &nbsp;&nbsp;Removal</td>
				<td align="center"><?php if($policy['travel_inconv_removal']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['travel_inconv_removal_amt']) echo $policy['travel_inconv_removal_amt'];else echo '-';?></td>
				<td><?php if($policy['travel_inconv_removal_note']) echo $policy['travel_inconv_removal_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>No Deductible Option</td>
				<td align="center"><?php if($policy['no_deductible_option']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['no_deductible_option_amt']) echo $policy['no_deductible_option_amt'];else echo '-';?></td>
				<td><?php if($policy['no_deductible_option_note']) echo $policy['no_deductible_option_note'];else echo '-';?></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th width="37%">MEDICAL SERVICES</th>
				<th width="12%" align="center">Status</th>
				<th width="9%" align="center">Amount</th>
				<th width="42%">Coverage</th>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Medical Services</td>
				<td align="center"><?php if($policy['medical_services']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['medical_services_amt']) echo $policy['medical_services_amt'];else echo '-';?></td>
				<td><?php if($policy['medical_services_note']) echo $policy['medical_services_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Guaranteed Payment of Medical</td>
				<td align="center"><?php if($policy['guaranteed_payment_of_med']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['guaranteed_payment_of_med_amt']) echo $policy['guaranteed_payment_of_med_amt'];else echo '-';?></td>
				<td><?php if($policy['guaranteed_payment_of_med_note']) echo $policy['guaranteed_payment_of_med_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Emerg Medical Evacuation</td>
				<td align="center"><?php if($policy['emerg_med_evacuation']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['emerg_med_evacuation_amt']) echo $policy['emerg_med_evacuation_amt'];else echo '-';?></td>
				<td><?php if($policy['emerg_med_evacuation_note']) echo $policy['emerg_med_evacuation_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Emergency Medical Repatriation</td>
				<td align="center"><?php if($policy['emerg_med_repatriation']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['emerg_med_repatriation_amt']) echo $policy['emerg_med_repatriation_amt'];else echo '-';?></td>
				<td><?php if($policy['emerg_med_repatriation_note']) echo $policy['emerg_med_repatriation_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Transportation of Mortal Remains</td>
				<td align="center"><?php if($policy['transport_mortal_remains']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['transport_mortal_remains_amt']) echo $policy['transport_mortal_remains_amt'];else echo '-';?></td>
				<td><?php if($policy['transport_mortal_remains_note']) echo $policy['transport_mortal_remains_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Compassionate Visit</td>
				<td align="center"><?php if($policy['compassionate_visit']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['compassionate_visit_amt']) echo $policy['compassionate_visit_amt'];else echo '-';?></td>
				<td><?php if($policy['compassionate_visit_note']) echo $policy['compassionate_visit_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Return of Minor Children</td>
				<td align="center"><?php if($policy['return_minor_children']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['return_minor_children_amt']) echo $policy['return_minor_children_amt'];else echo '-';?></td>
				<td><?php if($policy['return_minor_children_note']) echo $policy['return_minor_children_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Convalescence Expenses</td>
				<td align="center"><?php if($policy['conv_expenses']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['conv_expenses_amt']) echo $policy['conv_expenses_amt'];else echo '-';?></td>
				<td><?php if($policy['conv_expenses_note']) echo $policy['conv_expenses_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>On Travel Services</td>
				<td align="center"><?php if($policy['on_travel_services']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['on_travel_services_amt']) echo $policy['on_travel_services_amt'];else echo '-';?></td>
				<td><?php if($policy['on_travel_services_note']) echo $policy['on_travel_services_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Transport and  Accommodation</td>
				<td align="center"><?php if($policy['trans_n_accommod']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['trans_n_accommod_amt']) echo $policy['trans_n_accommod_amt'];else echo '-';?></td>
				<td><?php if($policy['trans_n_accommod_note']) echo $policy['trans_n_accommod_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Funeral Costs</td>
				<td align="center"><?php if($policy['funeral_costs']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['funeral_costs_amt']) echo $policy['funeral_costs_amt'];else echo '-';?></td>
				<td><?php if($policy['funeral_costs_note']) echo $policy['funeral_costs_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Courier of Medication</td>
				<td align="center"><?php if($policy['courier_of_medication']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['courier_of_medication_amt']) echo $policy['courier_of_medication_amt'];else echo '-';?></td>
				<td><?php if($policy['courier_of_medication_note']) echo $policy['courier_of_medication_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Dental Emergency</td>
				<td align="center"><?php if($policy['dental_emergency']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['dental_emergency_amt']) echo $policy['dental_emergency_amt'];else echo '-';?></td>
				<td><?php if($policy['dental_emergency_note']) echo $policy['dental_emergency_note'];else echo '-';?></td>
			</tr>

			<tr style="background-color:#F9F9F9;">
				<td>Premature Return</td>
				<td align="center"><?php if($policy['premature_return']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['premature_return_amt']) echo $policy['premature_return_amt'];else echo '-';?></td>
				<td><?php if($policy['premature_return_note']) echo $policy['premature_return_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Cost of First aid and Rescue</td>
				<td align="center"><?php if($policy['first_aid_cost']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['first_aid_cost_amt']) echo $policy['first_aid_cost_amt'];else echo '-';?></td>
				<td><?php if($policy['first_aid_cost_note']) echo $policy['first_aid_cost_note'];else echo '-';?></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th width="37%">TRAVEL INCONVENIENCE</th>
				<th width="12%" align="center">Status</th>
				<th width="9%" align="center">Amount</th>
				<th width="42%">Coverage</th>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Travel Inconvience</td>
				<td align="center"><?php if($policy['travel_inconvenience']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['travel_inconvenience_amt'])echo $policy['travel_inconvenience_amt'];else echo '-';?></td>
				<td><?php if($policy['travel_inconvenience_note'])echo $policy['travel_inconvenience_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Luggage Loss</td>
				<td align="center"><?php if($policy['luggage_loss']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['luggage_loss_amt'])echo $policy['luggage_loss_amt'];else echo '-';?></td>
				<td><?php if($policy['luggage_loss_note'])echo $policy['luggage_loss_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Personal Money</td>
				<td align="center"><?php if($policy['personal_money']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['personal_money_amt'])echo $policy['personal_money_amt'];else echo '-';?></td>
				<td><?php if($policy['personal_money_note'])echo $policy['personal_money_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Baggage Delay</td>
				<td align="center"><?php if($policy['baggage_delay']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['baggage_delay_amt'])echo $policy['baggage_delay_amt'];else echo '-';?></td>
				<td><?php if($policy['baggage_delay_note'])echo $policy['baggage_delay_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Flight Delay</td>
				<td align="center"><?php if($policy['flight_delay']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['flight_delay_amt'])echo $policy['flight_delay_amt'];else echo '-';?></td>
				<td><?php if($policy['flight_delay_note'])echo $policy['flight_delay_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Loss of Passport</td>
				<td align="center"><?php if($policy['loss_of_passport']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['loss_of_passport_amt'])echo $policy['loss_of_passport_amt'];else echo '-';?></td>
				<td><?php if($policy['loss_of_passport_note'])echo $policy['loss_of_passport_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Trip Cancel</td>
				<td align="center"><?php if($policy['trip_cancel']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['trip_cancel_amt'])echo $policy['trip_cancel_amt'];else echo '-';?></td>
				<td><?php if($policy['trip_cancel_note'])echo $policy['trip_cancel_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Missed Departure</td>
				<td align="center"><?php if($policy['missed_departure']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['missed_departure_amt'])echo $policy['missed_departure_amt'];else echo '-';?></td>
				<td><?php if($policy['missed_departure_note'])echo $policy['missed_departure_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Curtailment Journey</td>
				<td align="center"><?php if($policy['curtailment_journey']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['curtailment_journey_amt'])echo $policy['curtailment_journey_amt'];else echo '-';?></td>
				<td><?php if($policy['curtailment_journey_note'])echo $policy['curtailment_journey_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Hijacking</td>
				<td align="center"><?php if($policy['hijacking']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['hijacking_amt'])echo $policy['hijacking_amt'];else echo '-';?></td>
				<td><?php if($policy['hijacking_note'])echo $policy['hijacking_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Emergency Family Travel</td>
				<td align="center"><?php if($policy['emerg_family_travel']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['emerg_family_travel_amt'])echo $policy['emerg_family_travel_amt'];else echo '-';?></td>
				<td><?php if($policy['emerg_family_travel_note'])echo $policy['emerg_family_travel_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Personal Liability</td>
				<td align="center"><?php if($policy['personal_liability']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['personal_liability_amt'])echo $policy['personal_liability_amt'];else echo '-';?></td>
				<td><?php if($policy['personal_liability_note'])echo $policy['personal_liability_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Personal Accident</td>
				<td align="center"><?php if($policy['personal_accident']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['personal_accident_amt'])echo $policy['personal_accident_amt'];else echo '-';?></td>
				<td><?php if($policy['personal_accident_note'])echo $policy['personal_accident_note'];else echo '-';?></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th width="37%">PERSONAL ACCIDENT AND TOTAL DISABLEMENT</th>
				<th align="center" width="12%">Status</th>
				<th align="center" width="9%">Amount</th>
				<th width="42%">Coverage</td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td width="38%">Common Carrier</td>
				<td width="10%" align="center"><?php if($policy['common_carrier']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td width="10%" align="center"><?php if($policy['common_carrier_amt'])echo $policy['common_carrier_amt'];else echo '-';?></td>
				<td width="42%"><?php if($policy['common_carrier_note'])echo $policy['common_carrier_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>All Other Accidents</td>
				<td align="center"><?php if($policy['all_other_accidents']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['all_other_accidents_amt']) echo $policy['all_other_accidents_amt'];else echo '-';?></td>
				<td><?php if($policy['all_other_accidents_note']) echo $policy['all_other_accidents_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Permanent Loss of Sight</td>
				<td align="center"><?php if($policy['loss_of_sight']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['loss_of_sight_amt']) echo $policy['loss_of_sight_amt'];else echo '-';?></td>
				<td><?php if($policy['loss_of_sight_note']) echo $policy['loss_of_sight_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Permanent Total Disablement</td>
				<td align="center"><?php if($policy['total_disablement']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['total_disablement_amt']) echo $policy['total_disablement_amt'];else echo '-';?></td>
				<td><?php if($policy['total_disablement_note']) echo $policy['total_disablement_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Death Accident</td>
				<td align="center"><?php if($policy['death_accident']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['death_accident_amt']) echo $policy['death_accident_amt'];else echo '-';?></td>
				<td><?php if($policy['death_accident_note']) echo $policy['death_accident_note'];else echo '-';?></td>
			</tr>
		</table>
	</td>
  </tr>
</table>
<?php }
if($pol_type=='(TPL)')
{?>
<table width="100%">
<tr>
		<th width="20%">Policy ID</th>
		<td width="1%">:</td>
		<td width="79%"><?php echo $policy['comp_policy_id'];?></td>
	</tr>
	<tr>
		<th width="21%">Title</th>
		<td width="1%">:</td>
		<td width="78%"><?php echo $policy['title'];?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td>:</td>
		<td><?php echo $policy['description'];?></td>
	</tr>
	<tr>
		<th>Policy Amount</th>
		<td>:</td>
		<td><?php echo $policy['policy_amount'];?></td>
	</tr>
	<tr>
		<td colspan="3">
			<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
				<tr style="background-color:#94DEF7; height:25px;">
					<th colspan="3">Vehicle Information</th>
				</tr>
				<tr>
					<td width="21%">Vehicle Type</td>
					<td width="1%">:</td>
					<td width="78%"><?php echo $policy['vehicle_type_tpl'];?></td>
				</tr>
				<tr>
					<td width="21%">Specification (Cylinders)</td>
					<td width="1%">:</td>
					<td width="78%"><?php echo $policy['vehicle_cylender_tpl'];?></td>
				</tr>
				<tr>
					<td width="21%">Weight of the Vehicle (tons)</td>
					<td width="1%">:</td>
					<td width="78%"><?php echo $policy['vehicle_weight_tpl'];?></td>
				</tr>
				<tr>
					<td width="21%">Number of Seats</td>
					<td width="1%">:</td>
					<td width="78%"><?php echo $policy['vehicle_seats_tpl'];?></td>
				</tr>
			</table>
		</td>
	</tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th>Coverage Details</th>
				<th align="center">Status</th>
				<th align="center">Amount</th>
				<th>Coverage</th>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td width="34%">Personal Accident Benefit to Driver</td>
				<td width="12%" align="center"><?php if($policy['pab_to_driver']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td width="12%" align="center"><?php if($policy['pab_to_driver_amt'])echo $policy['pab_to_driver_amt'];else echo '-';?></td>
				<td width="42%"><?php if($policy['pab_to_driver_note'])echo $policy['pab_to_driver_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Personal Accident Benefit to Passenger</td>
				<td align="center"><?php if($policy['pab_to_passenger']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['pab_to_passenger_amt']) echo $policy['pab_to_passenger_amt'];else echo '-';?></td>
				<td><?php if($policy['pab_to_passenger_note']) echo $policy['pab_to_passenger_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Road Side Assistance Cover</td>
				<td align="center"><?php if($policy['rsa_cover']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['rsa_cover_amt']) echo $policy['rsa_cover_amt'];else echo '-';?></td>
				<td><?php if($policy['rsa_cover_note']) echo $policy['rsa_cover_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Rent A Car Benefit</td>
				<td align="center"><?php if($policy['rent_car_benefit']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['rent_car_benefit_amt']) echo $policy['rent_car_benefit_amt'];else echo '-';?></td>
				<td><?php if($policy['rent_car_benefit_note']) echo $policy['rent_car_benefit_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>FST (Fire, Storm, Tempest) Cover</td>
				<td align="center"><?php if($policy['fst_cover']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['fst_cover_amt']) echo $policy['fst_cover_amt'];else echo '-';?></td>
				<td><?php if($policy['fst_cover_note']) echo $policy['fst_cover_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Windscreen claims</td>
				<td align="center"><?php if($policy['windscreen_claims']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['windscreen_claims_amt']) echo $policy['windscreen_claims_amt'];else echo '-';?></td>
				<td><?php if($policy['windscreen_claims_note']) echo $policy['windscreen_claims_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Territory Cover</td>
				<td align="center"><?php if($policy['territory_cover']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['territory_cover_amt']) echo $policy['territory_cover_amt'];else echo '-';?></td>
				<td><?php if($policy['territory_cover_note']) echo $policy['territory_cover_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Excess</td>
				<td align="center"><?php if($policy['excess']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['excess_amt']) echo $policy['excess_amt'];else echo '-';?></td>
				<td><?php if($policy['excess_note']) echo $policy['excess_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Third Party Property Damage</td>
				<td align="center"><?php if($policy['tpp_damage']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['tpp_damage_amt']) echo $policy['tpp_damage_amt'];else echo '-';?></td>
				<td><?php if($policy['tpp_damage_note']) echo $policy['tpp_damage_note'];else echo '-';?></td>
			</tr>
		</table>
	</td>
  </tr>
</table>
<?php }
if($pol_type=='(Comprehensive)')
{?>
<table width="100%">

     <tr>
		<th width="20%">Policy ID</th>
		<td width="1%">:</td>
		<td width="79%"><?php echo $policy['comp_policy_id'];?></td>
	</tr>
	
	<tr>
		<th width="21%">Title</th>
		<td width="1%">:</td>
		<td width="78%"><?php echo $policy['title'];?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td>:</td>
		<td><?php echo $policy['description'];?></td>
	</tr>
	<tr>
		<th>Policy Amount</th>
		<td>:</td>
		<td><?php echo $policy['policy_amount'];?></td>
	</tr>
	<tr>
		<th>Vehicle Make</th>
		<td>:</td>
		<td><?php echo $policy['vehicle_make_comp'];?></td>
	</tr>
	<tr>
		<th>Vehicle Model</th>
		<td>:</td>
		<td><?php echo $policy['vehicle_model_comp'];?></td>
	</tr>
	<tr>
		<th>Vehicle Type</th>
		<td>:</td>
		<td><?php echo $policy['vehicle_type_comp'];?></td>
	</tr>
	<tr>
		<th>Agency Repair</th>
		<td>:</td>
		<td><?php if($policy['is_agency_repair']==1)echo 'Yes'; else echo 'No';?></td>
	</tr>
	<tr>
		<th>No Claims Certificate</th>
		<td>:</td>
		<td><?php echo $policy['no_of_ncd'];?></td>
	</tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th>Coverage Details</th>
				<th align="center">Status</th>
				<th align="center">Amount</th>
				<th>Coverage</th>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td width="33%">Personal Accident Benefit to Driver</td>
				<td width="13%" align="center"><?php if($policy['pab_to_driver']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td width="11%" align="center"><?php if($policy['pab_to_driver_amt'])echo $policy['pab_to_driver_amt'];else echo '-';?></td>
				<td width="43%"><?php if($policy['pab_to_driver_note'])echo $policy['pab_to_driver_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Personal Accident Benefit to Passenger</td>
				<td align="center"><?php if($policy['pab_to_passenger']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['pab_to_passenger_amt']) echo $policy['pab_to_passenger_amt'];else echo '-';?></td>
				<td><?php if($policy['pab_to_passenger_note']) echo $policy['pab_to_passenger_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Road Side Assistance Cover</td>
				<td align="center"><?php if($policy['rsa_cover']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['rsa_cover_amt']) echo $policy['rsa_cover_amt'];else echo '-';?></td>
				<td><?php if($policy['rsa_cover_note']) echo $policy['rsa_cover_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Rent A Car Benefit</td>
				<td align="center"><?php if($policy['rent_car_benefit']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['rent_car_benefit_amt']) echo $policy['rent_car_benefit_amt'];else echo '-';?></td>
				<td><?php if($policy['rent_car_benefit_note']) echo $policy['rent_car_benefit_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>FST (Fire, Storm, Tempest) Cover</td>
				<td align="center"><?php if($policy['fst_cover']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['fst_cover_amt']) echo $policy['fst_cover_amt'];else echo '-';?></td>
				<td><?php if($policy['fst_cover_note']) echo $policy['fst_cover_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Windscreen claims</td>
				<td align="center"><?php if($policy['windscreen_claims']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['windscreen_claims_amt']) echo $policy['windscreen_claims_amt'];else echo '-';?></td>
				<td><?php if($policy['windscreen_claims_note']) echo $policy['windscreen_claims_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Territory Cover</td>
				<td align="center"><?php if($policy['territory_cover']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['territory_cover_amt']) echo $policy['territory_cover_amt'];else echo '-';?></td>
				<td><?php if($policy['territory_cover_note']) echo $policy['territory_cover_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Excess</td>
				<td align="center"><?php if($policy['excess']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['excess_amt']) echo $policy['excess_amt'];else echo '-';?></td>
				<td><?php if($policy['excess_note']) echo $policy['excess_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Third Party Property Damage</td>
				<td align="center"><?php if($policy['tpp_damage']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['tpp_damage_amt']) echo $policy['tpp_damage_amt'];else echo '-';?></td>
				<td><?php if($policy['tpp_damage_note']) echo $policy['tpp_damage_note'];else echo '-';?></td>
			</tr>
		</table>
	</td>
  </tr>
</table>
<?php }
if($_GET['type']=='malpractice')
{?>
<table width="100%">

<tr>
		<th width="20%">Policy ID</th>
		<td width="1%">:</td>
		<td width="79%"><?php echo $policy['comp_policy_id'];?></td>
	</tr>
	<tr>
		<th width="21%">Title</th>
		<td width="1%">:</td>
		<td width="78%"><?php echo $policy['title'];?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td>:</td>
		<td><?php echo $policy['description'];?></td>
	</tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th colspan="3">Period Of Insurance</th>
			</tr>
			<tr>
				<th width="21%">Period of Insurance</th>
				<td width="1%">:</td>
				<td width="78%"><?php echo $policy['period'];if($policy['period']>1) echo '&nbsp;Years';?></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th colspan="3">Coverage Information</th>
			</tr>
			<tr>
				<th width="21%">Coverage Information</th>
				<td width="1%">:</td>
				<td width="78%"><?php echo $policy['coverage_details'];?></td>
			</tr>
			<tr>
				<th width="21%">Policy Amount </th>
				<td width="1%">:</td>
				<td width="78%"><?php echo $policy['policy_amount'];?></td>
			</tr>
		</table>
	</td>
  </tr>
</table>
<?php }
if($_GET['type']=='medical')
{?>
<table width="100%">
	<tr>
		<th width="21%">Title</th>
		<td width="1%">:</td>
		<td width="78%"><?php echo $policy['title'];?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td>:</td>
		<td><?php echo $policy['description'];?></td>
	</tr>
	<tr>
		<th>Policy Amount</th>
		<td>:</td>
		<td><?php echo $policy['policy_amount'];?></td>
	</tr>
	<tr>
		<th>Emirate</th>
		<td>:</td>
		<td>
			<?php echo $policy['emirate'];?>
		</td>
	</tr>
	<tr>
		<th>Area of Coverage</th>
		<td>:</td>
		<td><?php if($policy['coverage_type']=='1') echo 'Worldwide including US and Canada';
			 if($policy['coverage_type']=='2') echo 'Worldwide excluding US and Canada';
			 if($policy['coverage_type']=='3') echo 'Regional';
			 if($policy['coverage_type']=='4') echo 'Local';?>
		</td>
	</tr>
	<tr>
		<th>Excess</th>
		<td>:</td>
		<td><?php if($policy['is_excess']=='1')echo 'Yes&nbsp;&nbsp;<b>Value</b>&nbsp;:&nbsp;'.$policy['excess']; else echo 'No';?></td>
	</tr>
	<?php if($policy['doc_url'])
	{?>
	<tr>
		<th>Document Attached</th>
		<td>:</td>
		<td><?php echo '<a href="../download.php?dir=upload/health_policy&f='.$policy['doc_url'].'">'.$policy['doc_url'].'</a>';?></td>
	</tr>
	<?php }?>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th>Coverage Details</th>
				<th align="center">Status</th>
				<th align="center">Amount</th>
				<th>Coverage</th>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td width="33%">Dental</td>
				<td width="13%" align="center"><?php if($policy['dental']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td width="11%" align="center"><?php if($policy['dental_amt'])echo $policy['dental_amt'];else echo '-';?></td>
				<td width="43%"><?php if($policy['dental_note'])echo $policy['dental_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Maternity Benefit </td>
				<td align="center"><?php if($policy['maternity_benefit']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['maternity_benefit_amt']) echo $policy['maternity_benefit_amt'];else echo '-';?></td>
				<td><?php if($policy['maternity_benefit_note']) echo $policy['maternity_benefit_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Area of Cover</td>
				<td align="center"><?php if($policy['area_of_cover']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['area_of_cover_amt']) echo $policy['area_of_cover_amt'];else echo '-';?></td>
				<td><?php if($policy['area_of_cover_note']) echo $policy['area_of_cover_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Max CoverPer Annum</td>
				<td align="center"><?php if($policy['max_cover_per_annum']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['max_cover_per_annum_amt']) echo $policy['max_cover_per_annum_amt'];else echo '-';?></td>
				<td><?php if($policy['max_cover_per_annum_note']) echo $policy['max_cover_per_annum_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Chronic Medical Conditions</td>
				<td align="center"><?php if($policy['chronic_med_cond']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['chronic_med_cond_amt']) echo $policy['chronic_med_cond_amt'];else echo '-';?></td>
				<td><?php if($policy['chronic_med_cond_note']) echo $policy['chronic_med_cond_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Pre Exist Conditions</td>
				<td align="center"><?php if($policy['preexist_cond']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['preexist_cond_amt']) echo $policy['preexist_cond_amt'];else echo '-';?></td>
				<td><?php if($policy['preexist_cond_note']) echo $policy['preexist_cond_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Routine Dental </td>
				<td align="center"><?php if($policy['routine_ental']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['routine_ental_amt']) echo $policy['routine_ental_amt'];else echo '-';?></td>
				<td><?php if($policy['routine_ental_note']) echo $policy['routine_ental_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Claim</td>
				<td align="center"><?php if($policy['claim']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['claim_amt']) echo $policy['claim_amt'];else echo '-';?></td>
				<td><?php if($policy['claim_note']) echo $policy['claim_note'];else echo '-';?></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th>OUT PATIENT</th>
				<th align="center">Status</th>
				<th align="center">Amount</th>
				<th>Coverage</th>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td width="33%">Out Patient</td>
				<td width="13%" align="center"><?php if($policy['out_patient']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td width="11%" align="center"><?php if($policy['out_patient_amt'])echo $policy['out_patient_amt'];else echo '-';?></td>
				<td width="43%"><?php if($policy['out_patient_note'])echo $policy['out_patient_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Within the Network - UAE </td>
				<td align="center"><?php if($policy['with_nw_uae_out']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['with_nw_uae_out_amt']) echo $policy['with_nw_uae_out_amt'];else echo '-';?></td>
				<td><?php if($policy['with_nw_uae_out_note']) echo $policy['with_nw_uae_out_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Within the Network -   Outside UAE</td>
				<td align="center"><?php if($policy['with_nw_outuae_out']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['with_nw_outuae_out_amt']!='') echo $policy['with_nw_outuae_out_amt'];else echo '-';?></td>
				<td><?php if($policy['with_nw_outuae_out_note']) echo $policy['with_nw_outuae_out_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Outside Network - Within   UAE </td>
				<td align="center"><?php if($policy['non_nw_uae_out']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['non_nw_uae_out_amt']) echo $policy['non_nw_uae_out_amt'];else echo '-';?></td>
				<td><?php if($policy['non_nw_uae_out_note']) echo $policy['non_nw_uae_out_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Outside Network - Outside   UAE</td>
				<td align="center"><?php if($policy['non_nw_outuae_out']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['non_nw_outuae_out_amt']) echo $policy['non_nw_outuae_out_amt'];else echo '-';?></td>
				<td><?php if($policy['non_nw_outuae_out_note']) echo $policy['non_nw_outuae_out_note'];else echo '-';?></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr> 
  	<td colspan="3">
		<table width="100%" style="margin-top:10px;" cellpadding="2" cellspacing="2">
			<tr style="background-color:#94DEF7; height:25px;">
				<th>IN PATIENT</th>
				<th align="center">Status</th>
				<th align="center">Amount</th>
				<th>Coverage</th>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td width="33%">In Patient</td>
				<td width="13%" align="center"><?php if($policy['in_patient']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td width="11%" align="center"><?php if($policy['in_patient_amt'])echo $policy['in_patient_amt'];else echo '-';?></td>
				<td width="43%"><?php if($policy['in_patient_note'])echo $policy['in_patient_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Within the Network - UAE </td>
				<td align="center"><?php if($policy['with_nw_uae_in']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['with_nw_uae_in_amt']) echo $policy['with_nw_uae_in_amt'];else echo '-';?></td>
				<td><?php if($policy['with_nw_uae_in_note']) echo $policy['with_nw_uae_in_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Within the Network -   Outside UAE</td>
				<td align="center"><?php if($policy['with_nw_outuae_in']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['with_nw_outuae_in_amt']) echo $policy['with_nw_outuae_in_amt'];else echo '-';?></td>
				<td><?php if($policy['with_nw_outuae_in_note']) echo $policy['with_nw_outuae_in_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F9F9F9;">
				<td>Outside Network - Within   UAE </td>
				<td align="center"><?php if($policy['non_nw_uae_in']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['non_nw_uae_in_amt']) echo $policy['non_nw_uae_in_amt'];else echo '-';?></td>
				<td><?php if($policy['non_nw_uae_in_note']) echo $policy['non_nw_uae_in_note'];else echo '-';?></td>
			</tr>
			<tr style="background-color:#F2FBFF;">
				<td>Outside Network - Outside   UAE</td>
				<td align="center"><?php if($policy['non_nw_outuae_in']=='1') echo 'Covered'; else echo 'Not Covered';?>
				<td align="center"><?php if($policy['non_nw_outuae_in_amt']) echo $policy['non_nw_outuae_in_amt'];else echo '-';?></td>
				<td><?php if($policy['non_nw_outuae_in_note']) echo $policy['non_nw_outuae_in_note'];else echo '-';?></td>
			</tr>
		</table>
	</td>
  </tr>
</table>
<?php }
?>
</div>