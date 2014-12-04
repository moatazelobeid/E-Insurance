<?php
// includes
include_once("config/session.php");
include_once("config/config.php");
include_once("config/tables.php");
include_once("config/functions.php");

// class involved
include_once("library/core/dbFactory.php");
include_once("library/core/mailFactory.php");
include_once("library/core/signup.class.php");
$signup = new signup();
//echo base64_encode('1hHdOvC4etKfCPsj98T8')."<br/>";
//echo base64_encode('11');
// check login

if(isset($_POST['signup']))
{
    $sig = $signup->signup_1();
	if($sig == '1')
	{
	  $msg = "A Verification Link is sent to your Email Address.";
	}
	else if($sig == '2')
	{
	 $msg = "Registration Successfull, but Mail Sending Failed..!!";
	}else if ($sig == '3') // if company is not registered in ollys pages. still send a message.
	{
	   //$msg = "Sorry..!! We are not serving your company at this time. We will inform you when we start servicing your company.";
	   $msg = "A Verification Link is sent to your Email Address.";
	}else if($sig == '4')
	{
	  $msg = "Sorry..!! E-mail Already Address Exists. Try Another.";
	}
	 
}
if(isset($_POST['submit_step_2']))
{
  $sig2 = $signup->signup_2(array('id' => base64_decode($_GET['USER']))); // for second phase registration..
  if($sig2 == '1')
  {
  header("Location:".BASE_URL."signup.php?phase=phase_three&emp_id=".$_GET['USER']."&st=3");
  }

}
if(isset($_POST['submit_step_3'])) // for 3rd phase registration..
{
    if($_POST['s1'] == '0')
	{
	  $signup_fail = $signup->signup_failed(base64_decode($_GET['emp_id']));
	  $ssw=mysql_query("DELETE FROM me_employee WHERE id='".base64_decode($_GET['emp_id'])."' AND company_id='0'");
	 header("Location:".BASE_URL."signup.php?phase=phase_four&emp_id=".$_GET['emp_id']."&st=4&sts=failed");
	}
	else if($_POST['s1'] == 'a')
	{
	 header("Location:".BASE_URL."index.php?page=empaccount");
	}
	else if($_POST['s1']!= 'a' && $_GET['email'] != '')
	{
	  $comp_id = $_POST['s1'];
	  $cng_com=$signup->company_changed($_GET['email']);
	  $ssw=mysql_query("UPDATE me_employee SET emp_email ='".$_GET['email']."',company_id='$comp_id' WHERE id=".base64_decode($_GET['emp_id']));
	 $_SESSION['uid'] = base64_decode($_GET['emp_id']);
	   header("Location:".BASE_URL."index.php?page=empaccount&sts=changed");
	}
	else if($_POST['s1'] != '0' && $_POST['s1'] != '')
	{
	    $employee_id = base64_decode($_GET['emp_id']);
		$unique_emp_id = ucodeGenEmp(EMPLOYEETBL,'emp_id','id','91','7');
	    $comp_id = $_POST['s1'];
	    $sig3 = $signup->signup_3(array('id' => $employee_id),$unique_emp_id,$comp_id);
       if($sig3 == '1')
       {
	    $_SESSION['uid'] = base64_decode($_GET['emp_id']);
        header("Location:".BASE_URL."index.php?REG=".base64_encode('successful')."&emp_id=".$_GET['emp_id']."&sts=ok");
       }else{
	    $msg3 = "Record Can't be update at this time..";
		 //$msg3 = $sig3;
	   }

	}else if($_POST['s1'] == '')
	{
	  $msg3 = "Please Select Your Company Location";
	}
   
}
if(isset($_POST['submit_step_4']))
{
   header("Location:".BASE_URL."index.php");
}
/*// check page status
if(siteAuth('E') == 1){
header("location:useraccount.php");
}*/
echo get_header();
?>
<style>
.errorxx{
background-color: #FFFFFF;
    border-color: #CCCCCC;
    border-radius: 6px 6px 6px 6px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 0 5px #AAAAAA;
    color: #FF0000;
    float: left;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    margin: 0 auto;
    padding: 8px;
    text-align: center;
    width: 352px;
}
</style>

<link href="<?php echo BASE_URL;?>css/framework.css" rel="stylesheet" type="text/css" media="screen" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/jquery.js"></script>
<script src="<?php echo BASE_URL;?>js/custom-form-elements.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo BASE_URL;?>js/curvycorners.src.js" type="text/javascript" ></script><link rel="stylesheet" href="css/form.css" type="text/css" media="screen">
<script type="text/javascript">
function check_signup()
{
 var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
 if((document.getElementById("emp_uname1").value == 'Your name') || (document.getElementById("emp_uname1").value == ''))
 {
   document.getElementById("signup_error").style.display = 'inline';
   document.getElementById("errorbox").innerHTML = 'Enter Your User Name';
   document.getElementById("emp_uname1").focus();
   return false;
 }
 else if(document.getElementById("emp_email").value == 'Company email Address' || document.getElementById("emp_email").value == '')
 {
   document.getElementById("signup_error").style.display = 'inline';
   document.getElementById("errorbox").innerHTML = 'Enter Your Company email Address';
   document.getElementById("emp_email").focus();
   return false;
 }else if(reg.test(document.getElementById("emp_email").value) == false) 
 {
   document.getElementById("signup_error").style.display = 'inline';
   document.getElementById("errorbox").innerHTML = 'Enter Your Valid Company email Address';
   document.getElementById("emp_email").focus();
   return false;
 }
 else if(document.getElementById("term_checkbox").checked == false)
 {
   
   document.getElementById("signup_error").style.display = 'inline';
   document.getElementById("errorbox").innerHTML = "You have to agree with the Olly's Pages Terms of Service";
   return false;
 }
 else
 {
   return true;
 }
}

function check_email_exists(email)
{
if(email != '' && email != 'Company email Address')
{
alert("hello");
	var xx;
	$.ajax({  
		type: "POST",  
		url: "util/check_emp_email.php",  
		data: "email=" + email,
		success: function(msg){  
		$("#errorbox").ajaxComplete(function(event, request, settings){ 
									
		if(msg == 'OK'){
			xx = 1;
		} 
		else if(msg == 'ERROR'){ 
	     document.getElementById("signup_error").style.display = 'inline';
         document.getElementById("errorbox").innerHTML = 'Email Address Already Exists. Please Try Another.';
         document.getElementById("emp_email").focus();
         return false;
		}
		  if(msg == 'INVALID'){ 
			document.getElementById("signup_error").style.display = 'inline';
            document.getElementById("errorbox").innerHTML = 'Email Address Already Exists. Please Try Another.';
            document.getElementById("emp_email").focus();
            return false;
		  }
		 });
		} 
	   });
}
}
function signup_step2()
{
 if((document.getElementById("emp_fname").value == ''))
 {
   document.getElementById("signup_error2").style.display = 'inline';
   document.getElementById("errorbox2").innerHTML = 'Enter Your First Name';
   document.getElementById("emp_fname").focus();
   return false;
 }
 else if(document.getElementById("emp_lname").value == '')
 {
   document.getElementById("signup_error2").style.display = 'inline';
   document.getElementById("errorbox2").innerHTML = 'Enter Your Last Name';
   document.getElementById("emp_lname").focus();
   return false;
 }
 else if(document.getElementById("emp_uname").value == '')
 {
   document.getElementById("signup_error2").style.display = 'inline';
   document.getElementById("errorbox2").innerHTML = "Enter Your User Name";
   document.getElementById("emp_uname").focus();
   return false;
 }else if(document.getElementById("emp_pwd").value == '')
 {
	document.getElementById("signup_error2").style.display = 'inline';
    document.getElementById("errorbox2").innerHTML = "Enter Password";
	document.getElementById("emp_pwd").focus();
    return false;
 }
 else if(document.getElementById("emp_repwd").value == '')
 {
	document.getElementById("signup_error2").style.display = 'inline';
    document.getElementById("errorbox2").innerHTML = "Enter Retype Password";
	document.getElementById("emp_repwd").focus();
    return false;
 }else if (document.getElementById("emp_pwd").value != document.getElementById("emp_repwd").value)
 {
 
    document.getElementById("signup_error2").style.display = 'inline';
    document.getElementById("errorbox2").innerHTML = "Password Mismatch!!";
	document.getElementById("emp_pwd").value = '';
	document.getElementById("emp_repwd").value = '';
	document.getElementById("emp_pwd").focus();
    return false;
	}
    else
    {
      return true;
    }
}
<?php
	  if($_GET['phase']=="phase_three" && $_GET['emp_id']!="" && $_GET['st']=="3" && $_GET['email']!="")
	  { ?>
	 function check()
	 {
	 var radio_choice = false;
	for (counter = 0; counter < document.signup_form.s1.length; counter++)
   {
	 if (document.signup_form.s1[counter].checked)
		 {
			   radio_choice = true; 
		}
    }
	  if (!radio_choice)
	   {
		   alert("Please select a company branch.")
		  return (false);
	   }
		if(document.getElementById("no_branch").checked == true)
	{
	   alert('Sorry, We are not serving your company');
	   return false;
	}
}	
	<?php }?>
</script>
<link rel="stylesheet" href="<?php echo BASE_URL;?>css/form.css" type="text/css" media="screen">
</head>
<body  style="background-image:none;">
<div id="bggraphic1">
  <div id="loginbox">
    <div class="loginbox-inner" style="padding-bottom:20px;"><a href="index.php"><img src="images/logo.png" width="119" height="50" border="0" /></a></div>
    <div class="loginbox-inner">
    
    <div id="loginboxcontent">
	<?php 
if($_GET['st'] == '1' && $_GET['acode'] != "" && $_GET['USER'] != '')
{
	$phase = 1;
	// check activation code
	$sq = "SELECT COUNT(*) AS records,id FROM ".EMPLOYEETBL." WHERE unique_gen_code = '".base64_decode($_GET['acode'])."' AND id = '".base64_decode($_GET['USER'])."'";
	$res = mysql_query($sq);
	$rs = mysql_fetch_object($res);
	if($rs->records > 0)
	{
		// correct activation code
		// set user status to 1
		$rid = $rs->id;
		//$query = "UPDATE ".EMPLOYEETBL." SET emp_status = '1' WHERE id = '".$rid."'";
		//mysql_query($query);
		$phase = 2;
	}
	else
	{
		$msg = "Wrong Activation Link!Try Again.";
		$phase = 1;
	}
	
}else if($_GET['phase'] == 'phase_three' && $_GET['st'] == '3'){
$phase = 3;
}
else if($_GET['phase'] == 'phase_four' && $_GET['st'] == '4'){
$phase = 4;
}else{
$phase = 1;
}
?>
    <form id="signup_form" name="signup_form" method="post" action="" style="padding:0px; margin:0px;">
	<?php if($st == '' && $st != '1' && $phase == '1' && $acode == ''){?>
         <div class="loginbox-mid1">
           <div class="login-mid1inner">
             <h6 class="org18">Sign up for an Olly's Pages account </h6>
           </div>
           <div class="login-mid1inner" style="margin-top:12px;"><h6  class="signuptext1">Please sign up if you have been told about Olly's pages by your company. Sorry, we dont allow walk up sign ups at this time. </h6>          </div>
		   
            <div class="login-mid1inner" id="signup_error" style="margin-top:14px;display:<?php if($msg != ''){echo "inline";}else{echo "none";}?>;">
             <div id="errorbox"><?php echo $msg; ?></div>
           </div>
		   
           <div class="login-mid1inner">
             <input name="emp_uname1" id="emp_uname1" type="text" class="logintextbox" value="Your name" onFocus="if(this.value == 'Your name'){this.value = '';document.getElementById('emp_uname1').style.border = '1px solid #4D90FE';}" onBlur="if(this.value == ''){this.value = 'Your name';document.getElementById('emp_uname1').style.borderColor = '';}else if(this.value != 'Your name'){document.getElementById('emp_uname1').style.borderColor = '';}"  />
          </div>
           <div class="login-mid1inner">
             <input name="emp_email" id="emp_email" type="text" class="logintextbox" value="Company email Address" onFocus="if(this.value == 'Company email Address'){this.value = '';document.getElementById('emp_email').style.border = '1px solid #4D90FE';}" onBlur="if(this.value == ''){this.value = 'Company email Address';document.getElementById('emp_email').style.borderColor = '';}else if(this.value != 'Company email Address'){document.getElementById('emp_email').style.borderColor = '';}"/>
        </div>
           
          <div class="login-mid1inner">
          <div class="loginbox1">
             <div class="formsmall-box" style="padding-right:0px; padding-left:2px;"> <input type="checkbox" class="styled" id="term_checkbox" name="term_checkbox"/></div>
            <div class="formsmall-box" style="padding-top:2px; padding-right:4px;"> <h6 class="signuptext1">I agree with the Olly's pages</h6> </div> 
            <div class="formsmall-box" style="padding-top:2px;"><a href="#" class="txt1">terms of service.</a></div>
            </div>
          </div>
           
           <div class="login-mid1inner">
             <div class="loginbox1" style="float:left">
             <div class="formsmall-box"> <input name="signup" type="submit" id="bigbutton" value="Sign up" onClick="return check_signup();"/>
             </div>
             <div class="formsmall-box"> <input name="input" type="reset" id="bigbutton1" value="Cancel" onClick="document.location='index.php'" /></div>
             </div>
           </div>
           
          </div>
		  
		  <?php } if($_GET['acode'] != '' && $_GET['st'] == '1' && $phase = '2'){?>
		  <div class="loginbox-mid1">
           <div class="login-mid1inner">
             <h6 class="org18">Congratulations!</h6>
           </div>
           <div class="login-mid1inner" style="margin-top:8px; margin-bottom:14px;"><h6  class="signuptext1">You are almost done. Just one more step...</h6>          </div>
		   
		   <div class="login-mid1inner" id="signup_error2" style="margin-top:14px;display:<?php if($msg1 != ''){echo "inline";}else{echo "none";}?>;">
             <div id="errorbox2" class="errorxx"><?php echo $msg1; ?></div>
           </div>
		   
           
           <div class="login-mid1inner" style="margin-bottom:8px;padding-top:20px;">
           <lable>First name</lable>
             <input name="emp_fname" id="emp_fname" type="text" class="s1" onFocus="document.getElementById('emp_fname').style.border = '1px solid #4D90FE'" onBlur="document.getElementById('emp_fname').style.borderColor = ''"/>
         
           </div>
           <div class="login-mid1inner" style="margin-bottom:8px;"> 
           <lable>Last name</lable>
           <input name="emp_lname" id="emp_lname" type="text" class="s1" onFocus="document.getElementById('emp_lname').style.border = '1px solid #4D90FE'" onBlur="document.getElementById('emp_lname').style.borderColor = ''" />
           </div>
           
            <div class="login-mid1inner" style="margin-bottom:8px;"> 
                  <lable>User name</lable>
            <input name="emp_uname" id="emp_uname" type="text" class="s1" onFocus="document.getElementById('emp_uname').style.border = '1px solid #4D90FE'" onBlur="document.getElementById('emp_uname').style.borderColor = ''"/>
               
           </div>
           
           <div class="login-mid1inner" style="margin-bottom:8px;"> 
            <lable>Password</lable>
              <input name="emp_pwd" id="emp_pwd" type="password" class="s1"  onFocus="document.getElementById('emp_pwd').style.border = '1px solid #4D90FE'" onBlur="document.getElementById('emp_pwd').style.borderColor = ''"/>
              
           </div>
           
            <div class="login-mid1inner" style="margin-bottom:8px;"> 
              <lable>Retype password</lable>
               <input name="emp_repwd" id="emp_repwd" type="password" class="s1" onFocus="document.getElementById('emp_repwd').style.border = '1px solid #4D90FE'" onBlur="document.getElementById('emp_repwd').style.borderColor = ''"/>
                
           </div>
           
            <div class="login-mid1inner">
             <div class="loginbox1" style="float:left; margin-left:45px;">
         <input name="submit_step_2" type="submit" id="bigbutton" value="Complete registration" onClick="return signup_step2();" />
          
             </div>
           </div>
           
          </div>
		  <?php }else if($phase = '3' && $_GET['phase'] == 'phase_three' && $_GET['st'] == '3'){
		 // echo base64_decode($_GET['emp_id']);
		        // getting the company locations from database..
				//Change company branch name after login
				if($_GET['phase'] == 'phase_three' && $_GET['st'] == '3' && $_GET['email']!=''){
				$sqlQuery = $signup->getCngeComnyLocton($_GET['email']);
				}else{
				$sqlQuery = $signup->getCompanyLoocaton(base64_decode($_GET['emp_id']));
				}
				if($sqlQuery == 0)
				{
				  $msg = "";
				  $ss = 0;
				}
				else{
				   $ss = 1;
				}
				
		 //echo $sqlQuery; 
		 //echo base64_decode($_GET['emp_id']); ?>
		  <div class="loginbox-mid1">
           <div class="login-mid1inner">
             <h6 class="org18">Select Your Company Location</h6>
           </div>
		   <div class="login-mid1inner" id="signup_error" style="margin-top:14px;display:<?php if($msg3 != ''){echo "inline";}else{echo "none";}?>;">
             <div id="errorbox2" class="errorxx"><?php echo $msg3; ?></div>
           </div>
		   <?php if($ss == 1)
		         {
				 
				// echo mysql_num_rows($sqlQuery);
				 $x=1;
				while($arr = mysql_fetch_array($sqlQuery))
				 { ?>
				 <div class="login-mid1inner">
                 <div class="signuptext2" style="color:#000000; padding-top:18px;">
                 <div class="formsmall-box1" > 
                 <input type="radio" class="styled" name="s1" value="<?php echo $arr['id'];?>"/></div>
                 <div class="formsmall-box" style="padding-top:2px; padding-left:8px;">  
                 <?php
				       $state_fetch = dbFactory::recordFetch($arr['id'],'states:state_id');
				 $address = $arr['c_address1']." ".$arr['c_address2'].", ".$arr['city_id'].", ".$state_fetch['state_name']." ".$arr['c_zip'];
				 echo wordwrap($address,50,"<br/>",true);
				 ?>
				 
				 </div>
                 </div>
                 </div>
		   <?php $x++;}}?>
       
           
           <div class="login-mid1inner">
           <div class="signuptext2" style="color:#000000; padding-top:12px;">
           <div class="formsmall-box1"> 
           <input name="s1" id="no_branch" type="radio" class="styled" value="<?php if($_GET['st'] == '3' && $_GET['email']!=''){echo "a";}else{echo "0";}?>"/></div>
          <div class="formsmall-box" style="padding-top:2px;padding-left:8px;">  
            My location is not listed here</div>
            </div>
           </div>
		   
           <div class="login-mid1inner" style="float:left">
             <div class="loginbox1" style="float:left; margin-left:32px">
          <input name="submit_step_3" type="submit" id="bigbutton" value="Continue" onClick="return check();" />
             </div>
           </div>
           
          </div>
		  <?php }else if($_GET['phase'] == 'phase_four' && $_GET['st'] == '4' && $_GET['sts'] == 'failed' && $phase = 4){?>
		   <div class="loginbox-mid1">
           <div class="login-mid1inner" style=" padding-left:4px;">
           <h6 class="org18">Sorry!</h6>
           </div>
           <div class="login-mid1inner" style="margin-top:10px; margin-bottom:34px; padding-left:4px;"><h6  class="signuptext1">We are not serving your company at this time. We will
inform you when we start servicing your company.</h6>          </div>
           <div class="login-mid1inner" >
           <input name="submit_step_4" type="submit" id="bigbutton" value="Continue" />
		   </div>
           </div>
		   <?php }?>
</form>
    </div>
   
   
    </div>
    
    <div class="loginbox-inner" style="padding-top:4px;"><div align="center" style="margin:0 auto; padding-top:13px; padding-bottom:7px;"><a href="index.php?page=terms-of-service" id="footerlinkstext1">Terms of Service </a> | <a href="privacy-policy" id="footerlinkstext1"> Privacy Policy </a> | <a href="vendor-login.php" id="footerlinkstext1">Vendors</a> | <a href="index.php?page=contact-us" id="footerlinkstext1">Contact</a></div></div>
    <div id="copyright1" align="center"><?php echo $config['copyright']; ?></div>
  </div>
</div>
</body>
</html>