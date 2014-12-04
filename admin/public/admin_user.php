<?php 
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 10;//limit in each page
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
				if($db->recordDelete(array('id'=>$id),USRTBL) == 1){
					$db->recordDelete(array('uid'=>$id,'user_type'=>'S'),LOGINTBL);
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=admin_user';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=admin_user';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=admin_user';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("uid" => $id,"user_type"=>'S'),array('is_active'=>'1'),LOGINTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=admin_user';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=admin_user';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=admin_user';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("uid" => $id,"user_type"=>'S'),array('is_active'=>'0'),LOGINTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=admin_user';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='account.php?page=admin_user';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='account.php?page=admin_user';</script>";
		}
		break;
	}
}
//print_r ($_SESSION);


// delete individual users
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	if($db->recordDelete(array('id'=>$_GET['id']),USRTBL) == 1){
		$db->recordDelete(array('uid'=>$_GET['id'],'user_type'=>'S'),LOGINTBL);
	// delete user login record
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=admin_user';</script>";
	}
}

//for active
if($_GET['id'] != "" && $_GET['task'] == "activate")
{
	$upd = "update ".LOGINTBL." set is_active  = '1' where uid = '".$_GET['id']."' and user_type='S'";
	mysql_query($upd) or die(mysql_error());
	echo "<script>alert('Record Activated Sucessfully');</script>";
}
//for block
if($_GET['id'] != "" && $_GET['task'] == "block")
{
	$upd = "update ".LOGINTBL." set is_active  = '0' where uid = '".$_GET['id']."' and user_type='S'";
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
  var retVal = confirm("Do you want to Delete these User ?");
   if( retVal == true ){
      
	   document.chapter_fr.todo.value='deleteall'; document.chapter_fr.submit();
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
<div style="padding-left: 0px;">
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 4px; margin-top: 10px;">
    <tr>

      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List/Manage Admin</strong></td>
      <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">

<a href="account.php?page=create_user"><img src="images/add_new.png" width="87" height="15" border="0"></a>
	  
         <!--<input type="button" name="addnew" id="addnew" value=" Add New Admin " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; cursor: pointer;" onclick="location.href='account.php?page=create_user'"/>-->
      </td>

    </tr> 

  </table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      
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
    <td width="98%"><strong>Opps !! Following Errors has been detected</strong><br />
      <?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>
    <!-- users list -->
<form action="" method="post" name="chapter_fr" style="padding: 0px; margin: 0px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr>
       <td width="38%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;"> <input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
         <input name="publishall" type="button" disabled="disabled" id="publishall" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" value="Active"/>
         <input type="button" name="unpublishall" id="unpublishall" value="Inactive " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/></td>
       <td width="62%"  align="right" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
         <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 150px; font-weight: normal;" value="<?php echo $_POST['sertxt']; ?>">
         &nbsp;&nbsp;OR&nbsp;&nbsp;
        <select name="search_by_status" id="search_by_status" style="width: 150px; font-weight: normal;"><option value="">Status</option><option value="1" <?php if($_POST["search_by_status"] == "1") echo "selected='selected'"; ?>>Active</option><option value="0" <?php if($_POST["search_by_status"] == "0") echo "selected='selected'"; ?>>Inactive</option></select>
         <input type="submit" name="search" id="search" value=" Search " class="actionBtn" /></td>
       </tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 2px;">
  <tr>
    <td style="border-top: 0px solid #99C; padding-left: 0px;">
    <table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr style="color: #FFF;">

	  <td width="3%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll"  onclick="check_all();" /></td>
       <td width="28%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Name</strong></td>
     <td width="31%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Email Id</strong></td>
       <td width="10%" align="center" bgcolor="#333333"><strong>Status</strong></td>
       <td width="13%" align="center" bgcolor="#333333"><strong>Joined On</strong></td>
        <td width="15%" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
       <?php 
	   
		if(isset($_POST['search']))
		{   
		if($_POST['search_by_status']!="") {
			
			$sq = "SELECT c1.*,c2.uname,c2.pwd,c2.is_active FROM ".USRTBL." AS c1,".LOGINTBL." AS c2 where c1.id = c2.uid 
				   AND c2.user_type = 'S' AND (c2.is_active LIKE '".$_POST['search_by_status']."') LIMIT ".$startpoint.",".$perpage; }
		else {
		$sq = "SELECT c1.*,c2.uname,c2.pwd,c2.is_active FROM ".USRTBL." AS c1,".LOGINTBL." AS c2 where c1.id = c2.uid 
				   AND c2.user_type = 'S' AND (c1.fname LIKE '%".$_POST['sertxt']."%' OR c1.lname LIKE '%".$_POST['sertxt']."%' 
				    OR c1.mail_id LIKE '%".$_POST['sertxt']."%' OR c2.uname LIKE '%".$_POST['sertxt']."%') LIMIT ".$startpoint.",".$perpage; }
		}
		else
		{
			$sq = "SELECT c1.*,c2.uname,c2.pwd,c2.is_active FROM ".USRTBL." AS c1,".LOGINTBL." AS c2 where c1.id = c2.uid 
				   AND c2.user_type = 'S' LIMIT ".$startpoint.",".$perpage;
		}
		
		$j=0;
		$rs = mysql_query($sq);
		if(mysql_num_rows($rs) > 0){
		if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=(10*($_GET["part"]-1))+1;}
		
		while($row=mysql_fetch_array($rs)){
		
		$l_info = mysql_fetch_array(mysql_query("select * from ".LOGINTBL." where uid = '".$row['id']."' AND user_type = 'S'"));
		
        $j++;
		$bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"'; ?>
        
    <tr <?php echo $bgcolor; ?>>
        <td align="center" >
        
    <input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');" <?php if($_SESSION['aid']==$row["id"]){?> disabled="disabled"<?php }?>/>
    
        	
        </td>
		<td align="left" style="padding-left: 5px;"><?php echo stripslashes($row["fname"])." ".stripslashes($row["lname"]); ?></td>
	    <td align="left" style="padding-left: 5px;"><?php echo $row["mail_id"]; ?></td>
		<td width="10%" align="center" >
		
       		<?php if($l_info["is_active"]=='0') { ?>
        	<a href="account.php?page=admin_user&task=activate&id=<?php echo $row["id"]; ?>"><span style="color:#FF0000">In Active</span> </a>
 			<?php } else {  ?>
  			<a href="account.php?page=admin_user&task=block&id=<?php echo $row["id"]; ?>"><span style="color:#390">Active</span> </a>
			<?php } ?>
        
        </td>
		<td width="13%" align="center" ><?php echo date("d/m/Y",strtotime($row["create_date"])); ?></td>
        <td width="15%" align="center" >
        
        <a id="box1" href="public/view_user.php?id=<?php echo $row["id"]; ?>">
        <img src="images/b_browse.png" alt="View User Detail" width="16" height="16" 
        border="0" title="View <?php echo $row["fname"]."'s"; ?> Detail" style="cursor: pointer;" /></a>&nbsp;
		
		<a href="account.php?page=create_user&amp;task=edit&amp;id=<?php echo $row["id"];  ?>">
        <img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit User Profile" style="cursor: pointer;" /></a>&nbsp;
        <?php if($_SESSION['aid']!=$row["id"]){?>
        <a href="account.php?page=admin_user&amp;task=delete&amp;id=<?php echo $row["id"];  ?> " onclick="return confirm('Are You Sure To Delete!');">
        <img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;" /></a>
        <?php }?>
        </td>
        
  </tr>
  	<?php $i++;}}else{ ?>
  <tr>
  	<td colspan="8" align="center" bgcolor="#F2FBFF">No Admin Listed</td>
  </tr>
  <?php  }  ?>
 </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td><input type="button" name="deleteall" id="deleteall1" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
      <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="publishall" id="publishall1" value="Active " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span><span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
      <input type="button" name="unpublishall" id="unpublishall1" value="inactive " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span>
      <input type="hidden" name="todo" id="todo" value=""/></td>
  </tr>
</table>
</form>
<!-- @end users list -->
  </td>
  </tr>
  <tr><td>
  <!--<span style="color:#CC6699">Hints : G.M (Genral Manager), S.A (Super Admin), I.M (Item Manager)</span>-->
  </td></tr>
</table></td>
  </tr>
  <tr>
    <td align="center" valign="top" style="padding-top: 10px;">
		<?php
            echo Paging(USRTBL,$perpage,"account.php?page=admin_user&","id IN (SELECT uid FROM ".LOGINTBL." )");
        ?>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-top: 10px;"><span style="color:#FF0000"><b>Note: </b></span>Search can be posible by First Name, Last Name or Email Id or Status . </td>
  </tr>
</table>
</div>