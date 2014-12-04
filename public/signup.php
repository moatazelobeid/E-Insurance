<?php 
//echo date("Y-m-d H:i:s");;

if(isset($_POST['save']))
{ 
	$checkemail = mysql_query("select * from ".USERTBL." where email='".$_POST['email']."'");
	if(mysql_num_rows($checkemail) >0)
	{
		$msg="<font color='red'></font><font color='#009933'>You are already registered</font>";
	}else
	{
		$username=$_POST['email'];
		
		$password=base64_encode($_POST['password']);
		
		$customer_id = get_code(USERTBL,'customer_code','id');
		$_POST['created_date'] = date("Y-m-d H:i:s");
		$_POST['dob'] = date("Y-m-d H:i:s",strtotime($_POST['dob']));
	
		$record_ins1 = $db->recordInsert(array("customer_code"=>$customer_id,"fname"=>$_POST['fname'],"dob"=>$_POST['dob'],"lname"=>$_POST['lname'],"email"=>$_POST['email'],"created_date"=>$_POST['created_date'],"address1"=>$_POST['address'],"security_question"=>$_POST['security_question'],"security_answer"=>$_POST['security_answer'],"phone_mobile"=>$_POST['phone_mobile'],"phone_landline"=>$_POST['phone_landline']),USERTBL);
		if($record_ins1 == '1')
		{
		  $empid = mysql_insert_id();
		  $db->recordInsert(array('uid'=>$empid,"user_type"=>'U',"uname"=>$username,"pwd"=>$password,"is_active"=>'1'),LOGINTBL);
		  
			$to = $_POST['email'];
			$subject = 'Congratulation!. your registration is successful with our site Alsgr';
			$message = '<span style="font-size: larger;"><strong><span style="color: rgb(51, 102, 153); font-family: Verdana, Geneva, sans-serif;">Dear {fname},<br />
	</span></strong></span><br style="color: rgb(51, 102, 153); font-family: Verdana, Geneva, sans-serif; font-size: 11px; " />
	<span style="color: rgb(51, 102, 153); font-family: Verdana, Geneva, sans-serif; font-size: 11px; ">We are glad to inform your that new login details for your account has been successfully updated.<br />
	</span><br style="color: rgb(51, 102, 153); font-family: Verdana, Geneva, sans-serif; font-size: 11px; " />
	<strong><span style="color: rgb(51, 102, 153); font-family: Verdana, Geneva, sans-serif; font-size: 11px; ">User Name :</span></strong><span style="color: rgb(51, 102, 153); font-family: Verdana, Geneva, sans-serif; font-size: 11px; "> {username}</span><br style="color: rgb(51, 102, 153); font-family: Verdana, Geneva, sans-serif; font-size: 11px; " />
	<strong><span style="color: rgb(51, 102, 153); font-family: Verdana, Geneva, sans-serif; font-size: 11px; ">New password:</span></strong><span style="color: rgb(51, 102, 153); font-family: Verdana, Geneva, sans-serif; font-size: 11px; "> {password}</span>&nbsp;<br />
	<span style="color:#336699;"><br />
	<strong>Best Wishes<br />
	<br />
	ALSGR Insurance</strong></span><br type="_moz" />';
			$message= setMailContent(array($_POST['fname'], $username, base64_decode($password)),$message);
			// send mail
			sendMail($to,$subject,$message);
		}
		if(mysql_affected_rows() > 0)
			$msg="<font color='#009933'></font><font color='#009933'>Your Registration is sucessfull</font>";
	}
}
?>
<script type="text/javascript">
function validForm(){ 

	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var str = document.quotation_form;
	var error = "";
	var flag = false;
	var email = $("#email").val();
	var dataArray = new Array();
	
	if(str.fname.value == "")
	{
		str.fname.style.borderColor = "RED";
		error += "- Enter Firstname \n";
		flag = false;
		dataArray.push('fname');
	}
	else
	{
		str.fname.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.lname.value == "")
	{
		str.lname.style.borderColor = "RED";
		error += "- Enter Last name \n";
		flag = false;
		dataArray.push('lname');
	}
	else
	{
		str.fname.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}

	if(str.phone_mobile.value == "")
	{
		str.phone_mobile.style.borderColor = "RED";
		error += "- Enter Mobile no \n";
		flag = false;
		dataArray.push('phone_mobile');
	}else if(isNaN(str.phone_mobile.value))
	{
	
	    str.phone_mobile.style.borderColor = "RED";
		error = "- Enter a Valid Phone(M) Number \n";
		flag = false;
	}
	else
	{
		str.phone_mobile.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.dob.value == "")
	{
		str.dob.style.borderColor = "RED";
		error += "- Enter Date of birth \n";
		flag = false;
		dataArray.push('dob');
	}
	else
	{
		str.dob.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.email.value == "")
	{
		str.email.style.borderColor = "RED";
		error += "- Enter Email \n";
		flag = false;
		dataArray.push('email');
	}
	else
	{
		str.email.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	
	if(str.password.value == "")
	{
		str.password.style.borderColor = "RED";
		error += "- Enter Password \n";
		flag = false;
		dataArray.push('password');
	}
	else
	{
		str.password.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if($("#password").val() != $("#retypepassword").val())
	{
		$("#retypepassword").css("border-color",'red');
		error += "- Password doesn't matches \n";
		alert(error);
		$("#retypepassword").focus();
		return false;
		
		
	}else
	{
		str.retypepassword.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.security_question.value == "")
	{
		str.security_question.style.borderColor = "RED";
		error += "- Select Security Question \n";
		flag = false;
		dataArray.push('security_question');
	}
	else
	{
		str.security_question.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.security_answer.value == "")
	{
		str.security_answer.style.borderColor = "RED";
		error += "- Select Security Answer \n";
		flag = false;
		dataArray.push('security_answer');
	}
	else
	{
		str.security_answer.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(email != '' && !filter.test(email))

	{

		$("#email").css("border-color",'RED');
		error += "- Enter Valid Email \n";
		alert(error);
		$("#email").focus();
		return false;

	}else
	{
		$("#email").css('border-color','');
		
	}
	if(flag == false)
	{
		alert(error);
		str.elements[dataArray[0]].focus();
		
	}
	else
	{
		document.getElementById("quotation_form").submit();
	}
}



</script>

<div id="signup-form">
<?php if(isset($msg))
		{ ?>
		<div><span><?=$msg?></span></div>
 <?php }?>
<!--BEGIN #subscribe-inner -->
		<div><span id="errmsg"></span></div>
        <div id="signup-inner">
        
        	<div class="clearfix" id="header">
                <h1>Alsagr Registration Form!</h1>
            </div>
            <form id="quotation_form" name="quotation_form" action=""   method="post">            
                <p>
                <label for="Fname">First Name *</label>
               <input name="fname" type="text" id="fname" tabindex="3" autocomplete="off" value="<?=$_POST['fname']?>"  />
                </p>
                 <p>
                <label for="lname">Last Name *</label>
                 <input name="lname" type="text" id="lname" tabindex="3" autocomplete="off" value="<?=$_POST['lname']?>"  />
                </p>
               
                
                 <p>
                <label for="mobile_no">Phone(M) *</label>
                <input id="phone_mobile" type="text" name="phone_mobile" value="<?=$_POST['phone_mobile']?>" />
                </p>
                
                <p>
                <label for="mobile_no">Phone(L)</label>
                <input id="phone_landline" type="text" name="phone_landline" value="<?=$_POST['phone_landline']?>" />
                </p>
                <p>
                <label for="mobile_no">Address</label>
                <textarea id="address1"  name="address" value="" ><?=$_POST['address']?></textarea>
                </p>
                 <p>
                <label for="dob">Date of Birth *</label>
                <input id="dob" type="text" autocomplete="off" class="dateofbirth" name="dob" value="<?=date('d/m/y',strtotime($_POST['dob']))?>" />
                </p>

                <h2 style="border-bottom: 1px solid #efefef;">Login Information!</h2>
                 <p>
                <label for="lname">Email *</label>
                 <input name="email" type="text" tabindex="3" autocomplete="off" value="<?=$_POST['email']?>" id="email"  />
                </p>
              
                 <p>
                <label for="dob">Password *</label>
                <input name="password" type="password" id="password" tabindex="3" class="generalTextBox" autocomplete="off" value="<?=$_POST['password']?>" />
                </p> 
                 <p>
                <label for="dob">Retype Password *</label>
                <input name="retypepassword" type="password" id="retypepassword" tabindex="3" class="generalTextBox" autocomplete="off" value="<?=$_POST['retypepassword']?>" />
                </p> 
                 <p>
                <label for="dob">Security Question *</label>
                <select name="security_question" class="generalDropDown" id="security_question">
               <option selected="selected" value="">--Choose Security Question--</option>
               <option value="1" <?=($_POST['security_question']=='1')?'Selected=selected':''?>>What was your first phone number</option>
               <option value="2" <?=($_POST['security_question']=='2')?'Selected=selected':''?>>What was your first pet name</option>
               <option value="3" <?=($_POST['security_question']=='3')?'Selected=selected':''?>>What was your first phone number</option>
               <option value="4" <?=($_POST['security_question']=='4')?'Selected=selected':''?>>What was your first pet name</option>
               <option value="5" <?=($_POST['security_question']=='5')?'Selected=selected':''?>>What was your first phone number</option>
               <option value="6" <?=($_POST['security_question']=='6')?'Selected=selected':''?>>What was your first pet name</option>
             </select>
                </p> 
                 <p>
                <label for="dob">Security Answer*</label>
                <input name="security_answer" type="text" id="security_answer" tabindex="3" class="generalTextBox" autocomplete="off" value="<?=$_POST['security_answer']?>"  />
                </p>
                <p>
				<input type="hidden" name="save" id="save" />
                <input type="button" onclick="validForm();" value="Save"  name="save" id="save"  />
                </p>
                 <div style="float:right;"><span id="errmsg" style=" font-size:12px;color:#900;"><a href="index.php?page=sign-in">Sign in</a></span></div>
                  
            </form>
            
		<div id="required">
		<p>* Required Fields<br/></p>
		</div>


            </div>
        
        <!--END #signup-inner -->
        </div>