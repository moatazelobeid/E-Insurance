<?php
// create user


// update user information
if(isset($_POST['update']))
{
	//$datas = $_POST;
	if($_GET['id']!=""){
	   // post params
	  
		$username=$_POST['uname'];
		$password=base64_encode($_POST['pwd']);
		
		unset($_POST['uname']);
		unset($_POST['pwd']);
		unset($_POST['update']);
		unset($_POST['cust_id']);
		$id=$_GET['id'];
	
		
		$cus_details=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid=".$id." and user_type='U'"));
		
		 $unamecheck=mysql_query("select uname from ".LOGINTBL." where uname='$username'");
		 $unameres=mysql_fetch_array($unamecheck);
		 $checkuname=$unameres['uname'];
		 
			$resultqsss = $db->recordUpdate(array("uid" => $id, "user_type" => 'U'),array("uname"=>$username,"pwd"=>$password),LOGINTBL);
		
		$resultq=$db->recordUpdate(array("id" => $id),$_POST,USERTBL);
	  
	
		if($resultqsss)
		{
			//mail to admin on username or password change
			$to = $_POST['email'];
			$email_data=getEmailTemplate(9);
			$subject = $email_data['0'];
			$message= setMailContent(array($_POST['fname'], $username, base64_decode($password)), $email_data['1']);// send mail
			if($unamechange=='1' || $pwdchange=='1')
				sendMail($to,$subject,$message);
		
		
			header('location:account.php?page=user_list');
		}else{
			$msg="Your Record Updation failed";
		}
	
	
	}



}
//redirectuser();
if($_GET['id'] != "")
{
		$user  = mysql_fetch_array(mysql_query("SELECT a.id as 'id',a.fname as 'fname',a.lname as 'lname',a.cust_id as 'cust_id',b.ag_fname as 'ag_fname',b.ag_lname as 'ag_lname',b.ag_code as 'ag_code',a.phone1 as 'phone1',a.email as 'email',a.created_date as 'created_date',c.is_active as 'is_active',c.uname as 'uname',c.pwd as 'pwd' FROM ".USERTBL." a,".AGENTTBL." b,".LOGINTBL." c where a.id=c.uid and c.user_type='U' and a.id=".$id));
	
	//echo "SELECT a.id as 'id',a.fname as 'fname',a.lname as 'lname',a.cust_id as 'cust_id',b.ag_fname as 'ag_fname',b.ag_lname as 'ag_lname',b.ag_code as 'ag_code',a.phone1 as 'phone1',a.email as 'email',a.created_date as 'created_date',c.is_active as 'is_active',c.uname as 'uname',c.pwd as 'pwd' FROM ".USERTBL." a,".AGENTTBL." b,".LOGINTBL." c where a.agent_id=b.id and a.id=c.uid and c.user_type='U' and a.id=".$id;	
}

?>
<script type="text/javascript">
function validateManager()
{
	var str = document.p_fr;
	var error = "";
	var flag = true;
	//var dataArray = new Array();
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	if(str.ag_code.value == "")
	{
		str.ag_code.style.borderColor = "RED";
	error += "-Enter Agent Id \n";
		flag = false;
	     //dataArray.push('ag_id');
	}
	else
	{
		str.ag_code.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	if(str.fname.value == "")
	{
		str.fname.style.borderColor = "RED";
		error += "- Enter First Name \n";
		flag = false;
		//dataArray.push('fname');
	}
	else
	{
		str.fname.style.borderColor = "";
	    //flag = true;
		//dataArray.pop();
	}
	if(str.lname.value == "")
	{
		str.lname.style.borderColor = "RED";
		error += "- Enter Last Name \n";
		flag = false;
		//dataArray.push('lname');
	}
	else
	{
	 	str.lname.style.borderColor = "";
	    //flag = true;
		//dataArray.pop();
	}
	
	if(str.email.value == "")
	{
		str.email.style.borderColor = "RED";
		error += "- Enter Email Address \n";
		flag = false;
		//dataArray.push('email');
	}
	else
	 if(str.email.value.search(filter) == -1)
	{
	    str.email.style.borderColor = "RED";
		error += "- Valid Email Address Is Required  \n";
		flag = false;
		//dataArray.push('email');
	}else
	{
		str.email.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
    if(str.phone1.value == "")
	{
		str.phone1.style.borderColor = "RED";
		error += "- Enter Mobile Number \n";
		flag = false;
		//dataArray.push('mobile');
	}else if(isNaN(str.ag_phone1.value)){
	
	    str.phone1.borderColor = "RED";
		error = "- '"+str.ag_phone1.value+"' Is Not phone Number \n";
		flag = false;
		}
	else
	{
		str.phone1.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
	if(str.uname.value == "")
	{
		str.uname.style.borderColor = "RED";
		error += "- Enter User Name \n";
		flag = false;
	//	dataArray.push('pwd');
	}
	else
	{
		str.uname.style.borderColor = "";
	//	flag = true;
	//	dataArray.pop();
	}

	
	if(str.pwd.value == "")
	{
		str.pwd.style.borderColor = "RED";
		error += "- Enter Password \n";
		flag = false;
	//	dataArray.push('pwd');
	}
	else
	{
		str.pwd.style.borderColor = "";
	//	flag = true;
	//	dataArray.pop();
	}

	//if(error != "")
	if(flag == false)
	{
		alert(error);
		//str.elements[dataArray[0]].focus();
		return false;
	}
	else{
	return true;
	}
	
}
</script>


<script type="text/javascript">

function checkUname(id,uid)
    {    
	//alert(id);
    $.ajax({
         type: "POST",
         url: "util/ajax-chk.php",
         data: "chk_uname="+ id + "&type=customer&user_id="+uid,
         success: function(msg){
		// alert(msg);
		 if(msg == 'ERROR')
			{
			$("#err_uname").html("This username is already taken");
			document.getElementById('uname').value="";
			document.getElementById('update').disabled = true;
			return false;
			}
			else if(msg == 'OK')
			{
			$("#err_uname").html("");
			document.getElementById('update').disabled = false;
			}	
			else if(msg == 'BLANK')
			{
			$("#err_uname").html("Please Enter a Valid Username");
			document.getElementById('update').disabled = true;
			}		       
			}    
		});
	}
function checkEmail(id,uid)
    {    
	//alert(id);
    $.ajax({
         type: "POST",
         url: "<?php echo BASE_URL;?>util/ajax-chk.php",
         data: "chk_email="+ id + "&type=customer&user_id="+uid,
         success: function(msg){ 
		 if(msg == 'ERROR')
			{
			$("#dr_span").html("This Emial ID already registered.");
			document.getElementById('ag_email').value = '';
			document.getElementById('update').disabled = true;
			return false;
			}
			else if(msg == 'OK')
			{
			$("#dr_span").html("");
			document.getElementById('update').disabled = false;
			}else if(msg == 'BLANK')
			{
			 $("#dr_span").html("Please Enter a Valid Emial ID");
			 document.getElementById('update').disabled = true;
			}			       
		  }    
		});
	}
</script>

<script type="text/javascript">
function isNumberKey(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
}

</script>

<table width="550" border="0" align="center" cellpadding="3" cellspacing="0" style="border-bottom: 1px solid #CCC; margin-top: 20px;">
  <tr>
    <td width="358" style="padding-bottom: 2px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Edit Customer</strong></td>
    <td width="180" valign="top" style="padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036; "><span style="padding-right:40px;"><a href="<?php echo BASE_URL?>account.php?page=user_list">View Customer List</a></span></td>
    
  </tr>
</table>
<?php if($msg <> ""){ ?>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 0px; <?php if(isset($msg)){?>background-color: #F1F8E9;<?php }?> line-height: 15px; color: #900;">
  
  <!--<tr>
    <td width="98%"><?php echo $msg; ?></td>
  </tr>-->
  
</table>
<?php } ?>


<form action="" method="post" name="p_fr" id='p_fr' enctype="multipart/form-data" onsubmit="return validateManager();" >
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
    <tr>
      <td width="50%" valign="top" style="padding-right: 10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
	<tr>
    <td style="padding-top: 3px; padding-left: 0px; padding-bottom: 3px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	</table>
	</td>
    </tr>
</table>

		
		
		
		
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2; padding-left:5px;"><strong>Customer  Details:</strong></td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td style="padding: 5px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
                
                <tr>
                  <td style="padding-left: 0px;">Customer ID  :</td>
                 <td><input name="cust_id" type="text" class="textbox" id="ag_code" style="width: 200px; border: none; font-size: 14px;background-color:white; " value="<?php echo $user['cust_id']; ?>" readonly="yes" />                     </td>
                </tr>
				<tr>
                  <td style="padding-left: 0px;">First Name :</td>
                  <td><input name="fname" type="text" class="textbox" id="fname" style="width: 200px;" value="<?php echo $user['fname']; ?>" /> <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				
				<tr>
                  <td style="padding-left: 0px;">Last Name :</td>
                  <td><input name="lname" type="text" class="textbox" id="lname" style="width: 200px;" value="<?php echo $user['lname']; ?>" /> <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				<tr>
                  <td width="29%" style="padding-left: 0px;"> Email : </td>
                  <td width="71%"><div id='dr_span' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <input name="email" type="text" class="textbox" onblur="checkEmail(this.value,<?php echo $user['id']; ?>)" onkeyup="checkEmail(this.value,<?php echo $user['id']; ?>)" id="email" style="width: 200px;" value="<?php echo $user['email']; ?>" autocomplete="off" oncontextmenu="return false;" oncopy="return false;" oncut="return false;" onpaste="return false;" />
                  <span style="padding-left: 5px; color:#F00"> *</span></td>
                </tr>
				
				
				<tr>
                  <td width="29%" style="padding-left: 0px;">Phone: </td>
                  <td width="71%">
				  <input name="phone1" type="text" class="textbox" maxlength="12" id="phone1" onKeyPress="return isNumberKey(event)" style="width: 200px;" value="<?php echo $user['phone1']; ?>" />
                  <span style="padding-left: 5px; color:#F00"> *</span></td>
                </tr>
				
				
				
				
				
				
				
				
				
              </table>
			  
			  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px; padding-top:5px;">
		   <tr>
		     <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2; padding-left:5px;"><strong>Login  Details:</strong></td>
            </tr>
	      </table>
		  
		  <table width="100%" border="0" cellspacing="2" cellpadding="2" style="margin-bottom: 0px; padding-top:10px;">
		  <tr>
		    <td width="29%" style="padding-right: 10px;">Username: </td>
                    <td width="71%">
					  <div id='err_uname' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
                      <input name="uname" type="text" class="textbox" id="uname" style="width: 200px;" value="<?php echo $user['uname'];?>" onblur="return checkUname(this.value,<?php echo $user['id']; ?>);" onkeyup="return checkUname(this.value,<?php echo $user['id']; ?>);" autocomplete="off" oncontextmenu="return false;" oncopy="return false;" oncut="return false;" onpaste="return false;"  />
              <span style="padding-left: 5px; color:#F00"> *</span></td>
            </tr>
		  
		  <tr>
		    <td width="29%" style="padding-right: 10px;">Password: </td>
                    <td width="71%">
                      <input name="pwd"  type="text" class="textbox" id="pwd" style="width: 200px;" value="<?php echo base64_decode($user['pwd']); ?>" /></td>
            </tr>
		  </table>
		  
		  
			  </td>
          </tr>
        </table>
        
        
        </td>
    </tr>
    <tr>
    </tr>
    <tr>
      <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
        </table></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" style="padding: 5px;">
       <input type="submit" name="update" id="update" value=" Update" class="actionBtn" >
	  	
        <input type="button" name="cancel" id="cancel" value="Cancel" class="actionBtn" onclick="location.href='account.php?page=user_list'" />
        <!--<input type="button" name="list" id="list" value="Back To List" class="actionBtn" onclick="location.href='account.php?page=emplist'">-->        
        </td>
    </tr>
  </table>
</form>