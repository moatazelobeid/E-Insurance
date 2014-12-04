<?php
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage;

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
				if($db->recordDelete(array('id' => $id),CLAIMMOTOR) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=claim-center';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=claim-center';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=claim-center';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),CLAIMMOTOR) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=claim-center';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=claim-center';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=claim-center';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),CLAIMMOTOR) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records UnPublished successfully');location.href='account.php?page=claim-center';</script>";
			}else{
				echo "<script>alert('No Records UnPublished');location.href='account.php?page=claim-center';</script>";
			}
		}else{
			echo "<script>alert('No Records UnPublished');location.href='account.php?page=claim-center';</script>";
		}
		break;
	}
}
// delete individual users
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	if($db->recordDelete(array('id' => $_GET['id']),CLAIMMOTOR) == 1){
	// delete user login record
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=claim-center';</script>";
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
		document.getElementById("deleteall1").disabled = "";
		
		for(l=1;l<=num_tot;l++)
		{
			obj = document.getElementById('chkNo'+l);
			document.getElementById("chkNo" + l).checked = true;
		}
	}else{
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		
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
		document.getElementById("deleteall1").disabled = "";
		}
	}else{
		for(l=1;l<=num_tot;l++){
			if(document.getElementById("chkNo" + l).checked == true)
			flag++;
		}
		if(flag == 0){
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		}
	}
}

function confirmInput()
{
	var retVal = confirm("Do you want to delete the claim request?");
	if( retVal == true ){
		document.subject_fr.todo.value='deleteall';document.subject_fr.submit();
		return true;
	}else{
		return false;
	}
}
 
function checkUpdate(val,id)
{
$.ajax({
	 type: "POST",
	 url: "util/claim_reply.php",
	 data: "status="+val+"&id="+id,
	 success: function(msg)
	 {
			if(msg == 'OK')
			{
				alert ("Status changed successfully")
			}
			else if(msg == 'ERROR')
			{
				alert("Error in updating status");
			}
	 }
});
}
</script>
<script type="text/javascript">
// fade out messages
var fade_out = function() {
  $("#errorDiv").fadeOut().empty();
}
setTimeout(fade_out, 2000);
</script>

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 5px; margin-top: 3px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Claims </strong></td>
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
<?php if($errmsg <> ""){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #900;" id="errorDiv">
  <tr>
    <td width="2%" valign="top"><img src="<?php echo IMG_PATH; ?>warning.png" width="24" height="24" /></td>
    <td width="98%"><strong>Opps !! Following Errors has beed detected</strong><br />
      <?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>

<form action="" method="post" name="subject_fr" style="padding: 0px; margin: 0px;">

  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr>
       <td width="6%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onClick="confirmInput();" disabled="disabled"/></td>
      <?php $allrows=mysql_query("SELECT * FROM ".CLAIMMOTOR." ORDER BY id DESC"); ?>
       <td width="19%" align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 11px; color: #036;"><strong>Total: <?=mysql_num_rows($allrows)?> </strong></td>
       <td width="75%" align="right" style="border-bottom: 0px; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;"><select name="stat" style="width: 100px; font-weight: normal; padding: 3px 3px 3px 3px;">
		  <option value="">Status</option>
		  <option value="0" <?php if($_POST["stat"]=='0') echo "selected='selected'";?>> Open </option>
          <option value="1" <?php if($_POST["stat"]=='1') echo "selected='selected'";?>> On Progress </option>
          <option value="2" <?php if($_POST["stat"]=='2') echo "selected='selected'";?>> Closed </option>
        </select>
	   <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 120px; font-weight: normal;" placeholder="Policy No " value="<?php echo $_POST['sertxt']; ?>">
	   <input type="submit" name="search" id="search" value=" Search " class="actionBtn" />
	   </td>
    </tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td valign="top" style="border-bottom: 1px solid #CCCCCC; padding-left: 0px; padding-right: 0px;">
	<input type="hidden" name="checked_id" id="checked_id" value=""/>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr style="color: #FFF; background-color: #8B8585;">

	  <td width="3%" align="center"><input type="checkbox" name="chkAll" id="chkAll" onClick="check_all();" /></td>
       <td width="11%" style="padding-left: 5px;"><strong>Claim No </strong></td>
       <td width="11%" style="padding-left: 5px;"><strong>Policy Number </strong></td>
       <td width="17%" style="padding-left: 5px;"><strong>Insured Person</strong></td>
       <td width="17%" style="padding-left: 5px;"><strong>Policy Type </strong></td>
       <td width="10%" align="center" style="padding-left: 5px;"><strong>Loss Date </strong></td>
       <td width="11%" align="center"><strong>Claim Date </strong></td>
        <td width="11%" align="center"><strong>Status</strong></td>
        <td width="9%" align="center"><strong>Action</strong></td>
        </tr>
       <?php
	   $whr="";
	   $pwhr="";
	   if(isset($_POST['search']))
	   {
		   	if(isset($_POST['stat']) && $_POST['stat']!='')
			{
				$status = $_POST['stat'];
				$whr[]=" status='$status'";
			}
		  	if(isset($_POST['sertxt']))
			{
			
				$whr[]=" (policy_no like '%".$_POST['sertxt']."%')";
			}
			if(!empty($whr))
			{
				$where=" where ".implode(" AND ",$whr);
				$pwhr=implode(" AND ",$whr);
			}
		  $rs=  mysql_query("SELECT * FROM ".CLAIMMOTOR.$where." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	   }else{
		   $rs=mysql_query("SELECT * FROM ".CLAIMMOTOR." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	   }
	   
	   if(mysql_num_rows($rs) > 0)
	   {
	   		$i=0;
			if(($_GET["part"]==1) || ($_GET["part"]=='')){$i=1;}else{$i=(15*($_GET["part"]-1))+1;}
			while($row=mysql_fetch_array($rs)){
			$bgcolor = ($i%2 == 0)?'bgcolor="#F2F2F2"':'bgcolor=""';
			
			// Get Policy Details
			$policy_deatil = $db->recordFetch($row["policy_no"],POLICYMASTER.":".'policy_no');
			
	  ?>
      <tr <?php echo $bgcolor; ?>>
        <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onClick="check_single('chkNo<?php echo $i;?>');"/></td>
		<td  style="padding-left: 5px;"><?php echo $row["claim_no"]; ?></td>
        <td  style="padding-left: 5px;"><?php echo $row["policy_no"]; ?></td>
		<td  style="padding-left: 5px;"><?php echo $policy_deatil['insured_person']; ?></td>
		<td  style="padding-left: 5px;">
		<?php
		$policy_class_title = get_value('title',constant('POLICIES'),$policy_deatil["policy_class_id"],'id');
		$ptype_title = get_value('policy_type',constant('POLICYTYPES'),$policy_deatil["policy_type_id"],'id');
		echo stripslashes($policy_class_title).' ('.stripslashes($ptype_title).')';
		?>		</td>
		<td align="center"  style="padding-left: 5px;"><?php echo date("d/m/Y",strtotime($row["loss_date"])); ?></td>
		<td width="11%" align="center"><?php echo date("d/m/Y",strtotime($row["created_date"])); ?></td>
        <td width="11%" align="center">
		<select id='status' name='status' onchange="checkUpdate(this.value,<?php echo $row["id"]; ?>,'<?php echo $row['policy_type']?>')" style="width: 110px;">
          <option value="0"  <?php if($row["status"]=='0') echo "selected='selected'";?>> Open </option>
          <option value="1"  <?php if($row["status"]=='1') echo "selected='selected'";?>> On Progress </option>
          <option value="2"  <?php if($row["status"]=='2') echo "selected='selected'";?>> Closed </option>
        </select>		</td>
        <td align="center">
		<a class="postcomment" href="public/claim-details.php?id=<?php echo $row['id'];?>"><img src="images/view.png"  width="16" height="16" border="0" title="View Claim" style="cursor: pointer;" /></a>&nbsp;
		<a class="claim_reply" href="public/claim-reply.php?id=<?php echo $row["id"];?>&type=<?php echo $row['policy_type'];?>"><img src="images/email_icon.png" alt="Reply" width="16" height="16" border="0" title="Reply Against Claim" style="cursor: pointer;"></a>&nbsp;
		<a href="account.php?page=claim-center&task=delete&id=<?php echo $row["id"];?>&type=<?php echo $row['policy_type'];?>" onclick="return confirm('ARE YOU SURE TO DELETE!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete Claim" style="cursor: pointer;"></a></td>
        </tr>
        <?php $i++;}}else{
			?>
            <tr>
        <td colspan="9" align="center">No Record Listed</td>	
		</tr>
            <?php
		}?>
 </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td width="6%"><input type="button" name="deleteall" id="deleteall1" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onClick="confirmInput();" disabled="disabled"/>
      <input type="hidden" name="todo" id="todo" value=""/></td>
    <td width="19%">&nbsp;</td>
    
    <td width="75%" align="right">
	<?php if(isset($_POST['search'])){ ?>
	<?php echo Paging(POLICYTYPES,$perpage,"account.php?page=claim-center&",$pwhr);?>
    <?php }else{?>
    <?php echo Paging(POLICYTYPES,$perpage,"account.php?page=claim-center&");?>
    <?php } ?>
    </td>
  </tr>
</table>
<!-- @end users list -->
</form>