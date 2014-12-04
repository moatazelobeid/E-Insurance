<?php
// create user
if(isset($_POST['save']))
{
	// post params
	$username=$_POST['uname'];
	$password=base64_encode($_POST['pwd']);
	
	unset($_POST['uname']);
	unset($_POST['pwd']);
	unset($_POST['save']);
	
	$_POST['created_date'] = date("Y-m-d H:i:s");
		
	$photo=$_FILES['ag_photo']['name'];
	if($photo!='')
	{
      $photo1=time().$photo;
	  $_POST['ag_photo'] = $photo1;
      $tmp=$_FILES['ag_photo']['tmp_name'];
      move_uploaded_file ($tmp,"../upload/agent/".$photo1);
    }
	
	$record_ins1 = $db->recordInsert($_POST,AGENTTBL);
	
	if($record_ins1 == '1')
	{
	  $empid = mysql_insert_id();
	  $db->recordInsert(array('uid'=>$empid,"user_type"=>'A',"uname"=>$username,"pwd"=>$password,"is_active"=>'1'),LOGINTBL);
	}
	
	if(mysql_affected_rows() > 0)
	{
	    $companyname = $config['company_name'];
		// send mail
		$to = $_POST['ag_email'];
		$email_data=getEmailTemplate(3);
		$subject = $email_data['0'];
		$message= setMailContentAgent(array($_POST['ag_fname'], $companyname, SITE_URL, $username, base64_decode($password)), $email_data['1']);// send mail
		sendMail($to,$subject,$message);
		
		header('location:account.php?page=agent_list');
	}else
	{
	 	$msg="Record Not Saved";
	}

}

// update user information
if(isset($_POST['update']))
{
	//$datas = $_POST;
	if($_GET['id']!=""){

	   // post params
	  
		$status=$_POST['status'];
		
		$username=$_POST['uname'];
		$password=base64_encode($_POST['pwd']);
		
		unset($_POST['uname']);
		unset($_POST['pwd']);
		unset($_POST['update']);
		
		$ag_details=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid=".$id." and user_type='A'"));
		if(base64_decode($ag_details['pwd'])==$_POST['pwd'])
			$pwdchange=0;
		else
			$pwdchange=1;
		if($ag_details['uname']==$_POST['uname'])
			$unamechange=0;
		else
			$unamechange=1;
		
		if($unamechange=='1' || $pwdchange=='1')
			$resultqsss = $db->recordUpdate(array("uid" => $id, "user_type" => 'A'),array("uname"=>$username,"pwd"=>$password),LOGINTBL);
		
		$resultq=$db->recordUpdate(array("id" => $id),$_POST,AGENTTBL);
	  
		$photo=$_FILES['ag_photo']['name'];
	
		//upload photo
		if($photo!=''){
		
			$photo1=time().$photo;
			$tmp=$_FILES['ag_photo']['tmp_name'];
			move_uploaded_file ($tmp,"../upload/agent/".$photo1);
			$photopath=getElementVal('ag_photo',$datalists);
			unlink("../upload/agent/$photopath");
			$resultq=$db->recordUpdate(array("id" => $id),array("ag_photo"=>$photo1),AGENTTBL);
		}
	
	
	
		if($resultqsss)
		{
	     	$companyname = $config['company_name'];
			// send mail on username or password change
			$to = $_POST['ag_email'];
			$email_data=getEmailTemplate(4);
			$subject = $email_data['0'];
			$message= setMailContentAgent(array($_POST['ag_fname'], $companyname, SITE_URL, $username, base64_decode($password)), $email_data['1']);// send mail
			if($unamechange=='1' || $pwdchange=='1')
				sendMail($to,$subject,$message);

			header('location:account.php?page=agent_list');
		}else{
			$msg="Your Record Updation failed";
		}
	}



}
//redirectuser();
if($_GET['task'] == "edit" && $_GET['id'] != "")
{
		$datalists = $db->recordFetch($_GET['id'],AGENTTBL.":".'id');
		$sql_arr = mysql_fetch_array(mysql_query("SELECT * FROM ".LOGINTBL." WHERE uid = '".$_GET['id']."' AND user_type = 'A'"));
		
}

$lastid="select * from ".AGENTTBL." ORDER BY id DESC limit 1";
$lastid1=mysql_fetch_object(mysql_query($lastid));
$lsid=$lastid1->ag_code;
$lastempid=explode('G',$lsid);
$lastempid1=$lastempid[1]+1;
$code=$lastempid[0].G.$lastempid1;
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
	
	if(str.ag_fname.value == "")
	{
		str.ag_fname.style.borderColor = "RED";
		error += "- Enter First Name \n";
		flag = false;
		//dataArray.push('fname');
	}
	else
	{
		str.ag_fname.style.borderColor = "";
	    //flag = true;
		//dataArray.pop();
	}
	if(str.ag_lname.value == "")
	{
		str.ag_lname.style.borderColor = "RED";
		error += "- Enter Last Name \n";
		flag = false;
		//dataArray.push('lname');
	}
	else
	{
	 	str.ag_lname.style.borderColor = "";
	    //flag = true;
		//dataArray.pop();
	}
	
	
	
	if(str.ag_email.value == "")
	{
		str.ag_email.style.borderColor = "RED";
		error += "- Enter Email Address \n";
		flag = false;
		//dataArray.push('email');
	}
	else
	 if(str.ag_email.value.search(filter) == -1)
	{
	    str.ag_email.style.borderColor = "RED";
		error += "- Valid Email Address Is Required  \n";
		flag = false;
		//dataArray.push('email');
	}else
	{
		str.ag_email.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
	if(str.ag_dob.value == "")
	{
		str.ag_dob.style.borderColor = "RED";
		error += "- Enter Date of Birth \n";
		flag = false;
	//	dataArray.push('pwd');
	}
	else
	{
		str.ag_dob.style.borderColor = "";
	//	flag = true;
	//	dataArray.pop();
	}

    if(str.ag_phone1.value == "")
	{
		str.ag_phone1.style.borderColor = "RED";
		error += "- Enter Mobile Number \n";
		flag = false;
		//dataArray.push('mobile');
	}else if(isNaN(str.ag_phone1.value)){
	
	    str.ag_phone1.borderColor = "RED";
		error = "- '"+str.ag_phone1.value+"' Is Not phone Number \n";
		flag = false;
		}
	else
	{
		str.ag_phone1.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
	if(str.ag_address1.value == "")
	{
		str.ag_address1.style.borderColor = "RED";
		error += "- Enter Address \n";
		flag = false;
		//dataArray.push('addr1');
	}
	else
	{
		str.ag_address1.style.borderColor = "";
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
$(function() {
		$( "#ag_dob" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' , maxDate:0  });
	});
</script>
<script type="text/javascript">

function checkUname(id)
    {    
	//alert(id);
	var uid="<?php echo $_GET['id'];?>";
    $.ajax({ 
         type: "POST",
         url: "util/ajax-chk.php",
         data: "chk_uname="+ id + "&type=agent&id="+uid,
         success: function(msg){
		// alert(msg);
		 if(msg == 'ERROR')
			{
			$("#err_uname").html("This username is already taken");
			$("input[type=submit]").attr("disabled", "disabled");
			//document.getElementById('uname').value="";
			return false;
			}
			else if(msg == 'OK')
			{
			$("#err_uname").html("");
			$("input[type=submit]").removeAttr("disabled");
			}			       
			}    
		});
	}
function checkEmail(id)
    {    
	var uid="<?php echo $_GET['id'];?>";
    $.ajax({
         type: "POST",
         url: "<?php echo BASE_URL;?>util/ajax-chk.php",
         data: "chk_email="+ id + "&type=agent&id="+uid,
         success: function(msg){
		 if(msg == 'ERROR')
			{
			$("#dr_span").html("This Emial ID already registered.");
			document.getElementById('ag_email').value = '';
			return false;
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

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="border-bottom: 1px solid #CCC; margin-top: 10px;">
  <tr>
    <td width="662" style="padding-bottom: 2px; padding-left: 0px; font-size: 14px; color: #036;"><strong><?php if($_GET['id']!="") { echo "Edit Broker"; } else {echo "Add Broker";} ?> </strong>
	</td>
	<td align="right" valign="top" style="padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;">
	<a href="<?php echo BASE_URL?>account.php?page=agent_list"><img src="images/view_all.png" width="87" height="15" border="0"></a>
	</td>
  </tr>
</table>
<?php if($msg <> ""){ ?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 0px; <?php if(isset($msg)){?>background-color: #F1F8E9;<?php }?> line-height: 15px; color: #900;">
  <tr>
    
    <td width="98%"><?php echo $msg; ?></td>
  </tr>
</table>
<?php } ?>

<?php if($errmsg <> ""){ ?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 0px; <?php if(isset($errmsg)){?>background-color: #F1F8E9;<?php }?> line-height: 15px; color: #900;">
  <tr>
    <td width="98%"><?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>

<form action="" method="post" name="p_fr" id='p_fr' onSubmit="return validateManager();" enctype="multipart/form-data">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
    <tr>
      <td width="25%" valign="top" style="padding-right: 15px;">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2; padding-left:5px;"><strong>Broker  Details:</strong></td>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3" style="margin-top: 10px;">
                
                <tr>
                  <td >Broker Code:</td>
                  <td>
				 
				 <input readonly="readonly" name="ag_code" type="text" class="textbox" id="ag_code" style="width: 200px; border: none; font-size: 14px;background-color:white; border-left: 1px solid #666;" value="<?php  if($_GET['id']!=''){echo getElementVal('ag_code',$datalists);}else{if(isset($lsid)){echo $code;}else{echo 'ACAG100201';}} ?>"/>                     </td>
                </tr>
				
				
				<tr>
                  <td >First Name:</td>
                  <td><input name="ag_fname" type="text" class="textbox" id="ag_fname" style="width: 200px;" value="<?php echo getElementVal('ag_fname',$datalists); ?>" /> <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				
				<tr>
                  <td >Last Name:</td>
                  <td><input name="ag_lname" type="text" class="textbox" id="ag_lname" style="width: 200px;" value="<?php echo getElementVal('ag_lname',$datalists); ?>" /> <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				<tr>
                  <td width="19%" > Email: </td>
                  <td width="81%"><div id='dr_span' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <input name="ag_email" type="text" class="textbox" onblur="checkEmail(this.value)" onkeyup="checkEmail(this.value)" id="ag_email" style="width: 200px;" value="<?php echo getElementVal('ag_email',$datalists); ?>" autocomplete="off" oncontextmenu="return false;" oncopy="return false;" oncut="return false;" onpaste="return false;" />
                  <span style="padding-left: 5px; color:#F00"> *</span></td>
                </tr>
				<tr>
                  <td width="19%" valign="top" >Gender:</td>
                  <td width="81%" >
				 
				  <input type="radio" name="ag_sex" id="sex" value="M" checked="checked" <?php if(getElementVal('ag_sex',$datalists) == 'M')echo "checked='checked'";?> />Male
				  <input name="ag_sex" type="radio" id="sex" value="F" <?php if(getElementVal('ag_sex',$datalists) == 'F')echo "checked='checked'";?>  />Female</td>
                </tr>
				<tr>
                  <td width="19%" valign="top" >Date of Birth:</td>
                  <td width="81%">
				  <input name="ag_dob" type="text" readonly="readonly" maxlength="10" class="textbox" id="ag_dob" value="<?php echo getElementVal('ag_dob',$datalists);?>" style="width: 200px;" />
				  <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				<tr>
                  <td width="19%" >Phone(M): </td>
                  <td width="81%">
				  <input name="ag_phone1" type="text" class="textbox" maxlength="12" id="ag_phone1" onKeyPress="return isNumberKey(event)" style="width: 200px;" value="<?php echo getElementVal('ag_phone1',$datalists); ?>" />
                  <span style="padding-left: 5px; color:#F00"> *</span></td>
                </tr>
				
				<tr>
                  <td width="19%" >Phone(H): </td>
                  <td width="81%">
				  <input name="ag_phone2" type="text" class="textbox" id="ag_phone2" style="width: 200px;" value="<?php echo getElementVal('ag_phone2',$datalists); ?>" /></td>
                </tr>
				<tr>
                  <td width="19%" valign="top" >Address 1:</td>
                  <td width="81%">
				  <textarea class="textbox" style="width:200px; height:60px; resize:none" name="ag_address1" id="ag_address1"><?php echo getElementVal('ag_address1',$datalists); ?></textarea>
				  <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				<tr>
                  <td width="19%" valign="top" >Address 2:</td>
                  <td width="81%">
				  <textarea class="textbox" style="width:200px; height:60px; resize:none" name="ag_address2" id="ag_address2"><?php echo getElementVal('ag_address2',$datalists); ?></textarea></td>
                </tr>
				<tr>
                  <td width="19%" >City: </td>
                  <td width="81%">
				  <input name="ag_city" type="text" class="textbox" id="ag_city" style="width: 200px;" value="<?php echo getElementVal('ag_city',$datalists); ?>"/>                  </td>
                </tr>
				<tr>
                  <td width="19%" >State: </td>
                  <td width="81%">
				 <input name="ag_state" type="text" class="textbox" id="ag_state" style="width: 200px;" value="<?php echo getElementVal('ag_state',$datalists); ?>"/>                 </td>
                </tr>
				
				<tr>
                  <td width="19%" >Country: </td>
                  <td width="81%">
				   <input name="ag_country" type="text" class="textbox" id="ag_country" style="width: 200px;" value="<?php echo getElementVal('ag_country',$datalists); ?>"/>                </td>
                </tr>
				<tr>
                  <td width="19%" >Zip Code: </td>
                  <td width="81%">
				  <input name="ag_zip" type="text" class="textbox" maxlength="7" onKeyPress="return isNumberKey(event)" id="ag_zip" style="width: 200px;" value="<?php echo getElementVal('ag_zip',$datalists); ?>" /></td>
                </tr>
        </table>	  
	  </td>
      <td width="25%" valign="top">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
		   <tr>
			 <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2; padding-left:5px;"><strong>Login  Details:</strong></td>
		  </tr>
	    </table>
		  <table width="100%" border="0" cellspacing="2" cellpadding="2" style="margin-bottom: 0px; padding-top:10px;">
		  <tr>
		    <td width="17%" style="padding-right: 10px;">Username: </td>
                    <td width="83%">
					  <div id='err_uname' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
                      <input name="uname" type="text" class="textbox" id="uname" style="width: 200px;" value="<?php echo $sql_arr['uname'];?>" onkeyup="return checkUname(this.value);" onblur="return checkUname(this.value);" autocomplete="off" oncontextmenu="return false;" oncopy="return false;" oncut="return false;" onpaste="return false;"  />
            <span style="padding-left: 5px; color:#F00"> *</span></td>
            </tr>
		  
		  <tr>
		    <td width="17%" style="padding-right: 10px;">Password: </td>
                    <td width="83%">
            <input name="pwd" <?php if($_GET['id'] == ''){?> readonly="readonly" <?php }?> type="text" class="textbox" id="pwd" style="width: 200px;" value="<?php if($_GET['id'] == ''){echo generateCode('8');}else{echo base64_decode($sql_arr['pwd']);} ?>" /></td>
            </tr>
	    </table>
	  </td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 15px;">
  <tr>
    <td>
	<?php
		if($_GET['id'] != "" && $task == "edit"){
    	?>
        
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn">
        <?php }else{ ?>
        <input type="submit" name="save" id="save" value="Save" class="actionBtn">
        <?php } ?>
        <input type="button" name="cancel" id="cancel" value="Cancel" class="actionBtn" onclick="location.href='account.php?page=agent_list'" />
	</td>
  </tr>
</table>

</form>