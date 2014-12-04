<?php
// vendorf management
// class name: vendor
class company {
	
	// vars
	public $company_id;
	public $flag;
	

	// save new company
	public function save(){
		// get posted data
		$datas = $_POST;
		$add_vendor = $_POST['vendor_name'];
		unset($datas['save']);
		unset($datas['vendor_name']);
		$phone = $datas['c_phone1']."-".$datas['c_phone2']."-".$datas['c_phone3'];
	  
	 	unset($datas['c_phone1']);
	 	unset($datas['c_phone2']);
	 	unset($datas['c_phone3']);
		
		// set local settings
		
		//print_r($datas);
		
		// insert into vendor
		$result = dbFactory::recordInsert($datas,COMPANYTBL,'',array('c_status'=>1,'c_phone'=>$phone,'create_date'=>date('Y-m-d h:i:s')));
		$comp_cnt = 0;
		if($result == 1)
		{
		    $c_id = mysql_insert_id();
			foreach($add_vendor as $key => $vendor)
			{
			$result1 = dbFactory::recordInsert(array('company_id' => $c_id, 'vendor_id' => $vendor),COMPANYVENDORTBL,'');
			$comp_cnt++;
			}
			if($comp_cnt > 0)
			{
			   $this->flag = 1;		// success
			   return message::setMsg("A new Company added successfully");
			}
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Company creation failed");
		}
	}
	
	// Edit existing vendor from the list
	public function edit(){
	
	
		
	}
	
	// update existing vendor
	public function update($cond = array()){
	
	// get posted data
		$datas = $_POST;
		$add_vendor = $_POST['vendor_name'];
		unset($datas['update']);
		unset($datas['vendor_name']);
		
		// set local settings
		//$datas['v_pwd'] = base64_encode($datas['v_pwd']);

      	$phone = $datas['c_phone1']."-".$datas['c_phone2']."-".$datas['c_phone3'];
	  
	 	unset($datas['c_phone1']);
	 	unset($datas['c_phone2']);
	 	unset($datas['c_phone3']);
		
		//print_r($datas);
		
		// insert into vendor
		$result = dbFactory::recordUpdate($cond,$datas,COMPANYTBL,array('c_phone'=>$phone,'modify_date'=>date('Y-m-d h:i:s')));
		$comp_cnt = 0;
		if($result == 1)
		{
		    
		    $c_id = $cond['id'];
			mysql_query("DELETE FROM ".COMPANYVENDORTBL." WHERE company_id = '$c_id'");
			foreach($add_vendor as $key => $vendor)
			{
			$result1 = dbFactory::recordInsert(array('company_id' => $c_id, 'vendor_id' => $vendor),COMPANYVENDORTBL,'');
			$comp_cnt++;
			}
			if($comp_cnt > 0)
			{
			   $this->flag = 1;		// success
			   return message::setMsg("Company Successfully Updated..");
			}
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Company updation failed");
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