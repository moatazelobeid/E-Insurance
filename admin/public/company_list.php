<?php 
//redirectuser();
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 

//save partners
if(isset($_POST["save_partners"]))
{ 
	$partners=$_POST['partners'];
	$id=$_POST['id'];
		
	for($n = 0; $n < count($id); $n++)
	{	
		$qry="update ".COMPANYTBL." set partner='0' where id=".$id[$n];
		mysql_query($qry) or die(mysql_error());
	}
		
	for($i = 0; $i < count($partners); $i++)
	{	
		$qry2="update ".COMPANYTBL." set partner='1' where id=".$partners[$i];
		mysql_query($qry2) or die(mysql_error());
	}
}


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
				if($db->recordDelete(array('id' => $id),COMPANYTBL) == 1){
				$db->recordUpdate(array("comp_id" => $id),array('del_status' => '1'),AUTOPOLICY);
				$db->recordUpdate(array("comp_id" => $id),array('del_status' => '1'),HEALTHPOLICY);
				$db->recordUpdate(array("comp_id" => $id),array('del_status' => '1'),MALPRACTICEPOLICY);
				$db->recordUpdate(array("comp_id" => $id),array('del_status' => '1'),TRAVELPOLICY);
					$db->recordDelete(array('uid' => $id,'user_type' => 'C'),LOGINTBL);
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=company_list';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=company_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=company_list';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("uid" => $id,'user_type' => 'C'),array('is_active'=>'1'),LOGINTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Activated successfully');location.href='account.php?page=company_list';</script>";
			}else{
				echo "<script>alert('No Records Updated');location.href='account.php?page=company_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Updated');location.href='account.php?page=company_list';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete company record
				if($db->recordUpdate(array("uid" => $id,'user_type' => 'C'),array('is_active'=>'0'),LOGINTBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Blocked successfully');location.href='account.php?page=company_list';</script>";
			}else{
				echo "<script>alert('No Records Updated');location.href='account.php?page=company_list';</script>";
			}
		}else{
			echo "<script>alert('No Records Updated');location.href='account.php?page=company_list';</script>";
		}
		break;
	}
}
// delete individual company
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
$datalists = $db->recordFetch($_GET['id'],COMPANYTBL.":".'id');
$photopath=getElementVal('comp_logo',$datalists);
unlink("../upload/company/$photopath");
		
	// delete company record
	
	$fetch = mysql_query ("SELECT * FROM ".COMPANYTBL." where id = '".$_GET['id']."'");
	$row = mysql_fetch_array($fetch);
	$upd1 = mysql_query("DELETE FROM ".LOGINTBL." WHERE uid = '".$row["id"]."' AND user_type = 'C'");
	//sm code
	$id=$_GET['id'];
	$db->recordUpdate(array("comp_id" => $id),array('del_status' => '1'),AUTOPOLICY);
	$db->recordUpdate(array("comp_id" => $id),array('del_status' => '1'),HEALTHPOLICY);
	$db->recordUpdate(array("comp_id" => $id),array('del_status' => '1'),MALPRACTICEPOLICY);
	$db->recordUpdate(array("comp_id" => $id),array('del_status' => '1'),TRAVELPOLICY);
	//sm code
	
	$db->recordDelete(array('id'=> $_GET['id']),COMPANYTBL);
	echo "<script>alert('Company Deleted Sucessfully');location.href='account.php?page=company_list';</script>";
}
//for active
if($_GET['id'] != "" && $_GET['task'] == "activate")
{
		$upd = "update ".LOGINTBL." set is_active = '1' where uid = '".$_GET['id']."' AND user_type = 'C'";
		mysql_query($upd) or die(mysql_error());
		echo "<script>alert('Record Activated Sucessfully');location.href='account.php?page=company_list';</script>";
}
//for block
if($_GET['id'] != "" && $_GET['task'] == "block")
{
		$upd = "update ".LOGINTBL." set is_active = '0' where uid = '".$_GET['id']."' AND user_type = 'C'";
		mysql_query($upd) or die(mysql_error());
		echo "<script>alert('Record Blocked Sucessfully');location.href='account.php?page=company_list';</script>";	
}
// export to excel
if($task == "export"){
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
  var retVal = confirm("Do you want to Delete these Compny List ?");
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

function setBestPartner(id)
{
	url="<?php echo BASE_URL;?>util/utils.php?task=setpartnerOfMonth&company_id="+id;
	$.post(url,function(data){
	
		window.location.href='<?php echo BASE_URL;?>account.php?page=company_list';
	});
}
</script>

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 2px; margin-top: 10px;">
    <tr>

      <td align="right" style="border-bottom: 0px solid #CCC; padding-bottom: 0px; padding-left: 0px; font-size: 14px; color: #036;">
	  
	
      </td>

    </tr> 

</table>  
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px;  line-height: 15px; color: #666;">
          <tr>
            <td width="34%" align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-top:3px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List/Manage Company </strong></td>
            <td width="51%"  align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px;"><form method="get" style=" padding-bottom:4px;" action="">
              <input type="hidden" name="page" value="company_list" />
              <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 140px; font-weight: normal;" value="<?php echo $_GET['sertxt']; ?>" />
              <input type="submit" name="search" id="search" value="Search" class="actionBtn" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
              <input type="button" name="reset" id="reset" value="Reset" class="actionBtn" onclick="location.href='account.php?page=company_list'" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />
            </form>
            </td>
            <td width="15%"  align="right" style="border-bottom: 1px solid #CCC; padding-right: 1px; padding-bottom:4px;">
            
            <!--  <input type="button" name="export" id="export" value=" Export To Excel " class="actionBtn" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; cursor: pointer;" onclick="location.href='account.php?page=emplist&task=export<?php //echo $sterm;  ?>'"/>-->
	  
         <input type="button" name="addnew" class="actionBtn" id="addnew" value=" Add New Company " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; cursor: pointer;" onclick="location.href='account.php?page=add_company'"/>
            
            </td>
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
                          <td width="12%" align="left" bgcolor="#006699" style="padding-left: 5px;"><strong>Company Name</strong></td>
                          <td width="9%" align="center" bgcolor="#006699"><strong>Company ID</strong></td>
                          <td width="13%" align="center" bgcolor="#006699"><strong>Contact Person</strong></td>
                          <td width="13%" align="center" bgcolor="#006699"><strong>Email</strong></td>
                          <td width="9%" align="center" bgcolor="#006699"><strong>Partners</strong>
                          <input type="submit" name="save_partners" style="background:url(<?php echo BASE_URL; ?>images/s_b.gif);border:none;cursor:pointer;margin-left:3px;background-repeat:no-repeat;" value="" /></td>
						  <td width="12%" align="center" bgcolor="#006699"><strong>Partner Of Month</strong></td>
                          <td width="9%" align="center" bgcolor="#006699"><strong>Created On</strong></td>
                          <td width="9%" align="center" bgcolor="#006699"><strong>Status</strong></td>
                          <td width="11%" align="center" bgcolor="#006699"><strong>Action</strong></td>
                        </tr>
                        <?php 
		if(isset($_GET['search'])){
		$sq = "SELECT * FROM ".COMPANYTBL." where (comp_name LIKE '%".$_GET['sertxt']."%' OR comp_code LIKE '%".$_GET['sertxt']."%') order by id desc LIMIT ".$startpoint.",".$perpage;
		}
	//echo $sq;
		else{
		$sq = "SELECT * FROM ".COMPANYTBL." ORDER BY id desc LIMIT ".$startpoint.",".$perpage;
		}
		
		$rs = mysql_query($sq);
		if(mysql_num_rows($rs) > 0){
		if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		while($row=mysql_fetch_array($rs)){
		
		$sq = mysql_query("select * from ".LOGINTBL." WHERE uid='".$row['id']."' AND user_type = 'C'");
        $smq1=mysql_fetch_array($sq);
		
		if($i % 2 == 0){ $bgcolor = "#F2F3F5"; }else{ $bgcolor = "#FFFFFF";  }
			  ?>
                        <tr bgcolor="<?php echo $bgcolor;?>">
                          <td align="center"><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');" /></td>
                          <td align="left"  style="padding-left: 5px;"><?php echo stripslashes($row["comp_name"]); ?></td>
                          <td width="9%" align="center"><?php echo $row["comp_code"]; ?></td>
                          <td width="13%" align="center"><?php echo $row["comp_contact_person"]; ?></td>
                          <td width="13%" align="center"><?php echo $row["comp_email"]; ?></td>
                          <td width="9%" align="center">
						  	<input name="partners[]" type="checkbox" class="input"  value="<?php echo $row["id"]; ?>" <?php if($row['partner']==1) echo 'checked="checked"';?> >
						  	<input name="id[]" type="hidden" class="input"  value="<?php echo $row["id"]; ?>" >
						  </td>
						  <td width="12%" align="center" <?php if($row['partner_of_month']==1){?>style="padding-left:22px"<?php }?>>
						  	<input name="partner_of_month" type="radio" class="input"  value="<?php echo $row["id"]; ?>" <?php if($row['partner_of_month']==1) echo 'checked="checked"';?> onclick="setBestPartner(this.value);" >
							<?php if($row['partner_of_month']==1){?>
								<span><a href="public/bestpartner_msg.php?id=<?php echo $row['id']; ?>" id="fancy"><img src="images/answer.png" width="16" height="16" border="0" style="cursor: pointer;"></a></span>
							<?php }?>
						  </td>
                          <td width="9%" align="center" ><?php echo date('d-m-Y',strtotime($row["created_date"])); ?></td>
                          <?php if(isset($_GET['search'])){
			$url="account.php?page=company_list&sertxt=".$_GET['sertxt']."&emp_type=".$_GET['emp_type']."&search=search";
			} else $url="account.php?page=company_list"; ?>
                          <td width="9%" align="center" ><?php if($smq1['is_active']=='0') { ?>
                              <a style="color:red;" href="<?php echo $url;?>&task=activate&id=<?php echo $row["id"]; ?>">In Active
                                <?php } else {?>
                              </a><a href="<?php echo $url; ?>&task=block&id=<?php echo $row["id"]; ?>">Active </a>
                              <?php } ?></td>
                          <td width="11%" align="center" >
							  <a id="box1" href="public/set_commision.php?id=<?php echo $row["id"]; ?>&type=company"><img src="images/answer.png" alt="View Company Details" width="16" height="16" border="0" title="Set Commision" style="cursor: pointer;" /></a>&nbsp;
							  <a id="box1" href="public/view_company.php?id=<?php echo $row["id"]; ?>"><img src="images/b_browse.png" alt="View Company Details" width="16" height="16" border="0" title="View Company Details" style="cursor: pointer;" /></a>&nbsp;
							  <a href="account.php?page=add_company&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit Company Profile" style="cursor: pointer;" /></a>&nbsp;
							  <a href="account.php?page=company_list&amp;task=delete&amp;id=<?php echo $row["id"];  ?> " onclick="return confirm('Are You Sure To Delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete Company" style="cursor: pointer;" /></a>
						  </td>
                        </tr>
                        <?php $i++;}}else{
			?>
                        <tr>
                          <td colspan="10" align="center" bgcolor="#F2FBFF">No company Listed</td>
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

				 echo Paging(COMPANYTBL,$perpage,"account.php?page=company_list&sertxt=".$_GET['sertxt']."&search=search&","comp_name LIKE '%".$_GET['sertxt']."%' OR comp_code LIKE '%".$_GET['sertxt']."%'");
					
					} 
					else{
					echo Paging(COMPANYTBL,$perpage,"account.php?page=company_list&","");
					} 
			
			  ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-top: 10px;"><span style="color:#FF0000"><b>Note: </b></span>Search can be posible by Company Name or Company ID. </td>
  </tr>
</table>
