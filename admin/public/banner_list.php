<?php 

$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 25;//limit in each page
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
					$db->recordDelete(array('id'=>$id),ADVERTISEMENT);
					$count++;
				
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=banner_list&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=banner_list&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=banner_list&part=".$_GET['part']."';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),ADVERTISEMENT) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=banner_list&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=banner_list&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=banner_list&part=".$_GET['part']."';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),ADVERTISEMENT) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=banner_list&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='account.php?page=banner_list&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='account.php?page=banner_list&part=".$_GET['part']."';</script>";
		}
		break;
	}
}
// delete individual users
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	if($db->recordDelete(array('id'=>$_GET['id']),ADVERTISEMENT) == 1){
	$db->recordDelete(array('id'=>$_GET['id']),ADVERTISEMENT);
	// delete user login record
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=banner_list';</script>";
	}
}

//for active
if($_GET['id'] != "" && $_GET['task'] == "activate")
{
		$upd = "update ".ADVERTISEMENT." set status  = '1' where id = '".$_GET['id']."' ";
		mysql_query($upd) or die(mysql_error());
		echo "<script>alert('Record Activated Sucessfully');</script>";
}
//for block
if($_GET['id'] != "" && $_GET['task'] == "block")
{
		$upd = "update ".ADVERTISEMENT." set status  = '0' where id = '".$_GET['id']."' ";
		mysql_query($upd) or die(mysql_error());
		echo "<script>alert('Record Blocked Sucessfully');</script>";	
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
  var retVal = confirm("Do you want to Delete these Advertisement ?");
   if( retVal == true ){
      
	   document.chapter_fr.todo.value='deleteall';document.chapter_fr.submit();
	  return true;
   }else{
      
	  return false;
	
   }
 }
</script>
<script type="text/javascript">
// fade out messages
var fade_out = function() {
  $("#errorDiv").fadeOut().empty();
}
</script>
<style type="text/css">
.coltext{
color:#FFFFFF;
text-decoration:none;
}
</style>

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 8px; margin-top: 10px;">
    <tr>

      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #F98923;"><strong>List/Manage Advertisements </strong></td>
      <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
		<a href="account.php?page=manage_ad"><div class="actionBtn1" style="width:137px;">Add New Advertisement</div></a>
      </td>

    </tr> 
</table>


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><span style="padding-top: 10px;">
      <?php
			echo Paging(CUSTOMER,$perpage,"account.php?page=view_member&");
		?>
      </span>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>

    <td>
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
       <td width="38%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Active " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
         <input type="button" name="unpublishall" id="unpublishall" value="Inactive " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/></td>
       <td width="62%"  align="right" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
         <!--<input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 150px; font-weight: normal;" value="<?php echo $_POST['sertxt']; ?>">
         <input type="submit" name="search" id="search" value=" Search " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />--></td>
       </tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td style="border-top: 0px solid #99C; padding-left: 0px;">
    <table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr style="color: #FFF;">

	  <td width="3%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
       <td width="3%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
       <td width="15%" align="center" bgcolor="#333333"><strong>Type</strong></td>
       <td width="16%" align="center" bgcolor="#333333"><strong>Position</strong></td>
       <td width="11%" align="center" bgcolor="#333333"><strong>Status</strong></td>
       <td width="12%" align="center" bgcolor="#333333"><strong>Posted On</strong></td>
        <td width="18%" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
        <?php   

	$sql11=mysql_query("SELECT * FROM ".ADVERTISEMENT." order by id desc limit ".$startpoint.",".$perpage) or die(mysql_error());
	
		//$line = ms_display_value($sql11);
        //@extract($sql11);

		$j=0;
		//$rs1 = mysql_query($sql11);
		if(mysql_num_rows($sql11) > 0){
		if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=(25*($_GET["part"]-1))+1;}
		
		while($row=mysql_fetch_array($sql11)){
		
        $j++;
		$bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"'; 
		$bnr_type = $row['type'];   
        ?>
        <tr <?php echo $bgcolor; ?>>
 		<td align="center">
        	<input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');"/>        </td>
		<td align="center"><?php echo $j; ?></td>
		<td width="15%" align="center" ><?php if($bnr_type=='Code'){echo "Script Code";}else{echo $bnr_type;}?></td>
		<td width="16%" align="center" ><?php echo $row["position"]; ?></td>
		<td width="11%" align="center" >
			<?php if($row["status"]=='0') { ?>
        	<a href="account.php?page=banner_list&task=activate&id=<?php echo $row["id"]; ?>"><font color="#FF0000">In Active</font> </a>
 			<?php } else {  ?>
  			<a href="account.php?page=banner_list&task=block&id=<?php echo $row["id"]; ?>"><span style="color: #339966">Active </span></a>

			<?php } ?>		</td>
		<td width="12%" align="center" ><?php echo date("d/m/Y",strtotime($row["created_date"])); ?></td>
        <td width="18%" align="center" >
        
       <a id="box1" href="public/ad_details.php?id=<?php echo $row["id"]; ?>"><img src="images/b_browse.png" alt="View Details" width="16" height="16" border="0" title="View Details" style="cursor: pointer;" /></a>
		
        <a href="account.php?page=manage_ad&amp;task=edit&amp;id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" 
        height="16" border="0" title="Edit User Profile" style="cursor: pointer;" /></a>&nbsp;
        
        <a href="account.php?page=banner_list&amp;task=delete&amp;id=<?php echo $row["id"];  ?> " onclick="return confirm('Are You Sure To Delete!');">
        <img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;" /></a>        </td>
  </tr>
  
  <?php $i++; } } else { ?>
  
  <tr>
  	<td colspan="8" align="center" bgcolor="#F2FBFF">No Banner Listed</td>
  </tr>
  <?php } ?>
 </table></td>
 </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td><input type="button" name="deleteall" id="deleteall1" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
      <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="publishall" id="publishall1" value="Active " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span><span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
      <input type="button" name="unpublishall" id="unpublishall1" value="Inactive " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span>
      <input type="hidden" name="todo" id="todo" value=""/></td>
  </tr>
</table>
</form>
<!-- @end users list -->  </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td>
  </tr>
</table></td></tr>
  <tr>
    <td align="center" valign="top" style="padding-top: 10px;">&nbsp;</td>
  </tr>
</table>