<?php 
//redirectuser();
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage =15;//limit in each page
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
				if($db->recordDelete(array('id' => $id),USERTBL) == 1){
					$db->recordDelete(array('uid' => $id,'user_type' => 'U'),LOGINTBL);
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=user_list';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=user_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=user_list';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("uid" => $id,'user_type' => 'U'),array('is_active'=>'1'),LOGINTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Activated successfully');location.href='account.php?page=user_list';</script>";
			}else{
				echo "<script>alert('No Records Updated');location.href='account.php?page=user_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Updated');location.href='account.php?page=user_list';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete company record
				if($db->recordUpdate(array("uid" => $id,'user_type' => 'U'),array('is_active'=>'0'),LOGINTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Blocked successfully');location.href='account.php?page=user_list';</script>";
			}else{
				echo "<script>alert('No Records Updated');location.href='account.php?page=user_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Updated');location.href='account.php?page=user_list';</script>";
		}
		break;
	}
}
// delete individual company
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	if(canDeleteCustomer($_GET['id']))
	{
		$datalists = $db->recordFetch($_GET['id'],AGENTTBL.":".'id');
		
		// delete Agent record
		
		
		$upd1 = mysql_query("DELETE FROM ".USERTBL." WHERE id = '".$_GET['id']."' ");
		$upd1 = mysql_query("DELETE FROM ".LOGINTBL." WHERE uid = '".$_GET['id']."' AND user_type = 'U'");
		
		
		echo "<script>location.href='account.php?page=user_list';</script>";
	}
	
}
//for active
if($_GET['id'] != "" && $_GET['task'] == "activate")
{
		$upd = "update ".LOGINTBL." set is_active = '1' where uid = '".$_GET['id']."' AND user_type = 'U'";
		mysql_query($upd) or die(mysql_error());
		echo "<script>alert('Record Activated Sucessfully');location.href='account.php?page=user_list';</script>";
}
//for block
if($_GET['id'] != "" && $_GET['task'] == "block")
{
		$upd = "update ".LOGINTBL." set is_active = '0' where uid = '".$_GET['id']."' AND user_type = 'U'";
		mysql_query($upd) or die(mysql_error());
		echo "<script>alert('Record Blocked Sucessfully');location.href='account.php?page=user_list';</script>";	
}
// export to excel
/*if($task == "export"){
		$datas = array();
		// fetch user list from database
	if(isset($_GET['sertxt']))
		 {
		if($_GET['emp_type']!='' && $_GET['sertxt']!='')
		{
		$emp=$_GET['emp_type'];
		$sqlist = mysql_query("SELECT * FROM ".USRTBL."  where emp_type_id='$emp' and (emp_fname LIKE '%".$_GET['sertxt']."%' OR emp_Lname LIKE '%".$_GET['sertxt']."%' OR emp_code='".$_GET['sertxt']."')");
		  	  
		}
		else
		 {
		   if($_GET['emp_type']=='' && $_GET['sertxt']=='')
		   {
		    $sqlist = mysql_query("SELECT * FROM ".USRTBL." where emp_type_id= '10'");
		   } 
		}
	  }else
		{
		$sqlist = mysql_query("SELECT * FROM ".USRTBL." where emp_type_id= '10'");
			}
		if(mysql_num_rows($sqlist) > 0){
		$i = 0;
		while($reslist = mysql_fetch_array($sqlist)){
			$i++;
			// save data to array
			array_push($datas,array('Name'=>$reslist['emp_fname']." ".$reslist['emp_lname'],'company Id'=>$reslist['emp_code'],'Username'=>$reslist['emp_uname'],'Email'=>$reslist['emp_email'],'Phone No'=>$reslist['emp_phone1'],'Position'=>$reslist['emp_position'],'Joindate'=>$reslist['date_of_join'],'Status'=>$reslist['emp_status']));
		}
		export_to_excel($datas,'empoyeelist123456');
		}
		else
		{
		$errmsg = "There is no active company in the list";
	    }
   	}*/

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
  var retVal = confirm("Do you want to Delete these User list ?");
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
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 2px; margin-top: 10px;">
     

</table>  
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px;  line-height: 15px; color: #666;">
          <tr>
            <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-top:3px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List/Manage Customers</strong></td>
            <td width="58%"  align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px;"><form method="get" style=" padding-bottom:4px;" action="">
              <input type="hidden" name="page" value="user_list" />
              <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 140px; font-weight: normal;" value="<?php echo $_GET['sertxt']; ?>" />
              <input type="submit" name="search" id="search" value="Search" class="actionBtn" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
              <input type="button" name="reset" id="reset" value="Reset" class="actionBtn" onclick="location.href='account.php?page=user_list'" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
            </form></td>
          </tr>
        </table>
              <!-- users list -->
              <form action="" method="post" name="chapter_fr" style="padding: 0px; margin: 0px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td width="57%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
                        <input type="button" name="publishall" id="publishall" value="Publish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
                        <input type="button" name="unpublishall" id="unpublishall" value="Unpublish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
                    </td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
                  <tr>
                    <td style="border-top: 0px solid #99C; padding-left: 0px;"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                        <tr style="color: #FFF;">
                          <td width="3%" align="center" bgcolor="#006699"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
                          <td width="12%" align="left" bgcolor="#006699" style="padding-left: 5px;"><strong>Customer Name</strong></td>
                          <td width="8%" align="center" bgcolor="#006699"><strong>Customer ID</strong></td>
                          <td width="12%" align="left" bgcolor="#006699" style="padding-left: 5px;"><strong>Agent Name</strong></td>
                          <td width="10%" align="left" bgcolor="#006699" style="padding-left: 5px;"><strong>Agent Id</strong></td>
                          <td width="9%" align="center" bgcolor="#006699"><strong>Phone No</strong></td>
                          <td width="11%" align="center" bgcolor="#006699"><strong>E-mail</strong></td>
                          <td width="11%" align="center" bgcolor="#006699"><strong>Created On</strong></td>
                          <td width="8%" align="center" bgcolor="#006699"><strong>Status</strong></td>
                          <td width="16%" align="center" bgcolor="#006699"><strong>Action</strong></td>
                        </tr>
                        <?php 
		if(isset($_GET['search'])){
		$sq = "SELECT a.id as 'id',a.agent_id as 'agent_id', a.fname as 'fname',a.lname as 'lname',a.cust_id as 'cust_id',a.phone1 as 'phone1',a.email as 'email',a.created_date as 'created_date',c.is_active as 'is_active' FROM ".USERTBL." a,".LOGINTBL." c where a.id=c.uid and c.user_type='U' and (fname LIKE '%".$_GET['sertxt']."%' OR lname LIKE '%".$_GET['sertxt']."%' OR cust_id LIKE '%".$_GET['sertxt']."%') ORDER BY a.id desc LIMIT ".$startpoint.",".$perpage;
		}
	//echo $sq;
		else{
		$sq = "SELECT a.id as 'id',a.agent_id as 'agent_id',a.fname as 'fname',a.lname as 'lname',a.cust_id as 'cust_id',a.phone1 as 'phone1',a.email as 'email',a.created_date as 'created_date',c.is_active as 'is_active' FROM ".USERTBL." a,".LOGINTBL." c where a.id=c.uid and c.user_type='U' ORDER BY a.id desc LIMIT ".$startpoint.",".$perpage;
		}
		
		$rs = mysql_query($sq);
		if(mysql_num_rows($rs) > 0){
		if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=1;}
		while($row=mysql_fetch_array($rs)){
		$sql_ag = mysql_query("SELECT * FROM ".AGENTTBL." WHERE id = '".$row['agent_id']."'");
		$asd =mysql_fetch_array($sql_ag);
		if(mysql_num_rows($sql_ag) >0){
		$agent = $asd['ag_fname']." ".$asd['ag_lname']."";
		$agentid=$asd['ag_code'];
		}else{
		  $agent = "--";
		  $agentid="";
		} 
			
		if($i % 2 == 0){ $bgcolor = "#F2F3F5"; }else{ $bgcolor = "#FFFFFF";  }
			  ?>
                        <tr bgcolor="<?php echo $bgcolor;?>">
                          <td align="center"><input type="checkbox" name="chkNo[]"  value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');" <?php if(canDeleteCustomer($row["id"])){?> id="chkNo<?php echo $i;?>"<?php }else{ echo 'disabled="disabled"';}?> /></td>
                          <td align="left"  style="padding-left: 5px;" title="<?php echo stripslashes($row["fname"])." ".stripslashes($row["lname"]); ?>"><?php echo stripslashes($row["fname"])." ".stripslashes($row["lname"]); ?></td>
                          <td width="8%" align="center" title="<?php echo $row["cust_id"]; ?>"><?php echo $row["cust_id"]; ?></td>
                          <td align="left"  style="padding-left: 5px;" title="<?php echo $agent; ?>"><?php echo $agent; ?></td>
                          <td align="left"  style="padding-left: 5px;" title="<?php echo $agentid; ?>"><?php echo $agentid; ?></td>
                          <td width="9%" align="center" title="<?php echo $row["phone1"]; ?>"><?php echo $row["phone1"]; ?></td>
                          <td width="11%" align="center" title="<?php echo $row["email"]; ?>"><?php echo $row["email"]; ?></td>
                          <td width="11%" align="center"  ><?php echo date('d-m-Y',strtotime($row["created_date"])); ?></td>
                          <?php if(isset($_GET['search'])){
			$url="account.php?page=user_list&sertxt=".$_GET['sertxt']."&emp_type=".$_GET['emp_type']."&search=search";
			} else $url="account.php?page=user_list"; ?>
                          <td width="8%" align="center" ><?php if($row['is_active']=='0') { ?>
                              <a href="<?php echo $url; ?>&task=activate&id=<?php echo $row["id"]; ?>">In Active
                                <?php } else {?>
                              </a><a href="<?php echo $url; ?>&task=block&id=<?php echo $row["id"]; ?>">Active </a>
                              <?php } ?></td>
                          <td width="16%" align="center" ><a id="box1" href="public/view_customer.php?id=<?php echo $row["id"]; ?>"><img src="images/b_browse.png" alt="View Customer Details" width="16" height="16" border="0" title="View Customer Details" style="cursor: pointer;" /></a>&nbsp;<a href="account.php?page=edit_customer&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit Customer Profile" style="cursor: pointer;" /></a>&nbsp;
			  <?php if(canDeleteCustomer($row["id"]))
			  {
			  ?>
			  <a href="account.php?page=user_list&amp;task=delete&amp;id=<?php echo $row["id"];  ?> " onclick="return confirm('Are You Sure To Delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete Customer" style="cursor: pointer;" /></a>
			  <?php
			  }
			  else
			  {
				 ?>
			  <a href="javascript:void(0);" onclick="alert('A Customer having financial transaction cannot be deleted!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete Customer" style="cursor: pointer; opacity: 0.5" /></a>
			  <?php
				
			  }
			  ?>
			  </td>
                        </tr>
                        <?php $i++;}}else{
			?>
                        <tr>
                          <td colspan="10" align="center" bgcolor="#F2FBFF">No Customer Listed</td>
                        </tr>
                        <?php
		}?>
                    </table></td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
                  <tr>
                    <td><input type="button" name="deleteall" id="deleteall1" value="Delete Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
                        <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
                        <input type="button" name="publishall" id="publishall1" value="Publish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
                        </span><span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
                        <input type="button" name="unpublishall" id="unpublishall1" value="Unpublish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
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
    <td align="center" valign="top" style="padding-top: 10px;"><?php
			 if(isset($_GET['search'])){
				
				 echo Paging(USERTBL,$perpage,"account.php?page=user_list&sertxt=".$_GET['sertxt']."&search=search&","fname LIKE '%".$_GET['sertxt']."%' OR lname LIKE '%".$_GET['sertxt']."%' OR cust_id LIKE '%".$_GET['sertxt']."%'");
					
					} 
					else{
					echo Paging(USERTBL,$perpage,"account.php?page=user_list&","");
					} 
			
			  ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-top: 10px;"><span style="color:#FF0000"><b>Note: </b></span>Search can be posible by Customer First Name or Last Name or Customer ID. </td>
  </tr>
</table>
