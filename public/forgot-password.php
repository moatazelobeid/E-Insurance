    <?php
if(isset($_POST['send']))
{

	$email=$_POST['email_id'];
	
	$login= mysql_query("SELECT * FROM ksa_user WHERE email='$email'");
	$rows=mysql_fetch_array($login);
	if(mysql_num_rows($login)!=0)
	{
		
		$email= $rows['mail_id'];
		$adminuid = $rows['id'];
$adminps= mysql_query("SELECT * FROM ksa_login WHERE uid='$adminuid' and user_type ='U'");
	
	$adminrows=mysql_fetch_array($adminps);		
		$upw1 = $adminrows['pwd'];
		$password = base64_decode($upw1);
		$to= $_POST['email_id']; 
		$email= $_POST['email_id']; 
		$subject_user = "Password Details Request";
		$from = 'Al sagr Cooperative';
		$headers_user  = 'MIME-Version: 1.0' . "\r\n";
  $headers_user .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers_user .="From: ".$from;
  		$message_user= '<table width="100%" cellpadding="3" cellspacing="3">
  <tr><td colspan="2">Your have requested for Your Login details.<br/><br/>Check details below:<br/></td></tr>

  <tr><td  align="left"><strong>Email:</strong></td><td align="left">'.$_POST['email_id'].'</td></tr>
  <tr><td align="left" valign="top"><strong>Password:</strong></td><td align="left">"'.$password.'"</td></tr>
 
  </table>';

 		$sentmail = mail($to,$subject_user,$message_user,$headers_user);
		if($sentmail)
		{
			
			$allmsg =  '<font color="#66FF66">Your password was sent to your email..</font>';
		}else
		{
			$allmsg =  '<font color="#66FF66">Password sending failed</font>';
		}
	}
	else
	{
		$allmsg = '<font color="#900">You have entered wrong Email Id. Please Try Again.!!</font>';
	}
}
?>	
<script type="application/javascript" >
function val_form()
{

	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var username = $("#email_id").val();

		if(username =='')
		{
			$("#email_id").css('border-color','#900');
			$("#email_id").attr("placeholder","Enter your email")
			$("#email_id").focus();
			return false;
		}else
		{
			$("#email_id").css('border-color','');
		}
	
		
}
</script>
<div class="innrebodypanel">
				<div class="clearfix" style="height:15px;">.</div>
				<div class="innerwrap">
				
					<div class="breadcrumb" >
						<a itemprop="url" href="<?=BASE_URL?>">Home</a> 
						<span class="breeadset">&#8250;</span>
						<a itemprop="url" href="index.php?page=sign-in">Sign In</a> 
						<span class="breeadset">&#8250;</span>
						<strong>Forgot Password</strong>
					</div>
					
					<div class="lg-3">
						<div class="normallist1 innerleft">
							<h1>Members Benefits</h1>
							<ul>
                            	<li>
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
                        	<h1>Forgot Password</h1>
                            <p>
                            	<?php if(isset($allmsg)){ echo $allmsg;} ?>
                            </p>
                            
                            <div class="clearfix"></div>
                            
                            <div class="wpcf7" id="wpcf7-f61-p12-o1">
                                  <form action="" method="post"  name="forgot_frm" id="forgot_frm" class="wpcf7-form" onSubmit="return val_form();">
                                    <div class="form-row">
                                      <label for="your-name">Email id <span class="required">*</span></label>
                                      <br>
                                      <span class="wpcf7-form-control-wrap your-name">
                                      <input type="text" name="email_id" value="<?=$_POST['email_id']?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required input-text" id="email_id" aria-required="true">
                                      </span>
                                    </div>
                                    
                                    <div class="form-row-submit">
                                      <input type="submit" value="Submit" name="send" class="submitbtn1" style="float: left;">
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