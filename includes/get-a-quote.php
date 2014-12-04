<?php
// call class instance
$db = new dbFactory();

//Get minimum car value
$min_car_val = (MIN_COMP_PREMIUM_AMT*100)/COMP_PREMIUM_CAR_VALUE_PERCENT;
$min_car_val = round($min_car_val,2);

if(isset($_POST['submit_quote']))
{
	unset($_POST['submit_quote']);	
	$_POST['created_date']=date('Y-m-d H:i:s');
	/*$_POST['first_name'] = addslashes($_POST['first_name']);
	$_POST['last_name'] = addslashes($_POST['last_name']);
	$_POST['email'] = addslashes($_POST['email']);
	$_POST['iqma_no'] = addslashes($_POST['iqma_no']);*/
	$_POST['quote_key'] = uniqid();
	
	$_POST['driver_license_issue_date'] = date('Y-m-d',strtotime($_POST['driver_license_issue_date']));
	
	
	if($_POST['policy_type_id'] == 1)
	{
		unset($_POST['vehicle_make']);
		unset($_POST['vehicle_model']);
		unset($_POST['vehicle_agency_repair']);
		unset($_POST['vehicle_made_year']);
		unset($_POST['car_value']);
		unset($_POST['agency_deduct_amt']);
	}
	else
	{
		unset($_POST['vehicle_type_tpl']);
	}
		
	
	//Insert into policy quote table
	$result = $db->recordInsert($_POST,POLICYQUOTES,'');
	
	if(!empty($result))
	{
		$lastid = mysql_insert_id();
		$quotekeyid = 'AC/Q/'.date("Y").'/00'.$lastid;
		
		unset($_POST['quote_key']);
		unset($_POST['created_date']);
		
		//save all field in session
		$_SESSION['motor']['Quote'] = $_POST;
		$_SESSION['motor']['step_2'] = '1';
		
		$_SESSION['motor']['Quote_key'] = $quotekeyid;
		
		$insert = $db->recordUpdate(array("id" => $lastid),array("quote_key"=>$quotekeyid),POLICYQUOTES);
		
		$_SESSION['get_a_quote_id'] = $lastid;
		$_SESSION['get_a_quote_msg'] = '<font color="#00CC33">Qoutation send sucessfully.</font>';
	}
	else
	{
		$_SESSION['get_a_quote_msg'] = '<font color="#00CC33">Qoutation sending Failed.</font>';	
	}
	
	header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=2');	
}
?>
<style>
#ui-datepicker-div
{
	z-index:5555 !important;
}
</style>
<script>
function agencyRepair(yr)
{
	var cyear = "<?php echo date('Y');?>";
	
	if(yr.length == '4')
	{
		var car_age = parseInt(cyear) - parseInt(yr);
		
		if(car_age < 0)
			car_age = car_age*(-1);
		
		/*if(car_age > 3)
		{
			$('#vehicle_agency_repair2').attr('checked','checked');	
			$('#agency_deduct_amt_div').show();	
			$('#vehicle_agency_repair').attr('disabled','disabled');	
		}
		else
		{
			$('#vehicle_agency_repair').removeAttr('disabled');
			$('#vehicle_agency_repair2').removeAttr('checked');	
			$('#agency_deduct_amt_div').hide();	
		}*/
		if(car_age > 7)
		{
			alert('Car age should be maximim 7 years');
			$('#vehicle_made_year').val('');	
		}
	}
}

function displayDeductAmnt()
{
	/*if(document.getElementById('vehicle_agency_repair2').checked==true)
	{
		$('#agency_deduct_amt_div').show();	
	}	
	else
	{
		$('#agency_deduct_amt_div').hide();	
	}*/
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
{/*
	var data = '';
	$('#vtype_section').html('Loading...');
	
	if(vmodel!='')
	{
		var url = '<?php //echo BASE_URL;?>/util/vehicle.php?vehicle_modelid='+vmodel; //alert(url);
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
*/}

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
	  
function validGetAQuoteForm()
{
	var form = document.get_a_quote;
	var flag = true;
	var fields = new Array();
	var pid = $('#policy_type_id').val(); 
	
	var car_val = parseFloat($('#car_value').val());
	
	var min_car_value = parseFloat('<?php echo $min_car_val;?>');
	
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
	
	if(form.driver_age.value == '')
	{
		form.driver_age.style.borderColor='red';
		flag = false;	
		fields.push('driver_age');
	}
	else
	{
		form.driver_age.style.borderColor='#FFF';
	}
	
	if(form.driver_license_issue_date.value == '')
	{
		form.driver_license_issue_date.style.borderColor='red';
		flag = false;	
		fields.push('driver_license_issue_date');
	}
	else
	{
		form.driver_license_issue_date.style.borderColor='#FFF';
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
	
		if(form.vehicle_made_year.value.length < 4)
		{
			$('#vehicle_made_year').css( "border-color", "red" );
			flag = false;	
			fields.push('vehicle_made_year');
		}
		else
		{
			$('#vehicle_made_year').css( "border-color", "#FFFFFF" );
		}
	
		if($('#car_value').val() == '')
		{
			$('#car_value').css( "border-color", "red" );
			flag = false;	
			fields.push('car_value');
		}
		else
		{
			if(car_val < min_car_value)
			{
				alert('Car value should be minimum '+min_car_value+ ' SR');	
				$('#car_value').css( "border-color", "red" );
				flag = false;	
				fields.push('car_value');
			}
			else
			{
				$('#car_value').css( "border-color", "#FFFFFF" );
			}
		}
	
		var btn = form.vehicle_agency_repair.length; 
		//alert(document.step2.package_no.length);
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
<style>
select
{
	height: 29px;
	width: 194px;
	margin: 3px 0 4px 0;	
}
.agency_rpr
{
	float: left;color: #fff;margin: 7px 15px 10px 0;
}
.agency_rpr_div
{
	color:#FFFFFF;
}	
</style>
<?php 
//$display_tpl_clm = 'style="display:none;"';
$display_comp_clm = 'style="display:none;"';
?>
<div>
    <div id="home-form" class="yakeendown brownbox">
        <h2 id="getquote" style="text-align:center;">
            Quick Quote
        </h2>
        <form id="get_a_quote" name="get_a_quote" method="post" onclick="stopslider()">
        	<input type="hidden" name="policy_class_id" value="1" />
            <div id="step-1">
                <!--<div class="form-row-medical">
                	<input id="first_name" name="first_name" placeholder="First Name" type="text">
                </div>
                <div class="form-row-medical">
                	<input id="last_name" name="last_name" placeholder="Last Name" type="text">
                </div>
                <div class="form-row-medical">
                	<input id="email" name="email" placeholder="Email" type="text">
                </div>
                <div class="form-row-medical">
                	<input id="iqma_no" name="iqma_no" placeholder="IQMA Number/Saudi/Company Id" type="text">
                </div>-->
                <div class="form-row-medical">
                	<select name="driver_age" id="driver_age">
                    	<option value="">Driver Age</option>
						<?php
                        $driver_ages_sql = "select * from ".DRIVERAGE." where status='Active' order by age asc";
						$driver_ages = mysql_query($driver_ages_sql);
						while($driver_age = mysql_fetch_array($driver_ages))
						{?>
                        	<option value="<?php echo $driver_age['id'];?>"><?php echo $driver_age['age'];?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                        
                <div class="form-row-medical">
                	<input id="driver_license_issue_date" name="driver_license_issue_date" placeholder="Driver License issuing date" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" class="date_picker_calender" />
                </div>
                
                <div class="form-row-medical">
                	<select name="policy_type_id" id="policy_type_id" onchange="showVehicleColumn(this.value);">
                    	<!--<option value="">Insurance type</option>-->
						<?php
                        $policy_types_sql = "select a.* from ".POLICYTYPES." as a inner join ".PRODUCTS." as b on a.policy_id=b.id where a.status='1' order by a.policy_type desc";
						$policy_types = mysql_query($policy_types_sql);
						while($policy_type = mysql_fetch_array($policy_types))
						{?>
                        	<option value="<?php echo $policy_type['id'];?>" <?php if($policy_type['id']==1){?>selected="selected"<?php }?>><?php echo $policy_type['policy_type'];?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                
                
                                
                <div class="row1 vtype_comp" <?php echo $display_comp_clm;?>>
                        <!--<lable>Vehicle Make</lable>-->
                        <select id="vehicle_make" name="vehicle_make" class="dropdown" onchange="getVehicleModel(this.value);">
                            <option value="">Vehicle Make</option>
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
                    <!--<lable>Vehicle Model</lable>-->
                    <span id="vmodel_section">
                    <select id="vehicle_model" name="vehicle_model" class="dropdown" onchange="getVehicleType(this.value);">
                        <option value="">Vehicle Model</option>
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
                
                <?php /*?><div class="row1 vtype_comp" <?php echo $display_comp_clm;?>>
                    <!--<lable>Vehicle Type</lable>-->
                    <span id="vtype_section">
                    <select id="vehicle_type" name="vehicle_type" class="dropdown">
                        <option value="">Vehicle Type</option>
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
                </div><?php */?>
                
        
                <div class="row1 vtype_tpl" <?php echo $display_tpl_clm;?>>
                    <!--<lable>Vehicle Type</lable>-->
                   <select name="vehicle_type_tpl" id="vehicle_type_tpl"  class="dropdown">
                       <option value="">Car Type</option>
                       <?php 
                        $vehicletypesql = mysql_query("select * from ".VTYPE." where make_id='0' order by type_name asc");
                         ?>
                         <?php while($myrow = mysql_fetch_array($vehicletypesql)): ?>
                        <option value="<?=$myrow["id"]?>"><?=$myrow["type_name"]?></option>
                    <?php endwhile; ?>
                        
                   </select>
                </div>
        
                <?php /*?><div class="row1 vtype_tpl" <?php echo $display_tpl_clm;?>>
                    <!--<lable>Vehicle Cylinder </lable>-->
                    <select name="vehicle_cylender" id="vehicle_cylender"  class="dropdown">
                        <option value="">Vehicle Cylinder</option>
                        <option value="4">4</option>
                        <option value="6">6</option>
                        <option value="8">8</option>
                        <option value="More than 8">More than 8</option>
                    </select>
                </div>
                
                <div class="row1 vtype_tpl" <?php echo $display_tpl_clm;?>>
                   <!-- <lable>Vehicle Weight </lable>-->
                    <select name="vehicle_weight" id="vehicle_weight"  class="dropdown">
                        <option value="">Vehicle Weight</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                
                <div class="row1 vtype_tpl" <?php echo $display_tpl_clm;?>>
                    <!--<lable>Vehicle Seats</lable>-->
                    <select name="vehicle_seats" id="vehicle_seats"  class="dropdown">
                        <option value="">Vehicle Seats</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div><?php */?>
                
                        
                <div class="form-row-medical vtype_comp" <?php echo $display_comp_clm;?>>
                	<input id="vehicle_made_year" name="vehicle_made_year" placeholder="Year" type="text" maxlength="4" onkeypress="return isNumberKey(event)" autocomplete="off" onblur="agencyRepair(this.value);" />
                    <?php /*?><select id="vehicle_made_year" name="vehicle_made_year" onchange="agencyRepair(this.value);">
						<option value="">Year</option>
						<?php 
                        $start_yr = date('Y')-50;
                        $end_yr = date('Y');
                        for($i = $start_yr; $i <= $end_yr; $i++)
                        {
                            ?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php 	
                        }
                        ?>
                    </select><?php */?>
                </div>
                        
                <div class="form-row-medical vtype_comp" <?php echo $display_comp_clm;?>>
                	<input id="car_value" name="car_value" placeholder="Car Value" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" />
                </div>
                <?php /*?><div class="row1">
                    <!--<lable>Vehicle Regd. Place</lable>-->
                    <input type="text" autocomplete="off" name="vehicle_regd_place" id="vehicle_regd_place" value="<?php echo $vehicle_regd_place;?>" placeholder="Vehicle Regd. Place" />
                </div>
                
                <div class="row1">
                   <!-- <lable>Vehicle Ownership</lable>-->
                    <select id="vehicle_ownership" name="vehicle_ownership" class="dropdown">
                        <option value="">Vehicle Ownership</option>
                        <option value="Financed" <?php if($vehicle_ownership == 'Financed'){echo 'selected="selected"';}?>>Financed</option>
                        <option value="Owned" <?php if($vehicle_ownership == 'Owned'){echo 'selected="selected"';}?>>Owned</option>
                        <option value="Leased" <?php if($vehicle_ownership == 'Leased'){echo 'selected="selected"';}?>>Leased</option>
                    </select>
                </div>
                
                <div class="row1">
                    <!--<lable>Vehicle Use</lable>-->
                    <select id="vehicle_use" name="vehicle_use" class="dropdown">
                        <option value="">Vehicle Use</option>
                        <option value="Private" <?php if($vehicle_use == 'Private'){echo 'selected="selected"';}?>>Private</option>
                        <option value="Business" <?php if($vehicle_use == 'Business'){echo 'selected="selected"';}?>>Business</option>
                        <option value="Occasional" <?php if($vehicle_use == 'Occasional'){echo 'selected="selected"';}?>>Occasional</option>
                    </select>
                </div><?php */?>
                
                <div class="row1 agency_rpr_div vtype_comp" <?php echo $display_comp_clm;?>>
                    <lable class="agency_rpr">Agency Repair </lable>
                    <div class="radoipan" style="float:left !important;">
                        <input type="radio" id="vehicle_agency_repair" class="radio" name="vehicle_agency_repair" value="Yes" style=" width: 13%;" 
						<?php if($vehicle_agency_repair=='Yes'){echo 'checked="checked"';}?> onclick="displayDeductAmnt();" />
                        <span>Yes</span>
                        
                        <input type="radio" id="vehicle_agency_repair2" class="radio" name="vehicle_agency_repair" value="No" style=" width: 13%;" <?php if($vehicle_agency_repair=='No'){echo 'checked="checked"';}?>
                         onclick="displayDeductAmnt();" />
                        <span>No</span>
                    </div>
                </div>

            	<?php /*?><div class="row1 vtype_tpl" <?php echo $display_comp_clm;?> style="display:none" id="agency_deduct_amt_div">
                    <select name="agency_deduct_amt" id="agency_deduct_amt"  class="dropdown">
                    <?php 
					$dpkg_sql = mysql_query("select * from ". DEDUCTPKGS." where status='1'");
					while($dpkg_val = mysql_fetch_array($dpkg_sql))
					{?>
                        <option value="<?php echo $dpkg_val['id'];?>"><?php echo $dpkg_val['name'];?> SR</option>
                    <?php }?>
                    </select>
                </div><?php */?>

                <div class="row1">
                    <input id="vehicle_ncd" name="vehicle_ncd" placeholder="Claim Paid" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" />
                </div>

                <?php /*?><div class="row1">
                    <!--<lable>Purchase year</lable>-->
                    <!--<input type="text" autocomplete="off" name="vehicle_purchase_year" id="vehicle_purchase_year"  onkeypress="return isNumberKey(event)" />-->
                    <select id="vehicle_purchase_year" name="vehicle_purchase_year" class="dropdown">
                        <option value="">Purchase year</option>
						<?php  $starting_year  =date('Y', strtotime('-20 year'));
                        $ending_year = date('Y'); 
                        
                        for($starting_year; $starting_year <= $ending_year; $starting_year++) 
						{
							echo '<option value="'.$starting_year.'">'.$starting_year.'</option>';
                        }  ?>
                    </select>
                </div><?php */?>
                        
                <div class="form-row-medical">
                	<input id="mobile_no" name="mobile_no" placeholder="Mobile Number" maxlength="12" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" />
                </div>
                
                <div style="margin-top:10px;"></div>
                <div class="form-row" style="margin-top: 10px;" id="CartSubmit">
                    <button type="submit" id="submit3" name="submit_quote" class="submit" style="position: inherit; margin-left: 25%;" onclick="return validGetAQuoteForm();">
                    	Get A Quote
                    </button>
                </div>
            </div>
        </form>
        <div id="SponsorDivToolTip" style="left: 220px; display: none;">
            A verification code will be sent to this mobile number
        </div>
    </div>
</div>
<script type="text/javascript">
//jQuery.noConflict();
 /*function stopslider(){
	          $('#banner-fade').bjqs({
	            height      : 300,
	            width       : 1000,
	            responsive  : true,
				animspeed   : 4000,
stop : true
	           }); 
  //$('#sldierbanner').clearQueue();
//return true;
	        }*/
  
</script>