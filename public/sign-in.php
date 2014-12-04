<?php 

if(!empty($_GET['logoff']) && $_GET['logoff'] == 1)
{
	if(isset($_SESSION['uid']))
	{
		$todaytime = date('Y-m-d H:i:s');
		$update_login = $db->recordUpdate(array("uid" => $_SESSION['uid']),array('last_logout'=>$todaytime,'login_status'=>'0'),LOGINTBL);
		unset($_SESSION['uid']);
		unset($_SESSION['uname']);
		unset($_SESSION['uemail']);
	}
	header("location:index.php?page=sign-in&logout=1");
}

if(isset($_SESSION['uid']) && empty($_GET['logoff']))
{
	header("location:index.php?page=user-dashboard");
}

if(!empty($_GET['logout']) && $_GET['logout'] == 1)
{
	$msg ="sucessfully logged out";
}
if(isset($_POST['save']))
{

	$username= $_POST['uname'];
	$paswd = $_POST['passwrd'];
	$check_user = mysql_query("select * from ".LOGINTBL." WHERE uname ='".$username."' AND pwd = '".base64_encode($paswd)."' ");

	$check_useractive = mysql_query("select * from ".LOGINTBL." WHERE uname ='".$username."' AND pwd = '".base64_encode($paswd)."' and is_active = '1' ");
	if(mysql_num_rows($check_user) >0)
	{
		if(mysql_num_rows($check_useractive) >0)
		{
			$userlogininfo = mysql_fetch_object($check_user);
			$userinfo = mysql_fetch_object(mysql_query("select * from ".USERTBL." where id='".$userlogininfo->uid."' limit 1 "));
			$todaytime = date('Y-m-d H:i:s');
			$update_login = $db->recordUpdate(array("id" => $userlogininfo->id),array('last_login'=>$todaytime,'login_status'=>'1'),LOGINTBL);
			$_SESSION['uid'] =  $userinfo->id;
			$_SESSION['uname'] =  $userinfo->fname;
			$_SESSION['uemail'] =  $userinfo->email;
			header("location:index.php?page=user-dashboard");
		}else
		{
			$errmsg =  '<font color="#900;">You are currently Inactive</font>';
		}
	}else{
			
		$errmsg =  '<font color="#900;">Incorrect login credentials</font>';
	}
	
}


?>
<script type="application/javascript" >
function val_form()
{

	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var username = $("#uname").val();
	var passwrd = $("#passwrd").val();

		if(username =='')
		{
			$("#uname").css('border-color','#900');
			$("#uname").attr("placeholder","Enter username or email")
			$("#uname").focus();
			return false;
		}else
		{
			$("#uname").css('border-color','');
		}
		if(passwrd =='')
		{

			$("#passwrd").css('border-color','#900');
			$("#passwrd").attr("placeholder","Enter your password")
			$("#passwrd").focus();
			return false;
			
		}else
		{
			$("#passwrd").css('border-color','');
		}
	
		
}
</script>
<style type="text/css">
.innerleft ul li{margin-bottom: 0px!important;padding-left: 18px!important; background-color:transparent!important; padding-top:0px!important;line-height: 18px!important;}
</style>

<div class="innrebodypanel">
				<div class="clearfix" style="height:15px;">.</div>
				<div class="innerwrap">
				
					<div class="breadcrumb" >
						<a itemprop="url" href="<?=BASE_URL?>">Home</a> 
						<span class="breeadset">&#8250;</span>
						<strong>Sign In </strong>
					</div>
					
					<div class="lg-3">
						<div class="normallist1 innerleft listnew">
							<h1>Members Benefits</h1>
							<ul>
                            	<li style="padding: 0!important; background:none!important;">
                                    <ul>
                                        <li>Edit & update your contact</li>
                                        <li>Lorem Lorem Ipsum</li>
                                        <li>Retrieve stored insurance quotes</li>
                                        <li>Lorem Lorem Ipsum Lorem Ipsum</li>
                                        <li>Refresh quotes without filling forms</li>
                                    </ul>
                                    <br />
                                	<!--<a href="signup"><input type="submit" value="Sign Up" class="submitbtn1"></a>-->
                                </li>
							</ul>
						</div>
						
					</div>
					
					<div class="lg-6">
						<div class="rightformpan innerTFl">
                        	<h1>Sign In</h1>
                            <p><?php if(isset($errmsg)){ echo $errmsg;} ?></p>
                            
                            <div class="clearfix"></div>
                            
                            <div class="wpcf7" id="wpcf7-f61-p12-o1" style="border: 1px solid #CACACA;padding: 1em 1.5em;">
                                  <form action="" method="post"  name="signin_frm" id="signin_frm" class="wpcf7-form" onSubmit="return val_form();">
                                    <div class="form-row">
                                      <label for="your-name">Email id <span class="required">*</span></label>
                                      <br>
                                      <span class="wpcf7-form-control-wrap your-name">
                                      <input type="text" name="uname" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required input-text" id="uname" aria-required="true">
                                      </span>
                                    </div>
                                    <div class="form-row">
                                      <label for="your-email">Password <span class="required">*</span></label>
                                      <br>
                                      <span class="wpcf7-form-control-wrap your-email">
                                      <input name="passwrd" type="password" id="passwrd" autocomplete="off" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text"  aria-required="true"  style="width: 98.4%;">
                                      </span>
                                    </div>
                                    
                                    <div class="form-row-submit">
                                      <input type="submit" name="save" value="Sign In"  class="submitbtn1" style="float: left;">
                                      <a href="index.php?page=forgot-password" class="forgot">Forgot Password?</a>
                                    </div>
                                  </form>
                            </div>
                            <div class="clearfix" style="height:100px;">.</div>
                        </div>
					</div>
                    
                    
				
				<div class="clearfix"></div>
				</div>
				<div class="clearfix" style="height: 15px;"></div>
		</div>