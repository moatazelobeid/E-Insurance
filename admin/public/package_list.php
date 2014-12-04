<?php 
//redirectuser();
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
				if($db->recordDelete(array('id' => $id),PACKAGE) == 1){
					//$db->recordDelete(array('uid' => $id,'user_type' => 'A'),LOGINTBL);
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=package_list';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=package_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=package_list';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),PACKAGE) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Activated successfully');location.href='account.php?page=package_list';</script>";
			}else{
				echo "<script>alert('No Records Updated');location.href='account.php?page=package_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Updated');location.href='account.php?page=package_list';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete company record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),PACKAGE) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Blocked successfully');location.href='account.php?page=package_list';</script>";
			}else{
				echo "<script>alert('No Records Updated');location.href='account.php?page=package_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Updated');location.href='account.php?page=package_list';</script>";
		}
		break;
	}
}
// delete individual company
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	$fetch = mysql_query ("SELECT * FROM ".PACKAGE." where id = '".$_GET['id']."'");
	$row = mysql_fetch_array($fetch);
	$upd1 = mysql_query("DELETE FROM ".PACKAGECOVER." WHERE package_no = '".$row["package_no"]."'");
	
	$db->recordDelete(array('id'=> $_GET['id']),PACKAGE);
	echo "<script>location.href='account.php?page=package_list';</script>";
}
//for active
if($_GET['id'] != "" && $_GET['task'] == "activate")
{
	$upd = "update ".PACKAGE." set status = '1' where id = '".$_GET['id']."'";
	mysql_query($upd) or die(mysql_error());
	echo "<script>alert('Record Activated Sucessfully');location.href='account.php?page=package_list';</script>";
}
//for block
if($_GET['id'] != "" && $_GET['task'] == "block")
{
	$upd = "update ".PACKAGE." set status = '0' where id = '".$_GET['id']."'";
	mysql_query($upd) or die(mysql_error());
	echo "<script>alert('Record Blocked Sucessfully');location.href='account.php?page=package_list';</script>";	
}
?>
<!--JQuery search code start-->
<script type="text/javascript">
$(document).ready(function()
{
	$('#search').keyup(function()
	{
		searchTable($(this).val());
	});

setTimeout(function() {$(".msgdiv").slideUp()}, 3000);
});

function searchTable(inputVal)
{
	var table = $('#tblData');
	table.find('#rowid').each(function(index, row)
	{
		var allCells = $(row).find('td');
		if(allCells.length > 0)
		{
			var found = false;
			allCells.each(function(index, td)
			{
				var regExp = new RegExp(inputVal, 'i');
				if(regExp.test($(td).text()))
				{
					found = true;
					return false;
				}
			});
			if(found == true)$(row).show();else $(row).hide();
		}
	});
}
</script>
<!--JQuery search code end-->
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
			if(document.getElementById('chkNo'+l))
			{
				obj = document.getElementById('chkNo'+l);
				document.getElementById("chkNo" + l).checked = true;
			}
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
			if(document.getElementById("chkNo" + m))
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
  var retVal = confirm("Do you want to Delete these Agent List ?");
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
<style>
.msgdiv
{
	/*margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;*/
}
</style>
<form action="" method="post" name="chapter_fr" style="padding: 0px; margin: 0px;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px;">
          <tr>
            <td align="left" style="border-bottom: 1px solid #CCC; padding-left: 0px; font-size: 14px; color: #036;">
            <strong>List/Manage Underwritting </strong>
            </td>
            <td width="58%"  align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 12px; padding-right: 0px; padding-top: 5px;">
           
         <a href="account.php?page=package" class="linkBtn">Add New</a></td>
          </tr>
        </table>
        <?php  if(isset($_GET['added'])){ ?>
		<div class="msgdiv">
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;">
		  <tr>
			<td width="2%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
			<td width="98%"><?php echo "Package Added Successfully"; ?></td>
		  </tr>
		</table>
		</div>
		<?php } ?>
		
		<?php if(isset($_GET['updated'])){ ?>
		<div class="msgdiv">
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;">
		  <tr>
			<td width="2%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
			<td width="98%"><?php echo "Package Updated Successfully"; ?></td>
		  </tr>
		</table>
		</div>
		<?php } ?>
        
              <!-- users list -->
              
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td width="28%" align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; font-size: 14px; color: #036;"><input type="button" name="deleteall2" id="deleteall" value="Delete Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
                        <input type="button" name="publishall2" id="publishall" value="Publish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
                        <input type="button" name="unpublishall2" id="unpublishall" value="Unpublish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>                    </td>
                    <td width="29%"  align="right" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
              <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 180px; padding: 3px 3px 3px 3px;" value="<?php echo $_POST['sertxt']; ?>" placeholder="Search Package"/>
              <input type="submit" name="search" id="search" value="Search" class="actionBtn" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
              <input type="button" name="reset" id="reset" value="Reset" class="actionBtn" onclick="location.href='account.php?page=package_list'" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
			</td></tr></table>
			
					</td>
      </tr>
                <tr><td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;" id="tblData">
                  <tr>
                    <td style="border-top: 0px solid #99C; padding-left: 0px;">
					<table width="100%" border="0" cellspacing="0" cellpadding="3">
                        <tr style="color: #FFF;">
                          <td width="3%" align="center" bgcolor="#8B8585"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
                          
                          <td width="10%" align="center" bgcolor="#8B8585" style="padding-left: 5px;"><strong>Package No.</strong></td>
                          <td width="22%" align="left" bgcolor="#8B8585"><strong>Package Title</strong></td>
                          <td width="17%" align="center" bgcolor="#8B8585"><strong>Policy Type </strong></td>
                       	  <td width="11%" align="center" bgcolor="#8B8585"><strong> Price (SR) </strong></td>
                       	  <td width="10%" align="center" bgcolor="#8B8585"><strong>Total Covers </strong></td>
                       	  <td width="11%" align="center" bgcolor="#8B8585"><strong>Created Date </strong></td>
                          <td width="8%" align="center" bgcolor="#8B8585"><strong>Status</strong></td>
                          <td width="8%" align="center" bgcolor="#8B8585"><strong>Action</strong></td>
                        </tr>
                        <?php 
		if(isset($_POST['search'])){
		$sq = "SELECT * FROM ".PACKAGE." WHERE (package_title LIKE '%".$_POST['sertxt']."%' OR package_title_ar LIKE '%".$_POST['sertxt']."%') OR package_no = '".$_POST['sertxt']."' order by id desc LIMIT ".$startpoint.",".$perpage;
		}
		else{
		$sq = "SELECT * FROM ".PACKAGE." ORDER BY id desc LIMIT ".$startpoint.",".$perpage;
		}
		//echo $sq;
		$rs = mysql_query($sq);
		if(mysql_num_rows($rs) > 0){
		if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=($perpage*($_GET["part"]-1))+1;}
		while($row=mysql_fetch_array($rs)){
		
        $smq1=mysql_fetch_array($sq);
		
		if($i % 2 == 0){ $bgcolor = "#F2F3F5"; }else{ $bgcolor = "#FFFFFF";  }
		?>
                        <tr bgcolor="<?php echo $bgcolor;?>" id="rowid">
                          <td align="center">
                          <input type="checkbox" name="chkNo[]" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');" <?php if(canDeleteAgent($row["id"])){ ?> id="chkNo<?php echo $i;?>"<?php }else { echo 'disabled="disabled"';}?> />                          </td>
                          <td width="10%" align="center"><?php echo $row["package_no"]; ?></td>
                          <td align="left"  style="padding-left: 5px;"><?php echo stripslashes($row["package_title"]);?></td>
                          <td width="17%" align="left">
						  <?php
						  // will show policy class and policy type
						  $policytype = $db->recordFetch($row["policy_type_id"],POLICYTYPES.":".'id');
						  $policyclass = $db->recordFetch($policytype['policy_id'],POLICIES.":".'id');
						  
						  if($policyclass['title'] != ""){
						  		echo stripslashes($policyclass['title'])." (".$policytype['policy_type'].")";
						  }	  
						  ?>						  </td>
                          <td width="11%" align="center"><?php echo $row["package_amt"]; ?></td>
                          <td width="10%" align="center">
						  <?php
						   $total_covers = mysql_fetch_object(mysql_query("SELECT COUNT(*) as total FROM ".PACKAGECOVER." where package_no = '".$row["package_no"]."'"));
						   echo $total_covers->total;
						  ?>
						  </td>
                          <td width="11%" align="center" ><?php echo date('d-m-Y',strtotime($row["created_date"])); ?></td>
                          <?php
						  $ads = mysql_fetch_array(mysql_query("SELECT * FROM ".PRODUCTS." WHERE id = '".$row['product_id']."'")); 
						  $url = "account.php?page=package&task=package_edit&policy_id=".$ads['policy_class_id']."&policytype=".$row['policy_type_id']."&id=".$row['id'];
						  ?>
                          <td width="8%" align="center" ><?php if($row['status']=='0') { ?>
                              <a href="account.php?page=package_list&task=activate&id=<?php echo $row["id"];?>">
                              <font color='red'>Inactive</font>                              </a>
                              <?php } else{?>
                              <a href="account.php?page=package_list&task=block&id=<?php echo $row["id"];?>">
                              Active                              </a>
                              <?php }?></td>
                          <td width="8%" align="center">
							
						    <a id="box1" href="public/view_package.php?id=<?php echo $row["id"]; ?>">
                            <img src="images/b_browse.png" alt="View Package Details" width="16" height="16" border="0" title="View Agent Details" style="cursor: pointer;" />                            </a>&nbsp;
							  <a href="<?php echo $url;?>">
                              <img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit Agent Profile" style="cursor: pointer;" />                              </a>&nbsp;
                              
                              
							  <a href="account.php?page=package_list&amp;task=delete&amp;id=<?php echo $row["id"];?> " onclick="return confirm('Are You Sure To Delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete Agent" style="cursor: pointer;" /></a>       					  </td>
                        </tr>
                        <?php $i++;}}else{
			?>
                        <tr>
                          <td colspan="12" align="center" bgcolor="#F2FBFF">No Package Found </td>
                        </tr>
                        <?php
		}?>
                    </table></td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
                  <tr>
                    <td style="padding-left: 0px;"><input type="button" name="deleteall" id="deleteall1" value="Delete Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
                        <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
                        <input type="button" name="publishall" id="publishall1" value="Publish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
                        </span><span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
                        <input type="button" name="unpublishall" id="unpublishall1" value="Unpublish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
                        </span>
                        <input type="hidden" name="todo" id="todo" value=""/></td>
                  </tr>
                </table>
              
          <!-- @end users list -->
        </td>
      </tr>
    </table>
	
	</td>
  </tr>
  <tr>
    <td align="center" valign="top" style="padding-top: 10px;"><?php
			 if(isset($_GET['search'])){
				  echo Paging(PACKAGE,$perpage,"account.php?page=package_list&","(package_title LIKE '%".$_POST['sertxt']."%' OR package_title_ar LIKE '%".$_POST['sertxt']."%' OR ag_code LIKE '%".$_POST['sertxt']."%') OR package_no = '".$_POST['sertxt']."'");
					
					} 
					else{
					echo Paging(PACKAGE,$perpage,"account.php?page=package_list&");
					} 
			
			  ?></td>
  </tr>
</table>
</form>