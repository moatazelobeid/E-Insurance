<!--<h1 style="height: 200PX;
text-align: center;
FONT-SIZE: 50px;
padding-top: 150PX;">COMING SOON</h1>-->



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
</style>
<script>
function getVehicleModel(vmake,id)
{
	var data = '';
	$('#vmodel_section_'+id).html('Loading...');
	
	if(vmake!='')
	{
		var url = '<?php echo BASE_URL;?>/util/vehicle.php?vehicle_id='+vmake+'&vno='+id; 
		$.get(url,function(res)
		{
			//alert(res);
			if(res!=0)
			{
				data = res;
			}
			else
			{
				data = '<select id="vehicle_model_'+id+'" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
			}
			$('#vmodel_section_'+id).html(data);
		});
	}
	else
	{
		data = '<select id="vehicle_model_'+id+'" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
		$('#vmodel_section_'+id).html(data);
	}
	getVehicleType('',id);
}
function getVehicleType(vmodel,id)
{
	var data = '';
	$('#vtype_section_'+id).html('Loading...');
	
	if(vmodel!='')
	{
		var url = '<?php echo BASE_URL;?>/util/vehicle.php?vehicle_modelid='+vmodel+'&vno='+id; //alert(url);
		$.get(url,function(res)
		{
			//alert(res);
			if(res!=0)
			{
				data = res;
			}
			else
			{
				data = '<select id="vehicle_model_'+id+'" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
			}
			$('#vtype_section_'+id).html(data);
		});
	}
	else
	{
		data = '<select id="vehicle_type_'+id+'" name="vehicle_type" class="dropdown"><option value="">Select</option></select>';
		$('#vtype_section_'+id).html(data);
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

function validCompForm(id)
{
	var flag = true;
	var fields = new Array();

	if($('#policy_type_id_'+id).val() == '')
	{
		$('#policy_type_id_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('#policy_type_id_'+id);
	}
	else
	{
		$('#policy_type_id_'+id).css( "border-color", "#B6B6B6" );
	}

	if($('#vehicle_make_'+id).val() == '')
	{
		$('#vehicle_make_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_make_'+id);
	}
	else
	{
		$('#vehicle_make_'+id).css( "border-color", "#B6B6B6" );
	}

	if($('#vehicle_model_'+id).val() == '')
	{
		$('#vehicle_model_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_model_'+id);
	}
	else
	{
		$('#vehicle_model_'+id).css( "border-color", "#B6B6B6" );
	}

	if($('#vehicle_type_'+id).val() == '')
	{
		$('#vehicle_type_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_type_'+id);
	}
	else
	{
		$('#vehicle_type_'+id).css( "border-color", "#B6B6B6" );
	}

	if($('#vehicle_regd_place_'+id).val() == '')
	{
		$('#vehicle_regd_place_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_regd_place_'+id);
	}
	else
	{
		$('#vehicle_regd_place_'+id).css( "border-color", "#B6B6B6" );
	}

	if($('#vehicle_ownership_'+id).val() == '')
	{
		$('#vehicle_ownership_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_ownership_'+id);
	}
	else
	{
		$('#vehicle_ownership_'+id).css( "border-color", "#B6B6B6" );
	}

	if($('#vehicle_use_'+id).val() == '')
	{
		$('#vehicle_use_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_use_'+id);
	}
	else
	{
		$('#vehicle_use_'+id).css( "border-color", "#B6B6B6" );
	}

	/*if(form.vehicle_agency_repair.value == '')
	{
		form.vehicle_agency_repair.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_agency_repair');
	}
	else
	{
		form.vehicle_agency_repair.style.borderColor='#B6B6B6';
	}*/

	if($('#vehicle_ncd_'+id).val() == '')
	{
		$('#vehicle_ncd_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_ncd_'+id);
	}
	else
	{
		$('#vehicle_ncd_'+id).css( "border-color", "red" );
	}

	if(form.vehicle_purchase_year.value == '')
	{
		$('#policy_type_id_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('vehicle_purchase_year');
	}
	else
	{
		$('#vehicle_make_'+id).css( "border-color", "red" );
	}

	if(form.first_name.value == '')
	{
		$('#policy_type_id_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('first_name');
	}
	else
	{
		$('#vehicle_make_'+id).css( "border-color", "red" );
	}

	if(form.last_name.value == '')
	{
		$('#last_name_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('last_name_'+id);
	}
	else
	{
		$('#last_name_'+id).css( "border-color", "#B6B6B6" );
	}
	
	if(!validEmail($('#email_'+id).val()))
	{
		$('#email_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('email_'+id);
	}
	else
	{
		$('#email_'+id).css( "border-color", "#B6B6B6" );
	}
	
	if($('#mobile_no_'+id).val() == '')
	{
		$('#mobile_no_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('mobile_no_'+id);
	}
	else
	{
		$('#mobile_no_'+id).css( "border-color", "#B6B6B6" );
	}
	
	if($('#dob_'+id).val() == '')
	{
		$('#dob_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('dob_'+id);
	}
	else
	{
		$('#dob_'+id).css( "border-color", "#B6B6B6" );
	}
	
	if($('#country_'+id).val() == '')
	{
		$('#country_'+id).css( "border-color", "red" );
		flag = false;	
		fields.push('country_'+id);
	}
	else
	{
		$('#country_'+id).css( "border-color", "#B6B6B6" );
	}
	if(fields.length>0)
	{
		var fld = fields[0];
		
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}

$(function() {
	//$( "#vehicles" ).accordion();
	
	$("#vehicles").accordion({
		collapsible  : true,
		active       : false,
		//heightStyle  : "content",
		navigation   : true
	}); 
	
	<?php if(!empty($_GET['vehicle']))
	{?>
		$('#vid_<?php echo $_GET['vehicle'];?>').click();
	<?php }?>
    

	
});


function removeVehicle(m)
{
	var url = '<?php BASE_URL;?>index.php?page=motor-insurance&step=1<?php if($_GET['vehicle']){echo '&vehicle='.$_GET['vehicle'];}?>&del='+m;	
	window.location.href = url;
}

</script>

<?php 
$step = $_GET['step']; 
if(empty($step))
	$step = 1;

	
//first step submit	
if(isset($_POST['submit']))
{
	unset($_POST['submit']);	
	unset($_POST['save_to_quote']);	
	
	$_POST['first_name'] = addslashes($_POST['first_name']);
	$_POST['last_name'] = addslashes($_POST['last_name']);
	$_POST['email'] = addslashes($_POST['email']);
	
	$vcnt = count($_SESSION['motor']['Vehicle']);
	exit;
	$_SESSION['motor']['Vehicle'][$vcnt] = $_POST;
	
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
	
	$policy_type_id = $_SESSION['motor']['Vehicle']['policy_type_id'];
	
	//Only for comprehensive	
	$vehicle_make = $_SESSION['motor']['Vehicle']['vehicle_make'];	
	$vehicle_model = $_SESSION['motor']['Vehicle']['vehicle_model'];	
	$vehicle_type = $_SESSION['motor']['Vehicle']['vehicle_type'];	
	$vehicle_agency_repair = $_SESSION['motor']['Vehicle']['vehicle_agency_repair'];	
	$vehicle_ncd = $_SESSION['motor']['Vehicle']['vehicle_ncd'];	
	
	//Only for tpl	
	$vehicle_type_tpl = $_SESSION['motor']['Vehicle']['vehicle_type_tpl'];
	$vehicle_cylender = $_SESSION['motor']['Vehicle']['vehicle_cylender'];	
	$vehicle_weight = $_SESSION['motor']['Vehicle']['vehicle_weight'];	
	$vehicle_seats = $_SESSION['motor']['Vehicle']['vehicle_seats'];
	
	//common for both tpl and comprehensive	
	$vehicle_regd_place = $_SESSION['motor']['Vehicle']['vehicle_regd_place'];	
	$vehicle_ownership = $_SESSION['motor']['Vehicle']['vehicle_ownership'];	
	$vehicle_use = $_SESSION['motor']['Vehicle']['vehicle_use'];	
	$vehicle_purchase_year = $_SESSION['motor']['Vehicle']['vehicle_purchase_year'];	
	
	$first_name = $_SESSION['motor']['Vehicle']['first_name'];	
	$last_name = $_SESSION['motor']['Vehicle']['last_name'];	
	$email = $_SESSION['motor']['Vehicle']['email'];	
	$mobile_no = $_SESSION['motor']['Vehicle']['mobile_no'];	
	$dob = $_SESSION['motor']['Vehicle']['dob'];	
	$country = $_SESSION['motor']['Vehicle']['country'];	
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
                <li><a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=2" <?php if($step == 2){echo 'class="active"';}?>>Step-2</a></li>
                <li><a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=3" <?php if($step == 3){echo 'class="active"';}?>>Step-3</a></li>
                <li><a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=4" <?php if($step == 4){echo 'class="active"';}?>>Step-4</a></li>
                <li><a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=5" <?php if($step == 5){echo 'class="active"';}?>>Step-5</a></li>
            </ul>
            
            <?php if($step == 1)
			{?>
                <div id="step-1" class="ins_content formpan">
                	<?php 
					
					if(!empty($_SESSION['motor']['Vehicle']))
					{?>
                        <div id="vehicles">
                        
                        	<?php $m = 0; //session_destroy();
							//echo '<pre>';print_r($_SESSION['motor']['Vehicle']);echo '</pre>';
							foreach($_SESSION['motor']['Vehicle'] as $key=>$motor)
							{
								$m++;
								
								//echo '<pre>';print_r($_SESSION['motor']['Vehicle']);echo '</pre>';
								
								$policy_type_id = '';
								
								$vehicle_make = '';	
								$vehicle_model = '';	
								$vehicle_type = '';	
								$vehicle_agency_repair = '';	
								$vehicle_ncd = '';	
								$vehicle_type_tpl = '';
								$vehicle_cylender = '';	
								$vehicle_weight = '';	
								$vehicle_seats = '';
								$vehicle_regd_place = '';	
								$vehicle_ownership = '';	
								$vehicle_use = '';	
								$vehicle_purchase_year = '';	
								$first_name = '';	
								$last_name = '';	
								$email = '';	
								$mobile_no = '';	
								$dob = '';	
								$country = '';	
								
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
								?>
                            
                                <h2>
                                	Vehicle-<?php echo $m;?>
                                	<div style="float: right;position: relative;top: 0px;color: red; cursor:pointer;" onclick="removeVehicle(<?php echo $m;?>);">
                                    	X
                                    </div>
                                </h2>
                        
                                <form name="step1_<?php echo $m;?>" id="step1_<?php echo $m;?>" method="post">
                                    <input type="hidden" name="vehicle_no" value="<?php echo $m;?>" />
                                    
                                    <div class="clearfix" style="height:10px;"></div>
                                    <h2>Vehicle Information</h2>
                                    <div class="clearfix" style="height:10px;"></div>
                                    
                                    <div class="row1">
                                            <lable>Insurance type</lable>
                                            <select name="policy_type_id" id="policy_type_id_<?php echo $m;?>" class="dropdown">
                                                <option value="">Insurance type</option>
                                                <?php
                                                $policy_types_sql = "select a.* from ".POLICYTYPES." as a inner join ".PRODUCTS." as b on a.policy_id=b.id where a.status='1' order by a.policy_type asc";
                                                $policy_types = mysql_query($policy_types_sql);
                                                while($policy_type = mysql_fetch_array($policy_types))
                                                {?>
                                                    <option value="<?php echo $policy_type['id'];?>" <?php if($policy_type_id == $policy_type['id']){echo 'selected="selected"';}?>><?php echo $policy_type['policy_type'];?></option>
                                                <?php }  ?>
                                        </select>
                    
                                        </div>
                                        
                                    <div class="row1">
                                            <lable>Vehicle Make</lable>
                                            <select id="vehicle_make_<?php echo $m;?>" name="vehicle_make" class="dropdown" onchange="getVehicleModel(this.value,<?php echo $m;?>);">
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
                                        
                                    <div class="row1">
                                        <lable>Vehicle Model</lable>
                                        <span id="vmodel_section_<?php echo $m;?>">
                                        <select id="vehicle_model_<?php echo $m;?>" name="vehicle_model" class="dropdown" onchange="getVehicleType(this.value,<?php echo $m;?>);">
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
                                    
                                    <div class="row1">
                                        <lable>Vehicle Type</lable>
                                        <span id="vtype_section_<?php echo $m;?>">
                                        <select id="vehicle_type_<?php echo $m;?>" name="vehicle_type" class="dropdown">
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
                                    
                                    <div class="row1">
                                        <lable>Vehicle Regd. Place</lable>
                                        <input type="text" autocomplete="off" name="vehicle_regd_place" id="vehicle_regd_place_<?php echo $m;?>" value="<?php echo $vehicle_regd_place;?>">
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Vehicle Ownership</lable>
                                        <select id="vehicle_ownership_<?php echo $m;?>" name="vehicle_ownership" class="dropdown">
                                            <option value="">Select</option>
                                            <option value="Financed" <?php if($vehicle_ownership == 'Financed'){echo 'selected="selected"';}?>>Financed</option>
                                            <option value="Owned" <?php if($vehicle_ownership == 'Owned'){echo 'selected="selected"';}?>>Owned</option>
                                            <option value="Leased" <?php if($vehicle_ownership == 'Leased'){echo 'selected="selected"';}?>>Leased</option>
                                        </select>
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Vehicle Use</lable>
                                        <?php /*?><input type="text" autocomplete="off" name="vehicle_use" id="vehicle_use" value="<?php echo $vehicle_use;?>"><?php */?>
                                        <select id="vehicle_use_<?php echo $m;?>" name="vehicle_use" class="dropdown">
                                            <option value="">Select</option>
                                            <option value="Private" <?php if($vehicle_use == 'Private'){echo 'selected="selected"';}?>>Private</option>
                                            <option value="Business" <?php if($vehicle_use == 'Business'){echo 'selected="selected"';}?>>Business</option>
                                            <option value="Occasional" <?php if($vehicle_use == 'Occasional'){echo 'selected="selected"';}?>>Occasional</option>
                                        </select>
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Agency Repair </lable>
                                        <div class="radoipan" style="float:left !important;">
                                            <input type="radio" id="vehicle_agency_repair_<?php echo $m;?>" class="radio" name="vehicle_agency_repair" value="Yes" style=" width: 13%;" <?php if($vehicle_agency_repair=='Yes'){echo 'checked="checked"';}?> />
                                            <span>Yes</span>
                                            
                                            <input type="radio" id="vehicle_agency_repair2_<?php echo $m;?>" class="radio" name="vehicle_agency_repair" value="No" style=" width: 13%;" <?php if($vehicle_agency_repair=='No'){echo 'checked="checked"';}?> />
                                            <span>No</span>
                                        </div>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    <div class="row1">
                                        <lable>No Claim Discount (NCD)</lable>
                                        <select id="vehicle_ncd_<?php echo $m;?>" name="vehicle_ncd" class="dropdown" style="margin-top:7px;">
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
                                
                                    <div class="row1">
                                        <lable>Purchase year</lable>
                                        <!--<input type="text" autocomplete="off" name="vehicle_purchase_year" id="vehicle_purchase_year"  onkeypress="return isNumberKey(event)" />-->
                                        <select id="vehicle_purchase_year_<?php echo $m;?>" name="vehicle_purchase_year" class="dropdown" style="margin-top:7px;">
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
                                    </div>
                                
                                    <div class="row1">
                                        <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Driver's Information!</strong></lable>
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>First Name  *</lable>
                                        <input type="text" autocomplete="off" name="first_name" id="first_name_<?php echo $m;?>" value="<?php echo $first_name;?>" />
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Last name </lable>
                                        <input type="text" autocomplete="off" name="last_name" id="last_name_<?php echo $m;?>" value="<?php echo $last_name;?>" />
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Email   *</lable>
                                        <input type="text" autocomplete="off" name="email" id="email_<?php echo $m;?>" value="<?php echo $email;?>" />
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Mobile no   *</lable>
                                        <input type="text" autocomplete="off" name="mobile_no" id="mobile_no_<?php echo $m;?>"  onkeypress="return isNumberKey(event)" value="<?php echo $mobile_no;?>" />
                                    </div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Date of Birth *</lable>
                                        <input type="text" autocomplete="off" class="date_picker" name="dob" id="dob_<?php echo $m;?>" value="<?php echo $dob;?>">
                                    </div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Country  *</lable>
                                        <select id="country_<?php echo $m;?>" name="country" class="dropdown">
                                            <option value="">-Select-</option>
                                            <option value="AGRA" <?php if($country=='AGRA'){echo 'selected="selected"';}?>>AGRA</option>
                                        </select>
                                    </div>
                                    
                                    <div style="font-size: 11px;clear: both; font-family:Arial, Helvetica, sans-serif; position:relative; top:8px;">
                                      * Required Fields
                                      <br /><br />
                                    </div>
                                    <input type="submit" class="submit_button" name="submit" value="submit" style="width: 100px;float: right;" onclick="return validCompForm(<?php echo $m;?>);" />
                                    <input type="reset" class="submit_button" value="Clear" style="width: 100px;float: right;margin-right: 10px;" />
                                    <div class="clearfix" style="height:10px;"></div>
                                    
                                </form>
                            
                            <?php }
							
							//echo $add_more_vehicle_no;
							
							if(!empty($_GET['vehicle']) && ($_GET['vehicle'] == $add_more_vehicle_no))
							{
								$vno = $add_more_vehicle_no;?>
                            
                                <h2 id="vid_<?php echo $add_more_vehicle_no;?>">Vehicle-<?php echo $add_more_vehicle_no;?></h2>
                        
                                <form name="step1_<?php echo $vno;?>" id="step1_<?php echo $vno;?>" method="post">
                                   <input type="hidden" name="vehicle_no" value="<?php echo $vno;?>" /> 
                                    <div class="clearfix" style="height:10px;"></div>
                                    <h2>Vehicle Information</h2>
                                    <div class="clearfix" style="height:10px;"></div>
                                    
                                    <div class="row1">
                                            <lable>Insurance type</lable>
                                            <select name="policy_type_id_<?php echo $vno;?>" id="policy_type_id" class="dropdown">
                                                <option value="">Insurance type</option>
                                                <?php
                                                $policy_types_sql = "select a.* from ".POLICYTYPES." as a inner join ".PRODUCTS." as b on a.policy_id=b.id where a.status='1' order by a.policy_type asc";
                                                $policy_types = mysql_query($policy_types_sql);
                                                while($policy_type = mysql_fetch_array($policy_types))
                                                {?>
                                                    <option value="<?php echo $policy_type['id'];?>"><?php echo $policy_type['policy_type'];?></option>
                                                <?php }  ?>
                                        </select>
                    
                                        </div>
                                        
                                    <div class="row1">
                                            <lable>Vehicle Make</lable>
                                            <select id="vehicle_make_<?php echo $vno;?>" name="vehicle_make" class="dropdown" onchange="getVehicleModel(this.value,<?php echo $vno;?>);">
                                                <option value="">Select</option>
                                                <?php
                                                $vmakes_sql = "select * from ".VMAKE." where status='1' order by make asc";
                                                $vmakes = mysql_query($vmakes_sql);
                                                while($vmake = mysql_fetch_array($vmakes))
                                                {?>
                                                    <option value="<?php echo $vmake['id'];?>">
                                                        <?php echo $vmake['make'];?>
                                                    </option>
                                                <?php }?>
                                            </select>
                                      </div>
                                        
                                    <div class="row1">
                                        <lable>Vehicle Model</lable>
                                        <span id="vmodel_section_<?php echo $vno;?>">
                                        <select id="vehicle_model_<?php echo $vno;?>" name="vehicle_model" class="dropdown" onchange="getVehicleType(this.value,<?php echo $vno;?>);">
                                            <option value="">Select</option>
                                        </select>
                                        </span>
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Vehicle Type</lable>
                                        <span id="vtype_section_<?php echo $vno;?>">
                                        <select id="vehicle_type_<?php echo $vno;?>" name="vehicle_type" class="dropdown">
                                            <option value="">Select</option>
                                        </select>
                                        </span>
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Vehicle Regd. Place</lable>
                                        <input type="text" autocomplete="off" name="vehicle_regd_place" id="vehicle_regd_place_<?php echo $vno;?>" />
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Vehicle Ownership</lable>
                                        <select id="vehicle_ownership_<?php echo $vno;?>" name="vehicle_ownership" class="dropdown">
                                            <option value="">Select</option>
                                            <option value="Financed">Financed</option>
                                            <option value="Owned">Owned</option>
                                            <option value="Leased">Leased</option>
                                        </select>
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Vehicle Use</lable>
                                        <?php /*?><input type="text" autocomplete="off" name="vehicle_use" id="vehicle_use" value="<?php echo $vehicle_use;?>"><?php */?>
                                        <select id="vehicle_use_<?php echo $vno;?>" name="vehicle_use" class="dropdown">
                                            <option value="">Select</option>
                                            <option value="Private">Private</option>
                                            <option value="Business">Business</option>
                                            <option value="Occasional">Occasional</option>
                                        </select>
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Agency Repair </lable>
                                        <div class="radoipan" style="float:left !important;">
                                            <input type="radio" id="vehicle_agency_repair_<?php echo $vno;?>" class="radio" name="vehicle_agency_repair" value="Yes" style=" width: 13%;" />
                                            <span>Yes</span>
                                            
                                            <input type="radio" id="vehicle_agency_repair2_<?php echo $vno;?>" class="radio" name="vehicle_agency_repair" value="No" style=" width: 13%;" />
                                            <span>No</span>
                                        </div>
                                    </div>
                                    <div class="clearfix" style="height:5px;"></div>
                                    <div class="row1">
                                        <lable>No Claim Discount (NCD)</lable>
                                        <select id="vehicle_ncd_<?php echo $vno;?>" name="vehicle_ncd" class="dropdown" style="margin-top:7px;">
                                            <option value="">Select</option>
                                            <?php
                                            for($n=0; $n<=5; $n++)
                                            {
                                                $ncd_selected = '';
                                                if($vehicle_ncd == $n)
                                                    $ncd_selected = 'selected="selected"';
                                                echo '<option value="'.$n.'">'.$n.'</option>';
                                            }?>
                                        </select>
                                    </div>
                                
                                    <div class="row1">
                                        <lable>Purchase year</lable>
                                        <!--<input type="text" autocomplete="off" name="vehicle_purchase_year" id="vehicle_purchase_year"  onkeypress="return isNumberKey(event)" />-->
                                        <select id="vehicle_purchase_year_<?php echo $vno;?>" name="vehicle_purchase_year" class="dropdown" style="margin-top:7px;">
                                            <?php  $starting_year  =date('Y', strtotime('-20 year'));
                                            $ending_year = date('Y'); 
                                            
                                            for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                                if($starting_year == date('Y')) {
                                                    echo '<option value="'.$starting_year.'" selected="selected">'.$starting_year.'</option>';
                                                } else {
                                                    echo '<option value="'.$starting_year.'">'.$starting_year.'</option>';
                                                }
                                            }  ?>
                                        </select>
                                    </div>
                                
                                    <div class="row1">
                                        <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Driver's Information!</strong></lable>
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>First Name  *</lable>
                                        <input type="text" autocomplete="off" name="first_name" id="first_name_<?php echo $vno;?>" />
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Last name </lable>
                                        <input type="text" autocomplete="off" name="last_name" id="last_name_<?php echo $vno;?>" />
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Email   *</lable>
                                        <input type="text" autocomplete="off" name="email" id="email_<?php echo $vno;?>" />
                                    </div>
                                    
                                    <div class="row1">
                                        <lable>Mobile no   *</lable>
                                        <input type="text" autocomplete="off" name="mobile_no" id="mobile_no_<?php echo $vno;?>"  onkeypress="return isNumberKey(event)" />
                                    </div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Date of Birth *</lable>
                                        <input type="text" autocomplete="off" class="date_picker" name="dob" id="dob_<?php echo $vno;?>" />
                                    </div>
                                    
                                    
                                    <div class="row1">
                                        <lable>Country  *</lable>
                                        <select id="country_<?php echo $vno;?>" name="country" class="dropdown">
                                            <option value="">-Select-</option>
                                            <option value="AGRA">AGRA</option>
                                        </select>
                                    </div>
                                    
                                    <div style="font-size: 11px;clear: both; font-family:Arial, Helvetica, sans-serif; position:relative; top:8px;">
                                      * Required Fields
                                      <br /><br />
                                    </div>
                                    <input type="submit" class="submit_button" name="submit" value="submit" style="width: 100px;float: right;" onclick="return validCompForm('<?php echo $add_more_vehicle_no;?>');" />
                                    <input type="reset" class="submit_button" value="Clear" style="width: 100px;float: right;margin-right: 10px;" />
                                    <div class="clearfix" style="height:10px;"></div>
                                    
                                </form>
                            						
							<?php }?>
                            
                        </div>
                        
                        <a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=1&vehicle=<?php echo $add_more_vehicle_no;?>">
                            <input type="button" class="submit_button" value="Add More Vehicle" style="width: 20%;margin-left: 40%;" />
                        </a>
                    
                        
					<?php }
					else
					{?>
						<form name="step1_1" id="step1_1" method="post">
                            
                            <div class="clearfix" style="height:10px;"></div>
                            <h2>Vehicle Information</h2>
                            <div class="clearfix" style="height:10px;"></div>
                            
                            <div class="row1">
                                    <lable>Insurance type</lable>
                                    <select name="policy_type_id" id="policy_type_id_1" class="dropdown">
                                        <option value="">Insurance type</option>
                                        <?php
                                        $policy_types_sql = "select a.* from ".POLICYTYPES." as a inner join ".PRODUCTS." as b on a.policy_id=b.id where a.status='1' order by a.policy_type asc";
                                        $policy_types = mysql_query($policy_types_sql);
                                        while($policy_type = mysql_fetch_array($policy_types))
                                        {?>
                                            <option value="<?php echo $policy_type['id'];?>"><?php echo $policy_type['policy_type'];?></option>
                                        <?php }  ?>
                                </select>
            
                                </div>
                                
                            <div class="row1">
                                    <lable>Vehicle Make</lable>
                                    <select id="vehicle_make_1" name="vehicle_make" class="dropdown" onchange="getVehicleModel(this.value,1);">
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
                                
                            <div class="row1">
                                <lable>Vehicle Model</lable>
                                <span id="vmodel_section_1">
                                <select id="vehicle_model_1" name="vehicle_model" class="dropdown" onchange="getVehicleType(this.value,1);">
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
                            
                            <div class="row1">
                                <lable>Vehicle Type</lable>
                                <span id="vtype_section_1">
                                <select id="vehicle_type_1" name="vehicle_type" class="dropdown">
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
                            
                            <div class="row1">
                                <lable>Vehicle Regd. Place</lable>
                                <input type="text" autocomplete="off" name="vehicle_regd_place" id="vehicle_regd_place_1" value="<?php echo $vehicle_regd_place;?>">
                            </div>
                            
                            <div class="row1">
                                <lable>Vehicle Ownership</lable>
                                <select id="vehicle_ownership_1" name="vehicle_ownership" class="dropdown">
                                    <option value="">Select</option>
                                    <option value="Financed" <?php if($vehicle_ownership == 'Financed'){echo 'selected="selected"';}?>>Financed</option>
                                    <option value="Owned" <?php if($vehicle_ownership == 'Owned'){echo 'selected="selected"';}?>>Owned</option>
                                    <option value="Leased" <?php if($vehicle_ownership == 'Leased'){echo 'selected="selected"';}?>>Leased</option>
                                </select>
                            </div>
                            
                            <div class="row1">
                                <lable>Vehicle Use</lable>
                                <?php /*?><input type="text" autocomplete="off" name="vehicle_use" id="vehicle_use" value="<?php echo $vehicle_use;?>"><?php */?>
                                <select id="vehicle_use_1" name="vehicle_use" class="dropdown">
                                    <option value="">Select</option>
                                    <option value="Private" <?php if($vehicle_use == 'Private'){echo 'selected="selected"';}?>>Private</option>
                                    <option value="Business" <?php if($vehicle_use == 'Business'){echo 'selected="selected"';}?>>Business</option>
                                    <option value="Occasional" <?php if($vehicle_use == 'Occasional'){echo 'selected="selected"';}?>>Occasional</option>
                                </select>
                            </div>
                            
                            <div class="row1">
                                <lable>Agency Repair </lable>
                                <div class="radoipan" style="float:left !important;">
                                    <input type="radio" id="vehicle_agency_repair_1" class="radio" name="vehicle_agency_repair" value="Yes" style=" width: 13%;" <?php if($vehicle_agency_repair=='Yes'){echo 'checked="checked"';}?> />
                                    <span>Yes</span>
                                    
                                    <input type="radio" id="vehicle_agency_repair2_1" class="radio" name="vehicle_agency_repair" value="No" style=" width: 13%;" <?php if($vehicle_agency_repair=='No'){echo 'checked="checked"';}?> />
                                    <span>No</span>
                                </div>
                            </div>
                            <div class="clearfix" style="height:5px;"></div>
                            <div class="row1">
                                <lable>No Claim Discount (NCD)</lable>
                                <select id="vehicle_ncd_1" name="vehicle_ncd" class="dropdown" style="margin-top:7px;">
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
                        
                            <div class="row1">
                                <lable>Purchase year</lable>
                                <!--<input type="text" autocomplete="off" name="vehicle_purchase_year" id="vehicle_purchase_year"  onkeypress="return isNumberKey(event)" />-->
                                <select id="vehicle_purchase_year_1" name="vehicle_purchase_year" class="dropdown" style="margin-top:7px;">
                                    <?php  $starting_year  =date('Y', strtotime('-20 year'));
                                    $ending_year = date('Y'); 
                                    
                                    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                        if($starting_year == date('Y')) {
                                            echo '<option value="'.$starting_year.'" selected="selected">'.$starting_year.'</option>';
                                        } else {
                                            echo '<option value="'.$starting_year.'">'.$starting_year.'</option>';
                                        }
                                    }  ?>
                                </select>
                            </div>
                        
                            <div class="row1">
                                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Driver's Information!</strong></lable>
                            </div>
                            
                            <div class="row1">
                                <lable>First Name  *</lable>
                                <input type="text" autocomplete="off" name="first_name" id="first_name_1" value="<?php echo $first_name;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Last name </lable>
                                <input type="text" autocomplete="off" name="last_name" id="last_name_1" value="<?php echo $last_name;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Email   *</lable>
                                <input type="text" autocomplete="off" name="email" id="email_1" value="<?php echo $email;?>" />
                            </div>
                            
                            <div class="row1">
                                <lable>Mobile no   *</lable>
                                <input type="text" autocomplete="off" name="mobile_no" id="mobile_no_1"  onkeypress="return isNumberKey(event)" value="<?php echo $mobile_no;?>" />
                            </div>
                            
                            
                            <div class="row1">
                                <lable>Date of Birth *</lable>
                                <input type="text" autocomplete="off" class="date_picker" name="dob" id="dob_1" value="<?php echo $dob;?>">
                            </div>
                            
                            
                            <div class="row1">
                                <lable>Country  *</lable>
                                <select id="country_1" name="country" class="dropdown">
                                    <option value="">-Select-</option>
                                    <option value="AGRA" <?php if($country=='AGRA'){echo 'selected="selected"';}?>>AGRA</option>
                                </select>
                            </div>
                            
                            <div style="font-size: 11px;clear: both; font-family:Arial, Helvetica, sans-serif; position:relative; top:8px;">
                              * Required Fields
                              <br /><br />
                            </div>
                            <input type="submit" class="submit_button" name="submit" value="submit" style="width: 100px;float: right;" onclick="return validCompForm(1);" />
                            <input type="reset" class="submit_button" value="Clear" style="width: 100px;float: right;margin-right: 10px;" />
                            <div class="clearfix" style="height:10px;"></div>
                            
                        </form>
					<?php }?>
                </div>
            <?php }
			if($step == 2)
			{?>
                <div id="step-2">
                
                </div>
            <?php }
			if($step == 3)
			{?>
                <div id="step-3">
                
                </div>
            <?php }
			if($step == 4)
			{?>
                <div id="step-4">
                
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
