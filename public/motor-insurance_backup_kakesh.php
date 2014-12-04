
<!--<h1 style="height: 200PX;
text-align: center;
FONT-SIZE: 50px;
padding-top: 150PX;">COMING SOON</h1>-->

<?php 
include('PHPMailer/PHPMailerAutoload.php');

include('paypal/paypalfunctions.php');

// call class instance
$db = new dbFactory();
//Set quote details to vehicle_details
if(!empty($_SESSION['motor']['Quote']))
{
	$_SESSION['motor']['Vehicle'] = $_SESSION['motor']['Quote'];
	unset($_SESSION['motor']['Quote']);	
	unset($_SESSION['motor']['Vehicle']['created_date']);	
}
//echo '<pre>'; print_r($_SESSION['motor']); echo '</pre>';

function getCoverTitle($id)
{
	$res = mysql_fetch_array(mysql_query("select cover_title from ".PRODUCTCOVERS." where id=".$id));
	return stripslashes($res['cover_title']);
}
function getPackageDetails($package_no)
{
	$res = mysql_fetch_object(mysql_query("select * from ".PACKAGE." where package_no='".$package_no."'"));
	return $res;
}
function getVMake($id)
{
	//$makedata = $db->recordFetch($id,VMAKE.':id');
	$res = mysql_fetch_object(mysql_query("select make from ".VMAKE." where id=".$id));
	return $res->make;
}
function getVModel($id)
{
	$res = mysql_fetch_object(mysql_query("select model from ".VMODEL." where id=".$id));
	return $res->model;
}
function getVType($id)
{
	$res = mysql_fetch_object(mysql_query("select type_name from ".VTYPE." where id=".$id));
	return $res->type_name;
}
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript">
$(function() {
	$( "#insured_period_startdate" ).datepicker({
		
		dateFormat: 'dd-mm-yy' , 
		changeYear: 'false' , 
		yearRange: '<?php echo date('Y');?>:<?php echo date('Y');?>' , 
		changeMonth: 'true' 
		<?php /*?>showOn: "button",
		buttonImage: "<?php echo BASE_URL;?>images/calenter-icon.png",
		buttonImageOnly: true<?php */?>
		
		
		} );
	$( "#dob" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:<?php echo date('Y');?>' , changeMonth: 'true' } );
});


function showCoverageDetail(id)
{
	$("#cvg_detail_"+id).slideToggle(400);
}

function showColumn(val)
{
	if(val == 1)
	{
		$('.vtype_comp').hide();
		$('.vtype_tpl').show();
	}	
	if(val == 2)
	{
		$('.vtype_comp').show();
		$('.vtype_tpl').hide();
	}
	if(val == '')
	{
		$('.vtype_comp').hide();
		$('.vtype_tpl').hide();
	}
}

function Mod10(ccNumb)

{  // v2.0

	var fr=document.paymentForm;

	var valid = "0123456789"  // Valid digits in a credit card number

	var len = ccNumb.length;  // The length of the submitted cc number

	var iCCN = parseInt(ccNumb);  // integer of ccNumb

	var sCCN = ccNumb.toString();  // string of ccNumb

	sCCN = sCCN.replace (/^s+|s+$/g,'');  // strip spaces

	var iTotal = 0;  // integer total set at zero

	var bNum = true;  // by default assume it is a number

	var bResult = false;  // by default assume it is NOT a valid cc

	var temp;  // temp variable for parsing string

	var calc;  // used for calculation of each digit



	// Determine if the ccNumb is in fact all numbers

	for (var j=0; j<len; j++) {

	  temp = "" + sCCN.substring(j, j+1);

	  if (valid.indexOf(temp) == "-1"){bNum = false;}

	}



	// if it is NOT a number, you can either alert to the fact, or just pass a failure

	if(!bNum){

	  /*alert("Not a Number");*/bResult = false;

	}

	// Determine if it is the proper length

	if((len == 0)&&(bResult)){  // nothing, field is blank AND passed above # check

	  bResult = false;

	} else{  // ccNumb is a number and the proper length - let's see if it is a valid card number

	  if(len >= 15){  // 15 or 16 for Amex or V/MC

		for(var i=len;i>0;i--){  // LOOP throught the digits of the card

		  calc = parseInt(iCCN) % 10;  // right most digit

		  calc = parseInt(calc);  // assure it is an integer

		  iTotal += calc;  // running total of the card number as we loop - Do Nothing to first digit

		  i--;  // decrement the count - move to the next digit in the card

		  iCCN = iCCN / 10;                               // subtracts right most digit from ccNumb

		  calc = parseInt(iCCN) % 10 ;    // NEXT right most digit

		  calc = calc *2;                                 // multiply the digit by two

		  // Instead of some screwy method of converting 16 to a string and then parsing 1 and 6 and then adding them to make 7,

		  // I use a simple switch statement to change the value of calc2 to 7 if 16 is the multiple.

		  switch(calc){

			case 10: calc = 1; break;       //5*2=10 & 1+0 = 1

			case 12: calc = 3; break;       //6*2=12 & 1+2 = 3

			case 14: calc = 5; break;       //7*2=14 & 1+4 = 5

			case 16: calc = 7; break;       //8*2=16 & 1+6 = 7

			case 18: calc = 9; break;       //9*2=18 & 1+8 = 9

			default: calc = calc;           //4*2= 8 &   8 = 8  -same for all lower numbers

		  }

		iCCN = iCCN / 10;  // subtracts right most digit from ccNum

		iTotal += calc;  // running total of the card number as we loop

	  }  // END OF LOOP

	  if ((iTotal%10)==0){  // check to see if the sum Mod 10 is zero

		bResult = 1;  // This IS (or could be) a valid credit card number.

	  } else {

		bResult = 0;  // This could NOT be a valid credit card number

		}

	  }

	}

	// change alert to on-page display or other indication as needed.

	return bResult;

}

function validStep5Form()
{
	var flag = true;
	var fields = new Array();
	var cno = $('#card_no').val();
	
	if($('#card_no').val() == '')
	{
		$('#card_no').css( "border-color", "red" );
		flag = false;	
		fields.push('card_no');
	}
	else
	{
		var res = Mod10(cno);
		if(res == 0)
		{
			alert("Enter a Valid Card Number");
			flag = false;	
			fields.push('card_no');
		}
		else
		{
			$('#card_no').css( "border-color", "#999" );
		}
	}
	
	if($('#card_exp_mm').val() == '')
	{
		$('#card_exp_mm').css( "border-color", "red" );
		flag = false;	
		fields.push('card_exp_mm');
	}
	else
	{
		$('#card_exp_mm').css( "border-color", "#999" );
	}
	
	if($('#card_exp_yy').val() == '')
	{
		$('#card_exp_yy').css( "border-color", "red" );
		flag = false;	
		fields.push('card_exp_yy');
	}
	else
	{
		$('#card_exp_yy').css( "border-color", "#999" );
	}
	
	if($('#cvv_no').val() == '')
	{
		$('#cvv_no').css( "border-color", "red" );
		flag = false;	
		fields.push('cvv_no');
	}
	else
	{
		$('#cvv_no').css( "border-color", "#999" );
	}
	
	if(fields.length>0)
	{
		var fld = fields[0];

		$('#'+fld).focus();
		return false;
	}
	else
	{
		document.step5_form.submit();
	}
}
function validEmail(x)
{ 
	var atpos=x.indexOf("@");

	var dotpos=x.lastIndexOf(".");

	if(atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
		return false;
	}
	else
	{
		return true;	
	}
}
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

 return true;
}

function validStep2Form()
{
	var cnt = 0;
	
	if ($('input[name=package_no]:checked').length == 0)
	{
		cnt = 1;
	}
	if (cnt > 0) 
	{
		alert('Please select any package type');
		return false;
	}
}
function validStep3Form()
{
	var form = document.step3_form;
	var flag = true;
	var fields = new Array();
	
	if(document.getElementById('same_as_driver'))
	{
		if(document.getElementById('same_as_driver').checked == true)
		{
			return true;	
		}
	}
	
	if(form.fname.value == '')
	{
		form.fname.style.borderColor='red';
		flag = false;	
		fields.push('fname');
	}
	else
	{
		form.fname.style.borderColor='#B6B6B6';
	}

	/*if(form.lname.value == '')
	{
		form.lname.style.borderColor='red';
		flag = false;	
		fields.push('lname');
	}
	else
	{
		form.lname.style.borderColor='#B6B6B6';
	}*/
	
	if(form.dob.value == '')
	{
		form.dob.style.borderColor='red';
		flag = false;	
		fields.push('dob');
	}
	else
	{
		form.dob.style.borderColor='#B6B6B6';
	}
	
	/*if(form.dob_dd.value == '')
	{
		form.dob_dd.style.borderColor='red';
		flag = false;	
		fields.push('dob_dd');
	}
	else
	{
		form.dob_dd.style.borderColor='#B6B6B6';
	}

	if(form.dob_mm.value == '')
	{
		form.dob_mm.style.borderColor='red';
		flag = false;	
		fields.push('dob_mm');
	}
	else
	{
		form.dob_mm.style.borderColor='#B6B6B6';
	}

	if(form.dob_yy.value == '')
	{
		form.dob_yy.style.borderColor='red';
		flag = false;	
		fields.push('dob_yy');
	}
	else
	{
		form.dob_yy.style.borderColor='#B6B6B6';
	}*/

	if(!validEmail(form.email.value))
	{
		form.email.style.borderColor='red';
		flag = false;	
		fields.push('email');
	}
	else
	{
		form.email.style.borderColor='#B6B6B6';
	}
	
	if(form.phone_mobile.value == '')
	{
		form.phone_mobile.style.borderColor='red';
		flag = false;	
		fields.push('mobile_no');
	}
	else
	{
		form.phone_mobile.style.borderColor='#B6B6B6';
	}
	
	/*if(form.address1.value == '')
	{
		form.address1.style.borderColor='red';
		flag = false;	
		fields.push('address1');
	}
	else
	{
		form.address1.style.borderColor='#B6B6B6';
	}*/
	
	if(form.country.value == '')
	{
		form.country.style.borderColor='red';
		flag = false;	
		fields.push('country');
	}
	else
	{
		form.country.style.borderColor='#B6B6B6';
	}
	
	if(form.state.value == '')
	{
		form.state.style.borderColor='red';
		flag = false;	
		fields.push('state');
	}
	else
	{
		form.state.style.borderColor='#B6B6B6';
	}
	
	if(form.iqma_no.value == '')
	{
		form.iqma_no.style.borderColor='red';
		flag = false;	
		fields.push('iqma_no');
	}
	else
	{
		form.iqma_no.style.borderColor='#B6B6B6';
	}
	
	if(form.drive_license_no.value == '')
	{
		form.drive_license_no.style.borderColor='red';
		flag = false;	
		fields.push('drive_license_no');
	}
	else
	{
		form.drive_license_no.style.borderColor='#B6B6B6';
	}
	
	//validate vehicle info
	
	if($('#vehicle_regd_place').val() == '')
	{
		$('#vehicle_regd_place').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_regd_place');
	}
	else
	{
		$('#vehicle_regd_place').css( "border-color", "#999" );
	}

	if($('#vehicle_ownership').val() == '')
	{
		$('#vehicle_ownership').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_ownership');
	}
	else
	{
		$('#vehicle_ownership').css( "border-color", "#999" );
	}

	if($('#vehicle_use').val() == '')
	{
		$('#vehicle_use').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_use');
	}
	else
	{
		$('#vehicle_use').css( "border-color", "#999" );
	}
	
	if(form.vehicle_year_made.value == '')
	{
		form.vehicle_year_made.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_year_made');
	}
	else
	{
		form.vehicle_year_made.style.borderColor='#B6B6B6';
	}
	
	if(form.vehicle_color.value == '')
	{
		form.vehicle_color.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_color');
	}
	else
	{
		form.vehicle_color.style.borderColor='#B6B6B6';
	}
	
	if(form.chassic_no.value == '')
	{
		form.chassic_no.style.borderColor='red';
		flag = false;	
		fields.push('chassic_no');
	}
	else
	{
		form.chassic_no.style.borderColor='#B6B6B6';
	}
	
	if(form.engine_no.value == '')
	{
		form.engine_no.style.borderColor='red';
		flag = false;	
		fields.push('engine_no');
	}
	else
	{
		form.engine_no.style.borderColor='#B6B6B6';
	}
	
	//validate attach document
	var cnt = $('#atch_count').val();
	var is_atch = 0;
	
	/*for(var i=1; i<=cnt; i++)
	{
		if(document.getElementById('#atch_title_'+i))
		{
			if($('#atch_title_'+i).val()=='')
			{
				$('#atch_title_'+i).css( "border-color", "red" );
				flag = false;	
				fields.push('atch_title_'+i);
				is_atch++;
			}
			else
			{
				$('#atch_title_'+i).css( "border-color", "#B6B6B6" );
			}
		}
		if(document.getElementById('#atch_file_'+i))
		{
			if($('#atch_file_'+i).val()=='')
			{
				$('#atch_file_'+i).css( "border-color", "red" );
				flag = false;	
				fields.push('atch_file_'+i);
				is_atch++;
			}
			else
			{
				$('#atch_file_'+i).css( "border-color", "#B6B6B6" );
			}
		}
	}*/

	if(form.insured_period_startdate.value=='')
	{
		form.insured_period_startdate.style.borderColor="red";
		flag= false;
		fields.push('insured_period_startdate');
	}
	else
	{
		form.insured_period_startdate.style.borderColor="#B6B6B6";
	}
	
	/*if(is_atch == '0')
	{
		alert('Attach minimum one document.');
		flag = false;	
	}*/
	
	if(fields.length>0)
	{
		var fld = fields[0];
		
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}

function updateYDetail()
{
	if(document.getElementById('same_as_driver').checked == true)
	{
		$('#is_driver').val(1);	
	}
	else
	{
		$('#is_driver').val(0);	
	}
	//$('#step3_btn').unbind("click.validStep3Form");
	$('#step3_btn').click();
	//$('#step3_btn').click(function() { return true; });
	//document.getElementById('step3_form').submit();
	//$('#step3_form').submit();
}

function validStep4Form()
{
	if(document.getElementById('accept_terms').checked == false)
	{
		alert('Accept terms and conditions');
		return false;	
	}
}
</script>

<?php 

//session_destroy();

$step = $_GET['step']; 
if(empty($step))
	$step = 1;

if($step == 1)
{?>

    <script>
		function validStep1Form(id)
		{
			var form = document.step1_form;
			var flag = true;
			var fields = new Array();
			var pid = $('#policy_type_id').val(); 
		
			if(form.policy_type_id.value == '')
			{
				form.policy_type_id.style.borderColor='red';
				flag = false;	
				fields.push('policy_type_id');
			}
			else
			{
				form.policy_type_id.style.borderColor='#999';
			}
			
			if(pid == 1)
			{
				if($('#vehicle_type_tpl').val() == '')
				{
					$('#vehicle_type_tpl').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_type_tpl');
				}
				else
				{
					$('#vehicle_type_tpl').css( "border-color", "#999" );
				}
			
				if($('#vehicle_cylender').val() == '')
				{
					$('#vehicle_cylender').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_cylender');
				}
				else
				{
					$('#vehicle_cylender').css( "border-color", "#999" );
				}
			
				if($('#vehicle_weight').val() == '')
				{
					$('#vehicle_weight').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_weight');
				}
				else
				{
					$('#vehicle_weight').css( "border-color", "#999" );
				}
			
				if($('#vehicle_seats').val() == '')
				{
					$('#vehicle_seats').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_seats');
				}
				else
				{
					$('#vehicle_seats').css( "border-color", "#999" );
				}
			}
		
			if(pid == 2)
			{ 
				if($('#vehicle_make').val() == '')
				{
					$('#vehicle_make').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_make');
				}
				else
				{
					$('#vehicle_make').css( "border-color", "#999" );
				}
			
				if($('#vehicle_model').val() == '')
				{
					$('#vehicle_model').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_model');
				}
				else
				{
					$('#vehicle_model').css( "border-color", "#999" );
				}
			
				if($('#vehicle_type').val() == '')
				{
					$('#vehicle_type').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_type');
				}
				else
				{
					$('#vehicle_type').css( "border-color", "#999" );
				}
			
				if($('#vehicle_ncd').val() == '' && $('#vehicle_ncd').val() != '0')
				{
					$('#vehicle_ncd').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_ncd');
				}
				else
				{
					$('#vehicle_ncd').css( "border-color", "#999" );
				}
				
				var btn = form.vehicle_agency_repair.length; 
				var cnt = 0;
				for (var i=0; i < btn; i++) 
				{
					if (form.vehicle_agency_repair[i].checked == true) 
					{
						cnt++; 
					}
				}
				if (cnt > 0) 
				{
					$('.agency_rpr').css( "color", "#999" );
				}
				else
				{
					flag = false;	
					$('.agency_rpr').css( "color", "red" );
				}
				
			}
		
			if(fields.length>0)
			{
				var fld = fields[0];
				
				//form.fname.focus();
				$('#'+fld).focus();
				flag = false;	
			}
			return flag;
		}
	
		function showVehicleColumn(val)
		{
			if(val == 1)
			{
				$('.vtype_comp').hide();
				$('.vtype_tpl').show();
			}	
			if(val == 2)
			{
				$('.vtype_comp').show();
				$('.vtype_tpl').hide();
			}
			if(val == '')
			{
				$('.vtype_comp').hide();
				$('.vtype_tpl').hide();
			}
		}
		function getVehicleModel(vmake)
		{
			var data = '';
			$('#vmodel_section').html('Loading...');
			
			if(vmake!='')
			{
				var url = '<?php echo BASE_URL;?>/util/vehicle.php?vehicle_id='+vmake; 
				$.get(url,function(res)
				{
					//alert(res);
					if(res!=0)
					{
						data = res;
					}
					else
					{
						data = '<select id="vehicle_model" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
					}
					$('#vmodel_section').html(data);
				});
			}
			else
			{
				data = '<select id="vehicle_model" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
				$('#vmodel_section').html(data);
			}
			getVehicleType('');
		}
		function getVehicleType(vmodel)
		{
			var data = '';
			$('#vtype_section').html('Loading...');
			
			if(vmodel!='')
			{
				var url = '<?php echo BASE_URL;?>/util/vehicle.php?vehicle_modelid='+vmodel; //alert(url);
				$.get(url,function(res)
				{
					//alert(res);
					if(res!=0)
					{
						data = res;
					}
					else
					{
						data = '<select id="vehicle_model" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
					}
					$('#vtype_section').html(data);
				});
			}
			else
			{
				data = '<select id="vehicle_type" name="vehicle_type" class="dropdown"><option value="">Select</option></select>';
				$('#vtype_section').html(data);
			}
		}
	</script>
    <?php 
	
	//first step submit	
	if(isset($_POST['submit']))
	{
		unset($_POST['submit']);	
		
		$_SESSION['motor']['step_2'] = '1';
		
		$_POST['fname'] = addslashes($_POST['fname']);
		$_POST['lname'] = addslashes($_POST['lname']);
		$_POST['email'] = addslashes($_POST['email']);
		
		if($_POST['policy_type_id'] == 1)
		{
			unset($_POST['vehicle_make']);
			unset($_POST['vehicle_model']);
			unset($_POST['vehicle_type']);
			unset($_POST['vehicle_agency_repair']);
			unset($_POST['vehicle_ncd']);
		}
		else
		{
			unset($_POST['vehicle_type_tpl']);
			unset($_POST['vehicle_cylender']);
			unset($_POST['vehicle_weight']);
			unset($_POST['vehicle_seats']);
		}
		
		$_SESSION['motor']['Vehicle'] = $_POST;
		
		if(!empty($_SESSION['motor']['Vehicle']))
		{
			header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=2');	
		}
	}
	
	$total_vehicles  = count($_SESSION['motor']['Vehicle']);
	$add_more_vehicle_no = $total_vehicles+1;
	
	if(!empty($_SESSION['motor']['Vehicle']))
	{
		//echo '<pre>';print_r($_SESSION['motor']['Vehicle']);echo '</pre>';
		
		$motor = $_SESSION['motor']['Vehicle'];
		
		$policy_type_id = $motor['policy_type_id'];
		
		//Only for comprehensive	
		$vehicle_make = $motor['vehicle_make'];	
		$vehicle_model = $motor['vehicle_model'];	
		$vehicle_type = $motor['vehicle_type'];	
		$vehicle_agency_repair = $motor['vehicle_agency_repair'];	
		$vehicle_ncd = $motor['vehicle_ncd'];	
		
		//Only for tpl	
		$vehicle_type_tpl = $motor['vehicle_type_tpl'];
		$vehicle_cylender = $motor['vehicle_cylender'];	
		$vehicle_weight = $motor['vehicle_weight'];	
		$vehicle_seats = $motor['vehicle_seats'];
		
		//common for both tpl and comprehensive	
		$vehicle_regd_place = $motor['vehicle_regd_place'];	
		$vehicle_ownership = $motor['vehicle_ownership'];	
		$vehicle_use = $motor['vehicle_use'];	
		$vehicle_purchase_year = $motor['vehicle_purchase_year'];	
		
		$fname = $motor['fname'];	
		$lname = $motor['lname'];	
		$email = $motor['email'];	
		$mobile_no = $motor['mobile_no'];	
		$dob_dd = $motor['dob_dd'];	
		$dob_mm = $motor['dob_mm'];	
		$dob_yy = $motor['dob_yy'];	
		$country = $motor['country'];
		
		//TPL policy type
		if($policy_type_id == 1)
		{
			$display_comp_clm = 'style="display:none"';
			$display_tpl_clm = 'style="display:block"';
		}	
		//Comp policy type
		if($policy_type_id == 2)
		{
			$display_comp_clm = 'style="display:block"';
			$display_tpl_clm = 'style="display:none"';
		}	
	}
	else
	{
		$display_tpl_clm = 'style="display:none"';	
	}
}

if($step == 2)
{
	//check step-2 access
	if($_SESSION['motor']['step_2'] != '1')
	{
		header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=1');		
	}
	
	//step-2 submit	
	if(isset($_POST['submit']))
	{
		unset($_POST['submit']);
		$_SESSION['motor']['Package'] = $_POST['package_no'];
		$_SESSION['motor']['step_3'] = '1';
		
		if(!empty($_SESSION['motor']['Package']))
		{
			header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=3');	
		}
			
	}
	
	
	if(!empty($_SESSION['motor']['Vehicle']))
	{
		//echo '<pre>';print_r($_SESSION['motor']['Vehicle']);echo '</pre>';
		
		$motor = $_SESSION['motor']['Vehicle'];
		
		$policy_type_id = $motor['policy_type_id'];
		
		//Only for comprehensive	
		$vehicle_make = $motor['vehicle_make'];	
		$vehicle_model = $motor['vehicle_model'];	
		$vehicle_type = $motor['vehicle_type'];	
		$vehicle_agency_repair = $motor['vehicle_agency_repair'];	
		$vehicle_ncd = $motor['vehicle_ncd'];	
		
		//Only for tpl	
		$vehicle_type_tpl = $motor['vehicle_type_tpl'];
		$vehicle_cylender = $motor['vehicle_cylender'];	
		$vehicle_weight = $motor['vehicle_weight'];	
		$vehicle_seats = $motor['vehicle_seats'];
		
	}
	//For TPL
	if($policy_type_id == 1)
	{
		$pckg_sql = "select * from ".PACKAGE." where policy_type_id=1 and vehicle_type_tpl='".$vehicle_type_tpl."' and status = '1'";
	}
	//For Comp
	if($policy_type_id == 2)
	{
		if($vehicle_agency_repair == 'Yes')
			$vehicle_agency_repair=1;
			
		if($vehicle_agency_repair == 'No')
			$vehicle_agency_repair=0;
		
		
		$pckg_sql = "select * from ".PACKAGE." where policy_type_id='2' and vehicle_make_comp='".$vehicle_make."' and vehicle_model_comp='".$vehicle_model."' 
		and vehicle_type_comp='".$vehicle_type."' and is_agency_repair='".$vehicle_agency_repair."' and no_of_ncd='".$vehicle_ncd."' and status = '1'";
	}
	//echo $pckg_sql;exit;
	$pckg_sql_qry = mysql_query($pckg_sql);
	$total_pkg = mysql_num_rows($pckg_sql_qry);
	
	if(!empty($_SESSION['motor']['Package']))
	{
		$package_no = $_SESSION['motor']['Package'];	
	}
}

if($step == 3)
{
	?>
    
    <script>
    function addAttchment()
    {
		var atch_cnt = parseInt($('#atch_count').val());
		//alert(atch_cnt);
		var cnt = atch_cnt+1;
		
		var data = '<div id="atch_'+cnt+'"><div class="listcross"><div class="row1" style="float:left;width: 48%;clear: inherit;"><lable>Document Title *</lable><input type="text" name="atch_title[]" id="atch_title_'+cnt+'" /></div><div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;"><lable>Attachment *</lable><input type="file" name="atch_file[]" id="atch_file_'+cnt+'" /></div><span class="cross" onclick="delAttchment('+cnt+');">X</span></div>';	
		$('#atch_'+atch_cnt).after(data);
		$('#atch_count').val(cnt);
	}
	
	function delAttchment(id)
	{
		$('#atch_'+id).remove();
		var atch_cnt = parseInt($('#atch_count').val());
		var cnt = atch_cnt-1;
		$('#atch_count').val(cnt);
	}
	function getPolicyEndDate(date1)
	{
		var enddate = '';
		
		var dt  = date1.split('-');
		
		var day = dt[0];
		var month = dt[1];
		var year = dt[2];

		//enddate = month+'/'+day+'/'+(parseInt(year)+1);
		
		enddate = day+'-'+month+'-'+(parseInt(year)+1);
		
		$('#insured_period_enddate').val(enddate);	
		//alert(enddate);
	}
    </script>
    <?php 
	
	//Step-3 submit	
	if(isset($_POST['submit']))
	{
		unset($_POST['submit']);	
		
		unset($_SESSION['motor']['Vehicle']['mobile_no']);
		
		//Allow access to step-4
		$_SESSION['motor']['step_4'] = '1';
		
		//set insurance period date
		$_SESSION['motor']['Policy']['insured_period_startdate'] = $_POST['insured_period_startdate'];	
			unset($_POST['insured_period_startdate']);	
		
		$_SESSION['motor']['Policy']['insured_period_enddate'] = $_POST['insured_period_enddate'];	
			unset($_POST['insured_period_enddate']);	

		$total_atch = count($_POST['atch_title']); 
		//upload_attachments
		$upload_path = 'upload/motr-attchment/';
		
		for($i = 0; $i<$total_atch; $i++)
		{
			if($_FILES['atch_file']['name'][$i]!='')
			{
				$atch_name = time().'_'.rand(1,99999).".".end(explode(".",$_FILES['atch_file']['name'][$i]));
				if(move_uploaded_file($_FILES['atch_file']['tmp_name'][$i],$upload_path.$atch_name))
				{
					$no = count($_SESSION['motor']['Attachment']);
					
					$_SESSION['motor']['Attachment'][$no]['atch_title'] = $_POST['atch_title'][$i];
					unset($_POST['atch_title'][$i]);
					
					$_SESSION['motor']['Attachment'][$no]['atch_file'] = $atch_name;
					unset($_POST['atch_file'][$i]);
				}
				else
				{
					unset($_POST['atch_title'][$i]);
					unset($_POST['atch_file'][$i]);
				}
			}	
		}
		unset($_POST['atch_title']);
		unset($_POST['atch_file']);
		//Add vehicle info
		$_SESSION['motor']['Vehicle']['vehicle_purchase_year'] = $_POST['vehicle_purchase_year'];		
		unset($_POST['vehicle_purchase_year']);
		
		$_SESSION['motor']['Vehicle']['vehicle_regd_place'] = $_POST['vehicle_regd_place'];	
		unset($_POST['vehicle_regd_place']);	
		
		$_SESSION['motor']['Vehicle']['vehicle_ownership'] = $_POST['vehicle_ownership'];	
		unset($_POST['vehicle_ownership']);	
		
		$_SESSION['motor']['Vehicle']['vehicle_use'] = $_POST['vehicle_use'];	
		unset($_POST['vehicle_use']);	
		
		$_SESSION['motor']['Vehicle']['vehicle_year_made'] = $_POST['vehicle_year_made'];	
		unset($_POST['vehicle_year_made']);	
		
		$_SESSION['motor']['Vehicle']['vehicle_color'] = $_POST['vehicle_color'];	
		unset($_POST['vehicle_color']);	
		
		$_SESSION['motor']['Vehicle']['chassic_no'] = $_POST['chassic_no'];	
		unset($_POST['chassic_no']);	
		
		$_SESSION['motor']['Vehicle']['engine_no'] = $_POST['engine_no'];	
		unset($_POST['engine_no']);	
		
		//Save customer detail
		//if driver is customer
		if($_POST['is_driver'] == 1)
		{
			$motor = $_SESSION['motor']['Vehicle'][0];
			$_SESSION['motor']['Your_details']['fname'] = $motor['fname'];
			$_SESSION['motor']['Your_details']['lname'] = $motor['lname'];
			$_SESSION['motor']['Your_details']['email'] = $motor['email'];
			$_SESSION['motor']['Your_details']['mobile_no'] = $motor['mobile_no'];
			$_SESSION['motor']['Your_details']['dob'] = $motor['dob'];
			$_SESSION['motor']['Your_details']['country'] = $motor['country'];
		}
		else
		{
			$_SESSION['motor']['Your_details'] = $_POST;
		}
		
		if(!empty($_SESSION['motor']['Your_details']))
		{
			header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=4');	
		}
		
	}
	
	//check step-3 access
	if($_SESSION['motor']['step_3'] != '1')
	{
		header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=1');		
	}
	
	$is_driver = $_SESSION['motor']['Your_details']['is_driver'];
	$fname = $_SESSION['motor']['Your_details']['fname'];
	$lname = $_SESSION['motor']['Your_details']['lname'];
	$gender = $_SESSION['motor']['Your_details']['gender'];
	$email = $_SESSION['motor']['Your_details']['email'] ;
	$phone_landline = $_SESSION['motor']['Your_details']['phone_landline'] ;
	$phone_mobile = $_SESSION['motor']['Your_details']['phone_mobile'] ;
	$dob = $_SESSION['motor']['Your_details']['dob'];
	/*$dob_dd = $_SESSION['motor']['Your_details']['dob_dd'];
	$dob_mm = $_SESSION['motor']['Your_details']['dob_mm']; 
	$dob_yy = $_SESSION['motor']['Your_details']['dob_yy'];*/
	$address1 = $_SESSION['motor']['Your_details']['address1'];
	$address2 = $_SESSION['motor']['Your_details']['address2'];
	$country = $_SESSION['motor']['Your_details']['country'];
	$state = $_SESSION['motor']['Your_details']['state'];
	$iqma_no = $_SESSION['motor']['Your_details']['iqma_no'];
	$drive_license_no = $_SESSION['motor']['Your_details']['drive_license_no'];
	
	//vehicle info
	$vehicle_purchase_year = $_SESSION['motor']['Vehicle']['vehicle_purchase_year'];
	$vehicle_regd_place = $_SESSION['motor']['Vehicle']['vehicle_regd_place'];
	$vehicle_ownership = $_SESSION['motor']['Vehicle']['vehicle_ownership'];
	$vehicle_use = $_SESSION['motor']['Vehicle']['vehicle_use'];
	$vehicle_year_made = $_SESSION['motor']['Vehicle']['vehicle_year_made'];
	$vehicle_color = $_SESSION['motor']['Vehicle']['vehicle_color'];
	$chassic_no = $_SESSION['motor']['Vehicle']['chassic_no'];
	$engine_no = $_SESSION['motor']['Vehicle']['engine_no'];
	
	$attachments = $_SESSION['motor']['Attachment'];
	//echo '</pre>';print_r($attachments); echo '</pre>';
	
	//Policy info
	$insured_period_startdate = $_SESSION['motor']['Policy']['insured_period_startdate'];
	$insured_period_enddate = $_SESSION['motor']['Policy']['insured_period_enddate'];
		
	if(!empty($_SESSION['motor']['Vehicle']))
	{
		$motor = $_SESSION['motor']['Vehicle'];
		
		$policy_type_id = $motor['policy_type_id'];
		
		//Only for comprehensive
		if($policy_type_id == 2)
		{	
			$vehicle_make = $motor['vehicle_make'];	
			$vehicle_model = $motor['vehicle_model'];	
			$vehicle_type = $motor['vehicle_type'];	
			$vehicle_agency_repair = $motor['vehicle_agency_repair'];	
			$vehicle_ncd = $motor['vehicle_ncd'];	
			
			$vmake_title = getVMake($vehicle_make);
			$vmodel_title = getVModel($vehicle_model);
			$vtype_title = getVType($vehicle_type);
		}
		
		//Only for tpl	
		if($policy_type_id == 1)
		{	
			$vehicle_type_tpl = $motor['vehicle_type_tpl'];
			$vehicle_cylender = $motor['vehicle_cylender'];	
			$vehicle_weight = $motor['vehicle_weight'];	
			$vehicle_seats = $motor['vehicle_seats'];
			$vtype_title = getVType($vehicle_type_tpl);
		}
		
		if(empty($phone_mobile))
			$phone_mobile = $motor['mobile_no'];
	}
}

if($step == 4)
{
	//Step-3 submit	
	if(isset($_POST['submit']))
	{
		unset($_POST['submit']);	
		
		//Allow access to step-4
		$_SESSION['motor']['step_5'] = '1';
		
		$_SESSION['motor']['Accept_terms'] = 1;
		
		if(!empty($_SESSION['motor']['Accept_terms']))
		{
			header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=5');		
		}
	}
	
	//check step-3 access
	if($_SESSION['motor']['step_4'] != '1')
	{
		header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=1');		
	}
	
	//get select package details
	if(!empty($_SESSION['motor']['Package']))
	{
		$pkg = getPackageDetails($_SESSION['motor']['Package']); 
		$pkg_title = stripslashes($pkg->package_title);
		$pkg_desc = stripslashes($pkg->package_desc);
		$pkg_price = number_format($pkg->package_amt,2);
	}

	$accept_terms = $_SESSION['motor']['Accept_terms'];
	
	$is_driver = $_SESSION['motor']['Your_details']['is_driver'];
	$fname = $_SESSION['motor']['Your_details']['fname'];
	$lname = $_SESSION['motor']['Your_details']['lname'];
	$gender = $_SESSION['motor']['Your_details']['gender'];
	$email = $_SESSION['motor']['Your_details']['email'] ;
	$phone_landline = $_SESSION['motor']['Your_details']['phone_landline'] ;
	$phone_mobile = $_SESSION['motor']['Your_details']['phone_mobile'] ;
	//$dob = $_SESSION['motor']['Your_details']['dob_dd'].'-'.$_SESSION['motor']['Your_details']['dob_mm'].'-'.$_SESSION['motor']['Your_details']['dob_yy'];
	
	$dob = $_SESSION['motor']['Your_details']['dob'];
	
	$address1 = $_SESSION['motor']['Your_details']['address1'];
	$address2 = $_SESSION['motor']['Your_details']['address2'];
	$country = $_SESSION['motor']['Your_details']['country'];
	$state = $_SESSION['motor']['Your_details']['state'];
	$iqma_no = $_SESSION['motor']['Your_details']['iqma_no'];
	$drive_license_no = $_SESSION['motor']['Your_details']['drive_license_no'];
	
	//vehicle info
	$vehicle_purchase_year = $_SESSION['motor']['Vehicle']['vehicle_purchase_year'];
	$vehicle_regd_place = $_SESSION['motor']['Vehicle']['vehicle_regd_place'];
	$vehicle_ownership = $_SESSION['motor']['Vehicle']['vehicle_ownership'];
	$vehicle_use = $_SESSION['motor']['Vehicle']['vehicle_use'];
	$vehicle_year_made = $_SESSION['motor']['Vehicle']['vehicle_year_made'];
	$vehicle_color = $_SESSION['motor']['Vehicle']['vehicle_color'];
	$chassic_no = $_SESSION['motor']['Vehicle']['chassic_no'];
	$engine_no = $_SESSION['motor']['Vehicle']['engine_no'];
	
	$attachments = $_SESSION['motor']['Attachment'];
	//echo '</pre>';print_r($attachments); echo '</pre>';
	
	//Policy info
	$insured_period_startdate = $_SESSION['motor']['Policy']['insured_period_startdate'];
	$insured_period_enddate = $_SESSION['motor']['Policy']['insured_period_enddate'];
		
	if(!empty($_SESSION['motor']['Vehicle']))
	{
		$motor = $_SESSION['motor']['Vehicle'];
		
		$policy_type_id = $motor['policy_type_id'];
		
		//Only for comprehensive
		if($policy_type_id == 2)
		{	
			$vehicle_make = $motor['vehicle_make'];	
			$vehicle_model = $motor['vehicle_model'];	
			$vehicle_type = $motor['vehicle_type'];	
			$vehicle_agency_repair = $motor['vehicle_agency_repair'];	
			$vehicle_ncd = $motor['vehicle_ncd'];	
			
			$vmake_title = getVMake($vehicle_make);
			$vmodel_title = getVModel($vehicle_model);
			$vtype_title = getVType($vehicle_type);
		}
		
		//Only for tpl	
		if($policy_type_id == 1)
		{	
			$vehicle_type_tpl = $motor['vehicle_type_tpl'];
			$vehicle_cylender = $motor['vehicle_cylender'];	
			$vehicle_weight = $motor['vehicle_weight'];	
			$vehicle_seats = $motor['vehicle_seats'];
			$vtype_title = getVType($vehicle_type_tpl);
		}
		
	}
}
//unset($_SESSION['motor']['Your_details']);
//unset($_SESSION['motor']['Vehicle']['created_date']); exit; 
if($step == 5)
{
	//Step-3 submit	
	if(isset($_POST['card_no']))
	{
		//unset($_POST['submit']);	
		
		$cc_exp = $_POST['card_exp_mm']."/".$_POST['card_exp_yy'];
		$card_no = $_POST['card_no'];
		
		$fname = $_SESSION['motor']['Your_details']['fname'];
		$lname = $_SESSION['motor']['Your_details']['lname'];
		$phone_mobile = $_SESSION['motor']['Your_details']['phone_mobile'];
		$email = $_SESSION['motor']['Your_details']['email'];
		$dob = $_SESSION['motor']['Your_details']['dob'];
		//$dob = $_SESSION['motor']['Your_details']['dob_dd'].'-'.$_SESSION['motor']['Your_details']['dob_mm'].'-'.$_SESSION['motor']['Your_details']['dob_yy'];
		$dob = date("Y-m-d", strtotime($dob));
		
		$package_no = $_SESSION['motor']['Package'];
		
		$card_no = $_POST['card_no'];
		
		$package_name = $_POST['package_name'];
		
		$total_payment_amount = $_POST['total_payment_amount'];
		
		if(($total_payment_amount == '0.00') || empty($total_payment_amount))
		{
			$total_payment_amount = '0.01';	
		}
		
		$ip_add = str_replace('.','',$_SERVER['SERVER_ADDR']);
		
		//paypal credit card payment
		
		// do payment
		$payment_type = "Sale";
		$card_type = $_POST['card_type'];
		$exp_date  = $_POST['card_exp_mm'].$_POST['card_exp_yy'];
		$cvv_no = $_POST['cvv_no'];
		$country_code  = 'USA';
		/*$currency_code  = 'SAR';
		$country_code  = 'USA';*/
		$currency_code  = 'USD';
		
		
		$resArray = DirectPayment ( $payment_type, $total_payment_amount, $card_type, $card_no,
									$exp_date, $cvv_no, $fname, '', '', 
									$country_code, $currency_code ); 
		
		$ack = strtoupper($resArray["ACK"]);
		
		//echo '<pre>'; print_r($resArray); echo '</pre>'; 
		
		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{
			//on payment success
			$transaction_id = urldecode($resArray["TRANSACTIONID"]);
			$payment_date = date('Y-m-d H:i:s', strtotime($_POST['TIMESTAMP']));
			//make pdf
			
			$pdf_url = BASE_URL.'util/pdf.php';
			
			//$pdf_url = BASE_URL.'index.php?page=pdf';
			
			// create a new cURL resource
			$ch = curl_init();
			
			// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_URL, $pdf_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			
			// grab URL and pass it to the browser
			curl_exec($ch);
			
			// close cURL resource, and free up system resources
			curl_close($ch);	
			
			
			
			unset($_SESSION['motor']['Your_details']['is_driver']);
			unset($_SESSION['motor']['Your_details']['dob']);
		
			
			//get customer code
			$customer_code = get_code(USERTBL,'customer_code','id');
			
			//Add customer
			$user = $_SESSION['motor']['Your_details'];
			$user['customer_code'] = $customer_code; 
			$user['dob'] = $dob;
			$user['created_date'] = date('Y-m-d H:i:s'); 
			
			unset($_SESSION['motor']['Vehicle']['created_date']);	
			unset($_SESSION['motor']['Vehicle']['quote_key']);	
			
			//check user
			if($db->isExists('email',array('email'=>$email),USERTBL))
			{
				//get user details	
				$reg_user_deatil = $db->recordFetch($email,USERTBL.":".'email');
				$customer_code = getElementVal('customer_code',$reg_user_deatil);
			} 
			else
			{
				//insert into user table
				$result = $db->recordInsert($user,USERTBL,'');
				if($result == 1)
				{
					$uid = mysql_insert_id();
					$login['uid'] =  $uid;
					$login['uname'] =  $email;
					$login['user_type'] =  'U';
					$login['login_status'] =  '1';
					$pwd = rand();
					$login['pwd'] =  base64_encode($pwd);
					
					//insert into login table
					$insert_login = $db->recordInsert($login,LOGINTBL,'');
					
					$user_subject = 'Your Account Information.';
					$user_email_msg = 'Dear '.$fname.'<br><br>Your Account is successfully created at '.SITE_NAME.'.<br>Please follow your login credentials below,<br><strong>Username:</strong>'.$email.'<br>'.'<strong>Password:</strong>'.$pwd.
					'<br><br>Regards,<br>'.SITE_NAME;
				
					//Email account details to the customer
					//mail($email,$subject,$msg);	
		
					$user_mail = new PHPMailer;
					
					$user_mail->From = SITE_EMAIL;
					$user_mail->FromName = SITE_NAME;
					$user_mail->addAddress($email, $fname.' '.$lname);
					
					$user_mail->isHTML(true);  // Set email format to HTML
					
					$user_mail->Subject = $user_subject;
					
					$user_mail->Body    = $user_email_msg;
					
					if(!$user_mail->send()) { }
				
				}
			}
			
				
		
			
			//Insert into policy master table
			//get policy no
			$policy_no = get_code(POLICYMASTER,'policy_no','id');
	
			//set policy master array
			$insured_period_startdate = $_SESSION['motor']['Policy']['insured_period_startdate'];
			$insured_period_enddate = $_SESSION['motor']['Policy']['insured_period_enddate'];
			
			$policy_master = '';
			
			$policy_master['insured_period_startdate'] = date("Y-m-d", strtotime($insured_period_startdate));
			$policy_master['insured_period_enddate'] = date("Y-m-d", strtotime($insured_period_enddate));
			$policy_master['policy_no'] = $policy_no;
			$policy_master['package_no'] = $package_no;
			$policy_master['customer_id'] = $customer_code;
			$policy_master['policy_class_id'] = $_SESSION['motor']['Vehicle']['policy_class_id'];
			$policy_master['policy_type_id'] = $_SESSION['motor']['Vehicle']['policy_type_id'];
			$policy_master['doc_type_id'] = 1;
			$policy_master['doc_key'] = "AC/".date("Y")."/".$policy_no;
			$policy_master['quotation_key'] = $_SESSION['motor']['Quote_key'];
			$policy_master['policy_year'] = date('Y');
			$policy_master['insured_period_known'] = 'Yes';
			$policy_master['insured_period'] = 1;
			$policy_master['insured_period_type'] = 'year';
			$policy_master['insured_timezon'] = 'UAE';
			$policy_master['debit_account'] = 'Yes';
			$policy_master['insured_person'] = $fname.' '.$lnme;
			$policy_master['payment_term'] = 1;
			$policy_master['registry_date'] = date('Y-m-d H:i:s');
			$policy_master['uw_year'] = date('Y');
			$policy_master['is_complete'] = 1;
			$policy_master['policy_by'] ='Online';
	
			//Insert into policy master table
			$insert_policy_master = $db->recordInsert($policy_master,POLICYMASTER,'');
			if($insert_policy_master == 1)
			{
				$policy_motor = '';
				$policy_motor = $_SESSION['motor']['Vehicle'];	
				$policy_motor['is_canceled'] = 0;
				$policy_motor['first_name'] = $fname;
				$policy_motor['last_name'] = $lname;
				$policy_motor['email'] = $email;
				$policy_motor['mobile_no'] = $phone_mobile;
				$policy_motor['dob'] = $dob; 
				$policy_motor['country'] = $_SESSION['motor']['Your_details']['country'];
				$policy_motor['customer_id'] = $customer_code;
				$policy_motor['policy_no'] = $policy_no;
				$policy_motor['package_no'] = $package_no;
				
				unset($policy_motor['fname']);
				unset($policy_motor['lname']);
				
				//echo '<pre>'; print_r($policy_motor); echo '</pre>'; exit;
				
				//Insert into policy motor table
				$insert_policy_motor = $db->recordInsert($policy_motor,POLICYMOTOR,'');
				
				if($insert_policy_motor == 1)
				{
					//get package covers
					$pkg_covers = $db->recordArray($package_no,PACKAGECOVER.':package_no');
					while($pkg_cover = mysql_fetch_array($pkg_covers))
					{
						//echo '<pre>'; print_r($pkg_cover);echo '</pre>';
						//Insert policy covers
						$policy_cover = '';
						$policy_cover['policy_no'] = $policy_no;
						$policy_cover['package_no'] = $package_no;
						$policy_cover['customer_id'] = $customer_code;
						$policy_cover['cover_id'] = $pkg_cover['cover_id'];
						$policy_cover['cover_amt'] = $pkg_cover['cover_amt'];
						$policy_cover['coverage'] = $pkg_cover['coverage'];
						
						//Insert into policy cover table
						$insert_policy_cover = $db->recordInsert($policy_cover,POLICYCOVERS,'');
					}
					
					//Insert customer attachments
					if(!empty($_SESSION['motor']['Attachment']))
					{
						$atchments = $_SESSION['motor']['Attachment'];	
						foreach($atchments as $atchment)
						{
							$policy_attachment = '';
							$policy_attachment = $atchment;
							$policy_attachment['customer_id'] = $customer_code;
							$policy_attachment['policy_no'] = $policy_no;
							$policy_attachment['atch_date'] = date('Y-m-d H:i:s');
							
							//Insert into policy attachment table
							$insert_policy_attachment = $db->recordInsert($policy_attachment,POLICYATTACHMENTS,'');	
						}
					}
					
					//Insert into payment table
					$payment_data = '';
					$payment_data['policy_no'] = $policy_no;
					$payment_data['customer_id'] = $customer_code;
					$payment_data['policy_amount'] = $total_payment_amount;
					$payment_data['amount_paid'] = $total_payment_amount;
					$payment_data['transaction_id'] = $transaction_id;
					$payment_data['payment_mode'] = 'online';
					$payment_data['payment_processor'] = 'credit card';
					$payment_data['payment_status'] = '1';
					$payment_data['paid_date'] = date('Y-m-d H:i:s');
					
					$insert_policy_payment = $db->recordInsert($payment_data,POLICYPAYMENTS,'');
					
					//Redirect to success page on payment success
					if($insert_policy_payment == 1)
					{
						
						$pdf_file_path = BASE_URL.'upload/pdfReports/'.$policy_no.'.pdf';			
						$pdf_download_link = 'Policy- <a href="'.$pdf_file_path.'" target="_blank">'.$policy_no.'</a>';
						
						//Email to customer
						
						$mail = new PHPMailer;
						
						$mail->From = SITE_EMAIL;
						$mail->FromName = SITE_NAME;
						$mail->addAddress($email, $fname.' '.$lname);
						
						//Attach pdf document
						$dir = $_SERVER['DOCUMENT_ROOT'];
						$pdfdoc = $dir."/alsagr/upload/pdfReports/".$policy_no.".pdf";
						$mail->addAttachment($pdfdoc);  
						
						$mail->isHTML(true);  // Set email format to HTML
						
						$mail->Subject = 'Policy Purchase Confirmation.';
						
						$contact_us_link = '<a href="'.BASE_URL.'index.php?page=contact-us" target="_blank">contact us</a>';
						
						$email_content = 'Dear '.$fname.'<br><br>You have successfully purchased Motor Insurance Policy at '.SITE_NAME.' with Policy No: '.$policy_no.'.<br><br>
						Your policy details are enclosed in the attached PDF below.<br>If you find any problem in getting your policy attachment, 
						<br>Please click here to '.$contact_us_link.'.<br><br>Regards,<br>'.SITE_NAME;
						
						$mail->Body    = $email_content;
						
						if(!$mail->send()) { 
						  /* echo 'Message could not be sent.';
						   echo 'Mailer Error: ' . $mail->ErrorInfo;*/
						}
						
						session_destroy();
						//unset($_SESSION['Motor']);
						
						header('Location: '.BASE_URL.'index.php?page=paymentsuccess');	
					}	
				}
			}
			
		}
		else
		{
			//Display a user friendly Error on the page using any of the following error information returned by PayPal
			$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
			$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
			$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
			$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
			
			$error_msg = 'Your payment transaction is failed. Try again';
		}
	}
	
	//check step-3 access
	if($_SESSION['motor']['step_5'] != '1')
	{
		header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=1');		
	}
	
	//get select package details
	if(!empty($_SESSION['motor']['Package']))
	{
		$pkg = getPackageDetails($_SESSION['motor']['Package']); 
		$pkg_title = stripslashes($pkg->package_title);
		$pkg_desc = stripslashes($pkg->package_desc);
		$pkg_price = number_format($pkg->package_amt,2);
	}
	//Policy info
	$insured_period_startdate = $_SESSION['motor']['Policy']['insured_period_startdate'];
	$insured_period_enddate = $_SESSION['motor']['Policy']['insured_period_enddate'];
}

if($policy_type_id == 1)
{
	$policy_type_name = 'TPL';	
}
else
{
	$policy_type_name = 'Comprehensive';	
}
?>


<div class="innrebodypanel">
        <div class="clearfix" style="height:15px;">.</div>
        <div class="innerwrap">
        
            <div class="auto__ins_head">
                <div class="dataseedin">
                  <div style="float:left; width:222px; height:auto; margin-right:10px;">
                    <h1>Motor Insurance</h1>
                    <div class="clearfix" style="height:7px;"></div>
                    <strong><?php echo $policy_type_name;?> Motor Insurance</strong>
                  </div>
                  
                  
                  <div class="step_area">
                    <div class="step_area_line"></div>
                    
                    <div class="step1 <?php if($step == 1){echo 'active';}?>" onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=motor-insurance&step=1'">
                      <div style="margin-top:5px;">Your Vehicle</div>
                    </div>
                    
                    <div class="step2 <?php if($step == 2){echo 'active';}?>" 
                    <?php if(!empty($_SESSION['motor']['step_2'])){?>onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=motor-insurance&step=2'"<?php }?>>
                      <div style="margin-top:5px;">Quotation</div>
                    </div>
                    
                    <div class="step3 <?php if($step == 3){echo 'active';}?>" 
                    <?php if(!empty($_SESSION['motor']['step_3'])){?>onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=motor-insurance&step=3'"<?php }?>>
                      <div style="margin-top:5px;">Your Details</div>
                    </div>
                    
                    <div class="step4 <?php if($step == 4){echo 'active';}?>" 
                    <?php if(!empty($_SESSION['motor']['step_4'])){?>onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=motor-insurance&step=4'"<?php }?>>
                      <div style="margin-top:5px;">Summary</div>
                    </div>
                    
                    <div class="step5 <?php if($step == 5){echo 'active';}?>" 
                    <?php if(!empty($_SESSION['motor']['step_5'])){?>onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=motor-insurance&step=5'"<?php }?>>
                      <div style="margin-top:5px;">Payment</div>
                    </div>
                    
                  </div>
                  
                </div>
            </div>
            <div class="clearfix" style="height:10px;"></div>
            
            <div class="leftbokpan">
                 <div id="formpan" class="formpan2 formpan5">
                 	<?php if($step == 1)
					{?>
                    	<form name="step1_form" id="step1_form" method="post">
                            <h1 style="background: green; color:#fff; text-align:center;font-weight: bold;">
                                Vehicle Information
                            </h1>
                			<div class="padding15" style="padding-top:10px;">
                            <div class="row1">
                                    <lable>Insurance Type</lable>
                                    <?php if(!empty($policy_type_id))
                                    {
                                        echo '<input type="hidden" name="policy_type_id" value="'.$policy_type_id.'" />';	
                                    }?>
                                    <select <?php if(empty($policy_type_id)){?>name="policy_type_id"<?php }else{echo 'disabled="disabled"';}?> id="policy_type_id" class="dropdown" onchange="showColumn(this.value);">
                                        <!--<option value="">Insurance type</option>-->
                                        <?php
                                        $policy_types_sql = "select a.* from ".POLICYTYPES." as a inner join ".PRODUCTS." as b on a.policy_id=b.id where a.status='1' order by a.policy_type asc";
                                        $policy_types = mysql_query($policy_types_sql);
                                        while($policy_type = mysql_fetch_array($policy_types))
                                        {?>
                                            <option value="<?php echo $policy_type['id'];?>" <?php if($policy_type_id == $policy_type['id']){echo 'selected="selected"';}?>><?php echo $policy_type['policy_type'];?></option>
                                        <?php }  ?>
                                    </select>
                                    
                                </div>
                                
                            <div class="row1 vtype_comp" <?php echo $display_comp_clm;?>>
                                    <lable>Vehicle Make</lable>
                                    <select id="vehicle_make" name="vehicle_make" class="dropdown" onchange="getVehicleModel(this.value);">
                                        <option value="">Select</option>
                                        <?php
                                        $vmakes_sql = "select * from ".VMAKE." where status='1' order by make asc";
                                        $vmakes = mysql_query($vmakes_sql);
                                        while($vmake = mysql_fetch_array($vmakes))
                                        {?>
                                            <option value="<?php echo $vmake['id'];?>" <?php if($vehicle_make == $vmake['id']){echo 'selected="selected"';}?>>
                                                <?php echo $vmake['make'];?>
                                            </option>
                                        <?php }?>
                                    </select>
                              </div>
                                
                            <div class="row1 vtype_comp" <?php echo $display_comp_clm;?>>
                                <lable>Vehicle Model</lable>
                                <span id="vmodel_section">
                                <select id="vehicle_model" name="vehicle_model" class="dropdown" onchange="getVehicleType(this.value);">
                                    <option value="">Select</option>
                                    <?php
                                    if(!empty($vehicle_make))
                                    {
                                        $vmodels_sql = "select * from ".VMODEL." where make_id='".$vehicle_make."' and status='1' order by model asc";
                                        $vmodels = mysql_query($vmodels_sql);
                                        while($vmodel = mysql_fetch_array($vmodels))
                                        {?>
                                            <option value="<?php echo $vmodel['id'];?>" <?php if($vehicle_model == $vmodel['id']){echo 'selected="selected"';}?>>
                                                <?php echo $vmodel['model'];?>
                                            </option>
                                        <?php }
                                    }?>
                                </select>
                                </span>
                            </div>
                            
                            <div class="row1 vtype_comp" <?php echo $display_comp_clm;?>>
                                <lable>Vehicle Type</lable>
                                <span id="vtype_section">
                                <select id="vehicle_type" name="vehicle_type" class="dropdown">
                                    <option value="">Select</option>
                                    <?php
                                    if(!empty($vehicle_model))
                                    {
                                        $vtypes_sql = "select * from ".VTYPE." where model_id='".$vehicle_model."' and status='1' order by type_name asc";
                                        $vtypes = mysql_query($vtypes_sql);
                                        while($vtype = mysql_fetch_array($vtypes))
                                        {?>
                                            <option value="<?php echo $vtype['id'];?>" <?php if($vehicle_type == $vtype['id']){echo 'selected="selected"';}?>>
                                                <?php echo $vtype['type_name'];?>
                                            </option>
                                        <?php }
                                    }?>
                                </select>
                                </span>
                            </div>
                            
            
                            <div class="row1 vtype_tpl" <?php echo $display_tpl_clm;?>>
                                <lable>Vehicle Type</lable>
                               <select name="vehicle_type_tpl" id="vehicle_type_tpl"  class="dropdown">
                                   <option value="">-Select type-</option>
                                   <?php 
                                    $vehicletypesql = mysql_query("select * from ".VTYPE." where make_id='0'");
                                     ?>
                                     <?php while($myrow = mysql_fetch_array($vehicletypesql)): ?>
                                    <option value="<?=$myrow["id"]?>" <?php if($vehicle_type_tpl == $myrow['id']){echo 'selected="selected"';}?>><?=$myrow["type_name"]?></option>
                                <?php endwhile; ?>
                                    
                               </select>
                            </div>
                    
                            <div class="row1 vtype_tpl" <?php echo $display_tpl_clm;?>>
                                <lable>Vehicle Cylinder </lable>
                                <select name="vehicle_cylender" id="vehicle_cylender"  class="dropdown">
                                    <option value="">-Select-</option>
                                    <option value="4" <?php if($vehicle_cylender == 4){echo 'selected="selected"';}?>>4</option>
                                    <option value="6" <?php if($vehicle_cylender == 6){echo 'selected="selected"';}?>>6</option>
                                    <option value="8" <?php if($vehicle_cylender == 8){echo 'selected="selected"';}?>>8</option>
                                    <option value="More than 8" <?php if($vehicle_cylender == 'More than 8'){echo 'selected="selected"';}?>>More than 8</option>
                                </select>
                            </div>
                            
                            <div class="row1 vtype_tpl" <?php echo $display_tpl_clm;?>>
                                <lable>Vehicle Weight </lable>
                                <select name="vehicle_weight" id="vehicle_weight"  class="dropdown">
                                    <option value="">-Select-</option>
                                    <?php 
                                    for($wt=1; $wt<=4; $wt++)
                                    {?>
                                         <option value="<?php echo $wt;?>" <?php if($vehicle_weight == $wt){echo 'selected="selected"';}?>><?php echo $wt;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            
                            <div class="row1 vtype_tpl" <?php echo $display_tpl_clm;?>>
                                <lable>Vehicle Seats</lable>
                                <select name="vehicle_seats" id="vehicle_seats"  class="dropdown">
                                    <option value="">-Select-</option>
                                    <?php 
                                    for($seat=1; $seat<=8; $seat++)
                                    {?>
                                         <option value="<?php echo $seat;?>" <?php if($vehicle_seats == $seat){echo 'selected="selected"';}?>><?php echo $seat;?></option>
                                    <?php }?>
                                </select>
                            </div>
                    
                            
                            
                            <?php /*?><div class="row1">
                                <lable>Vehicle Regd. Place</lable>
                                <input type="text" autocomplete="off" name="vehicle_regd_place" id="vehicle_regd_place" value="<?php echo $vehicle_regd_place;?>">
                            </div>
                            
                            <div class="row1">
                                <lable>Vehicle Ownership</lable>
                                <select id="vehicle_ownership" name="vehicle_ownership" class="dropdown">
                                    <option value="">Select</option>
                                    <option value="Financed" <?php if($vehicle_ownership == 'Financed'){echo 'selected="selected"';}?>>Financed</option>
                                    <option value="Owned" <?php if($vehicle_ownership == 'Owned'){echo 'selected="selected"';}?>>Owned</option>
                                    <option value="Leased" <?php if($vehicle_ownership == 'Leased'){echo 'selected="selected"';}?>>Leased</option>
                                </select>
                            </div>
                            
                            <div class="row1">
                                <lable>Vehicle Use</lable>
                               
                                <select id="vehicle_use" name="vehicle_use" class="dropdown">
                                    <option value="">Select</option>
                                    <option value="Private" <?php if($vehicle_use == 'Private'){echo 'selected="selected"';}?>>Private</option>
                                    <option value="Business" <?php if($vehicle_use == 'Business'){echo 'selected="selected"';}?>>Business</option>
                                    <option value="Occasional" <?php if($vehicle_use == 'Occasional'){echo 'selected="selected"';}?>>Occasional</option>
                                </select>
                            </div><?php */?>
                            
                            <div class="row1 vtype_comp" <?php echo $display_comp_clm;?>>
                                <lable class="agency_rpr" style="float:left;">Agency Repair </lable>
                                <div class="radoipan" style="float:left !important; margin-bottom:5px; margin-top:0px;">
                                    <input type="radio" id="vehicle_agency_repair" class="radio" name="vehicle_agency_repair" value="Yes" style=" width: 13%;" <?php if($vehicle_agency_repair=='Yes'){echo 'checked="checked"';}?> />
                                    <span style="color:#000000">Yes</span>
                                    
                                    <input type="radio" id="vehicle_agency_repair2" class="radio" name="vehicle_agency_repair" value="No" style=" width: 13%;" <?php if($vehicle_agency_repair=='No'){echo 'checked="checked"';}?> />
                                    <span style="color:#000000">No</span>
                                </div>
                            </div>
                            <div class="clearfix" style="height:5px;"></div>
                            <div class="row1 vtype_comp" <?php echo $display_comp_clm;?>>
                                <lable>No Claim Discount (NCD)</lable>
                                <select id="vehicle_ncd" name="vehicle_ncd" class="dropdown" style="margin-top:7px;">
                                    <option value="">Select</option>
                                    <?php
                                    for($n=0; $n<=5; $n++)
                                    {
                                        $ncd_selected = '';
                                        if($vehicle_ncd == $n)
                                            $ncd_selected = 'selected="selected"';
                                        echo '<option value="'.$n.'" '.$ncd_selected.'>'.$n.'</option>';
                                    }?>
                                </select>
                            </div>
                        
                            <?php /*?><div class="row1">
                                <lable>Purchase year</lable>
                                <select id="vehicle_purchase_year" name="vehicle_purchase_year" class="dropdown" style="margin-top:7px;">
                                    <?php  $starting_year  =date('Y', strtotime('-20 year'));
                                    $ending_year = date('Y'); 
                                    
                                    for($starting_year; $starting_year <= $ending_year; $starting_year++) 
                                    {
                                        $vehicle_purchase_year_selctd = '';
                                        if($vehicle_purchase_year == $starting_year)
                                        { 
                                            $vehicle_purchase_year_selctd = 'selected="selected"';
                                        }
                                        else
                                        {
                                            if($starting_year == date('Y'))	
                                                $vehicle_purchase_year_selctd = 'selected="selected"';
                                        }
                                        echo '<option value="'.$starting_year.'" '.$vehicle_purchase_year_selctd.'>'.$starting_year.'</option>';
                                    }  ?>
                                </select>
                            </div><?php */?>
                        
                            <?php /*?><div class="row1">
                                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Driver's Information!</strong></lable>
                            </div>
                            
                            <div class="row1">
                                <lable>First Name  *</lable>
                                <input type="text" autocomplete="off" name="fname" id="fname" value="<?php echo $fname;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Last name </lable>
                                <input type="text" autocomplete="off" name="lname" id="lname" value="<?php echo $lname;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Email   *</lable>
                                <input type="text" autocomplete="off" name="email" id="email" value="<?php echo $email;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Mobile no   *</lable>
                                <input type="text" autocomplete="off" name="mobile_no" id="mobile_no"  onkeypress="return isNumberKey(event)" value="<?php echo $mobile_no;?>" />
                            </div>
                            
                            
                            <div class="row1">
                                <lable>Date of Birth *</lable>
                                <input type="text" autocomplete="off" class="date_picker2" name="dob" id="dob" value="<?php echo $dob;?>">
                            </div>
                            
                            
                            <div class="row1">
                                <lable>Country  *</lable>
                                <select id="country" name="country" class="dropdown">
                                    <option value="">-Select-</option>
                                    <option value="AGRA" <?php if($country=='AGRA'){echo 'selected="selected"';}?>>AGRA</option>
                                </select>
                            </div>
                            <?php */?>
                            <div style="font-size: 11px;clear: both; font-family:Arial, Helvetica, sans-serif; position:relative; top:8px; color:red;">
                              * Required Fields
                              <br><br>
                            </div>
                            <div class="clearfix" style="height:5px;"></div>
                            <div style="text-align:center"><input type="submit" class="submit_button" name="submit" value="Get a quote" onclick="return validStep1Form(<?php echo $m;?>);" /></div>
                            <!--<input type="reset" class="submit_button" value="Clear" style="width: 100px;float: right;margin-right: 10px;" />-->
                            </div>
                    </form>
					<?php }
					if($step == 2)
					{?>
                    	<form name="step2" id="step2" method="post">
                            <h1 style="background: green; color:#fff; text-align:center;font-weight: bold;">
                                Quotation
                            </h1>
                            <div class="padding15" style="padding-top:1px"> 
                            <?php 
                            if($total_pkg > 0)
                            {
                                while($pkg = mysql_fetch_array($pckg_sql_qry))
                                {
                                    //echo '<pre>'; print_r($pkg); echo '</pre>';
                                    ?>
                                    <div class="packageslist ">
                                        <div class="search_box_two">
                                          <div class="listTL">
                                               <table cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td width="30" valign="top">
                                                                <input type="radio" name="package_no" value="<?php echo $pkg['package_no'];?>" <?php if($package_no == $pkg['package_no']){echo 'checked="checked"';}?> style="float: left;" />
                                                            </td>
                                                            <td width="460" valign="top">
                                                                <strong><?php echo stripslashes($pkg['package_title']);?></strong>
                                                                <div class="clearfix" style="height:10px;"></div>
                                                                <p>
                                                                    <?php echo stripslashes($pkg['package_desc']);?>
                                                                </p>
                                                                <a href="javascript:void(0);" class="covgr" onclick="showCoverageDetail('<?php echo $pkg['id'];?>');">View Coverage</a>
                                                            </td>
                                                            <td valign="middle" width="100" class="priceTL">
                                                                <?php echo number_format($pkg['package_amt'],2);?><br><span>SAR</span>
                                                            </td>
                                                        </tr>
                                                   </tbody>
                                               </table>
                                         </div>
                                        </div>
                                        
                                        <!--Coverage list-->
                                        <div id="cvg_detail_<?php echo $pkg['id'];?>" class="covg_details" style="display:none;">
                                            <h2><?php echo stripslashes($pkg['package_title']);?></h2>
                                            <?php
											$pkg_covers = $db->recordArray($pkg['package_no'],PACKAGECOVER.':package_no');
											if(mysql_num_rows($pkg_covers)>0)
											{
												echo '<ul>';
												while($pkg_cover = mysql_fetch_array($pkg_covers))
												{
													echo '<li>'.getCoverTitle($pkg_cover['cover_id']).'</li>';
												}
												echo '</ul>';
											}
											else
											{
												echo 'No coverage found.';	
											}?>
                                        </div>
                                                    
                                    </div>
                                    <?php 
                                }	?>
                                 <div class="clearfix" style="height:10px;"></div>
                                <input type="submit" class="submit_button" name="submit" value="Buy now" style="width: 30%;" onclick="return validStep2Form(1);" />
                                <?php 
                            }
                            else
                            {
                               ?>
                               <div style="min-height:100px;">
                               No package found as per your search.
                               </div>
                               <?php 	
                            }
                            ?>
                            </div>
                           
                        </form>
					<?php }
					if($step == 3)
					{?>
                        <form name="step3_form" id="step3_form" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="is_driver" id="is_driver" value="0" />
                            <h1 style="background: green; color:#fff; text-align:center;font-weight: bold;">
                                Policy Holder's detail
                            </h1>
                            
                            <div class="padding15">
                            <?php if(!empty($_SESSION['motor']['Vehicle']['fname']))
							{?>
                                <div class="row1">
                                    <lable></lable>
                                    <input type="checkbox"  <?php if($is_driver == 1){echo 'checked="checked"';}?> id="same_as_driver" value="1" onchange="updateYDetail();" />
                                    Same as driver
                                </div>
                            <?php }?>
                            <div class="row1">
                                <lable>Name  *</lable>
                                <input type="text" autocomplete="off" name="fname" id="fname" value="<?php echo $fname;?>" />
                            </div>
                            
                            <?php /*?><div class="row1">
                                <lable>Last name </lable>
                                <input type="text" autocomplete="off" name="lname" id="lname" value="<?php echo $lname;?>" />
                            </div><?php */?>
                            
                            <div class="row1">
                                <lable>Date of Birth *</lable>
                                <?php /*?><div class="clearfix" style="height:5px;"></div>
                                <input type="text" autocomplete="off" maxlength="2" placeholder="DD" name="dob_dd" value="<?php echo $dob_dd;?>" id="dob_dd" onkeypress="return isNumberKey(event)" style="width:110px;float: left;margin-right: 10px;">
                                <div style="width: auto;float: left;margin-right: 10px;margin-top: 5px;border-bottom: 1px solid gray;">&nbsp;&nbsp;</div>
                                <input type="text" autocomplete="off" maxlength="2" placeholder="MM" name="dob_mm" value="<?php echo $dob_mm;?>" id="dob_mm" onkeypress="return isNumberKey(event)" style="width:110px;float: left;margin-right: 10px;">
                                <div style="width: auto;float: left;margin-right: 10px;margin-top: 5px;border-bottom: 1px solid gray;">&nbsp;&nbsp;</div>
                                <input type="text" autocomplete="off" maxlength="4" placeholder="YYYY" name="dob_yy" value="<?php echo $dob_yy;?>" id="dob_yy" onkeypress="return isNumberKey(event)" style="width:200px;float: left;"><?php */?>
                           		<input type="text" autocomplete="off" name="dob" class="" id="dob" value="<?php echo $dob;?>">
                            </div>
                            
                            <div class="row1">
                                <lable>Gender </lable>
                                <div class="radoipan" style="float:left;">
                                    <input type="radio" id="genderm" class="radio" name="gender" value="m" <?php if($gender!='f'){echo 'checked="checked"';}?> style=" width: 13%;">
                                    <span style="color:#000000">Male</span>
                                    
                                    <input type="radio" id="genderf" class="radio" name="gender" value="f" <?php if($gender=='f'){echo 'checked="checked"';}?> style=" width: 13%;">
                                    <span style="color:#000000">Female</span>
                                </div>
                            </div>
                            <div class="clearfix" style="height:5px;"></div>
                            
                            <div class="row1">
                                <lable>Email   *</lable>
                                <input type="text" autocomplete="off" name="email" id="email" value="<?php echo $email;?>" />
                            </div>
                            
                            <?php /*?><div class="row1">
                                <lable>Phone (Landline) *</lable>
                                <input type="text" autocomplete="off" name="phone_landline" id="phone_landline"  onkeypress="return isNumberKey(event)" value="<?php echo $phone_landline;?>" />
                            </div><?php */?>
                            
                            <div class="row1">
                                <lable>Phone (Mobile) *</lable>
                                <input type="text" autocomplete="off" name="phone_mobile" id="phone_mobile"  onkeypress="return isNumberKey(event)" value="<?php echo $phone_mobile;?>" />
                            </div>
                                        
                            <?php /*?><div class="row1">
                                <lable>Address *</lable>
                                <input type="text" name="address1" id="address1" value="<?php echo $address1;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Address (Temporary) *</lable>
                                <input type="text" name="address2" id="address2" value="<?php echo $address2;?>" />
                            </div><?php */?>
                                        
                            <div class="row1">
                                <lable>Country  *</lable>
                                <select id="country" name="country" class="dropdown">
                                    <!--<option value="">-Select-</option>-->
                                    <option value="Saudi Arabia" <?php if($country == 'Saudi Arabia'){echo 'selected="selected"';}?>>Saudi Arabia</option>
                                </select>
                            </div>
                            
                                        
                            <div class="row1">
                                <lable>State</lable>
                                <input type="text" name="state" id="state" value="<?php echo $state;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>IQMA No *</lable>
                                <input type="text" name="iqma_no" id="iqma_no" value="<?php echo $iqma_no;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Driving licence No *</lable>
                                <input type="text" name="drive_license_no" id="drive_license_no" value="<?php echo $drive_license_no;?>" />
                            </div>
                            
                            <div class="row1">
                                <h1 class="newtag1">
                                    Vehicle Detail
                                </h1>
                            </div>
                            <div class="clear" style="height:1px;"></div>
                            <?php 
							if($policy_type_id == 2)
							{?>
                                <div class="row1">
                                    <lable>Vehicle Make *</lable>
                                    <select class="dropdown" disabled="disabled">
                                        <option><?php echo $vmake_title;?></option>
                                    </select>
                                </div>
                                
                                <div class="row1">
                                    <lable>Vehicle Model *</lable>
                                    <select class="dropdown" disabled="disabled">
                                        <option><?php echo $vmodel_title;?></option>
                                    </select>
                                </div>
                                
                                <div class="row1">
                                    <lable>Vehicle Type *</lable>
                                    <select class="dropdown" disabled="disabled">
                                        <option><?php echo $vtype_title;?></option>
                                    </select>
                                </div>
                                
                                <div class="row1">
                                    <lable>Vehicle Type *</lable>
                                    <select class="dropdown" disabled="disabled">
                                        <option><?php echo $vtype_title;?></option>
                                    </select>
                                </div>
                                
                                <div class="row1">
                                    <lable>Agency Repair: </lable>
                                    <?php echo $vehicle_agency_repair;?>
                                </div>
                                <div class="clear" style="height:10px;"></div>
                                
                                <div class="row1">
                                    <lable>No Claim Discount (NCD)</lable>
                                    <select class="dropdown" disabled="disabled">
                                        <option><?php echo $vehicle_ncd;?></option>
                                    </select>
                                </div>
                            <?php 
							}
							if($policy_type_id == 1)
							{?>
                                
                                <div class="row1">
                                    <lable>Vehicle Type *</lable>
                                    <select class="dropdown" disabled="disabled">
                                        <option><?php echo $vtype_title;?></option>
                                    </select>
                                </div>
                                
                                <div class="row1">
                                    <lable>Vehicle Cylinder </lable>
                                    <select class="dropdown" disabled="disabled">
                                        <option><?php echo $vehicle_cylender;?></option>
                                    </select>
                                </div>
                                
                                <div class="row1">
                                    <lable>Vehicle Weight </lable>
                                    <select class="dropdown" disabled="disabled">
                                        <option><?php echo $vehicle_weight;?></option>
                                    </select>
                                </div>
                                
                                <div class="row1">
                                    <lable>Vehicle Seats </lable>
                                    <select class="dropdown" disabled="disabled">
                                        <option><?php echo $vehicle_seats;?></option>
                                    </select>
                                </div>
                                
							<?php }?>
                            <div class="row1">
                                <lable>Purchase year</lable>
                                <select id="vehicle_purchase_year" name="vehicle_purchase_year" class="dropdown">
                                    <?php  $starting_year  =date('Y', strtotime('-20 year'));
                                    $ending_year = date('Y'); 
                                    
                                    for($starting_year; $starting_year <= $ending_year; $starting_year++) 
                                    {
                                       $pyrselctd = '';
                                        if($starting_year == date('Y'))
                                            $pyrselctd = 'selected="selected"';
                                        echo '<option value="'.$starting_year.'" '.$pyrselctd.'>'.$starting_year.'</option>';
                                    }  ?>
                                </select>
                            </div>
                            
                            <div class="row1">
                                <lable>Vehicle Regd. Place</lable>
                                <input type="text" autocomplete="off" name="vehicle_regd_place" id="vehicle_regd_place" value="<?php echo $vehicle_regd_place;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Vehicle Ownership</lable>
                                <select id="vehicle_ownership" name="vehicle_ownership" class="dropdown">
                                    <option value="">Select</option>
                                    <option value="Financed" <?php if($vehicle_ownership == 'Financed'){echo 'selected="selected"';}?>>Financed</option>
                                    <option value="Owned" <?php if($vehicle_ownership == 'Owned'){echo 'selected="selected"';}?>>Owned</option>
                                    <option value="Leased" <?php if($vehicle_ownership == 'Leased'){echo 'selected="selected"';}?>>Leased</option>
                                </select>
                            </div>
                            
                            <div class="row1">
                                <lable>Vehicle Use</lable>
                                <select id="vehicle_use" name="vehicle_use" class="dropdown">
                                    <option value="">Select</option>
                                    <option value="Private" <?php if($vehicle_use == 'Private'){echo 'selected="selected"';}?>>Private</option>
                                    <option value="Business" <?php if($vehicle_use == 'Business'){echo 'selected="selected"';}?>>Business</option>
                                    <option value="Occasional" <?php if($vehicle_use == 'Occasional'){echo 'selected="selected"';}?>>Occasional</option>
                                </select>
                            </div>
                            
                            <div class="row1">
                                <lable>Vehicle Manufacture Year *</lable>
                                <select id="vehicle_year_made" name="vehicle_year_made" class="dropdown">
                                    <?php  $starting_year  =date('Y', strtotime('-20 year'));
                                    $ending_year = date('Y'); 
                                    
                                    for($starting_year; $starting_year <= $ending_year; $starting_year++) 
                                    {
                                       $vselctd = '';
                                        if($starting_year == date('Y'))
                                            $vselctd = 'selected="selected"';
                                        echo '<option value="'.$starting_year.'" '.$vselctd.'>'.$starting_year.'</option>';
                                    }  ?>
                                </select>
                            </div>
                            
                            
                            <div class="row1">
                                <lable>Vehicle Color *</lable>
                                <input type="text" name="vehicle_color" id="vehicle_color" value="<?php echo $vehicle_color;?>" />
                            </div>
                            
                            
                            <div class="row1">
                                <lable>Chassis No *</lable>
                                <input type="text" name="chassic_no" id="chassic_no" value="<?php echo $chassic_no;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Engine No *</lable>
                                <input type="text" name="engine_no" id="engine_no" value="<?php echo $engine_no;?>" />
                            </div>
                            
                            <?php /*?><div class="row1">
                                <lable>Vehicle Purchase Price *</lable>
                                <input type="text" name="vehicle_purchase_price" id="vehicle_purchase_price" value="<?php echo $vehicle_purchase_price;?>" />
                            </div><?php */?>
                            
                            <div class="row1">
                                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Document Attachment</strong></lable>
                            </div>
                            <div class="clear" style="height:1px;"></div>
                            <input type="hidden" id="atch_count" value="<?php if(!empty($attachments))echo count($attachments);else echo '1';?>" />
                            <?php 
                            if(!empty($attachments))
                            {
                                foreach($attachments as $key=>$attachment)	
                                {
                                    //echo '<pre>'; print_r($attachments); echo '</pre>';?>
                                    <div id="atch_<?php echo $key+1;?>">
                                        <div class="listcross">
                                            <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                            <?php if($key==0)
											{?>
                                                <lable>Document Title *</lable>
                                                <div class="clear" style="height:15px;"></div>
                                            <?php }?>
                                            <?php echo $attachment['atch_title'];?>
                                            <?php /*?><input type="text" name="atch_title[]" id="atch_title_<?php echo $key+1;?>" value="<?php echo $attachment['atch_title'];?>" disabled="disabled" /><?php */?>
                                        </div>
                                        <div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;">
                                            <?php if($key==0)
											{?>
                                                <lable>Attachment *</lable>
                                                <div class="clear" style="height:15px;"></div>
                                            <?php }?>
                                            <?php /*?><input type="file" name="atch_title[]" id="atch_file_<?php echo $key+1;?>" /><?php */?>
                                            <?php echo $attachment['atch_file'];?>
                                        </div>
                                        <?php 
                                       // if($key>0)
                                        //{?>
                                            <span class="cross" onclick="delAttchment('<?php echo $key+1;?>');">X</span>
                                        <?php //}?>
                                    </div>
                                    </div>
                                    <?php 	
                                }
                            }
                            else
                            {?>
                                <div id="atch_1">
                                    <div class="listcross">
                                        <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                        <lable>Document Title *</lable>
                                        <input type="text" name="atch_title[]" id="atch_title_1" />
                                    </div>
                                    <div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;">
                                        <lable>Attachment *</lable>
                                        <input type="file" name="atch_file[]" id="atch_file_1" />
                                    </div>
                                    <!--<span class="cross">X</span>-->
                                </div>
                                </div>
                            <?php }?>
                            <span class="listcross">
                            <a href="javaScript:void(0);" class="plusadd" onclick="addAttchment();">Add Attachment</a>
                            </span>
                            
                            
                            
									
                            <div class="row1">
                                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Insurace Period Detail</strong></lable>
                            </div>
                            <div class="clear" style="height:1px;"></div>
                            
                            <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                <lable>Start Date</lable>
                                <input type="text" class="" onchange="getPolicyEndDate(this.value);" autocomplete="off" name="insured_period_startdate" id="insured_period_startdate" value="<?php echo $insured_period_startdate;?>" /> 
                                <div class="clear" style="height:1px;"></div>
                            </div>
                            
                            <div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;">
                                <lable>End Date</lable>
                                <input type="text" name="insured_period_enddate" id="insured_period_enddate" value="<?php echo $insured_period_enddate;?>" readonly="readonly" />
                                <div class="clear" style="height:1px;"></div>
                            </div>
                            
                            
                            <div class="clear" style="height:1px;"></div>
                            
                            <div class="clear" style="height:5px;">&nbsp;</div>
                            <input type="submit" class="submit_button" name="submit" id="step3_btn" value="Save &amp; Continue" onclick="return validStep3Form(1);" />
                            <!--<input type="reset" class="submit_button" value="Clear"/>--> 
                            <div class="clear" style="height: 65px;">&nbsp;</div>
                            </div>
                        </form>
					<?php }
					if($step == 4)
					{?>
                    	<form name="step4_form" method="post">
                            <h1 style="background: green; color:#fff; text-align:center;font-weight: bold;">
                                Policy Summary
                            </h1>
                            <div class="padding15" style="padding-top:1px"> 
                            <div class="search_box_two">
                                  <div class="listTL">
                                       <table cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 90%;" valign="top">
                                                        <strong><?php echo $pkg_title;?></strong>
                                                        <div class="clearfix" style="height:10px;"></div>
                                                        <p>
                                                            <?php echo $pkg_desc;?>
                                                        </p>
                                                    </td>
                                                    <td valign="middle" width="100" class="priceTL">
                                                        <?php echo $pkg_price;?><br><span>SAR</span>
                                                    </td>
                                                </tr>
                                           </tbody>
                                       </table>
                                 </div>
                                </div>
                            <div class="clear" style="height:15px;"></div>
            
                            
                            <div>
                                <h1 class="newtag1">
                                    Policy Holder's detail
                                </h1>
                                
                                <div class="row1">
                                    <lable>Name :</lable>
                                    <span><?php echo $fname;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                
                                <?php /*?><div class="row1">
                                    <lable>Last Name :</lable>
                                    <span><?php echo $lname;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div><?php */?>
                                
                                <div class="row1">
                                    <lable>Date of Birth :</lable>
                                    <span><?php echo $dob;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                
                                <div class="row1">
                                    <lable>Gender :</lable>
                                    <span>
									<?php if($gender=='m')echo 'Male';
									if($gender=='f')echo 'Female';?>
                                    </span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                
                                <div class="row1">
                                    <lable>Email :</lable>
                                    <span><?php echo $email;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                
                                <?php /*?><div class="row1">
                                    <lable>Phone :</lable>
                                    <span><?php echo $phone_landline;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div><?php */?>
                                
                                
                                <div class="row1">
                                    <lable>Mobile :</lable>
                                    <span><?php echo $phone_mobile;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                
                                <?php /*?><div class="row1">
                                    <lable>Address :</lable>
                                    <span><?php echo $address1.' '.$address2;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div><?php */?>
                                
                                
                                <div class="row1">
                                    <lable>Country :</lable>
                                    <span><?php echo $country;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                <div class="row1">
                                    <lable>State :</lable>
                                    <span><?php echo $state;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                
                                <div class="row1">
                                    <lable>IQMA No :</lable>
                                    <span><?php echo $iqma_no;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                                                        
                                <div class="row1">
                                    <lable>Driving licence No :</lable>
                                    <span><?php echo $drive_license_no;?></span>
                                </div>
                                <div class="clearfix" style="height:10px;"></div>
                                
                                <h1 class="newtag1">Vehicle Detail</h1>
                                                                        
                                <!--<div class="row1">
                                    <lable>Vehicle Detail :</lable>
                                    <span>Rosoin foid</span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>-->
                                
                                <?php if($policy_type_id == 2)
                                {?>        
                                    <div class="row1">
                                        <lable>Vehicle Make :</lable>
                                        <span><?php echo $vmake_title;?></span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                                                            
                                    <div class="row1">
                                        <lable>Vehicle Model :</lable>
                                        <span><?php echo $vmodel_title;?></span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                                                            
                                    <div class="row1">
                                        <lable>Vehicle Type :</lable>
                                        <span><?php echo $vtype_title;?></span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                
                                    
                                    <div class="row1">
                                        <lable>Agency Repair</lable>
                                        <span><?php echo $vehicle_agency_repair;?></span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    <div class="row1">
                                        <lable>No Claim Discount (NCD)</lable>
                                        <span><?php echo $vehicle_ncd;?></span>
                                    </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                <?php }
								if($policy_type_id == 1)
								{?>
                                    <div class="row1">
                                        <lable>Vehicle Type :</lable>
                                        <span><?php echo $vtype_title;?></span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                
                                    <div class="row1">
                                        <lable>Vehicle Cylinder :</lable>
                                        <span><?php echo $vehicle_cylender;?></span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    <div class="row1">
                                        <lable>Vehicle Weight :</lable>
                                        <span><?php echo $vehicle_weight;?></span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    <div class="row1">
                                        <lable>Vehicle Seats :</lable>
                                        <span><?php echo $vehicle_seats;?></span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                                                            
                                <?php }	?>
                                                                        
                                <div class="row1">
                                    <lable>Vehicle Purchase Year :</lable>
                                    <span><?php echo $vehicle_purchase_year;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                                                        
                                                                        
                                <div class="row1">
                                    <lable>Vehicle Regd. Place :</lable>
                                    <span><?php echo $vehicle_regd_place;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                                                        
                                                                        
                                <div class="row1">
                                    <lable>Vehicle Ownership :</lable>
                                    <span><?php echo $vehicle_ownership;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                                                        
                                                                        
                                <div class="row1">
                                    <lable>Vehicle Use :</lable>
                                    <span><?php echo $vehicle_use;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                                                        
                                                                        
                                <div class="row1">
                                    <lable>Vehicle Manufacture Year :</lable>
                                    <span><?php echo $vehicle_year_made;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                                                        
                                <div class="row1">
                                    <lable>Vehicle Color  :</lable>
                                    <span><?php echo $vehicle_color;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                                                        
                                <div class="row1">
                                    <lable>Chassis No  :</lable>
                                    <span><?php echo $chassic_no;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                                                        
                                <div class="row1">
                                    <lable>Engine No  :</lable>
                                    <span><?php echo $engine_no;?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                                                        
                                <?php /*?><div class="row1">
                                    <lable>Vehicle Purchase Price  :</lable>
                                    <span><?php echo $drive_license_no;?></span>
                                </div>
                                <div class="clearfix" style="height:10px;"></div><?php */?>
                                
                                
                                <h1 class="newtag1">Document Attached</h1>
                                <div class="clear" style="height:1px;"></div>
                                
								<?php 
                                if(!empty($attachments))
                                {
                                    foreach($attachments as $key=>$attachment)	
                                    {?>
                                        <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                            <lable>Document Title :</lable>
                                            <span><?php echo $attachment['atch_title'];?></span>
                                        </div>
                                    
                                        <div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;">
                                            <lable>Attachment :</lable>
                                            <span><?php echo $attachment['atch_file'];?></span>
                                        </div>
                                            
                                        <div class="clear" style="height:30px;">&nbsp;</div>
                                <?php }
								}
								else
								{
									?>
                                    <div class="row1">
                                        <lable>No document attached.</lable>
                                    </div>
                                    <div class="clear" style="height:5px;"></div>
                                    <?php 
								}?>
                                
                                <h1 class="newtag1">Insurace Period Detail</h1>
                                <div class="clear" style="height:1px;"></div>
                                
                                <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                    <lable>Start Date : </lable>
                                    <?php echo date('d-m-Y',strtotime($insured_period_startdate));?>
                                    <div class="clear" style="height:1px;"></div>
                                </div>
                                
                                <div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;">
                                    <lable>End Date : </lable>
                                    <?php echo date('d-m-Y',strtotime($insured_period_enddate));?>
                                    <div class="clear" style="height:1px;"></div>
                                </div>
                                
                                <div class="clear" style="height:45px;">&nbsp;</div>
                                <div class="row1">
                                    <input type="checkbox" value="1" name="accept_terms" id="accept_terms" <?php if($accept_terms){ echo 'checked="checked"';}?>  />
                                    I accept all <a href="<?php echo BASE_URL.'index.php?page=terms-and-conditions';?>" target="_blank">terms and conditions</a> and <a href="<?php echo BASE_URL.'index.php?page=privacy-policy';?>" target="_blank">privacy policy</a>.
                                </div>
                                <div class="clear" style="height:15px;">&nbsp;</div>
                                <input type="button" class="submit_button" value="Recalculate" name="submit" onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=motor-insurance&step=3'" style="margin-right: 10px;">
                                <input type="submit" class="submit_button" value="Proceed to Payment" name="submit" onclick="return validStep4Form();" style="width: 33%;">
                            </div>
                            </div>
                            </form>
                    <?php }
					if($step == 5)
					{?>
                    	<form name="step5_form" id="step5_form" method="post">
                        	<input type="hidden" name="package_name" value="<?php echo $pkg_title;?>" />
                        	<input type="hidden" name="total_payment_amount" value="<?php echo $pkg_price;?>" />
                            <h1 style="background: green; color:#fff; text-align:center;font-weight: bold;">
                                Your Selected Quote
                            </h1>
                            <div class="padding15" style="padding-top:1px"> 
                            <div class="search_box_two">
                                  <div class="listTL">
                                       <table cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 90%;" valign="top">
                                                        <strong><?php echo $pkg_title;?></strong>
                                                        <div class="clearfix" style="height:10px;"></div>
                                                        <p>
                                                            <?php echo $pkg_desc;?>
                                                        </p>
                                                    </td>
                                                    <td valign="middle" width="100" class="priceTL">
                                                        <?php echo $pkg_price;?><br><span>SAR</span>
                                                    </td>
                                                </tr>
                                           </tbody>
                                       </table>
                                 </div>
                                </div>
                            <div class="clear" style="height:15px;"></div>
            
                            
                            <div class="row1">
                                <lable>Policy Amout :</lable>
                                <span><strong><?php echo $pkg_price;?> SAR</strong></span>
                            </div>
                            <div class="clear" style="height:5px;"></div>
                            
                            <div class="row1">
                                <lable>Policy Period :</lable>
                                <span><strong><?php echo date('d-m-Y',strtotime($insured_period_startdate));?> &nbsp;to&nbsp; <?php echo date('d-m-Y',strtotime($insured_period_enddate));?></strong></span>
                            </div>
                            <div class="clear" style="height:5px;"></div>
                            
                            <div class="row1">
                                <lable>Policy Date :</lable>
                                <span><strong>02-11-2016</strong></span>
                            </div>
                            <div class="clear" style="height:1px;"></div>
                            
                            
                            <div class="clear" style="height:10px;"></div>
                            <div>
                            
								<?php
                                if(!empty($error_msg))
                                {
                                    echo '<div style="padding: 10px;font-size: 16px;color: red;text-align: center;">'.$error_msg.'</div>';	
                                }
                                ?>
                            
                                <h1 class="newtag1">
                                    Credit Card Details
                                </h1>
                                
                                <p>We accept Visa,Master Card and American Express. </p>
                                
                                <div class="clearfix" style="height:10px;"></div>
                                
                                <div class="row1">
                                    <lable>Card Type</lable>
                                    <select id="card_type" name="card_type" class="dropdown">
                                        <option value="Visa" selected="selected">Visa</option>
                                        <option value="Master Card">Master Card</option>
                                        <option value="American Express">American Express</option>
                                    </select>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                <div class="row1">
                                    <lable>Card Number</lable>
                                    <input type="text" name="card_no" id="card_no" onkeypress="return isNumberKey(event)" />
                                </div>
                                
                                <div class="row1">
                                    <lable>Card Expires</lable>
                                    <div class="clearfix" style="height:5px;"></div>
                                    <input type="text" style="width:45%; float:left;" maxlength="2" placeholder="MM" name="card_exp_mm" id="card_exp_mm" onkeypress="return isNumberKey(event)" />
                                    
                                    <span style="float:left; padding:13px 15px 0px 15px;font-size: 19px;color: gray;"> / </span>
                                    
                                    <input type="text" style="width:45%; float:left;" placeholder="YYYY" maxlength="4" name="card_exp_yy" id="card_exp_yy" onkeypress="return isNumberKey(event)" />
                                </div>
                                <div class="clearfix" style="height:10px;"></div>
                                
                                
                                <div class="row1">
                                    <lable>CVV NO</lable>
                                    <div class="clearfix" style="height:5px;"></div>
                                    <input type="text" style="width:45%; float:left;margin-right: 2%;" name="cvv_no" id="cvv_no" onkeypress="return isNumberKey(event)" />
                                    <img src="images/ccv.png" alt="Security Code Location" style="width: 21%;padding-top: 5px;">
                                </div>
                                
                                <div class="clear" style="height:25px;">&nbsp;</div>
                                <div onclick="validStep5Form();" class="submit_button" style="text-align: center;line-height: 35px;">Pay Now</div>
                            </div>
							</div>		
						</form>
					<?php }?>
                     <div class="clear" style="height:25px;"></div>
                </div>  
                <div class="clear" style="height:5px;"></div>                  
            </div>
            
            
            <?php include_once('includes/booknow-sidebar.php'); ?>
        
        <div class="clearfix"></div>
        </div>
        <div class="clearfix" style="height:15px;"></div>
</div>