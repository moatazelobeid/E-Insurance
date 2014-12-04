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


$(function() {
	$( "#strtdate" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' } );
	$( "#enddate" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' });
});

</script>


<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 5px; margin-top: 3px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Sales Report</strong></td>
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
      <?php $allrows=mysql_query("SELECT * FROM ".POLICYMASTER.",".POLICYPAYMENTS." where ".POLICYMASTER.".policy_no = ".POLICYPAYMENTS.".policy_no ORDER BY ".POLICYMASTER.".id DESC "); ?>
       <td width="19%" align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 11px; color: #036;"><strong>Total: <?=mysql_num_rows($allrows)?> </strong></td>
       <td width="75%" align="right" style="border-bottom: 0px; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
	   <input name="frmdate" type="text" class="textbox" id="strtdate" style="width: 120px; font-weight: normal;" placeholder="Enter start date" value="<?php echo $_POST['frmdate']; ?>">
       <input name="todate" type="text" class="textbox" id="enddate" style="width: 120px; font-weight: normal;" placeholder="Enter end date " value="<?php echo $_POST['todate']; ?>">
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
		  <option value="1" <?php if($_POST["stat"]=='1') echo 'selected="selected"';?>>Paid</option>
          <option value="0" <?php if($_POST['stat']=='0') echo 'selected="selected"';?>>Unpaid</option>
        </select>
	   <input type="submit" name="search" id="search" value=" Search " class="actionBtn" />
	   </td>
    </tr>
  </table>
 <div style="overflow:scroll; max-height:700px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td valign="top" style="border-bottom: 1px solid #CCCCCC; padding-left: 0px; padding-right: 0px;">
	<input type="hidden" name="checked_id" id="checked_id" value=""/>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr style="color: #FFF; background-color: #8B8585; height:22px">
		<td width="3%" style="padding-left: 5px;"><strong>#SL</strong></td>
       <td width="8%" style="padding-left: 5px;"><strong>Policy No </strong></td>
       <td width="8%" style="padding-left: 5px;"><strong>Package No </strong></td>
       <td width="12%" style="padding-left: 5px;"><strong>Insured Person</strong></td>
       <td width="15%" style="padding-left: 5px;"><strong>Policy Type </strong></td>
       <td width="11%" style="padding-left: 5px;"><strong>Amount(SAR)</strong></td>
       <td width="15%" align="center"style="padding-left: 5px;"><strong>Transaction Id</strong></td>
        <td width="13%" align="center"><strong>Payment Status</strong></td>
       <td width="15%" align="center"><strong>Registry Date </strong></td>
        </tr>
       <?php
	   $whr="";
	    $pwhr="";
	   if(isset($_POST['search'])){
		   
			$whr[]=" ".POLICYMASTER.".policy_no = ".POLICYPAYMENTS.".policy_no ";
		   if(isset($_POST['stat']) && $_POST['stat']!='')
			  {
				  $status = $_POST['stat'];
				  $whr[]=" payment_status='$status'";
			  }
			 if(isset($_POST['policy_id']) && $_POST['policy_id']!='')
			  {
				  $policy_id = $_POST['policy_id'];
				  $whr[]=" policy_class_id='$policy_id'";
			  }
			  	  if($_POST['frmdate'] != '' && $_POST['todate']=='')
		{
			$frm_date=date('Y-m-d H:i:s',strtotime($_POST['frmdate']));
			$whr[]=" (registry_date BETWEEN '".$frm_date."' AND '".$frm_date."')";
		}	

		if($_POST['todate'] != '' && $_POST['frmdate'] == '')
		{
			$to_date=date('Y-m-d H:i:s',strtotime($_POST['todate']));
			$whr[]=" (registry_date BETWEEN '".$to_date."' AND '".$to_date."')";	
		}	   
		
		if($_POST['frmdate'] != '' && $_POST['todate'] != '')
		{
			$frm_date=date('Y-m-d H:i:s',strtotime($_POST['frmdate']));
			$to_date=date('Y-m-d H:i:s',strtotime($_POST['todate']));
		$whr[]=" (registry_date BETWEEN '".$frm_date."' AND '".$to_date."')";
		}
			 if(!empty($whr))
			{
				$where=" where ".implode("and",$whr);
				$pwhr=implode(" and",$whr);
			}
		
		  $rs=  mysql_query("SELECT * FROM ".POLICYMASTER.",".POLICYPAYMENTS." ".$where."  ORDER BY ".POLICYMASTER.".id DESC LIMIT ".$startpoint.",".$perpage);
	   }else{
		   $rs=mysql_query("SELECT * FROM ".POLICYMASTER.",".POLICYPAYMENTS." where ".POLICYMASTER.".policy_no = ".POLICYPAYMENTS.".policy_no ORDER BY ".POLICYMASTER.".id DESC LIMIT ".$startpoint.",".$perpage);
		  
	   }
		if(mysql_num_rows($rs) > 0){
			$i=0;
			if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		  $amountarr = array();
		while($row=mysql_fetch_array($rs)){
		$bgcolor = ($i%2 == 0)?'bgcolor="#F2F2F2"':'bgcolor=""';
			$i++;
			$transactionval  =mysql_fetch_assoc(mysql_query("SELECT * FROM ".POLICYPAYMENTS." where policy_no = '".$row['policy_no']."' "));
		  ?>
      <tr <?php echo $bgcolor; ?> style="padding-bottom:5px;padding-top:5px;">
		 <td  style="padding-left: 5px;" align="center"><?php echo $i; ?></td>
		<td  style="padding-left: 5px;"><?php echo $row["policy_no"]; ?></td>
        <td  style="padding-left: 5px;"><?php echo stripslashes($row["package_no"]); ?></td>
		<td  style="padding-left: 5px;"><?php echo stripslashes($row["insured_person"]); ?></td>
		<td  style="padding-left: 5px;"><?php 
			$pclass_details = mysql_fetch_object(mysql_query("SELECT * FROM ".POLICIES." WHERE id='".$row["policy_class_id"]."' limit 1"));
			$ptype_details = mysql_fetch_object(mysql_query("SELECT * FROM ".POLICYTYPES." WHERE id='".$row["policy_type_id"]."' limit 1"));
		echo $pclass_details->title.' ('.stripslashes($ptype_details->policy_type).')'; ?></td>
		<td align="center"  style="padding-left: 5px;"><?php 
		$policy_pricedet = mysql_fetch_object(mysql_query("SELECT * FROM ".PACKAGE." WHERE package_no='".$row["package_no"]."' limit 1"));
		array_push($amountarr,$policy_pricedet->package_amt);
		echo number_format($policy_pricedet->package_amt,2); ?></td>
        <td width="15%" align="center"><?php echo ($transactionval['transaction_id'] !='')?stripslashes($transactionval['transaction_id']):'N/A'; ?></td>
          <td width="13%" align="center">
				<?php echo ($transactionval['payment_status'] == 1)?'Paid':'Unpaid'; ?>
                </td>
		<td width="15%" align="center"><?php echo date("d/m/Y",strtotime($row["registry_date"])); ?></td> 
  </tr>
        <?php }}else{
			?>
            <tr>
        <td colspan="11" align="center">No Record Listed</td>	
		</tr>
            <?php
		}?>
 </table></td>
  </tr>
</table>
</div>
<table>
<tr>
<td colspan="3"><strong>Total Amount : </strong></td>
<td><?php if(!empty($amountarr)){ 
$total = array_sum($amountarr);
echo number_format($total,2);}else{echo 'N/A';} ?></td>
<td colspan="3"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td width="6%">
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