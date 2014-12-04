<?php 
if(!isset($_SESSION['uid']) && empty($_SESSION['uid']))
{
	header("location:index.php?page=sign-in");
}else{
		
if(isset($_POST['update']))
{
	// post params
	$id=$_SESSION['uid'];
	$user_type = "U";
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];	
	$email =  $_POST['email'];
	$pwd = base64_encode($_POST['pwd']);
	$salutation = $_POST['salutation'];
	$country = $_POST['country'];
	$dl_no = $_POST['drive_license_no'];
	$occupation = $_POST['occupation'];
	$state = $_POST['state'];
	$gender = $_POST['gender'];
	// message parameters
	$msg = "";
	$errmsg = "";
	
	// check email and username exists or not
	$sqlchk = mysql_query("SELECT * FROM ".USRTBL." WHERE email = '".$email."' and id!='".$_SESSION['uid']."'");
	if(mysql_num_rows($sqlchk) > 0){
			$errmsg="- Email id already exists";
	}else{
		$rs=mysql_query("select uname from ".LOGINTBL." where uname='".$email."' and user_type='U' and and uid!='".$_SESSION['uid']."' ");
        if(mysql_num_rows($rs) > 1)
		{
				$errmsg="- Username already exists";
		}else{
			
		
		$udata=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid='".$_SESSION['uid']."' and user_type='U' "));
		$userinfoo = mysql_fetch_object(mysql_query("SELECT * FROM ksa_user WHERE  id!='".$_SESSION['uid']."' limit 1"));

		$dob = (!empty($_POST['dob']))?date("Y-m-d H:i:s",strtotime($_POST['dob'])):$userinfoo->dob;
		$update_arr = array("salutation"=>$salutation,"fname"=>$_POST['fname'],"gender"=>$gender,"accno"=>$_POST['accno'],"dob"=>$dob,"lname"=>$_POST['lname'],"occupation"=>$occupation,"state"=>$state,"drive_license_no"=>$dl_no,"address1"=>$_POST['address'],"address2"=>$_POST['address2'],"phone_mobile"=>$_POST['phone_mobile'],"phone_landline"=>$_POST['phone_landline'],"iqma_no"=>$_POST['iqma_no'],"accname"=>$_POST['accname'],"country"=>$country);
	 	$sql =$db->recordUpdate(array("id" => $id),$update_arr,'ksa_user');
	   $photo=$_FILES['cus_photo']['name'];
	
		//upload photo
		if($photo!=''){
		
			$photo1=time().$photo;
			$tmp=$_FILES['cus_photo']['tmp_name'];
			move_uploaded_file ($tmp,"upload/user/".$photo1);
			$resultq=$db->recordUpdate(array("id" => $id),array("cus_photo"=>$photo1),'ksa_user');
		}
		if($sql ){
		
			$msg = '<font color="#093">Customers account successfully updated</font>';
		}
		else{
			$errmsg = '<font color="RED">- No Record Updated</font>';
		}
	}
	}
}
if(!empty($_SESSION['uid'])){
	$result = mysql_fetch_object(mysql_query("select ksa_user.*,".LOGINTBL.".uname, ".LOGINTBL.".pwd,".LOGINTBL.".is_active,".LOGINTBL.".user_type from ksa_user,".LOGINTBL." where ksa_user.id = ".LOGINTBL.".uid AND ksa_user.id = '".$_SESSION['uid']."' and user_type='U'"));
	$phone = $result->phone_mobile;
	}

?>
<script type="text/javascript">
function val_form()
{
	var str = document.edit_frm;
	var error = "";
	var flag = true;
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if(str.salutation.value == "")
	{
		str.salutation.style.borderColor = "RED";
		error += "- Enter Salutation \n";
		flag = false;
	}
	else
	{
		str.salutation.style.borderColor = "";
	}

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
	/*if(str.address.value == "")
	{
		str.address.style.borderColor = "RED";
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

function checkEmail(id)
    {    
    var aid='<?php echo $_SESSION['uid'];?>';
	$.ajax({
         type: "POST",
         url: "admin/util/ajax-chk.php",
         data: "chk_email="+ id + "&type=customer&id="+aid,
         success: function(msg){
		 if(msg == 'ERRORERROR')
			{
			$("#dr_span11").html("This Emial ID already registered.");
		
			}
			else if(msg == 'OK')
			{
			$("#dr_span11").html("");
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
<div class="innrebodypanel">
				<div class="clearfix" style="height:15px;">.</div>
				<div class="innerwrap">
				
					<div class="breadcrumb" >
						<a itemprop="url" href="<?=BASE_URL?>">Home</a> 
                        <span class="breeadset">&#8250;</span>
						<a itemprop="url" href="index.php?page=user-dashboard">Dashboard</a> 
						<span class="breeadset">&#8250;</span>
						<strong>Edit Profile </strong>
					</div>
					
					<?php include_once('includes/dashboard-sidebar.php'); ?>
					
					<div class="lg-6">
						<div class="rightformpan innerTFl">
                        	<h1>Edit Your Profile</h1>
                            <?php if(isset($errmsg)){ echo '<p>'.$errmsg.'</p>';} if(isset($msg)){echo '<p>'.$msg.'</p>';} ?>
                 
                            <div class="wpcf7" id="wpcf7-f61-p12-o1" style="width: 47%; float:left;">
                              <form action="" method="post"  name="edit_frm" id="edit_frm" class="wpcf7-form" enctype="multipart/form-data" onSubmit="return val_form();">
                            
                            <?php /*?><div class="form-row">
                              <label for="your-subject">Customer Type <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-subject">
                              <input type="radio" name="customer_type" id="customer_type1" value="1" checked="checked" <?php if($result->customer_type == '1')echo "checked='checked'";?> />Individual
				  			  <input name="customer_type" type="radio" id="customer_type2" value="2" <?php if($result->customer_type == '2')echo "checked='checked'";?>  />Commercial</td> 
                              </span>
                              <div class="clear" style="height:5px;"></div> 
                            </div><?php */?>
                            
                            <div class="form-row">
                              <label for="your-name">Salutation <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-name">
                              <select name="salutation" class="dropdown" id="salutation" >
                               <option value="">Select</option>
                              <option value="Mr" <?php if($result->salutation == 'Mr'){echo 'selected="selected"';}?>>Mr</option>
                              <option value="Miss" <?php if($result->salutation == 'Miss'){echo 'selected="selected"';}?>>Miss</option>
                              <option value="Mrs" <?php if($result->salutation == 'Mrs'){echo 'selected="selected"';}?>>Mrs</option>
                              <option value="Dr" <?php if($result->salutation == 'Dr'){echo 'selected="selected"';}?>>Dr</option>
                              </select>
                              </span>
                            </div>
                            <div class="form-row">
                              <label for="your-email">Name <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input type="text" name="fname" value="<?=$result->fname?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text"  id="fname" aria-required="true">
                              </span>
                            </div>
                             <?php /*?><div class="form-row">
                              <label for="your-email">Last name <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input type="text" name="lname" value="<?=$result->lname?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text"  id="lname" aria-required="true">
                              </span>
                            </div><?php */?>
                            <div class="form-row">
                              <label for="your-email">Date of birth <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input type="text" name="dob" readonly='readonly' value="<?php echo (!empty($result->dob) && $result->dob != '0000-00-00 00:00:00')?date('d/m/y',strtotime($result->dob)):''; ?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text"  id="dob" aria-required="true">
                              </span>
                            </div>
                            <div class="form-row">
                              <label for="your-subject">Gender <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-subject">
                              <input type="radio" name="gender" id="sex" value="m" checked="checked" <?php if($result->gender == 'm')echo "checked='checked'";?> />Male
				  			  <input name="gender" type="radio" id="sex" value="f" <?php if($result->gender == 'f')echo "checked='checked'";?>  />Female</td> 
                              </span>
                            </div>
                            <div class="form-row">
                              <label for="your-email">Email <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email"><div id='dr_span11' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
                              <input type="email" name="email"  value="<?=$result->email?>" size="40"  onblur="checkEmail(this.value);" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text"  id="email" aria-required="true">
                              </span>
                            </div>
                            <?php /*?><div class="form-row">
                              <label for="your-email">Occupation</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input type="text" name="occupation"  value="<?=$result->occupation?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text"  id="occupation" aria-required="true">
                              </span>
                            </div><?php */?>
                            <?php if(!empty($result->cus_photo)): ?>
                            <div class="form-row">
                              <span class="wpcf7-form-control-wrap your-email">
                             <img width="50" height="50"  src="<?php echo SITE_URL.'upload/user/'.$result->cus_photo;?>"/>
                              </span>
                            </div>
                            <?php endif; ?>
                            <div class="form-row">
                              <label for="your-email">Photo</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input name="cus_photo" class="textbox" id="cus_photo" type="file"  style="width: 200px;"/>
                              </span>
                            </div>
                            
                             <div class="form-row">
                              <label for="your-email">Account Name</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input name="accname" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text" value="<?=$result->accname?>"  id="accname" type="text"  />
                              </span>
                            </div>
                          
                            </div>
                           <div class="clear" style="height:0px;"></div> 
                            <div class="wpcf7" id="wpcf7-f61-p12-o1" style="width:47%; float:right;">
                             <?php /*?><div class="form-row">
                              <label for="your-message">Address(Primary)</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-message">
                              <textarea name="address"  class="wpcf7-form-control wpcf7-textarea input-textarea" style="height:75px" id="address"><?=$result->address1?></textarea>
                              </span>
                            </div>
                            <div class="form-row">
                              <label for="your-message">Address(Secondary)</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-message">
                              <textarea name="address2"  class="wpcf7-form-control wpcf7-textarea input-textarea" style="height:75px" id="address2"><?=$result->address2?></textarea>
                              </span>
                            </div><?php */?>
                            
                            <div class="form-row">
                              <label for="your-email">Account Number</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input name="accno" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text" value="<?=$result->accno?>"  id="accno" type="text"  />
                              </span>
                            </div>
                            
                            <div class="form-row">
                              <label for="your-email">Driving License Number</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input name="drive_license_no" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text" value="<?=$result->drive_license_no?>"  id="drive_license_no" type="text"  />
                              </span>
                            </div>
                            
                            <div class="form-row">
                            
                              <label for="your-name">Phone(M) <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-name">
                              <input type="text" name="phone_mobile" value="<?=$phone?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required input-text" onkeypress="return isNumberKey(event)" id="phone_mobile" aria-required="true">
                              </span>
                            </div>
                            <?php /*?><div class="form-row">
                              <label for="your-email">Phone(L)</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input type="text" name="phone_landline" value="<?=$result->phone_landline?>" size="40" onkeypress="return isNumberKey(event)" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text" id="phone_landline" aria-required="true">
                              </span>
                            </div><?php */?>
                             <div class="form-row">
                              <label for="your-email">IQMA Number</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input type="text" name="iqma_no" value="<?=$result->iqma_no?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text" id="iqma_no" aria-required="true">
                              </span>
                            </div>
                            <div class="form-row">
                              <label for="your-subject">Country <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-subject">
                            <select name="country" class="dropdown" id="country"  >
                              <option value="Saudi Arabia" selected="selected">Saudi Arabia</option>
                              </select>
                              </span>
                            </div>
                             <div class="form-row">
                              <label for="your-email">State</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <?php /*?><input type="text" name="state" value="<?=$result->state?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text" id="state" aria-required="true"><?php */?>
                              <select name="state" class="dropdown" id="state"  >
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
                              
                              </span>
                            </div>
                            <div class="form-row-submit" style="float:right; margin-right:0px;">
                              <input type="submit" name="update" value="Update"  class="submitbtn1" style="float: left;">
                            </div>
                          </form>
                            </div>
                            <div class="clearfix" style="height:100px;">.</div>
                        </div>
					</div>
                    
                    
				
				<div class="clearfix"></div>
				</div>
				<div class="clearfix" style="height: 15px;">.</div>
		</div>
<?php } ?>