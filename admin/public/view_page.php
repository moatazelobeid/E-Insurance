<?php
//delete--all
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
					$db->recordDelete(array(id => $id),PAGETBL);
					$count++;
				
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('pg_status'=>'1'),PAGETBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('pg_status'=>'0'),PAGETBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
		}
		break;
	}
}

//
if($id != "" && $task == "delete")
{
	mysql_query("DELETE FROM ".PAGETBL." WHERE id = '".$_GET['id']."'");
	if(mysql_affected_rows() > 0)
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
	else
	echo "<script>alert('Record Deletion Failed');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
}
if(isset($_GET["id"]) && $_GET["action"]=="activate") {
$id=$_GET["id"];
$upd="update ".PAGETBL." set pg_status=1 where id='$id'";
mysql_query($upd) or die(mysql_error());
if(mysql_affected_rows() > 0)
	echo "<script>alert('Record Published Sucessfully');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
	else
	echo "<script>alert('Record Published Failed');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
}

if(isset($_GET["id"]) && $_GET["action"]=="block") {
$id=$_GET["id"];
$upd="update ".PAGETBL." set pg_status=0 where id='$id'";
mysql_query($upd) or die(mysql_error());
if(mysql_affected_rows() > 0)
	echo "<script>alert('Record Blocked Sucessfully');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
	else
	echo "<script>alert('Record Blocked Failed');location.href='account.php?page=view_page&part=".$_GET['part']."';</script>";
}
?>
<?php
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage;
?>
<script language="javascript" type="text/javascript">
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
  var retVal = confirm("Do you want to Delete these Page ?");
   if( retVal == true ){
      
	   document.chapter_fr.todo.value='deleteall';document.chapter_fr.submit();
	  return true;
   }else{
      
	  return false;
	
   }
 }
</script>

<div style="width: 100%; margin: 0 auto; margin-top: 25px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Page/Article Manager</strong></td>
      <td align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><a href="account.php?page=page"><div class="button_admin">Add New Page</div></a></td>
    </tr>
  </table>
  <form action="" method="post" name="chapter_fr" id="chapter_fr">
  <table width="100%" border="0" cellspacing="0" cellpadding="3" style="background-color: #f2f2f2;">
  
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="41%" align="left"><input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
         <input type="button" name="unpublishall2" id="unpublishall" value="Inactive" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/></td>
        <td width="28%" align="right">Page Title:</td>
        <td width="23%" style="padding-left: 4px;"><input name="pg_title" type="text" class="textbox" id="pg_title" style="width: 200px;" value="<?php echo $_POST["pg_title"]; ?>"></td>
        <td width="8%" align="left"><input type="submit" name="search" id="search" value=" Search " class="actionBtn"></td>
        </tr>
    </table>
  </td>
  </tr>
  
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border-top: 1px solid #99C; padding-left: 0px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr style="color: #FFF;">
        <td width="3%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
        <td width="5%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
        <td width="34%" align="left" bgcolor="#333333"><strong>Page/Article Title</strong></td>
        <td width="38%" align="left" bgcolor="#333333"><strong>Parent Page/Article</strong></td>
        <td width="10%" align="center" bgcolor="#333333"><strong>Status</strong></td>
        <td width="10%" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
      <?php
	  $i=0;
	  if(isset($_POST["search"])){
		  $j = 0;
	 $sq = mysql_query("SELECT * FROM ".PAGETBL." WHERE pg_title like '%".$_POST["pg_title"]."%' LIMIT ".$startpoint.",".$perpage);
	  }
	  else{
		  $j = 0;
		  $sq = mysql_query("SELECT * FROM ".PAGETBL." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	  }
	  if(mysql_num_rows($sq) > 0){
		  if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $j=0;}else{$j=(15*($_GET["part"]-1));}
	  while($res = mysql_fetch_array($sq)){
		  $i++;
		  $bgcolor = ($i%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
	  ?>
      <tr <?php echo $bgcolor; ?>>
        <td align="center"><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $res['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');" /></td>
        <td align="center"><strong><?php echo $i; ?></strong></td>
        <td align="left"><?php echo stripslashes($res["pg_title"]); ?></td>
        <td><?php $sjq=mysql_fetch_array(mysql_query("SELECT * FROM ".PAGETBL." WHERE id='".$res["parent_item"]."'")); if($sjq["pg_title"] != "")echo stripslashes($sjq["pg_title"]); else echo "---"; ?></td>
        <td align="center"><?php if($res["pg_status"]=='1') { ?>
          <a href="account.php?page=view_page&amp;action=block&amp;id=<?php echo $res["id"]; ?>"><font color="green">Active</font>
          <?php } else {?>
          </a><a href="account.php?page=view_page&amp;action=activate&amp;id=<?php echo $res["id"]; ?>"><font color="red">Inactive </font></a>
          <?php } ?></td>
        <td align="center"><a href="account.php?page=page&id=<?php echo $res['id']; ?>&part=<?php echo $_GET['part']; ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a>&nbsp;<a href="account.php?page=view_page&task=delete&id=<?php echo $res['id']; ?>&part=<?php echo $_GET['part']; ?>" onclick="return confirm('Are you sure to delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a></td>
        </tr>
      <?php
	  }}else{
		  ?>
          <tr>
        <td colspan="6" align="center" bgcolor="#F2FBFF">No Record Found</td>
        </tr>
          <?php
	  }
	  ?>
	            <tr>
        <td colspan="6" align="left" bgcolor="#F2FBFF"><input type="button" name="deleteall" id="deleteall1" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
      <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="publishall" id="publishall1" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span><span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
      <input type="button" name="unpublishall" id="unpublishall1" value="Inactive" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span>
      <input type="hidden" name="todo" id="todo" value=""/></td>
        </tr>

      <tr>
            <td colspan="6" align="center">
<?php
			 if(isset($_POST['search'])){
				  echo Paging(PAGETBL,$perpage,"account.php?page=view_page&","pg_title LIKE '%".$_POST['pg_title']."%' ORDER BY pg_title DESC");
					
					}else{
					echo Paging(PAGETBL,$perpage,"account.php?page=view_page&");
					} 
			
			  ?>			
			
			</td>
          </tr>
          <tr><td colspan="8"><span style="color:red">Note: Search can be posible by page name.</span></td></tr>
    </table></td>
  </tr>
  
</table></form>
</div>