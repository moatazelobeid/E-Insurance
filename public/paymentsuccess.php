<?php
//unset($custom);
//unset($_SESSION['nvpReqArray']);

//session_destroy();

// call class instance
$db = new dbFactory();

include('PHPMailer/PHPMailerAutoload.php');


//echo '<pre>'; print_r($_SESSION); echo '</pre>';
//echo '<pre>'; print_r($_POST); echo '</pre>'; //exit;
//echo '<pre>'; print_r($_GET); echo '</pre>'; //exit;

function getCoverAmount($id,$package_no)
{
	$res = mysql_fetch_array(mysql_query("select cover_amt from ".PACKAGECOVER." where cover_id=".$id." and package_no = '".$package_no."'"));
	return number_format($res['cover_amt'],2);
}


//if(isset($_POST['txn_id']) && $_POST['txn_id'] != '')
if(!empty($_SESSION['motor']))
{
	//$_POST['payment_status'];
	
	if($_SESSION['motor']['Vehicle']['policy_type_id'] == 2)
	{
		$_SESSION['motor']['Vehicle']['vehicle_year_made'] = $_SESSION['motor']['Vehicle']['vehicle_made_year'];	
	}
	
	unset($_SESSION['motor']['Your_details']['vehicle_made_year']);
	unset($_SESSION['motor']['Vehicle']['vehicle_made_year']);
	unset($_SESSION['motor']['Vehicle']['agency_deduct_amt']);
	
	$fname = $_SESSION['motor']['Your_details']['fname'];
	$lname = $_SESSION['motor']['Your_details']['lname'];
	$phone_mobile = $_SESSION['motor']['Your_details']['phone_mobile'];
	$email = $_SESSION['motor']['Your_details']['email'];
	$dob = $_SESSION['motor']['Your_details']['dob'];
	$dob = date("Y-m-d", strtotime($dob));
	
	$driver_license_issue_date = $_SESSION['motor']['Vehicle']['driver_license_issue_date'];
	$driver_license_issue_date = date('Y-m-d', strtotime($driver_license_issue_date));
	
	unset($_SESSION['motor']['Vehicle']['driver_license_issue_date']);
		
	$package_no = $_SESSION['motor']['Package'];
	
	//on payment success
	
	if(!empty($_POST['txn_id']))
		$transaction_id =  $_POST['txn_id'];
	else
		$transaction_id =  rand();
	
	unset($_SESSION['motor']['Your_details']['is_driver']);
	unset($_SESSION['motor']['Your_details']['dob']);

	//total policy amount
	$total_payment_amount = $_SESSION['motor']['Total_Package_Amount'];
	
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
			//$login['login_status'] =  '1';
			$login['is_active'] =  '1';
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
	
	if(!empty($customer_code))
	{
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
		
		$policy_master['package_amt'] = $_SESSION['motor']['Package_Amount'];
		
		$policy_master['additional_package_amt'] = $_SESSION['motor']['Additional_Package_Amount'];
		
		$policy_master['agency_deduct_amt'] = $_SESSION['motor']['Agency_Deduct_Amount'];
		
		$policy_master['customer_id'] = $customer_code;
		$policy_master['policy_class_id'] = $_SESSION['motor']['Vehicle']['policy_class_id'];
		//$policy_master['policy_class_id'] = 1;
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
			$policy_motor['driver_license_issue_date'] = $driver_license_issue_date;
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
			
			unset($policy_motor['vehicle_made_year']);
			unset($policy_motor['fname']);
			unset($policy_motor['lname']);
			
			//echo '<pre>'; print_r($policy_motor); echo '</pre>'; exit;
			
			//Insert into policy motor table
			$insert_policy_motor = $db->recordInsert($policy_motor,POLICYMOTOR,'');
			
			if($insert_policy_motor == 1)
			{
				//insert package covers
				
				if(!empty($_SESSION['motor']['Package_Covers']))
				{
					$additional_pkg_covers = $_SESSION['motor']['Package_Covers'];	
					
					foreach($additional_pkg_covers as $additional_pkg_cover)
					{
						$policy_cover = '';
						$policy_cover['policy_no'] = $policy_no;
						$policy_cover['package_no'] = $package_no;
						$policy_cover['customer_id'] = $customer_code;
						$policy_cover['cover_id'] = $additional_pkg_cover;
						$policy_cover['cover_amt'] = getCoverAmount($additional_pkg_cover,$package_no);
						//$policy_cover['coverage'] = $pkg_cover['coverage'];
						
						//Insert into policy cover table
						$insert_policy_cover = $db->recordInsert($policy_cover,POLICYCOVERS,'');
					}
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
				$payment_data['payment_processor'] = 'paypal';
				
				if(!empty($_POST['payment_status']))
				{
					if(($_POST['payment_status'] == 'Completed') || ($_POST['payment_status'] == 'Paid'))
					{
						$payment_data['payment_status'] = '1';
					}
					else
					{
						$payment_data['payment_status'] = '0';
					}
				}
				else
				{
					$payment_data['payment_status'] = '1';
				}
				
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
					
					//session_destroy();
					
					unset($_SESSION['motor']);
					//unset($_SESSION['nvpReqArray']);
					
					//header('Location: '.BASE_URL.'index.php?page=paymentsuccess');	
				}	
			}
		}
	
	}
	
}

if(!empty($_SESSION['medical']))
{
	$name = $_SESSION['medical']['Step3']['name'];
	$phone_mobile = $_SESSION['medical']['Step3']['phone_mobile'];
	$email = $_SESSION['medical']['Step3']['email'];
	$dob = $_SESSION['medical']['Step3']['dob'];
	$dob = date("Y-m-d", strtotime($dob));
		
	$package_no = $_SESSION['medical']['Step2']['package_no'];
	
	//on payment success
	
	if(!empty($_POST['txn_id']))
		$transaction_id =  $_POST['txn_id'];
	else
		$transaction_id =  rand();
	
	unset($_SESSION['medical']['Step3']['dob']);
	unset($_SESSION['medical']['Step3']['name']);

	//total policy amount
	$total_payment_amount = $_SESSION['medical']['Total_Package_Amount'];
	
	//get customer code
	$customer_code = get_code(USERTBL,'customer_code','id');
	
	$salutation = $_SESSION['medical']['Step3']['title'];
	
	unset($_SESSION['medical']['Step3']['title']);
	//unset($_SESSION['medical']['Step3']['marital_status']);
	
	//Add customer
	$user = $_SESSION['medical']['Step3'];
	$user['salutation'] = $salutation; 
	$user['fname'] = $name; 
	$user['customer_code'] = $customer_code; 
	$user['dob'] = $dob;
	$user['created_date'] = date('Y-m-d H:i:s'); 
	
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
			//$login['login_status'] =  '1';
			$login['is_active'] =  '1';
			$pwd = rand();
			$login['pwd'] =  base64_encode($pwd);
			
			//insert into login table
			$insert_login = $db->recordInsert($login,LOGINTBL,'');
			
			$user_subject = 'Your Account Information.';
			$user_email_msg = 'Dear '.$name.'<br><br>Your Account is successfully created at '.SITE_NAME.'.<br>Please follow your login credentials below,<br><strong>Username:</strong>'.$email.'<br>'.'<strong>Password:</strong>'.$pwd.
			'<br><br>Regards,<br>'.SITE_NAME;
		
			//Email account details to the customer
			//mail($email,$subject,$msg);	

			$user_mail = new PHPMailer;
			
			$user_mail->From = SITE_EMAIL;
			$user_mail->FromName = SITE_NAME;
			$user_mail->addAddress($email, $name);
			
			$user_mail->isHTML(true);  // Set email format to HTML
			
			$user_mail->Subject = $user_subject;
			
			$user_mail->Body    = $user_email_msg;
			
			if(!$user_mail->send()) { }
		
		}
	}
	
	if(!empty($customer_code))
	{
		//Insert into policy master table
		//get policy no
		$policy_no = get_code(POLICYMASTER,'policy_no','id');
	
		//set policy master array
		$insured_period_startdate = $_SESSION['medical']['Policy']['insured_period_startdate'];
		$insured_period_enddate = $_SESSION['medical']['Policy']['insured_period_enddate'];
		
		$policy_master = '';
		
		$policy_master['insured_period_startdate'] = date("Y-m-d", strtotime($insured_period_startdate));
		$policy_master['insured_period_enddate'] = date("Y-m-d", strtotime($insured_period_enddate));
		$policy_master['policy_no'] = $policy_no;
		$policy_master['package_no'] = $package_no;
		
		$policy_master['package_amt'] = $_SESSION['medical']['Total_Package_Amount'];
		
		$policy_master['additional_package_amt'] = $_SESSION['medical']['Step2']['Additional_Package_Amount'];
		
		$policy_master['customer_id'] = $customer_code;
		$policy_master['policy_class_id'] = 3;
		
		$policy_master['doc_type_id'] = 1;
		$policy_master['doc_key'] = "AC/".date("Y")."/".$policy_no;
		$policy_master['quotation_key'] = $_SESSION['medical']['Quote_key'];
		$policy_master['policy_year'] = date('Y');
		$policy_master['insured_period_known'] = 'Yes';
		$policy_master['insured_period'] = 1;
		$policy_master['insured_period_type'] = 'year';
		$policy_master['insured_timezon'] = 'UAE';
		$policy_master['debit_account'] = 'Yes';
		$policy_master['insured_person'] = $name;
		$policy_master['payment_term'] = 1;
		$policy_master['registry_date'] = date('Y-m-d H:i:s');
		$policy_master['uw_year'] = date('Y');
		$policy_master['is_complete'] = 1;
		$policy_master['policy_by'] ='Online';
	
		//Insert into policy master table
		$insert_policy_master = $db->recordInsert($policy_master,POLICYMASTER,'');
		if($insert_policy_master == 1)
		{
			$policy_medical = '';
		
			$policy_medical['policy_class_id'] = 3;
			
			$policy_medical['title'] = $_SESSION['medical']['Step3']['title'];	
			$policy_medical['first_name'] = $_SESSION['medical']['Step1']['name'];	
			$policy_medical['occupation'] = $_SESSION['medical']['Step1']['occupation'];	
			$policy_medical['iqma_no'] = $_SESSION['medical']['Step1']['iqma_no'];	
			$policy_medical['nationality'] = $_SESSION['medical']['Step1']['nationality'];	
			$policy_medical['gender'] = $_SESSION['medical']['Step1']['gender'];	
			$policy_medical['network_class'] = $_SESSION['medical']['Step1']['network_class'];	
			$policy_medical['chronoc_diseases'] = $_SESSION['medical']['Step1']['chronoc_diseases'];	
			
			$policy_medical['is_canceled'] = 0;
			
			$policy_medical['email'] = $email;
			$policy_medical['mobile_no'] = $phone_mobile;
			$policy_medical['dob'] = $dob; 
			$policy_medical['country'] = $_SESSION['medical']['Step3']['country'];
			$policy_medical['customer_id'] = $customer_code;
			$policy_medical['policy_no'] = $policy_no;
			$policy_medical['package_no'] = $package_no;
		
			//Insert into policy motor table
			$insert_policy_medical = $db->recordInsert($policy_medical,POLICYMEDICAL,'');
			
			if($insert_policy_medical == 1)
			{
				//insert package covers
				
				if(!empty($_SESSION['medical']['Step2']['pkg_covers']))
				{
					$additional_pkg_covers = $_SESSION['medical']['Step2']['pkg_covers'];
					
					foreach($additional_pkg_covers as $additional_pkg_cover)
					{
						$policy_cover = '';
						$policy_cover['policy_no'] = $policy_no;
						$policy_cover['package_no'] = $package_no;
						$policy_cover['customer_id'] = $customer_code;
						$policy_cover['cover_id'] = $additional_pkg_cover;
						$policy_cover['cover_amt'] = getCoverAmount($additional_pkg_cover,$package_no);
						//$policy_cover['coverage'] = $pkg_cover['coverage'];
						
						//Insert into policy cover table
						$insert_policy_cover = $db->recordInsert($policy_cover,POLICYCOVERS,'');
					}
				}
				
				//Insert customer attachments
				if(!empty($_SESSION['medical']['Attachment']))
				{
					$atchments = $_SESSION['medical']['Attachment'];	
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
				
				//Insert customer attachments
				if($_SESSION['medical']['Step1']['total_insured_person'] > 0)
				{
					$total_insured_person = $_SESSION['medical']['Step1']['total_insured_person'];
					
					for($i=0; $i < $total_insured_person; $i++)
					{
						$inp_name = $_SESSION['medical']['Step1']['inp_name'][$i];
						$inp_gender = $_SESSION['medical']['Step1']['inp_gender'][$i];
						$inp_rel = $_SESSION['medical']['Step1']['inp_rel'][$i];
						$inp_dob = $_SESSION['medical']['Step1']['inp_dob'][$i];
						$inp_occup = $_SESSION['medical']['Step1']['inp_occup'][$i];
						$inp_iqma = $_SESSION['medical']['Step1']['inp_iqma'][$i];
						$inp_chron_ds = $_SESSION['medical']['Step1']['inp_chron_ds'][$i];
						
						if(!empty($inp_name) || !empty($inp_gender) || !empty($inp_rel) || !empty($inp_dob) || !empty($inp_occup) || !empty($inp_iqma) || !empty($inp_chron_ds))
						{
							$insured_person_data = '';
							
							$insured_person_data['customer_id'] = $customer_code;
							$insured_person_data['policy_no'] = $policy_no;
							$insured_person_data['add_date'] = date('Y-m-d H:i:s');
							
							$insured_person_data['name'] = $inp_name;
							$insured_person_data['gender'] = $inp_gender;
							$insured_person_data['relationship'] = $inp_rel;
							$insured_person_data['dob'] = date('Y-m-d',strtotime($inp_dob));
							$insured_person_data['occupation'] = $inp_occup;
							$insured_person_data['iqma_no'] = $inp_iqma;
							$insured_person_data['chronoc_disease'] = $inp_chron_ds;
							
							$insert_insured_person = $db->recordInsert($insured_person_data,MEDICAL_INSURED_PERSONS,'');	
						}
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
				$payment_data['payment_processor'] = 'paypal';
				
				if(!empty($_POST['payment_status']))
				{
					if(($_POST['payment_status'] == 'Completed') || ($_POST['payment_status'] == 'Paid'))
					{
						$payment_data['payment_status'] = '1';
					}
					else
					{
						$payment_data['payment_status'] = '0';
					}
				}
				else
				{
					$payment_data['payment_status'] = '1';
				}
				
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
					$mail->addAddress($email, $name);
					
					//Attach pdf document
					$dir = $_SERVER['DOCUMENT_ROOT'];
					$pdfdoc = $dir."/alsagr/upload/pdfReports/".$policy_no.".pdf";
					$mail->addAttachment($pdfdoc);  
					
					$mail->isHTML(true);  // Set email format to HTML
					
					$mail->Subject = 'Policy Purchase Confirmation.';
					
					$contact_us_link = '<a href="'.BASE_URL.'index.php?page=contact-us" target="_blank">contact us</a>';
					
					$email_content = 'Dear '.$name.'<br><br>You have successfully purchased Medical Insurance Policy at '.SITE_NAME.' with Policy No: '.$policy_no.'.<br><br>
					Your policy details are enclosed in the attached PDF below.<br>If you find any problem in getting your policy attachment, 
					<br>Please click here to '.$contact_us_link.'.<br><br>Regards,<br>'.SITE_NAME;
					
					$mail->Body    = $email_content;
					
					if(!$mail->send()) { 
					  /* echo 'Message could not be sent.';
					   echo 'Mailer Error: ' . $mail->ErrorInfo;*/
					}
					//session_destroy();
					
					//unset($_SESSION['medical']);
					//unset($_SESSION['nvpReqArray']);
					
					//header('Location: '.BASE_URL.'index.php?page=paymentsuccess');	
				}	
			}
		}
	
	}
	
}

?>

<div class="innrebodypanel">
        <div class="clearfix" style="height:15px;">.</div>
        <div class="innerwrap">
        
            
            <div class="clearfix" style="height:10px;"></div>
            
            <div class="notify successbox">
            <h1>Payment Success!</h1>
            <span class="alerticon"><img src="images/check.png" alt="checkmark"></span>
            <p>Thanks so much for your Payment in Alsgr Coporation. You will receive an email shortly to confirm your Payment.</p>
          </div>
          
            
         <div class="clearfix" style="height:250px;"></div>
        
        <div class="clearfix"></div>
        </div>
        <div class="clearfix" style="height:5px;"></div>
</div>