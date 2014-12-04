<?php
$travellers=mysql_query("select * from ".USERPOLICYTRAVELLERS." where policy_no='".$policy_no."'"); 
$user_travel_policy=mysql_fetch_assoc(mysql_query("select * from ".USERTRAVELPOLICY." where policy_no='".$policy_no."'"));

if($_GET['type']=='agent')
	$page='agent-policies';
else
	$page='policies';

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
	
	//update user travel policy details
	$departure_date=date('Y-m-d',strtotime($_POST['departure_date']));
	$return_date=date('Y-m-d',strtotime($_POST['return_date']));
	
	$result = $db->recordUpdate(array("policy_no" => $policy_no),array("reason_for_travel"=>$_POST['reason_for_travel'],"departure_date"=>$departure_date,"return_date"=>$return_date),USERTRAVELPOLICY);
	
	//update travellers details
	$count=$_POST['travellers_count'];
	for($i=0; $i<$count; $i++)
	{
		$tgender=$_POST['tgender'][$i];
		$tdob=date('Y-m-d',strtotime($_POST['tdob'][$i]));
		$tfname=$_POST['tfname'][$i];
		$tlname=$_POST['tlname'][$i];
		$tid=$_POST['tid'][$i]; 
		
		$db->recordUpdate(array("id" => $tid),array("gender"=>$tgender,"dob"=>$tdob,"fname"=>$tfname,"lname"=>$tlname),USERPOLICYTRAVELLERS);
	}
	//update attachments
	$atc_dir='../upload/attachments/travel/';
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
$(function() {
	
	var count=$("#travellers_count").val();
	count=parseInt(count)+1;
		
	for (var i=1; i<count; i++)
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

function calculate(val1, val2, msg) 
{
	var value1 = val1.split("-");
	var value2 = val2.split("-");
	if (value1 != "" && value2 != "") 
	{
		var day1 = parseFloat(value1[0]);
		var month1 = parseFloat(value1[1]);
		var year1 = parseFloat(value1[2]);
		var day2 = parseFloat(value2[0]);
		var month2 = parseFloat(value2[1]);
		var year2 = parseFloat(value2[2]);
		
		if ((year2 < year1) || (year2 == year1 && month2 < month1) || (year2 == year1 && month2 == month1 && day2 < day1) || (year2 == year1 && month2 == month1 && day2 == day1)) 
		{
			alert(msg);
			return false;
		}   
		else
			return true;     
	}
}

function validDepartureDate(val)
{
	var val2=$("#return_date").val();
	var res=calculate(val,val2,'Departure Date should less than Return Date.');
	if(res==false)
		$("#departure_date").val("");
	else
		$("#policy_from_date").val(val);
}

function validReturnDate(val)
{
	var val1=$("#departure_date").val();
	var res=calculate(val1,val,'Return Date should greater than Departure Date.');
	if(res==false)
		$("#return_date").val("");
	else
		$("#policy_to_date").val(val);
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
	var error = "";
	var flag = true;

	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var total=form.travellers_count.value;
	total=parseInt(total)+1;
	
	if(form.departure_date.value=='')
	{
		form.departure_date.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.departure_date.style.borderColor="";
	}
	if(form.return_date.value=='')
	{
		form.return_date.style.borderColor="red";
		flag= false;
	}
	else
	{
		form.return_date.style.borderColor="";
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
		if($("#fname_"+i).val()=='')
		{
			$("#fname_"+i).css("borderColor", "red");
			flag= false;
		}
		else
		{
			$("#fname_"+i).css("borderColor", "");
		}
		if($("#lname_"+i).val()=='')
		{
			$("#lname_"+i).css("borderColor", "red");
			flag= false;
		}
		else
		{
			$("#lname_"+i).css("borderColor", "");
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
<?php 
if($user_travel_policy['trip_type']=='Single')
	$ptime='12';
if($user_travel_policy['trip_type']=='Multi')
	$ptime=$user_travel_policy['perid_of_travel'];
?>
<input type="hidden" name="ptime" id="ptime" value="<?php echo $ptime;?>" />
<input type="hidden" name="uid" id="uid" value="<?php echo $user_policy_details['uid'];?>" />
<table width="875" cellpadding="4" cellspacing="" align="center">
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>Travel Information</strong></td>
	</tr>
	<tr>
		<td>Type Of Coverage</td>
		<td>
		<select name="trip_type" onchange="showCovDiv(this.value);" id="ddlMake" tabindex="13" class="generalDropDown" disabled="disabled">
			<option value="">[--SELECT--]</option>
			<option value="Single" <?php if($user_travel_policy['trip_type']=='Single') echo 'selected="selected"';?>>Single</option>
			<option value="Multi" <?php if($user_travel_policy['trip_type']=='Multi') echo 'selected="selected"';?>>Multiple</option>
		</select>
		</td>
	</tr>
	<?php $multi_display='';
	if($user_travel_policy['trip_type']=='Multi')
			$multi_display='';
		else
			$multi_display='style="display:none"';
	?>
	<tr class="fieldRow1 multi" <?php echo $multi_display;?>>
		<td class="fieldLabelsColumn1 multi" <?php echo $multi_display;?> > <span class="fieldLabel1 form_txt1">Period of Travel:</span> <span class="mandFieldIndicator">*</span></td>
		<td class="fieldsColumn1 multi">
			<input value="6" name="perid_of_travel" type="radio" checked="checked" <?php if($user_travel_policy['perid_of_travel']=='6') echo 'checked="checked"';?> /><span class="form_txt">6 Months </span><input value="12" name="perid_of_travel" type="radio" <?php if($user_travel_policy['perid_of_travel']=='12') echo 'checked="checked"';?> /><span class="form_txt">12 Months </span>
		</td>
	</tr>
	<tr class="fieldRow1 multi" <?php echo $multi_display;?>>
		<td class="fieldLabelsColumn1 multi" <?php echo $multi_display;?>><span class="fieldLabel1 form_txt1">Maximum days per trip :</span><span class="mandFieldIndicator">*</span></td>
		<td class="fieldsColumn1 multi" <?php echo $multi_display;?>>
		<input name="max_trip_days" type="text" id="max_trip_days" tabindex="3"  class="generalDropDown" autocomplete="off" value="<?php echo $user_travel_policy['max_trip_days'];?>">
		</td>
	</tr>
	<tr class="fieldRow1 multi" <?php echo $multi_display;?>>
		<td class="fieldLabelsColumn1 multi" <?php echo $multi_display;?>><span class="fieldLabel1 form_txt1">Reason for Travel :</span><span class="mandFieldIndicator">*</span></td>
		<td class="fieldsColumn1 multi" <?php echo $multi_display;?>>
			<select name="reason_for_travel"  class="generalDropDown">
			<option value="">[--SELECT--]</option>
			<option value="1" <?php if($user_travel_policy['reason_for_travel']=='1') echo 'selected="selected"';?>>Business</option>
			<option value="2" <?php if($user_travel_policy['reason_for_travel']=='2') echo 'selected="selected"';?>>Holidays</option>
			<option value="3" <?php if($user_travel_policy['reason_for_travel']=='3') echo 'selected="selected"';?>>Business and Holidays</option>
			</select>
		</td>
	</tr>
	<?php $single_display='';
	if($user_travel_policy['trip_type']=='Single')
			$single_display='';
		else
			$single_display='style="display:none"';
	?>		
	<tr class="fieldRow1 single" <?php echo $single_display;?>>
		<td class="fieldLabelsColumn1 single"  <?php echo $single_display;?>><span class="fieldLabel1 form_txt1">Departure Date :</span><span class="mandFieldIndicator">*</span></td>
		<td class="fieldsColumn1 single"  <?php echo $single_display;?>>
			<input name="departure_date" type="text" id="departure_date" tabindex="3"  class="generalDropDown calender" autocomplete="off" value="<?php echo date('d-m-Y',strtotime($user_travel_policy['departure_date']));?>" onchange="validDepartureDate(this.value);" >
		</td>
	</tr>
	<tr class="fieldRow1 single"  <?php echo $single_display;?>>
		<td class="fieldLabelsColumn1 single"   <?php echo $single_display;?>><span class="fieldLabel1 form_txt1">Return Date  :</span><span class="mandFieldIndicator">*</span></td>
		<td class="fieldsColumn1 single"  <?php echo $single_display;?>>
			<input name="return_date" type="text" id="return_date" tabindex="3"  class="generalDropDown calender" autocomplete="off" value="<?php echo date('d-m-Y',strtotime($user_travel_policy['return_date']));?>" onchange="validReturnDate(this.value);" >
		</td>
	</tr>
	<tr class="fieldRow1">
	 <td class="fieldLabelsColumn1"><span class="fieldLabel form_txt1">Geographic coverage  :</span> <span class="mandFieldIndicator1">*</span></td>
	 <td class="fieldsColumn1"><select name="geo_coverage" id="geo_coverage" tabindex="13" class="generalDropDown"   disabled="disabled">
	   <option value="" selected="selected">[--SELECT--]</option>
	   <option value="1" <?php if($user_travel_policy['geo_coverage']=='1') echo 'selected="selected"';?>>Worldwide excluding US and Canada</option>
	   <option value="2" <?php if($user_travel_policy['geo_coverage']=='2') echo 'selected="selected"';?>>Worldwide including US and Canada</option>
	   <option value="3" <?php if($user_travel_policy['geo_coverage']=='3') echo 'selected="selected"';?>>Schengen</option>
	   <option value="4" <?php if($user_travel_policy['geo_coverage']=='4') echo 'selected="selected"';?>>GCC and Jordan</option>
	 </select></td>
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
	<tr height="10"></tr>
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>Travellers Details</strong></td>
	</tr>
	<tr>
		<td colspan="2">
		<?php $n=1; while($traveller=mysql_fetch_array($travellers))
		{?>
			<table width="100%">
				<tr height="54">
					<td width="12%"><span class="form_txt1" style="font-weight:700; padding-left:5px;">Traveller :</span></td>
					<td width="18%">
						<span class="form_txt1">Gender:</span><span class="mandFieldIndicator1">*</span>
						<select name="tgender[]" id="gender_<?php echo $n;?>" class="generalDropDown" style="width:80px;" onchange="validGender(1);">
							 <option value="M" <?php if($traveller['gender']=='M') echo 'selected="selected"';?>>Male</option>
							 <option value="F" <?php if($traveller['gender']=='F') echo 'selected="selected"';?>>Female</option>
						</select>
				  </td>
					<td width="25%">
						<span class="form_txt1">Date Of Birth:</span><span class="mandFieldIndicator1">*</span>
						<input name="tdob[]" id="dob_<?php echo $n;?>" class="generalTextBox" type="text" style="width:100px;" value="<?php echo date('d-m-Y',strtotime($traveller['dob']));?>" />
				  </td>
					<td width="23%">
						<span class="form_txt1">First Name:</span><span class="mandFieldIndicator1">*</span>
						<input name="tfname[]" class="generalTextBox" id="fname_<?php echo $n;?>" type="text" style="width:100px;" onkeyup="validFname(1);" value="<?php echo $traveller['fname'];?>" />
				  </td>
					<td width="22%">
						<span class="form_txt1">Last Name:</span><span class="mandFieldIndicator1">*</span>
						<input name="tlname[]" class="generalTextBox" type="text" id="lname_<?php echo $n;?>" style="width:100px; margin-right:5px;" onkeyup="validLname(1);" value="<?php echo $traveller['lname'];?>" />
						<input type="hidden" name="tid[]" value="<?php echo $traveller['id'];?>" />
				  </td>
				</tr>
			</table>
		<?php $n++;}?>
		<input type="hidden" name="travellers_count" id="travellers_count" value="<?php echo mysql_num_rows($travellers);?>" />
		<?php if(mysql_num_rows($travellers)=='0')echo 'No traveller found.';?>
		</td>
	</tr>
	<tr height="10"></tr>
	<tr height="20" bgcolor="#F0F0F0">
		<td colspan="2"><strong>Quotation Details</strong></td>
	</tr>
	<tr>
		<?php 
		$policy_id=$user_travel_policy['comp_policy_id'];
		$sql="select * from ".TRAVELPOLICY." where comp_policy_id='".$policy_id."'";
		$policy_details=mysql_fetch_assoc(mysql_query($sql));
		$c_detail=getCompanyDetails($policy_details['comp_id']);
		?>
		<td colspan="2">
			<div style="float:left; padding-right:10px;"><img src="<?php echo str_replace('admin/','',BASE_URL);?>upload/company/<?php if($c_detail['comp_logo'])echo $c_detail['comp_logo']; else echo 'no-image.jpg';?>" width="84" height="69" /></div>
			<?php echo $policy_details['title'];?><br />
			Laggage Loss : <?php if($policy_details['luggage_loss_note'])echo $policy_details['luggage_loss_note']; else echo 'Not Covered ';?><br />
			Baggage Delay : <?php if($policy_details['baggage_delay_note'])echo $policy_details['baggage_delay_note']; else echo 'Not Covered ';?><br />
			Flight Delay : <?php if($policy_details['flight_delay_note'])echo $policy_details['flight_delay_note']; else echo 'Not Covered ';?><br />
			Policy Amount : <?php echo $payment_details['policy_amt'].' '.CURRENCY; ?> 
		</td>
	</tr>
	<tr height="10"></tr>
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
			</select>
		</td>
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
	   </select>
	   </td>
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
		<textarea name="address1" style="height:50px; resize:none;" class="generalTextBox"><?php echo stripslashes($user_policy_details['address1']);?></textarea>
		</td>
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
		</select>
		</td>
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
		</select>
		</td>
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
		<input type="text" name="policy_from_date" onchange="getPolicyToDate(this.value);" value="<?php echo date('d-m-Y',strtotime($user_policy_details['policy_from_date']));?>" <?php if($user_travel_policy['trip_type']!='Single') echo 'class="calender"';?> readonly="readonly" /></td>
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