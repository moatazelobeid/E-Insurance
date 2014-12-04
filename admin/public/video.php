<?php
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 
//chk language
if($_GET['lang']==1){
		$red1='en';
		}else if($_GET['lang']==2){
		$red1='ge';
		}else if($_GET['lang']==3){
		$red1='sp';
		}else if($_GET['lang']==4){
		$red1='fr';
		} 
		//chk part
if($_GET['part']!=''){
		$partredirect="/".$_GET['part'];
		}
		
// save record
if(isset($_POST['save']))
{
	//For page redirect 
	if($_POST['lang_id']==1){
		$red='en';
		}else if($_POST['lang_id']==2){
		$red='ge';
		}else if($_POST['lang_id']==3){
		$red='sp';
		}else if($_POST['lang_id']==4){
		$red='fr';
		}
	// filter params not to save
	unset($_POST['save']);
	$_POST['video_title'] = trim(addslashes($_POST['video_title']));
	$_POST['video_script'] = trim(addslashes($_POST['video_script']));
	//$_POST['url'] = trim(addslashes($_POST['url']));
	
	// Video File
	$video_file = basename($_FILES['video_file']['name']);
	$dir = "../upload/video/";
	$tmp_name = $_FILES['video_file']['tmp_name'];
	$_POST['video_file'] = ($video_file != "")?time().$video_file:'';
	
	// save record
	$result = $db->recordInsert($_POST,VIDEOTBL,'');
	if($result == 1){
	if($_POST['video_file']!= ""){echo move_uploaded_file($tmp_name,$dir.$_POST['video_file']);}
	echo "<script>alert('Video Saved Sucessfully');location.href='".BASEPATH."video/".$red."';</script>";
	}else if($result == 2){
	echo "<script>alert('Video Saving Failed');location.href='".BASEPATH."video/add';</script>";
	}
}

// Record Update
if(isset($_POST['update']))
{
	//For page redirect 
	if($_POST['lang_id']==1){
		$red='en';
		}else if($_POST['lang_id']==2){
		$red='ge';
		}else if($_POST['lang_id']==3){
		$red='sp';
		}else if($_POST['lang_id']==4){
		$red='fr';
		}
		
		if($_GET['part']!='')
		$rr="/".$_GET['part'];
	unset($_POST['update']);
	$_POST['video_title'] = trim(addslashes($_POST['video_title']));
	$_POST['video_script'] = trim(addslashes($_POST['video_script']));
	//$_POST['url'] = trim(addslashes($_POST['url']));
	
	// logo image
	$video_file = basename($_FILES['video_file']['name']);
	$dir = "../upload/video/";
	$tmp_name = $_FILES['video_file']['tmp_name'];
	$_POST['video_file'] = ($video_file != "")?time().$video_file:'';
	if(empty($_POST['video_file']) || $_POST['video_file'] == ""){unset($_POST['video_file']);}
	
	// update record
	if($db->recordUpdate(array("id" => $id),$_POST,VIDEOTBL) == 1){
	if($_POST['video_file'] != ""){move_uploaded_file($tmp_name,$dir.$_POST['video_file']);}
	echo "<script>alert('Video Updated Sucessfully');location.href='".BASEPATH."video/".$red.$rr."';</script>";
	}else
	echo "<script>alert('Video Updation Failed');location.href='".BASEPATH."video/edit/".$id."/".$red.$rr."';</script>";
}


if($task == "edit" && $id != "")
{
	// get all data
	$datalist = $db->recordFetch($id,VIDEOTBL.":".'id');
}

// delete individual countys
if($id != "" && $_GET['task'] == "delete")
{
	if($_GET['part']!='')
$partredirect1="/".$_GET['part'];
	if($db->recordDelete(array(id => $id),VIDEOTBL) == 1){
	$record = $db->recordFetch($id,VIDEOTBL.":".'id');
	unlink("../upload/video/".getElementVal('video_file',$record));
	// delete county login record
	echo "<script>alert('Record Deleted Sucessfully');location.href='".BASEPATH."video/".$_GET['lang'].$partredirect1."';</script>";
	}
}

// Set home page video  
if($id != "" && $_GET['task'] == "set")
{
	if($_GET['part']!='')
$partredirect1="/".$_GET['part'];
if($_GET['lang']=='en'){
		$st=1;
		}else if($_GET['lang']=='ge'){
		$st=2;
		}else if($_GET['lang']=='sp'){
		$st=3;
		}else if($_GET['lang']=='fr'){
		$st=4;
		} 


	if(mysql_query("update ".VIDEOTBL." set for_homepage='1' where id='".$id."' and lang_id='".$st."'")){
		mysql_query("update ".VIDEOTBL." set for_homepage='0' where id!='".$id."' and lang_id='".$st."'");
	echo "<script>alert('Home Page Video Set Sucessfully');location.href='".BASEPATH."video/".$_GET['lang'].$partredirect1."';</script>";
	}else{
	echo "<script>alert('Home Page Video Set failed');location.href='".BASEPATH."video/".$_GET['lang'].$partredirect1."';</script>";
		
		}
	
}
// Unset home page video  
if($id != "" && $_GET['task'] == "unset")
{
	if($_GET['part']!='')
$partredirect1="/".$_GET['part'];
if($_GET['lang']=='en'){
		$st=1;
		}else if($_GET['lang']=='ge'){
		$st=2;
		}else if($_GET['lang']=='sp'){
		$st=3;
		}else if($_GET['lang']=='fr'){
		$st=4;
		} 


	if(mysql_query("update ".VIDEOTBL." set for_homepage='0' where id='".$id."' and lang_id='".$st."'")){
			echo "<script>alert('Home Page Video UnSet Sucessfully');location.href='".BASEPATH."video/".$_GET['lang'].$partredirect1."';</script>";
	}else{
	echo "<script>alert('Home Page Video UnSet failed');location.href='".BASEPATH."video/".$_GET['lang'].$partredirect1."';</script>";
		
		}
	
}


// delete all countys
if(isset($_POST['todo'])){
	// case
	//chk part
	if($_GET['part']!=''){
		$partid="/".$_POST['part_id'];
		}
	switch($_POST['todo']){
		case 'deleteall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete county record
				if($db->recordDelete(array(id => $id),VIDEOTBL) == 1){
					$record = $db->recordFetch($id,VIDEOTBL.":".'id');
					unlink("../upload/video/".getElementVal('video_file',$record));
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='".BASEPATH."video/".$_POST['lang-name'].$partid."';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='".BASEPATH."video/".$_POST['lang-name'].$partid."';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='".BASEPATH."video/".$_POST['lang-name'].$partid."';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete county record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),VIDEOTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='".BASEPATH."video/".$_POST['lang-name'].$partid."';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='".BASEPATH."video/".$_POST['lang-name'].$partid."';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='".BASEPATH."video/".$_POST['lang-name'].$partid."';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete county record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),VIDEOTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='".BASEPATH."video/".$_POST['lang-name'].$partid."';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='".BASEPATH."video/".$_POST['lang-name'].$partid."';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='".BASEPATH."video/".$_POST['lang-name'].$partid."';</script>";
		}
		break;
	}
}
$lang=mysql_query("SELECT * FROM ".LANGUAGETBL." ORDER BY id DESC ");

//Record fetch based on language
if($_GET['lang']=='1'){
	     $langid="where lang_id=1";
	}else if($_GET['lang']=='2'){
		$langid="where lang_id=2";
	}else if($_GET['lang']=='3'){
		$langid="where lang_id=3";
	}else if($_GET['lang']=='4'){
		$langid="where lang_id=4";
	}else{
		$langid='';
		}
$rs=mysql_query("SELECT * FROM ".VIDEOTBL." ".$langid."  ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
?>
<script type="text/javascript">
function check_all()
{
	var num_tot = document.getElementsByName('chkNo[]').length;
	var l,m;
	if(document.getElementById("chkAll").checked == true)
	{
		// enable group add/edit/delete buttons
		for(l=1;l<=num_tot;l++)
		{
			obj = document.getElementById('chkNo'+l);
			document.getElementById("chkNo" + l).checked = true;
		}
	}else{
		// disable group add/edit/delete buttons
		for(m=1;m<=num_tot;m++)
		{
			document.getElementById("chkNo" + m).checked = false;
		}
	}
}
function check_single(checkid){
	var num_tot = document.getElementsByName('chkNo[]').length;
	var l,m;
	var flag = 0;
	if(document.getElementById(checkid).checked == true)
	{
		for(l=1;l<=num_tot;l++){
			if(document.getElementById("chkNo" + l).checked == true)
			flag++;
		}
		if(flag == 1){
		}
	}else{
		for(l=1;l<=num_tot;l++){
			if(document.getElementById("chkNo" + l).checked == true)
			flag++;
		}
		if(flag == 0){
		// disable group add/edit/delete buttons
		}
	}
}
</script>
<script type="text/javascript">
function validateManager()
{
if($("#video_title").val()==0){
	alert('Enter Video Title');
	$("#video_title").css("border-color","#F00");
	$("#video_title").focus();
	return false;
	}

if($('input:radio[name=radio]:checked').val()=='File'){
	if($("#video_file").val()==0){
	alert("Select file");
	$("#video_file").css("border-color","#F00");
	$("#video_file").focus();
	return false;
	}
	}else if($('input:radio[name=radio]:checked').val()=='Script'){
        if($("#video_script").val()==0){
		 alert("Enter Script");
         $("#video_script").css("border-color","#F00");
         $("#video_script").focus();
	     return false;
		}
		}

	
}
function isUrl(s) {
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(s);
}
// call event for delete, active and inactive record in bulk
function doAction(action){
	switch(action){
		case 'delete':
		var flag = confirm("Are you sure to delete?");
		if(flag){
		document.subject_fr.todo.value='deleteall';
		document.subject_fr.submit();
		}
		break;
		
		case 'active':
		document.subject_fr.todo.value='publishall';
		document.subject_fr.submit();
		break;
		
		case 'inactive':
		document.subject_fr.todo.value='unpublishall';
		document.subject_fr.submit();
		break;
	}
}
// fade out messages
var fade_out = function() {
  $("#errorDiv").fadeOut().empty();
}
setTimeout(fade_out, 2000);
function hideuploadpath(){
document.getElementById("video_file").disabled=true;
document.getElementById("video_script").disabled=false;	
document.getElementById("video_file").value='';
	}
function hidescriptpath(){
document.getElementById("video_file").disabled=false;
document.getElementById("video_script").disabled=true;
document.getElementById("video_script").value='';				
		}
$(document).ready(function(e) {
	<?php if($task!='edit'){?>
document.getElementById("video_script").disabled=true; 
document.getElementById("video_file").disabled=false;   
<?php }?>
});	

 $(document).ready(function() {
$(".videos").live('change',function() {
    var val = $(this).val();

    switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
        case 'mp4': case 'flv': case 'wmv':
            break;
        default:
            $(this).val('');
            // error message here
            alert("Only mp4, flv and wmv files are allowed to upload.");
            break;
    }
});
 });	
 function changeLang(url){
	 var urllink
       if(url == '1')
	   {
	    urllink ="<?php echo BASEPATH;?>video/en";
	   }else if(url == '2'){
	    urllink ="<?php echo BASEPATH;?>video/ge";
	   }else if(url == '3'){
	    urllink ="<?php echo BASEPATH;?>video/sp";
	   }else if(url == '4'){
	    urllink ="<?php echo BASEPATH;?>video/fr";
	   }
	   document.location=urllink;	
	
	}

</script>

<div class="bodyarea_inner">
    <div class="where" style="font-weight: normal;">
    <span class="admin1">Dashboard</span> » Contents » Videos</div>
</div>

<div class="mask" style="height:1px;"><img src="<?php echo BASEPATH; ?>images/mask.gif" alt="mask" title="mask" /></div>  
<div id="body">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>

<td valign="top" width="150">
<div class="body_leftbox">
<div class="mask" style="height:4px;"><img src="<?php echo BASEPATH; ?>images/mask.gif" alt="mask" title="mask" /></div>
<div class="body_leftboxtitle">Navigation</div>
<div class="mask" style="height:2px;"><img src="<?php echo BASEPATH; ?>images/mask.gif" alt="mask" title="mask" /></div>
<div class="bodyarea_left2" style="float: none;">
       <div class="box">
       
        <ul>
            <li><a href="<?php echo BASEPATH; ?>video/en" <?php if($task != "add") echo 'class="active"'; ?>>» All Videos</a></li>
            <li><a href="<?php echo BASEPATH; ?>video/add" <?php if($task == "add" || ($task == "edit" && is_numeric($id) != "")) echo 'class="active"'; ?>>» Add New Video</a></li>
        </ul>
    </div>
    </div>
    </div>
</td>

<td valign="top">

<?php
if($task == "add" || ($task == "edit" && is_numeric($id) != "")){
	
	?>
  <?php
if($msg <> ""){
	?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; line-height: 15px; color: #666;">
  <tr>
    <td width="6%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
    <td width="94%"><?php echo $msg; ?></td>
  </tr>
</table>
<?php } ?>
<?php
if($errmsg <> ""){
	?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; line-height: 15px; color: #900;" id="errorDiv">
  <tr>
    <td width="6%" valign="top"><img src="<?php echo IMG_PATH; ?>warning.png" width="24" height="24" /></td>
    <td width="94%"><strong>Opps !! Following Errors has beed detected</strong><br />
      <?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
      <div class="body_leftbox" style="margin-right: 0px;">
        <div class="body_midboxtitle">Add/Edit Video</div>
        <div class="mask" style="height:2px;"><img src="<?php echo BASEPATH; ?>images/mask.gif" alt="mask" title="mask" /></div>
        <div class="bodyarea_main_inner">
          
          <div style="margin:5px;">
            <div class="box">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="add">
                <form method="post" action="" id="form1" enctype="multipart/form-data" name="s_fr" onSubmit="return validateManager();">                           
                  <tbody>
                  <tr class="tr1">
                    <th width="109">Language<span class="red">*</span></th>
                    <td colspan="2">
                      <span class="error"></span>
                      <select name="lang_id" class="required" style="width:200px;" id="select" onchange="fetchlang(this.value)">
                      <?php while($langs = mysql_fetch_assoc($lang)){ ?>
                      <option value="<?php echo $langs['id']; ?>" <?php if(getElementVal('lang_id',$datalist) == $langs['id']) echo "selected='selected'"; ?>>
					  <?php echo $langs['language']; ?></option>
                      <?php } ?>
                      </select>
                    </td>
                    </tr>
                    <tr class="tr1">
                      <th width="128">Video Title<span class="red">*</span></th>
                      <td width="402"><input name="video_title" type="text" class="input" id="video_title" style="width: 400px; font-weight: normal;" value="<?php echo stripslashes(getElementVal('video_title',$datalist)); ?>" /></td>
                      <td width="538" class="note">For CMS reference only</td>
                      </tr> 
                    <tr>
                      <th>Video Type</th>
                      <td>
<input type="radio" name="video_type" id="radio" value="Script" <?php if(getElementVal('video_type',$datalist) == 'Script') echo "checked"; ?>  onclick="hideuploadpath()"/>
                        Script 
 <input type="radio" name="video_type" id="radio2" value="File" <?php if(getElementVal('video_type',$datalist) == 'File') echo "checked"; ?> onclick="hidescriptpath()" <?php if($_GET['task']=='add'){?>checked="checked" <?php }?>>
File </td>
                      <td class="note">&nbsp;</td>
                    </tr>
                    <tr>
                      <th valign="top">Script:</th>
                      <td><textarea name="video_script" rows="6" class="input" id="video_script" style="width: 400px; font-weight: normal; font-size: 12px;" <?php if(getElementVal('video_type',$datalist) != 'Script'){?> disabled="disabled" <?php  }?>><?php echo stripslashes(getElementVal('video_script',$datalist)); ?></textarea></td>
                      <td valign="top" class="note">Copy and paste external/embeded (Like Youtube) video scripts to the box<br />
(Adjust width and height in video script with 288 x 221)</td>
                    </tr>
                    <tr>
                      <th valign="top">Upload Video<span class="red">*</span></th>
                      <td valign="top"><input name="video_file" type="file" class="input videos" id="video_file" <?php if(getElementVal('video_type',$datalist) != 'File'){?> disabled="disabled" <?php  }?>/></td>
                      <td><?php if(getElementVal('video_file',$datalist) != "") echo "<img src='".str_replace($admin_folder,"",BASEPATH)."upload/video/".getElementVal('video_file',$datalist)."' width='180' height='60' />"; ?></td>
                    </tr>
                    <tr>
                      <th>Status</th>
                      <td>
                        <span class="error"></span>
                        <select name="status" class="select" id="status" style="width: 217px; font-weight: normal;">
                          <option value="1" <?php if(getElementVal('status',$datalist) == '1') echo "selected='selected'"; ?>>Active</option>
                          <option value="0" <?php if(getElementVal('status',$datalist) == '0') echo "selected='selected'"; ?>>Inactive</option>
                          </select>
                        </td>
                      <td>&nbsp;</td>
                    </tr> 
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="2" class="submit"><span style="padding-left: 0px;padding-top: 10px;">
                        <?php

	if($id != "" && $task == "edit"){

    ?>
                        <input type="submit" name="update" id="update" value=" Update Video" class="button">
                        <?php }else{ ?>
                        <input type="submit" name="save" id="save" value=" Add Video" class="button">
                        <?php } ?>
                        </span></td>
                      </tr> 
                    
                    </tbody>
                  </form>
                </table>
              </div>
            </div>
          </div>
        </div>
    </td>
    </tr>
</table>
    <?php
}else{
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
<div class="body_rightbox">
           <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="31%"><div class="body_midboxtitle">List All Videos</div></td>
     <td width="54%" align="right" style="padding-right: 12px; color: #CCC; word-spacing: 6px;" class="body_midboxlink">Select Langugae:
          <select name="lan_id1" id="select" class="select" style="padding: 0px; font-size: 11px;" onchange="changeLang(this.value);">
            <?php 
			$lang=mysql_query("SELECT * FROM ".LANGUAGETBL." ORDER BY id DESC");
			if(mysql_num_rows($lang) > 0){
			while($langs = mysql_fetch_assoc($lang)){ ?>
            <option value="<?php echo $langs['id']; ?>" <?php if($_GET['lang']==$langs['id']){?> selected="selected" <?php }?>> <?php echo $langs['language']; ?></option>
            <?php }} ?>
          </select>
    </td>
    <td width="69%" align="right" style="padding-right: 12px; color: #666; word-spacing: 6px;" class="body_midboxlink"><a href="javascript:doAction('delete');">Delete</a> | <a href="javascript:doAction('active');">Active</a> | <a href="javascript:doAction('inactive');">Inactive</a></td>
  </tr>
</table>
           <div class="mask" style="height:2px;"><img src="<?php echo BASEPATH; ?>images/mask.gif" alt="mask" title="mask" /></div>
           
           <div class="bodyarea_main_inner">
           <div style="margin:5px;">
          
           <form action="" method="post" name="subject_fr" style="padding: 0px; margin: 0px;">
           <input type="hidden" name="checked_id" id="checked_id" value=""/>
           <input type="hidden" name="todo" id="todo" value=""/>
            <input type="hidden" name="lang-name" id="lang-name" value="<?php echo $red1;?>"/>
             <input type="hidden" name="part_id" id="part_id" value="<?php echo $_GET['part'];?>"/>
           <table width="100%" class="list" border="0" cellpadding="0" cellspacing="0">
                <tbody><tr class="tr2">
                    <th width="3%"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></th>
                    <th width="4%">SL#</th>
                    <th width="21%">Video Title</th>
                    <th>View</th>
                    <th>Set For Home Pgae</th>
                    <th width="9%">Type</th>
                    <th width="7%">Status</th>
                    <th width="9%">Create Date</th>
                    <th colspan="2">Manage</th>
                    </tr>
					<?php
                   
                    if(mysql_num_rows($rs) > 0){
                    $i=0;
                    while($row=mysql_fetch_array($rs)){
                    $i++;
                    ?>
                                            <tr class="tr0">
                    <td align="center" valign="middle" class="center"><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');"/></td>
                    <td align="center"><?php echo $i;?></td>
                    <td><?php echo stripslashes($row["video_title"]); ?></td>
                    <td align="center">
                    <a href="<?php echo BASEPATH?>public/video_view.php?id=<?php echo $row['id']; ?>" class="video_view"><img src="<?php echo BASEPATH; ?>images/view_button.gif" border="0" style="cursor: pointer;" title="View Details"/></a>
                    </td>
                    <td align="center"><?php if($row['for_homepage']=='0'){?><a href="<?php echo BASEPATH."video/set/".$row['id']."/".$red1.$partredirect;?>" title="Set Now"  style="text-decoration:none"><strong>Set</strong></a><?php }else{?><a href="<?php echo BASEPATH."video/unset/".$row['id']."/".$red1.$partredirect;?>" title="UnSet Now" style="text-decoration:none"><strong>Un Set</strong></a><?php }?></td>
                    <td align="center"><?php echo $row["video_type"]; ?></td>
                    <td align="center"><?php if($row['status'] == 0) echo "Inactive"; else echo "Active"; ?></td>
                    <td align="center"><?php echo date("d/m/Y",strtotime($row["create_date"])); ?></td>
                    <td width="3%" align="center" class="center"><a href="<?php echo BASEPATH.'video/edit/'.$row['id']."/".$red1.$partredirect;?>"><img src="<?php echo BASEPATH; ?>images/ico_edit.png" border="0" style="cursor: pointer;" title="Edit"></a></td>
                    <td width="3%" align="center" class="center"><a href="<?php echo BASEPATH.'video/delete/'.$row['id']."/".$red1.$partredirect;?>""><img src="<?php echo BASEPATH; ?>images/ico_delete.png" border="0" style="cursor: pointer;" onclick="return confirm('Are you sure to delete?');" title="Delete"></a></td>
                </tr>
                
                <?php }}else{
			?>
            <tr class="tr0">
                    <td colspan="10" align="center" valign="middle" class="center" style="padding: 6px;">No Videos Listed</td>
                    </tr>
            <?php
		}?>
             </tbody></table>
             </form>
             <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 7px;">
 <tr><td width="4%" style="padding-left: 10px;"><img src="<?php echo BASEPATH; ?>images/arrow_point.gif" width="38" height="20" /></td>
   <td width="91%"><button onclick="javascript:doAction('delete');"><img src="<?php echo BASEPATH?>images/delete.gif" align="absmiddle" style="padding-bottom:2px;">Delete</button>  
   
   </td>
 <td width="5%" align="right"><?php  echo Ftr_Paging(VIDEOTBL,$perpage,BASEPATH."video/".$red1,"lang_id=".$_GET['lang']); ?></td></tr>
 </table>
            </div>
          </div>
            
        </div>
</td>
    </tr>
</table>
<?php } ?>

</td>
</tr>    
</tbody></table>

</div>