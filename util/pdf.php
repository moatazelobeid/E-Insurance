<?php  /*session_start();
include_once("../config/config.php");
include_once("../config/functions.php");
include_once("../config/tables.php");
include_once("../classes/dbFactory.php");

$db = new dbFactory();*/

//print_r($_SESSION); //exit;

/*function getCoverTitle($id)
{
	$res = mysql_fetch_object(mysql_query("select cover_title from ".PRODUCTCOVERS." where id=".$id));
	return stripslashes($res->cover_title);
}

function getPackageDetails($package_no)
{
	//$makedata = $db->recordFetch($id,VMAKE.':id');
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
*/

require_once("dompdf-master/dompdf_config.inc.php");

$policy_no = get_code(POLICYMASTER,'policy_no','id');
$document_key = "AC/".date("Y")."/".$policy_no;

//Get Insurance details
	
if(!empty($_SESSION['motor']['Package']))
{
	$pkg_no = $_SESSION['motor']['Package'];
	
	$pkg = getPackageDetails($_SESSION['motor']['Package']); 
	$pkg_title = stripslashes($pkg->package_title);
	$pkg_desc = stripslashes($pkg->package_desc);
	$pkg_price = number_format($pkg->package_amt,2);
}

$accept_terms = $_SESSION['motor']['Accept_terms'];

$is_driver = $_SESSION['motor']['Your_details']['is_driver'];
$fname = $_SESSION['motor']['Your_details']['fname'];
$customer_type = $_SESSION['motor']['Your_details']['customer_type'];

if($customer_type == 1)$customer_type =  'Individual';

if($customer_type == 2)$customer_type =  'Commercial';

$lname = $_SESSION['motor']['Your_details']['lname'];
$gender = $_SESSION['motor']['Your_details']['gender'];
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
$policy_type_id = $motor['policy_type_id'];

if($policy_type_id == 1)
{
	$vehicle_year_made = $_SESSION['motor']['Vehicle']['vehicle_year_made'];
}
else
{
	$vehicle_year_made = $_SESSION['motor']['Vehicle']['vehicle_made_year'];
}

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
		
		$vehicle_made_year = $motor['vehicle_made_year'];
		$car_value = $motor['car_value'];
		$agency_deduct_amt = $motor['agency_deduct_amt'];
		
		$vehicle_use = $motor['vehicle_use'];
		$vehicle_use_value = getVehicleUseValue($vehicle_use);
	}
	
	//Only for tpl	
	if($policy_type_id == 1)
	{	
		$vehicle_type_tpl = $motor['vehicle_type_tpl'];
		//$vehicle_cylender = $motor['vehicle_cylender'];	
		//$vehicle_weight = $motor['vehicle_weight'];	
		//$vehicle_seats = $motor['vehicle_seats'];
		$vtype_title = getVType($vehicle_type_tpl);
		
		$vehicle_use = getVehicleUse($vehicle_type_tpl);
		$vehicle_use_value = getVehicleUseValue($vehicle_use);
	}
	
	$vehicle_ncd = $motor['vehicle_ncd'];	
	$driver_age = $motor['driver_age'];	
	$driver_age_value  = getDriverAge($driver_age);
	$driver_license_issue_date = $motor['driver_license_issue_date'];
	$driver_license_issue_date = date('d-m-Y',strtotime($driver_license_issue_date));
	
}

if(!empty($_SESSION['motor']['Package_Covers']))
{
	$additional_pkg_covers = $_SESSION['motor']['Package_Covers'];	
}

if(!empty($_SESSION['motor']['Package']))
{
	$package_no = $_SESSION['motor']['Package'];	
}
$pkg_amount = $_SESSION['motor']['Total_Package_Amount'];

if($gender=='m')$gender= 'Male';
if($gender=='f')$gender= 'Female';

if(!empty($accept_terms))
	$accept_terms = 'Yes';

$html = '';

if($policy_type_id == 1)
	$policy_type_name = 'TPL Motor Insurance';
else
	$policy_type_name = 'Comprehensive Motor Insurance';

$html .= '<html>
    <head>
<style type="text/css">

body
{
	font-family: Arial, Helvetica, sans-serif !important;	
}

	.row1 {
margin-bottom: 5px;
clear: both;
position: relative;
width: 100%;
display: block;

}
 lable {
font-size: 15px;
text-align: left;
width: 100%;
color: #000;
padding-top: 0px;
clear: both;

}
lable strong {
padding: 5px 0px;
display: block;
color: green;
font-size: 15px;
}.search_box_two {
background-color: #E9E9E9;
padding-left: 8px;
padding-right: 8px;
border-radius: 5px;
margin-top: 8px;
font-weight: normal;
font-size: 12px;
height: auto;
cursor: pointer;
color: #000;
box-shadow: 1px 1px 4px rgb(167, 163, 156);
}
.listTL {
font-family: Arial, Helvetica, sans-serif;
font-size: 13px;
font-weight: bold;
}
.listTL table {
width: 100%;
}
.listTL table td {
padding: 10px;
}

.innerwrap p {
font-family: Arial, Helvetica, sans-serif;
font-size: 13px;
font-weight: normal;
line-height: 20px;
padding: 0;
margin: 0px 0px 10px 0px;
color: #303030;
}

td.priceTL {
font-size: 27px;
font-weight: bold;
text-align: center;
border-left: 1px solid rgb(194, 194, 194);
width: 10px;
}

td.priceTL span {
font-style: italic;
font-size: 15px;
}

</style>
    </head>

    <body>
        <div class="row1" style=" text-align:center;"">
			<img src="'.BASE_URL.'images/logo.png" />
            <lable style="width:100%; font-size:23px; text-align:center;"><strong style="padding-top:0;">'.$policy_type_name.'</strong></lable>
        </div>
		<div class="clear" style="height:15px;"></div>
        <table>
			<tr>
				<td>Policy Number: <strong>'.$policy_no.'</strong></td>
			</tr>
			<tr>
				<td>Document Key: <strong>'.$document_key.'</strong></td>
			</tr>
			<tr>
				<td>
				Insurace Period: 
                <strong>
                '. date('d-m-Y',strtotime($insured_period_startdate)).'
				</strong>
                To
				<strong>
                '. date('d-m-Y',strtotime($insured_period_enddate)).'
                </strong>
				</td>
			</tr>
			<tr>
				<td>Policy Date: <strong>'.date('d-m-Y').'</strong></td>
			</tr>
		</table>
		
        <div class="clear" style="height:15px;"></div> 
		               	
		<div class="row1">
			<lable style="width:100%; font-size:13px;"><strong style="padding-top:0;">Policy Package Details</strong></lable>
		</div>
                            
		
        <div class="search_box_two">
              <div class="listTL">
                   <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td valign="middle" style="width: 80%;" valign="top">
                                    <strong>'. $pkg_title.'</strong>
                                   
                                </td>
                                <td valign="middle" class="priceTL" align="right">
                                    '. $pkg_amount.' SR
                                </td>
                            </tr>
                       </tbody>
                   </table>
             </div>
            </div>
        <div class="clear" style="height:15px;"></div>';
		
			
            $html .= '<div class="row1">
                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="width: 147%;">Additional Package Covers</strong></lable>
            </div>';

			if(!empty($additional_pkg_covers))
			{
				foreach($additional_pkg_covers as $additional_pkg_cover)
				{
					$html .= '<div class="row1">
								<lable>'.getCoverTitle($additional_pkg_cover).': </lable>
								<span><strong>'.getCoverAmount($additional_pkg_cover,$package_no).' SR</strong></span>
							</div>
							<div class="clearfix" style="height:5px;"></div>';	
				}					
			}
			else
			{
				$html .= '<div class="row1">
							<lable>No covers added.</lable>
						</div>';	
			}
		
    
        
        $html .= '<div style="width:68%;">
            <div class="row1">
                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="padding-top:0; width: 147%;">Your Details</strong></lable>
            </div>
            
            <div class="row1">
                <lable> Name: </lable>
                <span>'. $fname.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
            
           
            
            <div class="row1">
                <lable>Date of Birth: </lable>
                <span>'. $dob.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
            
            <div class="row1">
                <lable>Gender: </lable>
                <span>'.$gender.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
            
            <div class="row1">
                <lable>Email: </lable>
                <span>'. $email.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
            
          
            
            <div class="row1">
                <lable>Mobile: </lable>
                <span>'. $phone_mobile.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
            
            
            
            <div class="row1">
                <lable>Country: </lable>
                <span>'. $country.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
            <div class="row1">
                <lable>State: </lable>
                <span>'. $state.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
            
            <div class="row1">
                <lable>IQMA No: </lable>
                <span>'. $iqma_no.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
                                                    
            <div class="row1">
                <lable>Driving licence No: </lable>
                <span>'. $drive_license_no.'</span>
            </div>
            <div class="clearfix" style="height:10px;"></div>
            
            <div class="row1">
                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="width: 147%;">Vehicle Detail</strong></lable>
            </div>';
       	?>
            
            <?php if($policy_type_id == 2)
            {       
                $html .= '<div class="row1">
                    <lable>Vehicle Make: </lable>
                    <span>'. $vmake_title.'</span>
                </div>
                <div class="clearfix" style="height:5px;"></div>
                
                                                        
                <div class="row1">
                    <lable>Vehicle Model: </lable>
                    <span>'. $vmodel_title.'</span>
                </div>
                <div class="clearfix" style="height:5px;"></div>
                                                        
                <div class="row1">
                    <lable>Car Value: </lable>
                    <span>'. $car_value.' SR</span>
                </div>
                <div class="clearfix" style="height:5px;"></div>
                                                        
                <div class="row1">
                    <lable>Agency Repair: </lable>
                    <span>'. $vehicle_agency_repair.'</span>
                </div>
                <div class="clearfix" style="height:5px;"></div>';
            
            }
			if($vehicle_agency_repair == 'No')
			{
				$agency_deduct_amt = $_SESSION['motor']['Vehicle']['agency_deduct_amt'];
				$deduct_pkg_sql = mysql_fetch_object(mysql_query("select name from ".DEDUCTPKGS." where id = '".$agency_deduct_amt."'"));
				$agency_deduct_amt_val = $deduct_pkg_sql->name;
				
				$html .= '
                                                        
                <div class="row1">
                    <lable>Additional Deduct Amount: </lable>
                    <span>'. $agency_deduct_amt_val.' SR</span>
                </div>
                <div class="clearfix" style="height:5px;"></div>';
				
			}
			
            if($policy_type_id == 1)
            {
                $html .= '<div class="row1">
                    <lable>Vehicle Type: </lable>
                    <span>'. $vtype_title.'</span>
                </div>
                <div class="clearfix" style="height:5px;"></div>';
            
            }
                                                    
            $html .= '
			
                                                    
            <div class="row1">
                <lable>Driver Age:</lable>
                <span>'. $driver_age_value.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
                                                    
                                                    
            <div class="row1">
                <lable>Driver License issuing date:</lable>
                <span>'. $driver_license_issue_date.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
                                                    
                                                    
            <div class="row1">
                <lable>Claim paid:</lable>
                <span>'. $vehicle_ncd.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
                                                    
			<div class="row1">
                <lable>Vehicle Purchase Year: </lable>
                <span>'. $vehicle_purchase_year.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
                                                    
                                                    
            <div class="row1">
                <lable>Vehicle Regd. Place: </lable>
                <span>'. $vehicle_regd_place.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
                                                    
                                                    
            <div class="row1">
                <lable>Vehicle Ownership: </lable>
                <span>'. $vehicle_ownership.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
                                                    
                                                    
            <div class="row1">
                <lable>Vehicle Use: </lable>
                <span>'. $vehicle_use_value.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
                                                    
                                                    
            <div class="row1">
                <lable>Vehicle Manufacture Year: </lable>
                <span>'. $vehicle_year_made.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
                                                    
            <div class="row1">
                <lable>Vehicle Color : </lable>
                <span>'. $vehicle_color.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
                                                    
            <div class="row1">
                <lable>Chassis No : </lable>
                <span>'. $chassic_no.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
                                                    
            <div class="row1">
                <lable>Engine No : </lable>
                <span>'. $engine_no.'</span>
            </div>
            <div class="clearfix" style="height:5px;"></div>
            
            <div class="row1">
                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="width: 147%;">Document Attached</strong></lable>
            </div>
            <div class="clear" style="height:1px;"></div>';
            
            
            if(!empty($attachments))
            {
                foreach($attachments as $key=>$attachment)	
                {
                    $html .= '<div class="row1">
                        <lable>Document Title: </lable>
                        <span>'. $attachment['atch_title'].'</span>
                    </div>
                
                    <div class="row1">
                        <lable>Attachment: </lable>
                        <span>'. $attachment['atch_file'].'</span>
                    </div>
                        
                    <div class="clear" style="height:10px;">&nbsp;</div>';
             }
            }
			else
			{
				$html .= '<div class="row1">
							<lable>No document attached.</lable>
						</div><div class="clear" style="height:5px;">&nbsp;</div>';	
			}
			
            $html .= '<div class="clear" style="height:5px;">&nbsp;</div>
            
        </div>';

$html .= '</body></html>';


$pdf_name =rand();

$file_location = "upload/pdfReports/".$policy_no.".pdf";

$local = array("::1", "127.0.0.1");
$is_local = in_array($_SERVER['REMOTE_ADDR'], $local);

if ( !empty( $html )) 
{

  if ( get_magic_quotes_gpc() )
    $html = stripslashes($html);
  
  $dompdf = new DOMPDF();
  $dompdf->load_html($html);
  $dompdf->set_paper('letter', 'portrait');
  $dompdf->render();


//To save pdf file
  $pdf = $dompdf->output();
  file_put_contents($file_location, $pdf);
//To save pdf file

//To download
  //$dompdf->stream($policy_no.".pdf", array("Attachment" => false));
  //$dompdf->stream($policy_no.".pdf", array("Attachment" => false));

  //exit(0);
}

?>