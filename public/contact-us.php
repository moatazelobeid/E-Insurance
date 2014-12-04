<?php
if(isset($_POST['save'])){
$msg =  '<font color="green">Contact details was sent successfully. Thanks.</font>';
$name = stripslashes($_POST['name']);	
$email = stripslashes($_POST['email']);	
$subject = stripslashes($_POST['subject']);
$message = stripslashes($_POST['message']);
$mobile = stripslashes($_POST['mobile']);
	
//mysql_query("INSERT INTO ".CONTACT." (name,email,subject,message,create_date) VALUES('".$name."','".$email."','".$subject."','".$message."','".date("Y-m-d")."')");if(mysql_affected_rows() > 0){


	
  $to="maasbeta1@gmail.com";  
  $from = "info@maasinfotech.com";
  $headers_user  = 'MIME-Version: 1.0' . "\r\n";
  $headers_user .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers_user .="From: ".$from;
  $subject_user = "A New Customer Contacted you";
  $message_user= '<table width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr><td colspan="2">A new Customer Contacted you.<br/><br/>Check detais below:<br/></td></tr>
   <tr><td align="right"><strong>Subject:</strong></td><td align="left">'.$subject.'</td></tr>
  <tr><td align="right"><strong>Name:</strong></td><td align="left">'.$name.'</td></tr>
  <tr><td align="right"><strong>Email:</strong></td><td align="left">'.$email.'</td></tr>
  <tr><td align="right"><strong>Mobile #:</strong></td><td align="left">'.$mobile.'</td></tr>
  <tr><td align="right" valign="top"><strong>Message:</strong></td><td align="left">'.$message.'</td></tr>
  </table>';
  mail($to,$subject_user,$message_user,$headers_user);
	
	
}
/*else
{
	$msg = 'Contact Details Sent Unsuccessfull. Please Try Again.!!';
}*/

?>
<script type="text/javascript">

function valForm()
{
   var name=$("#name").val();
	var email=$("#email").val();
	var subject=$("#subject").val();
	var mobile=$("#mobile").val();
	var message=$("#message").val();
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var security = $("#security").val();
	if(name==''|| (email=='' || !filter.test(email)) || subject=='' || message=='')
	{
		if(name=='')
		{
		$("#name").focus();
		$("#name").attr('placeholder','Enter Your Name');
		$("#fname").html("gdgfg");
		$("#name").css("border-color", "#B98133");
		return false;
		}
		else
		{
		$("#name").css("border-color", "");
		}
			
		if(email=='')
		{
			$("#email").focus();
			$("#email").attr('placeholder','Enter Your Email');
			
			$("#email").css("border-color", "#B98133");
			return false;
		}
		else if(!filter.test(email))
		{
			$("#email").focus();
			$("#email").attr('placeholder','Enter Your Valid Email');
			$("#email").css("border-color", "#B98133");
			return false;
		}
		else
		{

			$("#email").css("border-color", "");
		}
	 if(subject=='')
	{
		$("#subject").css("border-color","#B98133");
		$("#subject").focus();
		//alert("Enter  Subject");
		$("#error_div").html("Enter  Subject");
		
		return false;
	}
	else
	{
		$("#subject").css("border-color","");
		$("#error_div").html("");
	}
	if(mobile=='')
	{
		$("#mobile").css("border-color","#B98133");
		$("#mobile").focus();
		//alert("Enter  Subject");
		$("#mobile").attr('placeholder','Enter  Mobile No');
		$("#error_div").html("Enter  Mobile No");
		
		return false;
	}
	else
	{
		$("#subject").css("border-color","");
		$("#error_div").html("");
	}
	if(message=='')
	{
		$("#message").css("border-color","#B98133");
		$("#message").focus();
		//alert("Write  message");
		$("#error_div").html("Enter  Message");
		
		return false;
	}
	else
	{
		$("#message").css("border-color","");
		$("#error_div").html("");
	}
}
}
$(function() {
    setTimeout(function() {
        $("#error_div").fadeOut('slow');
}, 3000);
});
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
                <a itemprop="url" href="<?php echo BASE_URL;?>">Home</a> 
                <span class="breeadset">&#8250;</span>
                <strong>Contact </strong>
            </div>
            
            <div class="lg-3" style="width: 31%;">
                <div class="normallist1 innerleft">
                    <h1>Head Office</h1>
                    <ul>
                        <li style="background: #fff;">
                            <span class="CTNtitle">Office Location: </span>
                            <p>Al Sagr Cooperative insurance company<br />
                              (60th) sitteen street malaz, platinum center<br />
                              suite no. 501, 5th floor, near gulf bridge<br />
                              Riyadh 11312 - P.O. Box: 94<br />
                              Saudi Arabia<br />
                              Tel: 00966 1 4752233
                              <br />
                            </p>
                            
                            
                            <div class="clearfix" style="height:15px;"></div>
                            <span class="CTNtitle">Email :</span>
                            <p><a href="mailto:customer@alsagr.com">customer@alsagr.com</a></p>
                            
                            
                            
                            <div class="clearfix" style="height:15px;"></div>
                            <span class="CTNtitle">Alternate Number  :</span>
                            <p>92 000 1043</p>
                            
                            
                            <div class="clearfix" style="height:15px;"></div>
                            <span class="CTNtitle">Fax :</span>
                            <p>00966 1 4752255</p>
                        </li>
                    </ul>
                </div>
                
            </div>
            
            <div class="lg-6" style="width: 66%;">
                <div class="rightformpan innerTFl">
                    <h1>Contact us</h1>
                    <p>
                        Kindly use the form given below to send us your suggestions, complaints or questions and we will revert back to you at the earliest.
                    </p>
                    
                    <div class="clearfix"></div>
                  <?php if($msg) {?><div id="error_div" style="color: #FFFFFF;font-size: 12px;line-height: 18px;">
                        <?php echo $msg;?></div> <?php } ?>
                    <div class="wpcf7" id="wpcf7-f61-p12-o1"  style="border: 1px solid #CACACA;padding: 1em 1.5em; width: 75%;">
                         <form action="" method="post" id="sky-form" novalidate="novalidate" onsubmit="return valForm();" class="wpcf7-form">
                         
                         	<div class="form-row">
                              <label for="your-subject">Subject <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-subject">
                              <select name="subject" id="subject" class="dropdown">
											<option value="Suggestions">Suggestions</option>
                                            <option value="Complaints">Complaints</option>
                                            <option value="Questions">Questions</option>
                                            <option value="Comments">Comments</option>
                                    </select>
                              </span>
                            </div>
                            <div class="form-row">
                              
                              <label for="your-name">Name <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-name">
                              <input type="text" name="name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required input-text" id="name" aria-required="true">
                              </span>
                            </div>
                            <div class="form-row">
                              <label for="your-email">Email Id <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input type="email" name="email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text" id="email" aria-required="true" style="width: 98.5%;">
                              </span>
                            </div>
                            <div class="form-row">
                              <label for="your-email">Mobile # <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-email">
                              <input type="text" name="mobile" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email input-text" id="mobile" aria-required="true" style="width: 98.5%;">
                              </span>
                            </div>
                            <?php /*?><div class="form-row">
                              <label for="your-subject">Subject <span class="required">*</span></label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-subject">
                              <input type="text" name="subject" value="" size="40" class="wpcf7-form-control wpcf7-text input-text" id="subject">
                              </span>
                            </div><?php */?>
                            <div class="form-row">
                              <label for="your-message">Your Message</label>
                              <br>
                              <span class="wpcf7-form-control-wrap your-message">
                              <textarea name="message"  class="wpcf7-form-control wpcf7-textarea input-textarea" id="message" style="width: 98.5%;"></textarea>
                              </span>
                            </div>
                            <div class="form-row-submit">
                              <input type="submit" value="Submit" class="submitbtn1" name="save" id="save" style="display: inline-block;">
                            </div>
                          </form>
                    </div>
                    
                </div>
            </div>
        
        <div class="clearfix"></div>
        </div>
        <div class="clearfix" style="height:15px;">.</div>
</div>