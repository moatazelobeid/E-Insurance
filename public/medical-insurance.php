
<?php 
include('PHPMailer/PHPMailerAutoload.php');

include('paypal/paypalfunctions.php');

//include_once("util/pdf.php");

// call class instance
$db = new dbFactory();

function getRelationship($id)
{
	$res = mysql_fetch_array(mysql_query("select relationship from ".RELATIONSHIPS." where id=".$id));
	return stripslashes($res['relationship']);
}
function getNationalityName($id)
{
	$res = mysql_fetch_array(mysql_query("select nationality from ".NATIONALITY." where id=".$id));
	return stripslashes($res['nationality']);
}
function getNetorkClassName($id)
{
	$res = mysql_fetch_array(mysql_query("select nw_class from ".NETWORKCLASS." where id=".$id));
	return stripslashes($res['nw_class']);
}
function getCoverTitle($id)
{
	$res = mysql_fetch_array(mysql_query("select cover_title from ".PRODUCTCOVERS." where id=".$id));
	return stripslashes($res['cover_title']);
}
function getCoverAmount($id,$package_no)
{
	$res = mysql_fetch_array(mysql_query("select cover_amt from ".PACKAGECOVER." where cover_id=".$id." and package_no = '".$package_no."'"));
	return number_format($res['cover_amt'],2);
}


$step = $_GET['step']; 
if(empty($step))
	$step = 1;


//Set quote details to vehicle_details
if(!empty($_SESSION['medical']['Quote']))
{
	$_SESSION['medical']['Step1'] = $_SESSION['medical']['Quote'];
	unset($_SESSION['medical']['Quote']);	
	unset($_SESSION['medical']['Step1']['created_date']);	
}

//step-1 submit
if(isset($_POST['submit_step1']))
{
	unset($_POST['submit_step1']);
	$_SESSION['medical']['Step1'] = $_POST;	
	
	$_SESSION['medical']['is_step_2'] = 1;
	
	if(!empty($_SESSION['medical']['Step1']))
	{
		header('Location: '.BASE_URL.'index.php?page=medical-insurance&step=2');	
	}
}

//step-2 submit
if(isset($_POST['submit_step2']))
{
	unset($_POST['submit_step2']);
	
	unset($_POST['medical']['Step2']);
	
	$pkg_no = $_POST['package_no'];	
	
	$_SESSION['medical']['Total_Package_Amount'] = $_POST['package_amt_'.$pkg_no];	
	
	$_SESSION['medical']['Step2']['Package_Amount'] = $_POST['individual_package_amt_'.$pkg_no];
	
	$_SESSION['medical']['Step2']['Additional_Package_Amount'] = $_SESSION['medical']['Total_Package_Amount']-$_SESSION['medical']['Step2']['Package_Amount'];
		
	$_SESSION['medical']['Step2']['package_no'] = $pkg_no;
	$_SESSION['medical']['Step2']['pkg_covers'] = $_POST['pkg_covers_'.$pkg_no];	
	
	//$_SESSION['medical']['Step2'] = $_POST;
	
	unset($_POST);
	
	$_SESSION['medical']['is_step_3'] = 1;
	
	if(!empty($_SESSION['medical']['Step2']))
	{
		header('Location: '.BASE_URL.'index.php?page=medical-insurance&step=3');	
	}
}

//step-3 submit
if(isset($_POST['submit_step3']))
{
	unset($_POST['submit_step3']);
	
	//set insurance period date
	$_SESSION['medical']['Policy']['insured_period_startdate'] = $_POST['insured_period_startdate'];	
		unset($_POST['insured_period_startdate']);	
	
	$_SESSION['medical']['Policy']['insured_period_enddate'] = $_POST['insured_period_enddate'];	
		unset($_POST['insured_period_enddate']);	

	$total_atch = count($_POST['atch_title']); 
	//upload_attachments
	$upload_path = 'upload/medical-attchment/';
	
	for($i = 0; $i<$total_atch; $i++)
	{
		if($_FILES['atch_file']['name'][$i]!='')
		{
			$atch_name = time().'_'.rand(1,99999).".".end(explode(".",$_FILES['atch_file']['name'][$i]));
			if(move_uploaded_file($_FILES['atch_file']['tmp_name'][$i],$upload_path.$atch_name))
			{
				$no = count($_SESSION['medical']['Attachment']);
				
				$_SESSION['medical']['Attachment'][$no]['atch_title'] = $_POST['atch_title'][$i];
				unset($_POST['atch_title'][$i]);
				
				$_SESSION['medical']['Attachment'][$no]['atch_file'] = $atch_name;
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
	
	$_SESSION['medical']['Step3'] = $_POST;	
	
	$_SESSION['medical']['is_step_4'] = 1;
	
	if(!empty($_SESSION['medical']['Step3']))
	{
		header('Location: '.BASE_URL.'index.php?page=medical-insurance&step=4');	
	}
}

//step-3 submit
if(isset($_POST['submit_step4']))
{
	unset($_POST['submit_step4']);
	$_SESSION['medical']['is_step_5'] = 1;
	$_SESSION['medical']['Step4'] = $_POST;
	header('Location: '.BASE_URL.'index.php?page=medical-insurance&step=5');	
}

if($step == 1)
{
	$name = 	$_SESSION['medical']['Step1']['name'];
	$occupation = 	$_SESSION['medical']['Step1']['occupation'];
	$iqma_no = 	$_SESSION['medical']['Step1']['iqma_no'];
	$nationality = $_SESSION['medical']['Step1']['nationality'];
	
	if(!empty($_SESSION['medical']['Step1']['dob']))
	{
		$dob = 	date('d-m-Y',strtotime($_SESSION['medical']['Step1']['dob']));
	}
	
	$gender = 	$_SESSION['medical']['Step1']['gender'];
	$network_class = 	$_SESSION['medical']['Step1']['network_class'];
	$chronoc_diseases = 	$_SESSION['medical']['Step1']['chronoc_diseases'];
	
	$total_insured_person = $_SESSION['medical']['Step1']['total_insured_person'];
}

if($step == 2)
{
	$package_no = $_SESSION['medical']['Step2']['package_no'];
	$addtnal_pkg_covers = $_SESSION['medical']['Step2']['pkg_covers'];
	$package_amount = $_SESSION['medical']['Total_Package_Amount'];
}

if($step == 3)
{
	$name = 	$_SESSION['medical']['Step1']['name'];
	$iqma_no = 	$_SESSION['medical']['Step1']['iqma_no'];
	if(!empty($_SESSION['medical']['Step1']['dob']))
	{
		$dob = 	date('d-m-Y',strtotime($_SESSION['medical']['Step1']['dob']));
	}
	$gender = 	$_SESSION['medical']['Step1']['gender'];
	
	if(!empty($_SESSION['medical']['Step3']))
	{
		
		$title = 	$_SESSION['medical']['Step3']['title'];
		$name = 	$_SESSION['medical']['Step3']['name'];
		$marital_status = $_SESSION['medical']['Step3']['marital_status'];
		$email = 	$_SESSION['medical']['Step3']['email'];
		$phone_mobile = 	$_SESSION['medical']['Step3']['phone_mobile'];
		$country = 	$_SESSION['medical']['Step3']['country'];
		$state = 	$_SESSION['medical']['Step3']['state'];
		$iqma_no = 	$_SESSION['medical']['Step3']['iqma_no'];
		$drive_license_no = 	$_SESSION['medical']['Step3']['drive_license_no'];
		
		if(!empty($_SESSION['medical']['Step3']['dob']))
		{
			$dob = 	date('d-m-Y',strtotime($_SESSION['medical']['Step3']['dob']));
		}
		$gender = 	$_SESSION['medical']['Step3']['gender'];
	}
	
	$attachments = $_SESSION['medical']['Attachment'];
	
	//Policy info
	$insured_period_startdate = $_SESSION['medical']['Policy']['insured_period_startdate'];
	$insured_period_enddate = $_SESSION['medical']['Policy']['insured_period_enddate'];
}
function getPackageDetails($package_no)
{
	$res = mysql_fetch_object(mysql_query("select * from ".MEDICAL_PACKAGE." where package_no='".$package_no."'"));
	return $res;
}

if($step == 4)
{
	if(!empty($_SESSION['medical']['Total_Package_Amount']))
	{
		$package_amount = number_format($_SESSION['medical']['Total_Package_Amount'],2);
	}
	
	$package_no = $_SESSION['medical']['Step2']['package_no'];
	
	//get select package details
	if(!empty($_SESSION['medical']['Step2']['package_no']))
	{
		$pkg = getPackageDetails($_SESSION['medical']['Step2']['package_no']); 
		$pkg_title = stripslashes($pkg->package_title);
		$pkg_desc = stripslashes($pkg->package_desc);
		$pkg_price = number_format($pkg->package_amt,2);
	}

	$accept_terms = $_SESSION['medical']['Step4']['accept_terms'];
	
	$title = $_SESSION['medical']['Step3']['title'];
	$name = $_SESSION['medical']['Step3']['name'];
	$marital_status = $_SESSION['medical']['Step3']['marital_status'];
	$gender = $_SESSION['medical']['Step3']['gender'];
	$email = $_SESSION['medical']['Step3']['email'] ;
	$phone_mobile = $_SESSION['medical']['Step3']['phone_mobile'] ;
	
	$dob = $_SESSION['medical']['Step3']['dob'];
	
	$country = $_SESSION['medical']['Step3']['country'];
	$state = $_SESSION['medical']['Step3']['state'];
	$iqma_no = $_SESSION['medical']['Step3']['iqma_no'];
	$drive_license_no = $_SESSION['medical']['Step3']['drive_license_no'];
	
	$attachments = $_SESSION['medical']['Attachment'];
	//Policy info
	$insured_period_startdate = $_SESSION['medical']['Policy']['insured_period_startdate'];
	$insured_period_enddate = $_SESSION['medical']['Policy']['insured_period_enddate'];
	
	$additional_pkg_covers = $_SESSION['medical']['Step2']['pkg_covers'];
	
	$occupation = 	$_SESSION['medical']['Step1']['occupation'];
	$iqma_no = 	$_SESSION['medical']['Step1']['iqma_no'];
	$nationality = $_SESSION['medical']['Step1']['nationality'];
	
	$nationality_name = getNationalityName($nationality);
	
	$network_class = 	$_SESSION['medical']['Step1']['network_class'];
	
	$network_class_name = getNetorkClassName($network_class);
	
	$chronoc_diseases = 	$_SESSION['medical']['Step1']['chronoc_diseases'];
	
	$total_insured_person = $_SESSION['medical']['Step1']['total_insured_person'];
	
}

if($step == 5)
{
	//Paypal payment
	if(isset($_POST['pay_now']))
	{
		
		include_once("util/medical-pdf.php");
		
		$total_payment_amount = $_POST['total_payment_amount'];
		
		// PayPal Settings
		//$email 	= 'moataz.elobeid@gmail.com';
		$email 	= 'idbehera11@gmail.com';
		$return 	= BASE_URL.'index.php?page=paymentsuccess';
		$cancel 	= BASE_URL.'index.php?page=payment-cancelled';
		//$notify 	= BASE_URL.'paypal_ipn.php';
		
		$name = "Medical Insurance Policy";
		
		$custom=json_encode($_SESSION['motor']);
		
		// Firstly Append paypal account to querystring
		$querystring .= "?business=".urlencode($email)."&";	
	
		//Appending the subscription type for payment
		$querystring .= "cmd=".urlencode("_xclick")."&";
		
		//Append amount& currency & subsequent details to quersytring so it cannot be edited in html
		$querystring .= "currency_code=".urlencode("USD")."&";
		$querystring .= "no_note=".urlencode("1")."&";
		$querystring .= "no_shipping=".urlencode("1")."&";
			
		//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
		$querystring .= "item_name=".urlencode($name)."&";
		$querystring .= "amount=".urlencode(round($total_payment_amount))."&";
		
		$querystring .= "custom=''&";
		
        // Append paypal return addresses
		$querystring .= "rm=".urlencode("2")."&";
		$querystring .= "return=".urlencode(stripslashes($return))."&";
		$querystring .= "cancel_return=".urlencode(stripslashes($cancel))."&";
		$querystring .= "notify_url=".urlencode($return.'&notify=1');
		
		//Redirect to paypal IPN
		header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
		//header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
		exit();
		
	}
	
	//check step-5 access
	if($_SESSION['medical']['is_step_5'] != '1')
	{
		header('Location: '.BASE_URL.'index.php?page=medical-insurance&step=1');		
	}
	
	//get select package details
	if(!empty($_SESSION['medical']['Step2']['package_no']))
	{
		$package_no = $_SESSION['medical']['Step2']['package_no'];
		$pkg = getPackageDetails($_SESSION['medical']['Step2']['package_no']); 
		$pkg_title = stripslashes($pkg->package_title);
		$pkg_desc = stripslashes($pkg->package_desc);
		$pkg_price = number_format($pkg->package_amt,2);
	}
	
	//Policy info
	$insured_period_startdate = $_SESSION['medical']['Policy']['insured_period_startdate'];
	$insured_period_enddate = $_SESSION['medical']['Policy']['insured_period_enddate'];
	
	$additional_pkg_covers = $_SESSION['medical']['Step2']['pkg_covers'];
	
	if(!empty($_SESSION['medical']['Total_Package_Amount']))
	{
		$package_amount = $_SESSION['medical']['Total_Package_Amount'];	
	}
}


//echo '<pre>'; print_r($_SESSION); echo '</pre>';
//session_destroy();


?>
<style>
.child_row
{
	border:1px solid gray;
	padding:10px;
	height: 240px;
}
table.insured_person_table, table.insured_person_table tr
{
	border:1px solid gray;
}
table.insured_person_table  th {
background: url(images/person-th-bg.gif) repeat-x left bottom;
border-bottom: 1px solid #e0e0e0;
border-left: 1px solid #e0e0e0;
font-size: 11px;
font-weight: 400;
text-align: left;
vertical-align: top;
margin: 0;
padding: 3px 5px 12px 8px;
}
table.insured_person_table td {
font-size: 11px;
font-weight: 400;
border-left: 1px solid #e0e0e0;
vertical-align: top;
margin: 0;
padding:2px 5px;
}

form table.insured_person_table td  input[type="text"], form table.insured_person_table td  select {
background: #FFF;
border: 1px solid #DADADA;
color: #999;
float: left;
font-size: 11px;
padding: 2px;
width: 60px;
width: 50px!important;
margin-left: 1px;
float: left !important;
}
form table.insured_person_table td  input[type="text"]
{
	height:20px !important;
}
form table.insured_person_table td  select 
{
	height:25px !important;
	margin-top: 5px;
}
form table.insured_person_table td:last-child  input[type="text"]
{
	width:37px!important;
}
form table.insured_person_table td:last-child a
{
	font-family: sans-serif;
font-weight: normal;
color: #FFFFFF;
font-size: 7px;
background: green;
padding: 3px 4px;
border-radius: 20px;
position: absolute;
text-decoration: none;
margin-left: 3px;
margin-top: 12px;
}
</style>

<script type="text/javascript">

function updatePkgPrice(pkg_no, pkg_amt, cover_id)
{
	
	var current_pkg_amt = 	$( "#package_amt_"+pkg_no ).val();

	if($('#adtn_cover_'+pkg_no+'_'+cover_id).attr('checked') == true)
	{
		var new_pkg_amt = parseFloat(current_pkg_amt)+parseFloat(pkg_amt);
	}
	else
	{
		var new_pkg_amt = parseFloat(current_pkg_amt)-parseFloat(pkg_amt);
	}
	
	new_pkg_amt = parseFloat(Math.round(new_pkg_amt * 100) / 100).toFixed(2);
	
	//alert(new_pkg_amt);
	
	$('#package_amt_div_'+pkg_no).html(new_pkg_amt);
	$('#package_amt_'+pkg_no).val(new_pkg_amt);
}


var relationship_options = '';

<?php
$rel_list = mysql_query("select * from ".RELATIONSHIPS." where status='1' order by relationship asc");
if(mysql_num_rows($rel_list) > 0) 
{
	while($rel_detail = mysql_fetch_array($rel_list))
	{
		?>
		relationship_options=relationship_options+'<option value="<?php echo $rel_detail['id'];?>"><?php echo stripslashes($rel_detail['relationship']);?></option>';
		<?php 
	}
}?>

//var maxdobyr = '<?php //echo date('Y')-18;?>';
var d = new Date();
var maxdobyr = d.getFullYear() - 18;
d.setFullYear(maxdobyr);

$(function() {
	$( "#insured_period_startdate" ).datepicker({
		
		dateFormat: 'dd-mm-yy' , 
		changeYear: 'false' , 
		yearRange: '<?php echo date('Y');?>:<?php echo date('Y');?>' , 
		changeMonth: 'true' ,
		minDate:0
		} );
	
	$( ".dob_calender" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:'+maxdobyr , changeMonth: 'true',
defaultDate: d } );

});


function showCoverageDetail(id)
{
	$("#cvg_detail_"+id).slideToggle(400);
}


</script>
<script type="text/javascript" src="js/medical-insurance.js"></script>

<div class="innrebodypanel">
        <div class="clearfix" style="height:15px;">.</div>
        <div class="innerwrap">
        
            <div class="auto__ins_head">
                <div class="dataseedin">
                  <div style="float:left; width:222px; height:auto; margin-right:10px;">
                    <h1>Medical Insurance</h1>
                    <div class="clearfix" style="height:7px;"></div>
                    <strong>Medical Insurance</strong>
                  </div>
                  
                  
                  <div class="step_area">
                    <div class="step_area_line"></div>
                    
                    <div class="step1 <?php if($step == 1){echo 'active';}?>" onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=medical-insurance&step=1'">
                      <div style="margin-top:5px;">Find Quote</div>
                    </div>
                    
                    <div class="step2 <?php if($step == 2){echo 'active';}?>" 
                    <?php if(!empty($_SESSION['medical']['is_step_2'])){?>onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=medical-insurance&step=2'"<?php }?>>
                      <div style="margin-top:5px;">Quotation</div>
                    </div>
                    
                    <div class="step3 <?php if($step == 3){echo 'active';}?>" 
                    <?php if(!empty($_SESSION['medical']['is_step_3'])){?>onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=medical-insurance&step=3'"<?php }?>>
                      <div style="margin-top:5px;">Your Details</div>
                    </div>
                    
                    <div class="step4 <?php if($step == 4){echo 'active';}?>" 
                    <?php if(!empty($_SESSION['medical']['is_step_4'])){?>onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=medical-insurance&step=4'"<?php }?>>
                      <div style="margin-top:5px;">Summary</div>
                    </div>
                    
                    <div class="step5 <?php if($step == 5){echo 'active';}?>" 
                    <?php if(!empty($_SESSION['medical']['is_step_5'])){?>onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=medical-insurance&step=5'"<?php }?>>
                      <div style="margin-top:5px;">Payment</div>
                    </div>
                    
                  </div>
                  
                </div>
            </div>
            <div class="clearfix" style="height:10px;"></div>
            
            <div class="leftbokpan">
                 <div id="formpan" class="formpan2 formpan5" style="float: left;">
                 	<?php if($step == 1)
					{?>
                    	<form name="step1_form" id="step1_form" method="post">
                        <input type="hidden" name="policy_class_id" value="1" />
                            <h1 style="background: green; color:#fff; text-align:center;font-weight: bold;">
                                Health Information
                            </h1>
                			<div class="padding15" style="padding-top:10px;">
        
                                <div class="row1">
                                    <lable>Name</lable>
                                    <input type="text" autocomplete="off" name="name" id="name" value="<?php echo $name;?>">
                                </div>
                                    
                                <div class="row1">
                                    <lable>Date Of Birth</lable>
                                    <input type="text" autocomplete="off" name="dob" readonly="readonly" class="dob_calender" id="dob1" value="<?php echo $dob;?>" />
                                </div>
                                    
                                <div class="row1">
                                    <lable>Occupation</lable>
                                    <input type="text" autocomplete="off" name="occupation" id="occupation" value="<?php echo $occupation;?>">
                                </div>
                                    
                                <div class="row1">
                                    <lable>ID/IQMA No.</lable>
                                    <input type="text" autocomplete="off" name="iqma_no" id="iqma_no" value="<?php echo $iqma_no;?>">
                                </div>
                                    
                                <div class="row1">
                                    <lable>Nationality</lable>
                                    <select name="nationality" id="nationality" class="dropdown">
                                        <option value="">Nationality</option>
                                        <?php
										$nlist = mysql_query("select * from ".NATIONALITY." where status='1' order by nationality asc");
										if(mysql_num_rows($nlist) > 0) 
										{
											while($nation = mysql_fetch_array($nlist))
											{
												?>
                                                <option value="<?php echo $nation['id'];?>" <?php if($nationality == $nation['id'])echo 'selected';?>>
													<?php echo stripslashes($nation['nationality']);?>
                                                </option>
                                                <?php 
											}
										}?>
                                    </select>
                                </div>
                                    
                                <div class="row1">
                                    <lable>Gender</lable>
                                    <select name="gender" id="gender" class="dropdown">
                                        <option value="">Gender</option>
                                        <option value="2" <?php if($gender == 2)echo 'selected';?>>Male</option>
                                        <option value="1" <?php if($gender == 1)echo 'selected';?>>Female</option>
                                    </select>
                                </div>
                                    
                                <div class="row1">
                                    <lable>Network class</lable>
                                    <select name="network_class" id="network_class" class="dropdown" onchange="showVehicleColumn(this.value);">
                                        <option value="">Network Class</option>
                                        <option value="1" <?php if($network_class == 1)echo 'selected';?>>VIP</option>
                                        <option value="2" <?php if($network_class == 2)echo 'selected';?>>Class A</option>
                                        <option value="3" <?php if($network_class == 3)echo 'selected';?>>Class B</option>
                                        <option value="4" <?php if($network_class == 4)echo 'selected';?>>Class C</option>
                                    </select>
                                </div>
                                    
                                <div class="row1">
                                    <lable>Pre- Existing / Chronoc Diseases</lable>
                                    <input type="text" autocomplete="off" name="chronoc_diseases" class="" id="chronoc_diseases" value="<?php  echo $chronoc_diseases;?>">
                                </div>
                                
                                <div class="row1">
                                    <lable><strong>Insured persons</strong></lable>
                                    <!--<input type="checkbox" name="add_wife" class="" id="add_wife" value="1" onclick="addWife();">-->
                                </div>
                                
                                <div class="clearfix" style="height:10px;"></div>
                                <input type="hidden" name="total_insured_person" id="total_insured_person" value="<?php  if(isset($total_insured_person)) echo $total_insured_person; else echo 1;?>" />
                                <table style="font-size:11px;" class="insured_person_table" cellspacing="2" cellpadding="2">
                                	<thead>
                                        <tr>
                                            <th width="12%">Name</th>
                                            <th width="12%">Gender</th>
                                            <th width="12%">Relationship</th>
                                            <th width="12%">DOB</th>
                                            <th width="12%">Occupation</th>
                                            <th width="20%">ID/Iqama No</th>
                                            <th width="20%">Pre- Existing / Chronoc Diseases</th>
                                        </tr>
                                    </thead>
                                    <tbody id="inp_data">
										  <?php
                                          if(isset($total_insured_person))
										  {
											  for($i=1; $i <= $total_insured_person; $i++)
											  {
												  $inp_name = $_SESSION['medical']['Step1']['inp_name'][$i-1];
												  $inp_gender = $_SESSION['medical']['Step1']['inp_gender'][$i-1];
												  $inp_rel = $_SESSION['medical']['Step1']['inp_rel'][$i-1];
												  $inp_dob = $_SESSION['medical']['Step1']['inp_dob'][$i-1];
												  $inp_occup = $_SESSION['medical']['Step1']['inp_occup'][$i-1];
												  $inp_iqma = $_SESSION['medical']['Step1']['inp_iqma'][$i-1];
												  $inp_chron_ds = $_SESSION['medical']['Step1']['inp_chron_ds'][$i-1];
												  ?>
                                              		<?php
                                                    if($i>1)
													{?>
                                                    	<tr id="inp_<?php echo $i;?>"><td colspan="7" style="border-bottom:1px solid #e0e0e0"></td></tr>
                                                    <?php }?>
                                                    <tr id="insured_person_<?php echo $i;?>">
                                                        <td><input type="text" autocomplete="off" name="inp_name[]" id="inp_name_<?php echo $i;?>" value="<?php echo $inp_name;?>"></td>
                                                        <td>
                                                            <select name="inp_gender[]" id="inp_gender_<?php echo $i;?>">
                                                                <option value="">Gender</option>
                                                                <option value="2" <?php if($inp_gender == 2)echo 'selected';?>>Male</option>
                                                                <option value="1" <?php if($inp_gender == 1)echo 'selected';?>>Female</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="inp_rel[]" id="inp_rel_<?php echo $i;?>">
                                                            <?php
                                                            $rel_list = mysql_query("select * from ".RELATIONSHIPS." where status='1' order by relationship asc");
                                                            if(mysql_num_rows($rel_list) > 0) 
                                                            {
                                                                while($rel_detail = mysql_fetch_array($rel_list))
                                                                {
                                                                    ?>
                                                                   <option value="<?php echo $rel_detail['id'];?>"  <?php if($inp_rel == $rel_detail['id'])echo 'selected';?>><?php echo stripslashes($rel_detail['relationship']);?></option>
                                                                    <?php 
                                                                }
                                                            }?>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" autocomplete="off" name="inp_dob[]" class="dob_calender" id="inp_dob_<?php echo $i;?>" value="<?php echo $inp_dob;?>"></td>
                                                        <td><input type="text" autocomplete="off" name="inp_occup[]" id="inp_occup_<?php echo $i;?>" value="<?php echo $inp_occup;?>"></td>
                                                        <td><input type="text" autocomplete="off" name="inp_iqma[]" id="inp_iqma_<?php echo $i;?>" value="<?php echo $inp_iqma;?>"></td>
                                                        <td>
                                                            <input type="text" autocomplete="off" name="inp_chron_ds[]" class="" id="inp_chron_ds_<?php echo $i;?>" value="<?php echo $inp_chron_ds;?>">
                                                            <a href="javaScript:void(0);" id="inpclose_<?php echo $i;?>" onclick="removeInsuredPerson(<?php echo $i;?>)">X</a>
                                                        </td>
                                                    </tr>
                                              <?php 
											  }
										  }
										  else
										  {
												?>
                                                <tr id="insured_person_1">
                                            <td><input type="text" autocomplete="off" name="inp_name[]" id="inp_name_1" value="<?php //echo $dob;?>"></td>
                                            <td>
                                            	<select name="inp_gender[]" id="inp_gender_1">
                                                	<option value="">Gender</option>
                                                    <option value="2">Male</option>
                                                	<option value="1">Female</option>
                                                </select>
                                            </td>
                                            <td>
												<select name="inp_rel[]" id="inp_rel_1">
												<?php
                                                $rel_list = mysql_query("select * from ".RELATIONSHIPS." where status='1' order by relationship asc");
                                                if(mysql_num_rows($rel_list) > 0) 
                                                {
                                                    while($rel_detail = mysql_fetch_array($rel_list))
                                                    {
                                                        ?>
                                                       <option value="<?php echo $rel_detail['id'];?>"><?php echo stripslashes($rel_detail['relationship']);?></option>
                                                        <?php 
                                                    }
                                                }?>
                                            	</select>
                                            </td>
                                            <td><input type="text" autocomplete="off" name="inp_dob[]" class="dob_calender" id="inp_dob_1" value="<?php //echo $dob;?>"></td>
                                            <td><input type="text" autocomplete="off" name="inp_occup[]" id="inp_occup_1" value="<?php //echo $dob;?>"></td>
                                            <td><input type="text" autocomplete="off" name="inp_iqma[]" id="inp_iqma_1" value="<?php //echo $dob;?>"></td>
                                            <td>
                                                <input type="text" autocomplete="off" name="inp_chron_ds[]" class="" id="inp_chron_ds_1" value="<?php //echo $dob;?>">
                                                <a href="javaScript:void(0);" id="inpclose_1" onclick="removeInsuredPerson(1)">X</a>
                                            </td>
                                        </tr>
                                                <?php   
										  }
                                          ?>
                                        
                                        <tr id="inp_1"><td colspan="7" style="border-bottom:1px solid #e0e0e0"></td></tr>
                                    </tbody>
                                </table>
                                <div class="clearfix" style="height:10px;"></div>
                                
                                <div>
                                    <input type="button" class="submit_button" value="Add New" onclick="addInsuredPerson();" style="width: 15%; float:right" />
                                </div>
                                <div class="clearfix" style="height:10px;"></div>

                                <div style="font-size: 11px;clear: both; font-family:Arial, Helvetica, sans-serif; position:relative; top:8px; color:red;">
                                  * Required Fields
                                  <br><br>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                <div style="text-align:center">
                                    <input type="submit" class="submit_button" name="submit_step1" value="Get a quote" onclick="return validStep1Form(<?php echo $m;?>);" />
                                </div>
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
							$pckg_sql_qry = mysql_query("select * from ".MEDICAL_PACKAGE." where status='1'");
							$total_pkg = mysql_num_rows($pckg_sql_qry);
						
							if($total_pkg > 0)
							{
								$ii = 0;
								while($pkg = mysql_fetch_array($pckg_sql_qry))
								{
									$ii++;
									//echo '<pre>'; print_r($pkg); echo '</pre>';
									if(!empty($package_amount) && ($package_no == $pkg['package_no']))
										$package_amount = $package_amount;
									else
										$package_amount = $pkg['package_amt'];
									?>
									<div class="packageslist">
										<div class="search_box_two">
										  <div class="listTL">
											   <table cellpadding="0" cellspacing="0">
													<tbody>
														<tr>
															<td width="30" valign="top">
																<input type="radio" name="package_no" value="<?php echo $pkg['package_no'];?>" <?php if($package_no == $pkg['package_no']){echo 'checked="checked"';}?> style="float: left;" />
																<input type="hidden" name="package_amt_<?php echo $pkg['package_no'];?>" id="package_amt_<?php echo $pkg['package_no'];?>" value="<?php echo str_replace(',','',$package_amount);?>" />
																<input type="hidden" name="individual_package_amt_<?php echo $pkg['package_no'];?>" id="individual_package_amt_<?php echo $pkg['package_no'];?>" value="<?php echo str_replace(',','',$pkg['package_amt']);?>" />
															</td>
															<td width="200" valign="top">
																<strong><?php echo stripslashes($pkg['package_title']);?></strong>
																<div class="clearfix" style="height:10px;"></div>
																<p>
																	<?php echo stripslashes($pkg['package_desc']);?>
																</p>
															</td>
															<td valign="middle" width="100" class="priceTL">
																<span style="font-size:27px; font-style: normal;" id="package_amt_div_<?php echo $pkg['package_no'];?>"><?php echo $package_amount;?></span><span> SR</span>
															</td>
														</tr>
												   </tbody>
											   </table>
										 </div>
										</div>
										<?php 
										$pkg_covers = mysql_query("select * from ".PACKAGECOVER." where package_no='".$pkg['package_no']."'");
										//$pkg_covers = $db->recordArray($pkg['package_no'],PACKAGECOVER.':package_no');
										if(mysql_num_rows($pkg_covers) > 0)
										{?>
											<a href="javascript:void(0);" class="covgr" onclick="showCoverageDetail('<?php echo $pkg['id'];?>');" style="margin-top: 10px;">Additional Coverage</a>
											 <div class="clearfix" style="height:5px;"></div>
											<!--Coverage list-->
											<div id="cvg_detail_<?php echo $pkg['id'];?>" class="covg_details" style="display:none;">
												<h2><?php echo stripslashes($pkg['package_title']);?></h2>
												<?php
												if(mysql_num_rows($pkg_covers)>0)
												{
													echo '<ul>';
													while($pkg_cover = mysql_fetch_array($pkg_covers))
													{
														?>
														<li style="list-style:none;">  
														<input type="checkbox" onclick="updatePkgPrice('<?php echo $pkg['package_no'];?>','<?php echo $pkg_cover['cover_amt'];?>','<?php echo $pkg_cover['cover_id'];?>');" 
														name="pkg_covers_<?php echo $pkg['package_no'];?>[]" value="<?php echo $pkg_cover['cover_id'];?>" id="adtn_cover_<?php echo $pkg['package_no'];?>_<?php echo $pkg_cover['cover_id'];?>"
														<?php if(!empty($addtnal_pkg_covers) && in_array($pkg_cover['cover_id'],$addtnal_pkg_covers)) {echo 'checked="checked"';}?> 
														style="top: 3px;position: relative;" />
														<?php echo getCoverTitle($pkg_cover['cover_id']).': <strong>'.$pkg_cover['cover_amt'];?> SR</strong></li>
														<?php 
													}
													echo '</ul>';
												}
												else
												{
													echo 'No coverage found.';	
												}?>
											</div>
									   <?php }?>             
									</div>
									<?php 
								}	
								
								?>
								 <div class="clearfix" style="height:10px;"></div>
								<input type="submit" class="submit_button" name="submit_step2" value="Buy now" style="width: 30%;" onclick="return validStep2Form();" />
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
                            <h1 style="background: green; color:#fff; text-align:center;font-weight: bold;">
                                Your Policy Details
                            </h1>
                            
                            <div class="padding15" style="padding-top: 0px;">
							<div class="row1">
                                <h1 class="newtag1">
                                    Policy Holder's Details
                                </h1>
                            </div>
							
                            <div class="row1">
                                <lable>Name  *</lable>
                                <div class="clearfix" style="height:1px;"></div>
                                <select id="title" name="title" class="dropdown" style="width: 55px; float: left;">
                                    <option value="">Title</option>
                                    <option value="Miss" <?php if($title == 'Miss')echo 'selected';?>>Miss</option>
                                    <option value="Mr." <?php if($title == 'Mr.')echo 'selected';?>>Mr.</option>
                                    <option value="Mrs." <?php if($title == 'Mrs.')echo 'selected';?>>Mrs.</option>
                                </select>
                                
                                <input type="text" autocomplete="off" name="name" id="name" value="<?php echo $name;?>" style="width: 435px;" />
                            </div>
                            
                            <div class="row1">
                                <lable>Date of Birth *</lable>
                                <?php /*?><div class="clearfix" style="height:5px;"></div>
                                <input type="text" autocomplete="off" maxlength="2" placeholder="DD" name="dob_dd" value="<?php echo $dob_dd;?>" id="dob_dd" onkeypress="return isNumberKey(event)" style="width:110px;float: left;margin-right: 10px;">
                                <div style="width: auto;float: left;margin-right: 10px;margin-top: 5px;border-bottom: 1px solid gray;">&nbsp;&nbsp;</div>
                                <input type="text" autocomplete="off" maxlength="2" placeholder="MM" name="dob_mm" value="<?php echo $dob_mm;?>" id="dob_mm" onkeypress="return isNumberKey(event)" style="width:110px;float: left;margin-right: 10px;">
                                <div style="width: auto;float: left;margin-right: 10px;margin-top: 5px;border-bottom: 1px solid gray;">&nbsp;&nbsp;</div>
                                <input type="text" autocomplete="off" maxlength="4" placeholder="YYYY" name="dob_yy" value="<?php echo $dob_yy;?>" id="dob_yy" onkeypress="return isNumberKey(event)" style="width:200px;float: left;"><?php */?>
                           		<input type="text" autocomplete="off" name="dob" id="dob1" value="<?php echo $dob;?>" class="dob_calender" />
                            </div>
                            
                            <div class="row1">
                                <lable>Marital Status </lable>
                                <select name="marital_status" id="marital_status" class="dropdown">
                                    <option value="">-Select-</option>
                                    <option value="Single" <?php if($marital_status == 'Single')echo 'selected';?>>Single</option>
                                    <option value="Married" <?php if($marital_status == 'Married')echo 'selected';?>>Married</option>
                                </select>
                            </div>
                            <div class="clearfix" style="height:5px;"></div>
                            
                            <div class="row1">
                                <lable>Gender </lable>
                                <select name="gender" id="gender" class="dropdown">
                                    <option value="">-Select-</option>
                                    <option value="2" <?php if($gender == 2)echo 'selected';?>>Male</option>
                                    <option value="1" <?php if($gender == 1)echo 'selected';?>>Female</option>
                                </select>
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
                                <input type="text" autocomplete="off" name="phone_mobile" maxlength="12" id="phone_mobile"  onkeypress="return isNumberKey(event)" value="<?php echo $phone_mobile;?>" />
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
                                    <option value="">-Select-</option>
                                    <option value="Saudi Arabia" <?php if($country == 'Saudi Arabia'){echo 'selected="selected"';}?>>Saudi Arabia</option>
                                </select>
                            </div>
                            
                                        
                            <div class="row1">
                                <lable>State</lable>
								<select id="state" name="state" class="dropdown">
                                    <option value="">-Select-</option>
                                    <option value="Asir" <?php if($state == 'Asir'){echo 'selected="selected"';}?>>Asir</option>
									<option value="Al Qasim" <?php if($state == 'Al Qasim'){echo 'selected="selected"';}?>>Al Qasim</option>
									<option value="Al Madinah" <?php if($state == 'Al Madinah'){echo 'selected="selected"';}?>>Al Madinah</option>
									<option value="Al Jawf" <?php if($state == 'Al Jawf'){echo 'selected="selected"';}?>>Al Jawf</option>
									<option value="Al Bahah" <?php if($state == 'Al Bahah'){echo 'selected="selected"';}?>>Al Bahah</option>
									<option value="Al Riyadh" <?php if($state == 'Al Riyadh'){echo 'selected="selected"';}?>>Al Riyadh</option>
									<option value="Eastern Province" <?php if($state == 'Eastern Province'){echo 'selected="selected"';}?>>Eastern Province</option>
									<option value="Hail" <?php if($state == 'Hail'){echo 'selected="selected"';}?>>Hail</option>
									<option value="Jizan" <?php if($state == 'Jizan'){echo 'selected="selected"';}?>>Jizan</option>
									<option value="Makkah" <?php if($state == 'Makkah'){echo 'selected="selected"';}?>>Makkah</option>
									<option value="Najran" <?php if($state == 'Najran'){echo 'selected="selected"';}?>>Najran</option>
									<option value="Northern Borders" <?php if($state == 'Northern Borders'){echo 'selected="selected"';}?>>Northern Borders</option>
									<option value="Tabuk" <?php if($state == 'Tabuk'){echo 'selected="selected"';}?>>Tabuk</option>
                                </select>
                                <?php /*?><input type="text" name="state" id="state" value="<?php echo $state;?>" /><?php */?>
                            </div>
                            
                            <div class="row1">
                                <lable>IQMA No *</lable>
                                <input type="text" name="iqma_no" id="iqma_no" value="<?php echo $iqma_no;?>" readonly="readonly" />
                            </div>
                            
                            <div class="row1">
                                <lable>Driving licence No *</lable>
                                <input type="text" name="drive_license_no" id="drive_license_no" value="<?php echo $drive_license_no;?>" />
                            </div>
                            
                            <div class="clear" style="height:1px;"></div>
                           
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
                                <div id="atch_0"></div>
                                <div id="atch_1">
                                    <div class="listcross">
                                        <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                        <lable>Document Title *</lable>
                                        <input type="text" name="atch_title[]" id="atch_title_1" />
                                    </div>
                                    <div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;height:70px;">
                                        <lable>Attachment *</lable>
                                        <input type="file" name="atch_file[]" id="atch_file_1" />
                                        <span class="cross" onclick="delAttchment('1');">X</span>
                                    </div>
                                    
                                </div>
                                </div>
                            <?php }?>
                            <span class="listcross">
                            <a href="javaScript:void(0);" class="plusadd" onclick="addAttchment();">Add Attachment</a>
                            </span>
                            
                            
                            
									
                            <div class="row1">
                                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Insurace Period Details</strong></lable>
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
                            <input type="submit" class="submit_button" name="submit_step3" id="step3_btn" value="Save &amp; Continue" onclick="return validStep3Form();" />
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
                                                    <td style="width: 70%;" valign="top">
                                                        <strong><?php echo $pkg_title;?></strong>
                                                        <div class="clearfix" style="height:10px;"></div>
                                                        <p>
                                                            <?php echo $pkg_desc;?>
                                                        </p>
                                                    </td>
                                                    <td valign="middle" width="100" class="priceTL">
                                                        <?php echo $package_amount;?> <span>SR</span>
                                                    </td>
                                                </tr>
                                           </tbody>
                                       </table>
                                 </div>
                                </div>
                            <div class="clear" style="height:15px;"></div>
            
                            <div>
                                <h1 class="newtag1">
                                Additional Coverage
                                </h1>
                            	<?php if(!empty($additional_pkg_covers))
								{
									foreach($additional_pkg_covers as $additional_pkg_cover)
									{?>
                                        <div class="row1">
                                            <lable><?php echo getCoverTitle($additional_pkg_cover);?>: </lable>
                                            <span><strong><?php echo getCoverAmount($additional_pkg_cover,$package_no);?> SR</strong></span>
                                        </div>
                                        <div class="clearfix" style="height:5px;"></div>
								<?php }
								}
								else
								{?>
                                    <div class="row1">No additional coverage added.</div>
                                <?php }?>
                            	<div class="clearfix" style="height:5px;"></div>
                            </div>

							<div class="clear" style="height:15px;"></div>
                            
                            <div>
                                <h1 class="newtag1">
                                    Policy Holder's details
                              </h1>
                                
                                <?php /*?><div class="row1">
                                    <lable>Customer Type :</lable>
                                    <span><?php if($customer_type == 1)echo 'Individual';
									if($customer_type == 2)echo 'Commercial';?></span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div><?php */?>
                                
                                
                                <div class="row1">
                                    <lable>Name :</lable>
                                    <span><?php echo $title.' '.$name;?></span>
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
                                    <lable>Marital Status :</lable>
                                    <span>
									<?php echo $marital_status;?>
                                    </span>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                
                                <div class="row1">
                                    <lable>Gender :</lable>
                                    <span>
									<?php if($gender==2)echo 'Male';
									if($gender==1)echo 'Female';?>
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
                                <div class="clearfix" style="height:5px;"></div>
                                <!--<div class="clearfix" style="height:10px;"></div>
                                
                                 <h1 class="newtag1">Health Information</h1>-->
                                
                                <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                    <lable>Occupation : </lable>
                                    <?php echo $occupation;?>
                                    <div class="clear" style="height:1px;"></div>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                    <lable>Nationality : </lable>
                                    <?php echo $nationality_name;?>
                                    <div class="clear" style="height:1px;"></div>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                    <lable>Network class : </lable>
                                    <?php echo $network_class_name;?>
                                    <div class="clear" style="height:1px;"></div>
                                </div>
                                <div class="clearfix" style="height:5px;"></div>
                                <div class="row1" style="float:left;width: 48%;clear: inherit;">
                                    <lable>Pre- Existing / Chronoc Diseases : </lable>
                                    <?php echo $chronoc_diseases;?>
                                    <div class="clear" style="height:1px;"></div>
                                </div>
                                
                                <div class="clear" style="height:30px;"></div>
                                
                                <h1 class="newtag1">Insured Persons</h1>
                                <div class="clear" style="height:1px;"></div>
                                
                                <?php
								if(!empty($total_insured_person))
								{?>
                                	<table style="font-size:11px;" class="insured_person_table" cellspacing="2" cellpadding="2">
                                        <thead>
                                            <tr>
                                                <th width="12%">Name</th>
                                                <th width="12%">Gender</th>
                                                <th width="12%">Relationship</th>
                                                <th width="16%">DOB</th>
                                                <th width="12%">Occupation</th>
                                                <th width="16%">ID/Iqama No</th>
                                                <th width="20%">Pre- Existing / Chronoc Diseases</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
                                          for($i=1; $i <= $total_insured_person; $i++)
                                          {
                                              $inp_name = $_SESSION['medical']['Step1']['inp_name'][$i-1];
                                              $inp_gender = $_SESSION['medical']['Step1']['inp_gender'][$i-1];
                                              $inp_rel = $_SESSION['medical']['Step1']['inp_rel'][$i-1];
                                              $inp_dob = $_SESSION['medical']['Step1']['inp_dob'][$i-1];
                                              $inp_occup = $_SESSION['medical']['Step1']['inp_occup'][$i-1];
                                              $inp_iqma = $_SESSION['medical']['Step1']['inp_iqma'][$i-1];
                                              $inp_chron_ds = $_SESSION['medical']['Step1']['inp_chron_ds'][$i-1];
                                              
											  	if($i > 1)
												{?>
                                                    <tr><td colspan="7" style="border-bottom:1px solid #e0e0e0"></td></tr>
                                                <?php }?>
                                                <tr>
                                                    <td><?php echo $inp_name;?></td>
                                                    <td>
                                                        <?php if($inp_gender == 2)echo 'Male';
                                                        if($inp_gender == 1)echo 'Female';?>
                                                    </td>
                                                    <td>
                                                        <?php echo getRelationship($inp_rel);?>
                                                    </td>
                                                    <td><?php echo $inp_dob;?></td>
                                                    <td><?php echo $inp_occup;?></td>
                                                    <td><?php echo $inp_iqma;?></td>
                                                    <td>
                                                        <?php echo $inp_chron_ds;?>
                                                    </td>
                                                </tr>
                                          <?php 
                                          }
                                          ?>
                                         </tbody>
                                      </table>
                                 <?php 
								}
								else
								{
									?>
                                    <div class="row1">
                                        <lable>No Insured persons added.</lable>
                                    </div>
                                    <div class="clear" style="height:5px;"></div>
                                    <?php 
								}
								?>
                                
                                <div class="clear" style="height:30px;"></div>
                                
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
                                
                                <h1 class="newtag1">Insurace Period Details</h1>
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
                                    I accept all <a href="<?php echo BASE_URL.'util/terms-and-conditions.php';?>" class="fancy">terms and conditions</a>.
                                </div>
                                <div class="clear" style="height:15px;">&nbsp;</div>
                                <input type="button" class="submit_button" value="Recalculate" name="submit" onclick="document.location.href='<?php echo BASE_URL;?>index.php?page=medical-insurance&step=3'" style="margin-right: 10px;">
                                <input type="submit" class="submit_button" value="Proceed to Payment" name="submit_step4" onclick="return validStep4Form();" style="width: 33%;">
                            </div>
                            </div>
                            </form>
                    <?php }
					if($step == 5)
					{?>
                    	<form name="step5_form" id="step5_form" method="post">
                        	<input type="hidden" name="package_name" value="<?php echo $pkg_title;?>" />
                        	<input type="hidden" name="total_payment_amount" value="<?php echo $package_amount;?>" />
                            <h1 style="background: green; color:#fff; text-align:center;font-weight: bold;">
                                Your Selected Quote
                            </h1>
                            <div class="padding15" style="padding-top:1px"> 
                            <div class="search_box_two">
                                  <div class="listTL">
                                       <table cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 65%;" valign="top">
                                                        <strong><?php echo $pkg_title;?></strong>
                                                        <div class="clearfix" style="height:10px;"></div>
                                                        <p>
                                                            <?php echo $pkg_desc;?>
                                                        </p>
                                                    </td>
                                                    <td valign="middle" class="priceTL">
                                                        <?php echo $package_amount;?> <span>SR</span>
                                                    </td>
                                                </tr>
                                           </tbody>
                                       </table>
                                 </div>
                                </div>
                            <div class="clear" style="height:15px;"></div>
            
                            
                            <div class="row1">
                                <lable>Total Policy Amount:</lable>
                                <span><strong><?php echo $package_amount;?> SR</strong></span>
                            </div>
                            <div class="clear" style="height:5px;"></div>
                            
                            <div class="row1">
                                <lable>Policy Period :</lable>
                                <span><strong><?php echo date('d-m-Y',strtotime($insured_period_startdate));?> &nbsp;to&nbsp; <?php echo date('d-m-Y',strtotime($insured_period_enddate));?></strong></span>
                            </div>
                            <div class="clear" style="height:5px;"></div>
                            
                            <div class="row1">
                                <lable>Policy Date :</lable>
                                <span><strong><?php echo date('d-m-Y');?></strong></span>
                            </div>
                            <div class="clear" style="height:1px;"></div>
                            
                            <div class="clear" style="height:20px;"></div>
            
                            <div>
                                <h1 class="newtag1">
                                Additional Coverage
                                </h1>
                            	<?php if(!empty($additional_pkg_covers))
								{
									foreach($additional_pkg_covers as $additional_pkg_cover)
									{?>
                                        <div class="row1">
                                            <lable><?php echo getCoverTitle($additional_pkg_cover);?>: </lable>
                                            <span><strong><?php echo getCoverAmount($additional_pkg_cover,$package_no);?> SR</strong></span>
                                        </div>
                                        <div class="clearfix" style="height:5px;"></div>
								<?php }
								}
								else
								{?>
                                    <div class="row1">No additional coverage added.</div>
                                <?php }?>
                            	<div class="clearfix" style="height:5px;"></div>
                            </div>

							<div class="clear" style="height:20px;"></div>
                            
                            <div style="color: rgb(173, 169, 169);">
                            * Click on the <strong>"Pay Now"</strong> button to pay using paypal method.
                            </div>
                            
                            <div class="clear" style="height:10px;"></div>
                                
                                <input type="submit" class="submit_button" name="pay_now" value="Pay Now" style="width: 30%;" />
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