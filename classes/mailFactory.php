<?php
// class library for mailing activity
class mailFactory {
	
	// vars
	public $flag;
	
	// methods	
	function first_signup($to,$emp_id,$from = "info@maasinfotech.com")
	{
		// predefined mail variables
		// header set up
		
		//$contents1 = getEmailContents::getEmailContents_superAdmin(1);
		
		//$activation_link = BASE_URL."signup.php?acode=".base64_encode($acode)."&amp;USER=".base64_encode($emp_id)."&amp;st=1";
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from;
		
		
		$subject = "Account Creation Successful : Very Venice";
		$message = "Dear Artist,<br><br>You have successfully created your Account on Very Venice.<br>You will be able to log into the site after confirmation by Administarator.<br>";
		
		
		
		$site_fullpath = realpath(dirname(__FILE__));
		$site_path= str_replace('classes','',$site_fullpath);
		$templet_path=$site_path.'template';
	
		$file=$templet_path."/template.html";
		$fp=fopen($file,'r');
		$vcontent=fread($fp,filesize($file));
		$content=ereg_replace('xmsgx',$message,$vcontent);	
		
		
		if(mail($to,$subject,$content,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	
	function first_signup_backup($to,$emp_id,$from = "info@maasinfotech.com")
	{
		// predefined mail variables
		// header set up
		
		//$contents1 = getEmailContents::getEmailContents_superAdmin(1);
		
		//$activation_link = BASE_URL."signup.php?acode=".base64_encode($acode)."&amp;USER=".base64_encode($emp_id)."&amp;st=1";
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from;
		$subject = "Account Creation Successful : Very Venice";
		$message = "Dear Artist,<br><br>You have successfully created your Account on Very Venice.<br>You will be able to log into the site after confirmation by Administarator.<br><br>With Regards,<br>Very Venice";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	
		// methods
	function first_signup_error($to,$from = "admin@ollyspages.com")
	{
		// predefined mail variables
		// header set up
		
		$contents1 = getEmailContents::getEmailContents_superAdmin(1);
		$activation_link = BASE_URL."signup.php?phase=phase_four&st=4&sts=failed";
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Email Verification: Olly's Pages";
		$message = "Dear User,<br><br>".$contents1['contents']."<br/>Verification Link:<br>==========================================<br><a href='".$activation_link."' target='_blank'>".$activation_link."</a><br>==========================================<br><br>With Regards,<br>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	
	
	// Account Confirmation email
	function signUp_confirmation($to,$user_name,$from = "admin@ollyspages.com")
	{
		// predefined mail variables
		// header set up
		$contents1 = getEmailContents::getEmailContents_superAdmin(2);
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Account Activation Confirmation: Olly's Pages";
		$message = "Dear ".$user_name.",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	
	// company/branch is not serviced..
	function companyNotServiced($to,$company,$from = "admin@ollyspages.com")
	{
		// predefined mail variables
		// header set up
		$contents1 = getEmailContents::getEmailContents_superAdmin(3);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Account Creation Failed: Olly's Pages";
		$message = "Dear ".$to.",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
		// company/branch is not serviced..
	function sendPassLink($to,$company,$from = "admin@ollyspages.com")
	{
		// predefined mail variables
		// header set up
		$contents1 = getEmailContents::getEmailContents_superAdmin(3);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Account Creation Failed: Olly's Pages";
		$message = "Dear ".$to.",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
	}
	
	function companyNotRegistered($to,$company,$from = "admin@ollyspages.com")
	{
		// predefined mail variables
		// header set up
		$contents1 = getEmailContents::getEmailContents_superAdmin(8);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Company Changed Sucessfully: Olly's Pages";
		$message = "Dear ".$_SESSION['uname'].",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	
	//send link to mail change password
function emplresetpassword($to,$uid,$company,$name,$from = "admin@ollyspages.com")
	{
		// predefined mail variables
		// header set up
		$uid=base64_encode($uid);
	    //$todays_date = date("Y-m-d H:i:s");
        //$exp_date=date("Y-m-d H:i:s", strtotime ("+2 hour"));
		//$currenttime = date('G:i');
        $expttime = date('G:i', strtotime('+2 hours'));
        $convert_sec = strtotime($expttime);
     	$expiration_date = base64_encode($convert_sec);
		$contents1 = getEmailContents::getEmailContents_superAdmin(9);
		$password_link = "http://www.maasinfotech24x7.com/ollyspages/reset_password.php?exp=$expiration_date&uid=$uid";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Password reset link: Olly's Pages";
		$message = "Dear ".$name.",<br><br>".$contents1['contents']."Password Link:<br>==========================================<br><a href='".$password_link."' target='_blank'>".$password_link."</a><br>==========================================<br><br>With Regards,<br>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
	}
	//send link to adminmail wheree admin will change password
	function adminresetpass($to,$uid,$name,$company,$from = "admin@ollyspages.com")
	{
		$uid=base64_encode($uid);
        $expttime = date('G:i', strtotime('+2 hours'));
        $convert_sec = strtotime($expttime);
     	$expiration_date = base64_encode($convert_sec);
		//$contents1 = getEmailContents::getEmailContents_superAdmin(9);
		$password_link = "http://www.maasinfotech24x7.com/ollyspages/admin/admin_reset_password.php?exp=$expiration_date&uid=$uid";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n";
		$subject = "Password reset link: Olly's Pages";
		$message = "Dear Administrator,<br><br> You can click on the following link and reset  ".$name." Password.<br>The Password Link is given below <br>==========================================<br><a href='".$password_link."' target='_blank'>".$password_link."</a><br>==========================================<br><br>With Regards,<br>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
	}
	//send mail to admin which  user not register
	function reg_failed($email,$fname,$lname,$from = "admin@ollyspages.com")
	{
		$to="admin@ollyspages.com";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n";
		$subject = "User registration - Company not available: Olly's Pages";
		$message = "Dear Administrator,<br><br> ".$fname." ".$lname." was register but the company brach not found,<br>The company details is given below <br><br> Company Name:<strong>".$email."</strong><br>
		<br>With Regards,<br>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
	}
	//End
	function vendor_resetpassword($to,$from = "admin@ollyspages.com",$key)
	{
		// predefined mail variables
		// header set up
		$todays_date = date("Y-m-d H:i:s", strtotime ("+2 hour"));
		$exp_date= strtotime($todays_date);
		$contents1 = getEmailContents::getEmailContents_superAdmin(16);
		$password_link = "http://www.maasinfotech24x7.com/ollyspages/reset-password.php?type=v&id=".$key."&reset_id=".$exp_date;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Password reset link: Olly's Pages";
		$message = "Dear User,<br><br>".$contents1['contents']."Password Link:<br>==========================================<br><a href='".$password_link."' target='_blank'>".$password_link."</a><br>==========================================<br><br>With Regards,<br>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
	}
	
		function vendor_program($to,$from)
	  {
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n";
		$subject = "know more about our vendor program";
		$message = "Dear Administrator,<br><br> ".$from." wants to know about Ollyspages Vendor Program.<br>
		 <br>With Regards,<br>Ollyspages.com";
		  if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
	}
	
	function vendor_password_success($to,$from = "admin@ollyspages.com",$name)
	{
		// predefined mail variables
		// header set up
		$todays_date = date("Y-m-d H:i:s");
		$contents1 = getEmailContents::getEmailContents_superAdmin(17);
		$password_link = "http://www.maasinfotech24x7.com/ollyspages/reset-password.php?type=v&id=".$key;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Password reset successful: Olly's Pages";
		$message = "Dear ".$name.",<br><br>".$contents1['contents']."<br><br>With Regards,<br>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
	}
	
	
		function pswResetConfrm($to,$company,$name,$from = "admin@ollyspages.com")
	    {
		// predefined mail variables
		// header set up
		$contents1 = getEmailContents::getEmailContents_superAdmin(10);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Password reset confirmation: Olly's Pages";
		$message = "Dear ".$name.",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	
	function adminPswResetConfrm($to,$company,$name,$from = "admin@ollyspages.com")
	    {
		// predefined mail variables
		// header set up
		//$contents1 = getEmailContents::getEmailContents_superAdmin(10);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n";
		$subject = "Password reset confirmation: Olly's Pages";
		$message = "Dear Administrator,<br/><br/>Congratulations..!!  ".$name." account Password is successfully Changed.<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
		function forgotconfirmMsg($to,$company,$name,$from = "admin@ollyspages.com")
	    {
		// predefined mail variables
		// header set up
		$contents1 = getEmailContents::getEmailContents_superAdmin(10);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Password Changed confirmation: Olly's Pages";
		$message = "Dear ".$name.",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
		function news_update($to,$uname,$content,$from = "admin@ollyspages.com")
	    {
		// predefined mail variables
		// header set up
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n";
		$subject = "Ollys Pages News Update: Olly's Pages";
		$message = "Dear ".$uname.",<br/><br/> ollys pages news updated,The updated news is given below<br/>".$content."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	function terminate_account($to,$company,$name,$from = "admin@ollyspages.com")
	{
		// predefined mail variables
		// header set up
		$contents1 = getEmailContents::getEmailContents_superAdmin(11);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Termination confirmation: Olly's Pages";
		$message = "Dear ".$name.",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	function account_update($to,$company,$name,$from = "admin@ollyspages.com")
	{
		// predefined mail variables
		// header set up
		$contents1 = getEmailContents::getEmailContents_superAdmin(8);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Account updated: Olly's Pages";
		$message = "Dear ".$name.",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
	}
	function accountUpdated($to,$from = "admin@ollyspages.com")
	{
		$contents1 = getEmailContents::getEmailContents_superAdmin(15);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Account Updated: Olly's Pages";
		$message = "Dear ".$to.",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	function accountTerminated($to,$from = "admin@ollyspages.com")
	{
		$contents1 = getEmailContents::getEmailContents_superAdmin(18);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Account Terminated: Olly's Pages";
		$message = "Dear ".$to.",<br/><br/>".$contents1['contents']."<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	
	function itemDelivered($to,$from = "admin@ollyspages.com",$orderId,$user,$amt)
	{
		$contents1 = getEmailContents::getEmailContents_superAdmin(6);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Order Delivered Successfully : Olly's Pages";
		$message = "Dear ".$user.",<br/><br/>
		".$contents1['contents']."
		<br><br>
		<strong>Order Details</strong><br>
		<strong> Order Id :</strong> ".$orderId."<br>
		<strong> Price :</strong> $".$amt."
		<br/><br/>
		With Regards,
		<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
	}
	function itemDeliveredAdmin($vid,$from = "admin@ollyspages.com")
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n";
		
		$v = getVendor($vid);
		
		$to = 'admin@ollyspages.com';
		
		$vname = $v->vendor_name;
		$subject = "Order Delivered By ".$vname." : Olly's Pages";
		$message = "Dear Admin,<br/><br/>
		".$vname." has delivered his orders for ".date('d-m-Y')."
		<br/><br/>
		With Regards,
		<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
		
		
		//$contents1 = getEmailContents::getEmailContents_superAdmin(6);
		
		
		
	}
	
	function itemCancelled($to,$orderId,$user,$amt,$from = "admin@ollyspages.com")
	{
		$contents1 = getEmailContents::getEmailContents_superAdmin(5);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Order Cancelled : Olly's Pages";
		$message = "Dear ".$user.",
		<br/><br/>".$contents1['contents']."
		<br><br><strong> Cancelled Order Details</strong><br>
		<strong> Order Id :</strong> ".$orderId."<br>
		<strong> Price :</strong> $".$amt."
		<br/><br/>With Regards,<br/>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else{
		return 0;
		}
	}
	
	
	function reset_password_vendor($to,$from = "admin@ollyspages.com",$key)
	{
		// predefined mail variables
		// header set up
		//$todays_date = date("Y-m-d H:i:s");
        //$exp_date=date("Y-m-d H:i:s", strtotime ("+2 hour"));
        //$today = strtotime($todays_date);
     	//$expiration_date = strtotime($exp_date);
		//$currenttime = date('G:i');
        //$expttime = date('G:i', strtotime('+2 hours'));
		//$exptime=base64_encode($expttime);
		$expttime = date('G:i', strtotime('+2 hours'));
        $convert_sec = strtotime($expttime);
     	$expiration_date = base64_encode($convert_sec);
		
		$contents1 = getEmailContents::getEmailContents_superAdmin(16);
		$password_link = "http://www.maasinfotech24x7.com/ollyspages/reset-vendor-password.php?type=v&id=".$key."&exp=".$expiration_date;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Password reset link: Olly's Pages";
		$message = "Dear User,<br><br>".$contents1['contents']."Password Link:<br>==========================================<br><a href='".$password_link."' target='_blank'>".$password_link."</a><br>==========================================<br><br>With Regards,<br>Ollyspages.com";
		if(mail($to,$subject,$message,$headers) == true)
		{
		  return 1;
		}
		else
		{
		  return 0;
		}
	}
	
	 function sendOrderUpdate($to,$order_id,$amt,$name,$from = "admin@ollyspages.com")
	   {
		//$contents1 = getEmailContents::getEmailContents_superAdmin(4);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Order Successfully Updated: Olly's Pages";
		$message = "Dear ".$name.",<br/><br/>Your order with Order Id ".$order_id." has been updated as per your request.
		<br><br>Details<br/>Order ID: <strong>".$order_id."</strong><br/>Amount: <strong>$".$amt."</strong><br/><br/>With Regards,<br/>Ollyspages.com";
		 if(mail($to,$subject,$message,$headers) == true)
		  {
		   return 1;
		  }
		  else{
		  return 0;
		  }
		}
	
	
	   function SendOrderConfirmation($to,$order_id,$amt,$name,$from = "admin@ollyspages.com")
	   {
		$contents1 = getEmailContents::getEmailContents_superAdmin(4);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Order Successfully Completed: Olly's Pages";
		$message = "Dear ".$name.",<br/><br/>".$contents1['contents']."<br/>Order ID: <strong>".$order_id."</strong><br/>Amount: <strong>$".$amt."</strong><br/><br/>With Regards,<br/>Ollyspages.com";
		 if(mail($to,$subject,$message,$headers) == true)
		  {
		   return 1;
		  }
		  else{
		  return 0;
		  }
		}
		 
	   function sendPaidConfirmation($to,$amt,$name,$from = "admin@ollyspages.com")
	   {
		$contents1 = getEmailContents::getEmailContents_superAdmin(14);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Payment delivered : Olly's Pages";
		$message = "Dear ".$name.",<br/><br/>".$contents1['contents']."<br/><br/>Amount: <strong>$".$amt."</strong><br/><br/>With Regards,<br/>Ollyspages.com";
		 if(mail($to,$subject,$message,$headers) == true)
		  {
		   return 1;
		  }
		  else{
		  return 0;
		  }
		}
		
	   function sendPaidConfirmation2($to,$name,$from = "admin@ollyspages.com")
	   {
		//$contents1 = getEmailContents::getEmailContents_superAdmin(14);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n";
		$subject = "Payment delivered to ".$name.": Olly's Pages";
		$message = "Dear Admin,<br/><br/>Total collections for ".date('M/d/Y')." has been paid to ".$name." by Olly's Pages.</strong><br/><br/>With Regards,<br/>Ollyspages.com";
		 if(mail($to,$subject,$message,$headers) == true)
		  {
		   return 1;
		  }
		  else{
		  return 0;
		  }
		}
		
		
		
		function addNewItem($to,$name,$item_img,$item_name,$item_price,$item_desc,$from = "admin@ollyspages.com")
	   {
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n";
		$subject = "New Item Added: Olly's Pages";
		 $message = "
		 <span align='left'>&nbsp;&nbsp;Dear <strong> $name</strong></span><br/>
		<div  style='float:left;width:616px;padding:12px; background:#EEEEEE;margin:7px;'>
  <div  style='width:172px;float:left;margin-right:14px;'> <img src='http://www.maasinfotech24x7.com/ollyspages/vendor/images/item_images/$item_img' width='172' height='171' border='0' /></div>
  <div style='width:430px;float:left;'>
    <div style='width:430px;float:left;'>
      <div  style='width:300px; margin-right:10px; float:left' align='left'>
        <h5  style='font-size: 20px;margin:0px;padding:0px;text-decoration:none;color:#000000;' >$item_name</h5>
      </div>
      <div  style='width:120px; float:left' align='right'>
        <h3  style='font-size: 32px;margin:0px;padding:0px;text-decoration:none;color:#dc4a23;'>$item_price</h3>
      </div>
    </div>
    <div  style='width:430px;float:left;' align='left'>
      <h6  style='	font-family: Arial, Helvetica, sans-serif;font-size: 14px;font-weight: normal;color: #666666;text-decoration: none;padding:9px 0px 9px 0px;margin:0px;'>$item_desc</h6>
    </div>
</div>
</div>
<div  style='float:left;width:616px;padding:12px;  margin:7px;' align='left'><span style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; font-weight:bold;'>With Regards,</span><br/><a href='http://www.maasinfotech24x7.com/ollyspages' target='_blank'>
Ollyspages.com </a></div>";
		 if(mail($to,$subject,$message,$headers) == true)
		  {
		   return 1;
		  }
		  else{
		  return 0;
		  }
		}
		function daily_email($to,$uname,$from = "admin@ollyspages.com")
	   {
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .="From: ".$from. "\r\n".$contents1['bcc'];
		$subject = "Daily Email status: Olly's Pages";
		$message = "Dear ".$uname.",<br/><br/>plzzzz<br/><br/><br/>With Regards,<br/>Ollyspages.com";
		 if(mail($to,$subject,$message,$headers) == true)
		  {
		   return 1;
		  }
		  else{
		  return 0;
		  }
		}
}

class getEmailContents{

	public function getEmailContents_superAdmin($id)
	{
	   $contents_var = dbFactory::recordFetch($id,'me_notification_setting:id');
		$contents = $contents_var['notification_email_body'];
		$bcc = $contents_var['bcc_superadmin'];
		if($bcc == '1')
		{
			 $sql = mysql_query("SELECT * FROM me_admin WHERE is_superadmin = '1'");
			 $num = mysql_num_rows($sql);
			 while($xx = mysql_fetch_assoc($sql))
			 {
			   $bcc_admin .= $xx['uname'].",";
			 }
			 if($num > 0){
			  $bcc_admin1 = 'Bcc:'. $bcc_admin . '\r\n';
			 }else{
			  $bcc_admin1 = '';
			 }
		}
		else
		{
		 	$bcc_admin1 = '';
		}
		$contents1 = array('contents' => $contents,'bcc' => $bcc_admin1);
		
		return $contents1;
		
	}
	
}
?>