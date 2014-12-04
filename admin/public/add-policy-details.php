<?php
// Setp 2 Policy Registrtaion Form
// Create Policy
if(isset($_POST['save']))
{
	// get policy form submitted params
	$data = $_POST;
	
	// unset data array for specific elements
	unset($_POST['save']);
	unset($_POST['branch_title']);
	unset($_POST['office_title']);
	unset($_POST['business_type_name']);
	unset($_POST['policy_class_name']);
	unset($_POST['policy_type_name']);
	unset($_POST['doc_type']);
	unset($_POST['source_location_name']);
	unset($_POST['business_source_name']);
	unset($_POST['broker_name']);
	unset($_POST['salesman_name']);
	
	// set data array with specific elements
	$_POST['registry_date'] = date("Y-m-d h:i:s",strtotime($_POST['registry_date']));
	$_POST['insured_period_startdate'] = date("Y-m-d",strtotime($_POST['insured_period_startdate']));
	$_POST['insured_period_enddate'] = date("Y-m-d",strtotime($_POST['insured_period_enddate']));
	$_POST['step_no'] = "1";
	$_POST['is_complete'] = "0";
	
	// check for duplicate record
	if($db->isExists('policy_no',$_POST,POLICYMASTER)){
		$errmsg = "- Policy No already exists";
	}else{
	// save record
	$result = $db->recordInsert($_POST,POLICYMASTER,'');
	// set policy id
	$_SESSION['policy_id'] = array(mysql_insert_id(),'1');
	if($result == 1)
		echo "<script>alert('Policy Processed and Created Sucessfully');location.href='account.php?page=add-policy-details';</script>";
	else if($result == 2)
		echo "<script>alert('Policy Process Failed');location.href='account.php?page=add-policy';</script>";
	}
}
if($_GET['task'] == "edit" && $_GET['id'] != "")
{
	$datalists = $db->recordFetch($_GET['id'],POLICYMASTER.":".'id');
}else{
	// For New Policy
	// Generate Predefined items
	$policy_no = get_code(POLICYMASTER,'policy_no','id');
	$document_key = "AC/".date("Y")."/".$policy_no;
	$policy_start_date = date("d-m-Y");
}
?>
<script type="text/javascript">
// set document focus
if(document.customer_policy_form.branch_id.value == ""){
	document.customer_policy_form.branch_id.focus();
}

function validateManager()
{
	var str = document.customer_policy_form;
	var error = "";
	var flag = true;
	var dataArray = new Array();
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var nameRegex = /^[a-zA-Z ]{2,30}$/;
	
	if(str.branch_id.value == "")
	{
		str.branch_id.style.borderColor = "RED";
		error += "- Enter Branch Code\n";
		//flag = false;
	    dataArray.push('branch_id');
	}
	else
	{
		str.branch_id.style.borderColor = "";
		//flag = true;
		dataArray.pop();
	}
	if(str.office_id.value == "")
	{
		str.office_id.style.borderColor = "RED";
		error += "- Enter Office Code\n";
		//flag = false;
		dataArray.push('office_id');
	}
	else
	{
		str.office_id.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	if(str.business_type_id.value == "")
	{
		str.business_type_id.style.borderColor = "RED";
		error += "- Enter Business Type Code\n";
		//flag = false;
		dataArray.push('business_type_id');
	}
	else
	{
		str.business_type_id.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	if(str.policy_class_id.value == "")
	{
		str.policy_class_id.style.borderColor = "RED";
		error += "- Enter Policy Class Code\n";
		//flag = false;
		dataArray.push('policy_class_id');
	}
	else
	{
		str.policy_class_id.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	if(str.policy_type_id.value == "")
	{
		str.policy_type_id.style.borderColor = "RED";
		error += "- Enter Policy Type Code\n";
		//flag = false;
		dataArray.push('policy_type_id');
	}
	else
	{
		str.policy_type_id.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	if(str.doc_type_id.value == "")
	{
		str.doc_type_id.style.borderColor = "RED";
		error += "- Enter Document Code\n";
		//flag = false;
		dataArray.push('doc_type_id');
	}
	else
	{
		str.doc_type_id.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	if(!nameRegex.test(str.debit_account.value.trim()))
	{
		str.debit_account.style.borderColor = "RED";
		error += "- Enter Debit Account\n";
		//flag = false;
		dataArray.push('debit_account');
	}
	else
	{
		str.debit_account.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	if(!nameRegex.test(str.insured_person.value.trim()))
	{
		str.insured_person.style.borderColor = "RED";
		error += "- Enter Insured Item Name\n";
		//flag = false;
		dataArray.push('insured_person');
	}
	else
	{
		str.insured_person.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	if(!nameRegex.test(str.financed_person.value.trim()))
	{
		str.financed_person.style.borderColor = "RED";
		error += "- Enter Loss Payee Name\n";
		//flag = false;
		dataArray.push('financed_person');
	}
	else
	{
		str.financed_person.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	if(str.salesman_id.value == "")
	{
		str.salesman_id.style.borderColor = "RED";
		error += "- Enter Sales Persons Code\n";
		//flag = false;
		dataArray.push('salesman_id');
	}
	else
	{
		str.salesman_id.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	if(str.insured_period.value.trim() == "")
	{
		str.insured_period.style.borderColor = "RED";
		error += "- Enter Insured Period \n";
		//flag = false;
		dataArray.push('insured_period');
	}
	else
	{
	 	str.insured_period.style.borderColor = "";
	    //flag = true;
		dataArray.pop();
	}
	
	if(str.payment_term.value == "")
	{
		str.payment_term.style.borderColor = "RED";
		error += "- Enter Payment Term\n";
		//flag = false;
		dataArray.push('payment_term');
	}
	else
	{
		str.payment_term.style.borderColor = "";
		//flag = true;
		dataArray.pop();
	}
	
	if(str.uw_year.value == "")
	{
		str.uw_year.style.borderColor = "RED";
		error += "- Enter UW Year\n";
		//flag = false;
		dataArray.push('uw_year');
	}
	else
	{
		str.uw_year.style.borderColor = "";
		//flag = true;
		dataArray.pop();
	}
	
	if(str.installment_term.value == "")
	{
		str.installment_term.style.borderColor = "RED";
		error += "- Enter Installment Term\n";
		//flag = false;
		dataArray.push('installment_term');
	}
	else
	{
		str.installment_term.style.borderColor = "";
		//flag = true;
		dataArray.pop();
	}
	
	if(str.file_no.value == "")
	{
		str.file_no.style.borderColor = "RED";
		error += "- Enter File No\n";
		//flag = false;
		dataArray.push('file_no');
	}
	else
	{
		str.file_no.style.borderColor = "";
		//flag = true;
		dataArray.pop();
	}
	
	if(error != "")
	{
		alert(error);
		str.elements[dataArray[0]].focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<script type="text/javascript">
$(function() {
	$( "#insured_period_startdate" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' } );
	$( "#insured_period_enddate" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' });
});
</script>
<script type="text/javascript">
function getIdVal(field_name,table_name,display_field,data_field)
{
	var field_id = $("#"+field_name).val();
    $.ajax({
	type: "POST",
	url: "util/getidval.php",
	data: "table_name="+ table_name +"&id="+field_id+"&data_val="+data_field,
	success: function(msg){
	if(msg != ""){
		//alert(msg);
		$("#"+display_field).val(msg);
	}			       
	}});
}

function getCodeVal(field_name,table_name,display_field,data_field,code_field)
{
	var field_id = $("#"+field_name).val();
    $.ajax({
	type: "POST",
	url: "util/getidval.php",
	data: "table_name="+ table_name +"&id="+field_id+"&data_val="+data_field+"&code_field="+code_field,
	success: function(msg){
	if(msg != ""){
		//alert(msg);
		$("#"+display_field).val(msg);
	}			       
	}});
}

function getDates(){
	var policy_period = $("#insured_period").val();
	var policy_period_type = $("#insured_period_type").val();
	var startDate = $("#insured_period_startdate").val();
	
	$.ajax({
	type: "POST",
	url: "util/utils.php",
	data: "term="+ policy_period +"&term_type="+policy_period_type+"&st_date="+startDate+"&call_type=gettermdates",
	success: function(msg){
	if(msg != ""){
		//alert(msg);
		$("#insured_period_enddate").val(msg);
	}			       
	}});
}

function setNoPeriod(str){
	if(str.value != ""){
		switch(str){
			case 'No':
			$("#insured_period").attr('disabled',true);
			$("#insured_period_type").attr('disabled',true);
			$("#insured_period_startdate").attr('disabled',true);
			$("#insured_period_enddate").attr('disabled',true);
			break;
			
			case 'Yes':
			$("#insured_period").removeAttr('disabled');
			$("#insured_period_type").removeAttr('disabled');
			$("#insured_period_startdate").removeAttr('disabled');
			$("#insured_period_enddate").removeAttr('disabled');
			break;
		}
	}
}
</script>

<script type="text/javascript">
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}
</script>

<form action="" method="post" name="customer_policy_form" onSubmit="return validateManager();">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center">
	<input type="button" name="step1" id="step1" value=" 1. Basic Info " class="stepBtnDisabled" disabled="disabled">
	<input type="button" name="step2" id="step2" value=" 2. Subjects/Locations " class="stepBtn">
    <input type="submit" name="step3" id="step3" value=" 3. Covers/Conditions " class="stepBtn">
    <input type="submit" name="step4" id="step4" value=" 4. Premium Due " class="stepBtn"></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td style="padding-top: 10px;">
	<fieldset>
	<legend align="center">Policy</legend>
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
	  <tr>
		<td colspan="2">Branch</td>
	    <td colspan="2">Office</td>
	    <td colspan="2">Business Type</td>
	    <td colspan="2">Class</td>
	    <td colspan="2">Pol. Type</td>
	    <td colspan="2">Doc Type</td>
	  </tr>
	  <tr>
	    <td width="4%"><input name="branch_id" type="text" class="textbox" id="branch_id" style="width: 40px;" onBlur="getIdVal('branch_id','BRANCHES','branch_title','branch_name'); document.getElementById('source_location_id').value = this.value;" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('branch_id',$datalist); ?>"/></td>
	    <td width="12%"><input name="branch_title" type="text" class="textbox" id="branch_title" style="width: 100px;" readonly="readonly" onblur="document.getElementById('source_location_name').value = this.value;"/></td>
	    <td width="4%"><input name="office_id" type="text" class="textbox" id="office_id" style="width: 40px;" onBlur="getIdVal('office_id','OFFICES','office_title','office_name')" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('office_id',$datalist); ?>"/></td>
	    <td width="12%"><input name="office_title" type="text" class="textbox" id="office_title" style="width: 100px;" readonly="readonly"/></td>
	    <td width="4%"><input name="business_type_id" type="text" class="textbox" id="business_type_id" style="width: 40px;" onBlur="getIdVal('business_type_id','BUSINESSTYPE','business_type_name','business_type'); document.getElementById('business_source_id').value = this.value;" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('business_type_id',$datalist); ?>"/></td>
	    <td width="12%"><input name="business_type_name" type="text" class="textbox" id="business_type_name" style="width: 100px;" readonly="readonly" onblur="document.getElementById('business_source_name').value = this.value;"/></td>
	    <td width="4%"><input name="policy_class_id" type="text" class="textbox" id="policy_class_id" style="width: 40px;" onBlur="getIdVal('policy_class_id','POLICIES','policy_class_name','title')" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('policy_class_id',$datalist); ?>"/></td>
	    <td width="12%"><input name="policy_class_name" type="text" class="textbox" id="policy_class_name" style="width: 100px;" readonly="readonly"/></td>
	    <td width="4%"><input name="policy_type_id" type="text" class="textbox" id="policy_type_id" style="width: 40px;" onBlur="getIdVal('policy_type_id','POLICYTYPES','policy_type_name','policy_type')" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('policy_type_id',$datalist); ?>"/></td>
	    <td width="12%"><input name="policy_type_name" type="text" class="textbox" id="policy_type_name" style="width: 100px;" readonly="readonly"/></td>
	    <td width="4%"><input name="doc_type_id" type="text" class="textbox" id="doc_type_id" style="width: 40px;" onBlur="getIdVal('doc_type_id','DOCTYPES','doc_type','type_name')" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('doc_type_id',$datalist); ?>"/></td>
	    <td width="16%"><input name="doc_type" type="text" class="textbox" id="doc_type" style="width: 100px;" readonly="readonly"/></td>
	  </tr>
	</table>
	
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
	  <tr>
		<td width="16%"><strong>Policy No </strong></td>
	    <td width="16%"><strong>Policy Year </strong></td>
	    <td width="33%" style="padding-left: 5px;"><strong>Doc. Key</strong></td>
	    <td width="35%"><strong>Quotation Key </strong></td>
	    </tr>
	  <tr>
	    <td><input readonly="readonly" name="policy_no" type="text" class="textbox" id="policy_no" style="width: 160px; border: none; font-size: 14px;background-color:white; border-left: 1px solid #666;" value="<?php if($_GET['id']!=''){echo getElementVal('policy_no',$datalists);}else{echo $policy_no;} ?>"/></td>
	    <td><input readonly="readonly" name="policy_year" type="text" class="textbox" id="policy_year" style="width: 152px;" value="<?php if($_GET['id'] != ""){echo getElementVal('policy_year',$datalist);}else{echo date("Y");} ?>"/></td>
	    <td style="padding-left: 5px;"><input readonly="readonly" name="doc_key" type="text" class="textbox" id="doc_key" style="width: 327px; font-weight: bold;" value="<?php if($_GET['id'] != ""){echo getElementVal('doc_key',$datalist);}else{echo $document_key;} ?>"/></td>
	    <td><input name="quotation_key" type="text" class="textbox" id="quotation_key" style="width: 325px;" value="<?php echo getElementVal('quotation_key',$datalist); ?>"/></td>
	    </tr>
	</table>
	</fieldset>
	</td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>
	<fieldset>
	<legend style="background-color: rgba(2, 2, 2, 0.33);">Basic Information</legend>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="56%" valign="top" style="padding-right: 15px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="28%">Debit Account:</td>
            <td width="72%">
              <input name="debit_account" type="text" class="textbox" id="debit_account" style="width: 327px;" value="<?php echo getElementVal('debit_account',$datalist); ?>"/>
            </td>
          </tr>
          <tr>
            <td>Insured: </td>
            <td>
              <input name="insured_person" type="text" class="textbox" id="insured_person" style="width: 327px;" value="<?php echo getElementVal('insured_person',$datalist); ?>"/>
            </td>
          </tr>
          <tr>
            <td>Loss Payee/Financed By: </td>
            <td>
              <input name="financed_person" type="text" class="textbox" id="financed_person" style="width: 327px;" value="<?php echo getElementVal('financed_person',$datalist); ?>"/>
           </td>
          </tr>
          <tr>
            <td>Source Location: </td>
            <td><input name="source_location_id" type="text" class="textbox" id="source_location_id" style="width: 40px;" onBlur="getIdVal('source_location_id','BRANCHES','source_location_name','branch_name')" value="<?php echo getElementVal('source_location_id',$datalist); ?>"/>
              <input name="source_location_name" type="text" class="textbox" id="source_location_name" style="width: 275px;" readonly="readonly"/></td>
          </tr>
          <tr>
            <td>Business Source: </td>
            <td><input name="business_source_id" type="text" class="textbox" id="business_source_id" style="width: 40px;" onBlur="getIdVal('business_source_id','BUSINESSTYPE','business_source_name','business_type')" value="<?php echo getElementVal('business_source_id',$datalist); ?>"/>
              <input name="business_source_name" type="text" class="textbox" id="business_source_name" style="width: 275px;" readonly="readonly"/></td>
          </tr>
          <tr>
            <td>Broker:</td>
            <td>
              <input name="broker_id" type="text" class="textbox" id="broker_id" style="width: 100px;" onBlur="getCodeVal('broker_id','AGENTTBL','broker_name','ag_fname','ag_code')" placeholder="Agent Code" value="<?php echo getElementVal('broker_id',$datalist); ?>"/>
              <input name="broker_name" type="text" class="textbox" id="broker_name" style="width: 215px;" readonly="readonly"/>
            </td>
          </tr>
          <tr>
            <td>Salesman:</td>
            <td>
              <input name="salesman_id" type="text" class="textbox" id="salesman_id" style="width: 100px;" onBlur="getCodeVal('salesman_id','EMPLOYEETBL','salesman_name','emp_fname','emp_code')" placeholder="Emp Code" value="<?php echo getElementVal('salesman_id',$datalist); ?>"/>
              <input name="salesman_name" type="text" class="textbox" id="salesman_name" style="width: 215px;" readonly="readonly"/>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="padding-top: 10px; padding-bottom: 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
			  <tr>
				<td align="left" style=""><strong>Insurance Period</strong></td>
			  </tr>
			</table>			</td>
            </tr>
          <tr>
            <td colspan="2" style="padding: 0px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="28%">Known?</td>
    <td>
	<select style="width: 158px;" name='insured_period_known' id='insured_period_known' onchange="setNoPeriod(this.value)">
	   <option value="Yes" <?php if(getElementVal('insured_period_known',$datalist) == "Yes"){echo "selected='selected'";}?>>Yes</option>
	   <option value="No" <?php if(getElementVal('insured_period_known',$datalist) == "No"){echo "selected='selected'";}?>>No</option>
	</select>	</td>
    </tr>
  <tr>
    <td>Policy Period:</td>
    <td><input name="insured_period" type="text" class="textbox" id="insured_period" style="width: 46px;" onblur="getDates()" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('insured_period',$datalist); ?>"/>
      <select style="width: 100px;" name='insured_period_type' id='insured_period_type' onchange="getDates()">
        <option value="Years" <?php if(getElementVal('insured_period_type',$datalist) == "Years"){echo "selected='selected'";}?>>Years</option>
        <option value="Months" <?php if(getElementVal('insured_period_type',$datalist) == "Months"){echo "selected='selected'";}?>>Months</option>
      </select></td>
  </tr>
  <tr>
    <td>Policy Active Dates:</td>
    <td>
      <input name="insured_period_startdate" type="text" readonly="readonly" maxlength="10" class="textbox" id="insured_period_startdate" style="width: 150px;" placeholder="Start Date" value="<?php if($_GET['id'] != ""){echo getElementVal('insured_period_startdate',$datalist);}else{echo $policy_start_date;} ?>" onchange="getDates()"/>
-
<input name="insured_period_enddate" type="text" readonly="readonly" maxlength="10" class="textbox" id="insured_period_enddate" value="<?php if($_GET['id'] != ""){echo getElementVal('insured_period_enddate',$datalist);} ?>" style="width: 150px;" placeholder="End Date" />    </td>
  </tr>
  <tr>
    <td>Time Zone: </td>
    <td><select style="width: 158px;" name='insured_timezon' id='insured_timezon'>
      <option value="UAE" <?php if(getElementVal('insured_timezon',$datalist) == "UAE"){echo "selected='selected'";}?>>UAE</option>
    </select></td>
  </tr>
</table>

			</td>
          </tr>
        </table>
		</td>
	    <td width="44%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="20%">Registry Date: </td>
            <td width="80%"><input readonly="readonly" name="registry_date" type="text" class="textbox" id="registry_date" style="width: 200px;" value="<?php if($_GET['id'] != ""){echo getElementVal('registry_date',$datalist);}else{echo date("m-d-Y h:i:s");} ?>"/></td>
          </tr>
          <tr>
            <td>Payment Term: </td>
            <td><input name="payment_term" type="text" class="textbox" id="payment_term" style="width: 200px;" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('payment_term',$datalist); ?>"/></td>
          </tr>
          <tr>
            <td>UW Year: </td>
            <td><input name="uw_year" type="text" class="textbox" id="uw_year" style="width: 200px;" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('uw_year',$datalist); ?>"/></td>
          </tr>
          <tr>
            <td>Installment Term: </td>
            <td><input name="installment_term" type="text" class="textbox" id="installment_term" style="width: 200px;" onkeypress="return isNumberKey(event)" value="<?php echo getElementVal('installment_term',$datalist); ?>"/></td>
          </tr>
          <tr>
            <td>Installment Desc.: </td>
            <td><input name="installment_description" type="text" class="textbox" id="installment_description" style="width: 200px;" value="<?php echo getElementVal('installment_description',$datalist); ?>"/></td>
          </tr>
          <tr>
            <td>Reference:</td>
            <td><input name="reference" type="text" class="textbox" id="reference" style="width: 200px;" value="<?php echo getElementVal('reference',$datalist); ?>"/></td>
          </tr>
          <tr>
            <td>Remark:</td>
            <td><input name="remark" type="text" class="textbox" id="remark" style="width: 200px;" value="<?php echo getElementVal('remark',$datalist); ?>"/></td>
          </tr>
          <tr>
            <td>Your Ref.: </td>
            <td><input name="your_reference" type="text" class="textbox" id="your_reference" style="width: 200px;" value="<?php echo getElementVal('your_reference',$datalist); ?>"/></td>
          </tr>
          <tr>
            <td>Surveyor/Adjuster: </td>
            <td><input name="surveyor" type="text" class="textbox" id="surveyor" style="width: 200px;" value="<?php echo getElementVal('surveyor',$datalist); ?>"/></td>
          </tr>
          <tr>
            <td>File No: </td>
            <td><input name="file_no" type="text" class="textbox" id="file_no" style="width: 200px;" value="<?php echo getElementVal('file_no',$datalist); ?>"/></td>
          </tr>
        </table></td>
	  </tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	  <tr>
		<td>
		<?php
		if($_GET['id'] != "" && $task == "edit"){
    	?>
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn">
        <?php }else{ ?>
        <input type="submit" name="save" id="save" value=" Process  " class="actionBtn">
        <?php } ?>
		<input type="button" name="exit" id="exit" value=" Exit " class="actionBtn" onclick="location.href='account.php?page=policy-master'">
		</td>
	  </tr>
	</table>
	</fieldset></td>
  </tr>
</table>
</form>