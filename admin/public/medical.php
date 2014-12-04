<?php
if($_GET['type']=='agent')
	$page='agent-policies';
else
	$page='policies';

$members=mysql_query("select * from ".USERHEALTHPOLICYMEMBERS." where policy_no='".$policy_no."'"); 
$user_health_policy=mysql_fetch_assoc(mysql_query("select * from ".USERHEALTHPOLICY." where policy_no='".$policy_no."'"));

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
	
	//update user policy details
	$db->recordUpdate(array("policy_no" => $policy_no),array("policy_from_date"=>$policy_from_date,"policy_to_date"=>$policy_to_date,"fname"=>$fname,"lname"=>$lname,"gender"=>$_POST['gender'],"marital_status"=>$_POST['marital_status'],"nationality"=>$_POST['nationality'],"dob"=>$dob,"email"=>$email,"phone1"=>$_POST['phone1'],"phone2"=>$_POST['phone2'],"iquama_no"=>$iquama_no,"address1"=>$address1,"postal_code"=>$postal_code,"occupation"=>$occupation,"state"=>$_POST['state'],"country"=>$_POST['country']),USERPOLICY);
	
	//update insurance members details
	$count=$_POST['count'];
	for($i=0; $i<$count; $i++)
	{
		$mgender=$_POST['mgender'][$i];
		$mdob=date('Y-m-d',strtotime($_POST['mdob'][$i]));
		$mid=$_POST['mid'][$i]; 
		$dental=$_POST['mdental'][0];
		$maternity=$_POST['mmaternity'][0];
		
		$db->recordUpdate(array("id" => $mid),array("gender"=>$mgender,"dob"=>$mdob,"dental"=>$dental,"maternity"=>$maternity),USERHEALTHPOLICYMEMBERS);
	}
	
	//update attachments
	$atc_dir='../upload/attachments/medical/';
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

function checkAllDental()
{
	count=document.getElementsByName('mdental[]').length;
	if(document.getElementById("dental_1").checked ==true)
	{
		for(var i=2; i<=count; i++)
		{
			document.getElementById("dental_"+i).checked =true;
		}
	}
	if(document.getElementById("dental_1").checked ==false)
	{
		for(var i=2; i<=count; i++)
		{
			document.getElementById("dental_"+i).checked =false;
		}
	}
}
function checkAllMaternity()
{
	count=document.getElementsByName('mmaternity[]').length;
	if(document.getElementById("maternity_1").checked ==true)
	{
		for(var i=2; i<=count; i++)
		{
			document.getElementById("maternity_"+i).checked =true;
		}
	}
	if(document.getElementById("maternity_1").checked ==false)
	{
		for(var i=2; i<=count; i++)
		{
			document.getElementById("maternity_"+i).checked =false;
		}
	}
}

$(function() {
	
	var count=$("#count").val();
	count=parseInt(count)+1;
		
	for (var i=1; i<=count; i++)
	{
		$('#dob_'+i).datepicker({
		inline: true,
		yearRange: "-100:+0", 
		dateFormat: "dd-mm-yy",
		changeMonth:true,
		changeYear:true,
		});
	}	
		
});

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
	var total=form.count.value;
	total=parseInt(total)+1;
	
	for(var i=1; i<total; i++)
	{
		if($("#dob_"+i).val()=='')
		{
			$("#dob_"+i).css("borderColor", "red");
			flag= false;
		}
		else
		{
			$("#dob_"+i).css("borderColor", "");
		}
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
	if(form.state.value=='')
	{
		form.state.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.state.style.borderColor="";
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
		<td colspan="2"><strong>Medical Information</strong></td>
	</tr>
	<tr class="fieldRow1">
	 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Area Of Coverage  :</span> <span class="mandFieldIndicator1">*</span></td>
	 <td class="fieldsColumn1"><select name="geo_coverage"  id="geo_coverage" tabindex="13" class="generalDropDown"   disabled="disabled">
	   <option value="1" <?php if($user_health_policy['coverage_type']=='1') echo 'selected="selected"';?>>Worldwide excluding US and Canada</option>
	   <option value="2" <?php if($user_health_policy['coverage_type']=='2') echo 'selected="selected"';?>>Worldwide including US and Canada</option>
	   <option value="3" <?php if($user_health_policy['coverage_type']=='3') echo 'selected="selected"';?>>Schengen</option>
	   <option value="4" <?php if($user_health_policy['coverage_type']=='4') echo 'selected="selected"';?>>GCC and Jordan</option>
	 </select></td>
	</tr>
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>Insurance Members </strong></td>
	</tr>
	<tr>
		<td colspan="2">
		<?php $n=1; while($member=mysql_fetch_array($members))
		{?>
			<table width="100%">
				<tr height="54">
					<td width="14%"><span class="form_txt1" style="font-weight:700; padding-left:5px;">Member :</span></td>
					<td width="20%">
						<span class="form_txt1">Gender:</span><span class="mandFieldIndicator1">*</span>
						<select name="mgender[]" id="gender_<?php echo $n;?>" class="generalDropDown" style="width:80px;" onchange="validGender(1);">
							 <option value="M" <?php if($member['gender']=='M') echo 'selected="selected"';?>>Male</option>
							 <option value="F" <?php if($member['gender']=='F') echo 'selected="selected"';?>>Female</option>
						</select>				  </td>
					<td width="30%">
						<span class="form_txt1">Date Of Birth:</span><span class="mandFieldIndicator1">*</span>
						<input name="mdob[]" id="dob_<?php echo $n;?>" class="generalTextBox" type="text" style="width:100px;" value="<?php echo date('d-m-Y',strtotime($member['dob']));?>" />				  </td>
					<td width="18%">
						<span class="form_txt1">Dental:</span>
						<input name="mdental[]" type="checkbox" class="generalTextBox" id="dental_<?php echo $n;?>"  value="1" <?php if($member['dental']=='1')echo 'checked="checked"'; if($n>1) echo 'disabled="disabled"';?> onclick="checkAllDental();" />				  </td>
					<td width="18%">
						<span class="form_txt1">Maternity:</span>
						<input name="mmaternity[]" type="checkbox" class="generalTextBox" id="maternity_<?php echo $n;?>" style="margin-right:5px;" value="1" <?php if($member['maternity']=='1')echo 'checked="checked"'; if($n>1) echo 'disabled="disabled"';?> onclick="checkAllMaternity();" />
						<input type="hidden" name="mid[]" value="<?php echo $member['id'];?>" />				  </td>
				</tr>
			</table>
		<?php $n++;}?>
		<input type="hidden" name="count" id="count" value="<?php echo mysql_num_rows($members);?>" />		
		<?php if(mysql_num_rows($members)=='0')echo 'No member found.';?>
		</td>
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
		$policy_id=$user_health_policy['comp_policy_id'];
		$sql="select * from ".HEALTHPOLICY." where comp_policy_id='".$policy_id."'";
		$policy_details=mysql_fetch_assoc(mysql_query($sql));
		$c_detail=getCompanyDetails($policy_details['comp_id']);
		?>
		<td colspan="2">
			<div style="float:left; padding-right:10px;"><img src="<?php echo str_replace('admin/','',BASE_URL);?>upload/company/<?php if($c_detail['comp_logo'])echo $c_detail['comp_logo']; else echo 'no-image.jpg';?>" width="84" height="69" /></div>
			<?php echo $policy_details['title'];?><br />
		    Excess : 
		    <?php $excess=explode(',',$policy_details['excess']);?>
			<select name="" disabled="disabled">
			<?php for($i=0; $i<count($excess); $i++)
			{	$exval=$policy_details['comp_policy_id'].'_'.$excess[$i];?>
				<option value="<?php echo $exval;?>" <?php if($user_health_policy['excess_val']==$exval)echo 'selected="selected"';?>><?php echo $excess[$i];?></option>
			<?php }?>
			</select>
			<br />
			Maximum Cover per Annum : 
			<?php if($policy_details['max_cover_per_annum_note'])echo $policy_details['max_cover_per_annum_note']; else echo 'Not Covered ';?><br />
			<?php if($policy_details['doc_url']!='')
			{?>
				<a href="<?php echo str_replace('admin/','',BASE_URL).'download.php?&f='.$policy_details['doc_url'];?>" class="footerareacontent">Click to View List</a>
			<?php }?><br />
			Policy Amount : <?php echo $payment_details['policy_amt'].' '.CURRENCY; ?> 		</td>
	</tr>
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>User Details</strong></td>
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
		<input type="text" name="email" value="<?php echo stripslashes($user_policy_details['email']);?>" onblur="checkEmail(this.value);" /></td>
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
			   <option value="<?php echo $country['id'];?>" <?php if($user_policy_details['country']==$country['id']) echo 'selected="selected"';?>><?php echo $country['country'];?></option>
			<?php }?>
		</select>		</td>
	</tr>
	<tr>
		<td>State</td>
		<td id="state_div">
		<select name="state" class="generalDropDown">
			<?php 
			$sql=mysql_query("select * from ".STATE." where status='1' and country_id='".$user_policy_details['country']."'");?>
		   <?php 
			while($state=mysql_fetch_array($sql))
			{?>
				<option value="<?php echo $state['id'];?>" <?php if($user_policy_details['state']==$state['id']) echo 'selected="selected"';?>><?php echo $state['state'];?></option><?php 
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
		<input type="text" name="policy_from_date" onchange="getPolicyToDate(this.value);" value="<?php echo date('d-m-Y',strtotime($user_policy_details['policy_from_date']));?>" class="calender" readonly="readonly" /></td>
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