
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
				if($db->recordDelete(array('id'=>$id),MEDIATBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=view_media';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=view_media';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=view_media';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),MEDIATBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=view_media';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=view_media';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=view_media';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),MEDIATBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=view_media';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='account.php?page=view_media';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='account.php?page=view_media';</script>";
		}
		break;
	}
}
//print_r ($_SESSION);


// delete individual users
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	if($db->recordDelete(array('id'=>$_GET['id']),MEDIATBL) == 1){
		
	// delete user login record
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=view_media';</script>";
	}
}

//for active
if($_GET['id'] != "" && $_GET['task'] == "activate")
{
		$upd = "update ".MEDIATBL." set status  = '1' where id = '".$_GET['id']."'";
		mysql_query($upd) or die(mysql_error());
		echo "<script>alert('Record Activated Sucessfully');</script>";
}
//for block
if($_GET['id'] != "" && $_GET['task'] == "block")
{
	    $upd = "update ".MEDIATBL." set status  = '0' where id = '".$_GET['id']."'";
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
  var retVal = confirm("Do you want to Delete these Media ?");
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

      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List/Manage Media </strong></td>
      <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">

<a href="account.php?page=media"><img src="images/add_new.png" width="87" height="15" border="0"></a>
	  
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
        <!-- <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 150px; font-weight: normal;" value="<?php //echo $_POST['sertxt']; ?>">
         <input type="submit" name="search" id="search" value=" Search " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />--></td>
       </tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td style="border-top: 0px solid #99C; padding-left: 0px;">
    <table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr style="color: #FFF;">

	  <td width="3%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll"  onclick="check_all();" /></td>
       <td width="32%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Media Title </strong></td>
       <td width="14%" align="center" bgcolor="#333333"><strong>View</strong></td>
       <td width="15%" align="center" bgcolor="#333333"><strong>Type</strong></td>
       <td width="11%" align="center" bgcolor="#333333"><strong>Status</strong></td>
       <td width="14%" align="center" bgcolor="#333333"><strong>Created On</strong></td>
        <td width="11%" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
       <?php 
	   
		if(isset($_POST['search']))
		{		
			$sq = "SELECT c1.*,c2.uname,c2.pwd,c2.is_active FROM ".USRTBL." AS c1,".LOGINTBL." AS c2 where c1.id = c2.uid 
				   AND c2.user_type = 'S' AND (c1.fname LIKE '%".$_POST['sertxt']."%' OR c1.lname LIKE '%".$_POST['sertxt']."%' 
				   OR c2.uname LIKE '%".$_POST['sertxt']."%') LIMIT ".$startpoint.",".$perpage;
		}
		else
		{
			$sq = "SELECT * from ".MEDIATBL."  order by id desc LIMIT ".$startpoint.",".$perpage;
		}
		
		$j=0;
		$rs = mysql_query($sq);
		if(mysql_num_rows($rs) > 0){
		if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=(10*($_GET["part"]-1))+1;}
		
		while($row=mysql_fetch_array($rs)){
		
		
        $j++;
		$bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"'; ?>
        
    <tr <?php echo $bgcolor; ?>>
        <td align="center" >
        
    <input type="checkbox" name="chkNo[]" id="chkNo<?php echo $j;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $j;?>');" <?php if($_SESSION['aid']==$row["id"]){?> disabled="disabled"<?php }?>/>
    
        	
        </td>
		<td align="left" style="padding-left: 5px;"><?php echo $row["title"]; ?></td>
		<td width="14%" align="center" >
		<a href="<?php echo BASE_URL;?>public/video_view.php?id=<?php echo $row['id']; ?>" class="video_view"><img src="<?php echo BASE_URL; ?>images/view_button.gif" border="0" style="cursor: pointer;" title="View Details"/></a>
		</td>
		<td width="15%" align="center" ><?php echo $row["type"]; ?></td>
		<td width="11%" align="center" >
		
       		<?php if($row["status"]=='0') { ?>
        	<a href="account.php?page=view_media&task=activate&id=<?php echo $row["id"]; ?>">In Active </a>
 			<?php } else {  ?>
  			<a href="account.php?page=view_media&task=block&id=<?php echo $row["id"]; ?>"><span style="color:#390">Active</span> </a>
			<?php } ?>
        
        </td>
		<td width="14%" align="center" ><?php echo date("d/m/Y",strtotime($row["create_date"])); ?></td>
        <td width="11%" align="center" >
        
       
		
		<a href="account.php?page=media&amp;task=edit&amp;id=<?php echo $row["id"];  ?>">
        <img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit File" style="cursor: pointer;" /></a>&nbsp;
        <a href="account.php?page=view_media&amp;task=delete&amp;id=<?php echo $row["id"];  ?> " onclick="return confirm('Are You Sure To Delete!');">
        <img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete File" style="cursor: pointer;" /></a>
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
            echo Paging(MEDIATBL,$perpage,"account.php?page=view_media&");
        ?>
    </td>
  </tr>
</table>
