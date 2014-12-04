<?php $db = new dbFactory();
	if(empty($_SESSION['uid']))
	{
		header("location:index.php?page=sign-in");
	}else{
		$udata=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid='".$_SESSION['uid']."' and user_type='U' "));
		$userinfo=mysql_fetch_assoc(mysql_query("select * from ksa_user where id='".$_SESSION['uid']."' "));

function getVMake($id)
{
	//echo "select make from ".VMAKE." where id=".$id;
	//$makedata = $db->recordFetch($id,VMAKE.':id');
	$res = mysql_fetch_assoc(mysql_query("select make from ".VMAKE." where id=".$id));
	return stripslashes($res['make']);
}
function getVModel($id)
{
	$res = mysql_fetch_assoc(mysql_query("select model from ".VMODEL." where id=".$id));
	return stripslashes($res['model']);
}
function getVType($id)
{
	$res = mysql_fetch_assoc(mysql_query("select type_name from ".VTYPE." where id=".$id));
	return stripslashes($res['type_name']);
}

function getDriverAge($id)
{
	$res = mysql_fetch_object(mysql_query("select age from ".DRIVERAGE." where id=".$id));
	return $res->age;
}
function getVehicleUseValue($id)
{
	$res = mysql_fetch_object(mysql_query("select name from ".POLICYUSE." where id=".$id));
	return $res->name;
}
function get_amount($id){
		$policy_pricedet = mysql_fetch_object(mysql_query("SELECT * FROM ".POLICYPAYMENTS." WHERE policy_no='".$id."' limit 1"));
		return number_format($policy_pricedet->amount_paid,2);
}

$reg_user_deatil = $db->recordFetch($_SESSION['uid'],USERTBL.":".'id');

$customer_code = getElementVal('customer_code',$reg_user_deatil);

$fname = getElementVal('fname',$reg_user_deatil);

$customer_type = getElementVal('customer_type',$reg_user_deatil);;

if($customer_type == 1)$customer_type =  'Individual';

if($customer_type == 2)$customer_type =  'Commercial';

$dob = date('d-m-Y',strtotime(getElementVal('dob',$reg_user_deatil)));

$gender = getElementVal('gender',$reg_user_deatil);
if($gender == 'f')
	$gender = 'Female';
if($gender == 'm')
	$gender = 'Male';

$phone_mobile = getElementVal('phone_mobile',$reg_user_deatil);

$drive_license_no = getElementVal('drive_license_no',$reg_user_deatil);


$email = getElementVal('email',$reg_user_deatil);
$usercountry = getElementVal('country',$reg_user_deatil);
$state = getElementVal('state',$reg_user_deatil);
$iqma_no = getElementVal('iqma_no',$reg_user_deatil);
$country = getElementVal('fname',$reg_user_deatil);

function getCoverTitle($id)
{
	$res = mysql_fetch_array(mysql_query("select cover_title from ".PRODUCTCOVERS." where id=".$id));
	return stripslashes($res['cover_title']);
}

function getPackageDetails($package_no)
{
	$res = mysql_fetch_object(mysql_query("select package_title from ".PACKAGE." where package_no='".$package_no."'"));
	return $res->package_title;
}

$policy_no = $_GET['policyno'];
$policy_details_qry = "select a.*, b.insured_period_startdate, b.insured_period_enddate, b.doc_key, b.registry_date from ".POLICYMOTOR." as a inner join ".POLICYMASTER." as b on a.policy_no = b.policy_no where a.policy_no='".$policy_no."' and a.customer_id= '".$customer_code."'";
$policy_details = mysql_fetch_object(mysql_query($policy_details_qry));

$attachment_sql = mysql_query("select * from ".POLICYATTACHMENTS." where customer_id='".$customer_code."' and policy_no='".$policy_no."'");

//echo '<pre>'; print_r($policy_details); echo '</pre>';

$policy_type_id = $policy_details->policy_type_id;

if($policy_details->policy_type_id == 1)
{
	$policy_name = 'TPL Motor Policy';	
	
	$vtype_title = getVType($policy_details->vehicle_type_tpl);
	
	$vehicle_cylender = $policy_details->vehicle_cylender;
	$vehicle_weight = $policy_details->vehicle_weight;
	$vehicle_seats = $policy_details->vehicle_seats;
	
}
if($policy_details->policy_type_id == 2)
{
	$policy_name = 'Comprehensive Motor Policy';	
	
	$vmake_title = getVMake($policy_details->vehicle_make);
	$vmodel_title = getVModel($policy_details->vehicle_model); 
	$vtype_title = getVType($policy_details->vehicle_type);
	$vehicle_agency_repair = $policy_details->vehicle_agency_repair;
	$vehicle_ncd = $policy_details->vehicle_ncd;
}

$vehicle_purchase_year = $policy_details->vehicle_purchase_year;
$vehicle_regd_place = $policy_details->vehicle_regd_place;
$vehicle_ownership = $policy_details->vehicle_ownership;
$vehicle_use = $policy_details->vehicle_use;
$vehicle_year_made = $policy_details->vehicle_year_made;
$vehicle_color = $policy_details->vehicle_color;
$chassic_no = $policy_details->chassic_no;
$engine_no = $policy_details->engine_no;

$start_date = $policy_details->insured_period_startdate;
$start_date = date('d-m-Y',strtotime($start_date));
$end_date = $policy_details->insured_period_enddate;
$end_date = date('d-m-Y',strtotime($end_date));
$policy_date = date('d-m-Y',strtotime($policy_details->registry_date));

$pkg_covers = $db->recordArray($policy_details->package_no,PACKAGECOVER.':package_no');

$policycovers =  mysql_query("select * from ".POLICYCOVERS." where policy_no='$policy_no' and customer_id ='".$policy_details->customer_id."'");
//echo "select * from ".POLICYCOVERS." where policy_no='$policy_no' and customer_id ='".$policy_details->customer_id."'";

$pkg = getPackageDetails($policy_details->package_no); 
?>
<script type="text/javascript">

function printPolicy()
{
	var url='<?php echo BASE_URL;?>util/print.php?policyno=<?php echo $policy_no;?>';
	//alert(url);
	window.open(url,'popUpWindow','height=650,width=692,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
}
function downloadPDF()
{
	var url = '<?php echo BASE_URL;?>download.php?dir=<?php echo BASE_URL;?>upload/pdfReports/&f=<?php echo $policy_no;?>.pdf';
	window.location.href = url;
}
</script>
<div class="innrebodypanel">
        <div class="clearfix" style="height:15px;">.</div>
        <div class="innerwrap">
        
            <div class="breadcrumb" >
                <a itemprop="url" href="<?=BASE_URL?>">Home</a> 
                <span class="breeadset">&#8250;</span>
                <a itemprop="url" href="<?=BASE_URL.'index.php?page=user-dashboard'?>">Dashboard</a> 
                <span class="breeadset">&#8250;</span>
                <a itemprop="url" href="<?=BASE_URL.'index.php?page=mypolicies'?>">My Policies</a> 
                <span class="breeadset">&#8250;</span>
                <strong>Policy Details </strong>
            </div>
            
            <?php include_once('includes/dashboard-sidebar.php'); ?>
            <div class="lg-6">
                <div class="rightformpan innerTFl">
                    <h1><?php echo $policy_name?></h1>
                    
                        <div class="your-quoatation-inner1">
                          <table width="100%" border="0" cellpadding="2" cellspacing="4">
                                <tbody>
                                <tr>
                                	<td colspan="5">Policy Number: <?php echo $policy_details->policy_no;?></td>
                                </tr>
                                <tr>
                                	<td colspan="5">Document Key: <?php echo $policy_details->doc_key;?></td>
                                </tr>
                                <tr>
                                	<td colspan="5">Insurace Period: <?php echo $start_date.' To '.$end_date;?></td>
                                </tr>
                                <tr>
                                	<td colspan="5">Policy Date: <?php echo $policy_date;?></td>
                                </tr>
                                <tr>
                                	<td colspan="5">Policy Amount(SR): <?php echo get_amount($policy_no);?></td>
                                </tr>
                                 <?php if($policy_type_id==2)
								{?>
                                 <tr>
                                	<td colspan="5">Agency Deduct Amount(SR): <?php echo (!empty($policy_details->vehicle_agency_repair))?$policy_details->vehicle_agency_repair:'N/A'; ?></td>
                                </tr>
                                <?php } ?>
                                <tr><td colspan="5"></td></tr>
                                <tr>
                                  <th height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;"><strong>Additional Covers</strong></th>
                                </tr>
                                
								<?php 
                                if(mysql_num_rows($policycovers)>0)
                                {
                                    while($pol_cover = mysql_fetch_array($policycovers))	
                                    {?>
                                       <tr>
                                          <td colspan="2" height="30" style="text-align:left;"><?php echo getCoverTitle($pol_cover['cover_id']);?></td>
                                          <td colspan="2" style="text-align:left;"><?php echo $pol_cover['cover_amt'];?>&nbsp;SR</td>
                                  </tr> 
                                <?php }
								}
								else
								{?>
									<tr><td colspan="5">No Policy covers found.</td></tr>
                                    <?php 
								}
								?> <tr><td colspan="5"></td></tr>
                                <tr>
                                  <th height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;"><strong>Policy Holder's detail</strong></th>
                                </tr>
                                <tr>
                                  <td width="346" height="30" style="text-align:left;"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Name </span></span></td>
                                  <td width="281" height="30"><span class="item dateofbirth"><?php echo $fname;?></span></td>
                                  <td width="32" height="30">&nbsp;</td>
                                  <td width="346" height="30">&nbsp;<span class="fieldLabel form_txt1">Date of Birth </span></td>
                                  <td width="270" height="30"><span class="item dateofbirth"><?php echo $dob;?></span></td>
                                </tr>
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Gender </span></td>
                                  <td width="281" height="30"><span class="fieldsColumn1"><?php echo $gender;?></span></td>
                                  <td height="30">&nbsp;</td>
                                  <td height="30" style="text-align:left;"><span class="fieldLabel1 form_txt1">Email </span></td>
                                  <td height="30"><span class="fieldsColumn1"><?php echo $email;?></span></td> 
                                </tr>
                                
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Mobile Number</span></td>
                                  <td height="30"><?php echo $phone_mobile;?></td>
                                  <td height="30">&nbsp;</td>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Country</span></td>
                                  <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $usercountry;?></span></td>
                                </tr>
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">State </span></td>
                                  <td height="30">&nbsp;<span class="item dateofbirth"><?php echo $state;?></span></td>
                                  <td height="30">&nbsp;</td>
                                  <td height="30"><span class="fieldLabel1 form_txt1">IQMA Number</span></td>
                                  <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $iqma_no;?></span></td>
                                </tr>
                               
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Driving License No </span></td>
                                  <td height="30">&nbsp;<span class="item dateofbirth"><?php echo $drive_license_no;?></span></td>
                                  <?php /*?><td height="30">&nbsp;</td>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Customer Type</span></td>
                                  <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $customer_type;?></span></td>
<?php */?>                      </tr>
                                
                              </tbody>
                              
                                <tr>
                                    <td height="10"></td>
                                </tr>
                                
                                <tbody>
                                <tr>
                                  <th height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;"><strong>Vehicle Detail</strong></th>
                                </tr>
                                
                                <?php if($policy_type_id==1)
								{?>
                                
                                    <tr>
                                      <td width="346" height="30" style="text-align:left;">Vehicle Type</td>
                                      <td width="281" height="30">&nbsp;<span class="item dateofbirth"><?php echo $vtype_title;?></span></td>
                                      <td width="32" height="30">&nbsp;</td>
                                      <td width="346" height="30"><span class="fieldLabel form_txt1">Driver Age </span></td>
                                      <td width="270" height="30"> &nbsp;<span class="item dateofbirth">&nbsp;<?php echo (!empty($policy_details->driver_age))?getDriverAge($policy_details->driver_age):'N/A'; ?></span></td>
                                    </tr>
                                
                                  <?php /*?>  <tr>
                                      <td width="170" height="30" style="text-align:left;">Vehicle Weight</td>
                                      <td width="138" height="30">&nbsp;<span class="item dateofbirth"><?php echo $vehicle_weight;?></span></td>
                                      <td width="11" height="30">&nbsp;</td>
                                      <td width="116" height="30"><span class="fieldLabel form_txt1">Vehicle Seats </span></td>
                                      <td width="144" height="30"> &nbsp;<span class="item dateofbirth">&nbsp;<?php echo $vehicle_seats;?></span></td>
                                    </tr><?php */?>
                                    <tr>
                                      <td width="346" height="30" style="text-align:left;">Driver License Issuing Date</td>
                                       <td width="281" height="30">&nbsp;<span class="item dateofbirth"><?php echo (!empty($policy_details->driver_license_issue_date))?date('d/m/Y',strtotime($policy_details->driver_license_issue_date)):'N/A'; ?></span></td>
                                     <td width="32" height="30">&nbsp;</td>
                                      <td width="346" height="30"><span class="fieldLabel form_txt1">Claim Paid</span></td>
                                      <td width="270" height="30"><?php echo (!empty($policy_details->vehicle_ncd))?$policy_details->vehicle_ncd:'N/a'; ?></td>
                                    </tr>
                                    
                                    <tr>
                                      <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Regd. Place</span></td>
                                      <td height="30"><?php echo $vehicle_regd_place;?></td>
                                      <td height="30">&nbsp;</td>
                                      <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Ownership</span></td>
                                      <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $vehicle_ownership;?></span></td>
                                    </tr>
                                    <tr>
                                      <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Use</span></td>
                                      <td height="30">&nbsp;<span class="item dateofbirth"><?php echo (!empty($policy_details->vehicle_use))?getVehicleUseValue($policy_details->vehicle_use):'N/A'; ?></span></td>
                                      <td height="30">&nbsp;</td>
                                      <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Manufacture Year</span></td>
                                      <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $vehicle_year_made;?></span></td>
                                    </tr>
                                    <tr>
                                      <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Color </span></td>
                                      <td height="30">&nbsp;<span class="item dateofbirth"><?php echo $vehicle_color;?> </span></td>
                                      <td height="30">&nbsp;</td>
                                      <td height="30"><span class="fieldLabel1 form_txt1">Chassis No </span></td>
                                      <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $chassic_no;?></span></td>
                                    </tr>
                                    <tr>
                                      <td height="30"><span class="fieldLabel1 form_txt1">Engine No  </span></td>
                                      <td height="30">&nbsp;<span class="item dateofbirth"><?php echo $engine_no;?></span></td>
                                      <td height="30">&nbsp;</td>
                                      <?php /*?><td height="30"><span class="fieldLabel1 form_txt1"> Vehicle Purchase year</span></td>
                                      <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $vehicle_purchase_year;?></span></td><?php */?>
                                    </tr>
                                
                                <?php }
								
								 if($policy_type_id==2)
								 {?>
                                 <tr>
                                  <td width="346" height="30" style="text-align:left;">Driver Age</td>
                                  <td width="281" height="30">&nbsp;<span class="item dateofbirth"><?php echo (!empty($policy_details->driver_age))?getDriverAge($policy_details->driver_age):'N/A'; ?></span></td>
                                  <td width="32" height="30">&nbsp;</td>
                                  <td width="346" height="30"><span class="fieldLabel form_txt1">Driver License Issuing Date</span></td>
                                  <td width="270" height="30"><span class="item dateofbirth"><?php echo (!empty($policy_details->driver_license_issue_date))?date('d/m/Y',strtotime($policy_details->driver_license_issue_date)):'N/A'; ?></span></td>
                                </tr>
                                <tr>
                                  <td width="346" height="30" style="text-align:left;">Vehicle Make</td>
                                  <td width="281" height="30">&nbsp;<span class="item dateofbirth"><?php echo $vmake_title;?></span></td>
                                  <td width="32" height="30">&nbsp;</td>
                                  <td width="346" height="30"><span class="fieldLabel form_txt1">Vehicle Model </span></td>
                                  <td width="270" height="30"><span class="item dateofbirth"><?php echo $vmodel_title;?></span></td>
                                </tr>
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Type </span></td>
                                  <td width="281" height="30"><span class="fieldsColumn1"><?php echo $vtype_title;?></span></td>
                                  <td height="30">&nbsp;</td>
                                  <td height="30" style="text-align:left;"><span class="fieldLabel1 form_txt1">Agency Repair </span></td>
                                  <td height="30"><span class="fieldsColumn1"><?php echo $vehicle_agency_repair;?></span></td>
                                </tr>
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">No Claim Discount (NCD) </span></td>
                                  <td height="30"><span class="fieldsColumn1"><?php echo $vehicle_ncd;?></span></td>
                                  <td height="30">&nbsp;</td>
                                  <td height="30" style="text-align:left;"><span class="fieldLabel1 form_txt1">Vehicle Purchase year</span></td>
                                  <td height="30"><span class="item dateofbirth"><?php echo $vehicle_purchase_year;?></span></td>
                                </tr>
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Regd. Place</span></td>
                                  <td height="30"><?php echo $vehicle_regd_place;?></td>
                                  <td height="30">&nbsp;</td>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Ownership</span></td>
                                  <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $vehicle_ownership;?></span></td>
                                </tr>
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Use</span></td>
                                  <td height="30">&nbsp;<span class="item dateofbirth"><?php echo $vehicle_use;?></span></td>
                                  <td height="30">&nbsp;</td>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Manufacture Year</span></td>
                                  <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $vehicle_year_made;?></span></td>
                                </tr>
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Vehicle Color </span></td>
                                  <td height="30">&nbsp;<span class="item dateofbirth"><?php echo $vehicle_color;?> </span></td>
                                  <td height="30">&nbsp;</td>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Chassis No </span></td>
                                  <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $chassic_no;?></span></td>
                                </tr>
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Car value </span></td>
                                  <td height="30">&nbsp;<span class="item dateofbirth"><?php echo (!empty($policy_details->car_value))?$policy_details->car_value:'N/A'; ?> </span></td>
                                  <td height="30">&nbsp;</td>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Agency Repair</span></td>
                                  <td height="30"><span class="fieldLabel1 form_txt1"><?php echo (!empty($policy_details->vehicle_agency_repair))?$policy_details->vehicle_agency_repair:'N/A'; ?></span></td>
                                </tr>
                                <tr>
                                  <td height="30"><span class="fieldLabel1 form_txt1">Engine No  </span></td>
                                  <td height="30">&nbsp;<span class="item dateofbirth"><?php echo $engine_no;?></span></td>
                                  <td height="30">&nbsp;</td>
                                  <td width="346" height="30"><span class="fieldLabel form_txt1">Claim Paid</span></td>
                                      <td width="270" height="30"><?php echo (!empty($policy_details->vehicle_ncd))?$policy_details->vehicle_ncd:'N/a'; ?></td>
                                </tr>
                                <?php }?>
                               
                              </tbody>
                                
                                <tr>
                                    <td height="10"></td>
                                </tr>
                                
                                <tbody>
                                <tr>
                                  <th height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;"><strong>Document Attached</strong></th>
                                </tr>
                                
								<?php 
                                if(mysql_num_rows($attachment_sql)>0)
                                {
                                    while($attachment = mysql_fetch_array($attachment_sql))	
                                    {?>
                                       <tr>
                                          <td width="346" height="30" style="text-align:left;">Document Title</td>
                                          <td width="281" height="30">&nbsp;<span class="item dateofbirth"><?php echo $attachment['atch_title'];?></span></td>
                                          <td width="32" height="30">&nbsp;</td>
                                          <td width="346" height="30"><span class="fieldLabel form_txt1">Attachment</span></td>
                                          <td width="270" height="30"> &nbsp;<span class="item dateofbirth"><?php echo $attachment['atch_file'];?></span></td>
                                        </tr> 
                                <?php }
								}
								else
								{?>
									<tr><td colspan="5">No attachment found.</td></tr>
                                    <?php 
								}
								?>
                                
                              </tbody>
                                
                                <tr>
                                    <td height="10"></td>
                                </tr>
                                
                                <tbody>
                                
                                <tr height="10"><td colspan="5"></td></tr>
                                <tr height="10"><td colspan="5">
                                
                                	<input type="button" class="submit_button" value="Print" onclick="printPolicy();" style="width: 90px;float: right;" />
                                    <a href="<?php echo BASE_URL;?>download.php?dir=upload/pdfReports/&f=<?php echo $policy_no;?>.pdf">
                                        <input type="button" class="submit_button" value="Download PDF" style="width: 140px;float: right;margin-right: 10px;" />
                                    </a>
                                </td></tr>
                              </tbody>
                          </table>
                        </div>
                    
                </div>
            </div>
        <div class="clearfix"></div>
        </div>
       <div class="clearfix" style="height:15px;">.</div>
</div>
<?php } ?>