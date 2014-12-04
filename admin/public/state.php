<?php
if(isset($_POST['save']))
{
	// filter params not to save
	unset($_POST['save']);
	//print_r($datas);
	// check for duplicate record
	if($db->isExists('state','cat_id',$_POST,STATE)){
		$errmsg = "- State title already exists";
	}else{
	// save record
	$_POST['state'] = addslashes($_POST['state']); 
	$_POST['state_ar'] = addslashes($_POST['state_ar']);
	$result = $db->recordInsert($_POST,STATE,'');
	
	$recordId = mysql_insert_id();
	if($result == 1)
	{
		echo "<script>alert('state Saved Sucessfully');location.href='account.php?page=state';</script>";
	}else if($result == 2)
		echo "<script>alert('state Saving Failed');location.href='account.php?page=state';</script>";
	}
}
if(isset($_POST['update']))
{
	unset($_POST['update']);

    // update record
	$_POST['state'] = addslashes($_POST['state']); 
	$_POST['state_ar'] = addslashes($_POST['state_ar']);
	if($db->recordUpdate(array("id" => $id),$_POST,STATE) == 1){
	echo "<script>alert('state Updated Sucessfully');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
	}else{
	echo "<script>alert('state Updation Failed');location.href='account.php?page=state&task=edit&id=".$id."&part=".$_GET['part']."';</script>";
	}
	
}
if($task == "edit" && $id != "")
{
	// get all data
	$datalist = $db->recordFetch($id,STATE.":".'id');
}
// delete all users
if(isset($_POST['todo'])){
	// case
	switch($_POST['todo']){
		case 'deleteall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordDelete(array('id' => $id),STATE) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),STATE) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),STATE) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records UnPublished successfully');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records UnPublished');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records UnPublished');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
		}
		break;
	}
}
// delete individual users
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	if($db->recordDelete(array('id' => $_GET['id']),STATE) == 1){
	// delete user login record
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=state&part=".$_GET['part']."';</script>";
	}
}
?>
<script type="text/javascript">
function check_all()
{
	var num_tot = document.getElementsByName('chkNo[]').length;
	var l,m;
	if(document.getElementById("chkAll").checked == true)
	{
		// enable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "";
		document.getElementById("publishall").disabled = "";
		document.getElementById("unpublishall").disabled = "";
		document.getElementById("deleteall1").disabled = "";
		document.getElementById("publishall1").disabled = "";
		document.getElementById("unpublishall1").disabled = "";
		
		for(l=1;l<=num_tot;l++)
		{
			obj = document.getElementById('chkNo'+l);
			document.getElementById("chkNo" + l).checked = true;
		}
	}else{
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("publishall").disabled = "disabled";
		document.getElementById("unpublishall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		document.getElementById("publishall1").disabled = "disabled";
		document.getElementById("unpublishall1").disabled = "disabled";
		
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
		// enable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "";
		document.getElementById("publishall").disabled = "";
		document.getElementById("unpublishall").disabled = "";
		document.getElementById("deleteall1").disabled = "";
		document.getElementById("publishall1").disabled = "";
		document.getElementById("unpublishall1").disabled = "";
		}
	}else{
		for(l=1;l<=num_tot;l++){
			if(document.getElementById("chkNo" + l).checked == true)
			flag++;
		}
		if(flag == 0){
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("publishall").disabled = "disabled";
		document.getElementById("unpublishall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		document.getElementById("publishall1").disabled = "disabled";
		document.getElementById("unpublishall1").disabled = "disabled";
		}
	}
}
 function confirmInput()
 {
  var retVal = confirm("Do you want to Delete these State ?");
   if( retVal == true ){
      
	   document.chapter_fr.todo.value='deleteall';document.chapter_fr.submit();
	  return true;
   }else{
      
	  return false;
	
   }
 }
</script>
<script type="text/javascript">
function validateManager()
{
	var str = document.s_fr;
	var error = "";
	var flag = false;
	var dataArray = new Array();
	if(str.state.value == "")
	{
		str.state.style.borderColor = "RED";
		error = "- Enter state\n";
		flag = false;
		dataArray.push('state');
	}
	else
	{
		str.state.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(flag == false)
	{
		alert(error);
		str.elements[dataArray[0]].focus();
		return false;
	}
	else
	return true;
}
// fade out messages
var fade_out = function() {
  $("#errorDiv").fadeOut().empty();
}
</script>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 8px; margin-top: 10px;">

    <tr>

      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Create/Manage State </strong></td>

    </tr> 

  </table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="340" valign="top" style="padding-right: 10px;">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Add/Edit state</strong></td>
          </tr>
        </table>
<form action="" method="post" name="s_fr" onSubmit="return validateManager();">
        
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>

    <td style="padding-top: 5px;"><table width="100%" border="0" cellspacing="0" cellpadding="2">

      <tr>
        <td style="padding-left: 0px;">Country:</td>
        <td style="padding-right: 0px;"><select name="country_id" id="country_id" style="width: 193px; font-weight: normal;">
		<option value="">SELECT COUNTRY</option>
        <?php
		$sqlist = mysql_query("SELECT * FROM ".COUNTRY." WHERE status = '1'");
		while($reslist = mysql_fetch_array($sqlist)){
		?>
          <option value="<?php echo $reslist['id']; ?>" <?php if(getElementVal('country_id',$datalist) == $reslist['id']) echo "selected='selected'"; ?>><?php echo $reslist['country']; ?></option>
          <?php }?>
        </select></td>
      </tr>
	  
      <tr>
        <td style="padding-left: 0px;">State (En):</td>
        <td style="padding-right: 0px;"><input name="state" type="text" class="textbox" id="state" style="width: 187px; font-weight: normal;" value="<?php echo getElementVal('state',$datalist); ?>"></td>
      </tr>
	  
	  <tr>
        <td style="padding-left: 0px;">State (Ar):</td>
        <td style="padding-right: 0px;"><input name="state_ar" type="text" class="textbox" id="state_ar" style="width: 187px; font-weight: normal;" value="<?php echo getElementVal('state_ar',$datalist); ?>"></td>
      </tr>
	  
	  
      <tr>
        
        <td width="35%" style="padding-left: 0px;">Set Status:</td>
        
        <td width="65%" style="padding-right: 0px;"><select name="status" id="status" style="width: 193px; font-weight: normal;">
          
          <option value="1" <?php if(getElementVal('status',$datalist) == '1') echo "selected='selected'"; ?>>Active</option>
          
          <option value="0" <?php if(getElementVal('status',$datalist) == '0') echo "selected='selected'"; ?>>Inactive</option>
          
          </select></td>
        
      </tr>
      <tr>
        <td colspan="2" style="padding-left: 0px;padding-top: 10px;">
          <?php

	if($id != "" && $task == "edit"){

    ?>
          <input type="submit" name="update" id="update" value=" Update to List " class="actionBtn">
          <?php }else{ ?>
          <input type="submit" name="save" id="save" value=" Add to List " class="actionBtn">
          <?php } ?>
          <input type="button" name="cancel" id="cancel" value=" Reset " class="actionBtn" onclick="location.href='account.php?page=state'">
        </td>
        </tr>

      </table>

  </td>

  </tr>

</table>
</form>
</td>

    <td width="538" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>

    <td style="padding: 5px; background-color: #f2f2f2;">
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
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #900;" id="errorDiv">
  <tr>
    <td width="2%" valign="top"><img src="<?php echo IMG_PATH; ?>warning.png" width="24" height="24" /></td>
    <td width="98%"><strong>Opps !! Following Errors has beed detected</strong><br />
      <?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>
    <!-- users list -->
<form action="" method="post" name="chapter_fr" style="padding: 0px; margin: 0px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr>
       <td width="55%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
         <input type="button" name="unpublishall" id="unpublishall" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/></td>
       <td width="45%"  align="right" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
         <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 120px; font-weight: normal;" value="<?php echo $_POST['sertxt']; ?>">
         <input type="submit" name="search" id="search" value=" Search " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" /></td>
       </tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td style="border-top: 0px solid #99C; padding-left: 0px;">
	<input type="hidden" name="checked_id" id="checked_id" value=""/>
    <table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr style="color: #FFF;">

	  <td width="6%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
       <td width="62%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Sub Cotegory Name (Category )</strong></td>
       <td width="16%" align="center" bgcolor="#333333"><strong>Status</strong></td>
        <td width="16%" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
       <?php
	   $part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
       $part = ($part == 0 ? 1 : $part);
       $perpage = 15;//limit in each page
       $startpoint = ($part * $perpage) - $perpage; 
	   if(isset($_POST['search'])){
		  $rs=mysql_query("SELECT * FROM ".STATE." WHERE state LIKE '%".$_POST["sertxt"]."%' ORDER BY id DESC LIMIT $startpoint,$perpage"); 
	   }else{
		   $rs=mysql_query("SELECT * FROM ".STATE." ORDER BY id DESC LIMIT $startpoint,$perpage");
	   }
		if(mysql_num_rows($rs) > 0){
			$i=0;
		while($row=mysql_fetch_array($rs)){
		$bgcolor = ($i%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			$i++;
			// fetch subject title
			$subject_nm = $db->recordFetch($row['country_id'],COUNTRY.":".'id');
		  ?>
      <tr <?php echo $bgcolor;?>>
        <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');"/></td>
		<td align="left"  style="padding-left: 5px;"><?php echo stripslashes($row["state"]); ?> (<span style="color: #069"><?php echo $subject_nm['country']; ?></span>)</td>
		<td width="16%" align="center" >
		  <?php if($row['status'] == 0) echo "Inactive"; else echo "Active"; ?></td>
        <td width="16%" align="center" ><a href="account.php?page=state&task=edit&id=<?php echo $row["id"];  ?>&part=<?php echo $_GET['part'];?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit User Profile" style="cursor: pointer;"></a>&nbsp;<a href="account.php?page=state&task=delete&id=<?php echo $row["id"];  ?>&part=<?php echo $_GET['part'];?> " onclick="return confirm('Are You Sure To Delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;"></a></td>
  </tr>
        <?php }}else{
			?>
            <tr>
        <td colspan="4" align="center" >No state Listed</td>
		</tr>
            <?php
		}?>
            <tr>
           <td colspan="4" align="center" ><?php echo Paging(STATE,$perpage,"account.php?page=state&"); ?></td>
            </tr>
 </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td><input type="button" name="deleteall" id="deleteall1" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
      <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="publishall" id="publishall1" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span><span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="unpublishall" id="unpublishall1" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span>
      <input type="hidden" name="todo" id="todo" value=""/></td>
  </tr>
</table>
</form>
<!-- @end users list -->
    

  </td>

  </tr>

</table></td>

  </tr>

  <tr>

    <td colspan="2" valign="top" style="padding-top: 5px;">&nbsp;</td>

  </tr>

</table>


