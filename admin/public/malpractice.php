<?php
if($_GET['type']=='agent')
	$page='agent-policies';
else
	$page='policies';

$user_malpractice_policy=mysql_fetch_assoc(mysql_query("select * from ".USERMALPRACTICEPOLICY." where policy_no='".$policy_no."'"));
//echo '<pre>'; print_r($user_malpractice_policy); echo '</pre>'; 
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
	$nationality=$_POST['nationality'];
	
	//update user policy details
	$db->recordUpdate(array("policy_no" => $policy_no),array("policy_from_date"=>$policy_from_date,"policy_to_date"=>$p@     ���8@��name"=>$fname,"lname"=>$lname,"gender"=>$_POST['gender'],"marital_status"=>$_POST['marital_status'],"nationality"=>$nationality,"dob"=>$dob,"email"=>$email,"phone1"=>$_POST['phone1'],"phone2"=>$_POST['phone2'],"iquama_no"=>$iquama_no,"address1"=>$address1,"postal_code"=>$postal_code,"state"=>$_POST['state'],"country"=>$_POST['country']),USERPOLICY);
	
	$user_regd_no=addslashes($_POST['reg_no']);
	$user_expiry_date=date('Y-m-d',strtotime($_POST['expiry_date']));
	$other_med_prof_val=addslashes($_POST['other_med_prof_val']);
	$branch_med_prof_val=addslashes($_POST['branch_med_prof_val']);
	$super_speciality=addslashes($_POST['super_speciality']);
	$insurer=addslashes($_POST['insurer']);
	$terms=addslashes($_POST['terms']);
	$past_policy_no=addslashes($_POST['past_policy_no']);
	$exp_date=date('Y-m-d',strtotime($_POST['exp_date']));
	$canceled_insurer_details=addslashes($_POST['canceled_insurer_details']);
	$claim_date=date('Y-m-d',strtotime($_POST['claim_date']));
	$indemhyts_amt=addslashes($_POST['indemhyts_amt']);
	$claimant_name=addslashes($_POST['claimant_name']);
	$claim_nature=addslashes($_POST['claim_nature']);
	
	
	$db->recordUpdate(array("policy_no" => $policy_no),array("user_regd_no" => $user_regd_no, "user_expiry_date" => $user_expiry_date, "other_med_prof"=>$_POST['other_med_prof'],"other_med_prof_val"=>$other_med_prof_val,"branch_med_prof"=>$_POST['branch_med_prof'],"branch_med_prof_val"=>$branch_med_prof_val,"qualification"=>$_POST['qualification'],"super_speciality"=>$super_speciality,"experience" => $_POST['experience'], "past_insurance" => $_POST['past_insurance'], "insurer" =>$insurer, "terms" => $terms, "past_policy_no" => $past_policy_no, "exp_date" => $exp_date, "canceled_insurer"=> $_POST['canceled_insurer'], "canceled_insurer_details" => $canceled_insurer_details, "is_claim"=> $_POST['is_claim'], "claim_date" => $claim_date,"indemhyts_amt" => $indemhyts_amt, "claimant_name"=> $claimant_name, "claim_nature" => $claim_nature),USERMALPRACTICEPOLICY);
	
	//update attachments
	$atc_dir='../upload/attachments/malpractice/';
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

function openMedicalProfession(val)
{
	var form=document.policy_form;	
	$('#other_med_prof_err_msg').html('');
	if(val=='Other')
	{
		$('#other_med_prof_val').show();
		form.other_med_prof_val.style.borderColor="";
		form.other_med_prof_val.value='';
	}
	else
	{
		$('#other_med_prof_val').hide();
	}
}
function openBranchProfession(val)
{
	var form=document.policy_form;	
	$('#qualification_err_msg').html('');
	if(val=='Other')
	{
		$('#branch_med_prof_val').show();
		form.branch_med_prof_val.style.borderColor="";
		form.branch_med_prof_val.value='';
	}
	else
	{
		$('#branch_med_prof_val').hide();
	}
}
function openSuperSpeciality(val)
{
	var form=document.policy_form;	
	$('#qualification_err_msg').html('');
	if(val=='Super Speciality')
	{
		$('#super_speciality').show();
		form.super_speciality.style.borderColor="";
		form.super_speciality.value='';
	}
	else
	{
		$('#super_speciality').hide();
	}
}
function openPastInsureForm(val)
{
	var form=document.policy_form;
	$('#past_insurance_err_msg').html('');
	if(val=='0')
	{
		$('.past_insurance').hide();
		form.insurer.style.borderColor="";
		form.terms.style.borderColor="";
		form.policy_no.style.borderColor="";
		form.exp_date.style.borderColor="";
		form.insurer.value='';
		form.terms.value='';
		form.policy_no.value='';
		form.exp_date.value='';
	}
	if(val=='1')
	{
		$('.past_insurance').show();
	}
}

function openCanceledInsureForm(val)
{
	var form=document.policy_form;
	$('#canceled_insurer_err_msg').html('');
	if(val=='0')
	{
		$('.canceled_insurer').hide();
		form.canceled_insurer_details.style.borderColor="";
		form.canceled_insurer_details.value='';
	}
	if(val=='1')
	{
		$('.canceled_insurer').show();
	}
}

function openIsClaimForm(val)
{
	var form=document.policy_form;
	$('#is_claim_err_msg').html('');
	if(val=='0')
	{
		$('.is_claim').hide();
		form.claim_date.style.borderColor="";
		form.indemhyts_amt.style.borderColor="";
		form.claimant_name.style.borderColor="";
		form.claim_nature.style.borderColor="";
		form.claim_date.value='';
		form.indemhyts_amt.value='';
		form.claimant_name.value='';
		form.claim_nature.value='';
	}
	if(val=='1')
	{
		$('.is_claim').show();
	}
}

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
	var flag = true;

	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
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
	if(form.iquama_no.value.length !='10')
	{
		form.iquama_no.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.iquama_no.style.borderColor="";
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
	if(form.dob.value=='')
	{
		form.dob.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.dob.style.borderColor="";
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
	if(form.reg_no.value=='')
	{
		form.reg_no.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.reg_no.style.borderColor="";
	}
	if(form.expiry_date.value=='')
	{
		form.expiry_date.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.expiry_date.style.borderColor="";
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
	
	
	if (document.getElementById("other_med_prof").checked==true && form.other_med_prof_val.value =='' )
	{
		form.other_med_prof_val.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.other_med_prof_val.style.borderColor="";
	}
	if (document.getElementById("branch_med_prof").checked==true && form.branch_med_prof_val.value =='' )
	{
		form.branch_med_prof_val.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.branch_med_prof_val.style.borderColor="";
	}
	if (document.getElementById("qualification").checked==true && form.super_speciality.value =='' )
	{
		form.super_speciality.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.super_speciality.style.borderColor="";
	}
	if (document.getElementById("past_insurance").checked==true && form.insurer.value =='' )
	{
		form.insurer.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.insurer.style.borderColor="";
	}
	if (document.getElementById("past_insurance").checked==true && form.terms.value =='' )
	{
		form.terms.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.terms.style.borderColor="";
	}
	if (document.getElementById("past_insurance").checked==true && form.past_policy_no.value =='' )
	{
		form.past_policy_no.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.past_policy_no.style.borderColor="";
	}
	if (document.getElementById("past_insurance").checked==true && form.exp_date.value =='' )
	{
		form.exp_date.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.exp_date.style.borderColor="";
	}
	if (document.getElementById("canceled_insurer").checked==true && form.canceled_insurer_details.value =='' )
	{
		form.canceled_insurer_details.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.canceled_insurer_details.style.borderColor="";
	}
	if (document.getElementById("is_claim1").checked==true && form.claim_date.value =='' )
	{
		form.claim_date.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.claim_date.style.borderColor="";
	}
	if (document.getElementById("is_claim1").checked==true && form.indemhyts_amt.value =='' )
	{
		form.indemhyts_amt.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.indemhyts_amt.style.borderColor="";
	}
	if (document.getElementById("is_claim1").checked==true && form.claimant_name.value =='' )
	{
		form.claimant_name.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.claimant_name.style.borderColor="";
	}
	if (document.getElementById("is_claim1").checked==true && form.claim_nature.value =='' )
	{
		form.claim_nature.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.claim_nature.style.borderColor="";
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
<input type="hidden" name="ptime" id="ptime" value="<?php echo $user_malpractice_policy['period']*12;?>" />
<input type="hidden" name="uid" id="uid" value="<?php echo $user_policy_details['uid'];?>" />
<table width="875" cellpadding="4" cellspacing="" align="center">
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>General Information</strong></td>
	</tr>
	<tr class="fieldRow1"> 
	 <td colspan="2">
	 
		<table width="100%" height="" border="0" cellpadding="6" cellspacing="2">
		  <tbody>
			<tr>
			  <td width="269"><span class=" form_txt1"> First Name: </span> <span class="mandFieldIndicator1">*</span></td>
			  <td width="30"><input name="fname" type="text" id="fname" tabindex="3"  class="generalDropDown" autocomplete="off" value="<?php echo stripcslashes($user_policy_details['fname']);?>" /></td>
			  <td width="297"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Last Name   :</span> <span class="mandFieldIndicator1">*</span></span></td>
			  <td><input name="lname" type="text" id="lname" tabindex="3"  class="generalDropDown" autocomplete="off"  value="<?php echo stripcslashes($user_policy_details['lname']);?>"/></td>
			</tr>
			<tr>
			  <td><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">ID/ Iqama No    :</span> <span class="mandFieldIndicator1">*</span></span></td>
			  <td><input name="iquama_no" type="text" id="iquama_no" tabindex="3"  class="generalDropDown" autocomplete="off" value="<?php echo stripcslashes($user_policy_details['iquama_no']);?>" /></td>
			  <td><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Marital Status    :</span> <span class="mandFieldIndicator1">*</span></span></td>
			  <td ><span class="fieldsColumn1">
				<select name="marital_status" class="generalDropDown">
					<option value="">[--SELECT--]</option>
					<option value="single" <?php if($user_policy_details['marital_status']=='single') echo 'selected="selected"';?>>Single</option>
					<option value="married" <?php if($user_policy_details['marital_status']=='married') echo 'selected="selected"';?>>Married</option>
				</select>
			  </span></td>
			</tr>
			
			<tr>
			  <td>
			  	<span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Nationality :</span> <span class="mandFieldIndicator1">*</span></span><br />
			  </td>
			  <td>
			  <select name="nationality"  class="generalDropDown">
					   <option selected="selected" value="">[--SELECT--]</option>
						<?php $countries=mysql_query("select * from ".COUNTRY." where status='1'");
					   while($countrylist=mysql_fetch_array($countries))
					   {?>
						   <option value="<?php echo $countrylist['country'];?>" <?php if($user_policy_details['nationality']==$countrylist['country']) echo 'selected="selected"';?>><?php echo $countrylist['country'];?></option>
					   <?php }?>
				</select>
			  </td>
			  <td><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Email  :</span> <span class="mandFieldIndicator1">*</span></span></td>
			  <td><span id="dr_span" style="color:#FF0000; clear:both"></span><input name="email" type="text" id="email" tabindex="3"  class="generalDropDown" autocomplete="off" value="<?php echo $user_policy_details['email'];?>" onblur="checkEmail(this.value);"  /></td>
			</tr>
			
			<tr>
			  <td><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Country :</span> <span class="mandFieldIndicator1">*</span></span></td>
			  <td>
			  <select name="country" onchange="getStates(this.value);"  class="generalDropDown">
				   <option selected="selected" value="">[--SELECT--]</option>
				   <?php 
				   $clist=mysql_query("select * from ".COUNTRY." where status='1'");
				   $country_val=$user_policy_details['country'];
				   while($country=mysql_fetch_array($clist))
				   {?>
					   <option value="<?php echo $country['id'];?>" <?php if($country_val==$country['id']) echo 'selected="selected"';?>><?php echo $country['country'];?></option>
				   <?php }?>
				</select>
			  </td>
			  <td ><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">State  :</span> <span class="mandFieldIndicator1">*</span></span></td>
			   <td><span class="fieldsColumn1"  id="state_div">
			   <select name="state"  class="generalDropDown">
				   <option selected="selected" value="">[--SELECT--]</option>
				   <?php $state_val=$user_policy_details['state'];
				   if($state_val)
				   {
						$sql=mysql_query("select * from ".STATE." where status='1' and country_id='".$user_policy_details['country']."'");?>
					   <?php 
						while($state=mysql_fetch_array($sql))
						{?>
							<option value="<?php echo $state['id'];?>" <?php if($state_val==$state['id']) echo 'selected="selected"';?>><?php echo $state['state'];?></option><?php 
						}
				   }?>
				</select>
			  </span></td>
			</tr>
			
			
			<tr>
			  <td width="269"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Postal Code :</span> <span class="mandFieldIndicator1">*</span></span></td>
			  <td width="30"><input name="postal_code" type="text" id="postal_code" tabindex="3"  class="generalDropDown" autocomplete="off" value="<?php echo $user_policy_details['postal_code'];?>" /></td>
			  <td width="297"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Date Of Birth :</span> <span class="mandFieldIndicator1">*</span></span></td>
				<td ><span class="fieldsColumn1">
				<input name="dob" type="text" id="dob" tabindex="3"  class="generalDropDown dob" autocomplete="off" value="<?php echo date('d-m-Y',strtotime($user_policy_details['dob']));?>" />
			  </span></td>
			</tr>
			
			<tr>
			  <td><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Mobile Number :</span> <span class="mandFieldIndicator1">*</span></span></td>
			  <td><input name="phone1" type="text" id="phone1" tabindex="3"  class="generalDropDown" autocomplete="off" value="<?php echo $user_policy_details['phone1'];?>" /></td>
			  <td ><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Landline Number :</span></span></td>
			  <td><input name="phone2" type="text" id="phone2" tabindex="3"  class="generalDropDown" autocomplete="off" value="<?php echo $user_policy_details['phone2'];?>" /></td>
			</tr>
			
			<tr>
			  <td><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">SCHS Registration Number :</span> <span class="mandFieldIndicator1">*</span></span></td>
			  <td><input name="reg_no" type="text" id="reg_no" tabindex="3"  class="generalDropDown" autocomplete="off" value="<?php echo $user_malpractice_policy['user_regd_no'];?>" /></td>
			  <td ><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Expiry Date :</span> <span class="mandFieldIndicator1">*</span></span></td>
			  <td><span class="fieldsColumn1">
				<input name="expiry_date" type="text" id="expiry_date" tabindex="3"  class="generalDropDown calender" autocomplete="off" value="<?php echo date('d-m-Y',strtotime($user_malpractice_policy['user_expiry_date']));?>" />
			  </span></td>
			</tr>
			<tr>
				<td><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Address :</span> <span class="mandFieldIndicator1">*</span></span></td>
				<td><textarea name="address1" style="height:50px; resize:none;" class="generalTextBox"><?php echo $user_policy_details['address1'];?></textarea></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
			  <td colspan="4"><div style="margin-top:10px;"><span class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Period Of Insurance :</span> <span class="mandFieldIndicator1">*</span></span>
			  <input type="radio" name="period_of_insurance" value="1" <?php if($user_malpractice_policy['period']=='1')echo 'checked="checked"';?> disabled="disabled" /> 1 year
			  <input type="radio" name="period_of_insurance" value="2" <?php if($user_malpractice_policy['period']=='2')echo 'checked="checked"';?> disabled="disabled" /> 2 years
			  <input type="radio" name="period_of_insurance" value="3" <?php if($user_malpractice_policy['period']=='3')echo 'checked="checked"';?>  disabled="disabled" /> 3 years
			  <input type="radio" name="period_of_insurance" value="4" <?php if($user_malpractice_policy['period']=='4')echo 'checked="checked"';?>  disabled="disabled" /> 4 years
			  <input type="radio" name="period_of_insurance" value="5" <?php if($user_malpractice_policy['period']=='5')echo 'checked="checked"';?> disabled="disabled" /> 5 years
			  </div></td>
			</tr>
		  </tbody>
		</table>
	 
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
		$policy_id=$user_malpractice_policy['comp_policy_id'];
		$sql="select * from ".MALPRACTICEPOLICY." where comp_policy_id='".$policy_id."'";
		$policy_details=mysql_fetch_assoc(mysql_query($sql));
		$c_detail=getCompanyDetails($policy_details['comp_id']);
		?>
		<td colspan="2">
			<div style="float:left; padding-right:10px;"><img src="<?php echo str_replace('admin/','',BASE_URL);?>upload/company/<?php if($c_detail['comp_logo'])echo $c_detail['comp_logo']; else echo 'no-image.jpg';?>" width="84" height="69" /></div>
			<?php echo $policy_details['title'];?><br />
			<?php echo $policy_details['description'];?><br />
			Coverage Details : 
			<?php if($policy_details['coverage_details'])echo $policy_details['coverage_details']; else echo 'Not Covered ';?><br />
			
			Policy Amount : <?php echo $payment_details['policy_amt'].' '.CURRENCY; ?> 		</td>
	</tr>
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>User Details</strong></td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" height="" border="0" cellpadding="6" cellspacing="2">
                  <tbody>
                    
					   <tr class="fieldRow1">
                         <td colspan="6" class="fieldLabelsColumn"><span class="formtxt_blue">Profession</span></td>
                       </tr>
                       <tr>
					   	<td>
							<table cellpadding="0" cellspacing="0" width="100%">
							<tr><td colspan="4"><span id="other_med_prof_err_msg" class="error_msg"></span></td></tr> 
                       
					   <tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldLabel form_txt1">Doctor   :</span> <span class="mandFieldIndicator1">*</span></td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Surjeon" name="other_med_prof" type="radio"  id="doctor1" onclick="openMedicalProfession(this.value);" <?php if($user_malpractice_policy['other_med_prof']=='Surjeon')echo 'checked="checked"';?> />
                           <span class="form_txt">Surjeon</span></span></td>
                         <td width="138" height="40"><span class="fieldsColumn1">
                           <input value="Non Surjeon" name="other_med_prof" type="radio"  id="doctor2" onclick="openMedicalProfession(this.value);" <?php if($user_malpractice_policy['other_med_prof']=='Non Surjeon')echo 'checked="checked"';?> />
                          <span class="form_txt">Non Surjeon </span></span></td>
						 <td width="141" height="40"><span class="fieldsColumn1">
						  
						 </span></td>
					    </tr>
						
					   <tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldLabel form_txt1">Other Medical Professional   :</span> <span class="mandFieldIndicator1">*</span></td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Nurse" name="other_med_prof" type="radio"  id="check" onclick="openMedicalProfession(this.value);" <?php if($user_malpractice_policy['other_med_prof']=='Nurse')echo 'checked="checked"';?> />
                           <span class="form_txt">Nurse</span></span></td>
                         <td width="138" height="40"><span class="fieldsColumn1">
                           <input value="Lab Technician" name="other_med_prof" type="radio"  id="chk" onclick="openMedicalProfession(this.value);" <?php if($user_malpractice_policy['other_med_prof']=='Lab Technician')echo 'checked="checked"';?> />
                          <span class="form_txt">Lab Technician </span></span></td>
						 <td width="141" height="40"><span class="fieldsColumn1">
						   <input value="Paramedic" name="other_med_prof" type="radio" id="chk1"  onclick="openMedicalProfession(this.value);" <?php if($user_malpractice_policy['other_med_prof']=='Paramedic')echo 'checked="checked"';?> />
						   Paramedic 
						 </span></td>
					    </tr>
						
					   <tr class="fieldRow1">
                         <td width="188" height="40"></td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Dietician" name="other_med_prof" type="radio"  id="check" onclick="openMedicalProfession(this.value);" <?php if($user_malpractice_policy['other_med_prof']=='Dietician')echo 'checked="checked"';?> />
                           <span class="form_txt">Dietician</span></span></td>
                         <td width="138" height="40"><span class="fieldsColumn1">
                           <input value="X-Ray Technician" name="other_med_prof" type="radio"  id="chk" onclick="openMedicalProfession(this.value);"  <?php if($user_malpractice_policy['other_med_prof']=='X-Ray Technician')echo 'checked="checked"';?>/>
                          <span class="form_txt">X-Ray Technician </span></span></td>
						 <td width="141" height="40"><span class="fieldsColumn1">
						   <input value="Pharmacist" name="other_med_prof" type="radio" id="chk1" onclick="openMedicalProfession(this.value);" <?php if($user_malpractice_policy['other_med_prof']=='Pharmacist')echo 'checked="checked"';?> />
						   Pharmacist
						 </span></td>
					    </tr>
						
					   <tr class="fieldRow1">
                         <td width="188" height="40"></td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Other" name="other_med_prof" type="radio"  id="other_med_prof" onclick="openMedicalProfession(this.value);" <?php if($user_malpractice_policy['other_med_prof']=='Other')echo 'checked="checked"';?> />
                           <span class="form_txt">Other</span></span></td>
                         <td width="138" height="40" colspan="2"><span class="fieldsColumn1">
                           <input name="other_med_prof_val" id="other_med_prof_val" style="width:140px; <?php if($user_malpractice_policy['other_med_prof']!='Other'){?>display:none<?php }?>" class="generalTextBox" type="text" value="<?php echo $user_malpractice_policy['other_med_prof_val'];?>" />	</span></td>
					    </tr>
						
						<tr class="fieldRow1">
                         <td width="188" height="40" colspan="4"><span class="fieldLabelsColumn"><span class="formtxt_blue">If Doctor Select your Branch of Medical Profession </span></span></td>
					    </tr>
						<tr><td colspan="4"><span id="branch_med_prof_err_msg" class="error_msg"></span></td></tr> 
						<tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldsColumn1">
                           <input value="General Physician" name="branch_med_prof" type="radio"  id="check22" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='General Physician')echo 'checked="checked"';?> />
                           <span class="form_txt">General Physician </span></span></td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Dentisity" name="branch_med_prof" type="radio"  id="check" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Dentisity')echo 'checked="checked"';?> />
                           <span class="form_txt">Dentisity</span></span></td>
                         <td width="138" height="40"><span class="fieldsColumn1">
                           <input value="Pediatries" name="branch_med_prof" type="radio"  id="chk" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Pediatries')echo 'checked="checked"';?> />
                          <span class="form_txt">Pediatries </span></span></td>
						 <td width="141" height="40"><span class="fieldsColumn1">
						   <input value="Dermatology" name="branch_med_prof" type="radio" id="chk1" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Dermatology')echo 'checked="checked"';?> />
						   Dermatology</span></td>
					    </tr>
						
						<tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldsColumn1">
                           <input value="Orthopedics" name="branch_med_prof" type="radio"  id="check22" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Orthopedics')echo 'checked="checked"';?> />
                           <span class="form_txt">Orthopedics </span></span></td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Radiology" name="branch_med_prof" type="radio"  id="check" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Radiology')echo 'checked="checked"';?> />
                           <span class="form_txt">Radiology</span></span></td>
                         <td width="138" height="40"><span class="fieldsColumn1">
                           <input value="Psychiatry" name="branch_med_prof" type="radio"  id="chk" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Psychiatry')echo 'checked="checked"';?> />
                          <span class="form_txt">Psychiatry </span></span></td>
						 <td width="141" height="40"><span class="fieldsColumn1">
						   <input value="Anasthesia" name="branch_med_prof" type="radio" id="chk1" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Anasthesia')echo 'checked="checked"';?> />
						   Anasthesia</span></td>
					    </tr>
						
						<tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldsColumn1">
                           <input value="Urology" name="branch_med_prof" type="radio"  id="check22" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Urology')echo 'checked="checked"';?> />
                           <span class="form_txt">Urology</span></span></td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Cardiology" name="branch_med_prof" type="radio"  id="check" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Cardiology')echo 'checked="checked"';?> />
                           <span class="form_txt">Cardiology</span></span></td>
                         <td width="138" height="40"><span class="fieldsColumn1">
                           <input value="Neurology" name="branch_med_prof" type="radio"  id="chk" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Neurology')echo 'checked="checked"';?> />
                          <span class="form_txt">Neurology </span></span></td>
						 <td width="141" height="40"><span class="fieldsColumn1">
						   <input value="Other" name="branch_med_prof" type="radio" id="branch_med_prof" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Other')echo 'checked="checked"';?> />
						   Other</span></td>
					    </tr>
						
						<tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldsColumn1">
                           <input value="Gynecology" name="branch_med_prof" type="radio"  id="check22" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Gynecology')echo 'checked="checked"';?> />
                           <span class="form_txt">Gynecology</span></span></td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Plastic Surgery" name="branch_med_prof" type="radio"  id="check" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Plastic Surgery')echo 'checked="checked"';?> />
                           <span class="form_txt">Plastic Surgery </span></span></td>
                         <td width="138" height="40"><span class="fieldsColumn1">
                           <input value="Opthalmology" name="branch_med_prof" type="radio"  id="chk" onclick="openBranchProfession(this.value);" <?php if($user_malpractice_policy['branch_med_prof']=='Opthalmology')echo 'checked="checked"';?> />
                          <span class="form_txt">Opthalmology  </span></span></td>
						 <td width="141" height="40">
						 <input name="branch_med_prof_val" id="branch_med_prof_val" style="width:120px; <?php if($user_malpractice_policy['branch_med_prof']!='Other'){?>display:none<?php }?>" class="generalTextBox" type="text" value="<?php echo $user_malpractice_policy['branch_med_prof_val'];?>" />						 </td>
					    </tr>
						
						<tr class="fieldRow1">
                         <td width="188" height="40" colspan="4"><span class="fieldLabelsColumn"><span class="formtxt_blue">Qualification</span></span></td>
					    </tr>
						<tr><td colspan="4"><span id="qualification_err_msg" class="error_msg"></span></td></tr> 
						<tr class="fieldRow1">
                         <td width="188" height="40">&nbsp;</td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Graduation" name="qualification" type="radio"  id="check" onclick="openSuperSpeciality(this.value);" <?php if($user_malpractice_policy['qualification']=='Graduation')echo 'checked="checked"';?> />
                           <span class="form_txt">Graduation</span></span></td>
                         <td width="138" height="40"><span class="fieldsColumn1">
                           <input value="Post Graduation" name="qualification" type="radio"  id="chk" onclick="openSuperSpeciality(this.value);" <?php if($user_malpractice_policy['qualification']=='Post Graduation')echo 'checked="checked"';?> />
                          <span class="form_txt">Post Graduation </span></span></td>
						 <td width="141" height="40">&nbsp;</td>
					    </tr>
						
						<tr class="fieldRow1">
                         <td width="188" height="40">&nbsp;</td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="Super Speciality" name="qualification" type="radio"  id="qualification" onclick="openSuperSpeciality(this.value);" <?php if($user_malpractice_policy['qualification']=='Super Speciality')echo 'checked="checked"';?> />
                           <span class="form_txt">Super Speciality </span></span></td>
                         <td height="40"><input name="super_speciality" id="super_speciality"  class="generalTextBox" type="text" style="width:140px;  <?php if($user_malpractice_policy['qualification']!='Super Speciality'){?>display:none<?php }?>" value="<?php echo $user_malpractice_policy['super_speciality'];?>" /></td>
						 <td></td>
						 </tr>
						 
						 <tr class="fieldRow1">
                         <td width="188" height="40" colspan="4"><span class="fieldLabelsColumn"><span class="formtxt_blue">Experience of Specialization </span></span></td>
					    </tr>
						<tr><td colspan="4"><span id="experience_err_msg" class="error_msg"></span></td></tr> 
						<tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldsColumn1">
                           <input value="0 to 5 years" name="experience" type="radio"  id="check23" <?php if($user_malpractice_policy['experience']=='0 to 5 years')echo 'checked="checked"';?>/>
                           <span class="form_txt">0 to 5 years </span></span></td>
						 <td width="151" height="40"><span class="fieldsColumn1">
						   <input value="6  to 20 years" name="experience" type="radio"  id="check4" <?php if($user_malpractice_policy['experience']=='6  to 20 years')echo 'checked="checked"';?>/>
                           <span class="form_txt">6  to 20 years </span></span></td>
                         <td width="138" height="40"><span class="fieldsColumn1">
                           <input value="11 to 20 years" name="experience" type="radio"  id="chk" <?php if($user_malpractice_policy['experience']=='11 to 20 years')echo 'checked="checked"';?>/>
                           <span class="form_txt">11 to 20 years </span></span></td>
						 <td width="141" height="40"><span class="fieldsColumn1">
						   <input value="More thae 20  years" name="experience" type="radio"  id="check3" <?php if($user_malpractice_policy['experience']=='More thae 20  years')echo 'checked="checked"';?>/>
                           <span class="form_txt">More thae 20  years </span></span></td>
					    </tr>
						
						<tr class="fieldRow1">
                         <td width="188" height="40" colspan="4"><span class="fieldLabelsColumn"><span class="formtxt_blue">Previous Insurance/ Cliam Information</span></span></td>
					    </tr>
						<tr><td colspan="4"><span id="past_insurance_err_msg" class="error_msg"></span></td></tr> 
						<tr class="fieldRow1">
                         <td height="40" colspan="3">Do you have had medical Professional Liability insurance during past 12 Months </td>
						 <td width="141" height="40"><span class="fieldsColumn1">
						   <input value="1" name="past_insurance" type="radio"  id="past_insurance" onclick="openPastInsureForm(this.value);" <?php if($user_malpractice_policy['past_insurance']=='1')echo 'checked="checked"';?> />
                           <span class="form_txt">Yes  &nbsp;&nbsp;
                           <input value="0" name="past_insurance" type="radio"  id="check42" onclick="openPastInsureForm(this.value);" <?php if($user_malpractice_policy['past_insurance']=='0')echo 'checked="checked"';?> />
                           No </span></span></td>
					    </tr>
						
						<tr>
							<td height="5" colspan="4" class="past_insurance" style="display:none">&nbsp;</td>
						</tr>
						<?php $past_insurance_display=''; if($user_malpractice_policy['past_insurance']!='1'){ $past_insurance_display='display:none'; }?>
						<tr class="fieldRow1">
                         <td width="188" height="40" class="past_insurance" style=" <?php echo $past_insurance_display;?>"><span class="fieldsColumn1">Insurer <span class="form_txt">:</span></span></td>
						 <td height="40" colspan="3" class="past_insurance" style=" <?php echo $past_insurance_display;?>"><input name="insurer" class="generalTextBox" type="text" style="width:280px; float:left;" value="<?php echo $user_malpractice_policy['insurer'];?>" /></td>
                         </tr>
						 <tr class="fieldRow1">
                         <td width="188" height="40" class="past_insurance" style=" <?php echo $past_insurance_display;?>"><span class="fieldsColumn1">Terms <span class="form_txt">:</span></span></td>
						 <td height="40" colspan="3" class="past_insurance" style=" <?php echo $past_insurance_display;?>"><input name="terms" class="generalTextBox" type="text" style="width:280px; float:left;" value="<?php echo $user_malpractice_policy['terms'];?>" /></td>
						 </tr>
						 <tr class="fieldRow1">
                         <td width="188" height="40" class="past_insurance" style=" <?php echo $past_insurance_display;?>"><span class="fieldsColumn1">Polocy No <span class="form_txt">:</span></span></td>
						 <td height="40" colspan="3" class="past_insurance" style=" <?php echo $past_insurance_display;?>"><input name="past_policy_no" class="generalTextBox" type="text" style="width:280px; float:left;" value="<?php echo $user_malpractice_policy['past_policy_no'];?>" /></td>
						 </tr>
						 <tr class="fieldRow1">
                         <td width="188" height="40" class="past_insurance" style=" <?php echo $past_insurance_display;?>"><span class="fieldsColumn1">Exp Date <span class="form_txt">:</span></span></td>
						 <td height="40" colspan="3" class="past_insurance" style=" <?php echo $past_insurance_display;?>"><input name="exp_date" class="generalTextBox calender" type="text" style="width:280px; float:left;" value="<?php echo date('d-m-Y',strtotime($user_malpractice_policy['exp_date']));?>" /></td>
						 </tr>
						 
						<tr><td colspan="4"><span id="canceled_insurer_err_msg" class="error_msg"></span></td></tr> 
						 
						 <tr class="fieldRow1">
							 <td width="188" height="40" colspan="4">
							 Has many insurer ever cancelled, refused for Professional Linability/ Medical Malpractics Insurance.</td>
					    </tr>
						<tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldsColumn1">
                           <input value="1" name="canceled_insurer" type="radio"  id="canceled_insurer" onclick="openCanceledInsureForm(this.value);" <?php if($user_malpractice_policy['canceled_insurer']=='1')echo 'checked="checked"';?> />
                           <span class="form_txt">Yes</span> &nbsp;&nbsp;
                           <input value="0" name="canceled_insurer" type="radio"  id="radio2" onclick="openCanceledInsureForm(this.value);" <?php if($user_malpractice_policy['canceled_insurer']=='0')echo 'checked="checked"';?> />
                           <span class="form_txt">No </span></span></td>
						 <td width="151" height="40">&nbsp;</td>
                         <td width="138" height="40">&nbsp;</td>
						 <td width="141" height="40">&nbsp;</td>
					    </tr>
						
						<tr class="fieldRow1">
						<?php $canceled_insurer_display=''; if($user_malpractice_policy['canceled_insurer']!='1'){ $canceled_insurer_display='display:none'; }?>
                         <td width="188" height="40" class="canceled_insurer" style=" <?php echo $canceled_insurer_display;?>"><span class="fieldsColumn1">(If Yes <span class="form_txt">) Details : </span></span></td>
						 <td height="40" colspan="3" class="canceled_insurer" style=" <?php echo $canceled_insurer_display;?>"><textarea class="generalTextBox" type="text" style="width:420px; height:50px; resize:none;" name="canceled_insurer_details"><?php echo $user_malpractice_policy['canceled_insurer_details'];?></textarea></td>
						 </tr>
						 
						<tr><td colspan="4"><span id="is_claim_err_msg" class="error_msg"></span></td></tr> 
						 
						 <tr class="fieldRow1">
							 <td width="188" height="40" colspan="4">
							 Have you ever had a Claim against your in last 5 Years ? </td>
					    </tr>
						<tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldsColumn1">
                           <input value="1" name="is_claim" type="radio" id="is_claim1" onclick="openIsClaimForm(this.value);" <?php if($user_malpractice_policy['is_claim']=='1')echo 'checked="checked"';?> />
                           <span class="form_txt">Yes</span> &nbsp;&nbsp;
                           <input value="0" name="is_claim" type="radio"  id="is_claim0" onclick="openIsClaimForm(this.value);" <?php if($user_malpractice_policy['is_claim']=='0')echo 'checked="checked"';?> />
                           <span class="form_txt">No </span></span></td>
						 <td width="151" height="40">&nbsp;</td>
                         <td width="138" height="40">&nbsp;</td>
						 <td width="141" height="40">&nbsp;</td>
					    </tr>
						
						<tr class="fieldRow1">
						<?php $is_claim_display=''; if($user_malpractice_policy['is_claim']!='1'){ $is_claim_display='display:none'; }?>
                         <td width="188" height="40" class="is_claim" style=" <?php echo $is_claim_display;?>"><span class="fieldsColumn1">(If Yes <span class="form_txt">) Details : </span></span></td>
						 <td height="40" colspan="3" class="is_claim" style=" <?php echo $is_claim_display;?>">&nbsp;</td>
						</tr>
						
						
						<tr class="fieldRow1">
                         <td width="188" height="40" class="is_claim" style=" <?php echo $is_claim_display;?>"><span class="fieldsColumn1">
                           Date of Claim : <span class="form_txt"></span></span></td>
						 <td width="151" height="40" class="is_claim" style=" <?php echo $is_claim_display;?>"><input name="claim_date" class="generalTextBox claim" type="text" style="width:140px;" value="<?php echo date('d-m-Y',strtotime($user_malpractice_policy['claim_date']));?>" /></td>
                         <td width="138" height="40" class="is_claim" style=" <?php echo $is_claim_display;?>"><span class="fieldsColumn1">
                           Amount of Indemhitys <span class="form_txt"></span></span></td>
						 <td width="141" height="40" class="is_claim" style=" <?php echo $is_claim_display;?>"><input name="indemhyts_amt" class="generalTextBox" type="text" style="width:140px;" value="<?php echo $user_malpractice_policy['indemhyts_amt'];?>" /></td>
					    </tr>
						
						<tr class="fieldRow1">
                         <td width="188" height="40" class="is_claim" style=" <?php echo $is_claim_display;?>"><span class="fieldsColumn1">
                           Claimant' Name :</span></td>
						 <td height="40" colspan="2" class="is_claim" style=" <?php echo $is_claim_display;?>"><input name="claimant_name" class="generalTextBox" type="text" style="width:300px;" value="<?php echo $user_malpractice_policy['claimant_name'];?>" /></td>
						 <td width="141" height="40" class="is_claim" style=" <?php echo $is_claim_display;?>">&nbsp;</td>
						</tr>
						
						<tr class="fieldRow1">
                         <td width="188" height="40" class="is_claim" style=" <?php echo $is_claim_display;?>"><span class="fieldsColumn1">
                           Nature of claims :</span></td>
						 <td height="40" colspan="2" class="is_claim" style=" <?php echo $is_claim_display;?>"><input name="claim_nature" class="generalTextBox" type="text" style="width:300px;" value="<?php echo $user_malpractice_policy['claim_nature'];?>" /></td>
						 <td width="141" height="40" class="is_claim"  style=" <?php echo $is_claim_display;?>">&nbsp;</td>
						</tr>
						<tr class="fieldRow1">
                         <td width="188" height="40"><span class="fieldsColumn1">
                           Policy From Date :</span></td>
						 <td height="40" class="" ><input name="policy_from_date" class="generalTextBox calender" type="text" style="width:150px;" value="<?php echo date('d-m-Y',strtotime($user_policy_details['policy_from_date']));?>"  onchange="getPolicyToDate(this.value);" /></td>
						 <td height="40"><span class="fieldsColumn1">
                           Policy To Date :</span></td>
						 <td width="141" height="40"><input name="policy_to_date" id="policy_to_date" class="generalTextBox" type="text" style="width:150px;" value="<?php echo date('d-m-Y',strtotime($user_policy_details['policy_to_date']));?>" readonly="readonly" /></td>
						</tr>
						
						<tr class="fieldRow1"></tr>
						</table>						</td>
					   </tr>
					
                </table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<input type="submit" name="save" value="Update" onclick="return validForm();" class="actionBtn" /></td>
	</tr>
</table>
</form>