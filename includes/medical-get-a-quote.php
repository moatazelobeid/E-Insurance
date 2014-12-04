<?php
// call class instance
$db = new dbFactory();


if(isset($_POST['submit_medical_quote']))
{
	unset($_POST['submit_medical_quote']);	
	$_POST['created_date']=date('Y-m-d H:i:s');
	$_POST['quote_key'] = uniqid();
	
	$_POST['dob'] = date('Y-m-d', strtotime($_POST['dob']));
	
	//Insert into policy quote table
	$result = $db->recordInsert($_POST,MEDICALQUOTES,'');
	//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
	if(!empty($result))
	{
		$lastid = mysql_insert_id();
		$quotekeyid = 'AC/Q/'.date("Y").'/00'.$lastid;
		
		unset($_POST['quote_key']);
		unset($_POST['created_date']);
		
		//save all field in session
		$_SESSION['medical']['Quote'] = $_POST;
		$_SESSION['medical']['step_2'] = '1';
		
		$_SESSION['medical']['Quote_key'] = $quotekeyid;
		
		$insert = $db->recordUpdate(array("id" => $lastid),array("quote_key"=>$quotekeyid),MEDICALQUOTES);
		
		$_SESSION['medical']['get_a_quote_id'] = $lastid;
		$_SESSION['medical']['get_a_quote_msg'] = '<font color="#00CC33">Qoutation send sucessfully.</font>';
	}
	else
	{
		$_SESSION['medical']['get_a_quote_msg'] = '<font color="#00CC33">Qoutation sending Failed.</font>';	
	}
	
	header('Location: '.BASE_URL.'index.php?page=medical-insurance&step=1');	
}

?>
<script>
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

 return true;
}
	  
function validMedicalGetAQuoteForm()
{
	var form = document.medical_get_a_quote;
	var flag = true;
	var fields = new Array();
	
	if(form.dob.value == '')
	{
		form.dob.style.borderColor='red';
		flag = false;	
		fields.push('dob');
	}
	else
	{
		form.dob.style.borderColor='#FFF';
	}
	if(form.gender.value == '')
	{
		form.gender.style.borderColor='red';
		flag = false;	
		fields.push('gender');
	}
	else
	{
		form.gender.style.borderColor='#FFF';
	}
	if(form.network_class.value == '')
	{
		form.network_class.style.borderColor='red';
		flag = false;	
		fields.push('network_class');
	}
	else
	{
		form.network_class.style.borderColor='#FFF';
	}
	if(form.chronoc_diseases.value == '')
	{
		form.chronoc_diseases.style.borderColor='red';
		flag = false;	
		fields.push('chronoc_diseases');
	}
	else
	{
		form.chronoc_diseases.style.borderColor='#FFF';
	}
	if(form.mobile_no.value == '')
	{
		form.mobile_no.style.borderColor='red';
		flag = false;	
		fields.push('mobile_no');
	}
	else
	{
		form.mobile_no.style.borderColor='#FFF';
	}
	if(fields.length>0)
	{
		var fld = fields[0];
		
		//form.first_name.focus();
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}
</script>
<div>
    <div id="home-form" class="yakeendown greenbox">
      <h2 id="getquote" style="text-align:center;">
        Quick Quote
      </h2>
        <form id="medical_get_a_quote" name="medical_get_a_quote" method="post">
        	<input type="hidden" name="policy_class_id" value="3" />
        <div id="step-1">
            <div class="form-row-medical">
            <input value="" class="dob_calender" type="text" id="dob" name="dob" placeholder="Date of Birth" autocomplete="off" />
            </div>
            
            <div class="form-row-medical">
            <select name="gender" id="gender">
                <option value="" selected="selected">Gender</option>
                <option value="2">Male</option>
                <option value="1">Female</option>
            </select>
            </div>
            <div class="form-row-medical">
            <select name="network_class" id="network_class" onchange="showVehicleColumn(this.value);">
                <option value="" selected="selected">Network Class</option>
                <option value="2">VIP</option>
                <option value="1">Class A</option>
                <option value="1">Class B</option>
                <option value="1">Class C</option>
            </select>
            </div>
        <div class="form-row-medical">
        <input value="" class="mobile" name="chronoc_diseases" id="chronoc_diseases" type="text" placeholder="Pre-Existing / Chronic Diseases" autocomplete="off" />
        </div>
        <div class="form-row-medical">
        <input value="" class="mobile" name="mobile_no" id="mobile_no" maxlength="10" type="text" placeholder="Mobile Number"onkeypress="return isNumberKey(event)" autocomplete="off" />
        </div>
        <div class="clearfix"></div>
          <div class="form-row" style="margin-top: 10px;" id="CartSubmit">
            <button type="submit" id="submit3" class="submit" name="submit_medical_quote" style="position: inherit; margin-left: 25%;" onclick="return validMedicalGetAQuoteForm();">
            Get A Quote
            </button>
          </div>
          <br clear="all">
        </div>
      </form>
      <div id="SponsorDivToolTip" style="left: 220px; display: none;">
        A verification code will be sent to this mobile number
      </div>
    </div>
</div>