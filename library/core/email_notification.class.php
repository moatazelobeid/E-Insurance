<?php
// vendorf management
// class name: vendor
class emailnofication {
	
	// vars
	
	public $flag;
	// methods
		// update existing vendor
	public function update($cond = array()){
	// get posted data
		$datas = $_POST;
		unset($datas['update']);
		// set local settings
	  if(isset($datas['bcc_superadmin'])){$value=1;}else{$value=0;}
		// insert start
		$result = dbFactory::recordUpdate($cond,$datas,NOTIFICATIONTBL,array('bcc_superadmin'=>$value,'modify_date'=>date('Y-m-d h:i:s')));
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("Updated Successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("updation failed","0");
		}
	}
}
?>