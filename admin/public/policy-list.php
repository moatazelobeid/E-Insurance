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
				if($db->recordDelete(array('id' => $id),POLICYMASTER) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=policy-list';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=policy-list';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=policy-list';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),POLICYMASTER) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=policy-list';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=policy-list';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=policy-list';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),POLICYMASTER) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records UnPublished successfully');location.href='account.php?page=policy-list';</script>";
			}else{
				echo "<script>alert('No Records UnPublished');location.href='account.php?page=policy-list';</script>";
			}
		}else{
			echo "<script>alert('No Records UnPublished');location.href='account.php?page=policy-list';</script>";
		}
		break;
	}
}
// delete individual users
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	if($db->recordDelete(array('id' => $_GET['id']),POLICYMASTER) == 1){
	// delete user login record
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=policy-list';</script>";
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
  var retVal = confirm("Do you want to Delete the Policy?");
   if( retVal == true ){
      
	   document.subject_fr.todo.value='deleteall';document.subject_fr.submit();
	  return true;
   }else{
      
	  return false;
	
   }
 }
 
function checkUpdate(val,id,tablename)
{
	$.ajax({
		type: "POST",
		url: "util/utils.php",
		data: "request_id="+id+"&statusvalue="+val+"&tablename="+tablename,
		success: function(msg){
			if(msg ==1)
			{
				alert("Records Updated Sucessfully");
			}
			else
			{
				alert("Records Updation Failed");
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
      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List Policies</strong></td>
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
      <?php $allrows=mysql_query("SELECT * FROM ".POLICYMASTER." ORDER BY id DESC"); ?>
       <td width="19%" align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 11px; color: #036;"><strong>Total: <?=mysql_num_rows($allrows)?> </strong></td>
       <td width="75%" align="right" style="border-bottom: 0px; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
	   <select name="branch_id" style="width: 150px; font-weight: normal; padding: 3px 3px 3px 3px;">
		<option value="">Branch</option>
		<?php 
		$sql_class = mysql_query("SELECT id,branch_name FROM ".BRANCHES." WHERE status = '1'");
		if(mysql_num_rows($sql_class) > 0){
		while($result_class = mysql_fetch_array($sql_class))
		{
		?>
			<option value="<?php echo $result_class['id'];?>" <?php if($_POST['branch_id'] == $result_class['id'])echo 'selected="selected"';?>><?php echo $result_class['branch_name'];?></option>
		<?php }} ?>
		</select>
	   <select name="policy_id" style="width: 100px; font-weight: normal; padding: 3px 3px 3px 3px;">
		<option value="">Policy Type</option>
		<?php 
		$sql_class = mysql_query("SELECT id,title FROM ".POLICIES." WHERE status = '1'");
		if(mysql_num_rows($sql_class) > 0){
		while($result_class = mysql_fetch_array($sql_class))
		{
		?>
			<option value="<?php echo $result_class['id'];?>" <?php if($_POST['policy_id'] == $result_class['id'])echo 'selected="selected"';?>><?php echo $result_class['title'];?></option>
		<?php }} ?>
		</select>
		<select name="stat" style="width: 100px; font-weight: normal; padding: 3px 3px 3px 3px;">
		  <option value="">Status</option>
		  <option value="Pending" <?php if($_POST["stat"]=='Pending') echo 'selected="selected"';?>>Pending</option>
          <option value="Active" <?php if($_POST['stat']=='Active') echo 'selected="selected"';?>>Active</option>
          <option value="Expire" <?php if($_POST['stat']=='Expire') echo 'selected="selected"';?>>Expired</option>
          <option value="Closed" <?php if($_POST['stat']=='Closed') echo 'selected="selected"';?>>Cancelled</option>
        </select>
	   <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 120px; font-weight: normal;" placeholder="Package/Policy No " value="<?php echo $_POST['sertxt']; ?>">
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

	  <td width="4%" align="center"><input type="checkbox" name="chkAll" id="chkAll" onClick="check_all();" /></td>
       <td width="7%" style="padding-left: 5px;"><strong>Policy No </strong></td>
       <td width="11%" style="padding-left: 5px;"><strong>Package No </strong></td>
       <td width="12%" style="padding-left: 5px;"><strong>Insured Person</strong></td>
       <td width="11%" style="padding-left: 5px;"><strong>Policy Type </strong></td>
       <td width="11%" align="center" style="padding-left: 5px;"><strong>Amount(SR)</strong></td>
       <td width="16%" align="center" style="padding-left: 5px;"><strong>Policy Period</strong></td>
       <td width="10%" align="center"><strong>Registry Date </strong></td>
        <td width="10%" align="center"><strong>Status</strong></td>
        <td colspan="2" align="center"><strong>Action</strong></td>
        </tr>
       <?php
	   $whr="";
	    $pwhr="";
	   if(isset($_POST['search'])){
		   
		    if(isset($_POST['policy_id']) && $_POST['policy_id']!='')
			  {
				  $policy_id = $_POST['policy_id'];
				  $whr[]=" policy_class_id='$policy_id'";
			  }
		   if(isset($_POST['branch_id']) && $_POST['branch_id']!='')
			  {
				  $branch_id = $_POST['branch_id'];
				  $whr[]=" branch_id='$branch_id'";
			  }
		   if(isset($_POST['stat']) && $_POST['stat']!='')
			  {
				  $status = $_POST['stat'];
				  $whr[]=" status='$status'";
			  }
		  if(isset($_POST['sertxt']))
			{
			
				$whr[]=" (policy_no like '%".$_POST['sertxt']."%' or package_no like '%".$_POST['sertxt']."%' or insured_person like '%".$_POST['sertxt']."%' )";
			}
			 if(!empty($whr))
			{
				$where=" where ".implode("and",$whr);
				$pwhr=implode(" and",$whr);
			}
		  $rs=  mysql_query("SELECT * FROM ".POLICYMASTER.$where." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	   }else{
		   $rs=mysql_query("SELECT * FROM ".POLICYMASTER." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	   }
		if(mysql_num_rows($rs) > 0){
			$i=0;
			if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		while($row=mysql_fetch_array($rs)){
		$bgcolor = ($i%2 == 0)?'bgcolor="#F2F2F2"':'bgcolor=""';
			
		  ?>
      <tr <?php echo $bgcolor; ?>>
        <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onClick="check_single('chkNo<?php echo $i;?>');"/></td>
		<td  style="padding-left: 5px;"><?php echo $row["policy_no"]; ?></td>
        <td  style="padding-left: 5px;"><?php echo stripslashes($row["package_no"]); ?></td>
		<td  style="padding-left: 5px;"><?php echo stripslashes($row["insured_person"]); ?></td>
		<td  style="padding-left: 5px;"><?php 
			$pclass_details = mysql_fetch_object(mysql_query("SELECT * FROM ".POLICIES." WHERE id='".$row["policy_class_id"]."' limit 1"));
			$ptype_details = mysql_fetch_object(mysql_query("SELECT * FROM ".POLICYTYPES." WHERE id='".$row["policy_type_id"]."' limit 1"));
		echo $pclass_details->title;
		if(!empty($ptype_details->policy_type)) echo ' ('.stripslashes($ptype_details->policy_type).')'; ?></td>
		<td align="center"  style="padding-left: 5px;"><?php 
		/*$policy_pricedet = mysql_fetch_object(mysql_query("SELECT * FROM ".PACKAGE." WHERE package_no='".$row["package_no"]."' limit 1"));
		echo number_format($policy_pricedet->package_amt,2); */
		
		$policy_pricedet = mysql_fetch_object(mysql_query("SELECT * FROM ".POLICYPAYMENTS." WHERE policy_no='".$row["policy_no"]."' limit 1"));
		echo number_format($policy_pricedet->amount_paid,2);
		
		?></td>
		<td align="center"  style="padding-left: 5px;"><?php echo date("d/m/Y",strtotime($row["insured_period_startdate"])); ?> - <?php echo date("d/m/Y",strtotime($row["insured_period_enddate"])); ?></td>
		<td width="10%" align="center"><?php echo date("d/m/Y",strtotime($row["registry_date"])); ?></td>
        <td width="10%" align="center">
		<select name="status" class="generalDropDown" onchange="checkUpdate(this.value,<?php echo $row["id"]; ?>,'ksa_policy_master')" style="width: 80px;">
		  <option value="Pending" <?php if($row["status"]=='Pending') echo 'selected="selected"';?>>Pending</option>
          <option value="Active" <?php if($row["status"]=='Active') echo 'selected="selected"';?>>Active</option>
          <option value="Expire" <?php if($row["status"]=='Expire') echo 'selected="selected"';?>>Expired</option>
          <option value="Closed" <?php if($row["status"]=='Closed') echo 'selected="selected"';?>>Cancelled</option>
        </select>		</td>
 		 <?php /*?><td width="6%" align="center"><span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
          <input type="button" name="renew" id="renew" value="Renew" class="actionBtn" />
        </span></td><?php */?>
        <td width="8%" align="center">
		<a href="account.php?page=view-policy&id=<?php echo $row['id']; ?>&part=<?=$part?>">
		<img src="images/view.png"  width="16" height="16" border="0" title="View Customer Details" style="cursor: pointer;" /></a>&nbsp;
		<?php /*?><a href="account.php?page=edit-policy&action=edit&policy_no=<?php echo $row["policy_no"]; ?>&step=1">
		<img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit User Profile" style="cursor: pointer;"></a>&nbsp;<?php */?>
		<a href="account.php?page=policy-list&task=delete&id=<?php echo $row["id"];  ?> " onClick="return confirm('Are You Sure To Delete!');">
		<img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;"></a>		</td>
  </tr>
        <?php $i++;}}else{
			?>
            <tr>
        <td colspan="11" align="center">No Record Listed</td>	
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
	<?php echo Paging(POLICYTYPES,$perpage,"account.php?page=policy-list&",$pwhr);?>
    <?php }else{?>
    <?php echo Paging(POLICYTYPES,$perpage,"account.php?page=policy-list&");?>
    <?php } ?>
    </td>
  </tr>
</table>
<!-- @end users list -->
</form>