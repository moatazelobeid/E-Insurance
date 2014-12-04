<?php
// vendorf management
// class name: vendor
class user {
	
	// vars
	public $user_id;
	public $flag;
		// methods
	function __construct() {
		// generate vendor id
		$this->user_id = ucodeGenEmp(EMPLOYEETBL,'emp_id','id','91','7');
		return $this->user_id;
	}
	
   // methods
/*	function __construct() {
		// generate vendor id
		$this->emp_id = ucodeGen(EMPLOYEETBL,'emp_id','id','10','5');
		return $this->emp_id;
	}*/
	// save new vendor
    public function save(){
		// get posted data
		$datas = $_POST;
		unset($datas['save']);
		
		// set local settings
		$emp_pwd = base64_encode($datas['emp_pwd']);

      	$phone = $datas['emp_phone1']."-".$datas['emp_phone2']."-".$datas['emp_phone3'];
	     $company=$datas['company_id'];
	 	unset($datas['emp_phone1']);
	 	unset($datas['emp_phone2']);
	 	unset($datas['emp_phone3']);
		unset($datas['emp_repwd']);
		unset($datas['emp_pwd']);
		unset($datas['company_id']);
		// insert into user
		$comnyemail=trim($datas['emp_email']);
         $domain = explode('@',$comnyemail);
       $sql=mysql_num_rows(mysql_query("select * from me_company where c_url = '$domain[1]' AND c_status = '1'"));
	   $sqw=mysql_num_rows(mysql_query("SELECT emp_email FROM me_employee WHERE emp_email='$comnyemail'"));

        if($sql==0)
		{
		  return $flag = 0;
		}else if($sqw >0)
		{
		return $flag =3;
		}else{
		$result = dbFactory::recordInsert($datas,EMPLOYEETBL,'',array('emp_phone'=>$phone,'emp_pwd'=>$emp_pwd,'company_id'=>$company,'emp_status'=>1,'create_date'=>date('Y-m-d h:i:s')));
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("A new User added successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("user creation failed","0");
		}
	}
}	

	
	// update existing vendor
	public function update($cond = array()){
	
	// get posted data
		$datas = $_POST;
		unset($datas['update']);
		
		// set local settings
			$emp_pwd = base64_encode($datas['emp_pwd']);

      	$phone = $datas['emp_phone1']."-".$datas['emp_phone2']."-".$datas['emp_phone3'];
	     $company=$datas['company_id'];
	 	unset($datas['emp_phone1']);
	 	unset($datas['emp_phone2']);
	 	unset($datas['emp_phone3']);
		unset($datas['emp_repwd']);
		unset($datas['emp_pwd']);
		unset($datas['company_id']);
		
		//print_r($datas);
		
		// insert into vendor
		$result = dbFactory::recordUpdate($cond,$datas,EMPLOYEETBL,array('emp_phone'=>$phone,'emp_pwd'=>$emp_pwd,'company_id'=>$company,'emp_status'=>1,'create_date'=>date('Y-m-d h:i:s')));
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("user Updated Successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("user updation failed","0");
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
			return message::setMsg("User(s) Successfully Deleted");
		}
	}
	
	
	// set vendor status	
    public function disabled($idvals, $table, $column, $data = array())
	{
		 // disabled record
		 $count = 0;
		 foreach($idvals as $idval)
		 {
		    $sql=mysql_fetch_object(mysql_query("SELECT * FROM me_employee WHERE id=$idval"));
			if($sql->emp_status!=2)
			{
		   $result = dbFactory::recordUpdate(array($column => $idval),$data,$table);
		   if($result == '1')
			  $count++;
		 }
		 }
		 if($count > 0)
		 {
		   $this->flag = 1;		// success
		   return message::setMsg("Record(s) Disabled Successfully");
		 }
	}
	//send reset password link
	 	public function admin_reset_password($uid,$mail="ramendra.pati@gmail.com")
		{
			$email = mailFactory::adminresetpass($mail,$uid,'Password reset link');
			if($email == '1')
			 {
			   $this->flag = 1;	  // successful mail sending..
		       return 1;
			 }else{
			   $this->flag = 2;	  // failed sending mail
		       return 2;
			 }
		
		}
		public function admin_reset_confm($name,$mail="ramendra.pati@gmail.com")
		{
			$email = mailFactory:: adminPswResetConfrm($mail,'Password reset confirmation',$name);
			if($email == '1')
			 {
			   $this->flag = 1;	  // successful mail sending..
		       return 1;
			 }else{
			   $this->flag = 2;	  // failed sending mail
		       return 2;
			 }
		
		}
	//terminate the vendor status
	  public function terminate($idvals, $table, $column, $data = array())
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
		   return message::setMsg("Record(s) Terminate  Successfully");
		 }
	}
	
	
}
?>