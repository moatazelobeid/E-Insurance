<?php
// class library for database activity
class item {
	
	// vars
	public $flag;
	
	// methods
	public function getsideItems($orderId)
	{
		$side_item_name = '';
		
		$getItem = dbFactory::fetchItem(array('order_id' => $orderId),EMPORDER);
		if(isset($getItem))
		{
			$order = mysql_fetch_array($getItem);
			if($order['is_group_order'] == '1')
			{
				$subData = dbFactory::fetchItem(array('order_id' => $orderId,'guest_id' => $_SESSION['uid']),ORDERTBL);
				if(isset($subData))
				{
					$side_item_name = '';
					while($itemId = mysql_fetch_array($subData))
					{
						
						$side_item = $this->getItemNames($itemId['item_id']);
						if($side_item != '')
						{
							$side_item_name .= $side_item.', ';
						}
					
					}
				}
			}
			elseif($order['is_group_order'] == '0')
			{
			 	$subData = dbFactory::fetchItem(array('order_id' => $orderId,'emp_id' => $_SESSION['uid']),EMPORDSUBITEM);
				if(isset($subData))
				{
				    $side_item_name = '';
					while($itemId = mysql_fetch_array($subData))
					{
						$side_item = $this->getItemNames($itemId['subitem_id']);
						
						if($side_item != '')
						{
							$side_item_name .= $side_item.', ';
						}
					
					}
				 }
			}
		}
		$out =  substr($side_item_name, 0, -2 );
		return $out;
	
	}
	
	
	/* gives a main item array from a order id*/
	
	public function getMainItems($orderId)
	{
		//$main_item_name = array();
		
		$getItem = dbFactory::fetchItem(array('order_id' => $orderId),EMPORDER);
		if(isset($getItem))
		{
			$order = mysql_fetch_array($getItem);
			if($order['is_group_order'] == '1')
			{
				$subData = dbFactory::fetchItem(array('order_id' => $orderId),ORDERTBL);
				if(isset($subData))
				{
					$main_item_name = array();
					$main_item_price = array();
					$main_item = array();
					while($itemId = mysql_fetch_array($subData))
					{
						
						$itemArr = $this->getMainItemNamesPerVendor($itemId['item_id']);
						$qty = $itemId['quantity'];
					 //	$price = $qty*$itemArr['price'];
					    $price = $itemArr['price'];
						if(is_array($itemArr))
						{
							//$main_item_name .= $side_item.' ,';
						//	array_push($main_item_name,$itemArr['item_name']);
						    array_push($main_item_name,$itemId['item_id']);
							array_push($main_item_price,$price);
							$main_item = array_combine($main_item_name,$main_item_price);
						}
					
					}
				}
			}
			elseif($order['is_group_order'] == '0')
			{
                 $main_item_name = array();
				 $main_item_price = array();
				 $main_item = array();			 	
				$subData = dbFactory::fetchItem(array('order_id' => $orderId),EMPORDSUBITEM);
				if(isset($subData))
				{
				   
					while($itemId = mysql_fetch_array($subData))
					{
						//$itemArr = $this->getItemNames($itemId['subitem_id']);
						$qty = '1';
						$itemArr = $this->getMainItemNamesPerVendor($order['item_id']);
						if(is_array($itemArr))
						{
							//$main_item_name .= $side_item.' ,';
							$price = $qty*$itemArr['price'];
							array_push($main_item_name,$order['item_id']);
							array_push($main_item_price, $price);
							$main_item = array_combine($main_item_name,$main_item_price);
						 }
					
					}
				 }
				 else
				 {
				 	$itemArr2 = $this->getMainItemNamesPerVendor($order['item_id']);
					if(is_array($itemArr2))
					{
						//$main_item_name .= $side_item.' ,';
						$price2 = $itemArr2['price'];
						array_push($main_item_name,$order['item_id']);
						array_push($main_item_price, $price2);
						//print_r($main_item_price);
						$main_item = array_combine($main_item_name,$main_item_price);
					//	print_r($main_item);
					 }
					
					
				 }
			}
		}
		$out =  $main_item;
	//	print_r($out);
		return $out;
	
	}
	
/*gets side items for a vendor form an order*/	
	public function getsideItemsPerVendor($orderId)
	{
		$side_item_name = '';
		
		$getItem = dbFactory::fetchItem(array('order_id' => $orderId),EMPORDER);
		if(isset($getItem))
		{
			$order = mysql_fetch_array($getItem);
			if($order['is_group_order'] == '1')
			{
				$subData = dbFactory::fetchItem(array('order_id' => $orderId),ORDERTBL);
				if(isset($subData))
				{
					$side_item_name = '';
					while($itemId = mysql_fetch_array($subData))
					{
						
						$side_item = $this->getSideItemNamesPerVendor($itemId['item_id']);
						if(is_array($side_item))
						{
							for($j=0;$j<$itemId['quantity'];$j++)
							{
								$side_item_name .= $side_item['item_name'].', ';
							}
							$side_item_price1 = $itemId['quantity']*$side_item['price'];
							
							$side_item_price += $side_item_price1;
							
						}
					
					}
				}
			}
			elseif($order['is_group_order'] == '0')
			{
			 	$subData = dbFactory::fetchItem(array('order_id' => $orderId),EMPORDSUBITEM);
				if(isset($subData))
				{
				    $side_item_name = '';
					$side_item_price = '';
					$side_item='';
					while($itemId = mysql_fetch_array($subData))
					{
						$side_item = $this->getSideItemNamesPerVendor($itemId['subitem_id']);
						
						if(is_array($side_item))
						{	
						
							$side_item_name .= $side_item['item_name'].', ';
						//	$side_item_price1 = $itemId['quantity']*$side_item['price'];
							$side_item_price = $order['total_price'];
						}
					
					}
				 }
			}
		}
		$out['name'] =  substr($side_item_name, 0, -2 );
		$out['price'] = $side_item_price;
		return $out;
	
	}
	
	
	
	public function getvendorInfo($orderId)
	{
		$side_item_name = '';
		
		$getItem = dbFactory::fetchItem(array('order_id' => $orderId),EMPORDER);
		if(isset($getItem))
		{
			$order = mysql_fetch_array($getItem);
			if($order['is_group_order'] == '1')
			{
				$subData = dbFactory::fetchItem(array('order_id' => $orderId,'guest_id' => $_SESSION['uid']),ORDERTBL);
				if(isset($subData))
				{
					$out = '';
					while($itemId = mysql_fetch_array($subData))
					{
						 $vendor = $this->getVendorDetails($itemId['item_id']);
						 if($vendor != '')
						 {
							$out .= $vendor.',';
						  }
					}
				}
			}
			elseif($order['is_group_order'] == '0')
			{
			 	$subData = dbFactory::fetchItem(array('order_id' => $orderId,'emp_id' => $_SESSION['uid']),EMPORDSUBITEM);
				if(isset($subData))
				{
					
					$out = '';
					while($itemId = mysql_fetch_array($subData))
					{
						if($itemId['subitem_id'] != 0 || $itemId['subitem_id']!= '')
						{
							$vendor = $this->getVendorDetails($itemId['subitem_id']);
							if($vendor != '')
							{
								$out .= $vendor.',';
							}
						}
					}
				 }
			}
		}
		$out =  substr($out, 0, -1 );
		$vn = explode(",", $out);
		
		return $vn;
	}
	
	public function getVendorDetails($item_id)
	{
	
	   
	   $sql = dbFactory::fetchItem(array('id' => $item_id),ITEMTBL);
	   if(isset($sql))
	   {
	   		
			$arr =array();
			while($result = mysql_fetch_array($sql))
			{
				$vid = $result['vendor_id'];
				//array_push($arr, $result['vendor_id']);
				   
			}
		 	
	   } 
	  
	   return $vid;
	}
	
	public function getItemNames($id)
	{
		//$sql = mysql_query("select * from ".ITEMTBL." where id= '".$id."'");	 
		$sql = dbFactory::fetchItem(array('id' => $id),ITEMTBL);
	 	if(isset($sql))
		{
		  $res = mysql_fetch_array($sql);
		  if($res['is_side_item'] == 1)
		  {
		  	
			return $res['item_name'];
		
		  }
		}
	}
	
	public function getMainItemNames($id)
	{
		//$sql = mysql_query("select * from ".ITEMTBL." where id= '".$id."'");	 
		$sql = dbFactory::fetchItem(array('id' => $id,'vendor_id'=>$_SESSION['vid']),ITEMTBL);
	 	if(isset($sql))
		{
		  $res = mysql_fetch_array($sql);
		  if($res['is_side_item'] == 0)
		  {
		  	
			return $res['item_name'];
		
		  }
		}
	}
	public function getSideItemNamesPerVendor($id)
	{
		//$sql = mysql_query("select * from ".ITEMTBL." where id= '".$id."'");	 
		$sql = dbFactory::fetchItem(array('id' => $id,'vendor_id'=>$_SESSION['vid']),ITEMTBL);
	 	if(isset($sql))
		{
		  $res = mysql_fetch_array($sql);
		  if($res['is_side_item'] == 1)
		  {
		  	
			return $res;
		
		  }
		}
	}
	public function getMainItemNamesPerVendor($id)
	{
		//$sql = mysql_query("select * from ".ITEMTBL." where id= '".$id."'");	 
		$sql = dbFactory::fetchItem(array('id' => $id,'vendor_id'=>$_SESSION['vid']),ITEMTBL);
	 	if(isset($sql))
		{
		  $res = mysql_fetch_array($sql);
		  if($res['is_side_item'] == 0)
		  {
		  	
			return $res;
		
		  }
		}
	}
	/*//checks if item belongs to the vendor or not
	public function checkForVendor($orderId)
	{
		$sql = dbFactory::fetchItem('order_id'=>$result['order_id']),ORDERTBL);
		if(isset($sql))
		{
			while($arr = mysql_fetch_array($sql))
			{
				$vid = $this->getVendorDetails(arr['item_id']);
				if($vid == $_SESSION['vid'])
				{
					$vid = $this->getBuyerDetails(arr['order_id']);
				}
			}
		}
	
	}*/
	public function buyerDetails($orderId)
	{
		
		$sql = dbFactory::fetchItem(array('order_id'=>$orderId),EMPORDER);
		if(isset($sql))
		{
			while($rs = mysql_fetch_array($sql))
			{			
				$user = $this->getEmployee($rs['emp_id']);
								
			 } 
		  }
		
		return $user;
	//	print_r($user);
	}
	public function getEmployee($id)
	{
	   $sql = dbFactory::fetchItem(array('id'=>$id),EMPLOYEETBL);
	   if(isset($sql))
	   { 
		 
		 $sql1 = mysql_fetch_object($sql);
		 return $sqll; 
		
	   }
	}
	public function insertToedit($orderId)
	{
		$sql = dbFactory::fetchItem(array('order_id'=>$orderId),EMPORDER);
		if(isset($sql))
		{
			$result = mysql_fetch_array($sql);
			$usr = getUser($_SESSION['uid']);
			if(isset($usr))
			{
				 $email = $usr ->emp_email;
			}
			$del1 = dbFactory::delete_item(array('email_id'=>$email),TMPGROUPTBL);
			$del2 = dbFactory::delete_item(array('guest_id'=>$_SESSION['uid']),TMPORDERTBL);
			
			$dsel1 = dbFactory::fetchItem(array('email_id'=>$email),TMPGROUPTBL);
			$dsel2 = dbFactory::fetchItem(array('guest_id'=>$_SESSION['uid']),TMPORDERTBL);
			
			if(!$dsel1 && !$dsel2)
			{
			
				$ins1 = dbFactory::recordInsert(array('order_name'=>$result['grouporder_title'],'email_id'=>$email), TMPGROUPTBL);
				if($ins1 == 1)
				{
					$flag = 1;
				}
				else
				{
					$flag = 0;
				}
				$fetch1 = dbFactory::fetchItem(array('order_id'=>$orderId,'guest_id'=>$_SESSION['uid']), ORDERTBL);
				if(isset($fetch1))
				{
					while($rs = mysql_fetch_array($fetch1))
					{
						$ins2 = dbFactory::recordInsert(array('order_id' =>	$orderId,'item_id' => $rs['item_id'],'quantity'=>$rs['quantity'],'guest_id'=>$_SESSION['uid'],'price'=>$rs['price']), TMPORDERTBL);
						if($ins2 == 1)
						{
							$flag = 1;
						}
						else
						{
							$flag = 0;
						}
					}
				
				}
				
			
			
			}
	
		}
  
  	return $flag;
  }
  
 /* public function todaysTotalOrderPrice()
  {
  
  	
	
		$odr = dbFactory::fetchItem(array('vid'=>''.$_SESSION['vid'].''),'vendor_todays_order');
		$chk = dbFactory::fetchItem(array('vendor_id'=>''.$_SESSION['vid'].''),TODAYSORDERS);
		//if(isset($chk))
		//{
			//$del = mysql_query("delete from ".TODAYSORDERS." where vendor_id =  '".$_SESSION['vid']."'");
		//}
		if(isset($odr))
		{
			$largeOrder="";
			$i=1;
			while($rs = mysql_fetch_array($odr))
			{
			
			  $largeOrder = is_large_order($rs['order_id']);
			 // print_r($largeOrder);
			  		
			  $sql = dbFactory::fetchItem(array('order_id'=>$rs['order_id']),EMPORDER);
			  if(isset($sql))
			  {
			  	$q = mysql_fetch_array($sql);
				
			  }
	     
			  	$key='';
				$value="";
			  	//echo $rs['order_id'];
				$mainItems = $this->getMainItems($rs['order_id']);
				$k = 1;
				$sideItems = '';
				
				if(is_array($mainItems))
				{
				  $t_price="";
				 // $var = count($mainItems);
				  foreach($mainItems as $key => $value)
				  {
				  	if($k == '1')
					{
						$sideItems = $this->getsideItemsPerVendor($rs['order_id']);
						
					}
					else
					{
						$sideItems = '';
						
					}
					
					if(!is_array($largeOrder) || count($largeOrder) == 0)
					{ 
						$t_price = $sideItems['price'] + $value; 
					}
					else
					{ 
						$t_price = $sideItems['price']+$value;
					}
					if(is_array($largeOrder))
					{
					$vendor = get_vendor($key);
					if($vendor['id'] == $_SESSION['vid'])
					{
					$sq5 = dbFactory::fetchItem(array('order_id'=>$rs['order_id'],'item_id'=>$key),ORDERTBL);
					if(isset($sq5))
					{
						
						$rst = mysql_fetch_array($sq5);
						
						if($rst['quantity'] == ''){ $rst['quantity'] =0;} 
						$rst['quantity'];
						for($l = 0;$l<$rst['quantity'];$l++)
						{
						   if($l == 0)
							{
							
							 $tot += $t_price;
						//	$ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>$key,'side_items'=>$sideItems['name'],'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$t_price),TODAYSORDERS);
							
							 }
							 else
							 {
							 
							  $tot += $t_price;
							// $ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>$key,'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$value),TODAYSORDERS);
							 
							 }
							
						}
					
					}
					} 
				 //    $ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>$key,'side_items'=>$sideItems['name'],'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$t_price),TODAYSORDERS);
					
					}
					else
					{
					 
					  $tot += $t_price;
					 // $ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>$key,'side_items'=>$sideItems['name'],'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$t_price),TODAYSORDERS);
				//	"insert into ".TODAYSORDERS." (vendor_id,main_item,side_items,buyer,company,phone,price) values('".$_SESSION['vid']."','$key','".$sideItems['name']."','".$emp_name."','".$emp_company."','".$eph."','".$t_price."')";
					}
				
				
				
	        	 $k++;
		  		$i++; }
	 		   }
		    }
  		 }
	
	
	$tot_price = $tot;
	
	
  
  return $tot_price;
  
  
  
  }*/
  public function todaysTotalOrderPrice()
  {
  	$sel = dbFactory::fetchItem(array('vendor_id'=>''.$_SESSION['vid'].''),TODAYSORDERS);
	if(isset($sel))
	{
		while($rs = mysql_fetch_array($sel))
		{
			$total_price += $rs['price'];
		
		}
		return $total_price;
	}
  
  }

	public function mark_as_delivered()
	{
		$sel = dbFactory::fetchItem(array('vid'=>''.$_SESSION['vid'].''),'vendor_todays_order');
		
		if(isset($sel))
		{
			
			while($res = mysql_fetch_array($sel))
			{
				$se = dbFactory::fetchItem(array('order_id'=>''.$res['order_id'].''),EMPORDER);
				if(isset($se))
				{
				   $is_group_order ="";	
            	   $ord = mysql_fetch_array($se);
				   $is_group_order = $ord['is_group_order'];
				}
		        
				if($is_group_order == 1)
				{
				
				$si = dbFactory::fetchItem(array('order_id'=>''.$res['order_id'].''),ORDERTBL);
				//$si = mysql_query("select * from ".ORDERTBL." where order_id= '".$res['order_id']."'");
				
				if(mysql_num_rows($si) >0)
				{
					if(isset($si))
					{
						
						while($rst = mysql_fetch_array($si))
						{
						   $item = get_item_name($rst['item_id']);
						
						  if(isset($item))
						   {
								if($item['vendor_id'] == $_SESSION['vid'])	
								{
								
								$upd =  mysql_query("update ".ORDERTBL." set is_delivered = '1' where order_id = '".$res['order_id']."' and item_id = '".$rst['item_id']."'");                  
							// echo "update ".ORDERTBL." set is_delivered = '1' where order_id = '".$res['order_id']."'";
							  
								
								}
								
						   }
						}
						
						 $chk = $this->check_if_delivered($res['order_id']);
						
					}
				  }
			}
			else
		    {
				$upd =  mysql_query("update ".EMPORDER." set is_delivered = '1', delivery_date = now() where order_id = '".$res['order_id']."'");
				//echo "update ".EMPORDER." set is_delivered = '1', delivery_date = now() where order_id = '".$res['order_id']."'";
				if($upd)
				{
					$data = $this->getOrderDetails($res['order_id']);
			     	//print_r($data);
					if(isset($data))
					{
						$mail = mailFactory::itemDelivered($data['email'],$from = "info@maasinfotech.com",$res['order_id'],$data['name'],$data['t_price']);
				 	}
				}
			}
			
		}
		
		
	    if($upd)
		{   
			mysql_query("insert into me_vendor_paid (vendor_id, delivered_date, status) values('".$_SESSION['vid']."',now(),'0')");
			mysql_query("UPDATE ".BILLING." SET is_delivered = 1 where vendor_id = '".$_SESSION['vid']."' and billing_date = '".date('Y-m-d')."'");
	
			return 1;
		}
		else
		{
		 return 0;
		}
	
	  }
	}
	public function check_if_delivered($orderId)
	{
		$sel = dbFactory::fetchItem(array('order_id'=>$orderId,'is_delivered'=>'0'),ORDERTBL);
		if(isset($sel))
		{
			return 0;		
		}
		else
		{
			$upd = mysql_query("update ".EMPORDER." set is_delivered = '1', delivery_date =now() where order_id = '$orderId'");
			if($upd)
			{
				$data = $this->getOrderDetails($orderId);
			//	print_r($data);
				if(is_array($data))
				{
					$mail = mailFactory::itemDelivered($data['email'],$from = "info@maasinfotech.com",$orderId,$data['name'],$data['t_price']);
				}
				return 1;	
		   }
		}
	}
	public function check_delivery()
	{
		  $sel = dbFactory::fetchItem(array('vid'=>''.$_SESSION['vid'].''),'vendor_todays_order');
		  if(isset($sel))
		  {
			  if(mysql_num_rows($sel) == 0)
			  {
			  
				return true;
			  }
		  }
		  else
		  {
		  	return false;
		  }
	
	}
	
/*	inserts value in the TODAYSORDERS table when the page loads first time*/
	
	public function getTodaysOrders_abhilash()
	{
	
		$odr = dbFactory::fetchItem(array('vid'=>''.$_SESSION['vid'].''),'vendor_todays_order');
		$chk = dbFactory::fetchItem(array('vendor_id'=>''.$_SESSION['vid'].''),TODAYSORDERS);
		if(isset($chk))
		{
			$del = mysql_query("delete from ".TODAYSORDERS." where vendor_id =  '".$_SESSION['vid']."'");
		}
		if(isset($odr))
		{
			$largeOrder="";
			$i=1;
			while($rs = mysql_fetch_array($odr))
			{
			
			  $largeOrder = is_large_order($rs['order_id']);
			 // print_r($largeOrder);
			  		
			  $sql = dbFactory::fetchItem(array('order_id'=>$rs['order_id']),EMPORDER);
			  if(isset($sql))
			  {
			  	$q = mysql_fetch_array($sql);
				
			  }
	     
			   $sq4 = dbFactory::fetchItem(array('id'=>$q['emp_id']),EMPLOYEETBL);
			   if(isset($sq4))
			   {
				//	$employee = $im->buyerDetails($rs['order_id']);
				  $employee = mysql_fetch_object($sq4);
				  $emp_name = $employee->emp_fname." ".$employee->emp_lname; 
				  $company =  getCompanyInfo($employee->company_id);
				  $emp_company = $company->c_name;
				 
				  $emp_phone = str_replace('-', ' ', $employee->emp_phone);
				  $phone1 =  substr($emp_phone, 0, 3);  
				  $phone2 =  substr($emp_phone, 3);
				  $eph ='';
				  if($phone1 != '' && $phone2 !='')
				  {
					$eph = '('.$phone1.') '.$phone2;
				  }
			    }
				$key='';
				$value="";
			  	//echo $rs['order_id'];
				//$mainItems67 = $this->getMainItems('31036');
				
			      $mainItems = $this->getMainItems($rs['order_id']);
				  $k = 1;
				  $sideItems = '';
				if(is_array($mainItems))
				{
				  $t_price="";
				 // $var = count($mainItems);
				  foreach($mainItems as $key => $value)
				  {
				  	if($k == '1')
					{
						$sideItems = $this->getsideItemsPerVendor($rs['order_id']);
						
					}
					else
					{
						$sideItems = '';
						
					}
					
					if(!is_array($largeOrder) || count($largeOrder) == 0)
					{ 
						$t_price = $sideItems['price']; 
					}
					else
					{ 
						$t_price = $sideItems['price']+$value;
					}
					if(is_array($largeOrder))
					{
					$sq5 = dbFactory::fetchItem(array('order_id'=>$rs['order_id'],'item_id'=>$key),ORDERTBL);
					if(isset($sq5))
					{
						
						$rst = mysql_fetch_array($sq5);
						if($rst['quantity'] == ''){ $rst['quantity'] =0;} 
						$rst['quantity'];
						for($l = 0;$l<$rst['quantity'];$l++)
						{
						   if($l == 0)
							{
							$ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>$key,'side_items'=>$sideItems['name'],'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$t_price),TODAYSORDERS);
							
							 }
							 else
							 {
							 $ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>$key,'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$value),TODAYSORDERS);
							 
							 }
							
						}
					
					}
					 
				 //    $ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>$key,'side_items'=>$sideItems['name'],'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$t_price),TODAYSORDERS);
					
					}
					else
					{
					  $ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>$key,'side_items'=>$sideItems['name'],'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$t_price),TODAYSORDERS);
				//	"insert into ".TODAYSORDERS." (vendor_id,main_item,side_items,buyer,company,phone,price) values('".$_SESSION['vid']."','$key','".$sideItems['name']."','".$emp_name."','".$emp_company."','".$eph."','".$t_price."')";
					}
				
				
				
	        	 $k++;
		  		$i++; }
	 		   }
		    }
  		 }
}

public function getTodaysOrders()
	{
	
		$odr = dbFactory::fetchItem(array('vid'=>''.$_SESSION['vid'].''),'vendor_todays_order');
		$chk = dbFactory::fetchItem(array('vendor_id'=>''.$_SESSION['vid'].''),TODAYSORDERS);
		if(isset($chk))
		{
			$del = mysql_query("delete from ".TODAYSORDERS." where vendor_id =  '".$_SESSION['vid']."'");
		}
		if(isset($odr))
		{
			$largeOrder="";
			$i=1;
			while($rs = mysql_fetch_array($odr))
			{
			
			  $largeOrder = is_large_order($rs['order_id']);
			 // print_r($largeOrder);
			  		
			  $sql = dbFactory::fetchItem(array('order_id'=>$rs['order_id'],'is_cancel'=>'0','is_paid'=>'1'),EMPORDER);
			  if(isset($sql))
			  {
			  	$q = mysql_fetch_array($sql);
				
			  }
	     
			   $sq4 = dbFactory::fetchItem(array('id'=>$q['emp_id']),EMPLOYEETBL);
			   if(isset($sq4))
			   {
				//	$employee = $im->buyerDetails($rs['order_id']);
				  $employee = mysql_fetch_object($sq4);
				  $emp_name = $employee->emp_fname." ".$employee->emp_lname; 
				  $company =  getCompanyInfo($employee->company_id);
				  $emp_company = $company->c_name;
				 
				  $emp_phone = str_replace('-', ' ', $employee->emp_phone);
				  $phone1 =  substr($emp_phone, 0, 3);  
				  $phone2 =  substr($emp_phone, 3);
				  $eph ='';
				  if($phone1 != '' && $phone2 !='')
				  {
					$eph = '('.$phone1.') '.$phone2;
				  }
			    }
				$key='';
				$value="";
			  	//echo $rs['order_id'];
				//$mainItems67 = $this->getMainItems('31036');
				
			     // $mainItems = $this->getMainItems($rs['order_id']);
				  $k = 1;
				  $sideItems = '';
				//if(is_array($mainItems)){price=""; // $var = count($mainItems);}
				
				if(isset($largeOrder)) // if it is a large order ..
				{
				
				   $sqlarge = mysql_query("SELECT * FROM ".ORDERTBL." WHERE order_id = '".$rs['order_id']."'");
			       if(mysql_num_rows($sqlarge) > 0)
			       {
			        while($arr3 = mysql_fetch_assoc($sqlarge))
				     {
				      $fet_lrg = dbFactory::recordFetch($arr3['item_id'],'me_items:id');
					  if(isset($fet_lrg))
					  {
				       if($fet_lrg['vendor_id'] == $_SESSION['vid'])
			           {
			          //  $large_order_price += ($fet_lrg['price']*$arr3['quantity']);
					 	  $large_order_price += $arr3['price'];
			           }
				      }
				     } 
					 }
					 $order_name = mysql_real_escape_string($q['grouporder_title']);
					 // insert into vendors todays order table//
					  $ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>0,'side_items'=>'','buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$large_order_price,'order_id'=>$rs['order_id'],'is_large_order'=>1,'order_name'=>$order_name),TODAYSORDERS);
					  if($ins == '1')
					  {
					  $large_order_price = 0;// setting price to zero.
					  }
					  
					  
				}else{
				 // insert into vendors todays order table//
				 $sideItems = $this->getsideItemsPerVendor($rs['order_id']);
				 $item_ss = get_item_name($q['item_id']);
				 $item_name = mysql_real_escape_string($item_ss['item_name']);
				 $ins = dbFactory::recordInsert(array('vendor_id'=>$_SESSION['vid'],'main_item'=>$q['item_id'],'side_items'=>mysql_real_escape_string($sideItems['name']),'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$q['total_price'],'order_id'=>$rs['order_id'],'is_large_order'=>0,'order_name'=>$item_name),TODAYSORDERS);
				}
		    }
  		 }
		 
 }
	
public function getTodaysOrdersBilling()
	{
	    $chkd = 0;
		$odr = dbFactory::fetchItem(array('vid'=>''.$_SESSION['vid'].''),'vendor_todays_order');
        $chk123 = dbFactory::fetchItem(array('vendor_id'=>''.$_SESSION['vid'].'','billing_date'=>date('Y-m-d'),'is_delivered'=>'1'),BILLING);
		if(isset($chk123))
		{
			$chkd = mysql_num_rows($chk123);
		}
		if($chkd == 0)
		{
			$chk = dbFactory::fetchItem(array('vendor_id'=>''.$_SESSION['vid'].'','billing_date'=>date('Y-m-d')),BILLING);
			if(isset($chk))
			{
				$del = mysql_query("delete from ".BILLING." where vendor_id =  '".$_SESSION['vid']."' and billing_date = '".date('Y-m-d')."'");
			}
		}
		if(isset($odr))
		{
			$largeOrder="";
			$i=1;
			while($rs = mysql_fetch_array($odr))
			{
			
			  $largeOrder = is_large_order($rs['order_id']);
			 // print_r($largeOrder);
			  		
			  $sql = dbFactory::fetchItem(array('order_id'=>$rs['order_id'],'is_cancel'=>'0','is_paid'=>'1'),EMPORDER);
			  if(isset($sql))
			  {
			  	$q = mysql_fetch_array($sql);
				
			  }
	     
			   $sq4 = dbFactory::fetchItem(array('id'=>$q['emp_id']),EMPLOYEETBL);
			   if(isset($sq4))
			   {
				//	$employee = $im->buyerDetails($rs['order_id']);
				  $employee = mysql_fetch_object($sq4);
				  $emp_name = $employee->emp_fname." ".$employee->emp_lname; 
				  $company =  getCompanyInfo($employee->company_id);
				  $emp_company = $company->c_name;
				 
				  $emp_phone = str_replace('-', ' ', $employee->emp_phone);
				  $phone1 =  substr($emp_phone, 0, 3);  
				  $phone2 =  substr($emp_phone, 3);
				  $eph ='';
				  if($phone1 != '' && $phone2 !='')
				  {
					$eph = '('.$phone1.') '.$phone2;
				  }
			    }
				$key='';
				$value="";
			  	//echo $rs['order_id'];
				//$mainItems67 = $this->getMainItems('31036');
				
			     // $mainItems = $this->getMainItems($rs['order_id']);
				  $k = 1;
				  $sideItems = '';
				//if(is_array($mainItems)){price=""; // $var = count($mainItems);}
				  $settings = getSettingVals();
				  $mealie_commision = $settings->mealie_commision;
				  $noca_charges =  $settings->mealie_fees; 
				  $transaction_charges =  $mealie_commision+ $noca_charges;  
				if(isset($largeOrder)) // if it is a large order ..
				{
				
				   $sqlarge = mysql_query("SELECT * FROM ".ORDERTBL." WHERE order_id = '".$rs['order_id']."'");
			       if(mysql_num_rows($sqlarge) > 0)
			       {
			        while($arr3 = mysql_fetch_assoc($sqlarge))
				     {
				      $fet_lrg = dbFactory::recordFetch($arr3['item_id'],'me_items:id');
					  if(isset($fet_lrg))
					  {
				       if($fet_lrg['vendor_id'] == $_SESSION['vid'])
			           {
			          //  $large_order_price += ($fet_lrg['price']*$arr3['quantity']);
					 	  $large_order_price += $arr3['price'];
			           }
				      }
				     } 
					 }
					  
					  $order_name = mysql_real_escape_string($q['grouporder_title']);
					 // insert into vendors billing table//
					if($chkd == 0)
		           {        
					$ins = dbFactory::recordInsert(array('order_id'=>$rs['order_id'],'vendor_id'=>$_SESSION['vid'],'is_large_order'=>'1', 'order_name'=>$order_name,'billing_date' => date('Y-m-d'),'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$large_order_price,'main_item'=>'0','side_items'=>'','mealie_commission'=>$mealie_commision,'mealie_fees'=>$noca_charges),BILLING);
					}
					  if($ins == '1')
					  {
					  $large_order_price = 0;// setting price to zero.
					  }
					  
					  
				}else{
				
				 // insert into vendors billing table//
				 $sideItems = $this->getsideItemsPerVendor($rs['order_id']);
				 $item_ss = get_item_name($q['item_id']);
				 $item_name = mysql_real_escape_string($item_ss['item_name']);
				 if($chkd == 0)
		         {  
					$ins = dbFactory::recordInsert(array('order_id'=>$rs['order_id'],'vendor_id'=>$_SESSION['vid'],'is_large_order'=>'0', 'order_name'=>$order_name,'billing_date' => date('Y-m-d'),'buyer'=>$emp_name,'company'=>$emp_company,'phone'=>$eph,'price'=>$large_order_price,'main_item'=>$q['item_id'],'side_items'=>mysql_real_escape_string($sideItems['name']),'mealie_commission'=>$mealie_commision,'mealie_fees'=>$noca_charges),BILLING);
				 }
				 
				}
		    }
  		 }
		 
 }	
public function getCharges($date)
{
	if($date == ''){ $date = date('Y-m-d');}
	$out = array();
	$mchrg = mysql_query("select * from ".BILLING." where billing_date = '".$date."'");
	if(mysql_num_rows($mchrg) > 0)
	{
		$arr = mysql_fetch_array($mchrg);
		$out['commission'] = $arr['mealie_commission'];
		$out['fees'] = $arr['mealie_fees'];
		return $out;
	}
	else
	{
		$out['commission'] = 0;
		$out['fees'] = 0;
		return $out;
	}
	
	
}	
public function getOrderDetails($orderId)
{
	
	$sq = dbFactory::fetchItem(array('order_id'=>$orderId),EMPORDER);
	
	if(isset($sq))
	{
		$rs = mysql_fetch_array($sq);
    	$total_price = number_format($rs['total_price'],2,'.','');
		$emp_id = $rs['emp_id'];
		$user = getEmp($orderId);
		$usr = $user['emp_fname'] .' '.$user['emp_lname'];
		$details['t_price'] = $total_price;
		$details['name'] = $usr;
		$details['email'] = $user['emp_email'];
		//print_r($details);
		return $details;
		
	}

 }	
 public function checkVendorDelivery()
 {
  	$sel = dbFactory::fetchItem(array('vid'=>''.$_SESSION['vid'].''),'vendor_todays_order');
		
		if(isset($sel))
		{
			
			while($res = mysql_fetch_array($sel))
			{
				$se = dbFactory::fetchItem(array('order_id'=>''.$res['order_id'].''),EMPORDER);
				if(isset($se))
				{
				
			       $is_group_order ="";	
            	   $ord = mysql_fetch_array($se);
				   $is_group_order = $ord['is_group_order'];
				}
		        
				if($is_group_order == 1)
				{
				$si = dbFactory::fetchItem(array('order_id'=>''.$res['order_id'].''),ORDERTBL);
				//$si = mysql_query("select * from ".ORDERTBL." where order_id= '".$res['order_id']."'");
				if(isset($si))
				{
					if(mysql_num_rows($si) >0)
					{
						while($rst = mysql_fetch_array($si))
						{
						   $vid = get_vendor($rst['item_id']);
						   if(is_array($vid))
						   {
							 if($vid['id'] == $_SESSION['vid'])
							 {
								if($rst['is_delivered'] == '1')
								{
									$flag1 = 'true';
								}
								else
								{
									$flag2 = 'true';
								
								}
							 
							 }
						   }
						}
					
					}
			  }
			}
			else
		    {
				if($ord['is_delivered'] == 1)
				{
					$flag3 = 'true';
				
				}
				else
				{
					$flag4 = 'true';
				}	
				
			}
			
		}
		
		
	    if(!isset($flag4) && !isset($flag2))
		{
			return 1;
		}
		else
		{
		 return 0;
		}
	
	  }
	  else
	  {
	  	return 404;
	  }
 }	
	
}
?>