<!--<h1 style="height: 200PX;
text-align: center;
FONT-SIZE: 50px;
padding-top: 150PX;">COMING SOON</h1>-->

<?php 
// call class instance
$db = new dbFactory();
//Set quote details to vehicle_details
if(!empty($_SESSION['motor']['Quote']))
{
	$_SESSION['motor']['Vehicle'] = $_SESSION['motor']['Quote'];
	unset($_SESSION['motor']['Quote']);	
}
echo '<pre>'; print_r($_SESSION['motor']['Your_details']); echo '</pre>';

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

<style>
.motor_insurance
{
	width:100%;	
}
.motor_insurance ul
{
	width: 100%;
	height:auto;
	z-index:500;
	margin-left: 0;
}
.motor_insurance ul li
{
	list-style: none;
	list-style-image: none;
	margin: 0;
	padding: 0;
	position:relative;
	margin-left:2px;
	float: left;
	background: #000;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	-o-border-radius: 3px;
	border-radius: 3px;
	-webkit-box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);
	-moz-box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);
	-o-box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);
	box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);
	border-bottom-right-radius: 0px;
	border-bottom-left-radius: 0px;
}
.motor_insurance ul li a{
	text-align: center;
	display: block;
	padding:7px 12px 9px;
	margin-right:1px;
	color: #fff;
	-webkit-text-shadow: 0 -1px 0 black;
	border-top:3px solid #464646;
	text-shadow: 0 -1px 0 black;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: none;
	background: url(../images/repeating_textures.png) repeat-x;
	width:107.5px;
	
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	-o-border-radius: 3px;
	border-radius: 3px;
	border-bottom-right-radius: 0px;
	border-bottom-left-radius: 0px;
}
.motor_insurance ul li a:hover{
	background: none;
	color: #000;
	-webkit-text-shadow: none;
	text-shadow: none;
	border-top:3px solid #12B912;
	background: #fff;
	padding: 7px 12px 8px;
}
.motor_insurance ul li a.active{
	background: none;
	color: #000;
	-webkit-text-shadow: none;
	text-shadow: none;
	border-top:3px solid #12B912;
	background: #fff;
	padding: 7px 12px 8px;
}
.ins_content
{
	min-height: 100px;
	clear: both;
}
.formpan {
	width: auto;
	height: auto;
	background-color: #EDF4FA;
	border: 1px solid #D9DBDD;
	box-shadow: none;
	padding: 10px;
	background:rgb(235, 235, 235);
	-webkit-box-shadow: 0px 1px 8px rgba(114, 115, 116, 0.7);
	-moz-box-shadow: 0px 1px 8px rgba(114, 115, 116, 0.7);
	box-shadow: 0px 1px 8px rgba(114, 115, 116, 0.7);
}
.formpan form lable {
	font-size: 12px;
	text-align: left;
	width: 100px;
	float: left;
	color: #353535;
	padding-top: 7px;
}
.formpan form input[type="text"] {
text-align: left;
height: 19px;
font-weight: normal;
border: 1px solid #B6B6B6;
outline: none;
line-height: 23px;
padding: 4px;
font-family: 'Roboto';
float: right;
margin-bottom: 8px;
font-size: 11px;
color: #000;
border-top: 1px solid #C0C0C0;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;
width: 59%;
}
.formpan form lable 
{
	width:200px;
}
.dropdown
{
	float:left;
	width:270px;
}
.formpan form input[type="text"]
{
	float:left;
	width:260px;
}
.radoipan 
{
	width: 100px;
	float: left;
	margin-left: 0; 
}


/*for jquery accordon*/
.ui-state-default
{
	background:	#CFCDCD;
}
.ui-accordion .ui-accordion-header
{
	padding:5px 10px;
}
a.disable
{
	cursor:default;
}
</style>

<script>
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
	/*if(document.step2.package_no.checked == true)
	{	
		return true;
	}
	else
	{
		alert('Please select any package type');
		return false;
	}*/
	
	//var btn = document.step2.package_no; alert(btn);
	var btn = document.step2.package_no.length; 
	//alert(document.step2.package_no.length);
	var cnt = 0;
    for (var i=0; i < btn; i++) 
	{
	    if (document.step2.package_no[i].checked == true) 
		{
			cnt++; 
		}
    }
	
	if (cnt > 0) 
	{
		return true;
	}
	else
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
	
	if(form.first_name.value == '')
	{
		form.first_name.style.borderColor='red';
		flag = false;	
		fields.push('first_name');
	}
	else
	{
		form.first_name.style.borderColor='#B6B6B6';
	}

	if(form.last_name.value == '')
	{
		form.last_name.style.borderColor='red';
		flag = false;	
		fields.push('last_name');
	}
	else
	{
		form.last_name.style.borderColor='#B6B6B6';
	}
	
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
	
	if(form.address1.value == '')
	{
		form.address1.style.borderColor='red';
		flag = false;	
		fields.push('address1');
	}
	else
	{
		form.address1.style.borderColor='#B6B6B6';
	}
	
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
		$('#vehicle_regd_place').css( "border-color", "#FFFFFF" );
	}

	if($('#vehicle_ownership').val() == '')
	{
		$('#vehicle_ownership').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_ownership');
	}
	else
	{
		$('#vehicle_ownership').css( "border-color", "#FFFFFF" );
	}

	if($('#vehicle_use').val() == '')
	{
		$('#vehicle_use').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_use');
	}
	else
	{
		$('#vehicle_use').css( "border-color", "#FFFFFF" );
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
	
	for(var i=1; i<=cnt; i++)
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
	}

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
				form.policy_type_id.style.borderColor='#FFF';
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
					$('#vehicle_type_tpl').css( "border-color", "#FFFFFF" );
				}
			
				if($('#vehicle_cylender').val() == '')
				{
					$('#vehicle_cylender').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_cylender');
				}
				else
				{
					$('#vehicle_cylender').css( "border-color", "#FFFFFF" );
				}
			
				if($('#vehicle_weight').val() == '')
				{
					$('#vehicle_weight').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_weight');
				}
				else
				{
					$('#vehicle_weight').css( "border-color", "#FFFFFF" );
				}
			
				if($('#vehicle_seats').val() == '')
				{
					$('#vehicle_seats').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_seats');
				}
				else
				{
					$('#vehicle_seats').css( "border-color", "#FFFFFF" );
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
					$('#vehicle_make').css( "border-color", "#FFFFFF" );
				}
			
				if($('#vehicle_model').val() == '')
				{
					$('#vehicle_model').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_model');
				}
				else
				{
					$('#vehicle_model').css( "border-color", "#FFFFFF" );
				}
			
				if($('#vehicle_type').val() == '')
				{
					$('#vehicle_type').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_type');
				}
				else
				{
					$('#vehicle_type').css( "border-color", "#FFFFFF" );
				}
			
				if($('#vehicle_ncd').val() == '' && $('#vehicle_ncd').val() != '0')
				{
					$('#vehicle_ncd').css( "border-color", "red" );
					flag = false;	
					fields.push('vehicle_ncd');
				}
				else
				{
					$('#vehicle_ncd').css( "border-color", "#FFFFFF" );
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
					$('.agency_rpr').css( "color", "#FFFFFF" );
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
				
				//form.first_name.focus();
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
		
		$_POST['first_name'] = addslashes($_POST['first_name']);
		$_POST['last_name'] = addslashes($_POST['last_name']);
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
		
		$first_name = $motor['first_name'];	
		$last_name = $motor['last_name'];	
		$email = $motor['email'];	
		$mobile_no = $motor['mobile_no'];	
		$dob = $motor['dob'];	
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
		/*var time = new Date();
		time.setDate(time.getDate()+360);
		alert(time);*/
		var enddate = '';
		
		var dt  = date1.split('-');
		
		var year = dt[0];
		var month = dt[1];
		var day = dt[2];
		
		//enddate = month+'/'+day+'/'+(parseInt(year)+1);
		
		enddate = (parseInt(year)+1)+'-'+month+'-'+day;
		
		$('#insured_period_enddate').val(enddate);	
		//alert(enddate);
	}
    </script>
    <?php 
	
	//Step-3 submit	
	if(isset($_POST['submit']))
	{
		unset($_POST['submit']);	
		
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
			$_SESSION['motor']['Your_details']['first_name'] = $motor['first_name'];
			$_SESSION['motor']['Your_details']['last_name'] = $motor['last_name'];
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
		$first_name = $_SESSION['motor']['Your_details']['first_name'];
		$last_name = $_SESSION['motor']['Your_details']['last_name'];
		$email = $_SESSION['motor']['Your_details']['email'] ;
		$phone_landline = $_SESSION['motor']['Your_details']['phone_landline'] ;
		$phone_mobile = $_SESSION['motor']['Your_details']['phone_mobile'] ;
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
			$vtype_title = getVType($vehicle_type);
		}
		
	}
}
?>
<div class="innrebodypanel">
    <div class="clearfix" style="height:15px;"></div>
    <div class="innerwrap" style="min-height:500px;">
    
        <div class="breadcrumb" >
            <a itemprop="url" href="index.html">Home</a> 
            <span class="breeadset">&#8250;</span>
            <a itemprop="url" href="#">Motor Insurance</a> 
            <span class="breeadset">&#8250;</span>
            <strong>Step-<?php echo $step;?></strong>
        </div>
        
        <div id="motor_insurance" class="motor_insurance">
            <ul>
                <li style="margin-left:0;"><a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=1" <?php if($step == 1){echo 'class="active"';}?>>Step-1</a></li>
                <li>
					<?php if(!empty($_SESSION['motor']['step_2']))
                    {
                        ?>
                        <a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=2" <?php if($step == 2){echo 'class="active"';}?>>Step-2</a>
                        <?php 
                    }
                    else
                    {
                        ?>
                        <a href="javaScript:void(0);" class="disable">Step-2</a>
                        <?php 
                    }?>
                </li>
                <li>
                <?php if(!empty($_SESSION['motor']['step_3']))
				{
					?>
                    <a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=3" <?php if($step == 3){echo 'class="active"';}?>>Step-3</a>
                    <?php 
				}
				else
				{
					?>
                    <a href="javaScript:void(0);" class="disable">Step-3</a>
                    <?php 
				}?>
                </li>
                <li>
                <?php if(!empty($_SESSION['motor']['step_4']))
				{
					?>
                    <a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=4" <?php if($step == 4){echo 'class="active"';}?>>Step-4</a>
                    <?php 
				}
				else
				{
					?>
                    <a href="javaScript:void(0);" class="disable">Step-4</a>
                    <?php 
				}?>
                </li>
                <li>
                <?php if(!empty($_SESSION['motor']['step_5']))
				{
					?>
                    <a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=5" <?php if($step == 5){echo 'class="active"';}?>>Step-5</a>
                    <?php 
				}
				else
				{
					?>
                    <a href="javaScript:void(0);" class="disable">Step-5</a>
                    <?php 
				}?>
                </li>
            </ul>
            
            <?php if($step == 1)
			{?>
                <div id="step-1" class="ins_content formpan">
                	
                    <form name="step1_form" id="step1_form" method="post">
                        <div class="clearfix" style="height:10px;"></div>
                        <h2>Vehicle Information</h2>
                        <div class="clearfix" style="height:10px;"></div>
                        
                        <div class="row1">
                                <lable>Insurance type</lable>
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
                                <option value="<?=$myrow["id"]?>" <?php if($vehicle_type_tpl == $vtype['id']){echo 'selected="selected"';}?>><?=$myrow["type_name"]?></option>
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
                            <lable class="agency_rpr">Agency Repair </lable>
                            <div class="radoipan" style="float:left !important;">
                                <input type="radio" id="vehicle_agency_repair" class="radio" name="vehicle_agency_repair" value="Yes" style=" width: 13%;" <?php if($vehicle_agency_repair=='Yes'){echo 'checked="checked"';}?> />
                                <span>Yes</span>
                                
                                <input type="radio" id="vehicle_agency_repair2" class="radio" name="vehicle_agency_repair" value="No" style=" width: 13%;" <?php if($vehicle_agency_repair=='No'){echo 'checked="checked"';}?> />
                                <span>No</span>
                            </div>
                        </div>
                        <div class="clearfix" style="height:5px;"></div>
                        <div class="row1">
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
                            <input type="text" autocomplete="off" name="first_name" id="first_name" value="<?php echo $first_name;?>" />
                        </div>
                        
                        <div class="row1">
                            <lable>Last name </lable>
                            <input type="text" autocomplete="off" name="last_name" id="last_name" value="<?php echo $last_name;?>" />
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
                            <input type="text" autocomplete="off" class="date_picker" name="dob" id="dob" value="<?php echo $dob;?>">
                        </div>
                        
                        
                        <div class="row1">
                            <lable>Country  *</lable>
                            <select id="country" name="country" class="dropdown">
                                <option value="">-Select-</option>
                                <option value="AGRA" <?php if($country=='AGRA'){echo 'selected="selected"';}?>>AGRA</option>
                            </select>
                        </div>
                        
                        <div style="font-size: 11px;clear: both; font-family:Arial, Helvetica, sans-serif; position:relative; top:8px;">
                          * Required Fields
                          <br /><br />
                        </div><?php */?>
                        <input type="submit" class="submit_button" name="submit" value="Continue" style="width: 120px;float: right;" onclick="return validStep1Form(<?php echo $m;?>);" />
                        <input type="reset" class="submit_button" value="Clear" style="width: 100px;float: right;margin-right: 10px;" />
                        <div class="clearfix" style="height:10px;"></div>
                        
                    </form>	
					
                </div>
            <?php }
			if($step == 2)
			{?>
                <div id="step-2" class="ins_content formpan">
                    <form name="step2" id="step2" method="post">
                        
                        <div class="clearfix" style="height:10px;"></div>
                        <h2>Select Package</h2>
                        <div class="clearfix" style="height:10px;"></div>
                        <?php 
						if($total_pkg > 0)
						{
							?>
                            <ul style="width:100%;">
                            <?php 
							while($pkg = mysql_fetch_array($pckg_sql_qry))
							{
								//echo '<pre>'; print_r($pkg); echo '</pre>';
								?>
                                <li style="width:97%; margin-bottom:10px;background: #fff;padding: 10px;">
                                	<input type="radio" name="package_no" value="<?php echo $pkg['package_no'];?>" <?php if($package_no == $pkg['package_no']){echo 'checked="checked"';}?> style="float: left;" />
                                    <h2 style="float: left;"><?php echo stripslashes($pkg['package_title']);?></h2>
                                    
                                    <div style="float:right;">
                                    	Price: <?php echo number_format($pkg['package_amt'],2);?>
                                    </div>
                                    
                                    <div class="clearfix" style="height:10px;"></div>
                                    <?php echo stripslashes($pkg['package_desc']);?>
                                </li>
                                <?php 
							}	?>
                            </ul>
                            <input type="submit" class="submit_button" name="submit" value="submit" style="width: 100px;float: right;" onclick="return validStep2Form(1);" />
                            <?php 
						}
						else
						{
							echo 'No package found as per your search.';	
						}
						?>
                        <div class="clearfix" style="height:10px;"></div>
                    </form>
                </div>
            <?php }
			if($step == 3)
			{?>
                <div id="step-3" class="ins_content formpan">
                    <form name="step3_form" id="step3_form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="is_driver" id="is_driver" value="0" />
                        <div class="clearfix" style="height:10px;"></div>
                        <h2>Your Details</h2>
                        <div class="clearfix" style="height:10px;"></div>
                        
                        <?php /*?><div class="row1">
                            <lable></lable>
                            <input type="checkbox"  <?php if($is_driver == 1){echo 'checked="checked"';}?> id="same_as_driver" value="1" onchange="updateYDetail();" />
                            Same as driver
                        </div><?php */?>
                        
                        <div class="row1">
                            <lable>First Name  *</lable>
                            <input type="text" autocomplete="off" name="first_name" id="first_name" value="<?php echo $first_name;?>" />
                        </div>
                        
                        <div class="row1">
                            <lable>Last name </lable>
                            <input type="text" autocomplete="off" name="last_name" id="last_name" value="<?php echo $last_name;?>" />
                        </div>
                        
                        <div class="row1">
                            <lable>Date of Birth *</lable>
                            <input type="date" autocomplete="off" name="dob" value="<?php echo $dob;?>" id="dob">
                        </div>
                        
                        <div class="row1">
                            <lable>Gender </lable>
                            <div class="radoipan" style="float:left;">
                                <input type="radio" id="genderm" class="radio" name="gender" value="m" <?php if($gender!='f'){echo 'checked="checked"';}?> style=" width: 13%;">
                                <span>Male</span>
                                
                                <input type="radio" id="genderf" class="radio" name="gender" value="f" <?php if($gender=='f'){echo 'checked="checked"';}?> style=" width: 13%;">
                                <span>Female</span>
                            </div>
                        </div>
                        <div class="clearfix" style="height:5px;"></div>
                        
                        <div class="row1">
                            <lable>Email   *</lable>
                            <input type="text" autocomplete="off" name="email" id="email" value="<?php echo $email;?>" />
                        </div>
                        
                        <div class="row1">
                            <lable>Phone (Landline) *</lable>
                            <input type="text" autocomplete="off" name="phone_landline" id="phone_landline"  onkeypress="return isNumberKey(event)" value="<?php echo $phone_landline;?>" />
                        </div>
                        
                        <div class="row1">
                            <lable>Phone (Mobile) *</lable>
                            <input type="text" autocomplete="off" name="phone_mobile" id="phone_mobile"  onkeypress="return isNumberKey(event)" value="<?php echo $phone_mobile;?>" />
                        </div>
									
                        <div class="row1">
                            <lable>Address *</lable>
                            <input type="text" name="address1" id="address1" value="<?php echo $address1;?>" />
                        </div>
                        
                        <div class="row1">
                            <lable>Address (Temporary) *</lable>
                            <input type="text" name="address2" id="address2" value="<?php echo $address2;?>" />
                        </div>
									
                        <div class="row1">
                            <lable>Country  *</lable>
                            <select id="country" name="country" class="dropdown">
                                <!--<option value="">-Select-</option>-->
                                <option value="UAE" <?php if($country == 'UAE'){echo 'selected="selected"';}?>>UAE</option>
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
                        	<lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Vehicle Detail</strong></lable>
                        </div>
                        <div class="clear" style="height:1px;"></div>
                        
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
                            <lable>Vehicle Purchase year</lable>
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
                            <lable>Chasic No *</lable>
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
                                        <lable>Document Title *</lable>
                                        <?php echo $attachment['atch_title'];?>
                                        <?php /*?><input type="text" name="atch_title[]" id="atch_title_<?php echo $key+1;?>" value="<?php echo $attachment['atch_title'];?>" disabled="disabled" /><?php */?>
                                    </div>
                                    <div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;">
                                        <lable>Attachment *</lable>
                                        <?php /*?><input type="file" name="atch_title[]" id="atch_file_<?php echo $key+1;?>" /><?php */?>
                                        <?php echo $attachment['atch_file'];?>
                                    </div>
                                    <?php 
									if($key>0)
									{?>
                                    	<span class="cross" onclick="delAttchment('<?php echo $key+1;?>');">X</span>
                                    <?php }?>
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
                        <a href="javaScript:void(0);" class="plusadd" onclick="addAttchment();">Add Attachment</a>
                        
                        
                        <div class="row1">
                            <lable>Start Date *</lable>
                            <input type="date" onchange="getPolicyEndDate(this.value);" name="insured_period_startdate" id="insured_period_startdate" value="<?php echo $insured_period_startdate;?>" />
                        </div>
                        <div class="row1">
                            <lable>End Date *</lable>
                            <input type="date" name="insured_period_enddate" id="insured_period_enddate" value="<?php echo $insured_period_enddate;?>" readonly="readonly" />
                        </div>
                        
                        <div class="clearfix" style="height:10px;"></div>
                        <input type="submit" class="submit_button" name="submit" id="step3_btn" value="submit" style="width: 100px;float: right;" onclick="return validStep3Form(1);" />
                        <input type="reset" class="submit_button" value="Clear" style="width: 100px;float: right;margin-right: 10px;" />
                        <div class="clearfix" style="height:10px;"></div>
                	</form>
                </div>
            <?php }
			if($step == 4)
			{?>
                <div id="step-4" class="ins_content formpan">
                    <div class="leftbokpan">
                     <div id="formpan" class="formpan2" style="width:99%!important;">
                              <form>
                                <div class="row1">
                                    <lable style="width:100%; font-size:13px;"><strong style="padding-top:0;">Your Selected Quote</strong></lable>
                                </div>
                                
                                <div class="search_box_two">
                                      <div class="listTL">
                                           <table cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 90%;" valign="top">
                                                            <strong>Comprehensive Motor Insurance</strong>
                                                            <div class="clearfix" style="height:10px;"></div>
                                                            <p>
                                                                We have a team of dedicated experts who are always willing to provide valuable suggestions to our clients.
                                                            </p>
                                                        </td>
                                                        <td valign="middle" width="100" class="priceTL">
                                                            287<br><span>AED</span>
                                                        </td>
                                                    </tr>
                                               </tbody>
                                           </table>
                                     </div>
                                    </div>
                                <div class="clear" style="height:15px;"></div>
                
                                
                                <div style="width:68%;">
                                    <div class="row1">
                                        <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="padding-top:0; width: 147%;">Policy Holder's detail</strong></lable>
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>First Name :</lable>
                                        <span>Yousuel</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Last Name :</lable>
                                        <span>Fonade</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    <div class="row1">
                                        <lable>Date of Birth :</lable>
                                        <span>10 April 1991</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Gender :</lable>
                                        <span>Male</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Email :</lable>
                                        <span>yousofzakel@yahoo.com</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Phone :</lable>
                                        <span>0674 2155 456</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Mobile :</lable>
                                        <span>+91 9875 6785 56</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Address :</lable>
                                        <span>2nd Floor, Dioxy City, UAE</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Country :</lable>
                                        <span>UAE</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    <div class="row1">
                                        <lable>State :</lable>
                                        <span>Ajman</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                    
                                    <div class="row1">
                                        <lable>IQMA No :</lable>
                                        <span>C12345DVL0</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                                                            
                                    <div class="row1">
                                        <lable>Driving licence No :</lable>
                                        <span>DL45c20T8</span>
                                    </div>
                                    <div class="clearfix" style="height:10px;"></div>
                                    
                                    <div class="row1">
                                        <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="width: 147%;">Vehicle Detail</strong></lable>
                                    </div>
                                                                            
                                    <div class="row1">
                                        <lable>Vehicle Detail :</lable>
                                        <span>Rosoin foid</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                                                            
                                    <div class="row1">
                                        <lable>Vehicle Make :</lable>
                                        <span>Soil fdt</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                                                            
                                    <div class="row1">
                                        <lable>Vehicle Model :</lable>
                                        <span>Polo T9</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                                                            
                                    <div class="row1">
                                        <lable>Vehicle Type :</lable>
                                        <span>Scorlit fon</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                                                            
                                    <div class="row1">
                                        <lable>Vehicle Manufacture Year :</lable>
                                        <span>1992</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                                                            
                                    <div class="row1">
                                        <lable>Vehicle Color  :</lable>
                                        <span>red</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                                                            
                                    <div class="row1">
                                        <lable>Chasic No  :</lable>
                                        <span>456</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    
                                                                            
                                    <div class="row1">
                                        <lable>Engine No  :</lable>
                                        <span>7DE4</span>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                                                            
                                    <div class="row1">
                                        <lable>Vehicle Purchase Price  :</lable>
                                        <span>506AED</span>
                                    </div>
                                    <div class="clearfix" style="height:10px;"></div>
                                    
                                    
                                    <div class="row1">
                                        <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="width: 147%;">Document Attached</strong></lable>
                                    </div>
                                    <div class="clear" style="height:1px;"></div>
                                    
                                    
                                    <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                        <lable>Document Title :</lable>
                                        <span>Lorem ipsum</span>
                                    </div>
                                
                                    <div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;">
                                        <lable>Attachment :</lable>
                                        <span><img src="images/menucar.png" alt="" style="width:60px;position: absolute;"></span>
                                    </div>
                                        
                                    <div class="clear" style="height:30px;">&nbsp;</div>
                                    
                                    
                                    <div class="row1">
                                        <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="width: 147%;">Insurace Period Detail</strong></lable>
                                    </div>
                                    <div class="clear" style="height:1px;"></div>
                                    
                                    <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                        <lable>Start Date : </lable>
                                        16-05-2007
                                        <div class="clear" style="height:1px;"></div>
                                    </div>
                                    
                                    <div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;">
                                        <lable>End Date : </lable>
                                        16-05-2007
                                        <div class="clear" style="height:1px;"></div>
                                    </div>
                                    
                                    <div class="clear" style="height:45px;">&nbsp;</div>
                                    <input type="submit" class="submit_button" value="Go to Payment">
                                </div>
                                
                                </form>
                        <div class="clear" style="height:1px;"></div>
                    </div>                    
                </div>
                </div>
            <?php }
			if($step == 5)
			{?>
                <div id="step-5">
                
                </div>
            <?php }?>
        </div>
        
        
    	<div class="clearfix"></div>
    </div>
    <div class="clearfix" style="height:15px;"></div>
</div>
