<?php
// create user
if(isset($_POST['save']))
{
	// post params
	$user_type = "S";
	$salute = $_POST['salute'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$mphn = $_POST['mext'];
	$email =  $_POST['email'];
	$age = $_POST['age'];
	$u_id = $_POST['u_id'];		
	$pwd = $_POST['pwd'];
	$approve = '1';
	
	// message parameters
	$msg = "";
	$errmsg = "";
	
	// check email and username
	$sqlchk = mysql_query("SELECT * FROM ".USRTBL." WHERE mail_id = '".$email."'");
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
			$sql = mysql_query("INSERT INTO ".USRTBL." (salutation, fname, lname, mail_id, mobile_phone, age, create_date) VALUES ('".$salute."', '".$fname."', '".$lname."', '".$email."', '".$mphn."', '".$age."', now())");
			// last record id inserted immediately
			$ins_id = mysql_insert_id();
		
			$sql_login = mysql_query("INSERT INTO ".LOGINTBL." (uid, uname, pwd, user_type, is_active) VALUES ('".$ins_id."', '".$u_id."', '".base64_encode($pwd)."', '".$user_type."', '".$approve."')");
			if(mysql_affected_rows() > 0){
			
			// send confirmation mail
			// create mail
			$to = $email;
			$email_data=getEmailTemplate(1);
			$subject = $email_data['0'];
			$message= setMailContent(array($fname, $u_id, $pwd), $email_data['1']);
			// send mail
			sendMail($to,$subject,$message);
			// unset post array to make the cache clear
			unset($_POST);
			
			$msg="Admin account successfully created";
			}else{
			$errmsg = "Admin creation failed";
			}
	   }
	}
}

// update user information
if(isset($_POST['update']))
{
	// post params
	$user_type = "S";
	$salute = $_POST['salute'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$mphn = $_POST['mext'];
	
	$email =  $_POST['email'];
	$age = $_POST['age'];
	$u_id = $_POST['u_id'];
	$pwd = $_POST['pwd'];
	$approve = $_POST['approve'];
	
	// message parameters
	$msg = "";
	$errmsg = "";
	
	// check email and username exists or not
	$sqlchk = mysql_query("SELECT * FROM ".USRTBL." WHERE mail_id = '".$email."' and id!='".$_GET['id']."'");
	if(mysql_num_rows($sqlchk) > 0){
			$errmsg="- Email id already exists";
	}else{
		$rs=mysql_query("select uname from ".LOGINTBL." where uname='".$u_id."' and user_type='S' ");
        if(mysql_num_rows($rs) > 1)
		{
				$errmsg="- Username already exists";
		}else{
		
		$udata=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid='".$_GET['id']."' and user_type='S' "));
		if(($udata['uname']!=$u_id) || ($udata['pwd']!=base64_encode($pwd)))
		{
			//mail to admin on username or password change
			$to = $email;
			$email_data=getEmailTemplate(2);
			$subject = $email_data['0'];
			$message= setMailContent(array($fname, $u_id, $pwd), $email_data['1']);// send mail
			sendMail($to,$subject,$message);
		}
		
		
	 	$sql = mysql_query("UPDATE ".USRTBL." SET `salutation` = '".$salute."',
					`fname` = '".$fname."',
					`lname` = '".$lname."',
					`mail_id` = '".$email."',
					`mobile_phone` = '".$mphn."',
					`age` = '".$age."',
					`modify_date` = now() WHERE `id` =".$_GET['id']."");
       $sql2 = mysql_query("UPDATE ".LOGINTBL." SET uname = '".$u_id."', 
							pwd = '".base64_encode($pwd)."',
							is_active = '".$approve."' 
							WHERE uid ='".$_GET['id']."' and user_type = 'S'");	
		if($sql || $sql2){
		
			if($_GET['view']!='myaccount')
				$msg = "Admin account successfully updated";
			else
				$msg = "Your account successfully updated";
		}
		else{
			$errmsg = "- No Record Updated";
		}
	}
	}
}


// get user record
if(isset($_GET['id'])){
	$result = mysql_fetch_object(mysql_query("select ".USRTBL.".*,".LOGINTBL.".uname, ".LOGINTBL.".pwd,".LOGINTBL.".is_active,".LOGINTBL.".user_type from ".USRTBL.",".LOGINTBL." where ".USRTBL.".id = ".LOGINTBL.".uid AND ".USRTBL.".id = '".$_GET['id']."' and user_type='S'"));
	
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
	
	if(str.salute.value == "")
	{
		str.salute.style.borderColor = "RED";
		error = "- Select a salutation \n";
		flag = false;
	}
	else
	{
		str.salute.style.borderColor = "";
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

	if(str.mext.value == "")
	{
		str.mext.style.borderColor = "RED";
		error += "- Enter Your Mobile Number \n";
		flag = false;
	}
	else if(isNaN(str.mext.value)){
	
	    str.mext.borderColor = "RED";
		error = "- '"+str.mext.value+"' Is Not A Valid Number \n";
		flag = false;
	
	}
	else
	{
		str.lname.style.borderColor = "";
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

	if(str.u_id.value == "")
	{
		str.u_id.style.borderColor = "RED";
		error += "- Enter Username \n";
		flag = false;
	}
	else
	{
		str.u_id.style.borderColor = "";
	}
	
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
	
	<?php if(!isset($_GET['id'])){?>
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
         data: "chk_email="+ id + "&type=admin&id="+aid,
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
	else
	return true;
}

</script>
<div style="padding-left: 0px;">
<?php if($_GET['view']!='myaccount')
		$hmsg='Add/Edit Admin';
		else
			$hmsg='My Account';?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-bottom: 8px; margin-top: 10px;">
  <tr>
    <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong><?php echo $hmsg;?></strong></td>
	<?php if($_GET['view']!='myaccount')
	{?>
    <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036; padding-right: 0px;"><a href="account.php?page=admin_user"><img src="images/view_all.png" width="87" height="15" border="0"></a></td>
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
                <tr>
                  <td style="padding-left: 0px;">Salutation:</td>
                  <td><select name="salute" id="salute" style="width: 206px;">
                      <option value="">--- Select ---</option>
                      <option <?php if($result->salutation == 'Mr') echo "selected='selected'" ?> value="Mr">Mr.</option>
                      <option  <?php if($result->salutation == 'Mrs') echo "selected='selected'" ?> value="Mrs">Mrs.</option>
					  <option  <?php if($result->salutation == 'Mis') echo "selected='selected'" ?> value="Miss">Miss.</option>
                    </select>
                    <span style="padding-left: 0px;">*</span></td>
                </tr>
                <tr>
                  <td style="padding-left: 0px;">First Name:</td>
                  <td><input name="fname" type="text" class="textbox" id="fname" style="width: 200px;" value="<?php echo $result->fname; ?>" />
                    <span style="padding-left: 0px;">*</span></td>
                </tr>
                <tr>
                  <td width="19%" style="padding-left: 0px;">Last Name:</td>
                  <td width="81%"><input name="lname" type="text" class="textbox" id="lname" style="width: 200px;" value="<?php echo $result->lname ; ?>" />
				  </td>
                </tr>
                <tr>
                  <td style="padding-left: 0px;">Mobile:</td>
                  <td><input name="mext" class="textbox" id="mext"  maxlength="10" onkeypress="return isNumberKey(event)" type="text" value="<?php echo $phone; ?>" style="width: 200px;"/>
				  <span style="padding-left: 0px;">*</span></td>
                </tr>
                <tr>
                  <td style="padding-left: 0px;">Email:</td>
                  <td><div id='dr_span' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <input name="email" type="text" class="textbox" id="email" style="width: 200px;" value="<?php echo $result->mail_id; ?>" onblur="checkEmail(this.value);" />
                    <span style="padding-left: 0px;"> *</span></td>
                </tr>
                <tr>
                  <td style="padding-left: 0px;">Age:</td>
                  <td><div id="dispState">
                      <input name="age" type="text" class="textbox" onkeypress="return isNumberKey(event)" id="age" style="width: 200px;" value="<?php echo $result->age; ?>">
                    </div></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
      <td width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Login Details</strong></td>
          </tr>
          <tr>
            <td align="left"><table width="100%">
                <tr>
                  <td style="padding-left: 0px;">Username :</td>
                  <td>
				  <div id='err_uname' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <input name="u_id" type="text" class="textbox" id="u_id" style="width: 200px;" value="<?php echo $result->uname?>" onkeyup="checkUname(this.value);" autocomplete="off"/>
                    <span id="parent" style="font-weight: bold; font-size:10px;padding-left:5px;">*</span></td>
                </tr>
                <tr>
                  <td width="28%" style="padding-left: 0px;">Password:</td>
                  <td width="72%"><input name="pwd" type="text" class="textbox" id="pwd" style="width: 200px;" value="<?php echo base64_decode($result->pwd) ;?>" />
                    <span style="padding-left: 5px;">*</span></td>
                </tr>
                <?php if(!isset($_GET['id'])){?>
                <tr>
                  <td style="padding-left: 0px;">Retype Password:</td>
                  <td><input name="re_pwd" type="text" class="textbox" id="re_pwd" style="width: 200px;" value="<?php echo base64_decode($result->pwd); ?>">
                    <span style="padding-left: 5px;">*</span></td>
                </tr>
                <?php } ?>
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
              </table></td>
          </tr>
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
        <a href="account.php?page=admin_user" style="text-decoration:none">
        <input type="button" name="cancel" id="cancel" value="View All User" class="actionBtn" onclick="location.href='account.php?page=admin_user'">
        </a>
		<?php }?></td>
    </tr>
  </table>
</form>
</div>