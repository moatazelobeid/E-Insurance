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

function confirmInput()
 {
  var retVal = confirm("Do you want to Delete these Job Opportunity ?");
   if( retVal == true ){
      
	   document.partcat_form.todo.value='deleteall';document.partcat_form.submit();
	  return true;
   }else{
      
	  return false;
	
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

function calculate(val1, val2, msg) 
{
	var value1 = val1.split("-");
	var value2 = val2.split("-");
	if (value1 != "" && value2 != "") 
	{
		var day1 = parseFloat(value1[0]);
		var month1 = parseFloat(value1[1]);
		var year1 = parseFloat(value1[2]);
		var day2 = parseFloat(value2[0]);
		var month2 = parseFloat(value2[1]);
		var year2 = parseFloat(value2[2]);
		
		if ((year2 < year1) || (year2 == year1 && month2 < month1) || (year2 == year1 && month2 == month1 && day2 < day1) || (year2 == year1 && month2 == month1 && day2 == day1)) 
		{
			alert(msg);
			return false;
		}   
		else
			return true;     
	}
}

function masterValidate()
{
	var str = document.str_form;
	var error = "";
	var flag = true;

	if(str.title.value =="")
	{
		str.title.style.borderColor = "RED";
		error += "- Enter Title \n";
		flag = false;
	}
	else
	{
		str.title.style.borderColor = "";
	}

	if(str.title_ar.value =="")
	{
		str.title_ar.style.borderColor = "RED";
		error += "- Enter Title (Ar) \n";
		flag = false;
	}
	else
	{
		str.title_ar.style.borderColor = "";
	}
	
	if(str.description.value =="")
	{
		str.description.style.borderColor = "RED";
		error += "- Enter Dsescription \n";
		flag = false;
	}
	else
	{
		str.description.style.borderColor = "";
	}

	if(str.description_ar.value == "")
	{
		str.description_ar.style.borderColor = "RED";
		error += "- Enter Dsescription (Ar) \n";
		flag = false;
	}
	else
	{
		str.description_ar.style.borderColor = "";
	}

	if(str.skills.value == "")
	{
		str.skills.style.borderColor = "RED";
		error += "- Enter Skills (Ar) \n";
		flag = false;
	}
	else
	{
		str.skills.style.borderColor = "";
	}

	if(str.skills_ar.value == "")
	{
		str.skills_ar.style.borderColor = "RED";
		error += "- Enter Skills (Ar) \n";
		flag = false;
	}
	else
	{
		str.skills_ar.style.borderColor = "";
	}

	if(str.display_date.value == "")
	{
		str.display_date.style.borderColor = "RED";
		error += "- Enter Display Date \n";
		flag = false;
	}
	else
	{
		str.display_date.style.borderColor = "";
	}

	if(str.expiry_date.value == "")
	{
		str.expiry_date.style.borderColor = "RED";
		error += "- Enter Expiry Date \n";
		flag = false;
	}
	else
	{
		str.expiry_date.style.borderColor = "";
	}
	
	if(str.display_date.value!='' && str.expiry_date.value!='')
	{
		var res =calculate(str.display_date.value, str.expiry_date.value, 'Expiry date should greater than Display Date');
		if(!res)
			return false;
	}
		
	if(error)
	{
		alert(error);	
		return false;
	}
	else
	{
		return true;
	}
	
}

</script>

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
					$db->recordDelete(array("id" => $id),JOBOPPORTUNITY);
					$count++;
				
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=job-opportunity&view=list';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=job-opportunity&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=job-opportunity&view=list';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),JOBOPPORTUNITY) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=job-opportunity&view=list';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=job-opportunity&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=job-opportunity&view=list';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),JOBOPPORTUNITY) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=job-opportunity&view=list';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='account.php?page=job-opportunity&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='account.php?page=job-opportunity&view=list';</script>";
		}
		break;
	}
}


if($_REQUEST['task']=='delete')
{

 $sqql="delete from ".JOBOPPORTUNITY." where id='".$_REQUEST['id']."'";

 $qrr=mysql_query($sqql);
 header("location:account.php?page=job-opportunity&view=list");
}



if($_GET['task']=='inactive'){

	$id=$_GET['id'];

	$sqlu=mysql_query("update ".JOBOPPORTUNITY." set status='0' where id='$id'");
if(mysql_affected_rows() > 0)
echo "<script>alert('Record Unpublished Sucessfully');location.href='account.php?page=job-opportunity&view=list&part=".$_GET['part']."';</script>";
else
echo "<script>alert('Record Unpublished Failed');location.href='account.php?page=job-opportunity&view=list&part=".$_GET['part']."';</script>";

}

if($_GET['task']=='active'){

	 $id=$_GET['id'];

	$sqlp="update ".JOBOPPORTUNITY." set status='1' where id='$id'";

	$resultp=mysql_query($sqlp);
	if(mysql_affected_rows() > 0)
	echo "<script>alert('Record Published Sucessfully');location.href='account.php?page=job-opportunity&view=list&part=".$_GET['part']."';</script>";
	else
	echo "<script>alert('Record Published Failed');location.href='account.php?page=job-opportunity&view=list&part=".$_GET['part']."';</script>";

}
if($_GET['id'] == "")
{
	// button variables
	$btn_name = "save";

	$btn_value = " Add Job ";
	$cancel = "<a href='account.php?page=job-opportunity&view=list'><u>Cancel</u></a>";
}
else
{
	$btn_name = "update";
	$btn_value = " Update & Save ";
	$cancel = "<a href='account.php?page=job-opportunity&view=list'>Cancel</a>";
}

// save record
if(isset($_POST['save']))
{
	unset($_POST['save']);
	$_POST['title']      = addslashes(trim($_POST['title']));
	$_POST['title_ar']       = addslashes(trim($_POST['title_ar']));
    $_POST['description']    = addslashes(trim($_POST['description']));
	$_POST['description_ar'] = addslashes(trim($_POST['description_ar']));
    $_POST['skills']       = addslashes(trim($_POST['skills']));
	$_POST['skills_ar']    = addslashes(trim($_POST['skills_ar']));
	$_POST['display_date'] = date('Y-m-d', strtotime($_POST['display_date']));
	$_POST['expiry_date']  = date('Y-m-d', strtotime($_POST['expiry_date']));
	
	$db->recordInsert($_POST, JOBOPPORTUNITY);
    header("location:account.php?page=job-opportunity&view=list");
}
// get record
if($_GET['id'] != "")
{
	$sq_var = "SELECT * FROM ".JOBOPPORTUNITY." WHERE id = '".$_GET['id']."'";
	$res_var = mysql_query($sq_var);
	$rs_var = mysql_fetch_object($res_var);
	
	// get vars
	$title = stripslashes($rs_var->title);
    $title_ar = stripslashes($rs_var->title_ar);
	$description    = stripslashes($rs_var->description);
	$description_ar = stripslashes($rs_var->description_ar);
	$skills    = stripslashes($rs_var->skills);
	$skills_ar = stripslashes($rs_var->skills_ar);
	$display_date = date('d-m-Y', strtotime($rs_var->display_date));
	$expiry_date = date('d-m-Y', strtotime($rs_var->expiry_date));
	$status = $rs_var->status;
}


// update

if(isset($_POST['update']))
{
	unset($_POST['update']);
	$_POST['title']      = addslashes(trim($_POST['title']));
	$_POST['title_ar']       = addslashes(trim($_POST['title_ar']));
    $_POST['description']    = addslashes(trim($_POST['description']));
	$_POST['description_ar'] = addslashes(trim($_POST['description_ar']));
    $_POST['skills']       = addslashes(trim($_POST['skills']));
	$_POST['skills_ar']    = addslashes(trim($_POST['skills_ar']));
	$_POST['display_date'] = date('Y-m-d', strtotime($_POST['display_date']));
	$_POST['expiry_date']  = date('Y-m-d', strtotime($_POST['expiry_date']));

	$id = $_GET['id'];
	
	$db->recordUpdate(array("id" => $id),$_POST,JOBOPPORTUNITY);

	header("location:account.php?page=job-opportunity&view=list");
}

//save order
if(isset($_POST["save_order"]))
{ 
	$order_set=$_POST['order_set'];
	$id=$_POST['id'];
	
	$ordx=array();
	foreach($order_set as $ord)
	{
		if($ord!=''){
			$ordx[]=$ord;
		}
	}
		
	$srvcid=array();
	foreach($id as $ordy)
	{
		if($ordy!=''){
			$srvcid[]=$ordy;
		}
	}
		
	for($i = 0; $i < count($id); $i++)
	{	
		$upd="update ".JOBOPPORTUNITY." set ordering='".$ordx[$i]."' where id='".$srvcid[$i]."' ";
		mysql_query($upd) or die(mysql_error());
	}
}


$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 
if($_GET["view"]!="list"){
?>  

<!-- app -->
<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td width="67%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Add/Edit Job </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=job-opportunity&view=list"><span class="button_admin_big">View all Job</span></a></td>
    </tr>
    <?php if($msg <> ""){
?>
  <div style="border: 1px solid #990; background-color: #FFC; padding: 2px; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="7%"><img src="../images/warning.png" width="32" height="32"></td>
<td width="93%"><?php echo $msg; ?></td>
</tr>
</table>
</div>
<?php } ?>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="3">
<form action="" method="post" name="str_form" id="str_form" onSubmit="return masterValidate()" enctype="multipart/form-data">  <tr>
    <td style="padding-left: 0px; padding-right: 0px;"><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
	  	<td width="20%" align="right"><strong>Title  (En): </strong> </td>
        <td width="80%">
          <input name="title" type="text" id="title" value="<?php echo $title; ?>" style="width: 564px;" class="textbox"/></td>
      </tr>
		
	<tr>
		<td align="right"><strong>Title  (Ar):</strong>  </td>
        <td width="80%">
          <input name="title_ar" type="text" id="title_ar" value="<?php echo $title_ar; ?>" style="width: 564px" class="textbox"/></td>
        </tr>
     <tr>
	 	<td style="vertical-align:text-top" align="right"><strong>Description  (En): </strong> </td>
        <td width="80%">
          <textarea name="description" id="description" style="width: 564px; height:60px; resize:none;" class="textbox"><?php echo $description; ?></textarea></td>
      </tr>
		
	<tr>
		<td style="vertical-align:text-top" align="right"><strong>Description (Ar):</strong>  </td>
        <td width="80%">
          <textarea name="description_ar" id="description_ar" style="width: 564px; height:60px; resize:none;" class="textbox"><?php echo $description_ar; ?></textarea></td>
        </tr>
		
				
	<tr>
		<td style="vertical-align:text-top" align="right"><strong>Skills (En) : </strong></td>
        <td width="80%">
          <textarea name="skills" id="skills" style="width: 564px; height:60px; resize:none;" class="textbox"><?php echo $skills; ?></textarea></td>
      </tr>
	
	<tr>
		<td style="vertical-align:text-top" align="right"><strong>Skills (Ar) :</strong></td>
        <td width="80%">
          <textarea name="skills_ar" id="skills_ar" style="width: 564px; height:60px; resize:none;" class="textbox"><?php echo $skills_ar; ?></textarea></td>
      </tr>
	
	<tr>
		<td style="vertical-align:text-top" align="right"><strong>Display Date :</strong></td>
        <td width="80%">
          <input type="text" name="display_date" id="display_date"  class="textbox calender" value="<?php echo $display_date; ?>"  /></td>
      </tr>
	
	<tr>
		<td style="vertical-align:text-top" align="right"><strong>Expiry Date :</strong></td>
        <td width="80%">
          <input type="text" name="expiry_date" id="expiry_date" class="textbox calender" value="<?php echo $expiry_date; ?>"  /></td>
      </tr>
	<tr>
		<td style="vertical-align:text-top" align="right"><strong>Status :</strong></td>
        <td width="80%">
          <select name="status" id="status" class="">
		  	<option value="1">Active</option>
		  	<option value="0">Inactive</option>
		  </select></td>
      </tr>
		
      <tr>
	  	<td></td>
        <td><input name="<?php echo $btn_name; ?>" type="submit" id="<?php echo $btn_name; ?>" value="<?php echo $btn_value; ?>" class="actionBtn" />
          <span style="padding-left: 4px;">
  &nbsp;&nbsp;<?php echo $cancel; ?></span></td>
      </tr>
    </table>
  </td>
  </tr>
  </form>
</table>
</div>
<?php }else { ?>
<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
<form action="" method="post" name="partcat_form" id="partcat_form" onSubmit="return masterValidate()">  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Jobs </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=job-opportunity"><span class="button_admin_big">Add New Job</span></a></td>
    </tr>
    <tr>
      <td width="29%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='publishall';document.partcat_form.submit();" disabled="disabled"/>
        <input type="button" name="unpublishall" id="unpublishall" value="Inactive" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='unpublishall';document.partcat_form.submit();" disabled="disabled"/></td>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
	  <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <td width="49%" align="right">Title:</td>
           <td width="37%" align="right" style="padding-left: 4px;"><input name="stitle" type="text" class="textbox" id="quest" style="width: 200px;" 
		value="<?php echo $_POST["stitle"]; ?>"></td>
        <td width="14%" align="right"><input type="submit" name="search" id="search" value=" Search " class="actionBtn"></td>
        </tr>
      </table>
	  </td>
      </tr>
    <?php if($msg <> ""){
?>
    <div style="border: 1px solid #990; background-color: #FFC; padding: 2px; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="7%"><img src="../images/warning.png" width="32" height="32" /></td>
          <td width="93%"><?php echo $msg; ?></td>
        </tr>
      </table>
    </div>
    <?php } ?>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr style="color: #FFF;">
            <td width="7%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
            <td width="8%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="24%" align="left" bgcolor="#333333"><strong>Title</strong></td>
            <td width="16%" align="center" bgcolor="#333333"><strong>Display Date </strong></td>
            <td width="15%" align="center" bgcolor="#333333"><strong>Expiry Date</strong></td>
            <td width="15%" align="center" bgcolor="#333333"><strong>Status</strong></td>
            <td width="15%" align="center" bgcolor="#333333"><strong>Action</strong></td>
          </tr>
          		
				<?php 
if(isset($_POST["search"])){
		  $j = 0;
		  $i = 0;
		 $sq = "SELECT * FROM ".JOBOPPORTUNITY." WHERE title LIKE '%".$_POST["stitle"]."%' ORDER BY id desc LIMIT ".$startpoint.",".$perpage;
	  }	else
	  {			
				
		  $sq = "select * from ".JOBOPPORTUNITY." ORDER BY id desc LIMIT ".$startpoint.",".$perpage;}
					
		  $rs=mysql_query($sq);
		  if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		  while($row=mysql_fetch_array($rs)){
		  $j++;
		  $bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			 
		  ?>
          <tr <?php echo $bgcolor; ?>>
            <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $j;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $j;?>');" /></td>
            <td align="center" ><strong><?php echo $j; ?></strong></td>
            <td ><?php echo $row["title"]; ?></td>
         	<td align="center">
				<?php echo date("d/m/Y",strtotime($row["display_date"])); ?>
			</td>
			<td align="center" ><?php echo date("d/m/Y",strtotime($row["expiry_date"])); ?></td>
            <td align="center" ><?php 
			
			if($row["status"]=='0') { ?>
              <a href="account.php?page=job-opportunity&task=active&view=list&id=<?php echo $row["id"]; ?>"><font color="#FF0000">InActive</font>
              <?php } else {?>
              </a><a href="account.php?page=job-opportunity&task=inactive&view=list&id=<?php echo $row["id"]; ?>"><font color="#006633">Active</font>
                  
                  </a>
            <?php } ?></td>

            <td align="center" ><a href="public/view-job-opportunity.php?id=<?php echo $row['id']; ?>" id="fancy"><img src="images/view.png"  width="16" height="16" border="0" title="View" style="cursor: pointer;" /></a>&nbsp;<a href="account.php?page=job-opportunity&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a>&nbsp;<a href="account.php?page=job-opportunity&task=delete&view=list&id=<?php echo $row["id"];  ?>" onclick="return confirm('ARE YOU SURE TO DELETE!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a></td>
          </tr>
          <?php $i=$i+1;} ?>
          <tr>
            <td colspan="8" align="left"><input type="button" name="deleteall" id="deleteall1" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
      <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="publishall" id="publishall1" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='publishall';document.partcat_form.submit();" disabled="disabled"/>
      </span>
      <span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
      <input type="button" name="unpublishall2" id="unpublishall1" value="Inactive" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='unpublishall';document.partcat_form.submit();" disabled="disabled"/>
      </span>
      <input type="hidden" name="todo" id="todo" value=""/></td>
          </tr>
          <tr>
            <td colspan="8" align="center"><?php
			
			 if(isset($_POST['search'])){
				  echo Paging(JOBOPPORTUNITY,$perpage,"account.php?page=job-opportunity&view=list&","name LIKE '%".$_POST['stitle']."%' ORDER BY id DESC");
					
					}else{
					echo Paging(JOBOPPORTUNITY,$perpage,"account.php?page=job-opportunity&view=list&");
					} 
			
			  ?>
			
			
				 
					
			
			 </td>
          </tr>
        </table></td>
      </tr>
    
  </table></form>
</div>
<?php } ?>