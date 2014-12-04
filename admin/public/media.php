<?php
function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
if(isset($_POST['update']))
{
	
		
		$rr="/".$_GET['part'];
	unset($_POST['update']);
	$_POST['title'] = trim(addslashes($_POST['title']));
	$_POST['title_ar'] = trim(addslashes($_POST['title_ar']));
	$_POST['script'] = trim(addslashes($_POST['script']));
	//$_POST['url'] = trim(addslashes($_POST['url']));
	$type=$_POST['type'];
	// logo image
	$video_file = basename($_FILES['video_file']['name']);
	$dir = "../upload/video/";
	$tmp_name = $_FILES['video_file']['tmp_name'];
	$_POST['video_file'] = ($video_file != "")?time().$video_file:'';
	if(empty($_POST['video_file']) || $_POST['video_file'] == ""){unset($_POST['video_file']);}
	
	// update record
	if($db->recordUpdate(array("id" => $id),$_POST,MEDIATBL) == 1){
	if($_POST['video_file'] != ""){move_uploaded_file($tmp_name,$dir.$_POST['video_file']);}
	$msg="Updated sucessfully....";
	}
	else
	{	$errmsg="Error in updation.....";
	}
}
 

if(isset($_POST['save']))
{
	unset($_POST['save']);

	// post params
	$_POST['title'] = trim(addslashes($_POST['title']));
	$_POST['title_ar'] = trim(addslashes($_POST['title_ar']));
	$_POST['script'] = trim(addslashes($_POST['script']));
	//$_POST['url'] = trim(addslashes($_POST['url']));
	
	// Video File
	$video_file = basename($_FILES['video_file']['name']);
	$dir = "../upload/video/";
	$tmp_name = $_FILES['video_file']['tmp_name'];
	$_POST['video_file'] = ($video_file != "")?time().$video_file:'';
	$photo_new=($video_file != "")?time().$video_file:'';
	// save record
	$result= $db->recordInsert($_POST,MEDIATBL,'');
	//$lipu=mysql_error();
	//echo $lipu;
	if($result == 1){
	if($photo_new!= ""){move_uploaded_file($tmp_name,$dir.$photo_new);}
		$msg="Media Added Sucessfully.....";
	}else if($result == 2){
	$errmsg="Error in Media add...";
	}
	}



if(isset($_GET['id']))
{
	$result = mysql_fetch_object(mysql_query("select * from ".MEDIATBL." where id = '".$_GET['id']."'"));
	//echo "hello";
}
	if($_GET['id'] != "" && $_GET['task'] == "edit"){?>
	
<script type="text/javascript">


function ValidateForm(form){
ErrorText= "";

if (  form.title.value == ""  )
{
alert ( "Please Enter your Media: Title " );
	$("#title").css("border-color","#F00");
	$("#title").focus();
return false;
}
if (  form.title_ar.value == ""  )
{
alert ( "Please Enter your Media: Title (AR)" );
	$("#title_ar").css("border-color","#F00");
	$("#title_ar").focus();
return false;
}

if ( ( form.type[0].checked == false ) && ( form.type[1].checked == false ) )
{
alert ( "Please choose your Media: File or Script" );
return false;
}
if (  form.type[0].checked == true  )
{
if(form.script.value == "" ){
alert ( "Please choose your Media: Script " );
	$("#script").css("border-color","#F00");
	$("#script").focus();

return false;
}

}


if (ErrorText= "") { form.submit() }
}</script>
	
	
	
	<?php }else {?>

<script type="text/javascript">


function ValidateForm(form){
ErrorText= "";

if (  form.title.value == ""  )
{
alert ( "Please Enter your Media: Title " );
	$("#title").css("border-color","#F00");
	$("#title").focus();
return false;
}
if (  form.title_ar.value == ""  )
{
alert ( "Please Enter your Media: Title (AR)" );
	$("#title_ar").css("border-color","#F00");
	$("#title_ar").focus();
return false;
}

if ( ( form.type[0].checked == false ) && ( form.type[1].checked == false ) )
{
alert ( "Please choose your Media: File or Script" );
return false;
}
if (  form.type[0].checked == true  )
{
if(form.script.value == "" ){
alert ( "Please choose your Media: Script " );
	$("#script").css("border-color","#F00");
	$("#script").focus();

return false;
}

}

if (  form.type[1].checked == true  )
{
if(form.video_file.value == "" ){
alert ( "Please Enter your Media: File " );
	$("#video_file").css("border-color","#F00");
	$("#video_file").focus();
return false;
}
}



if (ErrorText= "") { form.submit() }
}</script>

<?php }?>

<script type="text/javascript">
function isUrl(s) {
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(s);
}
// call event for delete, active and inactive record in bulk

// fade out messages
var fade_out = function() {
  $("#errorDiv").fadeOut().empty();
}
setTimeout(fade_out, 2000);
function hideuploadpath(){
document.getElementById("video_file").disabled=true;
document.getElementById("script").disabled=false;	
document.getElementById("video_file").value='';
	}
function hidescriptpath(){
document.getElementById("video_file").disabled=false;
document.getElementById("script").disabled=true;
document.getElementById("script").value='';				
		}
$(document).ready(function(e) {
	<?php if($_GET['task']!='edit'){?>
document.getElementById("script").disabled=true; 
document.getElementById("video_file").disabled=false;   
<?php }?>
});	

 $(document).ready(function() {
$(".videos").live('change',function() {
    var val = $(this).val();

    switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
        case 'mp4':  case 'wmv':case 'flv':
            break;
        default:
            $(this).val('');
            // error message here
            alert("Only mp4, flv and wmv files are allowed to upload.");
            break;
    }
});
 });	
</script>

<table width="700" border="0" align="center" cellpADing="3" cellspacing="0" style="border-bottom: 1px solid #CCC; margin-top: 20px;">
  <tr>
    <td style="pADing-bottom: 5px; pADing-left: 0px; font-size: 14px; color: #036;"><strong>Media Videos</strong></td>
    <td align="right" style="pADing-bottom: 5px; pADing-left: 0px; font-size: 14px; color: #036; pADing-right: 0px;"><a href="account.php?page=view_media"><div class="button_admin">View All Media</div></a></td>
  </tr>
</table>
<?php
if($msg <> "" or $_GET['mms']!=""){
	?>
<table width="700" border="0" align="center" cellpADing="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;">
  <tr>
    <td width="2%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
    <td width="98%"><?php echo $msg.$_GET['mms']; ?></td>
  </tr>
</table>
<?php } ?>
<?php
if($errmsg <> "" || $_GET['errmsg']!="" ){
	?>
<table width="700" border="0" align="center" cellpADing="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #900;">
  <tr>
    <td width="2%" valign="top"><img src="<?php echo IMG_PATH; ?>warning.png" width="24" height="24" /></td>
    <td width="98%"><strong>Opps !! Following Errors has beed detected</strong><br />
      <?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>
<form action="" method="post" name="form1" id="form1"  enctype="multipart/form-data">
  <table width="700" border="0" align="center" cellpADing="0" cellspacing="0" style="margin-top: 8px;">
    <tr>
      <td valign="top" style="padding-right: 10px;">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
	  <tr>
          <td align="right" class="txtblack14"><strong>Title (En): </strong></td>
          <td class="tdData"><input name="title" type="text" id="title" value="<?php echo $result->title; ?>"  size="48"  class="textfield_edit" /></td>
        </tr>
	  <tr>
          <td align="right" class="txtblack14"><strong>Title (Ar): </strong></td>
          <td class="tdData"><input name="title_ar" type="text" id="title_ar" value="<?php echo $result->title_ar; ?>"  size="48"  class="textfield_edit" /></td>
        </tr>
		
		<tr>
                  <td align="right" class="txtblack14"><strong>Video Type:</strong></td>
                  <td>
<input type="radio" name="type" id="radio" value="Script" <?php if($result->type == 'Script'){ echo "checked"; } ?>  onclick="hideuploadpath()"/>
                        Embed Code 
 <input type="radio" name="type" id="radio2" value="File" <?php if($result->type == 'File') {echo "checked";} else if($result->type != 'Script'){echo "checked";} ?> onclick="hidescriptpath()" >
Video File </td>
          </tr>
				
				<tr>
                  <td align="right" valign="top"  class="txtblack14"><strong>Embed Code:</strong></td>
                  <td  class="tdData"><textarea name="script" id="script"  rows="5" cols="50"  class="textarea_edit" <?php if($result->type != 'Script'){?> disabled="disabled" <?php  }?>><?php echo stripslashes($result->script);?>
</textarea></td>
                </tr>
				
				
				<tr>
                      <td align="right" valign="middle" ><strong>Upload Video File:</strong></td>
                      <td valign="top"><input name="video_file" type="file" class="input videos" id="video_file" 
					  <?php if($result->type != 'File' and $result->type != ''){?> disabled="disabled" <?php  }?>/></td>
                      
          </tr>
          <tr>
          <td></td>
          <td><span style="color:#FF0000">Note</span>:upload Only FLV and MP4 format video file.</td>
          </tr>
				
		</table></td>
    </tr>
    <tr>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpADing="0">
          <tr>
            <td style="pADing-top: 5px;"></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
        </table></td>
    </tr>
    <tr>
      <td valign="top" style="padding-top: 5px; padding-left:150px;"><?php
	if($_GET['id'] != "" && $_GET['task'] == "edit"){
    ?>
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn" onClick= "return ValidateForm(this.form)">
        <?php }else{ ?>
        <input type="submit" name="save" id="save" value="Save" class="actionBtn" onClick= "return ValidateForm(this.form)">
        <?php } ?>
        <a href="account.php?page=view_media" style="text-decoration:none">
        Cancel
        </a></td>
    </tr>
  </table>
</form>

