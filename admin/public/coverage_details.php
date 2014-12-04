<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');

$policy_no=$_GET['id'];

$user_policy=mysql_fetch_assoc(mysql_query("select * from ".USERPOLICY." where policy_no='".$policy_no."'"));
$policy_type=$user_policy['policy_type'];
if($policy_type=='travel')
{
	$data=mysql_fetch_assoc(mysql_query("select * from ".USERTRAVELPOLICY." where  policy_no='".$policy_no."'"));
	$total=mysql_num_rows(mysql_query("select * from ".USERPOLICYTRAVELLERS." where policy_no='".$policy_no."'"));
}
if($policy_type=='medical')
{
	$data=mysql_fetch_assoc(mysql_query("select * from ".USERHEALTHPOLICY." where  policy_no='".$policy_no."'"));
	$total=mysql_num_rows(mysql_query("select * from ".USERHEALTHPOLICYMEMBERS." where policy_no='".$policy_no."'"));
}

if($policy_type=='auto')
{
	$data=mysql_fetch_assoc(mysql_query("select * from ".USERAUTOPOLICY." where  policy_no='".$policy_no."'"));
}
?>
<style type="text/css">
	.maindiv
	{
		width:750px;
		height:480px;
		margin:0 auto;
		overflow:auto;
	}
	.head_title
	
	{
		width:730px;
		height:30px;
		margin-right:10px;
		margin-left:10px;
		font-family:Arial, Helvetica, sans-serif;
		font-size:16px;
		color:#FFFFFF;
		font-weight:bold;
		padding-left:15px;
		padding-top:5px;
		background: #01789f;
	}
	.head_title2
	{
		width:745px;
		height:20px;
		margin-right:10px;
		margin-left:10px;
		padding-top:10px;
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		color:#666666;
		text-align:center;
		font-weight:600;
	}
	.inner_div
	{
		width:745px;
		height:30px;
		margin-right:10px;
		margin-left:10px;
		font-family:Arial, Helvetica, sans-serif;
		font-size:14px;
		color:#666666;
		text-align:center;
		font-weight:600;
		margin-bottom:5px;
	}
	.inner_div_content
	{
		width:735px;
		height:22px;
		margin-bottom:10px;
		margin-right:10px;
		margin-left:10px;
		padding-left:10px;
		padding-top:8px;
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		color:#005D79;
		text-align:left;
		background-color:#ebf5fe;
	}
	.leftbar
	{
		width:358px;
		height:25px;
		float:left;
		padding-top:5px;
		padding-left:10px;
		border:1px solid #c0d1db ;
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		text-align:left;
		font-weight:normal;
		color:#4d4d4d;
	}
	.leftbar:hover
	{
		background-color:#cce8fd;
	}
	.submit_popup
	{
		background-color: #0085B2;
		width:100px;
		height: 30px;
		border: none;
		font-family: Arial, Helvetica, sans-serif;
		font-weight: bold;
		font-size: 12px;
		cursor: pointer;
		border-radius: 4px;
		border-radius:4px;
		color:#FFFFFF;
	}
	.submit_popup:hover
	{
		background-color: #029dd1;
		width:100px;
		height: 30px;
		border: none;
		font-family: Arial, Helvetica, sans-serif;
		font-weight: bold;
		font-size: 12px;
		cursor: pointer;
		border-radius: 4px;
		border-radius:4px;
		color:#FFFFFF;
	}
</style>
<div class="maindiv">
	<div class="head_title">Summary</div>
	<div class="head_title2"><?php echo $data['title'].'&nbsp;&nbsp;';
	if($total){echo $total*$data['policy_amount'];}else{echo $data['policy_amount'];} echo CURRENCY;?>  </div>
	<div style="clear:both; height:5px;"></div>
<?php if($policy_type=='travel')
{?>
	<div class="inner_div_content">
		<div style="width:370px; float:left">OPTIONAL COVERS</div> 
		<?php if($data['optional_covers_note'])echo $data['optional_covers_note']; else  echo 'Not Covered';?>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Adventurous Sports</div>
		<div class="leftbar"><?php if($data['adv_sports_note'])echo $data['adv_sports_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Sports Activities</div>
		<div class="leftbar"><?php if($data['sports_activities_note'])echo $data['sports_activities_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Hazardous Sports</div>
		<div class="leftbar"><?php if($data['hazard_sports_note'])echo $data['hazard_sports_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Scuba Diving</div>
		<div class="leftbar"><?php if($data['scuba_diving_note'])echo $data['scuba_diving_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Ski Cover</div>
		<div class="leftbar"><?php if($data['ski_cover_note'])echo $data['ski_cover_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Terrorism Extension</div>
		<div class="leftbar"><?php if($data['terrorism_xtension_note'])echo $data['terrorism_xtension_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Winter Sports</div>
		<div class="leftbar"><?php if($data['winter_sports_note'])echo $data['winter_sports_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Medical Cover Removal</div>
		<div class="leftbar"><?php if($data['medical_cover_removal_note'])echo $data['medical_cover_removal_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Travel Inconvenience Removal</div>
		<div class="leftbar"><?php if($data['travel_inconv_removal_note'])echo $data['travel_inconv_removal_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">No Deductible Option</div>
		<div class="leftbar"><?php if($data['no_deductible_option_note'])echo $data['no_deductible_option_note']; else  echo 'Not Covered';?></div>
	</div>
	
	<div class="inner_div_content">
		<div style="width:370px; float:left">MEDICAL SERVICES AND BENEFITS</div> 
		<?php if($data['medical_services_note'])echo $data['medical_services_note']; else  echo 'Not Covered';?>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Guaranteed Payment of Medical </div>
		<div class="leftbar"><?php if($data['guaranteed_payment_of_med_note'])echo $data['guaranteed_payment_of_med_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Emerg Medical Evacuation </div>
		<div class="leftbar"><?php if($data['emerg_med_evacuation_note'])echo $data['emerg_med_evacuation_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Emergency Medical Repatriation </div>
		<div class="leftbar"><?php if($data['emerg_med_repatriation_note'])echo $data['emerg_med_repatriation_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Transportation of Mortal Remains </div>
		<div class="leftbar"><?php if($data['transport_mortal_remains_note'])echo $data['transport_mortal_remains_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Compassionate Visit </div>
		<div class="leftbar"><?php if($data['compassionate_visit_note'])echo $data['compassionate_visit_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Return of Minor Children</div>
		<div class="leftbar"><?php if($data['return_minor_children_note'])echo $data['return_minor_children_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Convalescence Expenses</div>
		<div class="leftbar"><?php if($data['conv_expenses_note'])echo $data['conv_expenses_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">On Travel Services</div>
		<div class="leftbar"><?php if($data['on_travel_services_note'])echo $data['on_travel_services_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Transport and Accommodation</div>
		<div class="leftbar"><?php if($data['trans_n_accommod_note'])echo $data['trans_n_accommod_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Funeral Costs</div>
		<div class="leftbar"><?php if($data['funeral_costs_note'])echo $data['funeral_costs_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Courier of Medication</div>
		<div class="leftbar"><?php if($data['courier_of_medication_note'])echo $data['courier_of_medication_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Dental Emergency</div>
		<div class="leftbar"><?php if($data['dental_emergency_note'])echo $data['dental_emergency_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Premature Return</div>
		<div class="leftbar"><?php if($data['premature_return_note'])echo $data['premature_return_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Cost of First aid and Rescue</div>
		<div class="leftbar"><?php if($data['first_aid_cost_note'])echo $data['first_aid_cost_note']; else  echo 'Not Covered';?></div>
	</div>
	
	<div class="inner_div_content">
		<div style="width:370px; float:left">TRAVEL INCONVENIENCE</div> 
		<?php if($data['travel_inconvenience_note'])echo $data['travel_inconvenience_note']; else  echo 'Not Covered';?>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Luggage Loss </div>
		<div class="leftbar"><?php if($data['luggage_loss_note'])echo $data['luggage_loss_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Personal Money </div>
		<div class="leftbar"><?php if($data['personal_money_note'])echo $data['personal_money_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Baggage Delay </div>
		<div class="leftbar"><?php if($data['baggage_delay_note'])echo $data['baggage_delay_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Flight Delay </div>
		<div class="leftbar"><?php if($data['flight_delay_note'])echo $data['flight_delay_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Loss of Passport </div>
		<div class="leftbar"><?php if($data['loss_of_passport_note'])echo $data['loss_of_passport_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Trip Cancel</div>
		<div class="leftbar"><?php if($data['trip_cancel_note'])echo $data['trip_cancel_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Missed Departure</div>
		<div class="leftbar"><?php if($data['missed_departure_note'])echo $data['missed_departure_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Curtailment Journey</div>
		<div class="leftbar"><?php if($data['curtailment_journey_note'])echo $data['curtailment_journey_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Hijacking</div>
		<div class="leftbar"><?php if($data['hijacking_note'])echo $data['hijacking_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Emergency Family Travel</div>
		<div class="leftbar"><?php if($data['emerg_family_travel_note'])echo $data['emerg_family_travel_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Personal Liability </div>
		<div class="leftbar"><?php if($data['personal_liability_note'])echo $data['personal_liability_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Personal Accident</div>
		<div class="leftbar"><?php if($data['personal_accident_note'])echo $data['personal_accident_note']; else  echo 'Not Covered';?></div>
	</div>
	
	<div class="inner_div_content">PERSONAL ACCIDENT AND TOTAL DISABLEMENT </div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Common Carrier</div>
		<div class="leftbar"><?php if($data['common_carrier_note'])echo $data['common_carrier_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">All Other Accidents </div>
		<div class="leftbar"><?php if($data['all_other_accidents_note'])echo $data['all_other_accidents_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Permanent Loss of Sight</div>
		<div class="leftbar"><?php if($data['loss_of_sight_note'])echo $data['loss_of_sight_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Permanent Total Disablement</div>
		<div class="leftbar"><?php if($data['total_disablement_note'])echo $data['total_disablement_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Death Accident </div>
		<div class="leftbar"><?php if($data['death_accident_note'])echo $data['death_accident_note']; else  echo 'Not Covered';?></div>
	</div>
<?php }
if($policy_type=='medical')
{?>
	<div class="inner_div_content">
		<div style="width:370px; float:left">DENTAL</div> 
		<?php if($data['dental_note'])echo $data['dental_note']; else  echo 'Not Covered';?>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Maternity Benefit </div>
		<div class="leftbar"><?php if($data['maternity_benefit_note'])echo $data['maternity_benefit_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Area of Cover </div>
		<div class="leftbar"><?php if($data['area_of_cover_note'])echo $data['area_of_cover_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Max CoverPer Annum </div>
		<div class="leftbar"><?php if($data['max_cover_per_annum_note'])echo $data['max_cover_per_annum_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Chronic Medical Conditions </div>
		<div class="leftbar"><?php if($data['chronic_med_cond_note'])echo $data['chronic_med_cond_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Pre Exist Conditions </div>
		<div class="leftbar"><?php if($data['preexist_cond_note'])echo $data['preexist_cond_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Routine Dental </div>
		<div class="leftbar"><?php if($data['routine_ental_note'])echo $data['routine_ental_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Claim </div>
		<div class="leftbar"><?php if($data['claim_note'])echo $data['claim_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div_content">
		<div style="width:370px; float:left">OUT PATIENT</div> 
		<?php if($data['out_patient_note'])echo $data['out_patient_note']; else  echo 'Not Covered';?>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Within the Network - UAE</div>
		<div class="leftbar"><?php if($data['with_nw_uae_out_note'])echo $data['with_nw_uae_out_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Within the Network -   Outside UAE </div>
		<div class="leftbar"><?php if($data['with_nw_outuae_out_note'])echo $data['with_nw_outuae_out_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Outside Network - Within   UAE </div>
		<div class="leftbar"><?php if($data['non_nw_uae_out_note'])echo $data['non_nw_uae_out_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Outside Network - Outside   UAE</div>
		<div class="leftbar"><?php if($data['non_nw_outuae_out_note'])echo $data['non_nw_outuae_out_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div_content">
		<div style="width:370px; float:left">IN PATIENT</div> 
		<?php if($data['in_patient_note'])echo $data['in_patient_note']; else  echo 'Not Covered';?>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Within the Network - UAE</div>
		<div class="leftbar"><?php if($data['with_nw_uae_in_note'])echo $data['with_nw_uae_in_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Within the Network -   Outside UAE </div>
		<div class="leftbar"><?php if($data['with_nw_outuae_in_note'])echo $data['with_nw_outuae_in_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Outside Network - Within   UAE </div>
		<div class="leftbar"><?php if($data['non_nw_uae_in_note'])echo $data['non_nw_uae_in_note']; else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Outside Network - Outside   UAE</div>
		<div class="leftbar"><?php if($data['non_nw_outuae_in_note'])echo $data['non_nw_outuae_in_note']; else  echo 'Not Covered';?></div>
	</div>
<?php }

if($policy_type=='auto')
{?>
	<div class="inner_div_content">
		<div style="width:370px; float:left">COVERAGE DETAILS</div> 
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Personal Accident Benefit to Driver </div>
		<div class="leftbar"><?php if($data['pab_to_driver_note'])echo stripslashes($data['pab_to_driver_note']); else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Personal Accident Benefit to Passenger</div>
		<div class="leftbar"><?php if($data['pab_to_passenger_note'])echo stripslashes($data['pab_to_passenger_note']); else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Road Side Assistance Cover </div>
		<div class="leftbar"><?php if($data['rsa_cover_note'])echo stripslashes($data['rsa_cover_note']); else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Rent A Car Benefit </div>
		<div class="leftbar"><?php if($data['rent_car_benefit_note'])echo stripslashes($data['rent_car_benefit_note']); else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">FST (Fire, Storm, Tempest) Cover </div>
		<div class="leftbar"><?php if($data['fst_cover_note'])echo stripslashes($data['fst_cover_note']); else  echo 'Not Covered';?></div>
	</div>
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Windscreen claims </div>
		<div class="leftbar"><?php if($data['windscreen_claims_note'])echo stripslashes($data['windscreen_claims_note']); else  echo 'Not Covered';?></div>
	</div>
	
	<div class="inner_div">
		<div class="leftbar" style="margin-right:5px;">Third Party Property Damage </div>
		<div class="leftbar"><?php if($data['tpp_damage_note'])echo stripslashes($data['tpp_damage_note']); else  echo 'Not Covered';?></div>
	</div>
	
<?php }?>
	<div style="clear:both; height:10px;">&nbsp;</div>
</div>
