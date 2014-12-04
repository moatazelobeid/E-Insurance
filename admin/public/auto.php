<?php
if($_GET['type']=='agent')
	$page='agent-policies';
else
	$page='policies';

$user_auto_policy=mysql_fetch_assoc(mysql_query("select * from ".USERAUTOPOLICY." where policy_no='".$policy_no."'"));

if(isset($_POST['save']))
{
	unset($_POST['save']);
	
	$policy_from_date=date('Y-m-d',strtotime($_POST['policy_from_date']));
	$policy_to_date=date('Y-m-d',strtotime($_POST['policy_to_date']));
	$fname=addslashes($_POST['fname']);
	$lname=addslashes($_POST['lname']);
	$dob=date('Y-m-d',strtotime($_POST['dob']));
	$email=addslashes($_POST['email']);
	$iquama_no=addslashes($_POST['iquama_no']);
	$address1=addslashes($_POST['address1']);
	$postal_code=addslashes($_POST['postal_code']);
	$occupation=addslashes($_POST['occupation']);
	$country=addslashes($_POST['country']);
	$state=addslashes($_POST['state']);
	
	//update user policy details
	$db->recordUpdate(array("policy_no" => $policy_no),array("policy_from_date"=>$policy_from_date,"policy_to_date"=>$policy_to_date,"fname"=>$fname,"lname"=>$lname,"gender"=>$_POST['gender'],"marital_status"=>$_POST['marital_status'],"nationality"=>$_POST['nationality'],"dob"=>$dob,"email"=>$email,"phone1"=>$_POST['phone1'],"phone2"=>$_POST['phone2'],"iquama_no"=>$iquama_no,"address1"=>$address1,"postal_code"=>$postal_code,"occupation"=>$occupation,"state"=>$state,"country"=>$country),USERPOLICY);
	
	$vehicle_purchase_price=addslashes($_POST['vehicle_purchase_price']);
	$vehicle_chasis_no=addslashes($_POST['vehicle_chasis_no']);
	$vehicle_engine_no=addslashes($_POST['vehicle_engine_no']);
	$driving_lincense_no=addslashes($_POST['driving_lincense_no']);
	
	$db->recordUpdate(array("policy_no" => $policy_no),array("vehicle_purchase_year"=>$_POST['vehicle_purchase_year'],"vehicle_purchase_price"=>$vehicle_purchase_price,"vehicle_mfg_year"=>$_POST['vehicle_mfg_year'],"vehicle_chasis_no"=>$vehicle_chasis_no,"vehicle_engine_no"=>$vehicle_engine_no,"vehicle_color"=>$_POST['vehicle_color'],"driving_lincense_no"=>$driving_lincense_no),USERAUTOPOLICY);
	
	//update attachments
	$atc_dir='../upload/attachments/auto/';
	$acount=$_POST['attachment_count'];
	for($j=0; $j<$acount; $j++)
	{  
		$atc_name=$_POST['atc_name'][$j];
		$aid=$_POST['aid'][$j]; 
		if($_FILES['atc_file']['name'][$j]!='')
		{
			$file_name=time().'_'.$_FILES['atc_file']['name'][$j];
			$atc_filetmpname=$_FILES['atc_file']['tmp_name'][$j];
			//get and unlink the last attachment
			$sql=mysql_fetch_assoc(mysql_query("select upload_file from ".ATTACHMENTS." where id='".$aid."'"));
			unlink($atc_dir.$sql['upload_file']);
			
			if(move_uploaded_file($atc_filetmpname,$atc_dir.$file_name)==true)
				$db->recordUpdate(array("id" => $aid),array("upload_file"=>$file_name),ATTACHMENTS);
		}
		$db->recordUpdate(array("id" => $aid),array("attachment_name"=>$atc_name),ATTACHMENTS);
	}
	
	echo "<script>alert('Policy updated successfully'); window.location.href='".BASE_URL."account.php?page=".$page."';</script>";
}
?>


<script type="text/javascript">

function getPolicyToDate(val)
{		
	var ptime=$("#ptime").val();
	url="<?php echo str_replace('admin/','',BASE_URL);?>utils/utils.php?task=getPolicyToDate&fromdate="+val+'&ptime='+ptime;
	$.post(url,function(data)
	{	
		$("#policy_to_date").val(data);
	});
}

function getStates(cid)
{
	
	url="<?php echo str_replace('admin/','',BASE_URL);?>utils/utils.php?task=getStates&cid="+cid;
	$.post(url,function(data)
	{	
		$("#state_div").html(data);
	});
	
}


function validForm()
{
	var form = document.policy_form;
	var error = "";
	var flag = true;

	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	if(form.vehicle_purchase_price.value=='')
	{
		form.vehicle_purchase_price.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.vehicle_purchase_price.style.borderColor="";
	}
	if(form.vehicle_chasis_no.value=='')
	{
		form.vehicle_chasis_no.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.vehicle_chasis_no.style.borderColor="";
	}
	if(form.vehicle_engine_no.value=='')
	{
		form.vehicle_engine_no.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.vehicle_engine_no.style.borderColor="";
	}
	if(form.driving_lincense_no.value=='')
	{
		form.driving_lincense_no.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.driving_lincense_no.style.borderColor="";
	}
	
	
	var acount=$("#attachment_count").val();
	acount=parseInt(acount)+1;
	for(var j=1; j<acount; j++)
	{ 
		if($("#atc_name_"+j).val()=='')
		{
			$("#atc_name_"+j).css("borderColor", "red");
			flag= false;
		}
		else
		{
			$("#atc_name_"+j).css("borderColor", "");
		}
		if($("#atc_file_"+j).val()=='' && $("#file_name_"+j).val()=='')
		{
			$("#atc_file_"+j).css("borderColor", "red");
			flag= false;
		}
		else
		{
			$("#atc_file_"+j).css("borderColor", "");
		}
	}
		
	
	if(form.fname.value=='')
	{
		form.fname.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.fname.style.borderColor="";
	}
	if(form.lname.value=='')
	{
		form.lname.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.lname.style.borderColor="";
	}
	if(form.dob.value=='')
	{
		form.dob.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.dob.style.borderColor="";
	}
	if(!filter.test(form.email.value))
	{
		form.email.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.email.style.borderColor="";
	}
	if(form.phone1.value=='')
	{
		form.phone1.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.phone1.style.borderColor="";
	}
	if(form.iquama_no.value.length !='10')
	{
		form.iquama_no.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.iquama_no.style.borderColor="";
	}
	if(form.address1.value=='')
	{
		form.address1.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.address1.style.borderColor="";
	}
	if(form.postal_code.value=='')
	{
		form.postal_code.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.postal_code.style.borderColor="";
	}
	if(form.state.value=='')
	{
		form.state.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.state.style.borderColor="";
	}
	if(form.occupation.value=='')
	{
		form.occupation.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.occupation.style.borderColor="";
	}
	if(form.policy_from_date.value=='')
	{
		form.policy_from_date.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.policy_from_date.style.borderColor="";
	}
	if(flag == false)
		return false;
	else
		return true;
	
}
</script>
<script type="text/javascript">

function checkEmail(id)
{    
	var uid=$("#uid").val();
	if(id!='')
	{
    $.ajax({
         type: "POST",
         url: "util/ajax-chk.php",
         data: "chk_email="+ id + "&type=user&id="+uid,
         success: function(msg){
		 if(msg == 'ERROR')
			{
			$("#dr_span").html("This Emial ID already registered.");
			document.getElementById('email').value = '';
			}
			else if(msg == 'OK')
			{
			$("#dr_span").html("");
			}else if(msg == 'BLANK')
			{
			 $("#dr_span").html("Please Enter a Valid Emial ID");
			}			       
		  }    
		});
	}
}

function isNumberKey(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
}
</script>

<table width="875" border="0" align="center" cellpadding="3" cellspacing="0" style="border-bottom: 1px solid #CCC; margin-top: 0px; margin-bottom:10px;">
  <tr>
    <td width="662" style="padding-bottom: 2px; padding-left: 0px; font-size: 14px; color: #036;">
    <strong>Edit Policy</strong>
    </td>
    <td align="right" style="padding-bottom: 5px; font-size: 14px; color: #036; padding-right: 1px;">
      <input type="button" name="addnew" class="actionBtn" id="addnew" value=" View Policy List " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; cursor: pointer;" onclick="location.href='<?php echo BASE_URL?>account.php?page=<?php echo $page;?>'"/>
      </td>
  </tr>
</table>

<form action="" method="post" name="policy_form" id='policy_form' enctype="multipart/form-data">
<input type="hidden" name="ptime" id="ptime" value="12" />
<input type="hidden" name="uid" id="uid" value="<?php echo $user_policy_details['uid'];?>" />
<table width="875" cellpadding="4" cellspacing="" align="center">
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>Vehicle Information</strong></td>
	</tr>
	<?php if($user_auto_policy['coverage_type']=='comp')
	{?>
		<tr>
			<td><span class="fieldLabel form_txt1">Vehicle Make  :</span> </td>
			<td><?php echo $user_auto_policy['vehicle_make_comp'];?></td>
		</tr>
		<tr class="fieldRow1">
		 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Vehicle Model  :</span></td>
		 <td class="fieldsColumn1"><?php echo $user_auto_policy['vehicle_model_comp'];?></td>
		</tr>
		<tr class="fieldRow1">
		 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Vehicle Type  :</span></td>
		 <td class="fieldsColumn1"> <?php echo $user_auto_policy['vehicle_type_comp'];?> </td>
		</tr>
		<tr class="fieldRow1">
		 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Agency Repair  :</span></td>
		 <td class="fieldsColumn1"><?php if($user_auto_policy['is_agency_repair']=='1')echo 'Yes'; else echo 'No';?></td>
		</tr>
		<tr class="fieldRow1">
		 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">No Claim Discount (NCD)  :</span></td>
		 <td class="fieldsColumn1"><?php echo $user_auto_policy['no_of_ncd'];?></td>
		</tr>
	<?php  }
	if($user_auto_policy['coverage_type']=='tpl')
	{?>
		<tr class="fieldRow1">
		 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Vehicle Type  :</span></td>
		 <td class="fieldsColumn1"> <?php echo $user_auto_policy['vehicle_type_tpl'];?> </td>
		</tr>
		<tr class="fieldRow1">
		 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Specification (Cylinders)  :</span></td>
		 <td class="fieldsColumn1"> <?php echo $user_auto_policy['vehicle_cylender_tpl'];?> </td>
		</tr>
		<tr class="fieldRow1">
		 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Weight of the Vehicle (tons)  :</span></td>
		 <td class="fieldsColumn1"> <?php echo $user_auto_policy['vehicle_weight_tpl'];?> </td>
		</tr>
		<tr class="fieldRow1">
		 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Number of Seats  :</span></td>
		 <td class="fieldsColumn1"> <?php echo $user_auto_policy['vehicle_seats_tpl'];?> </td>
		</tr>
	<?php }?>
	<tr class="fieldRow1">
	 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Purchase Year   :</span></td>
	 <td class="fieldsColumn1">
	 <select name="vehicle_purchase_year" id="vehicle_purchase_year" class="generalDropDown">
	  <?php for($i = 2000;$i<=date('Y');$i++){?>
	  <option value="<?php echo $i;?>" <?php if($user_auto_policy['vehicle_purchase_year'] == $i){echo "selected";}?>><?php echo $i;?></option>
	  <?php }?>
	 </select>
	 </td>
	</tr>
	<tr class="fieldRow1">
	 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Purchase Price   :</span></td>
	 <td class="fieldsColumn1"><input type="text" name="vehicle_purchase_price" value="<?php echo $user_auto_policy['vehicle_purchase_price'];?>" /></td>
	</tr>
	<tr class="fieldRow1">
	 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Mfg. Years   :</span></td>
	 <td class="fieldsColumn1"><select name="vehicle_mfg_year" id="select" class="generalDropDown">
       <?php for($i = 2000;$i<=date('Y');$i++){?>
       <option value="<?php echo $i;?>" <?php if($user_auto_policy['vehicle_mfg_year'] == $i){echo "selected";}?>><?php echo $i;?></option>
       <?php }?>
     </select></td>
	</tr>
	<tr class="fieldRow1">
	 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Chasis Number   :</span></td>
	 <td class="fieldsColumn1"><input type="text" name="vehicle_chasis_no" value="<?php echo $user_auto_policy['vehicle_chasis_no'];?>" /></td>
	</tr>
	<tr class="fieldRow1">
	 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Engine Number    :</span></td>
	 <td class="fieldsColumn1"><input type="text" name="vehicle_engine_no" value="<?php echo $user_auto_policy['vehicle_engine_no'];?>" /></td>
	</tr>
	<tr class="fieldRow1">
	 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Vehicle Color    :</span></td>
	 <td class="fieldsColumn1">
	 <select name="vehicle_color" id="select" class="generalDropDown">
       <option value="red" <?php if($user_auto_policy['vehicle_color']=='red')echo 'selected="selected"';?> >Red</option>
       <option value="green" <?php if($user_auto_policy['vehicle_color']=='green')echo 'selected="selected"';?> >Green</option>
       <option value="blue" <?php if($user_auto_policy['vehicle_color']=='blue')echo 'selected="selected"';?> >Blue</option>
       <option value="black" <?php if($user_auto_policy['vehicle_color']=='black')echo 'selected="selected"';?> >Black</option>
       <option value="white" <?php if($user_auto_policy['vehicle_color']=='white')echo 'selected="selected"';?> >White</option>
	 </select>
	 </td>
	</tr>
	<tr class="fieldRow1">
	 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Driving License No    :</span></td>
	 <td class="fieldsColumn1"><input type="text" name="driving_lincense_no" value="<?php echo $user_auto_policy['driving_lincense_no'];?>" /></td>
	</tr>
	
	<tr height="10"></tr>
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>Attachments</strong></td>
	</tr>
	<tr>
		<td colspan="2">
		<?php $idno=1; while($attachment=mysql_fetch_array($attachments))
		{?>
			<table width="100%" id="sattachment-<?php echo $i;?>">
				<tr height="54">
					<td width="13%"><span class="form_txt1" style="font-weight:700; padding-left:5px;">Attachment :</span></td>
					<td width="8%"><span class="form_txt1"> Name : </span><span class="mandFieldIndicator1">*</span></td>
					<td width="10%">
						<input name="atc_name[]" class="generalTextBox" type="text" id="atc_name_<?php echo $idno;?>" style="margin-right:5px; width:150px;" value="<?php echo $attachment['attachment_name'];?>"  />
				  </td>
					<td width="12%"><span class="form_txt1">Upload File : </span><span class="mandFieldIndicator1">*</span></td>
					<td width="30%">
						<?php if($attachment['upload_file'])
						{
							$file=explode('_',$attachment['upload_file']);
							$file_name=str_replace($file[0].'_','',$attachment['upload_file']);
							echo $file_name.'<br>';
						}?>
						<input name="atc_file[]" class="generalTextBox" type="file" id="atc_file_<?php echo $idno;?>" style="height:22px; margin-right:5px; width:200px;" value=""  />							
						<input type="hidden" id="file_name_<?php echo $idno;?>" value="<?php echo $attachment['upload_file'];?>" />
						<input type="hidden" name="aid[]" value="<?php echo $attachment['id'];?>" />
				  </td>
				  <td width="5%"></td>
				</tr>
			</table>
		<?php $idno++;}?>
		<input type="hidden" name="attachment_count" id="attachment_count" value="<?php echo mysql_num_rows($attachments);?>" />
		<?php if(mysql_num_rows($attachments)=='0')echo 'No attachment found.';?>
		</td>
	</tr>
	
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>Quotation Details</strong></td>
	</tr>
	<tr>
		<?php 
		$policy_id=$user_auto_policy['comp_policy_id'];
		$sql="select * from ".AUTOPOLICY." where comp_policy_id='".$policy_id."'";
		$policy_details=mysql_fetch_assoc(mysql_query($sql));
		$c_detail=getCompanyDetails($policy_details['comp_id']);
		?>
		<td colspan="2">
			<div style="float:left; padding-right:10px;"><img src="<?php echo str_replace('admin/','',BASE_URL);?>upload/company/<?php if($c_detail['comp_logo'])echo $c_detail['comp_logo']; else echo 'no-image.jpg';?>" width="84" height="69" /></div>
			<?php echo $policy_details['title'];?><br />
			Road Side Assistance Cover  : <?php if($policy_details['rsa_cover_note'])echo $policy_details['rsa_cover_note']; else echo 'Not Covered ';?><br />
			Windscreen Claims  : <?php if($policy_details['windscreen_claims_note'])echo $policy_details['windscreen_claims_note']; else echo 'Not Covered ';?><br />
			Excsss : <?php if($policy_details['excess_note'])echo $policy_details['excess_note']; else echo 'Not Covered ';?><br />
			Third Party Damage : <?php if($policy_details['tpp_damage_note'])echo $policy_details['tpp_damage_note']; else echo 'Not Covered ';?><br />
			Policy Amount : <?php echo $payment_details['policy_amt'].' '.CURRENCY; ?> 		</td>
	</tr>
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>Customer Details</strong></td>
	</tr>
	<tr>
		<td>First Name</td>
		<td><input type="text" name="fname" value="<?php echo stripcslashes($user_policy_details['fname']);?>" class="textbox" /></td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td><input type="text" name="lname" value="<?php echo stripcslashes($user_policy_details['lname']);?>" class="textbox" /></td>
	</tr>
	<tr>
		<td>Gender</td>
		<td><input type="radio" name="gender" value="M" <?php if($user_policy_details['gender']=='M') echo 'checked="checked"';?>  />&nbsp;Male
		<input type="radio" name="gender" value="F"  <?php if($user_policy_details['gender']=='F') echo 'checked="checked"';?> />&nbsp;Female</td>
	</tr>
	<tr>
		<td>Marital Status</td>
		<td>
			<select name="marital_status" >
				<option value="single" <?php if($user_policy_details['marital_status']=='single') echo 'selected="selected"';?>>Single</option>
				<option value="married" <?php if($user_policy_details['marital_status']=='married') echo 'selected="selected"';?>>Married</option>
			</select>		</td>
	</tr>
	<tr>
		<td>Nationality</td>
		<td>
		<select name="nationality"  class="generalDropDown">
			<?php $countries=mysql_query("select * from ".COUNTRY." where status='1'");
		   while($countrylist=mysql_fetch_array($countries))
		   {?>
			   <option value="<?php echo $countrylist['country'];?>" <?php if($user_policy_details['nationality']==$countrylist['country']) echo 'selected="selected"';?>><?php echo $countrylist['country'];?></option>
		   <?php }?>
	   </select>	   </td>
	</tr>
	<tr>
		<td>Date Of Birth</td>
		<td>
		<input type="text" name="dob" class="dob" value="<?php echo date('d-m-Y',strtotime($user_policy_details['dob']));?>" /></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><span id="dr_span" style="color:#FF0000;"></span><br />
		<input type="text" name="email" id="email" value="<?php echo stripslashes($user_policy_details['email']);?>" onblur="checkEmail(this.value);" /></td>
	</tr>
	<tr>
		<td>Mobile Number</td>
		<td>
		<input type="text" name="phone1" value="<?php echo $user_policy_details['phone1'];?>" onkeypress="return isNumberKey(event);" /></td>
	</tr>
	<tr>
		<td>Landline Number</td>
		<td>
		<input type="text" name="phone2" value="<?php echo $user_policy_details['phone2'];?>" onkeypress="return isNumberKey(event);" /></td>
	</tr>
	<tr>
		<td>Iquama Number</td>
		<td>
		<input type="text" name="iquama_no" value="<?php echo stripslashes($user_policy_details['iquama_no']);?>" /></td>
	</tr>
	<tr>
		<td>Address</td>
		<td>
		<textarea name="address1" style="height:50px; resize:none;" class="generalTextBox"><?php echo stripslashes($user_policy_details['address1']);?></textarea>		</td>
	</tr>
	<tr>
		<td>Country</td>
		<td>
		<select name="country" onchange="getStates(this.value);"  class="generalDropDown">
			<?php 
			$clist=mysql_query("select * from ".COUNTRY." where status='1'");
			while($country=mysql_fetch_array($clist))
			{?>
			   <option value="<?php echo $country['country'];?>" <?php if($user_policy_details['country']==$country['country']) echo 'selected="selected"';?>><?php echo $country['country'];?></option>
			<?php }?>
		</select>		</td>
	</tr>
	<tr>
		<td>State</td>
		<td id="state_div">
		<?php 
			$sql=mysql_query("select a.* from ".STATE." as a inner join ".COUNTRY." as b on a.country_id=b.id where a.status='1' and b.country='".$user_policy_details['country']."'");?>
		<select name="state" class="generalDropDown">
			
		   <?php 
			while($state=mysql_fetch_array($sql))
			{?>
				<option value="<?php echo $state['state'];?>" <?php if($user_policy_details['state']==$state['state']) echo 'selected="selected"';?>><?php echo $state['state'];?></option><?php 
			}?>
		</select>		</td>
	</tr>
	<tr>
		<td>Postal Code</td>
		<td>
		<input type="text" name="postal_code" value="<?php echo stripslashes($user_policy_details['postal_code']);?>" /></td>
	</tr>
	<tr>
		<td>Occupation</td>
		<td>
		<input type="text" name="occupation" value="<?php echo stripslashes($user_policy_details['occupation']);?>" /></td>
	</tr>
	<tr>
		<td>Policy From Date</td>
		<td>
		<input type="text" name="policy_from_date" onchange="getPolicyToDate(this.value);" value="<?php echo date('d-m-Y',strtotime($user_policy_details['policy_from_date']));?>" class="calender" readonly="readonly"/></td>
	</tr>
	<tr>
		<td>Policy To Date</td>
		<td>
		<input type="text" name="policy_to_date" id="policy_to_date" value="<?php echo date('d-m-Y',strtotime($user_policy_details['policy_to_date']));?>" readonly="readonly" /></td>
	</tr>
	<tr>
		<td></td>
		<td>
		<input type="submit" name="save" value="Update" onclick="return validForm();" class="actionBtn" /></td>
	</tr>
</table>
</form>