<script type="text/javascript">

function checkUname(id)
    {    
    var cid='<?php echo $_GET['id'];?>';
	$.ajax({
         type: "POST",
         url: "util/ajax-chk.php",
         data: "chk_uname="+ id + "&type=company&id="+cid,
         success: function(msg){
		 if(msg == 'ERROR')
			{
			$("#err_uname").html("This username is already taken");
			//document.getElementById('uname').value="";
			$("input[type=submit]").attr("disabled", "disabled");
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
    var cid='<?php echo $_GET['id'];?>';
	$.ajax({
         type: "POST",
         url: "util/ajax-chk.php",
         data: "chk_email="+ id + "&type=company&id="+cid,
         success: function(msg){
		 if(msg == 'ERROR')
			{
			$("#dr_span").html("This Emial ID already registered.");
			document.getElementById('comp_email').value = '';
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

function check_url(theurl) {
     //var tomatch= /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z0-9-_%&\?\/.=]+\.{3}/; // [A-Za-z0-9-_%&\?\/.=]+$
	 //var tomatch = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
	// var tomatch = new RegExp("^(ftp|https?):\/\/(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{3}$");
	 //var tomatch = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	 var tomatch = new RegExp("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");
     if (tomatch.test(theurl))
     {
         return true;
     }
     else
     {
         return false; 
     }
}
</script>


<!-- Script by hscripts.com -->
<script type="text/javascript">

function checkDomain(nname)
{
var arr = new Array(
'.com','.net','.org','.biz','.coop','.info','.museum','.name',
'.pro','.edu','.gov','.int','.mil','.ac','.ad','.ae','.af','.ag',
'.ai','.al','.am','.an','.ao','.aq','.ar','.as','.at','.au','.aw',
'.az','.ba','.bb','.bd','.be','.bf','.bg','.bh','.bi','.bj','.bm',
'.bn','.bo','.br','.bs','.bt','.bv','.bw','.by','.bz','.ca','.cc',
'.cd','.cf','.cg','.ch','.ci','.ck','.cl','.cm','.cn','.co','.cr',
'.cu','.cv','.cx','.cy','.cz','.de','.dj','.dk','.dm','.do','.dz',
'.ec','.ee','.eg','.eh','.er','.es','.et','.fi','.fj','.fk','.fm',
'.fo','.fr','.ga','.gd','.ge','.gf','.gg','.gh','.gi','.gl','.gm',
'.gn','.gp','.gq','.gr','.gs','.gt','.gu','.gv','.gy','.hk','.hm',
'.hn','.hr','.ht','.hu','.id','.ie','.il','.im','.in','.io','.iq',
'.ir','.is','.it','.je','.jm','.jo','.jp','.ke','.kg','.kh','.ki',
'.km','.kn','.kp','.kr','.kw','.ky','.kz','.la','.lb','.lc','.li',
'.lk','.lr','.ls','.lt','.lu','.lv','.ly','.ma','.mc','.md','.mg',
'.mh','.mk','.ml','.mm','.mn','.mo','.mp','.mq','.mr','.ms','.mt',
'.mu','.mv','.mw','.mx','.my','.mz','.na','.nc','.ne','.nf','.ng',
'.ni','.nl','.no','.np','.nr','.nu','.nz','.om','.pa','.pe','.pf',
'.pg','.ph','.pk','.pl','.pm','.pn','.pr','.ps','.pt','.pw','.py',
'.qa','.re','.ro','.rw','.ru','.sa','.sb','.sc','.sd','.se','.sg',
'.sh','.si','.sj','.sk','.sl','.sm','.sn','.so','.sr','.st','.sv',
'.sy','.sz','.tc','.td','.tf','.tg','.th','.tj','.tk','.tm','.tn',
'.to','.tp','.tr','.tt','.tv','.tw','.tz','.ua','.ug','.uk','.um',
'.us','.uy','.uz','.va','.vc','.ve','.vg','.vi','.vn','.vu','.ws',
'.wf','.ye','.yt','.yu','.za','.zm','.zw');

var mai = nname;
var val = true;

var dot = mai.lastIndexOf(".");
var dname = mai.substring(0,dot);
var ext = mai.substring(dot,mai.length);
//alert(ext);
	
if(dot>2 && dot<57)
{
	for(var i=0; i<arr.length; i++)
	{
	  if(ext == arr[i])
	  {
	 	val = true;
		break;
	  }	
	  else
	  {
	 	val = false;
	  }
	}
	if(val == false)
	{
	  	 alert("Your domain extension "+ext+" is not correct");
		 return false;
	}
	else
	{
		for(var j=0; j<dname.length; j++)
		{
		  var dh = dname.charAt(j);
		  var hh = dh.charCodeAt(0);
		  if((hh > 47 && hh<59) || (hh > 64 && hh<91) || (hh > 96 && hh<123) || hh==45 || hh==46)
		  {
			 if((j==0 || j==dname.length-1) && hh == 45)	
		  	 {
		 	  	 alert("Domain name should not begin are end with '-'");
			      return false;
		 	 }
		  }
		else	{
		  	 alert("Your domain name should not have special characters");
			 return false;
		  }
		}
	}
}
else
{
 alert("Your Domain name is too short/long");
 return false;
}	

return true;
}
</script>
<script type="text/javascript">
function validateManager()
{
	var str = document.p_fr;
	var error = "";
	var flag = true;
	//var dataArray = new Array();
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var fup = document.getElementById('comp_logo');
    var fileName = fup.value;
    var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	
	if(str.comp_code.value == "")
	{
		str.comp_code.style.borderColor = "RED";
		error += "-Enter Company Id \n";
		flag = false;
	     //dataArray.push('emp_id');
	}
	else
	{
		str.comp_code.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	if(str.comp_name.value == "")
	{
		str.comp_name.style.borderColor = "RED";
		error += "- Enter Company Name \n";
		flag = false;
		//dataArray.push('fname');
	}
	else
	{
		str.comp_name.style.borderColor = "";
	    //flag = true;
		//dataArray.pop();
	}
	if(str.comp_url.value == "")
	{
		str.comp_url.style.borderColor = "RED";
		error += "- Enter Company URL \n";
		flag = false;
		//dataArray.push('lname');
	}
	else if(check_url(str.comp_url.value) == false)
	  // else if(checkDomain(str.comp_url.value) == false)
	{
	   str.comp_url.style.borderColor = "RED";
	   error += '- Enter a Valid URL \n';
	   str.comp_url.focus();
	   flag = false;
	}
	else
	{
	 	str.comp_url.style.borderColor = "";
	    //flag = true;
		//dataArray.pop();
	}
	
	if(fup.value != '')
	{
		if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG")
		{
		 //return true;
		} 
		else
		{
		  str.comp_logo.style.borderColor = "RED";
		  error += "- Please Upload GIF or JPG or png image only \n";
		  fup.focus();
		  flag = false;
		}
	}
	
	if(str.comp_address1.value == "")
	{
		str.comp_address1.style.borderColor = "RED";
		error += "- Enter Company Address \n";
		flag = false;
	//	dataArray.push('pwd');
	}
	else
	{
		str.comp_address1.style.borderColor = "";
	//	flag = true;
	//	dataArray.pop();
	}
	
	if(str.comp_contact_person.value == "")
	{
		str.comp_contact_person.style.borderColor = "RED";
		error += "- Enter Contact Person Name \n";
		flag = false;
		//dataArray.push('lname');
	}
	else
	{
	 	str.comp_contact_person.style.borderColor = "";
	    //flag = true;
		//dataArray.pop();
	}
	
	
	if(str.comp_email.value == "")
	{
		str.comp_email.style.borderColor = "RED";
		error += "- Enter Your Email \n";
		flag = false;
		//dataArray.push('email');
	}
	else
	 if(str.comp_email.value.search(filter) == -1)
	{
	    str.comp_email.style.borderColor = "RED";
		error += "- Valid Email Address Is Required  \n";
		flag = false;
		//dataArray.push('email');
	}else
	{
		str.comp_email.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	


	if(str.comp_phone1.value == "")
	{
		str.comp_phone1.style.borderColor = "RED";
		error += "- Enter Company Phone Number \n";
		flag = false;
		//dataArray.push('mobile');
	}
	else
	{
		str.comp_phone1.style.borderColor = "";
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
<?php
// create user
if(isset($_POST['save']))
{
	// post params
	$username = $_POST['uname'];
	$password = base64_encode($_POST['pwd']);
	
	unset($_POST['uname']);
	unset($_POST['pwd']);
	unset($_POST['save']);
	
	$_POST['created_date'] = date("Y-m-d H:i:s");
	
	$photo=$_FILES['comp_logo']['name'];
	if($photo!='')
	{
		$photo1=time().$photo;
		$_POST['comp_logo'] = $photo1;
		$tmp=$_FILES['comp_logo']['tmp_name'];
		move_uploaded_file ($tmp,"../upload/company/".$photo1);
	}
	
	$record_ins1 = $db->recordInsert($_POST,COMPANYTBL);

	if($record_ins1 == '1')
	{
		$empid = mysql_insert_id();
		$db->recordInsert(array('uid'=>$empid,"user_type"=>'C',"uname"=>$username,"pwd"=>$password,"is_active"=>'1'),LOGINTBL);
		// Email login detail to the company
		$to = $_POST['comp_email'];
		$email_data=getEmailTemplate(5);
		$subject = $email_data['0'];
		$message= setMailContent(array($_POST['comp_name'], $username, base64_decode($password)), $email_data['1']);// send mail
		sendMail($to,$subject,$message);
	}
	
	if(mysql_affected_rows() > 0)
	{
		header('location:account.php?page=company_list');
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
		
		$username=$_POST['uname'];
		$password=base64_encode($_POST['pwd']);
		
		unset($_POST['uname']);
		unset($_POST['pwd']);
		unset($_POST['update']);
				
		$company_details=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid=".$id." and user_type='C'"));
		if(base64_decode($company_details['pwd'])==$_POST['pwd'])
			$pwdchange=0;
		else
			$pwdchange=1;
		if($company_details['uname']==$_POST['uname'])
			$unamechange=0;
		else
			$unamechange=1;
		//unset($_POST['comp_logo']);
		if($unamechange=='1' || $pwdchange=='1')
			$resultqsss = $db->recordUpdate(array("uid" => $id, "user_type" => 'C'),array("uname"=>$username,"pwd"=>$password),LOGINTBL);
		
		$resultq=$db->recordUpdate(array("id" => $id),$_POST,COMPANYTBL);
	  
		$photo=$_FILES['comp_logo']['name'];
	
		//upload photo
		if($photo!=''){
		
			$photo1=time().$photo;
			$tmp=$_FILES['comp_logo']['tmp_name'];
			move_uploaded_file ($tmp,"../upload/company/".$photo1);
			$photopath=getElementVal('comp_logo',$datalists);
			unlink("../upload/company/$photopath");
			$resultq=$db->recordUpdate(array("id" => $id),array("comp_logo"=>$photo1),COMPANYTBL);
		}
		
		if($resultqsss)
		{
			$to = $_POST['comp_email'];
			$subject = "KSA Account Detail";
			// send mail on username or password change
			$to = $_POST['comp_email'];
			$email_data=getEmailTemplate(6);
			$subject = $email_data['0'];
			$message= setMailContent(array($_POST['comp_name'], $username, base64_decode($password)), $email_data['1']);// send mail
			if($unamechange=='1' || $pwdchange=='1')
				sendMail($to,$subject,$message);

			header('location:account.php?page=company_list');
		}else{
			$msg="Your Record Updation failed";
		}
	}
}
//redirectuser();
if($_GET['task'] == "edit" && $_GET['id'] != "")
{
		$datalists = $db->recordFetch($_GET['id'],COMPANYTBL.":".'id');
		$sql_arr = mysql_fetch_array(mysql_query("SELECT * FROM ".LOGINTBL." WHERE uid = '".$_GET['id']."' AND user_type = 'C'"));
		
}

$lastid="select * from ".COMPANYTBL." ORDER BY id DESC limit 1";
$lastid1=mysql_fetch_object(mysql_query($lastid));
$lsid=$lastid1->comp_code;
$lastempid=explode('P',$lsid);  
$lastempid1=$lastempid[1]+1;
$code=$lastempid[0].P.$lastempid1;
?>




<!-- Script by hscripts.com -->



<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="border-bottom: 1px solid #CCC; margin-top: 0px;">
  <tr>
    <td width="662" style="padding-bottom: 2px; padding-left: 0px; font-size: 14px; color: #036;">
    <strong><?php if($_GET['id']!="") { echo "Edit Company"; } else {echo "Add Company";} ?> </strong>
    </td>
    <td align="right" style="padding-bottom: 5px; font-size: 14px; color: #036; padding-right: 1px;">
      <input type="button" name="addnew" class="actionBtn" id="addnew" value=" View Company List " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; cursor: pointer;" onclick="location.href='<?php echo BASE_URL?>account.php?page=company_list'"/>
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


<form action="" method="post" name="p_fr" id='p_fr' onSubmit="return validateManager();" enctype="multipart/form-data">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
    <tr>
      <td width="50%" valign="top" style="padding-right: 10px;">
      
	  
	  
 

		
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	   <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Company Id</strong></td>
          </tr>
        </table>		
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 2px;">
          <tr>
            <td><table width="100%" height="35" border="0" cellpadding="2" cellspacing="0">
                <tr>
                  <td width="100%" height="35" style="padding: 5px; padding-left: 2px;"><input readonly="readonly" name="comp_code" type="text" class="textbox" id="comp_code" style="width: 200px; border: none; font-size: 14px;background-color:white; border-left: 1px solid #666;" value="<?php  if($_GET['id']!=''){echo getElementVal('comp_code',$datalists);}else{if(isset($lsid)){echo $code;}else{echo 'BVCOMP100201';}} ?>"/> </td>
                </tr>
              </table></td>
          </tr>
	  </table>
		
		
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Company Detail</strong></td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td style="padding: 5px; padding-left: 0px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
                
                <tr>
                  <td style="padding-left: 0px;">Company Name:</td>
                  <td><input name="comp_name" type="text" class="textbox" id="comp_name" style="width: 200px;" value="<?php echo getElementVal('comp_name',$datalists); ?>" /> <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				<tr>
                  <td style="padding-left: 0px;">URL (http://):</td>
                  <td><input name="comp_url" type="text" class="textbox" id="comp_url" style="width: 200px;" value="<?php echo getElementVal('comp_url',$datalists); ?>" />
                  <span style="padding-left: 5px; color:#F00"> *</span></td>
                </tr>
				
				<tr>
                  <td width="29%" style="padding-left: 0px;">Upload Logo:</td>
                  <td width="71%"><span style="padding-left: 0px;">
                    <input id="comp_logo" name="comp_logo" type="file">
                  </span></td>
                </tr>
				
				
				<tr>
                  <td width="29%" valign="top" style="padding-left: 0px;">Description:</td>
                  <td width="71%"><textarea style="width:250px; height:60px; resize:none" name="comp_description" id="comp_description"><?php echo getElementVal('comp_description',$datalists); ?></textarea></td> 
                </tr>
				<tr>
                  <td width="29%" valign="top" style="padding-left: 0px;">Address (1):</td>
                  <td width="71%"><textarea style="width:250px; height:60px; resize:none" name="comp_address1" id="comp_address1"><?php echo getElementVal('comp_address1',$datalists); ?></textarea>
                  <span style="padding-left: 5px; color:#F00">*</span></td>
                </tr>
				<tr>
                  <td width="29%" valign="top" style="padding-left: 0px;">Address (2):</td>
                  <td width="71%"><textarea style="width:250px; height:60px; resize:none" name="comp_address2" id="comp_address2"><?php echo getElementVal('comp_address2',$datalists); ?></textarea></td>
                </tr>
				<tr>
				  <td style="padding-left: 0px;">State:</td>
				  <td><input name="comp_state" type="text" class="textbox" id="comp_state" style="width: 200px;" value="<?php echo getElementVal('comp_state',$datalists); ?>"/></td>
			    </tr>
				<tr>
				  <td style="padding-left: 0px;">City:</td>
				  <td><input name="comp_city" type="text" class="textbox" id="comp_city" style="width: 200px;" value="<?php echo getElementVal('comp_city',$datalists); ?>"/></td>
			    </tr>
				<tr>
				  <td style="padding-left: 0px;">Country:</td>
				  <td><input name="comp_country" type="text" class="textbox" id="comp_country" style="width: 200px;" value="<?php echo getElementVal('comp_country',$datalists); ?>"/></td>
			    </tr>
				<tr>
				  <td style="padding-left: 0px;">Postal Code:</td>
				  <td><input name="comp_zip" type="text" class="textbox" maxlength="12" onKeyPress="return isNumberKey(event)" id="comp_zip" style="width: 200px;" value="<?php echo getElementVal('comp_zip',$datalists); ?>"/></td>
			    </tr>
				 
              </table></td>
          </tr>
        </table>
        
        
        </td>
		
		
      <td width="50%" valign="top" style="padding: 0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Contact Person Information</strong></td>
          </tr>
        </table>
 
 <table width="100%" border="0">
   <tr>
     <td style="padding-left: 0px;">Salutation:</td>
     <td><select name="comp_contact_salutation" id="comp_contact_salutation">
       <option value="Mr" <?php if(getElementVal('comp_contact_salutation',$datalists) == "Mr") echo "selected='selected'"; ?>>Mr</option>
       <option value="Mrs" <?php if(getElementVal('comp_contact_salutation',$datalists) == "Mrs") echo "selected='selected'"; ?>>Mrs</option>
     </select></td>
   </tr>
   <tr>
                  <td width="27%" style="padding-left: 0px;">Person Name:</td>
                  <td width="73%"><input name="comp_contact_person" type="text" class="textbox" id="comp_contact_person" style="width: 200px;" value="<?php echo getElementVal('comp_contact_person',$datalists); ?>" />                    <span style="padding-left: 5px; color:#F00"> *</span>                </td>
                </tr>
				
				 <tr>
				   <td style="padding-left: 0px;">Designation:</td>
				   <td><input name="comp_contact_designation" type="text" class="textbox" id="comp_contact_designation" style="width: 200px;" value="<?php echo getElementVal('comp_contact_designation',$datalists); ?>" /></td>
	      </tr>
				 <tr>
                  <td style="padding-left: 0px;">Email:</td>
                  <td>
                      <div id='dr_span' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
                      <input name="comp_email" type="text" class="textbox" onblur="checkEmail(this.value)" id="comp_email" style="width: 200px;" value="<?php echo getElementVal('comp_email',$datalists); ?>" onkeyup="checkEmail(this.value)" autocomplete="off" oncontextmenu="return false;" oncopy="return false;" oncut="return false;" onpaste="return false;" />
                    <span style="padding-left: 5px; color:#F00"> *</span></td>
                </tr>
				 <tr>
				   <td style="padding-left: 0px;">Mobile:</td>
				   <td><input name="comp_phone1" type="text" class="textbox" id="comp_phone1" style="width: 200px;" value="<?php echo getElementVal('comp_phone1',$datalists); ?>" />
			       <span style="padding-left: 5px; color:#F00">*</span></td>
	      </tr>
				 <tr>
				   <td style="padding-left: 0px;">Phone (Landline):</td>
				   <td><input name="comp_phone2" type="text" class="textbox" id="comp_phone2" style="width: 200px;" value="<?php echo getElementVal('comp_phone2',$datalists); ?>" /></td>
	      </tr>
				 <tr>
				   <td style="padding-left: 0px;">Fax:</td>
				   <td><input name="comp_fax" type="text" class="textbox" id="comp_fax" style="width: 200px;" value="<?php echo getElementVal('comp_fax',$datalists); ?>" /></td>
	      </tr>
 </table>


 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Login Detail</strong></td>
          </tr>
        </table>
 
 <table width="100%" border="0">
   <tr>
                  <td width="27%" style="padding-left: 0px;">Username:</td>
                  <td width="73%"> 
                      <div id='err_uname' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
                      <input name="uname" type="text" class="textbox" id="uname" style="width: 200px;" value="<?php echo $sql_arr['uname'];?>" onkeyup="return checkUname(this.value);" onblur="return checkUname(this.value);" autocomplete="off" oncontextmenu="return false;" oncopy="return false;" oncut="return false;" onpaste="return false;" />
              <span style="padding-left: 5px; color:#F00"> *</span>                </td>
                </tr>
				
				 <tr>
                  <td style="padding-left: 0px;">Password:</td>
                  <td>
                      <input name="pwd" <?php if($_GET['id'] == ''){?> readonly="readonly" <?php }?> type="text" class="textbox" id="pwd" style="width: 200px;" value="<?php if($_GET['id'] == ''){echo generateCode('8');}else{echo base64_decode($sql_arr['pwd']);} ?>" />
              <span style="padding-left: 5px; color:#F00"> *</span>          </td>
                </tr>
</table>

</td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
        </table></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" style="padding: 5px; padding-left: 0px;">
	  	<?php
		if($_GET['id'] != "" && $task == "edit"){
    	?>
          
          <input type="submit" name="update" id="update" value=" Update" class="actionBtn">
          <?php }else{ ?>
          <input type="submit" name="save" id="save" value="Save" class="actionBtn">
          <?php } ?>
          <input type="button" name="cancel" id="cancel" value="Cancel" class="actionBtn" onclick="location.href='account.php?page=company_list'" />     
        </td>
    </tr>
  </table>
</form>