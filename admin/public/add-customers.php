<?php
// create user

function get_customer_code($table,$ufield,$record_id,$whre="")
{
    if($whre!= ''){
		$sq = mysql_query("SELECT MAX($ufield) AS scode FROM $table $whre ORDER BY $record_id DESC LIMIT 0,1");
	}else{
		$sq = mysql_query("SELECT MAX($ufield) AS scode FROM $table ORDER BY $record_id DESC LIMIT 0,1");
	}
	
	// get code
	$res = mysql_fetch_object($sq);
	$s_code = $res->scode;
	if(isset($s_code)){
		$scode = $s_code + 1;
	}else{
		$scode = "1001";
	}
	return $scode;
}
if(isset($_POST['save']))
{

	// post params
	$user_type = "U";
	$email =  $_POST['email'];
	$uname = $_POST['email'];	
	$accno = $_POST['accno'];	
	$accname = $_POST['accname'];
	$salutation = $_POST['salutation'];
	$customer_source = $_POST['customer_source'];
	$country = $_POST['country'];
	$pwd = rand(6, 15);
	$customer_type =  $_POST['customer_type'];
	$approve = '1';
	$dl_no = $_POST['drive_license_no'];
	$occupation = $_POST['occupation'];
	$state = $_POST['state'];
	// message parameters
	$msg = "";
	$errmsg = "";
	$photo=$_FILES['cus_photo']['name'];
	if($photo!='')
	{
      $photo1=time().$photo;
	  $_POST['cus_photo'] = $photo1;
      $tmp=$_FILES['cus_photo']['tmp_name'];
      move_uploaded_file ($tmp,"../upload/user/".$photo1);
    }

	
	// check email and username
	$sqlchk = mysql_query("SELECT * FROM ".USRTBL." WHERE email = '".$email."'");
	if(mysql_num_rows($sqlchk) > 0)
	{
			$errmsg = "Email id already exists";
	}
	else
	{
		$rs=mysql_query("select uname from ".LOGINTBL." where uname='".$u_id."' and user_type='S' ");
        if(mysql_num_rows($rs) > 0)
		{
		   $errmsg = "Username already exists";
		}
		else
		{
			$customer_id = get_code(USERTBL,'customer_code','id');
			$_POST['created_date'] = date("Y-m-d H:i:s");
			$_POST['dob'] = date("Y-m-d H:i:s",strtotime($_POST['dob']));
			$insertcustomer = $db->recordInsert(array("customer_code"=>$customer_id,"fname"=>$_POST['fname'],"dob"=>$_POST['dob'],"email"=>$_POST['email'],"drive_license_no"=>$dl_no,"accno"=>$accno,"accname"=>$accname,"accname"=>$accname,"created_date"=>$_POST['created_date'],"phone_mobile"=>$_POST['phone_mobile'],"iqma_no"=>$_POST['iqma_no'],"country"=>$country,"customer_type"=>$customer_type,'cus_photo'=>$photo1,"customer_source"=>$customer_source,"state"=>$state),USERTBL);
			// last record id inserted immediately
			$ins_id = mysql_insert_id();
		
			$sql_login = mysql_query("INSERT INTO ".LOGINTBL." (uid, uname, pwd, user_type, is_active) VALUES ('".$ins_id."', '".$uname."', '".base64_encode($pwd)."', '".$user_type."', '".$approve."')");
			if(mysql_affected_rows() > 0){
				// unset post array to make the cache clear
			unset($_POST);
			
			$msg="Customer Account successfully created";
			}else{
			$errmsg = "Customer creation failed";
			}
	   }
	}
}

// update user information
if(isset($_POST['update']))
{
	// post params
	$id=$_GET['id'];
	$user_type = "U";
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];	
	$email =  $_POST['email'];
	$pwd = base64_encode($_POST['pwd']);
	$approve = $_POST['approve'];
	$salutation = $_POST['salutation'];
	$country = $_POST['country'];
	$dl_no = $_POST['drive_license_no'];
	$occupation = $_POST['occupation'];
	$state = $_POST['state'];
	// message parameters
	$msg = "";
	$errmsg = "";
	
	// check email and username exists or not
	$sqlchk = mysql_query("SELECT * FROM ".USRTBL." WHERE email = '".$email."' and id!='".$_GET['id']."'");
	if(mysql_num_rows($sqlchk) > 0){
			$errmsg="- Email id already exists";
	}else{
		$rs=mysql_query("select uname from ".LOGINTBL." where uname='".$email."' and user_type='U' and and uid!='".$_GET['id']."' ");
        if(mysql_num_rows($rs) > 1)
		{
				$errmsg="- Username already exists";
		}else{
			
		
		$udata=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid='".$_GET['id']."' and user_type='U' "));
		if(($udata['uname']!=$email) || ($udata['pwd']!=base64_encode($pwd)))
		{
			//mail to admin on username or password change
			$to = $email;
			$email_data=getEmailTemplate(2);
			$subject = $email_data['0'];
			$message= setMailContent(array($fname, $email, $pwd), $email_data['1']);// send mail
			sendMail($to,$subject,$message);
		}
		$userinfoo = mysql_fetch_object(mysql_query("SELECT * FROM ksa_user WHERE  id!='".$_GET['id']."' limit 1"));

		$dob = (!empty($_POST['dob']))?date("Y-m-d H:i:s",strtotime($_POST['dob'])):$userinfoo->dob;
		$update_arr = array("fname"=>$_POST['fname'],"accno"=>$_POST['accno'],"customer_type"=>$_POST['customer_type'],"dob"=>$dob,"state"=>$state,"drive_license_no"=>$dl_no,"phone_mobile"=>$_POST['phone_mobile'],"iqma_no"=>$_POST['iqma_no'],"accname"=>$_POST['accname'],"country"=>$country,"state"=>$state);
	 	$sql =$db->recordUpdate(array("id" => $id),$update_arr,'ksa_user');
       	$sql2 = $db->recordUpdate(array("uid" => $id),array('uname'=>$email,'pwd'=>$pwd,'is_active'=>$approve),LOGINTBL);
	  	$photo=$_FILES['cus_photo']['name'];
	
		//upload photo
		if($photo!=''){
		
			$photo1=time().$photo;
			$tmp=$_FILES['cus_photo']['tmp_name'];
			move_uploaded_file ($tmp,"../upload/user/".$photo1);
			$resultq=$db->recordUpdate(array("id" => $id),array("cus_photo"=>$photo1),'ksa_user');
		}
		if($sql || $sql2){
		
			$msg = "Customers account successfully updated";
		}
		else{
			$errmsg = "- No Record Updated";
		}
	}
	}
}


// get user record
if(isset($_GET['id'])){
	$result = mysql_fetch_object(mysql_query("select ksa_user.*,".LOGINTBL.".uname, ".LOGINTBL.".pwd,".LOGINTBL.".is_active,".LOGINTBL.".user_type from ksa_user,".LOGINTBL." where ksa_user.id = ".LOGINTBL.".uid AND ksa_user.id = '".$_GET['id']."' and user_type='U'"));
	$phone = $result->mobile_phone;
}
?>

<script type="text/javascript">
function validateManager()
{
	var str = document.p_fr;
	var error = "";
	var flag = true;
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	/*if(str.salutation.value == "")
	{
		str.salutation.style.borderColor = "RED";
		error += "- Enter Salutation \n";
		flag = false;
	}
	else
	{
		str.salutation.style.borderColor = "";
	}*/

	if(str.fname.value == "")
	{
		str.fname.style.borderColor = "RED";
		error += "- Enter First Name \n";
		flag = false;
	}
	else
	{
		str.fname.style.borderColor = "";
	}

	/*if(str.lname.value == "")
	{
		str.lname.style.borderColor = "RED";
		error += "- Enter Last Name \n";
		flag = false;
	}
	else
	{
		str.lname.style.borderColor = "";
	}*/
	if(str.dob.value == "")
	{
		str.dob.style.borderColor = "RED";
		error += "- Enter Date of birth \n";
		flag = false;
	}
	else
	{
		str.dob.style.borderColor = "";
	}
	if(str.email.value == "")
	{
		str.email.style.borderColor = "RED";
		error += "- Enter Your Email \n";
		flag = false;
	}
	else if(str.email.value.search(filter) == -1)
	{
	    str.email.style.borderColor = "RED";
		error += "- Valid Email Address Is Required  \n";
		flag = false;
	}
	else
	{
		str.email.style.borderColor = "";
	}
	/*if(str.address1.value == "")
	{
		str.address1.style.borderColor = "RED";
		error += "- Enter Address\n";
		flag = false;
	}
	else
	{
		str.address1.style.borderColor = "";
	}*/
	if(str.phone_mobile.value == "")
	{
		str.phone_mobile.style.borderColor = "RED";
		error += "- Enter Phone Number \n";
		flag = false;
	}
	else
	{
		str.phone_mobile.style.borderColor = "";
	}
	if(str.iqma_no.value == "")
	{
		str.iqma_no.style.borderColor = "RED";
		error += "- Enter IQMA Number \n";
		flag = false;
	}
	else
	{
		str.iqma_no.style.borderColor = "";
	}

	<?php if(isset($_GET['id'])){?>
	if(str.pwd.value == "")
	{
		str.pwd.style.borderColor = "RED";
		error += "- Enter Password \n";
		flag = false;
	}
	else
	{
		str.pwd.style.borderColor = "";
	}
	
	
	if(str.re_pwd.value == "")
	{
		str.re_pwd.style.borderColor = "RED";
		error += "- Retype Password \n";
		flag = false;
	}
	else
	{
		str.re_pwd.style.borderColor = "";
	}
	if((str.re_pwd.value != "") && (str.pwd.value != "" )){
		if(str.re_pwd.value != str.pwd.value)
		{
			str.re_pwd.style.borderColor = "RED";
			str.pwd.style.borderColor = "RED";
			error += "- Passwords do not match \n";
			flag = false;
		}
	}
	<?php } ?>
	
	if(flag == false)
	{
		alert(error);
		return false;
	}
	else
	{
	return true;
	}
}

function checkUname(id)
{    
   var aid='<?php echo $_GET['id'];?>';  
    $.ajax({
         type: "POST",
         url: "util/ajax-chk.php",
         data: "chk_uname="+ id + "&type=admin&id="+aid,
         success: function(msg)
		 {
			if(msg == 'ERROR')
			{
			$("#err_uname").html("This username is already taken");
			document.getElementById('u_id').value="";
			}
			else if(msg == 'OK')
			{
			$("#err_uname").html("");
			}	
		 }    
	});
}

function checkEmail(id)
    {    
    var aid='<?php echo $_GET['id'];?>';
	$.ajax({
         type: "POST",
         url: "util/ajax-chk.php",
         data: "chk_email="+ id + "&type=customer&id="+aid,
         success: function(msg){
		 if(msg == 'ERRORERROR')
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
	else
	return true;
}

</script>
<div style="padding-left: 0px;">
<?php if($_GET['view']!='myaccount')
		$hmsg='Add/Edit Customers';
		else
			$hmsg='My Account';?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-bottom: 8px; margin-top: 10px;">
  <tr>
    <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong><?php echo $hmsg;?></strong></td>
	<?php if($_GET['view']!='myaccount')
	{?>
    <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036; padding-right: 0px;"><a href="account.php?page=customer-list"><img src="images/view_all.png" width="87" height="15" border="0"></a></td>
	<?php }?>
  </tr>
</table>
<?php
if($msg <> ""){
	?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;">
  <tr>
    <td width="2%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
    <td width="98%"><?php echo $msg; ?></td>
  </tr>
</table>
<?php } ?>
<?php
if($errmsg <> ""){
	?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #900;">
  <tr>
    <td width="2%" valign="top"><img src="<?php echo IMG_PATH; ?>warning.png" width="24" height="24" /></td>
    <td width="98%"><strong>Opps !! Following Errors has been detected</strong><br />
      <?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>
<form action="" method="post" name="p_fr" onSubmit="return validateManager();" enctype="multipart/form-data">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
    <tr>
        <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Customer Details:</strong></td>
      </tr>
    </table>		
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 2px;">
          
                <tr>
                	<td width="12%"  height="35" style="padding-left: 2px;"><strong>Customer Id:</strong></td>
                  <td width="38%"  height="35" style=" padding-left: 2px;"><input readonly="readonly" name="customercode" type="text" class="textbox" id="emp_code" style="width: 200px; border: none; font-size: 14px;background-color:white; border-left: 1px solid #666;" value="<?php  if($_GET['id']!=''){echo $result->customer_code;}else{echo get_customer_code(USERTBL,'customer_code','id');} ?>"/></td>
                  <td width="14%" align="left" style="border-bottom: 0px solid #99C; "><strong>Customer Type:</strong></td>
                  <td width="36%" height="35" colspan="2">
	<?php ?>
	<select name="customer_type" id="customer_type" style="background-color: #FFFFFF; border: none;font-weight: normal; font-size: 14px; margin-top: 5px;">
    
	<option value="1" <?=($result->customer_type == 1)?'selected=selected':''?> >Individual</option>
    </select>	</td>
                </tr>
              
	  </table>
	
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
        <tr>
          <td width="50%" valign="top" style="padding-right: 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
              <tr>
           <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Personal  Details</strong></td>
        </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding-top: 5px;"><table width="100%" border="0" cellspacing="0" cellpadding="2">
            
            	<?php /*?><tr>
                  <td style="padding-left: 0px;">Salutation:</td>
                  <td><select name="salutation" class="textbox" id="salutation"  style="width: 209px;">
                   <option value="" >Select</option>
                  <option value="Mr" <?php if($result->salutation == 'Mr'){echo'selected="selected"';}  ?>>Mr</option>
               	  <option value="Miss" <?php if($result->salutation == 'Miss'){echo'selected="selected"';}  ?>>Miss</option>
                  <option value="Mrs" <?php if($result->salutation == 'Mrs'){echo'selected="selected"';}  ?>>Mrs</option>
                  <option value="Dr" <?php if($result->salutation == 'Dr'){echo'selected="selected"';}  ?>>Dr</option>
                  </select>
                    <span style="padding-left: 0px;">*</span></td>
                </tr> <?php */?>               
                <tr>
                  <td style="padding-left: 0px;"> Name:</td>
                  <td><input name="fname" type="text" class="textbox" id="fname" style="width: 200px;" value="<?php echo $result->fname; ?>" />
                    <span style="padding-left: 0px;">*</span></td>
                </tr>
                <?php /*?><tr>
                  <td width="19%" style="padding-left: 0px;">Last Name:</td>
                  <td width="81%"><input name="lname" type="text" class="textbox" id="lname" style="width: 200px;" value="<?php echo $result->lname ; ?>" />
				  </td>
                </tr><?php */?>
              
                <tr>
                  <td style="padding-left: 0px;">Date of Birth:</td>
                  <td><div id='dr_span11' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <input name="dob" type="text" class="textbox" id="dob" style="width: 200px;" value="<?php echo (!empty($result->dob) && $result->dob != '0000-00-00 00:00:00')?date('d/m/y',strtotime($result->dob)):''; ?>"  />
                    <span style="padding-left: 0px;"> *</span></td>
                </tr>
            	<tr>
                  <td width="24%" style="padding-left: 0px;">Gender:</td>
                  <td width="76%" style="padding-left: 0px;">
				 
				  <input type="radio" name="gender" id="sex" value="m" checked="checked" <?php if($result->gender == 'm')echo "checked='checked'";?> />Male
				  <input name="gender" type="radio" id="sex" value="f" <?php if($result->gender == 'f')echo "checked='checked'";?>  />Female</td> 
                </tr>
                <tr>
                  <td style="padding-left: 0px;">Email:</td>
                  <td><div id='dr_span' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <input name="email" type="text" class="textbox" id="email" style="width: 200px;" value="<?php echo $result->email; ?>" onblur="checkEmail(this.value);" />
                    <span style="padding-left: 0px;"> *</span></td>
                </tr>
                <?php /*?><tr>
                  <td style="padding-left: 0px;">Occupation:</td>
                  <td><div id='occupation' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <input name="occupation" type="text" class="textbox" id="occupation" style="width: 200px;" value="<?php echo $result->occupation; ?>"/>
                    
                </tr><?php */?>
                <?php if(isset($_GET['id'])){?>
                <tr>
                  <td style="padding-left: 0px;">Status:</td>
                  <td><select name="approve" id="approve" style="width:205px;">
                      <option value="1" <?php if($result->is_active == '1') echo "selected" ?>>Approve</option>
                      <option value="0" <?php if($result->is_active == '0') echo "selected" ?>>Disapprove</option>
                    </select>
                    <span style="padding-left: 5px;">*</span></td>
                </tr>
                <?php }?>
                <?php if(!empty($result->cus_photo))
				{?>
                <tr>
                  <td style="padding-left: 0px;" colspan="2"><img width="50" height="50"  src="<?php echo SITE_URL.'upload/user/'.$result->cus_photo;?>"/></td>
                </tr>
                <?php } ?>
                <tr>
                  <td style="padding-left: 0px;">Photo:</td>
                  <td><input name="cus_photo" class="textbox" id="cus_photo" type="file"  style="width: 200px;"/></td>
          		</tr>
              </table></td>
          </tr>
           <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Account Information</strong></td>
          </tr>
           <tr>
          <td><table width="100%">
             	  <tr>
                  <td width="24%" style="padding-left: 0px;">Account Name:</td>
                  <td width="76%"><input name="accname" type="text" class="textbox" id="accname" style="width: 200px;" value="<?php echo $result->accname ;?>" />
                  <input name="customer_source" type="hidden"  id="customer_source" style="width: 200px;" value="Offline" />
                  </td>
                </tr>
                <tr>
                  <td width="24%" style="padding-left: 0px;">Account Number:</td>
                  <td width="76%"><input name="accno" type="text" class="textbox" id="accno" style="width: 200px;" value="<?php echo $result->accno ;?>" /></td>
                </tr>
  				<tr>
                  <td width="24%" style="padding-left: 0px;">Driving License No:</td>
                  <td width="76%"><input name="drive_license_no" type="text" class="textbox" id="drive_license_no" style="width: 200px;" value="<?php echo $result->drive_license_no ;?>" /></td>
                </tr>
          </table></td>
          </tr>
        </table></td>
      <td width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
      
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Address Details</strong></td>
          </tr>
          <tr>
            <td align="left"><table width="100%">
              <?php /*?>  <tr>
                  <td style="padding-left: 0px;">Username :</td>
                  <td>
				  <div id='err_uname' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <input name="uname" type="text" class="textbox" id="u_id" style="width: 200px;" value="<?php echo $result->uname?>" readonly="readonly" onkeyup="checkUname(this.value);" autocomplete="off"/>
                    <span id="parent" style="font-weight: bold; font-size:10px;padding-left:5px;">*</span></td>
                </tr><?php */?>
                 
                    <?php /*?><tr>
                  <td width="28%"  style="padding-left: 0px;">Address (Primary):</td>
                  <td width="72%"><div id='dr_span12' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <textarea id="address1" class="textbox"  name="address" value="" style="margin: 2px; width: 198px; height: 52px; resize:none;" ><?php echo $result->address1; ?></textarea><span style="padding-left: 0px;">*</span></td>
                </tr>
                <tr>
                  <td width="28%"  style="padding-left: 0px;">Address (Secondary):</td>
                  <td width="72%"><div id='dr_span12' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <textarea id="address2" class="textbox"  name="address2" value="" style="margin: 2px; width: 198px; height: 52px; resize:none;" ><?php echo $result->address2; ?></textarea></td>
                </tr><?php */?>
                  <tr>
                  <td style="padding-left: 0px;">Phone(M):</td>
                  <td><input name="phone_mobile" class="textbox" id="phone_mobile"  maxlength="10" onkeypress="return isNumberKey(event)" type="text" value="<?php echo $result->phone_mobile; ?>" style="width: 200px;"/>
				  <span style="padding-left: 0px;">*</span></td>
                </tr>
                <?php /*?><tr>
                  <td style="padding-left: 0px;">Phone(L):</td>
                  <td><input name="phone_landline" class="textbox" id="phone_landline"  maxlength="10" onkeypress="return isNumberKey(event)" type="text" value="<?php echo $result->phone_landline; ?>" style="width: 200px;"/></td>
                </tr><?php */?>
                <tr>
                  <td style="padding-left: 0px;">IQMA Number:</td>
                  <td><input name="iqma_no" class="textbox" id="iqma_no"  maxlength="10" type="text" value="<?php echo $result->iqma_no; ?>" style="width: 200px;"/></td>
                </tr>
                 <tr>
                  <td style="padding-left: 0px;">Country:</td>
                  <td><select name="country" class="textbox" id="country"  style="width: 209px;">
                  <option value="Saudi Arabia" <?php if($result->country == 'Saudi Arabia'){?>selected="selected"<?php }?>>Saudi Arabia</option>
                  </select>
                  </td>
                </tr>
                <tr>
                  <td style="padding-left: 0px;">State:</td>
                  <td>
				  <select id="state" name="state" class="textbox" style="width: 200px;">
						<option value="">-Select-</option>
						<option value="Asir" <?php if($result->state == 'Asir'){echo 'selected="selected"';}?>>Asir</option>
						<option value="Al Qasim" <?php if($result->state == 'Al Qasim'){echo 'selected="selected"';}?>>Al Qasim</option>
						<option value="Al Madinah" <?php if($result->state == 'Al Madinah'){echo 'selected="selected"';}?>>Al Madinah</option>
						<option value="Al Jawf" <?php if($result->state == 'Al Jawf'){echo 'selected="selected"';}?>>Al Jawf</option>
						<option value="Al Bahah" <?php if($result->state == 'Al Bahah'){echo 'selected="selected"';}?>>Al Bahah</option>
						<option value="Al Riyadh" <?php if($result->state == 'Al Riyadh'){echo 'selected="selected"';}?>>Al Riyadh</option>
						<option value="Eastern Province" <?php if($result->state == 'Eastern Province'){echo 'selected="selected"';}?>>Eastern Province</option>
						<option value="Hail" <?php if($result->state == 'Hail'){echo 'selected="selected"';}?>>Hail</option>
						<option value="Jizan" <?php if($result->state == 'Jizan'){echo 'selected="selected"';}?>>Jizan</option>
						<option value="Makkah" <?php if($result->state == 'Makkah'){echo 'selected="selected"';}?>>Makkah</option>
						<option value="Najran" <?php if($result->state == 'Najran'){echo 'selected="selected"';}?>>Najran</option>
						<option value="Northern Borders" <?php if($result->state == 'Northern Borders'){echo 'selected="selected"';}?>>Northern Borders</option>
						<option value="Tabuk" <?php if($result->state == 'Tabuk'){echo 'selected="selected"';}?>>Tabuk</option>
					</select>
				  <?php /*?><input name="state" class="textbox" id="state"  maxlength="10" type="text" value="<?php echo $result->state; ?>" style="width: 200px;"/><?php */?>
                  </td>
                </tr>
              </table>
              </td>
          </tr><?php if(isset($_GET['id'])){?>
            <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Login details</strong></td>
          </tr>
           <tr>
          <td><table width="100%">
             
                <tr>
                  <td width="28%" style="padding-left: 0px;">Password:</td>
                  <td width="72%"><input name="pwd" type="text" class="textbox" id="pwd" style="width: 200px;" value="<?php echo base64_decode($result->pwd) ;?>" />
                    <span style="padding-left: 5px;">*</span></td>
                </tr>
               
                <tr>
                  <td style="padding-left: 0px;">Retype Password:</td>
                  <td><input name="re_pwd" type="text" class="textbox" id="re_pwd" style="width: 200px;" value="<?php echo base64_decode($result->pwd); ?>">
                    <span style="padding-left: 5px;">*</span></td>
                </tr>
               
          </table></td>
          </tr>
           <?php } ?>
        </table></td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding-top: 5px;"></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
        </table></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" style="padding-top: 5px;"><?php
	if($_GET['id'] != "" && $task == "edit"){
    ?>
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn">
        <?php }else{ ?>
        <input type="submit" name="save" id="save" value="Create Account" class="actionBtn">
        <?php } 
		if($_GET['view']!='myaccount')
		{?>
        <a href="account.php?page=customer-list" style="text-decoration:none">
        <input type="button" name="cancel" id="cancel" value="View All User" class="actionBtn" onclick="location.href='account.php?page=add-customers'">
        </a>
		<?php }?></td>
    </tr>
  </table>
</form>
</div>