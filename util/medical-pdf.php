<?php  

require_once("dompdf-master/dompdf_config.inc.php");

$policy_no = get_code(POLICYMASTER,'policy_no','id');
$document_key = "AC/".date("Y")."/".$policy_no;

//Get Insurance details
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

if($gender ==2)
	$gender_name = 'Male';
	
if($gender ==1)
	$gender_name = 'Female';
	
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

	
$html = '';

$policy_type_name = 'Medical Insurance';

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
                                    '. $package_amount.' SR
                                </td>
                            </tr>
                       </tbody>
                   </table>
             </div>
            </div>
        <div class="clear" style="height:15px;"></div>
		
			<div class="row1">
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
				$html .= '<div class="row1">No additional coverage added.</div>';
			}
			$html .= '<div class="clearfix" style="height:5px;"></div>

		<div class="clear" style="height:15px;"></div>
		
		<div style="width:98%;">
            <div class="row1">
                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="padding-top:0; width: 147%;">Your Details</strong></lable>
            </div>
			
			<div class="row1">
				<lable>Name :</lable>
				<span>'. $title.' '.$name.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
		  
			<div class="row1">
				<lable>Date of Birth :</lable>
				<span>'.$dob.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
			<div class="row1">
				<lable>Marital Status :</lable>
				<span>'.$marital_status.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
			<div class="row1">
				<lable>Gender :</lable>
				<span>'.$gender_name.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
			<div class="row1">
				<lable>Email :</lable>
				<span>'.$email.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
			<div class="row1">
				<lable>Mobile :</lable>
				<span>'.$phone_mobile.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
			<div class="row1">
				<lable>Country :</lable>
				<span>'.$country.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
			<div class="row1">
				<lable>State :</lable>
				<span>'.$state.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
			
			<div class="row1">
				<lable>IQMA No :</lable>
				<span>'.$iqma_no.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
													
			<div class="row1">
				<lable>Driving licence No :</lable>
				<span>'.$drive_license_no.'</span>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			
			<div class="row1" style="float:left;width: 48%;clear: inherit;">
				<lable>Occupation : </lable>
				'.$occupation.'
				<div class="clear" style="height:1px;"></div>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			<div class="row1" style="float:left;width: 48%;clear: inherit;">
				<lable>Nationality : </lable>
				'.$nationality_name.'
				<div class="clear" style="height:1px;"></div>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			<div class="row1" style="float:left;width: 48%;clear: inherit;">
				<lable>Network class : </lable>
				'.$network_class_name.'
				<div class="clear" style="height:1px;"></div>
			</div>
			<div class="clearfix" style="height:5px;"></div>
			<div class="row1" style="float:left;width: 70%;clear: inherit;">
				<lable>Pre- Existing / Chronoc Diseases : </lable>
				'.$chronoc_diseases.'
				<div class="clear" style="height:1px;"></div>
			</div>
			
			<div class="clear" style="height:30px;"></div>
			
            <div class="row1">
                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="width: 147%;">Insured Persons</strong></lable>
            </div>
			
			<div class="clear" style="height:1px;"></div>';
			
			if(!empty($total_insured_person))
			{
				$html .= '<table style="font-size:11px; width:100%;" class="insured_person_table" cellspacing="2" cellpadding="2">
					<thead>
						<tr>
							<td width="12%"><strong>Name</strong></td>
							<td width="12%"><strong>Gender</strong></td>
							<td width="12%"><strong>Relationship</strong></td>
							<td width="16%"><strong>DOB</strong></td>
							<td width="12%"><strong>Occupation</strong></td>
							<td width="16%"><strong>ID/Iqama No</strong></td>
							<td width="20%"><strong>Pre- Existing / Chronoc Diseases</strong></td>
						</tr>
					</thead>
					<tbody>';
					
					  for($i=1; $i <= $total_insured_person; $i++)
					  {
						  $inp_name = $_SESSION['medical']['Step1']['inp_name'][$i-1];
						  $inp_gender = $_SESSION['medical']['Step1']['inp_gender'][$i-1];
						  $inp_rel = $_SESSION['medical']['Step1']['inp_rel'][$i-1];
						  $inp_dob = $_SESSION['medical']['Step1']['inp_dob'][$i-1];
						  $inp_occup = $_SESSION['medical']['Step1']['inp_occup'][$i-1];
						  $inp_iqma = $_SESSION['medical']['Step1']['inp_iqma'][$i-1];
						  $inp_chron_ds = $_SESSION['medical']['Step1']['inp_chron_ds'][$i-1];
						  
						  if($inp_gender == 2)
							$inp_gender_name = 'Male';
							
						  if($inp_gender == 1)
							$inp_gender_name = 'Female';
							
							if($i > 1)
							{
								$html .= '<tr><td colspan="7" style="border-bottom:1px solid #e0e0e0"></td></tr>';
							}
							$html .= '<tr>
								<td>'.$inp_name.'</td>
								<td>'.$inp_gender_name.'</td>
								
								<td>'.getRelationship($inp_rel).'</td>
								<td>'. $inp_dob.'</td>
								<td>'. $inp_occup.'</td>
								<td>'. $inp_iqma.'</td>
								<td>'. $inp_chron_ds.'</td>
							</tr>';
					  }
					 $html .= '</tbody>
				  </table>';
			}
			else
			{
				$html .= '<div class="row1">
					<lable>No Insured persons added.</lable>
				</div>
				<div class="clear" style="height:5px;"></div>';
			}
			
			$html .= '<div class="clear" style="height:30px;"></div>
			
            <div class="row1">
                <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong style="width: 147%;">Document Attached</strong></lable>
            </div>
			<div class="clear" style="height:1px;"></div>';
			
			if(!empty($attachments))
			{
				foreach($attachments as $key=>$attachment)	
				{
					$html .= '<div class="row1" style="float:left;width: 48%;clear: inherit;">
						<lable>Document Title :</lable>
						<span>'. $attachment['atch_title'].'</span>
					</div>
				
					<div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;">
						<lable>Attachment :</lable>
						<span>'. $attachment['atch_file'].'</span>
					</div>
						
					<div class="clear" style="height:30px;">&nbsp;</div>';
				}
			}
			else
			{
				$html .= '<div class="row1">
					<lable>No document attached.</lable>
				</div>
				<div class="clear" style="height:5px;"></div>';
			}
			
			$html .= '<div class="clear" style="height:25px;">&nbsp;</div>
			
		</div>
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