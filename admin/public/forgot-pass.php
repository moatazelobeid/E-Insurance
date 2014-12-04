<?php 
error_reporting(0);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
   
   $email = $_POST['email'];
   if($email == ""){
   $msg ="*Please enter your email address";
   
   }else{
 
		$email=$_GET['email'];
		$utype='company';
		$res=mysql_fetch_assoc(mysql_query("select a.fname, a.lname, b.pwd, b.uname from ".USRTBL." as a inner join ".LOGINTBL." as b on a.id=b.uid where b.user_type='S' and a.mail_id='".$email."'"));
		$name=$res['fname'].' '.$res['lname'];
		$pwd=$res['pwd'];
		$uname=$res['uname'];
		if(!empty($res))
		{
			$pwd=base64_decode($pwd);
			//mail password to user
			$email_data=getEmailTemplate(36);
			$subject = $email_data['0'];
			$content= setMailContent(array($name, $uname, $pwd), $email_data['1']);
			sendMail($email,$subject,$content);
			$msg= 'Your password is successfully mailed to your email.';
			
		}
		else
		{
			$msg= 'This email id is not registered in this site as Super Admin.';
		}
	}
	echo $msg;
  // echo $val;
}
?>

<script type="text/javascript">
function validate2()
{
	var str = document.pwd_reset;
	var error = "";
	var flag = true;
//	var dataArray = new Array();
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var email = str.email.value;
	
	if(str.email.value == "")
	{
		//str.email.style.borderColor = "RED";
		error += "- Enter Your Email \n";
		flag = false;
	//	dataArray.push('email');
	}else if(str.email.value.search(filter) == -1)
	{
	   // str.email.style.borderColor = "RED";
		error += "- Valid Email Address Is Required  \n";
		flag = false;
	//	dataArray.push('email');
	}
	
	if(flag==true)
	{
		var url="util/utils.php?task=forgotPassword&email="+email; 
		$.post(url,function(data){ 
			alert(data);
			location.href='index.php';
		});
	}
}
</script>



<style type="text/css">
<!--
.contact-textbox {background-image: url(images/textbox1.png);
	background-repeat: no-repeat;
	background-position: left top;
	margin: 0px;
	padding: 7px;
	width: 182px;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
.contact-txt2 {font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: normal;
	color: #555454;
	text-decoration: none;
}
.style2 {font-family: Arial, Helvetica, sans-serif; font-size: 18px; font-weight: normal; color: #CCCCCC; text-decoration: none; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #d3d3d3; }
a.newlogin-txt {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #003399;
	text-decoration: none;
}
.style3 {color: #333333}
-->
</style>


<div class="innernewbox" style="padding-bottom:25px;">
  <div class="bodycontainer-box" style="margin-left:10px; margin-top:20px; ">
    <table width="350" border="0" align="center" cellpadding="5" cellspacing="0">
	<tr>
              <td align="center">&nbsp;<span style="color:#FF0000;font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal;text-decoration: none;"><?php echo $msg;?> </span></td>
            </tr>
      <tr>
        <td bgcolor="#D0D0D0"><table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td class="style2">&nbsp;<span class="style3">Forgot Password </span></td>
            </tr>
			 
            <tr>
              <td height="165" align="center" valign="middle" style="padding-top:10px;"><form id="pwd_reset" name="pwd_reset" method="post" action="">
                  <table width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
				 
                    <tr>
                      <td width="24%" align="left" valign="middle" class="contact-txt2">Email:</td>
                      <td width="76%" align="left" valign="middle"><input type="text"  id="email" name="email" placeholder="Enter your Email ID"/></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" valign="middle" class="contact-txt2"></td>
                      <td height="25" align="left" valign="middle" class="contact-txt2"><label>
                        <input type="button" id="submit" value="Submit" onclick="return validate2();" />
                      </label></td>
                    </tr>
                  </table>
              </form></td>
            </tr>
        </table></td>
      </tr>
    </table>
  </div>
</div>
