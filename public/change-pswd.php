<?php 


if(!isset($_SESSION['uid']) && empty($_SESSION['uid']))
{
	header("location:index.php?page=sign-in");
}
if(isset($_POST['save']))
{

	$uid = $_SESSION['uid'];
	$oldpasswrd= $_POST['oldpassword'];
	$paswd = base64_encode($_POST['password']);
	$check_user = mysql_query("select * from ".LOGINTBL." WHERE uid ='".$uid."' AND pwd = '".base64_encode($oldpasswrd)."' ");
	
	if(mysql_num_rows($check_user) >0)
	{
		$updat_arr = array("pwd" => $paswd);
		$record_updt1 = $db->recordUpdate(array("uid" => $uid),$updat_arr,LOGINTBL);

		if($record_updt1 == 1 )
		{
			
			$msg = "Password Updated Sucessfully";	
		}
	}else{
		$errmsg = "Incorrect password";	
	}
	
}


?>
<script type="application/javascript" >
function validate_form()
{

	var oldpassword = $("#oldpassword").val();
	var password = $("#password").val();
	var repassword = $("#repassword").val();
	if(oldpassword =='' || password =='' || repassword=='' )
	{
		if(oldpassword =='')
		{
			$("#oldpassword").css("border-color","red");
			$("#oldpassword").focus();
			$("#oldpassword").attr("placeholder","Enter old password");
			return false;
		}else
		{
			$("#oldpassword").css("border-color","");
		}
		if(password =='')
		{
			$("#password").css("border-color","red");
			$("#password").focus();
			$("#password").attr("placeholder","Enter password");
			return false;
		}else
		{
			$("#password").css("border-color","");
		}
		if(repassword =='')
		{
			$("#repassword").css("border-color","red");
			$("#repassword").focus();
			$("#repassword").attr("placeholder","Enter password");
			return false;
		}else if(password != repassword)
		{
			$("#repassword").css("border-color","red");
			alert('Password Do not matches');
			$("#repassword").focus();
			return false;
		}
		else
		{
			$("#repassword").css("border-color","");
		}
		
	}else
	{
		document.getElementById("quotation_form").submit();
		
	}
}
</script>
<div id="signup-form">
<!--BEGIN #subscribe-inner -->
		<div><span id="msgss" style=" font-size:12px;color:#093;"><?php if(isset($msg)){ echo $msg;} ?></span></div>
        <div id="signup-inner">
        
        	<div class="clearfix" id="header">
                <h1>Change Password </h1>
                </div>
                 <form id="quotation_form" name="quotation_form" action=""   method="post">  
                 <p>
                <label for="lname">Enter Old Password *</label>
                 <input name="oldpassword" type="password" id="oldpassword" tabindex="3" autocomplete="off" value=""  />
                </p>          
                 <p>
                <label for="lname">Password *</label>
                 <input name="password" type="password" id="password" tabindex="3" autocomplete="off" value=""  />
                </p>
                <p>
                <label for="lname">Retype Password *</label>
                 <input name="repassword" type="password" id="repassword" tabindex="3" autocomplete="off" value=""  />
                </p>
                <div><span id="errmsg" style=" font-size:12px;color:#900;"><?php if(isset($errmsg)){ echo $errmsg;} ?></span></div>
                <div style="float:right;"><span id="errmsg" style=" font-size:12px;color:#900;"><a href="index.php?page=user-dashboard">Back to dashboard</a></span></div>
              <input type="hidden" name="save" id="save" />
               <input type="button" onClick="validate_form();"  value="Sumbit"  name="save" id="save"  />
                </form>
            </div>
            </div>
        
 <!--END #signup-inner -->
</div>