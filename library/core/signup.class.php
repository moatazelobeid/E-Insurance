<?php
// Employee management
// class name: Signup
class Signup {
	
	// vars
	public $employee_id;
	public $flag;
	

	// Employee First Signup
	public function signup_1(){
		// get posted data
		$datas = $_POST;
		unset($datas['signup']);
        unset($datas['term_checkbox']);   
		unset($datas['emp_fname']);
		unset($datas['emp_lname']);
		unset($datas['emp_pwd']);
		unset($datas['emp_repwd']);
		unset($datas['emp_uname']);
		$uname = $datas['emp_uname1'];
		$lname = $datas['emp_lname1'];
		unset($datas['emp_uname1']);
		unset($datas['emp_lname1']);
		unset($datas['submit_step_3']);
		// check for domain extension
		$dom_ext = explode('@',$datas['emp_email']);
		if($this->dom_exists($dom_ext['1']) == '1')
		{
		   $acode = $this->randomPrefix(20,EMPLOYEETBL,'unique_gen_code');
		   // insert to db and send an email to that user..
		   $result = dbFactory::recordInsert($datas,EMPLOYEETBL,'emp_email',array('unique_gen_code'=>$acode,'emp_fname' => $uname,'emp_lname' =>$lname));
		   if($result == '1')
		   {
		       $emp_id = mysql_insert_id();
		       // send an email to user (email verification)..
			   $email = mailFactory::first_signup($datas['emp_email'],$acode,$emp_id);
			   if($email == '1')
			   {
			     $this->flag = 1;		// success
			     return 1;
			   }
			   else
			   {
			     $this->flag = 2;	  // fail
		         return 2;
			   }
		   }
		   else if($result == '3')
		   {
		    $this->flag = 4;	  // fail
		     return 4;
		   }
		   else
		   {
		    $this->flag = 2;	  // fail
		     return 2;
		   }
		  }
		  else
		  {
		       // send an email to user (company/branch not serviced.)..
			   //$email = mailFactory::companyNotServiced($datas['emp_email'],'company');
			   $email = mailFactory::first_signup_error($datas['emp_email']);
			   if($email == '1')
			   {
			      $this->flag = 2;	  // fail
		          return 3;
			   }
		    
		  }
		
	}
	
		// Employee Regd. 2nd Phase..update to database..
	public function signup_2($cond = array())
	{
		// get posted data
		$datas = $_POST;
		unset($datas['submit_step_2']);
        unset($datas['emp_repwd']);
		unset($datas['emp_uname1']);
		unset($datas['emp_email']);
		unset($datas['submit_step_3']);
		$password = base64_encode($datas['emp_pwd']);
		unset($datas['emp_pwd']);
		   // update to db
		   $result = dbFactory::recordUpdate($cond,$datas,EMPLOYEETBL,array('emp_pwd' => $password,'active_status'=>1,'create_date'=>date('Y-m-d h:i:s')));
		   if($result == '1')
		   {
		     $this->flag = 1;	  // update successful
		     return 1;
			 }
		   else
		   {
		     $this->flag = 2;	  // fail
		     return 2;
		   }
		  }
	
		
		// Employee Regd. 2nd Phase..update to database..
	public function signup_3($cond = array(),$emp_id,$comp_id)
	{
		// get posted data
		$datas = $_POST;
		unset($datas['submit_step_2']);
        unset($datas['emp_repwd']);
		unset($datas['emp_uname1']);
		unset($datas['emp_email']);
		unset($datas['signup']);
        unset($datas['term_checkbox']);   
		unset($datas['emp_fname']);
		unset($datas['emp_lname']);
		unset($datas['emp_pwd']);
		unset($datas['emp_repwd']);
		unset($datas['emp_uname']);
		unset($datas['emp_uname1']);
		unset($datas['submit_step_3']);
		   // update to db
		   $result = dbFactory::recordUpdate($cond,array('company_id' => $comp_id,'emp_id' => $emp_id,'emp_status' => '1'),EMPLOYEETBL);
		   if($result == '1')
		   {
		   
		   // send an email to user (email verification)..
			// get emp email..
			$email_usr = dbFactory::recordFetch($cond['id'],'me_employee:id');
			$email_id = $email_usr['emp_email'];
			$emp_name = $email_usr['emp_fname']." ".$email_usr['emp_lname'];
			$email = mailFactory::signUp_confirmation($email_id,$emp_name);
			if($email == '1')
			 {
			   $this->flag = 1;	  // update successful
		       return 1;
		     }
		   }
		   else
		   {
		     $this->flag = 2;	  // fail
		     return 2;
		   }
		}
		
		public function signup_failed($user_id)
		{
		    $email_usr = dbFactory::recordFetch($user_id,'me_employee:id');
			$email_id = $email_usr['emp_email'];
			$email = mailFactory::companyNotServiced($email_id,'company/branch');
			if($email == '1')
			 {
			   $this->flag = 1;	  // successful mail sending..
		       return 1;
			 }else{
			   $this->flag = 2;	  // failed sending mail
		       return 2;
			 }
		
		}
      	public function company_changed($email)
		{
			$email = mailFactory::companyNotRegistered($email,'Account updated');
			if($email == '1')
			 {
			   $this->flag = 1;	  // successful mail sending..
		       return 1;
			 }else{
			   $this->flag = 2;	  // failed sending mail
		       return 2;
			 }
		
		}
	//send reset password link
	 	public function reset_password($uid,$mail,$name)
		{
			$email = mailFactory:: emplresetpassword($mail,$uid,'Password reset link',$name);
			if($email == '1')
			 {
			   $this->flag = 1;	  // successful mail sending..
		       return 1;
			 }else{
			   $this->flag = 2;	  // failed sending mail
		       return 2;
			 }
		
		}
		//send password reset confirmation msg
			//send reset password link
	 	public function pass_reset_confm($mail,$name)
		{
			$email = mailFactory:: pswResetConfrm($mail,'Password reset confirmation',$name);
			if($email == '1')
			 {
			   $this->flag = 1;	  // successful mail sending..
		       return 1;
			 }else{
			   $this->flag = 2;	  // failed sending mail
		       return 2;
			 }
		
		}
		//send forgot password confirmation msg
	 	public function forgot_pass_confirm($mail,$name)
		{
			$email = mailFactory:: forgotconfirmMsg($mail,'Password Changed Confirmation confirmation',$name);
			if($email == '1')
			 {
			   $this->flag = 1;	  // successful mail sending..
		       return 1;
			 }else{
			   $this->flag = 2;	  // failed sending mail
		       return 2;
			 }
		
		}
	// checking for company exists /registered or not..
	public function dom_exists($domain)
	{
	  if(mysql_num_rows(mysql_query("SELECT c_url FROM me_company WHERE c_url = '".$domain."' AND c_status = '1'")))
	  {
	    return '1';
	  }else
	  {
	    return '0';
	  }
	}
		// random number generator
	public function randomPrefix($length,$table,$field)
	{
		global $db;	
		$random= "";
		srand((double)microtime()*1000000);
		$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
		$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
		$data .= "0FGH45OP89";
		for($i = 0; $i < $length; $i++)
		{
			$random .= substr($data, (rand()%(strlen($data))), 1);
		}
		$query="select $field from $table where $field='$random'";
		$res=mysql_query($query);
		if(mysql_num_rows($res)>0)
		{
			randomPrefix(20);
		}
		else
		{
			return $random;	
		}
    }
	
	// getting the company locations from emp_id's domain name.
	public function getCompanyLoocaton($emp_id)
	{
	  $sqlQr = mysql_fetch_object(mysql_query("SELECT emp_email FROM ".EMPLOYEETBL." WHERE id = '$emp_id'"));
	  $dom_ext = explode('@',$sqlQr->emp_email);
	  $sqlQuery = mysql_query("SELECT * FROM me_company WHERE c_url = '".$dom_ext['1']."' AND c_status = '1'");
	 // return "SELECT * FROM me_company WHERE c_url = '".$dom_ext['1']."' AND c_status = '1'";
	 if(mysql_num_rows($sqlQuery) > 0)
	  {
	    //$arr123 = mysql_fetch_assoc($sqlQuery);
	    return $sqlQuery;
	  }else
	  {
	    return '0';
	  }
	}
	//geeting the company location from emp. email's domain name. after login
		public function getCngeComnyLocton($email)
	{
	  $dom_ext = explode('@',$email);
	  $sqlQuery = mysql_query("SELECT * FROM me_company WHERE c_url = '".$dom_ext['1']."' AND c_status = '1'");
	 // return "SELECT * FROM me_company WHERE c_url = '".$dom_ext['1']."' AND c_status = '1'";
	 if(mysql_num_rows($sqlQuery) > 0)
	  {
	    //$arr123 = mysql_fetch_assoc($sqlQuery);
	    return $sqlQuery;
	  }else
	  {
	    return '0';
	  }
	}
	//  update existing vendor	
	public function update($cond = array()){
	
	// get posted data
		$datas = $_POST;
		unset($datas['update']);
		
		// set local settings
		//$datas['v_pwd'] = base64_encode($datas['v_pwd']);

      	$phone = $datas['v_phone1']."-".$datas['v_phone2']."-".$datas['v_phone3'];
	  
	 	unset($datas['v_phone1']);
	 	unset($datas['v_phone2']);
	 	unset($datas['v_phone3']);
		unset($datas['v_repwd']);
		
		//print_r($datas);
		
		// insert into vendor
		$result = dbFactory::recordUpdate($cond,$datas,VENDORTBL,array('v_phone'=>$phone,'modify_date'=>date('Y-m-d h:i:s')));
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("Vendor Updated Successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Vendor updation failed");
		}
		
	}
	
	    // delete vendor from list
		public function delete($idvals, $tables = array()){
		// delete record
		$count = 0;
		foreach($idvals as $idval){
			$result = dbFactory::recordDelete($idval,$tables);
			if($result == 1)
			$count++;
		}
		if($count > 0){
			$this->flag = 1;		// success
			return message::setMsg("Vendor(s) Successfully Deleted");
		}
	}
	
	
	// set vendor status	
    public function disabled($idvals, $table, $column, $data = array())
	{
		 // disabled record
		 $count = 0;
		 foreach($idvals as $idval)
		 {
		   $result = dbFactory::recordUpdate(array($column => $idval),$data,$table);
		   if($result == '1')
			  $count++;
		 }
		 if($count > 0)
		 {
		   $this->flag = 1;		// success
		   return message::setMsg("Record(s) Disabled Successfully");
		 }
	}
	
}
?>