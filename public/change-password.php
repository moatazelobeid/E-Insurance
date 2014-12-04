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
	$check_user = mysql_query("select * from ".LOGINTBL." WHERE user_type ='U' and uid ='".$uid."' AND pwd = '".base64_encode($oldpasswrd)."' ");
	
	if(mysql_num_rows($check_user) >0)
	{
		$updat_arr = array("pwd" => $paswd);
		$record_updt1 = $db->recordUpdate(array("uid" => $uid),$updat_arr,LOGINTBL);

		if($record_updt1 == 1 )
		{
			
			$msg = "Password Updated Sucessfully";	
		}
	}else{
		$errmsg = '<font color="#900">Incorrect Password.!!</font>';	
	}
	
}


?>
<script type="application/javascript" >
function val_form()
{

	var oldpassword = $("#oldpassword").val();
	var password = $("#password").val();
	var repassword = $("#repassword").val();
	if(oldpassword =='' || password =='' || repassword=='' || password != repassword )
	{
		if(oldpassword =='')
		{
			$("#oldpassword").css("border-color","#900");
			$("#oldpassword").focus();
			$("#oldpassword").attr("placeholder","Enter old password");
			return false;
		}else
		{
			$("#oldpassword").css("border-color","");
		}
		if(password =='')
		{
			$("#password").css("border-color","#900");
			$("#password").focus();
			$("#password").attr("placeholder","Enter password");
			return false;
		}else
		{
			$("#password").css("border-color","");
		}
		if(repassword =='')
		{
			$("#repassword").css("border-color","#900");
			$("#repassword").focus();
			$("#repassword").attr("placeholder","Enter password");
			return false;
		}else if(password != repassword)
		{
			$("#repassword").css("border-color","#900");
			alert('Password Do not matches');
			$("#repassword").focus();
			return false;
		}
		else
		{
			$("#repassword").css("border-color","");
		}
		
	}
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
            <strong>Change Password</strong>
        </div>
        
        <?php include_once('includes/dashboard-sidebar.php'); ?>
        
        <div class="lg-6">
            <div class="rightformpan innerTFl">
                <h1>Change Password</h1>
                <p>
                    <span id="msgss" style=" font-size:12px;color:#093;"><?php if(isset($msg)){ echo $msg;}elseif(isset($errmsg)){ echo $errmsg;} ?></span>
                </p>
                
                <div class="clearfix"></div>
                
                <div class="wpcf7" id="wpcf7-f61-p12-o1">
                      <form action="" method="post"  name="forgot_frm" id="forgot_frm" class="wpcf7-form" onSubmit="return val_form();">
                        <div class="form-row">
                          <label for="your-name">Old Password<span class="required">*</span></label>
                          <br>
                          <span class="wpcf7-form-control-wrap your-name">
                            <input name="oldpassword" type="password" id="oldpassword" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required input-text" tabindex="3" autocomplete="off" value=""  />
                          </span>
                        </div>
                        <div class="form-row">
                          <label for="your-name">New Password <span class="required">*</span></label>
                          <br>
                          <span class="wpcf7-form-control-wrap your-name">
                            <input name="password" type="password" id="password" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required input-text" tabindex="3" autocomplete="off" value=""  />
                          </span>
                        </div>
                        <div class="form-row">
                          <label for="your-name">Retype Password <span class="required">*</span></label>
                          <br>
                          <span class="wpcf7-form-control-wrap your-name">
                            <input name="repassword" type="password" id="repassword" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required input-text" tabindex="3" autocomplete="off" value=""  />
                          </span>
                        </div>
                        <div class="form-row-submit">
                          <input type="submit" value="Submit" name="save" class="submitbtn1" style="float: left;">
                        </div>
                      </form>
                </div>
                <div class="clearfix" style="height:100px;">.</div>
            </div>
        </div>
    <div class="clearfix"></div>
    </div>
		<div class="clearfix" style="height:15px;">.</div>
	</div>