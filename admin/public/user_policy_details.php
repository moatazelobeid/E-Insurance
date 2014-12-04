<?php 
$id=$_GET['id']; 
$policy=$_GET['policy_no']; 
$view=$_GET['view']; 
if($id)
{
	$user_policy=mysql_fetch_assoc(mysql_query("select * from ".USERPOLICY." where id='".$id."'"));
	$policy_no=$user_policy['policy_no']; 
	$policy_type=$user_policy['policy_type'];
	
	if($_GET['type']=='agent')
		$page="agent-policies";
	else
		$page="policies";
}
if($policy)
{
	$user_policy=mysql_fetch_assoc(mysql_query("select * from ".USERPOLICY." where policy_no='".$policy."'"));
	$policy_no=$user_policy['policy_no']; 
	$policy_type=$user_policy['policy_type'];
	$page="payments&view=".$view;
}

//get all attachments
$attachments=mysql_query("select * from ".ATTACHMENTS." where policy_no='".$policy_no."'");

$payment=mysql_fetch_assoc(mysql_query("SELECT * FROM ".PAYMENTS." WHERE policy_id = '".$policy_no."' order by id desc limit 0, 1"));
$policy_amt=number_format($payment['policy_amt'],2);
if($payment['is_discount']=='1')
	$discount=($payment['discount_amt']/$payment['policy_amt'])*100;
$amount=number_format($payment['amount_paid'],2);

if($policy_type=='travel')
{
	$travellers=mysql_query("select * from ".USERPOLICYTRAVELLERS." where policy_no='".$policy_no."'"); 
	$user_travel_policy=mysql_fetch_assoc(mysql_query("select * from ".USERTRAVELPOLICY." where policy_no='".$policy_no."'"));
}
if($policy_type=='medical')
{
	$members=mysql_query("select * from ".USERHEALTHPOLICYMEMBERS." where policy_no='".$policy_no."'"); 
	$user_health_policy=mysql_fetch_assoc(mysql_query("select * from ".USERHEALTHPOLICY." where policy_no='".$policy_no."'"));
}
if($policy_type=='auto')
{
	$user_auto_policy=mysql_fetch_assoc(mysql_query("select * from ".USERAUTOPOLICY." where policy_no='".$policy_no."'"));
}
if($policy_type=='malpractice')
{
	$user_malpractice_policy=mysql_fetch_assoc(mysql_query("select * from ".USERMALPRACTICEPOLICY." where policy_no='".$policy_no."'"));
}
?>
    
        
<div style="width: 900px; margin: 0 auto; margin-top: 10px;">
        <div class="innerpagearea_left_inner_d" align="center">
          <div class="mask" style="height:1px;"></div>
          
          <div class="clear"></div>
          
          <div class="welcomearea_d">
          
              <div  style="margin-left:7px; margin-right:7px;">
			  
				<div class="mask" style="height:10px;"></div>
				<table width="" height="" border="0" cellpadding="6" cellspacing="2">
				<tbody>
				<tr>
				<td colspan="3" style="border-bottom:1px solid #99c"><font style="font-size:14px; font-weight:bold; color:#036;">Policy Details</font>
				<a href="<?php echo BASE_URL;?>account.php?page=<?php echo $page;?>" style="float:right">&lt;&lt;&nbsp;Back</a></td>
				</tr>
				<tr class="fieldRow1">
				  <td colspan="3" class="fieldLabelsColumn">
				  
				   
				   <div class="mask" style="height:10px;"></div>
				   
				  <div class="your-quoatation1">
					 <div class="your-quoatation-inner1">
					  <table width="623" border="0" cellpadding="2" cellspacing="4">
						<tr>
						  <td height="20" colspan="7" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue">Customer Details </span></td>
						</tr>
						<tr>
						  <td width="170" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">First Name </span></span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td width="138" height="30" align="left">  <span class="item dateofbirth"><?php echo $user_policy['fname'];?></span></td>
						  <td width="11" height="30">&nbsp;</td>
						  <td width="116" height="30" align="right">&nbsp;<span class="fieldLabel form_txt1">Last Name </span></td>
                          <td width="11" height="30"><div align="center">:</div></td>
						  <td width="144" height="30" align="left"><span class="item dateofbirth">&nbsp;<?php echo $user_policy['lname'];?></span></td>
						</tr>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Gender </span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td width="138" height="30" align="left"><span class="fieldsColumn1"><?php if($user_policy['gender']){if($user_policy['gender']=='F')echo 'Female'; if($user_policy['gender']=='M') echo 'Male';} else {echo '-';}?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30"  align="right"><span class="fieldLabel1 form_txt1">Marital Status </span></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="fieldsColumn1"><?php echo $user_policy['marital_status'];?></span></td>
						</tr>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Nationality </span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="fieldsColumn1"><?php echo $user_policy['nationality'];?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30" style="text-align:left;"><div align="right"><span class="fieldLabel1 form_txt1">Date of Birth</span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="item dateofbirth"><?php echo date('d-m-y',strtotime($user_policy['dob']));?></span></td>
						</tr>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Email Id</span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><?php echo $user_policy['email'];?></td>
						  <td height="30">&nbsp;</td>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Mobile Number</span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="fieldLabel1 form_txt1"><?php echo $user_policy['phone1'];?></span></td>
						</tr>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Land Line Number  </span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="item dateofbirth"><?php if($user_policy['phone2']!='') echo $user_policy['phone2']; else echo 'N/A'; ?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Iquama No</span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="fieldLabel1 form_txt1"><?php echo $user_policy['iquama_no'];?></span></td>
						</tr>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Address </span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="item dateofbirth"><?php echo $user_policy['address1'];?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Country </span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="fieldLabel1 form_txt1"><?php if($policy_type=='auto'){echo $user_policy['country'];} else{  echo getCountryName($user_policy['country']);}?></span></td>
						</tr>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">State </span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="item dateofbirth"><?php if($policy_type=='auto'){echo $user_policy['state'];}else{echo getStateName($user_policy['state']);}?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Postal Code </span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="fieldLabel1 form_txt1"><?php echo $user_policy['postal_code'];?></span></td>
						</tr>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Occupation</span></div></td>
                           <td width="11" height="30"><div align="center">:</div></td>
						  <td height="30" align="left"><span class="item dateofbirth"><?php if($user_policy['occupation'])echo $user_policy['occupation']; else echo '-';?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30"><span class="fieldLabel1 form_txt1"> </span></td>
						  <td height="30"><span class="fieldLabel1 form_txt1"></span></td>
						</tr>
					  </table>
					</div>
				  </div>
				  <div class="mask" style="height:10px;"></div>
				  
				  <div class="your-quoatation1">
					 <div class="your-quoatation-inner1">
					  <table width="623" border="0" cellpadding="2" cellspacing="4">
						<tr>
						  <td height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue">Attachments</span></td>
						</tr>
				
						<tr style="font-weight:bold">
						  <td height="30"><span class="fieldLabel1 form_txt1">Attachment Name</span></td>
						  <td height="30">&nbsp;<span class="item dateofbirth">Attachment File</span></td>
						</tr>
						<?php $atotal=mysql_num_rows($attachments);
						if($atotal > 0)
						{
							while($attachment=mysql_fetch_array($attachments))
							{?>
								<tr>
								  <td height="30"><span class="fieldLabel1 form_txt1"><?php echo $attachment['attachment_name'];?></span></td>
								  <td height="30">&nbsp;<span class="item dateofbirth">
								  <?php if($attachment['upload_file'])
									{
										$file=explode('_',$attachment['upload_file']);
										$file_name=str_replace($file[0].'_','',$attachment['upload_file']);
									}?>
									<a href="<?php echo str_replace('admin/','',BASE_URL).'download.php?dir=upload/attachments/'.$policy_type.'/&f='.$attachment['upload_file'];?>"><?php echo $file_name;?></a>
								  </span></td>
								</tr>
						<?php }
						}
						else
						{?>
							<tr><td colspan="5">No Attachment Found.</td></tr><?php 
						}?>
						
					  </table>
					  
					</div>
				  </div>

				  <div class="mask" style="height:10px;"></div>
			<?php if($policy_type=='travel')
			{?>				
				  <div class="your-quoatation1">
					 <div class="your-quoatation-inner1">
					  <table width="644" border="0" cellpadding="2" cellspacing="4">
						<tr>
						  <td height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue">Traveller (s) Information</span></td>
						</tr>
				
						<tr style="font-weight:bold">
						  <td height="30"align="left"><span class="fieldLabel1 form_txt1">First Name</span></td>
						  <td height="30"align="left">&nbsp;<span class="item dateofbirth">Last Name</span></td>
						  <td height="30"align="left">&nbsp;</td>
						  <td height="30"align="left"><span class="fieldLabel1 form_txt1">Date Of Birth</span></td>
						  <td height="30"align="left"><span class="fieldLabel1 form_txt1">Gender</span></td>
						</tr>
						<?php $total=mysql_num_rows($travellers);
						if($total > 0)
						{
							while($traveller=mysql_fetch_array($travellers))
							{?>
								<tr>
								  <td height="30" align="left"><span class="fieldLabel1 form_txt1"><?php echo $traveller['fname'];?></span></td>
								  <td height="30" align="left">&nbsp;<span class="item dateofbirth"><?php echo $traveller['lname'];?></span></td>
								  <td height="30">&nbsp;</td>
								  <td height="30" align="left"><span class="fieldLabel1 form_txt1"><?php echo date('d-m-y',strtotime($traveller['dob']));?></span></td>
								  <td height="30" align="left"><span class="fieldLabel1 form_txt1"><?php if($traveller['gender']=='F')echo 'Female'; if($traveller['gender']=='M') echo 'Male';?></span></td>
								</tr>
						<?php }
						}
						else
						{?>
							<tr><td colspan="5">No travellers found</td></tr><?php 
						}?>
						
					  </table>
					  
					</div>
				  </div>
				  <div class="mask" style="height:10px;"></div>
				  
				  <div class="your-quoatation1">
					 <div class="your-quoatation-inner1">
					  <table width="623" border="0" cellpadding="2" cellspacing="4">
						<tr>
						  <td height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue">Travel Information </span></td>
						</tr>
						<tr>
						  <td width="170" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Type of Coverage:</span></span></div></td>
						  <td width="138" height="30" align="left"><span class="item dateofbirth"><?php echo $user_travel_policy['trip_type'];?></span></td>
						  <td width="11" height="30">&nbsp;</td>
						  <td width="116" height="30" align="right">&nbsp;<span class="fieldLabel form_txt1">Geographic<br />
						  Coverage:</span></td>
						  <td width="144" height="30"align="left"><span class="item dateofbirth">
						  <?php 
						  if($user_travel_policy['geo_coverage']=='1')echo 'Worldwide excluding US and Canada';
						  if($user_travel_policy['geo_coverage']=='2')echo 'Worldwide including US and Canada';
						  if($user_travel_policy['geo_coverage']=='3')echo 'Schengen';
						  if($user_travel_policy['geo_coverage']=='4')echo 'GCC and Jordan';?>
						  </span></td>
						</tr>
					<?php if($user_travel_policy['trip_type']=='Multi')
					{?>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Period of Travel:</span></div></td>
						  <td width="138" height="30"align="left"><?php echo $user_travel_policy['perid_of_travel'];?> Months</td>
						  <td height="30">&nbsp;</td>
						  <td height="30" style="text-align:left;"><div align="right"><span class="fieldLabel1 form_txt1">Reason for Travel</span></div></td>
						  <td height="30"align="left"><span class="fieldsColumn1">
						  <?php if($user_travel_policy['reason_for_travel']=='1')echo 'Business';
						  if($user_travel_policy['reason_for_travel']=='2')echo 'Holidays';
						  if($user_travel_policy['reason_for_travel']=='3')echo 'Business and Holidays';?>
						  </span></td>
						</tr>
					<?php }
					if($user_travel_policy['trip_type']=='Single')
					{?>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Departure Date:</span></div></td>
						  <td height="30"align="left"><span class="fieldsColumn1"><?php echo date('d-m-Y',strtotime($user_travel_policy['departure_date']));?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30" style="text-align:left;"><div align="right"><span class="fieldLabel1 form_txt1">Return  Date</span></div></td>
						  <td height="30"align="left"><span class="fieldsColumn1"><?php echo date('d-m-Y',strtotime($user_travel_policy['return_date']));?></span></td>
						</tr>
					<?php }?>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Country: </span></div></td>
						  <td height="30"align="left"><span class="fieldsColumn1"><?php echo getCountryName($user_policy['country']);?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30" style="text-align:left;"><div align="right"><span class="fieldLabel1 form_txt1">Provinces / State </span></div></td>
						  <td height="30"align="left"><span class="fieldsColumn1"><?php echo getStateName($user_policy['state']);?></span></td>
						</tr>
						
					  </table>
					</div>
				  </div>
				  <div class="mask" style="height:10px;"></div>
				  <?php 
					$policy_id=$user_travel_policy['comp_policy_id'];
					$sql="select * from ".USERTRAVELPOLICY." where comp_policy_id='".$policy_id."'";
					$policy_details=mysql_fetch_assoc(mysql_query($sql));
					$c_detail=getCompanyDetails($policy_details['comp_id']);
					?>
				  <div class="your-quoatation" style="margin-left:3px;">
						<div class="your-quoatation-inner">
						  <div class="quoatation-imgarea"><img src="<?php echo str_replace('admin/','',BASE_URL);?>upload/company/<?php if($c_detail['comp_logo'])echo $c_detail['comp_logo']; else echo 'no-image.jpg';?>" width="84" height="69" /></div>
							
						  <div class="quoatation-contarea" style="width:520px; margin-right:0px;">
							<table width="100%">
								<tr>
									<td colspan="9" width="520" class="blue-15">TRAVEL INSURANCE </td>
								</tr>
								<tr>
									<td width="100%">
										<table cellpadding="0" cellspacing="0">
											<tr>
												<td height="10" colspan="9" style="border-top:1px dotted #CCCCCC;">&nbsp;</td>
											</tr>
											<tr>
												<td width="176" class="popular_list_heading2" style="text-align:left;">laggage Loss </td>
												<td width="10">&nbsp;</td>
												<td width="132" class="popular_list_heading2">Baggage Delay </td>
												<td width="10">&nbsp;</td>
												<td width="184" class="popular_list_heading2">Flight Delay  </td>
										  </tr>
											<tr>
												<td colspan="9"  style="border-bottom:1px dotted #CCCCCC;">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="9">&nbsp;</td>
											</tr>
											<tr>
												<td width="176" class="popular_list_heading" style="border-right:1px dotted #CCCCCC;">
													<?php if($policy_details['luggage_loss_note'])echo $policy_details['luggage_loss_note']; else echo 'Not Covered ';?>												
												</td>
												<td width="10">&nbsp;</td>
												<td width="132" class="popular_list_heading2"  style="border-right:1px dotted #CCCCCC;"><?php if($policy_details['baggage_delay_note'])echo $policy_details['baggage_delay_note']; else echo 'Not Covered ';?></td>
												<td width="10">&nbsp;</td>
												<td width="184" class="popular_list_heading2"  style="border-right:1px dotted #CCCCCC;"><span class="popular_list_heading2" style="border-right:1px dotted #CCCCCC;"><?php if($policy_details['flight_delay_note'])echo $policy_details['flight_delay_note']; else echo 'Not Covered ';?></span></td>
										  </tr>
											<tr>
												<td colspan="9"  style="border-bottom:1px dotted #CCCCCC;">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="9">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="9" style="height:15px;">&nbsp;<b>Policy Amount : </b><?php echo $policy_amt.'<br>';
												if($payment['is_discount']=='1')
												{
													echo '&nbsp;<b>Discount : </b>'.$discount.'%<br>';?>
													&nbsp;<b>Total Policy Amount Paid : </b><?php echo $amount.' '.CURRENCY;
												}?>
												<a id="fancy_policy" href="<?php echo BASE_URL;?>public/coverage_details.php?id=<?php echo $policy_no; ?>&type=travel"><input name="Btn_Submit" value="Policy Details" class="viewdetails" type="button" style="float:right"></a></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						  </div>
					  </div>
					</div>
			<?php }?>	  
			
			<?php if($policy_type=='medical')
			{?>				
				  <div class="your-quoatation1">
					 <div class="your-quoatation-inner1">
					  <table width="623" border="0" cellpadding="2" cellspacing="4">
						<tr>
						  <td height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue"><?php if($policy_type=='travel')echo 'Traveller (s) Information'; if($policy_type=='medical')echo 'Insurance Members';?></span></td>
						</tr>
						
						<tr style="font-weight:bold">
						  <td height="30"><span class="fieldLabel1 form_txt1">Gender</span></td>
						  <td height="30">&nbsp;<span class="item dateofbirth">Date Of Birth</span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30"><span class="fieldLabel1 form_txt1">Dental</span></td>
						  <td height="30"><span class="fieldLabel1 form_txt1">Maternity</span></td>
						</tr>
						<?php $total=mysql_num_rows($members);
						if($total > 0)
						{
							while($member=mysql_fetch_array($members))
							{?>
								<tr>
								  <td height="30"><span class="fieldLabel1 form_txt1"><?php if($member['gender']=='M')echo 'Male';if($member['gender']=='F')echo 'Female';?></span></td>
								  <td height="30">&nbsp;<span class="item dateofbirth"><?php echo date('d-m-y',strtotime($member['dob']));?></span></td>
								  <td height="30">&nbsp;</td>
								  <td height="30"><span class="fieldLabel1 form_txt1"><?php if($member['dental']=='1')echo 'Yes';if($member['dental']=='0')echo 'No';?></span></td>
								  <td height="30"><span class="fieldLabel1 form_txt1"><?php if($member['maternity']=='1')echo 'Yes';if($member['maternity']=='0')echo 'No';?></span></td>
								</tr>
						<?php }
						}
						else
						{?>
							<tr><td colspan="5">No Insurance Member Found</td></tr><?php 
						}?>
						
					  </table>
					  
					</div>
				  </div>
				  <div class="mask" style="height:10px;"></div>
				  
				  <div class="your-quoatation1">
					 <div class="your-quoatation-inner1">
					  <table width="623" border="0" cellpadding="2" cellspacing="4">
						<tr>
						  <td height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue">Policy Information </span></td>
						</tr>
						<tr>
						  <td width="170" height="30" style="text-align:left;"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Area of Coverage</span></span></td>
						  <td colspan="3" height="30">&nbsp;<span class="item dateofbirth"><?php echo getCoverageType($user_health_policy['coverage_type']);?></span></td>
						  <td width="144" height="30">&nbsp; </td>
						</tr>
						<?php /*?><tr>
						  <td height="30"><span class="fieldLabel1 form_txt1">Country </span></td>
						  <td height="30"><span class="fieldsColumn1"><?php echo getCountryName($user_health_policy['country']);?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30" style="text-align:left;"><span class="fieldLabel1 form_txt1">Provinces / State </span></td>
						  <td height="30">&nbsp;<span class="fieldsColumn1"><?php echo getStateName($user_health_policy['state']);?></span></td>
						</tr><?php */?>
						<tr>
						  <td height="30"><span class="fieldLabel1 form_txt1">Policy From Date </span></td>
						  <td height="30"><span class="fieldsColumn1"><?php echo date('d-m-Y',strtotime($user_policy['policy_from_date']));?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30" style="text-align:left;"><span class="fieldLabel1 form_txt1">Policy To Date</span></td>
						  <td height="30">&nbsp;<span class="fieldsColumn1"><?php echo date('d-m-Y',strtotime($user_policy['policy_to_date']));?></span></td>
						</tr>
						
					  </table>
					</div>
				  </div>
				  <div class="mask" style="height:10px;"></div>
				  <?php 
					$policy_id=$user_health_policy['comp_policy_id'];
					$sql="select * from ".USERHEALTHPOLICY." where comp_policy_id='".$policy_id."'";
					$policy_details=mysql_fetch_assoc(mysql_query($sql));
					$c_detail=getCompanyDetails($policy_details['comp_id']);
					?>
				  <div class="your-quoatation" style="margin-left:3px;">
						<div class="your-quoatation-inner">
						  <div class="quoatation-imgarea"><img src="<?php echo str_replace('admin/','',BASE_URL);?>upload/company/<?php if($c_detail['comp_logo'])echo $c_detail['comp_logo']; else echo 'no-image.jpg';?>" width="84" height="69" /></div>
							
						  <div class="quoatation-contarea" style="width:520px; margin-right:0px;">
							<table width="100%">
								<tr>
									<td colspan="3" width="520" class="blue-15"><?php echo $policy_details['title'];?></td>
								</tr>
								<tr>
									<td width="100%">
										<table cellpadding="0" cellspacing="0">
											<tr>
												<td height="10">&nbsp;</td>
											</tr>
											<tr>
												<td width="130" class="popular_list_heading">Excess</td>
												<td width="10">&nbsp;</td>
												<td width="130" class="popular_list_heading">Maximum Cover per Annum</td>
												<td width="10">&nbsp;</td>
												<td width="231" class="popular_list_heading">Network of Hospitals, Clinics, Pharmacies</td>
											</tr>
											<tr>
												<td colspan="5"  style="border-bottom:1px dotted #CCCCCC;">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="5">&nbsp;</td>
											</tr>
											<tr>
												<td width="130" class="popular_list_heading" style="border-right:1px dotted #CCCCCC;">
												<?php echo $user_health_policy['excess_val'];?>
												</td>
												<td width="10">&nbsp;</td>
												<td width="130" class="popular_list_heading"  style="border-right:1px dotted #CCCCCC;"><?php echo $search_policy['max_cover_per_annum_note'];?></td>
												<td width="10">&nbsp;</td>
												<td width="231" class="popular_list_heading">
													<?php if($policy_details['doc_url']!='')
													{?>
														<a href="<?php echo str_replace('admin/','',BASE_URL).'download.php?dir=upload/health_policy/&f='.$policy_details['doc_url'];?>" class="footerareacontent">Click to View List</a>
													<?php }?>
												</td>
											</tr>
											<tr>
												<td colspan="5"  style="border-bottom:1px dotted #CCCCCC;">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="5">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="5">&nbsp;<b>Policy Amount : </b><?php echo $policy_amt.'<br>';
												if($payment['is_discount']=='1')
												{
													echo '&nbsp;<b>Discount : </b>'.$discount.'%<br>';?>
													&nbsp;<b>Total Policy Amount Paid : </b><?php echo $amount.' '.CURRENCY;
												}?>
												
												<a id="fancy_policy" href="<?php echo BASE_URL;?>public/coverage_details.php?id=<?php echo $policy_no; ?>&type=medical"><input name="Btn_Submit" value="Policy Details" class="viewdetails" type="button" style="float:right"></a></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						  </div>
					  </div>
					</div>
			<?php }?>	
			

			<?php if($policy_type=='auto')
			{?>		
			      <div class="your-quoatation1">
					 <div class="your-quoatation-inner1">
					  <table width="680" border="0" cellpadding="2" cellspacing="4">
						<tr>
						  <td height="20" colspan="7" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue">Vehicle Details  </span></td>
						</tr>
						
						<?php if($user_auto_policy['coverage_type'] == 'comp'){?>
					    <tr>
						 <td width="124" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Vehicle Make  </span></span></div></td>
						 <td width="3" height="30">:</td>
						 <td width="167" height="30" align="left"><span class="item dateofbirth"><?php echo $user_auto_policy['vehicle_make_comp'];?></span></td>
						 <td width="1" height="30">&nbsp;</td>
						 <td width="106" height="30" align="right">&nbsp;
					     <span class="fieldLabel form_txt1">Vehicle Model  </span></td>
						 <td width="14" height="30">:</td>
						 <td width="157" height="30" align="left"><span class="item dateofbirth"><?php echo $user_auto_policy['vehicle_model_comp'];?></span></td>
						</tr>
						
						<tr>
						  <td height="30" valign="top"><div align="right"><span class="fieldLabel1 form_txt1">Vehicle Type  </span></div></td>
						  <td width="3" height="30">:</td>
						  <td width="167" height="30" align="left"><span class="fieldsColumn1"><?php echo $user_auto_policy['vehicle_type_comp'];?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30" style="text-align:left;"><div align="right"><span class="fieldLabel1 form_txt1">Purchase Year  </span></div></td>
						  <td width="14" height="30">:</td>
						  <td height="30" align="left"><span class="fieldsColumn1"><?php echo $user_auto_policy['vehicle_purchase_year'];?></span></td>
						</tr>
						<?php } else if($user_auto_policy['coverage_type'] == 'tpl'){?>
					
						 <tr>
						 <td width="124" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Vehicle Type</span></span></div></td>
						 <td width="3" height="30">:</td>
						 <td width="167" height="30" align="left"><span class="item dateofbirth"><?php echo $user_auto_policy['vehicle_type_tpl'];?></span></td>
						 <td width="1" height="30">&nbsp;</td>
						 <td width="106" height="30">&nbsp;
						   <div align="right"><span class="fieldLabel form_txt1">Specification (Cylinders)</span></div></td>
						 <td width="14" height="30">:</td>
						 <td width="157" height="30" align="left"><span class="item dateofbirth"><?php echo $user_auto_policy['vehicle_cylender_tpl'];?></span></td>
						</tr>
						
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Weight of the Vehicle (tons)</span></div></td>
						  <td width="3" height="30">:</td>
						  <td width="167" height="30" align="left"><span class="fieldsColumn1"><?php echo $user_auto_policy['vehicle_weight_tpl'];?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30" style="text-align:left;"><span class="fieldLabel1 form_txt1"> Number of Seats </span></td>
						  <td width="14" height="30">:</td>
						  <td height="30" align="left"><span class="fieldsColumn1"><?php echo $user_auto_policy['vehicle_seats_tpl'];?></span></td>
						</tr> 	
						
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Purchase Year</span></div></td>
						  <td width="3" height="30">:</td>
						  <td width="167" height="30" align="left"><span class="fieldsColumn1"><?php echo $user_auto_policy['vehicle_purchase_year'];?></span></td>
						  <td height="30" colspan="4">&nbsp;</td>
						 
						</tr>
						
						
						<?php } ?>
						
						
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Purchase Price </span></div></td>
						   <td width="3" height="30">:</td>
						  <td height="30" align="left"><span class="fieldsColumn1"><?php echo $user_auto_policy['vehicle_purchase_price'];?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30" style="text-align:left;">&nbsp;</td>
						   <td width="14" height="30">&nbsp;</td>
						  <td height="30" align="right">&nbsp;</td>
						</tr>
						
					
						
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Vehicle mfg. Year </span></div></td>
						   <td width="3" height="30">:</td>
						  <td height="30" align="left"><?php echo $user_auto_policy['vehicle_mfg_year'];?></td>
						  <td height="30">&nbsp;</td>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Chasis No. </span></div></td>
						   <td width="14" height="30">:</td>
						  <td height="30" align="left"><span class="fieldLabel1 form_txt1"><?php echo $user_auto_policy['vehicle_chasis_no'];?></span></td>
						</tr>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Engine No.   </span></div></td>
						   <td width="3" height="30">:</td>
						  <td height="30" align="left"><span class="item dateofbirth"><?php echo $user_auto_policy['vehicle_engine_no'];?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Vehicle Color </span></div></td>
						   <td width="14" height="30">:</td>
						  <td height="30" align="left"><span class="fieldLabel1 form_txt1"><?php echo $user_auto_policy['vehicle_color'];?></span></td>
						</tr>
						<tr>
						  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Driving License No. </span></div></td>
						  <td width="3" height="30">:</td>
						  <td height="30" align="left"><span class="item dateofbirth"><?php echo $user_auto_policy['driving_lincense_no'];?></span></td>
						  <td height="30">&nbsp;</td>
						  <td height="30">&nbsp;</td>
						  <td width="14" height="30">&nbsp;</td>
						  <td height="30" align="right">&nbsp;</td>
						</tr>
						
						<tr>
						  <td height="30" colspan="7" align="right">&nbsp;</td>
						</tr>
					  </table>
					</div>
				  </div>
				  
				  
				  
				  <div class="mask" style="height:10px;"></div>
				  
				  <div class="your-quoatation1">
					 <div class="your-quoatation-inner1">
					  <table width="623" border="0" cellpadding="2" cellspacing="4">
						<tr>
						  <td height="20" colspan="7" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue">Insurance Information  </span></td>
						</tr>
						<tr>
						  <td width="124" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Insurance From  </span></span></div></td>
						  <td width="3" height="30">:</td>
						  <td width="107" height="30" align="left">&nbsp;<span class="item dateofbirth"><?php echo date('d-m-Y',strtotime($user_policy['policy_from_date']));?></span></td>
						  <td width="66" height="30">&nbsp;</td>
						  <td width="34" height="30" align="right">&nbsp;<span class="fieldLabel form_txt1">To  </span></td>
						   <td width="28" height="30">:</td>
						  <td width="201" height="30" align="left"><span class="item dateofbirth">&nbsp;<?php echo date('d-m-Y',strtotime($user_policy['policy_to_date']));?></span></td>
						</tr>
					  </table>
					</div>
				  </div>
				  
				    <div class="mask" style="height:10px;"></div>
				  
				<?php 
				$policy_id=$user_auto_policy['comp_policy_id'];
				$sql="select * from ".USERAUTOPOLICY." where comp_policy_id='".$policy_id."'";
				$policy_details=mysql_fetch_assoc(mysql_query($sql));
				$c_detail=getCompanyDetails($policy_details['comp_id']);
				?>
				  <div class="your-quoatation" style="margin-left:3px;">
						<div class="your-quoatation-inner">
						  <div class="quoatation-imgarea"><img src="<?php echo str_replace('admin/','',BASE_URL);?>upload/company/<?php if($c_detail['comp_logo'])echo $c_detail['comp_logo']; else echo 'no-image.jpg';?>" width="84" height="69" /></div>
						  
						  
						  <div class="quoatation-contarea" style="width:520px; margin-right:0px;">
							  	<table width="100%">
								<tr>
						  <td height="20" colspan="7" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue">Policy Information  </span></td>
						</tr>
								
									<tr>
										<td colspan="9" width="520" class="blue-15"><?php echo stripslashes($policy_details['title']);?></td>
									</tr>
									<tr>
										<td width="100%">
											<table cellpadding="0" cellspacing="0">
												<tr>
													<td height="10" colspan="9" style="border-top:1px dotted #CCCCCC;">&nbsp;</td>
												</tr>
												<tr>
													<td width="130" class="popular_list_heading2">Road Side Assistance Cover </td>
													<td width="10">&nbsp;</td>
													<td width="130" class="popular_list_heading2">Windscreen Claims </td>
													<td width="10">&nbsp;</td>
													<td width="231" class="popular_list_heading2">Terrytory Cover </td>
													<td width="10">&nbsp;</td>
													<td width="231" class="popular_list_heading2">Excsss</td>
													<td width="10">&nbsp;</td>
													<td width="231" class="popular_list_heading">Third Party Damage</td>
												</tr>
												<tr>
													<td colspan="9"  style="border-bottom:1px dotted #CCCCCC;">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="9">&nbsp;</td>
												</tr>
												<tr>
													<td width="130" class="popular_list_heading" style="border-right:1px dotted #CCCCCC;">
														<?php if($policy_details['rsa_cover'] == '0'){echo "Not Covered";} else if($policy_details['rsa_cover'] == '1'){echo stripslashes($policy_details['rsa_cover_note']);}?>
													</td>
													<td width="10">&nbsp;</td>
													<td width="130" class="popular_list_heading2"  style="border-right:1px dotted #CCCCCC;"><?php if($policy_details['windscreen_claims'] == '0'){echo "Not Covered";} else if($policy_details['windscreen_claims'] == '1'){echo stripslashes($policy_details['windscreen_claims_note']);}?></td>
													<td width="10">&nbsp;</td>
													<td width="231" class="popular_list_heading2"  style="border-right:1px dotted #CCCCCC;"><?php if($policy_details['territory_cover'] == '0'){echo "Not Covered";} else if($policy_details['territory_cover'] == '1'){echo stripslashes($policy_details['territory_cover_note']);}?></td>
													<td width="10">&nbsp;</td>
													<td width="231" class="popular_list_heading2"  style="border-right:1px dotted #CCCCCC;"><?php if($policy_details['excess'] == '0'){echo "Not Covered";} else if($policy_details['excess'] == '1'){echo stripslashes($policy_details['excess_note']);}?></td>
													<td width="10">&nbsp;</td>
													<td width="231" class="popular_list_heading2"><?php if($policy_details['tpp_damage'] == '0'){echo "Not Covered";} else if($policy_details['tpp_damage'] == '1'){echo stripslashes($policy_details['tpp_damage_note']);}?></td>
												</tr>
												<tr>
													<td colspan="9"  style="border-bottom:1px dotted #CCCCCC;">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="9">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="9">
														<table>
															<tr>
																<td width="80" style="height:15px; font-weight:bold;"><?php echo $policy_details['policy_amount'].' '.CURRENCY;?> </td>
																<td width="10">&nbsp;</td>
																<td width="320" align="left"></td>
																<td colspan="5">
																	<a href="<?php echo BASE_URL;?>public/coverage_details.php?id=<?php echo $policy_no; ?>&type=auto" id="fancy_policy"><input name="Btn_Submit" value="Policy Details" class="viewdetails" type="button" style="float:right"></a>																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							  </div>
					  </div>
					</div>
		
				 
				
				
				  
			<?php }
			
			if($policy_type=='malpractice')
			{?>
			   <div class="your-quoatation1">
				 <div class="your-quoatation-inner1">
				  <table width="623" border="0" cellpadding="2" cellspacing="4">
					<tr>
					  <td height="20" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue">Profession Information</span></td>
					</tr>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Profession : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['other_med_prof'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<?php if($user_malpractice_policy['other_med_prof']=='Surjeon' || $user_malpractice_policy['other_med_prof']=='Non Surjeon')
					{?>
					<tr>
					  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Branch Professional </span></div></td>
					  <td width="148" height="30"><span class="fieldsColumn1"><?php echo $user_malpractice_policy['branch_med_prof'];?></span></td>
					  <td height="30">&nbsp;</td>
					  <td height="30" style="text-align:left;">&nbsp;</td>
					  <td height="30">&nbsp;</td>
					</tr>
					<?php }?>
					<tr>
					  <td height="30"><div align="right"><span class="fieldLabel1 form_txt1">Qualification </span></div></td>
					  <td width="148" height="30"><span class="fieldsColumn1"><?php echo $user_malpractice_policy['qualification'];?></span></td>
					  <td height="30">&nbsp;</td>
					  <td height="30" style="text-align:left;" colspan="2">&nbsp;
						<?php if($user_malpractice_policy['qualification']=='Super Speciality')echo $user_malpractice_policy['super_speciality'];?>
					  </td>
					</tr>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Experience of Specialization  : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['experience'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Previous Insurance/ Cliam Information : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php if($user_malpractice_policy['past_insurance']=='1')echo 'Yes';if($user_malpractice_policy['past_insurance']=='0')echo 'No';?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<?php if($user_malpractice_policy['past_insurance']=='1')
					{?>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Insurer : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['insurer'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Terms : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['terms'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Policy Number  : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['past_policy_no'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Expiry Date : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['exp_date'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<?php }?>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Has many insurer ever cancelled : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php if($user_malpractice_policy['canceled_insurer']=='1')echo 'Yes'; if($user_malpractice_policy['canceled_insurer']=='0') echo 'No';?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<?php if($user_malpractice_policy['canceled_insurer']=='1')
					{?>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Cancelled Insurer Details : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['canceled_insurer_details'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<?php }?>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Have you ever had a Claim  : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php if($user_malpractice_policy['is_claim']=='1')echo 'Yes'; if($user_malpractice_policy['is_claim']=='0') echo 'No';?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<?php if($user_malpractice_policy['is_claim']=='1')
					{?>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Date Of Claim : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo date('d-m-Y',strtotime($user_malpractice_policy['claim_date']));?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Amount of Indemhitys : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['indemhyts_amt'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Claimant' Name : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['claimant_name'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Nature of claims : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo $user_malpractice_policy['claim_nature'];?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					<?php }?>
					<tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Policy From Date : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo date('d-m-Y',strtotime($user_policy['policy_from_date']));?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr><tr>
					  <td width="221" height="30" style="text-align:left;"><div align="right"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Policy To Date : </span></span></div></td>
					  <td width="148" height="30">&nbsp;<span class="fieldsColumn1"><?php echo date('d-m-Y',strtotime($user_policy['policy_to_date']));?></span></td>
					  <td width="6" height="30">&nbsp;</td>
					  <td width="181" height="30">&nbsp;</td>
					  <td width="23" height="30">&nbsp;</td>
					</tr>
					
					
				  </table>
				</div>
			  </div> 					   
			  
			  <div class="mask" style="height:10px;"></div>
			   <?php 
				$policy_id=$user_malpractice_policy['comp_policy_id'];
				$sql="select * from ".MALPRACTICEPOLICY." where comp_policy_id='".$policy_id."'";
				$policy_details=mysql_fetch_assoc(mysql_query($sql));
				$c_detail=getCompanyDetails($policy_details['comp_id']);
				?>
			   <div class="your-quoatation" style="margin-left:3px;">
					<div class="your-quoatation-inner">
					  <div class="quoatation-imgarea"><img src="<?php echo str_replace('admin/','',BASE_URL);?>upload/company/<?php if($c_detail['comp_logo'])echo $c_detail['comp_logo']; else echo 'no-image.jpg';?>" width="84" height="69" /></div>
						
					  <div class="quoatation-contarea" style="width:520px; margin-right:0px;">
						<table width="100%">
							<tr>
								<td colspan="9" width="520" class="blue-15"><?php echo $policy_details['title'];?></td>
							</tr>
							<tr>
								<td width="100%">
									<table cellpadding="0" cellspacing="0">
										<tr>
											<td width="100%"></td>
									  </tr>
										<tr>
											<td colspan="9"  style="border-bottom:1px dotted #CCCCCC;">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="4" height="50"  class="normgey-11">
												<?php echo $policy_details['description'];?>
											</td>
										</tr>
										<?php if($policy_details['coverage_details'])
										{?>
										<tr>
											<td colspan="4" height="50"  class="normgey-11">
												Coverage Details : <?php echo $policy_details['coverage_details'];?>
											</td>
										</tr>
										<?php }?>												
										<tr>
											<td colspan="9">
												<table>
													<tr>
														<td width="180" style="height:15px;"><b>Policy Amount : </b><?php echo $policy_details['policy_amount'].' '.CURRENCY;?> </td>
														<td width="10">&nbsp;</td>
														<td width="370" align="left"></td>
														<td align="right" colspan="5"></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					  </div>
				  </div>
				</div> 
			  
			<?php }?>	
			
				  </td>
				</tr>
				</table>
              </div>
              
              
          </div>
          
          <div class="mask" style="height:15px;"></div>
          
        </div>
      </div>
