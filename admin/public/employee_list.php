<?php 
//redirectuser();
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 
if(isset($_GET['search']))
{
$emp=$_GET['emp_type'];
$sterm="&emp_type=$emp&sertxt=".$_GET['sertxt'];	
}
// delete all Employees
if(isset($_POST['todo'])){
	// case
	switch($_POST['todo']){
		case 'deleteall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete Employee record
				if($db->recordDelete(array('id' => $id),EMPLOYEETBL) == 1){
					$db->recordDelete(array('uid' => $id,'user_type' => 'E'),LOGINTBL);
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=employee_list';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=employee_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=employee_list';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete Employee record
				if($db->recordUpdate(array("uid" => $id,'user_type' => 'E'),array('is_active'=>'1'),LOGINTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Activated successfully');location.href='account.php?page=employee_list';</script>";
			}else{
				echo "<script>alert('No Records Updated');location.href='account.php?page=employee_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Updated');location.href='account.php?page=employee_list';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete employee record
				if($db->recordUpdate(array("uid" => $id,'user_type' => 'E'),array('is_active'=>'0'),LOGINTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Blocked successfully');location.href='account.php?page=employee_list';</script>";
			}else{
				echo "<script>alert('No Records Updated');location.href='account.php?page=employee_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Updated');location.href='account.php?page=employee_list';</script>";
		}
		break;
	}
}
// delete individual employee
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
$datalists = $db->recordFetch($_GET['id'],EMPLOYEETBL.":".'id');
$photopath=getElementVal('emp_photo',$datalists);
unlink("../upload/user/$photopath");
		
	// delete employee record
	
	$fetch = mysql_query ("SELECT * FROM ".EMPLOYEETBL." where id = '".$_GET['id']."'");
	$row = mysql_fetch_array($fetch);
	$upd1 = mysql_query("DELETE FROM ".LOGINTBL." WHERE uid = '".$row["id"]."' AND user_type = 'E'");
	
	$db->recordDelete(array('id'=> $_GET['id']),EMPLOYEETBL);
	echo "<script>location.href='account.php?page=employee_list';</script>";
}
//for active
if($_GET['id'] != "" && $_GET['task'] == "activate")
{
		$upd = "update ".LOGINTBL." set is_active = '1' where uid = '".$_GET['id']."' AND user_type = 'E'";
		mysql_query($upd) or die(mysql_error());
		echo "<script>alert('Record Activated Sucessfully');location.href='account.php?page=employee_list';</script>";
}
//for block
if($_GET['id'] != "" && $_GET['task'] == "block")
{
		$upd = "update ".LOGINTBL." set is_active = '0' where uid = '".$_GET['id']."' AND user_type = 'E'";
		mysql_query($upd) or die(mysql_error());
		echo "<script>alert('Record Blocked Sucessfully');location.href='account.php?page=employee_list';</script>";	
}
// export to excel
if($task == "export"){
		$datas = array();
		// fetch Employee list from database
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
			array_push($datas,array('Name'=>$reslist['emp_fname']." ".$reslist['emp_lname'],'Employee Id'=>$reslist['emp_code'],'Username'=>$reslist['emp_uname'],'Email'=>$reslist['emp_email'],'Phone No'=>$reslist['emp_phone1'],'Position'=>$reslist['emp_position'],'Joindate'=>$reslist['date_of_join'],'Status'=>$reslist['emp_status']));
		}
		export_to_excel($datas,'empoyeelist123456');
		}
		else
		{
		$errmsg = "There is no active employee in the list";
	    }
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
  var retVal = confirm("Do you want to Delete these Employee List ?");
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
    <tr>

      <td align="right" style="border-bottom: 0px solid #CCC; padding-bottom: 0px; padding-left: 0px; font-size: 14px; color: #036;">
	  
	<!--  <input type="button" name="export" id="export" value=" Export To Excel " class="actionBtn" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; cursor: pointer;" onclick="location.href='account.php?page=emplist&task=export<?php //echo $sterm;  ?>'"/>-->
	  
         <!--<input type="button" name="addnew" class="actionBtn" id="addnew" value=" Add New Employee " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; cursor: pointer;" onclick="location.href='account.php?page=add_employee'"/>-->
      </td>

    </tr> 

  </table>  
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>

    <td>
    
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px;  line-height: 15px; color: #666;">
  <tr>
        <td width="28%" align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-top:3px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List/Manage Employee </strong></td>

     <?php /*?><td width="72%"  align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px;"> 
  
<form method="get" style=" padding-bottom:4px;" action="">
	
    <input type="hidden" name="page" value="employee_list" />
	<select name="emp_type" id="emp_type" style="width:154px;font-weight:normal;padding:0px;margin-top:3px;padding:3px;">
	<option value="">Select Employee Type</option>
	<?php
	$sqlist = mysql_query("SELECT * FROM ".EMPTYPE." WHERE status ='1'");
	while($reslist = mysql_fetch_array($sqlist)){
	?>
	<option value="<?php echo $reslist['id'];?>" <?php if($_GET['emp_type'] == $reslist['id']) echo "selected='selected'"; ?>><?php echo $reslist['emp_type']?></option>
    <?php }?>
    </select>  
 <!-- <p>
		<label for="search">
			<strong>Enter keyword to search </strong>
		</label>
		
	</p>-->
	<input type="text" id="search" class="textbox" placeholder="Search By Keyword" style="width: 120px; font-weight: normal;"/>
  <!--<input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 140px; font-weight: normal;" value="<?php echo $_GET['sertxt']; ?>">-->   
  <input type="submit" name="search" id="search" value="Search" class="actionBtn" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
  <input type="button" name="reset" id="reset" value="Reset" class="actionBtn" onclick="location.href='account.php?page=employee_list'" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
  </form>
  
 </td><?php */?>
  </tr>
</table>

    <!-- Employees list -->
	   <form action="" method="post" name="chapter_fr" style="padding: 0px; margin: 0px;">

  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr>
       <td width="57%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
	   <input type="button" name="deleteall" id="deleteall" value="Delete Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Publish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
         <input type="button" name="unpublishall" id="unpublishall" value="Unpublish Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
		
		 </td>
      
	  <td width="72%"  align="right" style="padding-left: 1px; padding-right: 1px; font-size: 14px;"> 
  
<form method="get" style=" padding-bottom:4px;" action="">
	
    <input type="hidden" name="page" value="employee_list" />
	<select name="emp_type" id="emp_type" style="width:154px;font-weight:normal;padding:0px;margin-top:3px;padding:3px;">
	<option value="">Select Employee Type</option>
	<?php
	$sqlist = mysql_query("SELECT * FROM ".EMPTYPE." WHERE status ='1'");
	while($reslist = mysql_fetch_array($sqlist)){
	?>
	<option value="<?php echo $reslist['id'];?>" <?php if($_GET['emp_type'] == $reslist['id']) echo "selected='selected'"; ?>><?php echo $reslist['emp_type']?></option>
    <?php }?>
    </select>  
 <!-- <p>
		<label for="search">
			<strong>Enter keyword to search </strong>
		</label>
		
	</p>-->
	<input type="text" id="search" class="textbox" placeholder="Search By Keyword" style="width: 120px; font-weight: normal;"/>
  <!--<input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 140px; font-weight: normal;" value="<?php echo $_GET['sertxt']; ?>">-->   
  <input type="submit" name="search" id="search" value="Search" class="actionBtn" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
  <input type="button" name="reset" id="reset" value="Reset" class="actionBtn" onclick="location.href='account.php?page=employee_list'" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
  </form>
  
 </td>
      
       </tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:3px;">
  <tr>
    <td style="border-top: 0px solid #99C; padding-left: 0px;">
    
    <table width="100%" border="0" cellspacing="1" cellpadding="2" id="tblData">
      <tr style="color: #FFF;">

	  <td width="4%" align="center" bgcolor="#006699"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
       <td width="17%" align="left" bgcolor="#006699" style="padding-left: 5px;"><strong>Name</strong></td>
	   <td width="11%" align="center" bgcolor="#006699"><strong>Employee Id</strong></td>
       <!--<td width="10%" align="center" bgcolor="#006699"><strong>Username</strong></td>-->
       <td width="13%" align="center" bgcolor="#006699"><strong>Email</strong></td>
       <td width="10%" align="center" bgcolor="#006699"><strong>Phone</strong></td>
       <td width="11%" align="center" bgcolor="#006699"><strong>Joined On</strong></td>
	   <td width="11%" align="center" bgcolor="#006699"><strong>Status</strong></td>
        <td width="11%" align="center" bgcolor="#006699"><strong>Action</strong></td>
		
      </tr>
       <?php 
		if(isset($_GET['search'])){
		if($_GET['emp_type']!='')
		{
		$emp=$_GET['emp_type'];
 $sq = "SELECT * FROM ".EMPLOYEETBL."  where emp_type_id='$emp' and (emp_fname LIKE '%".$_GET['sertxt']."%' OR emp_Lname LIKE '%".$_GET['sertxt']."%' OR emp_code='".$_GET['sertxt']."') LIMIT ".$startpoint.",".$perpage;
		}else
		{
		$sq = "SELECT * FROM ".EMPLOYEETBL." where (emp_fname LIKE '%".$_GET['sertxt']."%' OR emp_Lname LIKE '%".$_GET['sertxt']."%') LIMIT ".$startpoint.",".$perpage;
		}
	//echo $sq;
		}else{
		$sq = "SELECT * FROM ".EMPLOYEETBL." ORDER BY id LIMIT ".$startpoint.",".$perpage;
		}
		
		$rs = mysql_query($sq);
		if(mysql_num_rows($rs) > 0){
		if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		while($row=mysql_fetch_array($rs)){
		
		$sq = mysql_query("select * from ".LOGINTBL." WHERE uid='".$row['id']."' AND user_type = 'E'");
        $smq1=mysql_fetch_array($sq);
		
		if($i % 2 == 0){ $bgcolor = "#F2F3F5"; }else{ $bgcolor = "#FFFFFF";  }
			  ?>
      <tr bgcolor="<?php echo $bgcolor;?>" id="rowid">
        <td align="center"><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');" /></td>
		<td align="left"  style="padding-left: 5px;"><?php echo stripslashes($row["emp_fname"])." ".stripslashes($row["emp_lname"]); ?></td>
		<td width="11%" align="center"><?php echo $row["emp_code"]; ?></td>
		<!--<td width="10%" align="center"><?php echo $row["emp_uname"]; ?></td>-->
		<td width="13%" align="center"><?php echo $row["emp_email"]; ?></td>
		<td width="10%" align="center" ><?php echo $row["emp_phone1"]; ?></td>
		
	
		
		
		<td width="11%" align="center"><?php echo stripslashes($row["date_of_join"]); ?></td>
		<?php if(isset($_GET['search'])){
			$url="account.php?page=employee_list&sertxt=".$_GET['sertxt']."&emp_type=".$_GET['emp_type']."&search=search";
			} else $url="account.php?page=employee_list"; ?>
        <td width="11%" align="center" ><?php if($smq1['is_active']=='0') { ?>
          <a style="color:red;" href="<?php echo $url; ?>&task=activate&id=<?php echo $row["id"]; ?>">In Active
  <?php } else {?>
  </a><a href="<?php echo $url; ?>&task=block&id=<?php echo $row["id"]; ?>">Active
  
  </a>
  <?php } ?></td>
        <td width="11%" align="center" ><a id="box1" href="public/view_employee.php?id=<?php echo $row["id"]; ?>"><img src="images/b_browse.png" alt="View <?php echo $row["fname"]." ".$row["lname"]; ?> Detail" width="16" height="16" border="0" title="View Employee Detail" style="cursor: pointer;" /></a>&nbsp;<a href="account.php?page=add_employee&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit Employee Profile" style="cursor: pointer;" /></a>&nbsp;<a href="account.php?page=employee_list&amp;task=delete&amp;id=<?php echo $row["id"];  ?> " onclick="return confirm('Are You Sure To Delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete Employee" style="cursor: pointer;" /></a></td>
  </tr>
        <?php $i++;}}else{
			?>
            <tr>
        <td colspan="10" align="center" bgcolor="#F2FBFF">No employee Listed</td>
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

<!-- @end Employees list -->
  </td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td align="center" valign="top" style="padding-top: 10px;"><?php
			 if(isset($_GET['search'])){
				
				// echo Paging(EMPLOYEETBL,$perpage,"account.php?page=emplist&emp_type=".$_GET['emp_type']."&sertxt=".$_GET['sertxt']."&search=search&","emp_type_id=10 and (emp_fname LIKE '%".$_GET['sertxt']."%' OR emp_Lname LIKE '%".$_GET['sertxt']."%')");
					if($_GET['emp_type']!='') {
					echo Paging(EMPLOYEETBL,$perpage,"account.php?page=employee_list&emp_type=".$_GET['emp_type']."&sertxt=".$_GET['sertxt']."&search=Search&","emp_type_id='$emp' and (emp_fname LIKE '%".$_GET['sertxt']."%' OR emp_Lname LIKE '%".$_GET['sertxt']."%' OR emp_code='".$_GET['sertxt']."')"); }
					
					else {
					echo Paging(EMPLOYEETBL,$perpage,"account.php?page=employee_list&emp_type=".$_GET['emp_type']."&sertxt=".$_GET['sertxt']."&search=Search&","(emp_fname LIKE '%".$_GET['sertxt']."%' OR emp_Lname LIKE '%".$_GET['sertxt']."%')"); }
					} 
					else{
					//echo Paging(EMPLOYEETBL,$perpage,"account.php?page=emplist&","emp_type_id='10'");
					echo Paging(EMPLOYEETBL,$perpage,"account.php?page=employee_list&");
					} 
			
			  ?></td>
  </tr>
  <!--<tr>
    <td align="left" valign="top" style="padding-top: 10px;">
	<span style="color:#FF0000"><b>Note: </b></span>Search can be posible by First Name or Last Name.
	</td>
  </tr>-->
  
</table>
