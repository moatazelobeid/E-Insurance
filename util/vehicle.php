<?php  
include_once("../config/config.php");
include_once("../config/functions.php");
include_once("../config/tables.php");
include_once("../classes/dbFactory.php");

$db = new dbFactory();

if(isset($_REQUEST['vehicle_id']) && !empty($_REQUEST['vehicle_id']))
{
	$vehicle_id = $_REQUEST['vehicle_id'];
	
	$rs=mysql_query("select * from ".VMODEL." where make_id='".$vehicle_id."' and status ='1' ");

	$make='';
	if(mysql_num_rows($rs) > 0)
	{
		$make.= '<select id="vehicle_model" name="vehicle_model" class="dropdown" onchange="getVehicleType(this.value);"><option value="">-Select-</option>';
		while($row = mysql_fetch_array($rs)):
		$make.= '<option value="'.$row['id'].'">'.$row['model'].'</option>';
		endwhile;
		$make.="</select>";
		if($make <> '')
		{
			echo $make;	
		}
	}
	else{
		echo 0;
	}
}
if(isset($_REQUEST['vehicle_modelid']) && !empty($_REQUEST['vehicle_modelid']))
{
	$vehiclemodel_id = $_REQUEST['vehicle_modelid'];
	
	$rs=mysql_query("select * from ".VTYPE." where model_id='".$vehiclemodel_id."' and status ='1' ");

	$type='';
	if(mysql_num_rows($rs) > 0)
	{
		$type.= '<select id="vehicle_type" name="vehicle_type" class="dropdown"><option value="">Select</option>';
		while($row = mysql_fetch_array($rs)):
			$type.= '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
		endwhile;
		$type.="</select>";
		if($type <> '')
		{
			echo $type;	
		}
	}
	else{
		echo 0;
	}
}

if(isset($_REQUEST['ptype']) && !empty($_REQUEST['ptype']) && ($_REQUEST['task'] == 'getPolicyNos'))
{
	$policy_type_id = $_REQUEST['ptype'];
	$customer_id = $_REQUEST['cid'];
	
	$rs=mysql_query("select * from ".POLICYMASTER." where policy_type_id='".$policy_type_id."' and customer_id='".$customer_id."' ");

	$res='';
	if(mysql_num_rows($rs) > 0)
	{
		$res.= '<select id="policy_no" name="policy_no" class="dropdown" style="width: 68%;float: left;" onchange="getPolicyDetail(this.value);"><option value="">[--Select--]</option>';
		while($row = mysql_fetch_array($rs)):
			$res.= '<option value="'.$row['policy_no'].'">'.$row['policy_no'].'</option>';
		endwhile;
		$res.="</select>";
		if($res <> '')
		{
			echo $res;	
		}
	}
	else{
		echo 0;
	}
}

if(isset($_REQUEST['pno']) && !empty($_REQUEST['pno']) && ($_REQUEST['task'] == 'getPolicyDetails'))
{
	$policy_no = $_REQUEST['pno'];
	
	$policy_details_qry = "select a.*, b.insured_period_startdate, b.insured_period_enddate, b.doc_key, b.registry_date from ".POLICYMOTOR." as a inner join ".POLICYMASTER." as b on a.policy_no = b.policy_no where a.policy_no='".$policy_no."'";
	$policy_details = mysql_fetch_object(mysql_query($policy_details_qry));
	
	$res = '';
	
	if(!empty($policy_details))
	{
		
		//echo '<pre>'; print_r($policy_details);echo '</pre>'; 
		
		$start_date = $policy_details->insured_period_startdate;
		$start_date = date('d-m-Y',strtotime($start_date));
		$end_date = $policy_details->insured_period_enddate;
		$end_date = date('d-m-Y',strtotime($end_date));
		$dob = $policy_details->dob;
		$dob = date('d-m-Y',strtotime($dob));
		
		$reg_user_deatil = $db->recordFetch($policy_details->customer_id,USERTBL.":".'customer_code');
		$dob = getElementVal('dob',$reg_user_deatil);
		$dob = date('d-m-Y',strtotime($dob));
		
		$fname = getElementVal('fname',$reg_user_deatil);
		
		
		$res .= '<div class="form_area_left_dash_heading" style="width:100%; text-transform:none;">Policy Details </div>';	
		
		$res .= '<table id="policy_details_div" class="PLdetail21">
					  <tbody>
						<tr>
						  <td width="269" height="25"><span class="fieldLabel form_txt1" style="padding-left:3px;">Period From :</span></td>
						  <td width="30" height="25">&nbsp;</td>
						  <td style="width: 45%;" height="25"><span class="fieldLabel form_txt1" style="padding-left:3px;">Email :</span></td>
						</tr>
						<tr>
						  <td height="25"><table width="100%">
							  <tbody>
								<tr>
								  <td width="38%"><input name="policy_from_date" type="text" id="policy_from_date" tabindex="3" class="generalTextBox" autocomplete="off" readonly="" value="'.$start_date.'"></td>
								  <td width="18%" align="center">To</td>
								  <td width="44%"><input name="policy_to_date" type="text" id="policy_to_date" tabindex="3" class="generalTextBox" autocomplete="off" readonly="" value="'.$end_date.'"></td>
								</tr>
							  </tbody>
							</table></td>
						  <td>&nbsp;</td>
						  <td height="25"><span class="fieldsColumn1">
							<input name="email" type="text" id="email" tabindex="3" class="generalTextBox" autocomplete="off" readonly="" value="'.$policy_details->email.'" style="width: 96%;float: left;">
							</span></td>
						</tr>
						<tr>
						  <td width="50%" height="25">&nbsp;<span class="fieldLabel form_txt1">Name of Policy Holder :</span></td>
						  <td width="30" height="25">&nbsp;</td>
						  <td width="297" height="25">Date Of Birth</td>
						</tr>
						<tr>
						  <td height="25" align="left" valign="top"><span class="fieldsColumn1">
							<input name="name" type="text" id="name" tabindex="3" class="generalTextBox" autocomplete="off" readonly="" value="'.$policy_details->first_name.'">
							</span></td>
						  <td>&nbsp;</td>
						  <td height="25"><span class="fieldsColumn1">
							<input name="dob" type="text" tabindex="3" class="generalTextBox" autocomplete="off" readonly="readonly" value="'.$dob.'">
							</span></td>
						</tr>
						
						<tr>
						  <td colspan="3"></td>
						</tr>
				</tbody>
		</table>';
		
		echo $res;
	}
	else
	{
		echo 0;	
	}
}

if($_GET['task'] == 'getPaymentAmount')
{
	$customer_id = $_GET['cus_id'];
	$policy_no = $_GET['pno'];
	
	//echo "select policy_amount from ".POLICYPAYMENTS." where customer_id='".$customer_id."' and policy_no='".$policy_no."'"; exit;
	
	$res = mysql_fetch_object(mysql_query("select policy_amount from ".POLICYPAYMENTS." where customer_id='".$customer_id."' and policy_no='".$policy_no."'"));
	$total_payment_amount = $res->policy_amount;
	if(!empty($total_payment_amount))
		echo round($total_payment_amount,2);
	else echo 0;
}
?>