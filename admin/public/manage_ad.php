<?php
function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}

if(isset($_POST['save']))
{
	// post params
	$bnr_position = $_POST['bnr_position'];
	$bnr_type = $_POST['bnr_type'];
	$bnr_image = $_POST['bnr_image'];
	$bnr_href = $_POST['bnr_href'];
	$bnr_google_code =mysql_real_escape_string($_POST['bnr_google_code']);
	$status=1;
    $today=date("Y-m-d, H:i:s");
	
	$db->recordInsert(array('position'=>$bnr_position,"type"=>$bnr_type,"image_url"=>$bnr_image,"url"=>$bnr_href,
							'script'=>$bnr_google_code,'status'=>$status,'created_date'=>$today),ADVERTISEMENT);
							
	if(mysql_affected_rows() > 0)
	{
$msg="Banner With Script Added Sucessfully.......";

		$emp_id=mysql_insert_id();
		
		//image upload
$image=$_FILES['bnr_image']['name'];
 	//if it is not empty
 	if ($image) 
 	{
 	//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['bnr_image']['name']);
 	//get the extension of the file in a lower case format
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 	//if it is not a known extension, we will suppose it is an error and 
        // will not  upload the file,  
	//otherwise we will do more tests
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension !=
 "png") && ($extension != "gif")) 
 		{
		//print error message
 			echo '<h1>Unknown extension!</h1>';
 			//$errors=1;
 		}
 		else
 		{
//get the size of the image in bytes
 //$_FILES['image']['tmp_name'] is the temporary filename of the file
 //in which the uploaded file was stored on the server
 $size=filesize($_FILES['bnr_image']['tmp_name']);

//compare the size with the maxim size we defined and print error if bigger

//we will give an unique name, for example the time in unix time format
$image_name=$emp_id.'.'.$extension;
//the new name will be containing the full path where will be stored (images 
//folder)
	$directory="../upload/advertisement/";

$newname=$directory.$image_name;
//we verify if the image has been uploaded, and print error instead
$copied = copy($_FILES['bnr_image']['tmp_name'], $newname);
if (!$copied) 
{
	echo '<h1>Copy unsuccessfull!</h1>';
}
else
{
		$update=$db->recordUpdate(array("id" => $emp_id),array('image_url'=>$newname),ADVERTISEMENT);
		$msg="Banner With Image Added Sucessfully.......";
}

}}		//end
		
	}
	else
	{
		$errmsg="Account creation failed";
	}
}
//update
if(isset($_POST['update']))
{
	$errmsg='';
	$msg='';
	// Account Info
	$image=$_FILES['bnr_image']['name'];
 	//if it is not empty
 	if ($image) 
 	{
 		//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['bnr_image']['name']);
 		//get the extension of the file in a lower case format
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 		//if it is not a known extension, we will suppose it is an error and 
        // will not  upload the file,  
		//otherwise we will do more tests
 		if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 		{
			//print error message
 			echo '<h1>Unknown extension!</h1>';
 			//$errors=1;
 		}
 		else
 		{
			//get the size of the image in bytes
			 //$_FILES['image']['tmp_name'] is the temporary filename of the file
			 //in which the uploaded file was stored on the server
			 $size=filesize($_FILES['bnr_image']['tmp_name']);
			
			//compare the size with the maxim size we defined and print error if bigger
			
			//we will give an unique name, for example the time in unix time format
			$image_name=$_GET['id'].'.'.$extension;
			//the new name will be containing the full path where will be stored (images 
			//folder)
				$directory="../upload/advertisement/";
			
			$newname=$directory.$image_name;
			//we verify if the image has been uploaded, and print error instead
			$copied = copy($_FILES['bnr_image']['tmp_name'], $newname);
		}
	}
	
	$bnr_position = $_POST['bnr_position'];
	$bnr_type = $_POST['bnr_type'];
	$bnr_href = $_POST['bnr_href'];
	$bnr_google_code =  mysql_real_escape_string($_POST['bnr_google_code']);
	$bnr_image = $_POST['bnr_image'];
	$bnr_href =mysql_real_escape_string($_POST['bnr_href']);
	$today=date("Y-d-m,H:m:s");
	if($_GET['id']!="" and $bnr_type=="Image")
	{	
		if($image!='')
		{
			$update=mysql_query("update ".ADVERTISEMENT." set `position`='".$bnr_position."',`type`='".$bnr_type."',`url`='".$bnr_href."',`image_url`='".$newname."',
`script`='',`modified_date`='".$today."' where id='".$_GET['id']."'") or die(mysql_error());
		}
		else
		{
			$update=mysql_query("update ".ADVERTISEMENT." set `position`='".$bnr_position."',`type`='".$bnr_type."',`url`='".$bnr_href."',`script`='',`modified_date`='".$today."' where id='".$_GET['id']."'") or die(mysql_error());
		}
							
		if(mysql_affected_rows() > 0)
		{
			$msg="Banner updated successfully";
		}
		else
		{
			$errmsg=" No Banner updated Found!";
		}
	}
	if($_GET['id']!="" and $bnr_type=="Code")
	{	
		$image=mysql_fetch_assoc(mysql_query("select * from ".ADVERTISEMENT." where id='".$_GET['id']."'"));
		$image=$image['image_url'];
		
		$update=$db->recordUpdate(array("id" => $_GET['id']),array('position'=>$bnr_position,"type"=>$bnr_type, "image_url"=>"", "url"=>"",'script'=>$bnr_google_code,'modified_date'=>$today),ADVERTISEMENT);
		unlink($image);
		
		if(mysql_affected_rows() > 0)
		{
			$msg="Banner updated successfully";
		}
		else
		{
			$errmsg="Banner updated failed";
		}
	}
	//delete image
	if($_POST['banner_image_name_del']!='')
	{
		$var_del="";
		$update2=$db->recordUpdate(array("id" => $_GET['id']),array("image_url"=>$var_del),ADVERTISEMENT);
		$errmsg="";
		$msg="Banner updated successfully";
	}
}

//end



if(isset($_GET['id']))
{
	$result = mysql_fetch_object(mysql_query("select * from ".ADVERTISEMENT." where id = '".$_GET['id']."'"));
	//echo "hello";
}
?>

<script type="text/javascript">


function ValidateForm(form)
{
	var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

	ErrorText= "";
	
	if ( ( form.bnr_position[0].checked == false ) && ( form.bnr_position[1].checked == false ) && ( form.bnr_position[2].checked == false ))
	{
		alert ( "Please choose your Banner Position:" );
		return false;
	}
	if ( ( form.bnr_type[0].checked == false ) && ( form.bnr_type[1].checked == false ) )
	{
		alert ( "Please choose your Banner: Image or Script" );
		return false;
	}
	if (  form.bnr_type[0].checked == true  )
	{
		if(form.bnr_image.value == ""  && form.img_name.value=="")
		{
			alert ( "Please choose your Banner: Image " );
			return false;
		}
		else if(!pattern.test(form.bnr_href.value))
		{
			alert ( "Please Enter your valid Banner: Link" );
			return false;
		}
	}
	
	if (  form.bnr_type[1].checked == true  )
	{
		if(form.bnr_google_code.value == "" ){
			alert ( "Please Enter your Banner: Script " );
			return false;
		}
	}
	
	
	if (ErrorText= "") { form.submit() }
}


function checkUname(id)
{    
    $.ajax({
         type: "POST",
         url: "util/uname_ajax.php",
         data: "id=" + id,
         success: function(msg)
		 {
			$("#parent").html(msg);
		 }    
	});
}

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	else
	return true;
}

</script>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="border-bottom: 1px solid #CCC; margin-top: 20px;">
  <tr>
    <td style="padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #F98923;"><strong><?php if($_GET['id'] != "" && $task == "edit"){
    ?>Edit<?php }else{?>Add New<?php }?> Advertisement</strong></td>
    <td align="right" style="padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036; padding-right: 0px;"><a href="account.php?page=banner_list"><div class="actionBtn1" style="width:132px;">View All Advertisement</div></a></td>
  </tr>
</table>
<?php
if($msg <> ""){
	?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;">
  <tr>
    <td width="2%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
    <td width="98%"><?php echo $msg; ?></td>
  </tr>
</table>
<?php } ?>
<?php
if($errmsg <> ""){
	?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #900;">
  <tr>
    <td width="2%" valign="top"><img src="<?php echo IMG_PATH; ?>warning.png" width="24" height="24" /></td>
    <td width="98%"><strong>Opps !! Following Errors has beed detected</strong><br />
      <?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>
<form action="" method="post" name="form1" id="form1"  enctype="multipart/form-data" >
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
    <tr>
      <td valign="top" style="padding-right: 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Advertisement  Details</strong></td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding-top: 5px;"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td width="132" class="txtblack14">Position:</td>
                  <td width="680" class="tdData"><table><tr><td width="150"><input type="radio" name="bnr_position" value="Topright" alt="radio"  emsg="Please Select Position" 
				  <?php if($result->position=='Topright'){echo "checked" ;}?>/>
                    Top-Right  </td><td>&nbsp;(Adv width :320px)</td></tr>
					<tr><td width="150"><input type="radio" name="bnr_position" value="Bottomright" <?php if($result->position=='Bottomright'){echo "checked" ;}?>/>
                    Bottom-Right </td><td>&nbsp;(Adv width :320px)</td></tr>
					<tr><td width="150"><input type="radio" name="bnr_position" value="Bottomleft" <?php if($result->position=='Bottomleft'){echo "checked" ;}?>/>
                    Bottom-Left  </td><td>&nbsp;(Adv width :640px)</td></tr>
                    </table>
                                   </td>
                </tr>
                <tr>
                  <td width="132" class="txtblack14">Type:</td>
                  <td width="680" class="tdData"><table width="192">
                    <tr><td width="97"><input type="radio" alt="radio"  emsg="Please Select Banner Type" name="bnr_type" value="Image" onClick="javascript:document.form1.bnr_google_code.disabled=true;document.form1.bnr_image.disabled=false;document.form1.bnr_href.disabled=false;document.form1.bnr_href.alt='blank';document.form1.bnr_google_code.alt='';document.form1.bnr_image.alt='file|jpg,gif,bmp,png,tiff,JPG,GIF,BMP,PNG,TIFF,|0';document.form1.bnr_image_tr.alt='file|jpg,gif,bmp,png,tiff,JPG,GIF,BMP,PNG,TIFF,|0';" <?php if($result->type=="Image"){echo "checked";}?> />
                    Image+URL</td>
                   <td width="80"> <input type="radio" name="bnr_type" value="Code" onClick="javascript:document.form1.bnr_google_code.disabled=false;document.form1.bnr_image.disabled=true;document.form1.bnr_href.disabled=true;document.form1.bnr_href.alt='';document.form1.bnr_google_code.alt='blank';document.form1.bnr_image.alt='';" <?php if($result->type== "Code"){echo "checked";}?> /> Script</td></tr></table>
                   
                  <?php //=enum_dropdown("pr_bnr", "bnr_type", "bnr_type", $bnr_type)?></td>
                </tr>
              <?php
			  $bnr_image=$result->image_url;
			   if($bnr_image!='') { //echo $bnr_image; ?>
                <tr>
                  <td width="132" class="txtblack14">Current Banner  :</td>
                  <td width="680" class="tdData"><?php if($bnr_image!='') {?> <img src="<?php echo $bnr_image;?>" height="50" width="62"/><?php }?><br>
                    Delete
                  <input type="checkbox" name="banner_image_name_del" value="1">
</td>
                </tr>
				 <?php }?>
				 <input type="hidden" name="img_name" value="<?php echo $bnr_image;?>">
                <tr>
                  <td width="132" class="txtblack14">Image  :</td>
                  <td width="680" class="tdData"><input name="bnr_image" class="textfield_edit" type="file" id="bnr_image"  emsg="Photo file is required"  size="40"></td>
                </tr>
				
          		 <tr>
                  <td width="132" class="txtblack14">Link:</td>
                  <td width="680" class="tdData"><input name="bnr_href" type="text" id="bnr_href" value="<?php echo $result->url; ?>"  size="40"  class="generalTextBox" <?php if($result->type=='Code')echo 'disabled="disabled"';?> placeholder="Type http:// at begeining.." ></td>
                </tr>
                <tr>
                  <td width="132" class="txtblack14">Embed code:</td>
                  <td width="680" class="tdData"><textarea name="bnr_google_code" id="bnr_google_code"  rows="5" cols="50"  class="textarea_edit" <?php if($result->type=='Image')echo 'disabled="disabled"';?>><?php echo stripslashes($result->script);?>
</textarea></td>
                </tr>
              </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding-top: 5px;"></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
        </table></td>
    </tr>
    <tr>
      <td valign="top" style="padding-top: 5px;"><?php
	if($_GET['id'] != "" && $task == "edit"){
    ?>
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn"  onClick= "return ValidateForm(this.form)"  >
        <?php }else{ ?>
        <input type="submit" name="save" id="save" value="Save" class="actionBtn" onClick= "return ValidateForm(this.form)">
        <?php } ?>
        <a href="account.php?page=banner_list" style="text-decoration:none">
        <span class="actionBtn">Cancel</span>
        </a></td	>
    </tr>
  </table>
</form>

