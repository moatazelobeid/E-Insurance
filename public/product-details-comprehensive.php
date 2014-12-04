<?php
//Get minimum car value
$min_car_val = (MIN_COMP_PREMIUM_AMT*100)/COMP_PREMIUM_CAR_VALUE_PERCENT;
$min_car_val = round($min_car_val,2);

if(isset($_POST['submit_comp']))
{
	unset($_POST['submit_comp']);
	//print_r($_POST); exit;
	
	$_POST['created_date']=date('Y-m-d H:i:s');
	$_POST['quote_key'] = uniqid();
	
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

if(isset($_POST['submit_tpl']))
{
	unset($_POST['submit_tpl']);
	//print_r($_POST); exit;
	
	$_POST['created_date']=date('Y-m-d H:i:s');
	$_POST['quote_key'] = uniqid();
	
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

if(!empty($_SESSION['get_a_quote_id']))
{
	$quote_details = $db->recordFetch($_SESSION['get_a_quote_id'],POLICYQUOTES.':id');
	$mobile_no = $quote_details['mobile_no']; 
}
//get the product details
if($_GET['page']=='product-details-comprehensive'){
	$product_comp_detail = $db->recordFetch('1',PRODUCTS.':id');
	$product_tpl_detail = $db->recordFetch('3',PRODUCTS.':id');
}
?>
<style>
.msg_box
{
	background: #D9DBDD;
	padding: 8px 10px;
	font-weight: bold;
	font-size: 15px;
}
h3.ui-state-default, .clients_expand_bg {padding:0px!important; border:none!important;}
#accordion .ui-state-hover{background:none!important; border:none!important; padding:0px!important;}
.ui-accordion-header .ui-icon{display:none!important;}
.ui-state-active{padding:0px!important; border:none!important;}
#accordion .ui-accordion-content{padding:0px!important; border:none!important;}
.ui-datepicker select{border:none;}
a.state-active a:link{color:#fff!important; font-weight:bold!important;}
#accordion .ui-state-active a:link{background-image:url(images/icon-.png)!important;color:#fff!important; font-weight:bold!important;}
.lg-4 #tpl_det #accordion .ui-state-active a:link{background-image:url(images/icon-.png)!important;color:#fff!important; font-weight:bold!important;}
#accordion a:link{color:#fff!important; font-weight:bold!important;}
.ui-state-active a{{padding-left: 1em!important;font-family: Arial, Helvetica, sans-serif!important;font-size: 12px!important; color:#fff!important;}

.lg-4 #tpl_det #accordion .ui-state-active a:link{background-image: url(../images/icon-.png)!important;}

</style>
<script type="text/javascript">
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

function validQuoteForm()
{
	var form = document.comp_form;
	var flag = true;
	var fields = new Array();
	
	var car_val = parseFloat($('#car_value').val());
	var min_car_value = parseFloat('<?php echo $min_car_val;?>');

	if(form.driver_age.value == '')
	{
		form.driver_age.style.borderColor='red';
		flag = false;	
		fields.push('driver_age');
	}
	else
	{
		form.driver_age.style.borderColor='#B6B6B6';
	}
	
	if(form.driver_license_issue_date.value == '')
	{
		form.driver_license_issue_date.style.borderColor='red';
		flag = false;	
		fields.push('driver_license_issue_date');
	}
	else
	{
		form.driver_license_issue_date.style.borderColor='#B6B6B6';
	}
	
	if($('#vehicle_make').val() == '')
	{
		$('#vehicle_make').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_make');
	}
	else
	{
		$('#vehicle_make').css( "border-color", "#B6B6B6" );
	}

	if($('#vehicle_model').val() == '')
	{
		$('#vehicle_model').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_model');
	}
	else
	{
		$('#vehicle_model').css( "border-color", "#B6B6B6" );
	}

	if(form.vehicle_made_year.value.length < 4)
	{
		$('#vehicle_made_year').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_made_year');
	}
	else
	{
		$('#vehicle_made_year').css( "border-color", "#B6B6B6" );
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
			$('#car_value').css( "border-color", "#B6B6B6" );
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
		$('.agency_rpr').css( "color", "#B6B6B6" );
	}
	else
	{
		flag = false;	
		$('.agency_rpr').css( "color", "red" );
	}
	
	if($('#vehicle_ncd').val() == '' && $('#vehicle_ncd').val() != '0')
	{
		$('#vehicle_ncd').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_ncd');
	}
	else
	{
		$('#vehicle_ncd').css( "border-color", "#B6B6B6" );
	}
	
	if(form.mobile_no.value == '')
	{
		form.mobile_no.style.borderColor='red';
		flag = false;	
		fields.push('mobile_no');
	}
	else
	{
		form.mobile_no.style.borderColor='#B6B6B6';
	}
	
	if(fields.length>0)
	{
		var fld = fields[0];
		
		$('#'+fld).focus();
		flag = false;	
	}
	
	return flag;
}
function validTplForm()
{
	var form = document.tpl_form;
	var flag = true;
	var fields = new Array();

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
		form.policy_type_id.style.borderColor='#B6B6B6';
	}
	
	if(form.driver_age.value == '')
	{
		form.driver_age.style.borderColor='red';
		flag = false;	
		fields.push('driver_age');
	}
	else
	{
		form.driver_age.style.borderColor='#B6B6B6';
	}
	
	if(form.driver_license_issue_date.value == '')
	{
		form.driver_license_issue_date.style.borderColor='red';
		flag = false;	
		fields.push('driver_license_issue_date');
	}
	else
	{
		form.driver_license_issue_date.style.borderColor='#B6B6B6';
	}
	
	if($('#vehicle_type_tpl').val() == '')
	{
		$('#vehicle_type_tpl').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_type_tpl');
	}
	else
	{
		$('#vehicle_type_tpl').css( "border-color", "#B6B6B6" );
	}

	if($('#vehicle_ncd').val() == '' && $('#vehicle_ncd').val() != '0')
	{
		$('#vehicle_ncd').css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_ncd');
	}
	else
	{
		$('#vehicle_ncd').css( "border-color", "#B6B6B6" );
	}
	
	if(form.mobile_no.value == '')
	{
		form.mobile_no.style.borderColor='red';
		flag = false;	
		fields.push('mobile_no');
	}
	else
	{
		form.mobile_no.style.borderColor='#B6B6B6';
	}
	
	if(fields.length>0)
	{
		var fld = fields[0];
		
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}
function showPanelContent(panelid){
	if(panelid == "comp_det"){
		$("#CMT").html('Comprehensive Motor Insurance');
		$("#"+panelid).show();
		$("#tpl_det").hide();
	}else if(panelid == "tpl_det"){
		$("#CMT").html('Motor insurance (TPL)');
		$("#"+panelid).show();
		$("#comp_det").hide();
	}
}

$(function() {
	$( ".date_picker_calender" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:<?php echo date('Y');?>' , changeMonth: 'true',maxDate:0 } );
});
</script>
<style type="text/css">
#formpan form input[type="text"] {
	text-align: left;
	height: 28px;
	font-weight: normal;
	border: 1px solid #B6B6B6;
	outline: none;
	line-height: 23px;
	padding: 2px;
	font-family: Arial, Helvetica, sans-serif;
	/* float: right; */
	margin-bottom: 10px;
	margin-top: 5px;
	font-size: 12px;
	color: #000;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	width: 98.5%;
	background-color: #fff;
	border: 1px solid #C1C4C5;
	box-shadow: 0 1px 2px rgba(0,0,0,.1) inset;
	color: rgba(0,0,0,.75);
}
</style>
<div class="innrebodypanel">
    <div class="clearfix" style="height:15px;">.</div>
    <div class="innerwrap">
    
        <div class="breadcrumb" >
            <a itemprop="url" href="<?=BASE_URL?>">Home</a> 
            <span class="breeadset">&#8250;</span>
            <a itemprop="url" href="#">Motor Insurance</a> 
            <span class="breeadset">&#8250;</span>
            <strong><span id="CMT">Comprehensive Motor Insurance</span></strong>
        </div>
        
        <div class="lg-4" style="width: 42%;">
		<div id="comp_det" style="display: block;">
            <h2><?=stripslashes($product_comp_detail['product_title'])?></h2>
            <?=stripslashes($product_comp_detail['product_description'])?>
            <div class="clear" style="height: 10px;"></div>
            <div id="accordion">
                <div>
                    <h3><a href="#" style="color: #fff;font-weight: bold;">Key Benefits & Features</a></h3>
                    <div class="clients_expand_bg" style="height:auto;">
                        <?=stripslashes($product_comp_detail['product_key'])?>
                    </div>
                </div>
                
                <div>
                    <h3><a href="#" style="color: #fff;font-weight: bold;">Terms & Conditions</a></h3>
                    <div class="clients_expand_bg" style="height:auto;">
                        <?=stripslashes($product_comp_detail['product_terms'])?>
                    </div>
                </div>
                
            </div>
            
            <br />
            
            <a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=1">
            <button value="" class="buybtn" style="width: 25%;">Buy Now</button>
            </a>
            
            <div class="clearfix" style="height:50px;"></div>
			</div>
			
			<div id="tpl_det" style="display: none;">
			<h2><?=stripslashes($product_tpl_detail['product_title'])?></h2>
            <?=stripslashes($product_tpl_detail['product_description'])?>
            <div class="clear" style="height: 10px;"></div>
            <div id="accordion1">
                <div>
                    <h3><a href="#" style="color: #fff;font-weight: bold;">Key Benefits & Features</a></h3>
                    <div class="clients_expand_bg" style="height:auto;">
                        <?=stripslashes($product_tpl_detail['product_key'])?>
                    </div>
                </div>
                
                <div>
                    <h3><a href="#" style="color: #fff;font-weight: bold;">Terms & Conditions</a></h3>
                    <div class="clients_expand_bg" style="height:auto;">
                        <?=stripslashes($product_tpl_detail['product_terms'])?>
                    </div>
                </div>
                
            </div>
            
            <br />
            
            <a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=1">
            <button value="" class="buybtn" style="width: 25%;">Buy Now</button>
            </a>
            
            <div class="clearfix" style="height:50px;"></div>
			</div>
			
        </div>
       

        <div class="lg-5" style="width: 55%;">
		
		<div>
                          <div id="TabbedPanels1" class="TabbedPanels">
                            <ul class="TabbedPanelsTabGroup">
                              <li class="TabbedPanelsTab" tabindex="0" onclick="showPanelContent('comp_det')">Comprehensive</li>
                              <li class="TabbedPanelsTab" tabindex="0" onclick="showPanelContent('tpl_det')">TPL</li>
                            </ul>
                            <div class="TabbedPanelsContentGroup">
                            
                              <div class="TabbedPanelsContent">
							  
                                    <div id="formpan">
									<form method="post" name="comp_form" id="comp_form" onsubmit="return validQuoteForm();">
									<h4 style="color:#000;font-size: 16px; position:relative; top:-5px; text-align:center; margin:0; text-transform: uppercase;">Quick Quote</h4>
									<input type="hidden" name="policy_class_id" value="1" />
									<input type="hidden" name="policy_type_id" value="2" />
									<div class="row1">
										<lable>Driver Age</lable>
										
										<select name="driver_age" id="driver_age" class="dropdown">
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
									
									<div class="row1">
										<lable>Driver License Issuing Date</lable>
										<input id="driver_license_issue_date" name="driver_license_issue_date" placeholder="Driver License issuing date" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" class="date_picker_calender" />
									</div>
									
									<div class="row1">
										<lable>Vehicle Make</lable>
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
									
									<div class="row1">
										<lable>Vehicle Model</lable>
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
									
									<div class="row1">
										<lable>Made Year</lable>
										<input id="vehicle_made_year" name="vehicle_made_year" placeholder="Year" type="text" maxlength="4" onkeypress="return isNumberKey(event)" autocomplete="off" onblur="agencyRepair(this.value);" />
									</div>
									
									<div class="row1">
										<lable>Car Value</lable>
										<input id="car_value" name="car_value" placeholder="Car Value" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" />
									</div>
									
									<div class="row1">
										<lable><span id="agency-label">Agency Repair</span></lable>
										<div class="radoipan" style="float:left;">
						<input type="radio" id="vehicle_agency_repair" class="radio" name="vehicle_agency_repair" value="Yes" style=" width: 13%;" 
						<?php if($vehicle_agency_repair=='Yes'){echo 'checked="checked"';}?> onclick="displayDeductAmnt();" />
                        <span style="color: #333;">Yes</span>
                        
                        <input type="radio" id="vehicle_agency_repair2" class="radio" name="vehicle_agency_repair" value="No" style=" width: 13%;" <?php if($vehicle_agency_repair=='No'){echo 'checked="checked"';}?>
                         onclick="displayDeductAmnt();" />
                        <span style="color: #333;">No</span>
										</div>
									</div>
									<div class="clearfix" style="height:5px;"></div>
									
									<?php /*?><div class="row1 vtype_tpl" style="display:none" id="agency_deduct_amt_div">
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
										<lable><span id="agency-label">Claim Paid</span></lable>
										<input id="vehicle_ncd" name="vehicle_ncd" placeholder="Claim Paid" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" />
									</div>
									
									<div class="clearfix" style="height:5px;"></div>
									
									<div class="row1">
										<lable>Mobile No</lable>
										<input id="mobile_no" name="mobile_no" placeholder="Mobile Number" maxlength="12" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" />
									</div>
									
									<div style="font-size: 11px;clear: both; font-family:Arial, Helvetica, sans-serif; position:relative; top:8px; color: Red;">
									  * Required Fields
									  <br /><br />
									</div>
									
									<div class="clear" style="height:5px;">&nbsp;</div>
										<input type="submit" class="submit_button" name="submit_comp" value="Get A Quote" style="width: 30%;
margin-left: 35%;"/>
									</form>
                      <div class="clear" style="height:1px;"></div>
                    </div>
                              </div>
                              <div class="TabbedPanelsContent">
                                    <div id="formpan">
									<form method="post" name="tpl_form" id="tpl_form" onsubmit="return validTplForm();">
									<h4 style="color:#000;font-size: 16px; position:relative; top:-5px; text-align:center; margin:0; text-transform: uppercase;">Quick Quote</h4>
									<input type="hidden" name="policy_class_id" value="1" />
									<input type="hidden" name="policy_type_id" value="1" />
									
									<div class="row1">
									<lable>Vehicle Type</lable>
									<select name="driver_age" id="driver_age" class="dropdown">
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
									
									<div class="row1">
									<lable>Driver License Issuing Date</lable>
									<input id="driver_license_issue_date" name="driver_license_issue_date" placeholder="Driver License issuing date" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" class="date_picker_calender" />
									</div>
									
									<div class="row1">
									<lable>Car Type</lable>
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

									<div class="row1">
									<lable>Claim Paid</lable>
									<input id="vehicle_ncd" name="vehicle_ncd" placeholder="Claim Paid" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" />
									</div>

									<div class="row1">
										<lable>Mobile No</lable>
										<input id="mobile_no" name="mobile_no" placeholder="Mobile Number" maxlength="12" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" />
									</div>
									<div style="font-size: 11px;clear: both; font-family:Arial, Helvetica, sans-serif; position:relative; top:8px; color: red;">
									* Required Fields
									<br /><br />
									</div>
									
									<div class="clear" style="height:5px;">&nbsp;</div>
									<input type="submit" class="submit_button" name="submit_tpl" value="Get A Quote" style="width: 30%;
margin-left: 35%;" />
									
									</form>
                                          <div class="clear" style="height:1px;"></div>
                                        </div>
                              </div>
                            </div>
                          </div>
                        </div>
		
								
          
        </div>
    
    <div class="clearfix"></div>
    </div>
    <div class="clearfix" style="height:15px;">.</div>
</div>