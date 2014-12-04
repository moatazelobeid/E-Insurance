<?php
// vendorf management
// class name: vendor
class vendor {
	// vars
	public $vendor_id;
	public $flag;
	// methods
	function __construct() {
		// generate vendor id
		$this->vendor_id = ucodeGen(VENDORTBL,'vendor_id','id','10','5');
		return $this->vendor_id;
	}
	// save new vendor
	public function save(){
		// get posted data
		$datas = $_POST;
		unset($datas['save']);
		
		// set local settings
		$v_pwd = base64_encode($datas['v_pwd']);

      	$phone = $datas['v_phone1']."-".$datas['v_phone2']."-".$datas['v_phone3'];
	  
	 	unset($datas['v_phone1']);
	 	unset($datas['v_phone2']);
	 	unset($datas['v_phone3']);
		unset($datas['v_repwd']);
		unset($datas['v_pwd']);
		//print_r($datas);
		
		// insert into vendor
		$result = dbFactory::recordInsert($datas,VENDORTBL,'',array('v_pwd'=>$v_pwd,'v_status'=>1,'v_phone'=>$phone,'create_date'=>date('Y-m-d h:i:s')));
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("A new vendor added successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Vendor creation failed","0");
		}
	}
	
	// Edit existing vendor from the list
	public function edit(){
	
	
		
	}
	
	// update existing vendor
	public function update($cond = array()){
	
	// get posted data
		$datas = $_POST;
		unset($datas['update']);
		
		// set local settings
		$v_pwd = base64_encode($datas['v_pwd']);

      	$phone = $datas['v_phone1']."-".$datas['v_phone2']."-".$datas['v_phone3'];
	  
	 	unset($datas['v_phone1']);
	 	unset($datas['v_phone2']);
	 	unset($datas['v_phone3']);
		unset($datas['v_repwd']);
		unset($datas['v_pwd']);
		
		//print_r($datas);
		
		// insert into vendor
		$result = dbFactory::recordUpdate($cond,$datas,VENDORTBL,array('v_pwd'=>$v_pwd,'v_phone'=>$phone,'modify_date'=>date('Y-m-d h:i:s')));
		if($result == 1){
			$this->flag = 1;		// success
			return message::setMsg("Vendor Updated Successfully");
		}else{
			$this->flag = 2;		// fail
			return message::setMsg("Vendor updation failed","0");
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
		public function add_item()
		{
		// get posted data
		$datas = $_POST;
		// set local settings
		
		$attrib = $datas['attribute'];
		$item_name = mysql_real_escape_string($datas['item_name']);
		$item_desc = mysql_real_escape_string($datas['item_detail']);
		unset($datas['save']);
		unset($datas['attribute']);
    	unset($datas['item_name']);
		unset($datas['item_detail']);
		//print_r($datas);
		$file = $_FILES;
		if($file['item_img']['name'] != '' && $file['item_img']['size'] != 0)
		{
			//upload image
			$upl = $this->upload_image($file['item_img'],'images/item_images/');
		
		}
		else
		{
			$upl = 'default.png';
		}
		if($upl != '' && $upl != 'failed' && $upl != 'invalid_file')
		{
		// insert into items
			$img_name = $upl;
			$result = dbFactory::recordInsert($datas,ITEMTBL,'',array('vendor_id' =>$_SESSION['vid'] ,'item_name'=>$item_name,'item_detail'=>$item_desc,'item_img'=>$img_name,'create_date'=>date('Y-m-d h:i:s')));
			$item_id = mysql_insert_id();
			
			if(isset($attrib) && count($attrib) > 0 && $item_id != '')
			{
				
				foreach($attrib as $data)
				{
					
						$res = dbFactory::recordInsert(array('attribute_id'=>$data,'item_id'=>$item_id),ITEMATTRIB);
					//echo $res;
					
				}
			}
		}else
		{
			return 'Invalid file';
		}
		if($result == 1){
		 $idw = dbFactory::fetchItem(array('id'=>$item_id),ITEMTBL);
		 $ss=mysql_fetch_array($idw);
		   $ids = dbFactory::fetchItem(array('vendor_id'=>$_SESSION['vid']),COMPANYVENDORTBL);
			while($zz=mysql_fetch_array($ids))
			{
			  $idr=mysql_query("SELECT * FROM me_employee WHERE company_id='".$zz['company_id']."' AND for_menu_update='1'");
			 // echo "SELECT * FROM me_employee WHERE company_id='".$zz['company_id']."' AND for_menu_update='1'";
			  //$idr = dbFactory::fetchItem(array('company_id'=>$zz['company_id'],'for_menu_update'=>'1'),EMPLOYEETBL);
			   while($we=mysql_fetch_array($idr))
			   {
			   $email=$we['emp_email'];
			   $item_img=$ss['item_img'];
			   $item_name=$ss['item_name'];
			   //$item_price=$ss['price'];
			   $item_desc=$ss['item_detail'];
			   $name=$we['emp_uname'];
			   $pr=explode(".",$ss['price']);
      if($pr[1]==''){$item_price="$".$pr[0].".00";}else{$item_price="$".$pr[0].".".$pr[1];}
 			   $mail = mailFactory::addNewItem($email,$name,$item_img,$item_name,$item_price,$item_desc);
		
			} 
			}
			$this->flag = 1;		// success
			return 1;
		}else{
			$this->flag = 2;		// fail
			return 2;
		}
	}
	
	public function upload_image($file,$path)
	{
		$logo = basename($file['name']);
		$ext = explode(".",$logo);
		$ext = $ext[count($ext) - 1];
		if((($ext == 'jpg') || ($ext == 'jpeg') || ($ext == 'gif') || ($ext == 'png') || ($ext == 'bmp')))
		{
			$filename = time().str_replace(" ","_",$file['name']);
			$tmpname = $file['tmp_name'];
			if(move_uploaded_file($tmpname, $path.$filename ))
			{
				return $filename;
			}
			else
			{
				return 'failed';
			}
		}
		else
		{
			return 'invalid_file';
		}
		
	}
	
	public function update_item($cond = array())
	{
		// get posted data
		$datas = $_POST;
		// set local settings
		
		$attrib = $datas['attribute'];
		$item_name = mysql_real_escape_string($datas['item_name']);
		$item_desc = mysql_real_escape_string($datas['item_detail']);
		
		unset($datas['save']);
		unset($datas['attribute']);
		unset($datas['item_name']);
		unset($datas['item_detail']);
 	
		//print_r($datas);
		$file = $_FILES;
		//print_r($file);
		
		if($file['item_img']['name'] != '' && $file['item_img']['size'] != 0)
		{
			//upload image
			$upl = $this->upload_image($file['item_img'],'images/item_images/');
		
		}
		else
		{
			$upl = 'default.png';
		}
		if($upl != '' && $upl != 'failed' && $upl != 'invalid_file')
		{
		// update into items
			if($upl == 'default.png')
			{			
				$result = dbFactory::recordUpdate($cond,$datas,ITEMTBL,array('item_name'=>$item_name ,'item_detail' =>$item_desc));
			}
			else
			{
				$result = dbFactory::recordUpdate($cond,$datas,ITEMTBL,array('item_name'=>$item_name ,'item_detail' =>$item_desc,'item_img'=>$upl));
			}
		//	echo count($attrib);
			
			if(isset($attrib) && count($attrib) > 0)
			{
				$del = dbFactory::recordDelete($cond['id'], array(ITEMATTRIB=>'item_id'));
				
				if(count($attrib) > 0){
					foreach($attrib as $data)
					{
						//( $ids, $datas, $table, $extra = array(), $file = '' )
						$res = dbFactory::recordInsert(array('attribute_id'=>$data,'item_id'=>$cond['id']),ITEMATTRIB);
						//echo $res;
					}
				}
			}
		}else
		{
			return 3;
		}
		if($result == 1){
			$this->flag = 1;		// success
			return 1;
		}else{
			$this->flag = 2;		// fail
			return 2;
		}
	}
	
	// update existing vendor
	public function update_vprofile($cond = array()){
	
	// get posted data
		$datas = $_POST;
		
				
		// set local settings
		$v_pwd = base64_encode($datas['v_pwd']);

      	$phone = $datas['v_phone1']."-".$datas['v_phone2']."-".$datas['v_phone3'];
	  
	 	unset($datas['v_phone1']);
	 	unset($datas['v_phone2']);
	 	unset($datas['v_phone3']);
		unset($datas['v_repwd']);
		unset($datas['c_vpass']);
		unset($datas['v_pwd']);
		unset($datas['save']);
		unset($datas[emp_pwd]);
		//print_r($datas);
		// update to vendor
		$result = dbFactory::recordUpdate($cond,$datas,VENDORTBL,array('v_phone'=>$phone,'modify_date'=>date('Y-m-d h:i:s')));
		if($result == 1){
			$this->flag = 1;
			
			$usr = getUser('','V');	
			$to = $usr->v_email;
 			$mail = mailFactory::accountUpdated($to);
			// success
			return 1;
		}else{
			$this->flag = 2;		// fail
			return 2;
		}
		
	}
	
	// set vendor status	
    public function disabled($idvals, $table, $column, $data = array())
	{
		 // disabled record
		 $count = 0;
		 foreach($idvals as $idval)
		 {
		   $sql=mysql_fetch_object(mysql_query("SELECT * FROM me_vendor WHERE id=$idval"));
			if($sql->v_status!=2)
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
		   return message::setMsg("Record(s) terminate  Successfully");
		 }
	}
	//terminate the vendor status
    public function getVendorData($vendorId)
	{
		 if($vendorId != '')
		 {
		 	$v = dbFactory::fetchItem(array('id'=>$vendorId),VENDORTBL);
			if(isset($v))
			{
				$res = mysql_fetch_array($v);
			}
		 
		 }
		 return $res;
	}
	
	//public function vendor_billing_table() //inserts data to the billing table*/
//	{
//		$chk = mysql_query("select * from ".BILLING."");
//		if(mysql_num_rows($chk) > 0)
//		{
//			$del = mysql_query("delete from ".BILLING."");
//			
//		}
//		$s = mysql_query("select * from ".EMPORDER." where order_id !='' and emp_id !=''"); /*selects order_id from emporder*/
//		
//		if(mysql_num_rows($s) > 0)
//		{
//			while($r = mysql_fetch_array($s))
//			{
//				$orderId = $r['order_id'];
//				
//				$v_ids = $this->getVendorsPerOrder($r['order_id']); /*get vendor ids from an order*/
//			//	print_r($v_ids);
//				if(is_array($v_ids))
//				{
//					
//					foreach ($v_ids as $vid)
//					{
//						$main_item_arr = $this->getVendorMainItems($r['order_id'],$vid);
//						$side_item_arr = $this->getVendorSideItems($r['order_id'],$vid);
//						//	echo $r['order_id'];
//					//	print_r($side_item_arr);
//						$sideItemIds = '';
//						foreach ($side_item_arr as $key => $value)
//						{
//							for($l =0;$l<$value;$l++){
//							$sideItemIds .= $key.", ";
//							}
//							$i = get_item_name($key);
//							$i_price += $i['price']*$value;
//						}
//						
//						
//						//foreach($main_item_arr )
//						$sideItemIds = substr($sideItemIds,0,-2);
//						foreach ($main_item_arr as $key => $value)
//						{
//							$mi = get_item_name($key);
//							$mi_price = $mi['price']*$value;
//							
//							
//							$ins = mysql_query("insert into ".BILLING." (vendor_id,order_id, main_item_id, main_item_price, side_item_id, side_item_price, ordered_for) values ('".$vid."','".$orderId."','".$key."','".$mi_price."','".$sideItemIds."','".$i_price."','".$r['order_date']."')");
//						}
//						//$sideItemIds = '';
//					}
//				}
//			$a++;
//			}
//		}
//	}
	
	public function vendor_billing_table() //inserts data to the billing table*/
	{
		$chk = mysql_query("select * from ".BILLING." where vendor_id = '".$_SESSION['vid']."'");
		if(mysql_num_rows($chk) > 0)
		{
			$del = mysql_query("delete from ".BILLING." where vendor_id = '".$_SESSION['vid']."'");
			
		}
		$s = mysql_query("select * from ".EMPORDER." where order_id !='' and emp_id !=''"); /*selects order_id from emporder*/
		
		if(mysql_num_rows($s) > 0)
		{
			while($r = mysql_fetch_array($s))
			{
				$orderId = $r['order_id'];
				
				$side_item_arr = $this->getVendorSideItems($r['order_id'],$_SESSION['vid']);
			//	print_r($side_item_arr);
				$sideItemIds = '';
				$i_price =0;
				foreach ($side_item_arr as $key => $value)
				{
					for($l =0;$l<$value;$l++){
						$sideItemIds .= $key.", ";
						$i = get_item_name($key);
						$i_price += $i['price'];
						
					}
					
				}
			
				$sideItemIds = substr($sideItemIds,0,-2);
				
				$v_ids = $this->getVendorsPerOrder($r['order_id']); /*get vendor ids from an order*/
			//	print_r($v_ids);
				if(is_array($v_ids))
				{
						
					foreach ($v_ids as $vid)
					{
						$main_item_arr = $this->getVendorMainItems($r['order_id'],$vid);
						
						$j =1;
						foreach ($main_item_arr as $key => $value)
						{
							$mi = get_item_name($key);
							$mi_price = $mi['price'];
							if($j !=1)
							{
								$sideItemIds='';
								$i_price='';
									
							}							
							for($l =0;$l<$value;$l++)
							{
								if($l !=0)
								{
								$sideItemIds='';
								$i_price='';
									
								}	
							
							
							 $name = get_item_name($key);
							 $side = $sideItemIds;
							//  echo $side;
							  $s_i = explode(',',$side);
							  
							  $side_item_name ='';
							  for($k =0;$k<count($s_i);$k++)
							  {
								$s_name = get_item_name($s_i[$k]);
								$side_item_name .= $s_name['item_name'].', ';
								 
							  }
							 $side_item_name = substr($side_item_name,0,-2);
							 $price = $mi_price+$i_price;
							 $buyer = getEmp($r['order_id']);
							 $u_name = $buyer['emp_fname']." ".$buyer['emp_lname']; 
							 $comp = getCompanyInfo($buyer['company_id']);
							 $comp_name = $comp->c_name;
							 $emp_phone = str_replace('-', ' ', $buyer['emp_phone']);
							 $phone1 =  substr($emp_phone, 0, 3);  
							 $phone2 =  substr($emp_phone, 3);
							 $eph ='';
							 if($phone1 != '' && $phone2 !='')
							 {
								$eph = '('.$phone1.') '.$phone2;
							 }
							$ins = mysql_query("insert into ".BILLING." (vendor_id,order_id, main_item_id, main_item_price, side_item_id, side_item_price, billing_date,item,buyer,company,phone,price) values ('".$vid."','".$orderId."','".$key."','".$mi_price."','".$sideItemIds."','".$i_price."','".$r['order_date']."','".$name['item_name']."','".$u_name."','".$comp_name."','".$eph."','".$price."')");	
						  }
							$j++;
						}
						//$sideItemIds = '';
					}
				}
			$a++;
			}
		}
	}
	
   public function getVendorMainItems($orderId,$vid) /*gets main item id and quantity from order id and vendor id*/
   {
		$large = '';
		$itm_id = array();
		$itm_qty = array();
		$itm = array();
		$large = is_large_order($orderId);
		if(is_array($large))							/*if large order*/
		{
			$vr = dbFactory::fetchItem(array('order_id'=>$orderId),ORDERTBL);
			if(isset($vr))
			{
				while($items = mysql_fetch_array($vr))
				{
					$im = get_item_name($items['item_id']);
					if($im['vendor_id'] == $vid && $im['is_side_item'] == 0 && $items['is_delivered'] ==1)
					{
						array_push($itm_id, $im['id']);
						array_push($itm_qty, $items['quantity']);
						$itm = array_combine($itm_id,$itm_qty);
					 }
				 }
	         }
		  }
		  else
		  {
		  	$id = dbFactory::fetchItem(array('order_id'=>$orderId),EMPORDER); /*if single order*/
			if(isset($id))
			{
				$items2 = mysql_fetch_array($id);
			}
			$im2 = get_item_name($items2['item_id']);	
			if($im2['vendor_id'] == $vid && $im2['is_side_item'] == 0 && $items2['is_delivered'] == 1)
			{
		  		array_push($itm_id, $items2['item_id']);
				array_push($itm_qty, '1');
				$itm = array_combine($itm_id,$itm_qty);
			}
		  }
		  return $itm ;
	}
   public function getVendorSideItems($orderId,$vid) /*gets side item id and quantity from order id and vendor id*/
   {
		$large = '';
		$itm_id = array();
		$itm_qty = array();
		$itm = array();
		$large = is_large_order($orderId);
		if(is_array($large))							/*if large order*/
		{
			$vr = dbFactory::fetchItem(array('order_id'=>$orderId),ORDERTBL);
			if(isset($vr))
			{
				while($items = mysql_fetch_array($vr))
				{
					$im = get_item_name($items['item_id']);
					if($im['vendor_id'] == $vid && $im['is_side_item'] == 1 && $items['is_delivered'] ==1)
					{
						array_push($itm_id, $im['id']);
						array_push($itm_qty, $items['quantity']);
						$itm = array_combine($itm_id,$itm_qty);
					 }
				 }
	          }
		  }
		  else
		  {
		    $id = dbFactory::fetchItem(array('order_id'=>$orderId,'is_delivered'=>'1'),EMPORDER); /*if single order*/
			if(isset($id))
			{
			    $items2 = mysql_fetch_array($id);
				$id2 = dbFactory::fetchItem(array('order_id'=>$orderId,'item_id'=>$items2['item_id']),EMPORDSUBITEM);
				if(isset($id2))
				{
					while($item_list = mysql_fetch_array($id2))
					{
						$im2 = get_item_name($item_list['subitem_id']);	
						if($im2['vendor_id'] == $vid && $im2['is_side_item'] == '1')
						{
							array_push($itm_id, $im2['id']);
							array_push($itm_qty, '1');
							$itm = array_combine($itm_id,$itm_qty);
						}
					  }
				  }
		 	  }
			}
		  	
		  return $itm ;
	}
/*	public function getBillingTotalPrice($date)
	{
		$sq = dbFactory::multipleRecords(array('vendor_id'=>''.$_SESSION['vid'].'','DATE(billing_date)'=>$date),BILLING); 
		if(isset($sq))
		{
			while($arr = mysql_fetch_array($sq))
			{
				$main_item_price += $arr['main_item_price'];
				$side_item_price += $arr['side_item_price'];
			}
			
			$total_price = $main_item_price + $side_item_price;
			return $total_price;
		} 
	
	}*/
	
		public function getBillingTotalPrice($date)
	{
		$sq = dbFactory::multipleRecords(array('vendor_id'=>''.$_SESSION['vid'].'','DATE(billing_date)'=>$date),BILLING); 
		if(isset($sq))
		{
			while($arr = mysql_fetch_array($sq))
			{
				//$main_item_price += $arr['main_item_price'];
				//$side_item_price += $arr['side_item_price'];
				$order_price += $arr['price'];
			}
			
			//$total_price = $main_item_price + $side_item_price;
			return $order_price;
		} 
	
	}
	public function getVendorsPerOrder($orderId) /*returns an array of vendors of an orderId*/
	{
		$oid = dbFactory::fetchItem(array('order_id'=>$orderId),EMPORDER);
		if(isset($oid))
		{
			$rst = mysql_fetch_array($oid); 
			if($rst['is_group_order'] == 1)      /*if group order selects the grouporder_item table*/
			{
				$vr = dbFactory::fetchItem(array('order_id'=>$orderId),ORDERTBL);
				if(isset($vr))
				{
				    $v_id = array();
					while($arr = mysql_fetch_array($vr))
					{
						$item_id = $arr['item_id'];
						$v = get_vendor($item_id);
						if(count($v) > 0 && $v['is_side_item'] == '0')
						{
						   array_push($v_id,$v['id']);
						}
					
					 }
					
					 $out = array_values(array_unique($v_id));
					//  print_r($out);
					 return $out;
					 		
				   }
			   }
			   else
			   {
			    	$v_id = array();
			   		$item_id2 = $rst['item_id'];
					$v2 = get_vendor($item_id2);
					if(count($v2) > 0)
					{
					 	array_push($v_id,$v2['id']);
					}
					
					 $out = array_values(array_unique($v_id));
				     // print_r( $out);
					 return $out;
			    }
		     }
	   }
	  function vendorAdminBilling($vid)
	   {
	    $i =0;
	      $single_order_price = 0;
		  $large_order_price = 0;
		  $total_price = 0;
	      //echo $sql = dbFactory::fetchItem(array('DATE(order_date)' => 'CURDATE()'),EMPORDER);
		    $sql = mysql_query("select * from me_emp_order where DATE(order_date) = CURDATE() and is_cancel = '0' and is_paid = '1'");
		   if(isset($sql))
			 {
				while($arr = mysql_fetch_assoc($sql))
				{
					$order_id = $arr['order_id'];
					if($arr['is_group_order'] == '0')  // if the order is a single order..
					{
					  $fet = dbFactory::recordFetch($arr['item_id'],'me_items:id');
					  if(isset($fet))
					  {
					 	 if($fet['vendor_id'] == $vid)
					 	 {
							$single_order_price += $arr['total_price'];
					 	  }
				
						}
					}
					else if($arr['is_group_order'] == '1') // if the order is a Large order..
					{
					   $sqlarge = mysql_query("SELECT * FROM ".ORDERTBL." WHERE order_id = '".$order_id."'");
						if(mysql_num_rows($sqlarge) > 0)
						{
						  while($arr3 = mysql_fetch_assoc($sqlarge))
						   {
							$fet_lrg = dbFactory::recordFetch($arr3['item_id'],'me_items:id');
							if(isset($fet_lrg))
							{
							if($fet_lrg['vendor_id'] == $vid)
							{
							  //$large_order_price += ($fet_lrg['price']*$arr3['quantity']);
							  $large_order_price += ($arr3['price']);
							}
						  }
						 } 
						}
					  }
					  
						 $price1 = $single_order_price + $large_order_price;
						 
					}
			$total_price  = $price1;
			
			}
	    return $total_price;
		
 }
 
  function vendorAdminBillingNew($vid,$date)
	   {
	    $i =0;
		if($date=='')
		{
		$date = date('Y-m-d');
		}
	      $single_order_price = 0;
		  $large_order_price = 0;
		  $total_price = 0;
	      //echo $sql = dbFactory::fetchItem(array('DATE(order_date)' => 'CURDATE()'),EMPORDER);
		   $sql = mysql_query("select * from me_emp_order where DATE(order_date) = '".$date."' and is_cancel = '0' and is_paid = '1'");
		   if(isset($sql))
			 {
				while($arr = mysql_fetch_assoc($sql))
				{
					$order_id = $arr['order_id'];
					if($arr['is_group_order'] == '0')  // if the order is a single order..
					{
					  $fet = dbFactory::recordFetch($arr['item_id'],'me_items:id');
					  if(isset($fet))
					  {
					 	 if($fet['vendor_id'] == $vid)
					 	 {
							$single_order_price += $arr['total_price'];
					 	  }
				
						}
					}
					else if($arr['is_group_order'] == '1') // if the order is a Large order..
					{
					   $sqlarge = mysql_query("SELECT * FROM ".ORDERTBL." WHERE order_id = '".$order_id."'");
						if(mysql_num_rows($sqlarge) > 0)
						{
						  while($arr3 = mysql_fetch_assoc($sqlarge))
						   {
							$fet_lrg = dbFactory::recordFetch($arr3['item_id'],'me_items:id');
							if(isset($fet_lrg))
							{
							if($fet_lrg['vendor_id'] == $vid)
							{
							  //$large_order_price += ($fet_lrg['price']*$arr3['quantity']);
							  $large_order_price += ($arr3['price']);
							}
						  }
						 } 
						}
					  }
					  
						 $price1 = $single_order_price + $large_order_price;
						 
					}
			$total_price  = $price1;
			
			}
	    return $total_price;
		
 }
 
  function vendorAdminBilling2324234567890($vid)
	   {
	    $i =0;
	      $single_order_price = 0;
		  $large_order_price = 0;
		  $total_price = 0;
	      //echo $sql = dbFactory::fetchItem(array('DATE(order_date)' => 'CURDATE()'),EMPORDER);
		    $sql = mysql_query("select * from me_emp_order where DATE(order_date) = CURDATE() and is_cancel = '0' and is_paid = '1'");
		   if(isset($sql))
			 {
		  while($arr = mysql_fetch_assoc($sql))
		  {
		     $order_id = $arr['order_id'];
			if($arr['is_group_order'] == '0')  // if the order is a single order..
			{
			  $fet = dbFactory::recordFetch($arr['item_id'],'me_items:id');
			  if(isset($fet))
			  {
			  if($fet['vendor_id'] == $vid)
			  {
			    $single_order_price += $fet['price'];
			  }
			  // calculate subitem's price...
			  $sqsingle = mysql_query("SELECT * FROM ".EMPORDSUBITEM." WHERE order_id = '".$order_id."'");
			  if(mysql_num_rows($sqsingle) > 0)
			  {
			    while($arr2 = mysql_fetch_assoc($sqsingle))
				{
				    $fet2 = dbFactory::recordFetch($arr2['subitem_id'],'me_items:id');
				    if($fet2['vendor_id'] == $vid)
			        {
			          $single_order_price += $fet2['price'];
					  //echo $fet2['price']."<br/>";
					  //echo $i."- ".$fet2['price']."<br/>";
					  
			        }
					$i++;
				}
			  }
			}
		}
			else if($arr['is_group_order'] == '1') // if the order is a Large order..
			{
			   $sqlarge = mysql_query("SELECT * FROM ".ORDERTBL." WHERE order_id = '".$order_id."'");
			    if(mysql_num_rows($sqlarge) > 0)
			    {
			      while($arr3 = mysql_fetch_assoc($sqlarge))
				   {
				    $fet_lrg = dbFactory::recordFetch($arr3['item_id'],'me_items:id');
					if(isset($fet_lrg))
					{
				    if($fet_lrg['vendor_id'] == $vid)
			        {
			          //$large_order_price += ($fet_lrg['price']*$arr3['quantity']);
					  $large_order_price += ($sqlarge['price']);
			        }
				  }
				 } 
			    }
			  }
			  
			     $price1 = $single_order_price + $large_order_price;
			     $total_price  = $price1;
		    }
			}
	    return $total_price;
		
 }
 
 public function getToatalSalesAdmin()
 {
   $total_price = 0;
   $sql = mysql_query("SELECT * FROM me_emp_order where DATE(order_date) = CURDATE() and is_cancel = '0' and is_paid = '1'");
   if(mysql_num_rows($sql) > 0)
   {
     while($sq = mysql_fetch_assoc($sql))
	 {
	   $total_price += $sq['total_price'];
	 }
   }
   return $total_price;
 }
}
?>