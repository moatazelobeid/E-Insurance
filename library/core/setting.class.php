<?php
// setting management
// class name: setting
class setting {
	
	// vars
	public $flag;
	
	// methods
	// update  setting
	public function update(){
		// get posted data
		$datas = $_POST;
		
		$datas['mealie_commision'] = $datas['mealie_commision1'].".".$datas['mealie_commision2'];
		$datas['mealie_fees'] = $datas['mealie_fees1'].".".$datas['mealie_fees2'];
		$datas['purchase_lockin_time'] = $datas['purchase_lockin_time1'].":".$datas['purchase_lockin_time2']." ".$datas['purchase_lockin_time3'];
		$datas['menu_reminder_time'] = $datas['menu_reminder_time1'].":".$datas['menu_reminder_time2']." ".$datas['menu_reminder_time3'];
		$datas['food_delivery_start_time'] = $datas['food_delivery_start_time1'].":".$datas['food_delivery_start_time2']." ".$datas['food_delivery_start_time3'];
		$datas['food_delivery_end_time'] = $datas['food_delivery_end_time1'].":".$datas['food_delivery_end_time2']." ".$datas['food_delivery_end_time3'];

		
		unset($datas['update']);
		unset($datas['mealie_commision1']);
		unset($datas['mealie_commision2']);
		unset($datas['mealie_fees1']);
		unset($datas['mealie_fees2']);
		unset($datas['purchase_lockin_time1']);
		unset($datas['purchase_lockin_time2']);
		unset($datas['purchase_lockin_time3']);
		unset($datas['menu_reminder_time1']);
		unset($datas['menu_reminder_time2']);
		unset($datas['menu_reminder_time3']);
		unset($datas['food_delivery_start_time1']);
		unset($datas['food_delivery_start_time2']);
		unset($datas['food_delivery_start_time3']);
		unset($datas['food_delivery_end_time1']);
		unset($datas['food_delivery_end_time2']);
		unset($datas['food_delivery_end_time3']);
		


		// update setting
		$result = dbFactory::recordUpdate(array("id" => '1'),$datas,SYSTEMSETTING,array('update_date'=>date("Y-m-d h:i:s")));
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("Your Setting Updated Successfully!");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Setting Updated failed","0");
		}
	}
	
	//FOR save VENDER SERVICE TYPE
	public function save(){
		// get posted data
		
	
	    $datas = $_POST;
		unset($datas['save']);	
		
		
				// insert into vendor
		$result = dbFactory::recordInsert($datas,VSERVICETYPE);
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("A New Service Type Added Successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Service Type Creation Failed","0");
		}
		
		}
	
	
	public function updateservicetype(){
	
			$datas = $_POST;
			$id = $datas['id'];

        unset($datas['updateservicetype']);	
		unset($datas['id']);

	// update setting
		$result = dbFactory::recordUpdate(array("id" => $id),$datas,VSERVICETYPE);
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("Service Type Updated Successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Service Type Updation Failed","0");
		}
	}
	
	public function delete($idvals, $tables = array()){
	 
	      
		// delete record
		$count = 0;
		foreach($idvals as $idval){
		  $pgg=$_GET['page'];
		  if($pgg=='cuisine')
		  { 
		       $ids = dbFactory::fetchItem(array('v_cuisine'=>$idval),VENDORTBL);
		        $num=mysql_num_rows($ids);
				 $idt = dbFactory::fetchItem(array('id'=>$idval),VCUISINE);
		        $ss=mysql_fetch_array($idt);
				$msgg=$ss['vendor_cuisine']." Cuisine already assign to vendor";
		 }else if($pgg=='servicetype')
		 {
		       $ids = dbFactory::fetchItem(array('v_type'=>$idval),VENDORTBL);
		        $num=mysql_num_rows($ids);
				$idtt = dbFactory::fetchItem(array('id'=>$idval),VSERVICETYPE);
		        $ss=mysql_fetch_array($idtt);
				$msgg=$ss['vendor_service_type']." Servicetype already assign to vendor";
		 }
		
		if($num<=0)
		{
			$result = dbFactory::recordDelete($idval,$tables);
			if($result == 1)
			$count++;
		}
		
	//return message::setMsg($ss['vendor_cuisine']."Cuisine already assign to vendor");	
		}
		if($count == 0){
			$this->flag = 1;		// success
			return message::setMsg($msgg,"0");	
		}
		if($count > 0){
			$this->flag = 1;		// success
			return message::setMsg("Record Deleted Successfully");
		}
	}
	
	// disabled s type
		public function disabled($idvals, $table, $column, $data = array()){
		// disabled record
	$count = 0;
		foreach($idvals as $idval){
	       $pgg=$_GET['page'];
		  if($pgg=='cuisine')
		  { 
		        $ids = dbFactory::fetchItem(array('v_cuisine'=>$idval),VENDORTBL);
		        $num=mysql_num_rows($ids);
				 $idt = dbFactory::fetchItem(array('id'=>$idval),VCUISINE);
		        $ss=mysql_fetch_array($idt);
				$msgg=$ss['vendor_cuisine']." Cuisine already assign to vendor";
		 }else if($pgg=='servicetype')
		 {
		       $ids = dbFactory::fetchItem(array('v_type'=>$idval),VENDORTBL);
		        $num=mysql_num_rows($ids);
				$idtt = dbFactory::fetchItem(array('id'=>$idval),VSERVICETYPE);
		        $ss=mysql_fetch_array($idtt);
				$msgg=$ss['vendor_service_type']." Servicetype already assign to vendor";
		 }
		 if($num<=0)
		 {
			$result = dbFactory::recordUpdate(array($column => $idval),$data,$table);
			if($result == '1')
			//$up_qrr = mysql_query("update me_vendor_cuisine set status = '0' where id = '$idval'");
			//if(mysql_affected_rows() > 0)
			$count++;
		  }
		 
		}
		if($count == 0){
			$this->flag = 1;		// success
			return message::setMsg($msgg,"0");	
		}
		if($count > 0){
			$this->flag = 1;		// success
			return message::setMsg("Record(s) Disabled Successfully");
		}
	}
	
	//FOR save VENDER SERVICE TYPE
	public function savecuisine(){
		// get posted data
		
	
	    $datas = $_POST;
		unset($datas['savecuisine']);	
		
		
				// insert into vendor
		$result = dbFactory::recordInsert($datas,VCUISINE);
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("A New Cuisine Added Successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Cuisine Creation Failed","0");
		}
		
		}
	
	
	public function updatesavecuisine(){
	
			$datas = $_POST;
			$id = $datas['id'];

        unset($datas['updatesavecuisine']);	
		unset($datas['id']);

	// update setting
		$result = dbFactory::recordUpdate(array("id" => $id),$datas,VCUISINE);
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("Cuisine Updated Successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Cuisine Updated Failed","0");
		}
	}
}
?>