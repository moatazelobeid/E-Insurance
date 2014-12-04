<?php
if(isset($_POST['update']))
{
	unset($_POST['update']);
	$id = '1';
	$result = $db->recordUpdate(array("id" => $id),$_POST,MOTORSETTINGS);	
	if($result)
	{
		$sucessmsg = "Motor Insurance settings updated sucessfully";	
	}
}

$sq_var="select * from ".MOTORSETTINGS." where id='1'";
$rs_var=mysql_fetch_object(mysql_query($sq_var));
?>
<script type="text/javascript">
	function valForm()
	{
	var str=document.motor_ins_fr;
	if(str.car_cost_frm.value=='')
		{
			document.getElementById("mtitle").innerHTML="Enter Car cost from.";
			str.car_cost_frm.focus();
			return false;
		}else{
		document.getElementById("mtitle").innerHTML="";
		}
		
		if(str.car_cost_to.value=='')
		{
			document.getElementById("mtitle").innerHTML="Enter Car cost to.";
			str.car_cost_to.focus();
			return false;
		}else{
			document.getElementById("mtitle").innerHTML="";
		}
		
		
		if(str.addn_percnt_cost_tpl.value=='')
		{
			document.getElementById("mpos").innerHTML="Add Additional cost Percentage";
			str.addn_percnt_cost_tpl.focus();
			return false;
		}else{
		document.getElementById("mpos").innerHTML="";
		}
		
		
		if(str.addn_percnt_cost_comp.value=='')
		{
			document.getElementById("mpos1").innerHTML="Add Additional cost Percentage";
			str.addn_percnt_cost_comp.focus();
			return false;
		}else{
		document.getElementById("mpos1").innerHTML="";
		}
		
		if(str.comp_prem_car_val_percent.value=='')
		{
			document.getElementById("mpos2").innerHTML="Enter Comp. Premium For car value";
			str.comp_prem_car_val_percent.focus();
			return false;
		}else{
		document.getElementById("mpos2").innerHTML="";
		}
		
		if(str.min_comp_prem_amt.value=='')
		{
			document.getElementById("mpos3").innerHTML="Enter Minimun Comp. Premium Amount";
			str.min_comp_prem_amt.focus();
			return false;
		}else{
		document.getElementById("mpos3").innerHTML="";
		}
		if(str.max_comp_prem_amt.value=='')
		{
			document.getElementById("mpos12").innerHTML="Enter Maximun Comp. Premium Amount";
			str.max_comp_prem_amt.focus();
			return false;
		}else{
		document.getElementById("mpos12").innerHTML="";
		}
		
		if(str.max_agncy_repr_cost.value=='')
		{
			document.getElementById("mpos4").innerHTML="Enter Maximun Agency Repair Cost";
			str.max_agncy_repr_cost.focus();
			return false;
		}else{
		document.getElementById("mpos4").innerHTML="";
		}
		
		if(str.prem_grtr_claim_percnt.value=='')
		{
			document.getElementById("mpos5").innerHTML="Enter Premium > claim value";
			str.prem_grtr_claim_percnt.focus();
			return false;
		}else{
		document.getElementById("mpos5").innerHTML="";
		}
		
		if(str.claim_grtr_prem_percnt.value=='')
		{
			document.getElementById("mpos6").innerHTML="Enter Claim > premium value";
			str.claim_grtr_prem_percnt.focus();
			return false;
		}else{
		document.getElementById("mpos6").innerHTML="";
		}
		
		if(str.addn_deduct_amnt11.value=='')
		{
			document.getElementById("mpos8").innerHTML="Enter Additional Percentage Cost";
			str.addn_deduct_amnt11.focus();
			return false;
		}else{
		document.getElementById("mpos8").innerHTML="";
		}
		
		
		
		
	}
	
	 
function isNumberKey(evt)
 {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	else
	return true;
 }
</script>
<div style="width: 100%; margin: 0 auto; margin-top: 15px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Motor Insurance Settings</strong></td>
      <td align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;">&nbsp;</td>
    </tr>
  </table>
  <?php if($msg <> ""){
?>
  <div style="border: 1px solid #990; background-color: #FFC; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="6%"><img src="../images/warning.png" width="20" height="20"></td>
<td width="94%"><?php echo $msg; ?></td>
</tr>
</table>
</div>
<?php } ?>
  <?php if($sucessmsg <> ""){
?>
  <div style="border: 1px solid #990; background-color: #FFC; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="6%"><img src="<?=SITE_URL?>admin/images/correct.gif" width="20" height="20"></td>
<td width="94%"><?php echo $sucessmsg; ?></td>
</tr>
</table>
</div>
<?php } ?>
  <form action="" method="post" name="motor_ins_fr" onsubmit="return valForm();">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="27%">Car Cost Range (SR):</td>
        <td width="73%"><input name="car_cost_frm" type="text" class="textbox" onKeyPress="return isNumberKey(event);" id="car_cost_frm" value="<?php echo stripslashes($rs_var->car_cost_frm); ?>" style="width: 150px;">&nbsp;-&nbsp;<input name="car_cost_to" type="text" onKeyPress="return isNumberKey(event);" class="textbox" id="car_cost_to" value="<?php echo stripslashes($rs_var->car_cost_to); ?>" style="width: 150px;">&nbsp;&nbsp;<span id="mtitle" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
		
		<tr>
        <td width="27%" style="vertical-align:text-top;">Additional Percentage Cost (Tpl):</td>
        <td width="73%">
        	<input name="addn_percnt_cost_tpl" type="text" onKeyPress="return isNumberKey(event);" class="textbox" id="addn_percnt_cost_tpl" value="<?php echo stripslashes($rs_var->addn_percnt_cost_tpl); ?>" style="width: 150px;">&nbsp;(%)&nbsp;<span id="mpos" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span>
        	<br />
            This additional percentage will add to the premium amount<br />
            if Driving Liscence is more than one year 
            and Driver age is less thant 21( 18-21).
        </td>
        </tr>
		<tr>
        <td width="27%">Additional Percentage Cost (Comp):</td>
        <td width="73%"><input name="addn_percnt_cost_comp" type="text" class="textbox" onKeyPress="return isNumberKey(event);" id="addn_deduct_amnt" value="<?php echo stripslashes($rs_var->addn_percnt_cost_comp); ?>" style="width: 150px;">
          &nbsp;(%)&nbsp;<span id="mpos1" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span>&nbsp;&nbsp;<span id="mtitle" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
        <tr>
        <td width="27%">Comprehensive Premium For Car Value :</td>
        <td width="73%"><input name="comp_prem_car_val_percent" type="text" class="textbox" onKeyPress="return isNumberKey(event);" id="comp_prem_car_val_percent" value="<?php echo stripslashes($rs_var->comp_prem_car_val_percent); ?>" style="width: 150px;">&nbsp;(%)&nbsp;<span id="mpos2" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
         <tr>
        <td width="27%">Minimun Comprehensive Premium Amount (SR):</td>
        <td width="73%"><input name="min_comp_prem_amt" type="text" class="textbox" onKeyPress="return isNumberKey(event);" id="min_comp_prem_amt" value="<?php echo stripslashes($rs_var->min_comp_prem_amt); ?>" style="width: 150px;">&nbsp;&nbsp;<span id="mpos3" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
         <tr>
        <td width="27%">Maximun Comprehensive Premium Amount (SR):</td>
        <td width="73%"><input name="max_comp_prem_amt" type="text" class="textbox" onKeyPress="return isNumberKey(event);" id="max_comp_prem_amt" value="<?php echo stripslashes($rs_var->max_comp_prem_amt); ?>" style="width: 150px;">&nbsp;&nbsp;<span id="mpos12" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
         <tr>
        <td width="27%">Maximun Agency Repair Cost (SR):</td>
        <td width="73%"><input name="max_agncy_repr_cost" type="text" class="textbox" onKeyPress="return isNumberKey(event);" id="max_agncy_repr_cost" value="<?php echo stripslashes($rs_var->max_agncy_repr_cost); ?>" style="width: 150px;">&nbsp;&nbsp;<span id="mpos4" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
        <tr>
        <td width="27%">Premium > Claim Percentage value:</td>
        <td width="73%"><input name="prem_grtr_claim_percnt" type="text" class="textbox" onKeyPress="return isNumberKey(event);" id="prem_grtr_claim_percnt" value="<?php echo stripslashes($rs_var->prem_grtr_claim_percnt); ?>" style="width: 150px;">&nbsp;(%)&nbsp;<span id="mpos5" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
         <tr>
        <td width="27%">Claim > Premium Percentage value:</td>
        <td width="73%"><input name="claim_grtr_prem_percnt" type="text" class="textbox" onKeyPress="return isNumberKey(event);" id="claim_grtr_prem_percnt" value="<?php echo stripslashes($rs_var->claim_grtr_prem_percnt); ?>" style="width: 150px;">&nbsp;(%)&nbsp;<span id="mpos6" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
        <tr>
        <td width="27%">Additional Deductable Amount (SR):</td>
        <td width="73%"><input name="addn_deduct_amnt" type="text" class="textbox" onKeyPress="return isNumberKey(event);" id="addn_deduct_amnt11" value="<?php echo stripslashes($rs_var->addn_deduct_amnt); ?>" style="width: 150px;">&nbsp;&nbsp;<span id="mpos8" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span><br />
            If driver age between (18-21)
           </td>
        </tr>
        
      <tr>
        <td colspan="2">
          <input name="update" type="submit" id="update" value=" Update "  class="actionBtn">
      </td>
      </tr>
    </table>
  </td>
  </tr>
</table>
</form>
</div>