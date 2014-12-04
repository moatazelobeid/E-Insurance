<?php
// vendorf management
// class name: vendor
class admin {
	
	// vars
	public $vendor_id;
	public $flag;
	
	
	// save new vendor
	public function save(){
		// get posted data
		$datas = $_POST;
		unset($datas['save']);
		$data=array('name'.$datas['chat_chk']=>$datas,uname.$datas['chat_chk']=>$datas,pwd.$datas['chat_chk']=>$datas);
	
		$pwd= base64_encode($datas['pwd']);
		
		print_r($data);
		
		// insert into vendor
		if(isset($datas['is_superadmin'])){$value=1;}else{$value=0;}
		$result = dbFactory::recordInsert($data,ADMINTBL,'',array('is_superadmin'=>$value,'create_date'=>date('Y-m-d h:i:s')));
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("A new vendor Administrator successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Administrator creation failed","0");
		}
	}
	
	// Edit existing vendor from the list
		// update existing vendor
	public function update($cond = array()){
	// get posted data
		$datas = $_POST;
		unset($datas['update']);
		print_r($datas);
		$result = dbFactory::recordUpdate($cond,$datas,ADMINTBL,array('create_date'=>date('Y-m-d h:i:s')));
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("Updated Successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("updation failed","0");
	}
	  }
	
	    // delete vendor from list
		public function delete($idvals, $tables = array()){
		// delete record
		$count = 0;
		foreach($idvals as $idval){
		 if($idval==$_SESSION['aid'])
		 {
		   return message::setMsg("Administrator Account Not Deleted","0");
		 }
			$result = dbFactory::recordDelete($idval,$tables);
			if($result == 1)
			$count++;
		}
		if($count > 0){
			$this->flag = 1;		// success
			return message::setMsg("Administrator(s) Successfully Deleted");
		}
	}
	
	public function is_valid_email($email) {
		  $result = 1;
		  if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){ 
			$result = 0;
		  }
		  return $result;
		}
}
?>