<?php  
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 

if($_GET['task']=='delete' && $_GET['id'])
{
	$id=$_GET['id'];

  // if($db->recordUpdate(array("id" => $id),array('del_status' => '1'),OFFERS) == 1){
  
  if($db->recordDelete(array('id' => $id),OFFERS) == 1){
		$msg='Policy deleted successfully.';
		header('Location: account.php?page=policy-offers');
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
			foreach($_POST['chkNo'] as $key => $id){
				// delete user record
				
		    //if($db->recordUpdate(array("comp_policy_id" => $id),array('del_status' => '1'),$table) == 1){
				
				 if($db->recordDelete(array('id' => $id),OFFERS) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=policy-offers';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=policy-offers';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=policy-offers';</script>";
		}
		break;
		
	}
}

$whr="";
$suburl='';
$type=$_GET['type'];
$q=$_GET['q'];

if($_GET['type'] && $_GET['task']=='')
{
	$suburl.='&type='.$_GET['type'];
	$whr.=" and policy_type='".$type."' ";
}

if($_GET['company'] && $_GET['task']=='')
{
	$suburl.='&company='.$_GET['company'];
	$whr.=" and comp_id='".$_GET['company']."' ";
}

if($_GET['status'] && $_GET['task']=='')
{
    if($_GET['status'] == '3'){$_GET['status'] = '0';}
	
	$suburl.='&status ='.$_GET['status'];
	$whr.=" and status ='".$_GET['status']."' ";
}


if($_GET['q'] && $_GET['task']=='')
{
	$suburl.='&q='.$_GET['q'];
	$whr.=" and (title like '%".$q."%' OR comp_policy_id like '%".$q."%') ";
}	
	
//$rs = mysql_query("select comp_policy_id,comp_id,id,policy_type,title,description,status,policy_amount,created_date from ".TRAVELPOLICY." WHERE del_status = '0'".$whr." UNION select comp_policy_id,comp_id,id,policy_type,title,description,status,policy_amount,created_date from ".AUTOPOLICY." WHERE del_status = '0'".$whr." UNION select comp_policy_id,comp_id,id,policy_type,title,description,status,policy_amount,created_date from ".HEALTHPOLICY." WHERE del_status = '0'".$whr." UNION select comp_policy_id,comp_id,id,policy_type,title,description,status,policy_amount,created_date from ".MALPRACTICEPOLICY." WHERE del_status = '0'".$whr." ORDER BY created_date desc LIMIT ".$startpoint." , ".$perpage); 
//echo "select * from ".OFFERS." WHERE id != '0' AND id in(select id from ".COMPANYTBL." ) ORDER BY created_date desc LIMIT ".$startpoint." , ".$perpage.""
$rs = mysql_query("select * from ".OFFERS." WHERE id != '0' AND comp_id in(select id from ".COMPANYTBL.")".$whr." ORDER BY created_date desc LIMIT ".$startpoint." , ".$perpage.""); 

//$sql_paging = "select comp_policy_id,comp_id,id,policy_type,title,description,status,policy_amount,created_date from ".TRAVELPOLICY." WHERE del_status = '0'".$whr." UNION select comp_policy_id,comp_id,id,policy_type,title,description,status,policy_amount,created_date from ".AUTOPOLICY." WHERE del_status = '0'".$whr." UNION select comp_policy_id,comp_id,id,policy_type,title,description,status,policy_amount,created_date from ".HEALTHPOLICY." WHERE del_status = '0'".$whr." UNION select comp_policy_id,comp_id,id,policy_type,title,description,status,policy_amount,created_date from ".MALPRACTICEPOLICY." WHERE del_status = '0'".$whr." ORDER BY created_date desc";
 
$rs1 = "select * from ".OFFERS." WHERE id != '0' AND comp_id in(select id from ".COMPANYTBL.")".$whr." ORDER BY created_date desc"; //for paging
?>
<script type="text/javascript">
function searchByType(val)
{
	var typeurl='';
	var turl="";
	var sturl = "";
	var compurl = "";
	
	<?php if($_GET['q']){?>
		turl='&q=<?php echo $_GET['q'];?>';
	<?php }?>
	
	<?php if($_GET['company']){?>
	      compurl='&company=<?php echo $_GET['company'];?>';
	<?php }?>
	
	<?php if($_GET['status']){?>
		  sturl='&status=<?php echo $_GET['status'];?>';
	<?php }?>
	
	
	if(val!='')
		typeurl='&type='+val;
	var url='<?php echo BASE_URL;?>account.php?page=policy-offers'+typeurl+turl+sturl+compurl;
	window.location.href=url;
}

function searchByComp(val)
{
	var typeurl='';
	var turl="";
	var sturl = "";
	var compurl = "";
	
	<?php if($_GET['q']){?>
	      turl='&q=<?php echo $_GET['q'];?>';
	<?php }?>
	
	<?php if($_GET['status']){?>
		  sturl='&status=<?php echo $_GET['status'];?>';
	<?php }?>
	
	<?php if($_GET['type']){?>
	      typeurl='&type=<?php echo $_GET['type'];?>';
	<?php }?>
	
	if(val!='')
		compurl='&company='+val;
	var url='<?php echo BASE_URL;?>account.php?page=policy-offers'+typeurl+turl+sturl+compurl;
	window.location.href=url;
}

function searchByStatus(val)
{
	var typeurl='';
	var turl="";
	var sturl = "";
	var compurl = "";
	
	<?php if($_GET['q']){?>
	      turl='&q=<?php echo $_GET['q'];?>';
	<?php }?>
	
	<?php if($_GET['company']){?>
		  compurl='&company=<?php echo $_GET['company'];?>';
	<?php }?>
	
	<?php if($_GET['type']){?>
	      typeurl='&type=<?php echo $_GET['type'];?>';
	<?php }?>
	
	if(val!='')
		sturl='&status='+val;
	var url='<?php echo BASE_URL;?>account.php?page=policy-offers'+typeurl+turl+sturl+compurl;
	window.location.href=url;
}

function SearchByTitle()
{
	var typeurl='';
	var turl="";
	var sturl = "";
	var compurl = "";
	
	<?php if($_GET['type'])
	{?>
		typeurl='&type=<?php echo $_GET['type'];?>';
	<?php }?>
	
    <?php if($_GET['status']){?>
		  sturl='&status=<?php echo $_GET['status'];?>';
	<?php }?>
	
	<?php if($_GET['company']){?>
	      compurl='&company=<?php echo $_GET['company'];?>';
	<?php }?>
	
	var title=document.getElementById("q").value;
	if(title!='')
		turl='&q='+title;
	var url='<?php echo BASE_URL;?>account.php?page=policy-offers'+typeurl+turl+sturl+compurl;
	window.location.href=url;
}
</script>



<script type="text/javascript">
function check_all()
{
	var num_tot = document.getElementsByName('chkNo[]').length;
	var l,m;
	if(document.getElementById("chkAll").checked == true)
	{
		// enable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "";
		//document.getElementById("publishall").disabled = "";
		//document.getElementById("unpublishall").disabled = "";
		document.getElementById("deleteall1").disabled = "";
		//document.getElementById("publishall1").disabled = "";
		//document.getElementById("unpublishall1").disabled = "";
		
		for(l=1;l<=num_tot;l++)
		{
			obj = document.getElementById('chkNo'+l);
			document.getElementById("chkNo" + l).checked = true;
		}
	}else{
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		//document.getElementById("publishall").disabled = "disabled";
		//document.getElementById("unpublishall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		//document.getElementById("publishall1").disabled = "disabled";
		//document.getElementById("unpublishall1").disabled = "disabled";
		
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
		//document.getElementById("publishall").disabled = "";
		//document.getElementById("unpublishall").disabled = "";
		document.getElementById("deleteall1").disabled = "";
		//document.getElementById("publishall1").disabled = "";
		//document.getElementById("unpublishall1").disabled = "";
		}
	}else{
		for(l=1;l<=num_tot;l++){
			if(document.getElementById("chkNo" + l).checked == true)
			flag++;
		}
		if(flag == 0){
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		//document.getElementById("publishall").disabled = "disabled";
		//document.getElementById("unpublishall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		//document.getElementById("publishall1").disabled = "disabled";
		//document.getElementById("unpublishall1").disabled = "disabled";
		}
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
	url="<?php echo BASE_URL;?>util/utils.php?company_id="+id;
	$.post(url,function(data){
	
		window.location.href='<?php echo BASE_URL;?>account.php?page=company_list';
	});
}
function checkUpdate(val,id)
{
$.ajax({
   			 type: "POST",
  			 url: "util/utils.php",
  			 data: "offer_status="+val+"&id="+id,
  			 success: function(msg)
			 {
					if(msg == 'OK')
					{
						alert ("Status changed Successfully")
					}
					else if(msg == 'ERROR')
					{
						alert("Error in updating status");
					}
			 }
		});

}
function confirmInput()
 {
  var retVal = confirm("Do you want to Delete these Policy Offer ?");
   if( retVal == true ){
      
	   document.chapter_fr.todo.value='deleteall';document.chapter_fr.submit();
	  return true;
   }else{
      
	  return false;
	
   }
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
            <td width="34%" align="left" style="padding-left: 0px; font-size: 14px; color: #036;"><strong>List/Manage Policy Offers &amp; Deals </strong></td>
            <td width="51%"   align="right" style="padding-bottom: 0px; padding-left: 1px; padding-right: 2px; font-size: 14px;">
			
					 
			  <select name="policy_type" class="generalTextBox" style="width:auto" id="policy_type" onchange="searchByType(this.value);">
						<option value="">Filter By Policy Type</option>
						<option value="medical" <?php if($_GET['type']=='medical')echo 'selected="selected"';?>>Medical</option>
						<option value="malpractice" <?php if($_GET['type']=='malpractice')echo 'selected="selected"';?>>Malpractice</option>
						<option value="auto" <?php if($_GET['type']=='auto')echo 'selected="selected"';?>>Auto</option>
						<option value="travel" <?php if($_GET['type']=='travel')echo 'selected="selected"';?>>Travel</option>
				     </select>
				  
					 <select name="company" class="generalTextBox" style="width:auto" id="policy_type" onchange="searchByComp(this.value);">
						<option value="">Filter By Company</option>
						<?php $sql_c = mysql_query("SELECT * FROM ".COMPANYTBL); 
						      while($ard = mysql_fetch_array($sql_c)){?>
						<option value="<?php echo $ard['id'];?>" <?php if($_GET['company'] == $ard['id'])echo 'selected="selected"';?>><?php echo $ard['comp_name']; ?></option>
						<?php }?>
					  </select>
					  
					  
					  <select name="status" class="generalTextBox" style="width:auto" id="policy_type" onchange="searchByStatus(this.value);">
						<option value="">Filter By Status</option>
						<option value="3" <?php if($_GET['status']=='0')echo 'selected="selected"';?>>Pending</option>
						<option value="1" <?php if($_GET['status']=='1')echo 'selected="selected"';?>>Approved</option>
						<option value="2" <?php if($_GET['status']=='2')echo 'selected="selected"';?>>Rejected</option>
				     </select>
		
            </td>
           
          </tr>
        </table>
		
		
		
		
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px;  line-height: 15px; color: #666;">
          <tr>
            <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-top:3px; padding-left: 0px; font-size: 14px; color: #036;">
			
			         
					&nbsp;Search:&nbsp;<input type="text" class="textbox" name="q" id="q" value="<?php echo $_GET['q'];?>" style="width:260px;" />
					&nbsp;<input type="button" name="search" value="Search" class="actionBtn" style="padding:2px; margin-right:5px" onclick="SearchByTitle();" />
					<input type="button" name="reset" id="reset" value="Reset" class="actionBtn" onclick="location.href='account.php?page=policy-offers'" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" />            </td>
          </tr>
        </table>
		
		
              <!-- users list -->
              <form action="" method="post" name="chapter_fr" style="padding: 0px; margin: 0px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td width="57%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
                        
                       
                    </td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
                  <tr>
                    <td style="border-top: 0px solid #99C; padding-left: 0px;"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                        <tr style="color: #FFF;">
                          <td width="2%" height="25" align="center" bgcolor="#006699"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
                          <td width="8%" align="center" bgcolor="#006699" style="padding-left: 5px;"><strong>Offer ID# </strong></td>
                          <td width="25%" align="left" bgcolor="#006699"><strong>Policy Title</strong></td>
						  <td width="14%" align="left" bgcolor="#006699"><strong>Policy ID#</strong></td>
                          <td width="18%" align="left" bgcolor="#006699"><strong>Company</strong></td>
                          <td width="9%" align="center" bgcolor="#006699"><strong>Policy Type</strong></td>
                          <td width="9%" align="center" bgcolor="#006699"><strong>Created On</strong></td>
                          <td width="9%" align="center" bgcolor="#006699"><strong>Status</strong></td>
                          <td width="6%" align="center" bgcolor="#006699"><strong>Action</strong></td>
                        </tr>
                        <?php 
		if(mysql_num_rows($rs) > 0){
		
		
		$i=1;
		while($row=mysql_fetch_array($rs)){
		
		$sq = mysql_query("select * from ".LOGINTBL." WHERE uid='".$row['id']."' AND user_type = 'C'");
        $smq1=mysql_fetch_array($sq);
		
		if($i % 2 == 0){ $bgcolor = "#F2F3F5"; }else{ $bgcolor = "#FFFFFF";  }
			  ?>
                        <tr bgcolor="<?php echo $bgcolor;?>">
                          <td align="center">
						  <input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');" /> 
						  </td>
                          <td align="center"  style="padding-left: 5px;"><?php echo $row["offer_id"]; ?></td>
                          <td width="25%" align="left"><?php echo stripslashes($row["title"]); ?></td>
						  <td width="14%" align="left"><?php echo stripslashes($row["comp_policy_id"]); ?></td>
                          <td width="18%" align="left">
						  <?php 
						  $sql = mysql_fetch_array(mysql_query("SELECT * FROM ".COMPANYTBL." WHERE id='".$row['comp_id']."'"));
						 
						   echo '<label title="'.$sql['comp_code'].'">'.$sql['comp_name'].'</label>';
						  
						  //echo $row["comp_contact_person"]; ?></td>
                          <td width="9%" align="center"><?php echo ucwords($row['policy_type']); if($row['policy_type']=='auto')
						  {
						  $type=mysql_fetch_assoc(mysql_query("select coverage_type from ".AUTOPOLICY." where comp_policy_id = '".$row['comp_policy_id']."'"));
						  if($type['coverage_type']=='tpl')
							echo $type=' (TPL)';
						  if($type['coverage_type']=='comp')
							echo $type=' (Comprehensive)';
						   }
						   ?>
						   
						   </td>
                          
						  
                          <td width="9%" align="center" ><?php echo date('d-m-Y',strtotime($row["created_date"])); ?></td>
                          <?php if(isset($_GET['search'])){
			$url="account.php?page=policy-offers&sertxt=".$_GET['sertxt']."&emp_type=".$_GET['emp_type']."&search=search";
			} else $url="account.php?page=company_list"; ?>
                          <td width="9%" align="center" >
						  <select id='status' name='status' onchange="checkUpdate(this.value,<?php echo $row["id"]; ?>)" >
							  <option value="0"  <?php if($row["status"]=='0') echo "selected='selected'";?>> Pending </option>
							  <option value="1"  <?php if($row["status"]=='1') echo "selected='selected'";?>> Approved </option>
							  <option value="2"  <?php if($row["status"]=='2') echo "selected='selected'";?>> Rejected </option>
						 </select>
						  
						  </td>
                          <td width="6%" align="center" ><a id="box1" href="public/policy-offer-details.php?id=<?php echo $row["id"]; ?>"><img src="images/b_browse.png" alt="View Company Details" width="16" height="16" border="0" title="View Company Details" style="cursor: pointer;" /></a>&nbsp;
						  
					<a href="account.php?page=policy-offers&amp;task=delete&amp;id=<?php echo $row["id"];?>&amp;type=<?php echo $row['policy_type'];?>" onclick="return confirm('Are You Sure To Delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;" /></a></td>
                        </tr>
                        <?php $i++;}}else{?>
                        <tr>
                          <td colspan="10" align="center" bgcolor="#F2FBFF">No Offers listed </td>
                        </tr>
                        <?php }?>
                    </table></td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
                  <tr>
                    <td><input type="button" name="deleteall" id="deleteall1" value="Delete Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
                        <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;"></span>
                        
                      
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
							<td colspan="7" style="padding-top:10px" align="center">
								<?php echo Paging('',$perpage,"account.php?page=policy-offers".$suburl."&",'',$rs1);?>			
							</td>
						</tr>
  <tr>
    <td align="left" valign="top" style="padding-top: 10px;"><span style="color:#FF0000"><b>Note: </b></span>Search can be posible by Company Name or Policy Type or Offer ID. </td>
  </tr>
</table>
