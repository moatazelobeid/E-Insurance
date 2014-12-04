<?php
$sq_var="select * from ".GLOBALTBL." where cid='1'";

$res_var=mysql_query($sq_var);

$rs_var=mysql_fetch_object($res_var);



$id=$rs_var->cid;

$title=stripslashes(trim($rs_var->site_name));

$default_title=stripslashes(trim($rs_var->default_title));


$site_email=stripslashes(trim($rs_var->site_email));

$author_name=stripslashes(trim($rs_var->author_name));


$meta_tag=stripslashes(trim($rs_var->meta_tag));
$address=stripslashes(trim($rs_var->address));
$address_ar=stripslashes(trim($rs_var->address_ar));

$meta_keyword=stripslashes(trim($rs_var->default_keywords));
$copyright_info=stripslashes(trim($rs_var->copyright_info));
$copyright_info_ar=stripslashes(trim($rs_var->copyright_info_ar));
$phone=trim($rs_var->phone);
$email=stripslashes(trim($rs_var->email));
$fax=trim($rs_var->fax);
//$db_user=$rs_var->db_user;

$date=$rs_var->modified_date;
//update

if(isset($_POST['update']))

{

	$title = addslashes(trim($_POST['title']));

	$default_title=addslashes(trim($_POST['default_title']));


	$site_email=addslashes(trim($_POST['site_email']));
	$meta_tag=addslashes(trim($_POST['meta_tag']));

	$meta_keyword=addslashes(trim($_POST['meta_keyword']));

	
	$address=addslashes(trim($_POST['address']));
	$address_ar=addslashes(trim($_POST['address_ar']));
	$copyright_info=addslashes(trim($_POST['copyright_info']));
	$copyright_info_ar=addslashes(trim($_POST['copyright_info_ar']));
	$phone=$_POST['phone'];
	$email=addslashes(trim($_POST['email']));
	$fax=$_POST['fax'];

	//$date=$_POST['date'];

	//$msg = "";



 $sq_update = "Update ".GLOBALTBL." set 	site_name='$title',default_title='$default_title',default_keywords='$meta_keyword',address='$address', address_ar='$address_ar', meta_tag='$meta_tag',copyright_info='$copyright_info',copyright_info_ar='$copyright_info_ar',site_email='$site_email',modified_date = now(),phone='$phone',email='$email',fax='$fax' where cid='1'";
 
 //echo"Update ".GLOBALTBL." set 	site_name='$title',default_title='$default_title',default_keywords='$meta_keyword',meta_tag='$meta_tag',copyright_info='$copyright_info',site_email='$site_email',modified_date = now(),phone='$phone',email='$email',fax='$fax' where cid='1'";

  if($res_update=mysql_query($sq_update)){
	  
	  
	  $msg="<span style='color:green;font-weight:bold'>Update Success</span>";
	  }else{
	    $msg="<span style='color:red;font-weight:bold'>Update Failed</span>";
	  }
  

	}



?>

<script type="text/javascript">

function validate_config(){

var fn=document.global_form;

		document.getElementById('config_error').innerHTML='';

		if(fn.title.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Site Name';

		fn.title.focus();

		fn.title.style.borderColor='red';

		return false;

		}else{

		fn.title.style.borderColor='';

		}

		if(fn.default_title.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Default Title';

		fn.default_title.focus();

		fn.default_title.style.borderColor='red';

		return false;

		}else{

		fn.default_title.style.borderColor='';

		}

		

		if(fn.site_url.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Site URL';

		fn.site_url.focus();

		fn.site_url.style.borderColor='red';

		return false;

		}else{

		fn.site_url.style.borderColor='';

		}

		

		if(fn.admin_url.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Admin URL';

		fn.admin_url.focus();

		fn.admin_url.style.borderColor='red';

		return false;

		}else{

		fn.admin_url.style.borderColor='';

		}

		

		if(fn.site_email.value.length==0){

		document.getElementById('config_error').innerHTML='Enter SiteEmail';

		fn.site_email.focus();

		fn.site_email.style.borderColor='red';

		return false;

		}else{

		fn.site_email.style.borderColor='';

		}

		

		

		if(fn.content_type.value==''){

		document.getElementById('config_error').innerHTML='Select Content Type';

		fn.content_type.focus();

		fn.content_type.style.borderColor='red';

		return false;

		}else{

		fn.content_type.style.borderColor='';

		}



       if(fn.meta_tag.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Meta Description';

		fn.meta_tag.focus();

		fn.meta_tag.style.borderColor='red';

		return false;

		}else{

		fn.meta_tag.style.borderColor='';

		}

		if(fn.meta_keyword.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Meta Keyword';

		fn.meta_keyword.focus();

		fn.meta_keyword.style.borderColor='red';

		return false;

		}else{

		fn.meta_keyword.style.borderColor='';

		}
/*
		if(fn.language.value==''){

		document.getElementById('config_error').innerHTML='Select Language';

		fn.language.focus();

		fn.language.style.borderColor='red';

		return false;

		}else{

		fn.language.style.borderColor='';

		}*/

		if(fn.copyright_info.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Copyright Info';

		fn.copyright_info.focus();

		fn.copyright_info.style.borderColor='red';

		return false;

		}else{

		fn.copyright_info.style.borderColor='';

		}
		
		 if(fn.copyright_info_ar.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Copyright Info(Ar)';

		fn.copyright_info_ar.focus();

		fn.copyright_info_ar.style.borderColor='red';

		return false;

		}else{

		fn.copyright_info.style.borderColor='';
		}
		

		/*if(fn.server_name.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Server Name';

		fn.server_name.focus();

		fn.server_name.style.borderColor='red';

		return false;

		}else{

		fn.server_name.style.borderColor='';

		}*/

		/*if(fn.db_name.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Database Name';

		fn.db_name.focus();

		fn.db_name.style.borderColor='red';

		return false;

		}else{

		fn.db_name.style.borderColor='';

		}*/

		/*if(fn.db_user.value.length==0){

		document.getElementById('config_error').innerHTML='Enter DB User Name';

		fn.db_user.focus();

		fn.db_user.style.borderColor='red';

		return false;

		}else{

		fn.db_user.style.borderColor='';

		}*/

		/*if(fn.db_pwd.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Password';

		fn.db_pwd.focus();

		fn.db_pwd.style.borderColor='red';

		return false;

		}else{

		fn.db_pwd.style.borderColor='';

		}*/

}

</script>
<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 8px; margin-top: 10px;">

    <tr>

      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>System  Settings</strong></td>

    </tr> 

</table>
<?php if($msg <> ""){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;">
  <tr>
    <td width="2%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
    <td width="98%"><?php echo $msg; ?></td>
  </tr>
</table>
<?php } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
	  <form action="" method="post" name="global_form" id="global_form" >
        <tr>

          <td width="12%" valign="middle" style="padding-left: 4px;">Site Name: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="title" type="text" id="title" class="textbox" value="<?php echo $title;?>" size="61" /></td>
        </tr>

        <tr>

          <td valign="middle" style="padding-left: 4px;">Defult Title: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="default_title" id="default_title" type="text" class="textbox" value="<?php echo $default_title;?>" size="61"></td>
        </tr>

      

       

        <tr>

          <td valign="middle" style="padding-left: 4px;">SiteEmail: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="site_email"  type="text" id="site_email" class="textbox" value="<?php echo $site_email;?>" size="61"></td>
        </tr>


        

        

        <tr>

          <td rowspan="2" valign="top" style="padding-left: 4px;">Meta Contents:</td>

          <td width="18%" align="left" style="padding-left: 4px;"><strong>Descriptions</strong></td>

          <td width="70%" align="left" style="padding-left: 4px;"><strong>Keywords</strong></td>
        </tr>

        <tr>

          <td align="left" style="padding-left: 4px;"><textarea name="meta_tag" id="meta_tag" cols="26" rows="3" class="textbox" style="resize:none"><?php echo $meta_tag; ?></textarea></td>
          <td align="left" style="padding-left: 4px;"><textarea name="meta_keyword" id="meta_keyword" cols="26" rows="3" class="textbox" style="resize:none"><?php echo $meta_keyword; ?></textarea></td>
        </tr>

        <tr>

          <td width="12%" valign="top" style="padding-left: 4px;">Address: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><textarea name="address" id="address" rows="3" class="textbox" style="resize:none; width:380px;"><?php echo $address;?></textarea></td>
        </tr>
        <tr>

          <td width="12%" valign="top" style="padding-left: 4px;">Address(Ar): </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><textarea name="address_ar" id="address_ar" rows="3" class="textbox" style="resize:none; width:380px;"><?php echo $address_ar;?></textarea></td>
        </tr>
        <tr>

          <td width="12%" valign="middle" style="padding-left: 4px;">Copyright info(En): </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="copyright_info" id="copyright_info" type="text" class="textbox" value="<?php echo $copyright_info;?>" size="61"></td>
        </tr>
        <tr>

          <td width="12%" valign="middle" style="padding-left: 4px;">Copyright info(Ar): </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="copyright_info_ar" id="copyright_info_ar" type="text" class="textbox" value="<?php echo $copyright_info_ar;?>" size="61"></td>
        </tr>
		<tr>

          <td valign="middle" style="padding-left: 4px;">Phone no.: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="phone" id="phone" type="text" class="textbox" value="<?php echo $phone;?>" size="61"></td>
        </tr>
		<tr>

          <td valign="middle" style="padding-left: 4px;">Email: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="email" id="email" type="text" class="textbox" value="<?php echo $email;?>" size="61"></td>
        </tr>
		<tr>

          <td valign="middle" style="padding-left: 4px;">Fax: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="fax" id="fax" type="text" class="textbox" value="<?php echo $fax;?>" size="61"></td>
        </tr>
        <tr>

          <td height="44" colspan="3" align="left" style="padding-left: 4px;"><input type="submit" name="update" id="update" class="actionBtn" value="Modify" onclick="return validate_config()"></td>
        </tr>
	  </form>
</table>
</div>
