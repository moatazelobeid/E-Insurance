<?php
// create user
if(isset($_POST['save']))
{
	// post params
	
	$status=$_POST['status'];
	$username=$_POST['uname'];
	$password=base64_encode($_POST['pwd']);
	
	unset($_POST['status']);
	unset($_POST['uname']);
	unset($_POST['pwd']);
	unset($_POST['save']);
	
	$_POST['created_date'] = date("Y-m-d H:i:s");
	
	
	
	$photo=$_FILES['emp_photo']['name'];
	if($photo!='')
	{
      $photo1=time().$photo;
	  $_POST['emp_photo'] = $photo1;
      $tmp=$_FILES['emp_photo']['tmp_name'];
      move_uploaded_file ($tmp,"../upload/user/".$photo1);
    }





	
	$record_ins1 = $db->recordInsert($_POST,EMPLOYEETBL);
	
	if($record_ins1 == '1')
	{
	  $empid = mysql_insert_id();
	  $db->recordInsert(array('uid'=>$empid,"user_type"=>'E',"uname"=>$username,"pwd"=>$password,"is_active"=>$status),LOGINTBL);
	}
	
	if(mysql_affected_rows() > 0)
	{
		// create mail
		$to = $_POST['emp_email'];
		$email_data=getEmailTemplate(1);
		$subject = $email_data['0'];
		$message= setMailContent(array($_POST['emp_fname'], $username, base64_decode($password)), $email_data['1']);
		// send mail
		sendMail($to,$subject,$message);
		 
		 header('location:account.php?page=employee_list');
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
		
		unset($_POST['status']);
		unset($_POST['uname']);
		unset($_POST['pwd']);
		unset($_POST['update']);
		unset($_POST['emp_photo']);
		
		$emp_details=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid=".$id." and user_type='E'"));
		if(base64_decode($emp_details['pwd'])==$_POST['pwd'])
			$pwdchange=0;
		else
			$pwdchange=1;
		if($emp_details['uname']==$_POST['uname'])
			$unamechange=0;
		else
			$unamechange=1;
			
		if($unamechange=='1' || $pwdchange=='1')
			$resultqsss = $db->recordUpdate(array("uid" => $id, "user_type" => 'E'),array("uname"=>$username,"pwd"=>$password,"is_active" => $status),LOGINTBL);
		
		$resultq=$db->recordUpdate(array("id" => $id),$_POST,EMPLOYEETBL);
	  
		$photo=$_FILES['emp_photo']['name'];
	
	//upload photo
		if($photo!=''){
		
			$photo1=time().$photo;
			$tmp=$_FILES['emp_photo']['tmp_name'];
			move_uploaded_file ($tmp,"../upload/user/".$photo1);
			$photopath=getElementVal('emp_photo',$datalists);
			unlink("../upload/user/$photopath");
			$resultq=$db->recordUpdate(array("id" => $id),array("emp_photo"=>$photo1),EMPLOYEETBL);
		}
	
	
	
		if($resultqsss)
		{
			//mail to admin on username or password change
			$to = $_POST['emp_email'];
			$email_data=getEmailTemplate(2);
			$subject = $email_data['0'];
			$message= setMailContent(array($_POST['emp_fname'], $username, base64_decode($password)), $email_data['1']);// send mail
			if($unamechange=='1' || $pwdchange=='1')
				sendMail($to,$subject,$message);
		
			header('location:account.php?page=employee_list');
		}else{
			$msg="Your Record Updation failed";
		}
	}



}



//redirectuser();
if($_GET['task'] == "edit" && $_GET['id'] != "")
{
		$datalists = $db->recordFetch($_GET['id'],EMPLOYEETBL.":".'id');
		$sql_arr = mysql_fetch_array(mysql_query("SELECT * FROM ".LOGINTBL." WHERE uid = '".$_GET['id']."' AND user_type = 'E'"));
		
}

$lastid="select * from ".EMPLOYEETBL." ORDER BY id DESC limit 1";
$lastid1=mysql_fetch_object(mysql_query($lastid));
$lsid=$lastid1->emp_code;
$lastempid=explode('V',$lsid);  
$lastempid1=$lastempid[1]+1;
$code=$lastempid[0].V.$lastempid1;
?>
<script type="text/javascript">
function validateManager()
{
	var str = document.p_fr;
	var error = "";
	var flag = true;
	//var dataArray = new Array();
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var fup = document.getElementById('emp_photo');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	//var e = checkEmail(str.emp_email.value);
	//var u = checkUname(str.uname.value);
	
	if(str.emp_code.value == "")
	{
		str.emp_code.style.borderColor = "RED";
	error += "-Enter Employee Id \n";
		flag = false;
	     //dataArray.push('emp_id');
	}
	else
	{
		str.emp_code.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	if(str.emp_fname.value == "")
	{
		str.emp_fname.style.borderColor = "RED";
		error += "- Enter First Name \n";
		flag = false;
		//dataArray.push('fname');
	}
	else
	{
		str.emp_fname.style.borderColor = "";
	    //flag = true;
		//dataArray.pop();
	}
	if(str.emp_lname.value == "")
	{
		str.emp_lname.style.borderColor = "RED";
		error += "- Enter Last Name \n";
		flag = false;
		//dataArray.push('lname');
	}
	else
	{
	 	str.emp_lname.style.borderColor = "";
	    //flag = true;
		//dataArray.pop();
	}
	
	
	
	if(str.emp_email.value == "")
	{
		str.emp_email.style.borderColor = "RED";
		error += "- Enter Your Email \n";
		flag = false;
		//dataArray.push('email');
	}
	else if(str.emp_email.value.search(filter) == -1)
	{
	    str.emp_email.style.borderColor = "RED";
		error += "- Valid Email Address Is Required  \n";
		flag = false;
		//dataArray.push('email');
	}
	/*else if(e == 1)
	{
		str.emp_email.style.borderColor = "RED";
	    //error += "-This Email ID already registered. \n";
		error += e;
		flag = false;
	     //dataArray.push('emp_email');
	}*/
	else
	{
		str.emp_email.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
	if(str.emp_dob.value == "")
	{
		str.emp_dob.style.borderColor = "RED";
		error += "- Enter Your Date of Birth \n";
		flag = false;
	//	dataArray.push('pwd');
	}
	else
	{
		str.emp_dob.style.borderColor = "";
	//	flag = true;
	//	dataArray.pop();
	}
	
	if(str.date_of_join.value == "")
	{
		str.date_of_join.style.borderColor = "RED";
		error += "- Enter Your Date of Joining \n";
		flag = false;
	//	dataArray.push('date_of_join');
	}
	else
	{
		str.date_of_join.style.borderColor = "";
	//	flag = true;
	//	dataArray.pop();
	}
	
		if(str.emp_address1.value == "")
	{
		str.emp_address1.style.borderColor = "RED";
		error += "- Enter Address1 \n";
		flag = false;
		//dataArray.push('addr1');
	}
	else
	{
		str.emp_address1.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}

	  
		if(str.emp_phone1.value == "")
	{
		str.emp_phone1.style.borderColor = "RED";
		error += "- Enter Phone(M) \n";
		flag = false;
		//dataArray.push('mobile');
	}else if(isNaN(str.emp_phone1.value)){
	
	    str.emp_phone1.borderColor = "RED";
		error = "- Enter a Valid Phone(M) Number \n";
		flag = false;
		}
	else
	{
		str.emp_phone1.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}

	if(str.uname.value == "")
	{
		str.uname.style.borderColor = "RED";
		error += "- Enter User Name \n";
		flag = false;
	//	dataArray.push('uname');
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
	
	if(fileName!="")
        {
                if(ext == "gif" || ext == "GIF" || ext == "png" || ext == "PNG" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG")
                {
                   str.emp_photo.style.borderColor = "";    
                } 
                else
                {
                        alert("Upload Gif or Jpg or png images only");
                        fup.focus();
                        return false;
                }
  }
  
  /*if(e != 1)
	{
		str.emp_email.style.borderColor = "RED";
	    //error += "-Enter Email Id \n";
		flag = false;
	     //dataArray.push('emp_id');
	}
	else
	{
		str.emp_email.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}*/
	
	
    //checkUname(id);
	//checkEmail(str.emp_email.value);	
	
	
	if(flag == false)
	{
		alert(error);
		//str.elements[dataArray[0]].focus();
		return false;
	}
	else{
	//checkEmail(str.emp_email.value);
	return true;
	}
	
}



function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

</script>

<script type="text/javascript">

function get_age(val)
{
$.post("util/get_age.php",{dt:val},function(data){
$("#age").val(data);
});
}

$(function() {
		$( "#date_of_join" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' } );
	});
	
$(function() {
		$( "#date_of_leave" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' });
	});
	
$(function() {
		$( "#emp_dob" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' , maxDate:0  });
	});
	
function check(t)
	{
	if(t>0)
	{
	document.getElementById('preemp').readOnly = false ;
	document.getElementById('preempc').readOnly = false ;
	document.getElementById('preempe').readOnly = false ;		
	}
	else
	{
	document.getElementById('preemp').readOnly = true ;
	document.getElementById('preempc').readOnly = true ;
	document.getElementById('preempe').readOnly = true ;
	document.getElementById('preemp').value="";
	document.getElementById('preempc').value="";
	document.getElementById('preempe').value="";
	}}
</script>
<script type="text/javascript">

function checkUname(id)
    {  
	var eid='<?php echo $_GET['id'];?>';  
    $.ajax({
         type: "POST",
         url: "util/ajax-chk.php",
         data: "chk_uname="+ id + "&type=employee&id="+eid,
         success: function(msg){
		 if(msg == 'ERROR')
			{
			$("#err_uname").html("This username is already taken");
			//document.getElementById('uname').value="";
			$("input[type=submit]").attr("disabled", "disabled");
			//document.getElementById('save').disabled = true;
			//document.getElementById('update').disabled = true;
			return false;
			}
			else if(msg == 'OK')
			{
			$("#err_uname").html("");
			//document.getElementById('save').disabled = false;
			//document.getElementById('update').disabled = false;
			$("input[type=submit]").removeAttr("disabled");
			}			       
			}    
		});
	}
function checkEmail(id)
{    
	var eid='<?php echo $_GET['id'];?>';  
    $.ajax({
         type: "POST",
         url: "util/ajax-chk.php",
         data: "chk_email="+ id+ "&type=employee&id="+eid,
         success: function(msg){ //alert(msg);
		 if(msg == 'ERROR')
			{
			$("#dr_span").html("This Email ID already registered.");
			document.getElementById('emp_email').value = '';
			document.getElementById('save').disabled = true;
			document.getElementById('update').disabled = true;
			return false;
			}
			else if(msg == 'OK')
			{
			$("#dr_span").html("");
			document.getElementById('save').disabled = false;
			document.getElementById('update').disabled = false;
			}else if(msg == 'BLANK')
			{
			 $("#dr_span").html("Please Enter a Valid Email ID");
			 document.getElementById('save').disabled = true;
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
         if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

</script>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="border-bottom: 1px solid #CCC; margin-top: 10px;">
  <tr>
    <td width="662" style="padding-bottom: 2px; padding-left: 0px; font-size: 14px; color: #036;"><strong><?php if($_GET['id']!="") { echo "Edit Employee"; } else {echo "Add Employee";} ?> </strong></td><td width="146" valign="top" style="padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036; "></td>
    
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
      <td width="50%" valign="top" style="padding-right: 10px;">
      
	  
	  
 
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
	<tr>
    	<td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Employee Type:</strong>
		</td>
    </tr>
	<tr>
    <td style="padding-top: 3px; padding-left: 0px; padding-bottom: 3px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
    <td height="35" colspan="2">
	<?php ?>
	<select name="emp_type_id" id="emp_type_id" style="background-color: #FFFFFF; border: none;font-weight: normal; font-size: 14px; margin-top: 5px;">
	<?php
	$sqlist = mysql_query("SELECT * FROM ".EMPTYPE." WHERE status = '1'");
	while($reslist = mysql_fetch_array($sqlist)){
	?>
	<option value="<?php echo $reslist['id'];?>"  <?php if(getElementVal('emp_type_id',$datalists) ==$reslist['id']) echo "selected='selected'"; ?>><?php echo $reslist['emp_type']?></option>
    <?php }?>
    </select>	</td>
    </tr>
	</table>
	</td>
    </tr>
</table>

		
		
		
		
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Employee Details:</strong></td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td style="padding: 5px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
                
                <tr>
                  <td style="padding-left: 0px;">First Name:</td>
                  <td><input name="emp_fname" type="text" class="textbox" id="emp_fname" style="width: 200px;" value="<?php  echo getElementVal('emp_fname',$datalists);  ?>" /> <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				<tr>
                  <td style="padding-left: 0px;">Last Name:</td>
                  <td><input name="emp_lname" type="text" class="textbox" id="emp_lname" style="width: 200px;" value="<?php echo getElementVal('emp_lname',$datalists); ?>" /> <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				
				<tr>
                  <td width="24%" style="padding-left: 0px;">Email:</td>
                  <td width="76%"><div id='dr_span' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div><input name="emp_email" type="text" class="textbox" id="emp_email" style="width: 200px;" value="<?php echo getElementVal('emp_email',$datalists); ?>" onkeyup="checkEmail(this.value)" autocomplete="off" oncontextmenu="return false;" oncopy="return false;" oncut="return false;" onpaste="return false;" />
                  <span style="padding-left: 5px; color:#F00"> *</span></td>
                </tr>
				
				
				<tr>
                  <td width="24%" style="padding-left: 0px;">Gender:</td>
                  <td width="76%" style="padding-left: 0px;">
				 
				  <input type="radio" name="emp_sex" id="sex" value="M" checked="checked" <?php if(getElementVal('emp_sex',$datalists) == 'M')echo "checked='checked'";?> />Male
				  <input name="emp_sex" type="radio" id="sex" value="F" <?php if(getElementVal('emp_sex',$datalists) == 'F')echo "checked='checked'";?>  />Female</td> 
                </tr>
				<tr>
                  <td width="24%" style="padding-left: 0px;">Date of Birth:</td>
                  <td width="76%"><input name="emp_dob" type="text" readonly="readonly" maxlength="10" onchange="get_age(this.value)" class="textbox" id="emp_dob" style="width: 200px;" value="<?php echo getElementVal('emp_dob',$datalists); ?>" /> <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				<tr>
                  <td width="24%" style="padding-left: 0px;">Blood Group:</td>
                  <td width="76%"><input name="emp_blood_group" type="text" class="textbox" id="emp_blood_group" style="width: 200px;" value="<?php echo getElementVal('emp_blood_group',$datalists); ?>" />
                  <span style="padding-left: 5px; color:#F00"> *</span></td>
                </tr>
				 
              </table></td>
          </tr>
        </table>
        
        
        </td>
		
		
      <td width="50%" valign="top">
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	   <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Employee Id:</strong></td>
          </tr>
        </table>		
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 2px;">
          <tr>
            <td><table width="100%" height="35" border="0" cellpadding="2" cellspacing="0">
                <tr>
                  <td width="100%" height="35" style="padding: 5px; padding-left: 2px;"><input readonly="readonly" name="emp_code" type="text" class="textbox" id="emp_code" style="width: 200px; border: none; font-size: 14px;background-color:white; border-left: 1px solid #666;" value="<?php  if($_GET['id']!=''){echo getElementVal('emp_code',$datalists);}else{if(isset($lsid)){echo $code;}else{echo 'AC100201';}} ?>"/></td>
                </tr>
              </table></td>
          </tr>
	  </table>

 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Adress Details:</strong></td>
          </tr>
        </table>
 
 <table width="100%" border="0">
   <tr>
                  <td width="20%" style="padding-left: 0px;">Address1:</td>
                  <td width="80%"> 
            <input name="emp_address1" type="text" class="textbox" id="emp_address1" style="width: 200px;" value="<?php echo getElementVal('emp_address1',$datalists); ?>"> <span style="padding-left: 5px; color:#F00">*</span>                  </td>
          </tr>
				
				 <tr>
                  <td style="padding-left: 0px;">Address2:</td>
                  <td>
                      <input name="emp_address2" type="text" class="textbox" id="emp_address2" style="width: 200px;" value="<?php echo getElementVal('emp_address2',$datalists); ?>">                  </td>
                </tr>
                
				 
				 <tr>
                  <td style="padding-left: 0px;">Phone(M):</td>
                  <td><input name="emp_phone1" class="textbox" id="emp_phone1"  maxlength="10" type="text" onkeypress="return isNumberKey(event)"
				  value="<?php  echo getElementVal('emp_phone1',$datalists); ?>" style="width: 200px;"/>
                  <span style="padding-left: 5px; color:#F00"> *</span></td>
                </tr>
				<tr>
                  <td style="padding-left: 0px;">Phone(H):</td>
                  <td><input name="emp_phone2" class="textbox" id="emp_phone2"  maxlength="14" onkeypress="return isNumberKey(event);" type="text" value="<?php echo getElementVal('emp_phone2',$datalists);  ?>" style="width: 200px;" /></td>
                </tr>
               
			 <tr>
                  <td style="padding-left: 0px;">Photo:</td>
                  <td><input name="emp_photo" class="textbox" id="emp_photo" type="file"  style="width: 200px;"/></td>
          </tr>
</table>

</td>
    </tr>
    <tr>
      <td colspan="2" valign="top">
	  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style=" margin-top: 8px;">
 <tr>
            <td align="left" colspan="4" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Office Use:</strong></td>
          </tr>
		  <tr>
                  <td width="12%" style="padding-left: 3px;">Date of Joining:</td>
            <td width="38%"><div class="demo" style="padding-top:4px;"><input name="date_of_join" type="text" readonly="readonly" maxlength="10" class="textbox" id="date_of_join" value="<?php echo getElementVal('date_of_join',$datalists);?>" style="width: 200px;" /> 
            <span style="padding-left: 5px; color:#F00">*</span></div></td> 
			
            <td width="10%" style="padding-left: 3px;">Username:</td>
             <td width="40%">
			 <div id='err_uname' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
			 <div class="demo" style="padding-top:4px;"><input name="uname" type="text" class="textbox" id="uname" value="<?php echo $sql_arr['uname'];?>" style="width: 200px;" onkeyup="return checkUname(this.value);" onblur="return checkUname(this.value);" autocomplete="off" oncontextmenu="return false;" oncopy="return false;" oncut="return false;" onpaste="return false;" /> 
            <span style="padding-left: 5px; color:#F00">*</span></div></td> 
			
			
          </tr>
                
                <tr>
                  <td style="padding-left: 3px;">Date of leave:</td>
                  <td style="padding-top:-3px"><input name="date_of_leave" readonly="readonly" type="text" class="textbox" id="date_of_leave" style="width: 200px;" value="<?php echo getElementVal('date_of_leave',$datalists);?>"></td>
				 <td width="10%" style="padding-left: 3px;">Password:</td>
             <td width="40%"><div class="demo" style="padding-top:4px;"><input name="pwd" type="text" class="textbox" id="pwd" value="<?php echo base64_decode($sql_arr['pwd']);?>" style="width: 200px;" /> 
            <span style="padding-left: 5px; color:#F00">*</span></div></td> 
			
			
		  </tr>
				  <tr>
				  <td width="12%">Status:</td>
                  <td width="38%">
				   <select style="width: 206px;" name='status' id='status'>
				   <option value="1" <?php if($sql_arr['is_active'] == '1') echo "selected='selected'"; ?>>Active</option>
				   <option value="0" <?php if($sql_arr['is_active'] == '0') echo "selected='selected'"; ?>>InActive</option>
			       </select></td>
				   <td colspan="2">&nbsp;</td>
                </tr>

</table>  
	  
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding-top: 5px;"></td>
          </tr>
        </table>
		
	  </td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
        </table></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" style="padding: 5px;">
	  	<?php
		if($_GET['id'] != "" && $task == "edit"){
    	?>
        
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn">
        <?php }else{ ?>
        <input type="submit" name="save" id="save" value="Save" class="actionBtn">
        <?php } ?>
        <input type="button" name="cancel" id="cancel" value="Cancel" class="actionBtn" onclick="location.href='account.php?page=employee_list'" />
        <!--<input type="button" name="list" id="list" value="Back To List" class="actionBtn" onclick="location.href='account.php?page=emplist'">-->        
        </td>
    </tr>
  </table>
</form>