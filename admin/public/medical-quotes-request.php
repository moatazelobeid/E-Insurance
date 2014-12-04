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
				if($db->recordDelete(array('id' => $id),MEDICALQUOTES) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=medical--quotes-request';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=medical--quotes-request';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=medical--quotes-request';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),MEDICALQUOTES) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=medical--quotes-request';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=medical--quotes-request';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=medical--quotes-request';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),MEDICALQUOTES) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records UnPublished successfully');location.href='account.php?page=medical--quotes-request';</script>";
			}else{
				echo "<script>alert('No Records UnPublished');location.href='account.php?page=medical--quotes-request';</script>";
			}
		}else{
			echo "<script>alert('No Records UnPublished');location.href='account.php?page=medical--quotes-request';</script>";
		}
		break;
	}
}
// delete individual users
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	if($db->recordDelete(array('id' => $_GET['id']),MEDICALQUOTES) == 1){
	// delete user login record
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=medical--quotes-request';</script>";
	}
}
?>
<script type="text/javascript">
function check_all()
{
//alert(123);
	var num_tot = document.getElementsByName('chkNo[]').length;
		//alert(num_tot);

	var l,m,obj;
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
  var retVal = confirm("Do you want to Delete these Requests?");
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
function select_policy(val)
{

	 $.ajax({
         type: "POST",
         url: "util/utils.php",
         data: "policy_classid="+val,
         success: function(msg){
			if(msg ==0)
			{
				$("#policy_types").html('<select name="policy_type" disabled style="width: 150px; font-weight: normal; padding: 3px 3px 3px 3px;"><option value="">Select</option></select>');	
				
			}
			else
			{
				$("#policy_types").html(msg);	
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
      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Quote Requests</strong></td>
    </tr> 
</table>

<?php if($msg <> ""){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;">
  <tr>
    <td width="2%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
    <td width="98%" id="sucessmsg"><?php echo $msg; ?></td>
  </tr>
</table>
<?php } ?>
<?php if($errmsg <> ""){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #900;" id="errorDiv">
  <tr>
    <td width="2%" valign="top"><img src="<?php echo IMG_PATH; ?>warning.png" width="24" height="24" /></td>
    <td width="98%" ><strong>Opps !! Following Errors has beed detected</strong><br />
      <?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>
<form action="" method="post" name="subject_fr" style="padding: 0px; margin: 0px;">

  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr>
       <td width="6%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onClick="confirmInput();" disabled="disabled"/></td>
       <?php  $totalsql=mysql_query("SELECT * FROM ".MEDICALQUOTES." "); ?>
       <td width="19%" align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 11px; color: #036;"><strong>Total: <?=mysql_num_rows($totalsql)?></strong></td>
       <td width="75%" align="right" style="border-bottom: 0px; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
	   
	   <?php /*?><select name="policy_id" onchange="select_policy(this.value);" style="width: 150px; font-weight: normal; padding: 3px 3px 3px 3px;">
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
        <span id="policy_types">
        <select name="policy_type"  disabled style="width: 150px; font-weight: normal; padding: 3px 3px 3px 3px;">
		  <option value="">Select</option>
        </select>
        </span><?php */?>
		<select name="stats" style="width: 100px; font-weight: normal; padding: 3px 3px 3px 3px;">
		  <option value="">Status</option>
           <option value="Open" >Open</option>
          <option value="Closed" >Closed</option>
        </select>
	   <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 120px; font-weight: normal;" value="<?php echo $_POST['sertxt']; ?>">
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
       	<td width="16%" style="padding-left: 5px;"><strong>Quote Key</strong></td>
        <td width="14%" align="center" style="padding-left: 5px;"><strong>Mobile No</strong></td>
     	<td width="37%" style="padding-left: 5px;"><strong>Insurance Type </strong></td>
        <?php /*?><td width="10%" align="center" style="padding-left: 5px;"><strong>Purchase Year</strong></td><?php */?>
        <td width="11%" align="center"><strong>Request Date </strong></td>
        <td width="10%" align="center"><strong>Status</strong></td>
        <td colspan="2" align="center"><strong>Action</strong></td>
        </tr>
       <?php
	   $whr="";
	    $pwhr="";
	   if(isset($_POST['stats'])){
		   if(isset($_POST['stats']) && $_POST['stats']!='')
		  {
			  $status = $_POST['stats'];
			  $whr[]=" status='$status'";
		  }
		  if(isset($_POST['sertxt']))
			{
			
				$whr[]=" (quote_key like '%".$_POST['sertxt']."%' or first_name like '%".$_POST['sertxt']."%' or last_name like '%".$_POST['sertxt']."%' or email like '%".$_POST['sertxt']."%' )";
			}
			if(isset($_POST['policy_id']) && $_POST['policy_id']!='')
		  {
			  $policyid = $_POST['policy_id'];
			  $whr[]=" policy_class_id='$policyid'";
		  }
		  if(isset($_POST['policy_type']) && $_POST['policy_type']!='')
		  {
			  $policy_type = $_POST['policy_type'];
			  $whr[]=" policy_type_id='$policy_type'";
		  }
		  if(!empty($whr))
			{
				$where=" where ".implode("and",$whr);
				$pwhr=implode("and",$whr);
			}
			
		  $rs=  mysql_query("SELECT * FROM ".MEDICALQUOTES.$where." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
		
	   }else{
		   $rs=mysql_query("SELECT * FROM ".MEDICALQUOTES." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	   }
		if(mysql_num_rows($rs) > 0){
			$i=0;
			if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		while($row=mysql_fetch_array($rs)){
		$bgcolor = ($i%2 == 0)?'bgcolor="#F2F2F2"':'bgcolor=""';
			
		  ?>
      <tr <?php echo $bgcolor; ?>>
        <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');" /></td>
		<td  style="padding-left: 5px;"><?php echo $row["quote_key"]; ?></td>
		<td align="center"  style="padding-left: 5px;"><?php echo $row["mobile_no"]; ?></td>
		<td  style="padding-left: 5px;"><?php
		$policy_class_title = get_value('title',constant('POLICIES'),$row["policy_class_id"],'id');
		$insurance_types = mysql_fetch_array(mysql_query("select * from ".POLICYTYPES." where id = '".$row["policy_type_id"]."' "));
		echo stripslashes($policy_class_title); ?></td>
		<?php /*?><td align="center"  style="padding-left: 5px;"><?php echo $row["vehicle_purchase_year"]; ?></td><?php */?>
		<td width="11%" align="center"><?php echo date("d/m/Y",strtotime($row["created_date"])); ?></td>
        <td width="10%" align="center">
		<select name="status" class="generalDropDown" onchange="checkUpdate(this.value,<?php echo $row["id"]; ?>,'ksa_policy_quotes')" style="width: 80px;">
		  <option value="Open" <?php if($row["status"]=='Open') echo 'selected="selected"';?>>Open</option>
          <option value="Closed" <?php if($row["status"]=='Closed') echo 'selected="selected"';?>>Closed</option>
        </select></td>
        <td width="8%" align="center">
		<a href="public/medical-qoute-view.php?id=<?php echo $row['id']; ?>" id="fancy">
		<img src="images/view.png"  width="16" height="16" border="0" title="View Qoute Details" style="cursor: pointer;" /></a>&nbsp;
		<a href="account.php?page=medical--quotes-request&task=delete&id=<?php echo $row["id"];  ?> " onClick="return confirm('Are You Sure To Delete!');">
		<img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;"></a>		</td>
  </tr>
        <?php $i++; }}else{
			?>
            <tr>
        <td colspan="7" align="center">No Record Listed</td>	
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
    <td width="75%" align="right"><?php echo Paging(MEDICALQUOTES,$perpage,"account.php?page=medical--quotes-request".$sub_url."&",$pwhr);?></td>
  </tr>
</table>
<!-- @end users list -->
</form>