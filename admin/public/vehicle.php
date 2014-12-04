<?php
$view=$_GET['view'];
$make=mysql_query("SELECT * FROM ".VMAKE." ORDER BY id DESC");
$lmakeid=mysql_fetch_array(mysql_query("select max(id) from ".VMAKE.""));

$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 

if(isset($_POST['save']))
{
	// filter params not to save
	unset($_POST['save']);
	$view=$_GET['view'];
	if($view=='make')
	{
		$_POST['make']=addslashes($_POST['make']);
		$_POST['make_ar']=addslashes($_POST['make_ar']);
		// check for duplicate record
		if($db->isExists('make',$_POST,VMAKE)){
			$errmsg = "- Make already exists";
		}else{
			// save record
			$result = $db->recordInsert($_POST,VMAKE,'');
		}
	}
	if($view=='model')
	{
		$make_id=$_POST['make_id'];
		$model=$_POST['model'];
		$_POST['model']=addslashes($_POST['model']);
		$_POST['model_ar']=addslashes($_POST['model_ar']);
		// check for duplicate record
		$isdup=mysql_num_rows(mysql_query("select * from ".VMODEL." where model='".$model."' and make_id=".$make_id));
		if($isdup>0){
			$errmsg = "- Model already exists";
		}else{
			// save record
			$result = $db->recordInsert($_POST,VMODEL,'');
		}
	}
	if($view=='type')
	{
		
		$_POST['type_name']=addslashes($_POST['type_name']);
		$_POST['type_name_ar']=addslashes($_POST['type_name_ar']);
		$make_id=$_POST['make_id'];
		$model_id=$_POST['model_id'];
		$type_name=$_POST['type_name'];
		// check for duplicate record
		
		
		if($_POST['is_tpl_comp']=='tpl')
		{
			$isdup=mysql_num_rows(mysql_query("select * from ".VTYPE." where type_name='".$type_name."'"));
		}
		if($_POST['is_tpl_comp']=='comp')
		{
			$isduplicate = mysql_num_rows(mysql_query("select * from ".VTYPE." where  make_id=".$make_id." and model_id=".$model_id));
			$isdup=mysql_num_rows(mysql_query("select * from ".VTYPE." where type_name='".$type_name."' and make_id=".$make_id." and model_id=".$model_id));
		}
			
		if($isdup>0){
			$errmsg = "- Type already exists";
		}else if($isduplicate >0)
		{
			$errmsg = "- Type name for this Model and Make already exists";
		}		
		else{
		// save record
		$result = $db->recordInsert($_POST,VTYPE,'');
		}
	}
	$dview=ucwords($view);
	if($result == 1)
		echo "<script>alert('".$dview." Saved Sucessfully');location.href='account.php?page=vehicle&view=".$view."';</script>";
	else if($result == 2)
		echo "<script>alert('".$dview." Saving Failed');location.href='account.php?page=vehicle&view=".$view."';</script>";
	
}
if(isset($_POST['update']))
{
	unset($_POST['update']);
	$view=$_GET['view'];
	$dview=ucwords($view);
	
	if($view=='make')
	{
		$make=$_POST['make'];
		// check for duplicate record
		$isdup=mysql_num_rows(mysql_query("select * from ".VMAKE." where make='".$make."' and id!=".$id));
		if($isdup>0){
			$errmsg = "- Make already exists";
		}else{
			// save record
			$result = $db->recordUpdate(array("id" => $id),$_POST,VMAKE);
		}
	}
	if($view=='model')
	{
		$make_id=$_POST['make_id'];
		$model=$_POST['model'];
		// check for duplicate record
		$isdup=mysql_num_rows(mysql_query("select * from ".VMODEL." where model='".$model."' and make_id=".$make_id." and id!=".$id));
		if($isdup>0){
			$errmsg = "- Model already exists";
		}else{
			// update record
			$result = $db->recordUpdate(array("id" => $id),$_POST,VMODEL);
		}
	}
	if($view=='type')
	{
		$make_id=$_POST['make_id'];
		$model_id=$_POST['model_id'];
		$type_name=$_POST['type_name'];
		
		// check for duplicate record
		if($_POST['is_tpl_comp']=='tpl')
		{
			$isdup=mysql_num_rows(mysql_query("select * from ".VTYPE." where type_name='".$type_name."'  and id!=".$id));
		}
		if($_POST['is_tpl_comp']=='comp')
		{
			$isduplicate = mysql_num_rows(mysql_query("select * from ".VTYPE." where  make_id=".$make_id." and model_id=".$model_id." and id!=".$id));
			$isdup=mysql_num_rows(mysql_query("select * from ".VTYPE." where type_name='".$type_name."' and make_id=".$make_id." and model_id=".$model_id."  and id!=".$id));
		}
		if($isdup>0){
			$errmsg = "- Type already exists";
		}elseif($isduplicate >0)
		{
			$errmsg = "- Type name for this Model and Make already exists";
		}else{
			// update record
			$result = $db->recordUpdate(array("id" => $id),$_POST,VTYPE);
		}
		
	}
	if(!$errmsg){
		// update record
		if($result == 1){
		
			echo "<script>alert('".$dview." Updated Sucessfully');location.href='account.php?page=vehicle&view=".$view."';</script>";
		}else
			echo "<script>alert('".$dview." Updation Failed');location.href='account.php?page=vehicle&view=".$view."&task=edit&id=".$id."';</script>";
	}
}
if($task == "edit" && $id != "")
{
	// get all data
	if($view=='make')
		$datalist = $db->recordFetch($id,VMAKE.":".'id');
	if($view=='model')
		$datalist = $db->recordFetch($id,VMODEL.":".'id');
	if($view=='type')
		$datalist = $db->recordFetch($id,VTYPE.":".'id');
}
// delete all users
if(isset($_POST['todo']))
{
	$view=$_GET['view'];
	if($view=='make')
		$tbl=VMAKE;
	if($view=='model')
		$tbl=VMODEL;
	if($view=='type')
		$tbl=VTYPE;
	//echo '<pre>'; print_r($_POST['chkNo']); echo $tbl; echo $_POST['todo']; exit;
	// case
	switch($_POST['todo']){
		case 'deleteall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordDelete(array('id' => $id),$tbl) == 1){
				
					if($view=='make')
					{
						mysql_query("delete from ".VMODEL." where make_id=".$id);
						mysql_query("delete from ".VTYPE." where make_id=".$id);
					}
					if($view=='model')
					{
						mysql_query("delete from ".VTYPE." where model_id=".$id);
					}
		
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=vehicle&view=".$view."';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=vehicle&view=".$view."';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=vehicle&view=".$view."';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),$tbl) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=vehicle&view=".$view."';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=vehicle&view=".$view."';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=vehicle&view=".$view."';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),$tbl) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records UnPublished successfully');location.href='account.php?page=vehicle&view=".$view."';</script>";
			}else{
				echo "<script>alert('No Records UnPublished');location.href='account.php?page=vehicle&view=".$view."';</script>";
			}
		}else{
			echo "<script>alert('No Records UnPublished');location.href='account.php?page=vehicle&view=".$view."';</script>";
		}
		break;
	}
}
// delete individual users
if($_GET['id'] != "" && $_GET['task'] == "delete")
{
	$view=$_GET['view'];
	if($view=='make')
		$tbl=VMAKE;
	if($view=='model')
		$tbl=VMODEL;
	if($view=='type')
		$tbl=VTYPE;
	if($db->recordDelete(array('id' => $_GET['id']),$tbl) == 1){
	
		if($view=='make')
		{
			mysql_query("delete from ".VMODEL." where make_id=".$id);
			mysql_query("delete from ".VTYPE." where make_id=".$id);
		}
		if($view=='model')
		{
			mysql_query("delete from ".VTYPE." where model_id=".$id);
		}
		// delete user login record
		echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=vehicle&view=".$view."';</script>";
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
  var retVal = confirm("Do you want to Delete these Vehicle ?");
   if( retVal == true ){
      
	   document.subject_fr.todo.value='deleteall';document.subject_fr.submit();
	  return true;
   }else{
      
	  return false;
	
   }
 }
</script>
<script type="text/javascript">
function validateMake() 
{ 
	var str = document.makeform;
	var error = "";
	var flag = false;
	var dataArray = new Array();
	if(str.make.value == "")
	{
		str.make.style.borderColor = "RED";
		error += "- Enter Vehicle Make\n";
		flag = false;
		dataArray.push('make');
	}
	else
	{
		str.make.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.make_ar.value == "")
	{
		str.make_ar.style.borderColor = "RED";
		error += "- Enter Vehicle Make (Ar)\n";
		flag = false;
		dataArray.push('make_ar');
	}
	else
	{
		str.make_ar.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.agency_repair_cat.value == "")
	{
		str.agency_repair_cat.style.borderColor = "RED";
		error += "- Enter Agency Repair  \n";
		flag = false;
		dataArray.push('agency_repair_cat');
	}
	else
	{
		str.agency_repair_cat.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(flag == false)
	{
		alert(error);
		str.elements[dataArray[0]].focus();
		return false;
	}
	else
	return true;
}
function validateModel()
{ 
	var str = document.modelform;
	var error = "";
	var flag = false;
	var dataArray = new Array();
	if(!str.make_id || str.make_id.value == "")
	{
		if(str.make_id)
		{
		str.make_id.style.borderColor = "RED";
		error += "- Enter Vehicle Model\n";
		dataArray.push('make_id');
		}
		else
			error += "- Add Make\n";
		flag = false;
		
	}
	else
	{
		if(str.make_id)
			str.make_id.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.model.value == "")
	{
		str.model.style.borderColor = "RED";
		error += "- Enter Vehicle Model\n";
		flag = false;
		dataArray.push('model');
	}
	else
	{
		str.model.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.model_ar.value == "")
	{
		str.model_ar.style.borderColor = "RED";
		error += "- Enter Vehicle Model (Ar)\n";
		flag = false;
		dataArray.push('model_ar');
	}
	else
	{
		str.model_ar.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(flag == false)
	{
		alert(error);
		//str.elements[dataArray[0]].focus();
		return false;
	}
	else
	return true;
}
function validateType()
{ 
	var str = document.typeform;
	var error = "";
	var flag = false;
	var tplval=$('input[name=is_tpl_comp]:radio:checked').val();

	//alert(tplval);
	var dataArray = new Array();
	if(tplval=='comp')
	{
		if(!str.make_id || str.make_id.value == "")
		{
			if(str.make_id)
			{
				str.make_id.style.borderColor = "RED";
				dataArray.push('make_id');
				error += "- Select Make\n";
			}
			else
				error += "- Add Make\n";
			flag = false;
		}
		else
		{
			if(str.make_id)
				str.make_id.style.borderColor = "";
			flag = true;
			dataArray.pop();
		}
		if(!str.model_id || str.model_id.value == "")
		{
			if(str.model_id)
			{
				str.model_id.style.borderColor = "RED";
				dataArray.push('model_id');
				error += "- Select Model \n";
			}
			else
				error += "- Add Model \n";
				
			flag = false;
			
		}
		else
		{
			if(str.model_id)
				str.model_id.style.borderColor = "";
			flag = true;
			dataArray.pop();
		}
	}
	if(str.type_name.value=="")
	{
		str.type_name.style.borderColor = "RED";
		error += "- Enter Type \n";
		flag = false;
		dataArray.push('type_name');
	}
	else
	{
		str.type_name.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.type_name_ar.value == "")
	{
		str.type_name_ar.style.borderColor = "RED";
		error += "- Enter Type (Ar)\n";
		flag = false;
		dataArray.push('type_name_ar');
	}
	else
	{
		str.type_name_ar.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	
	if(error)
	{
		alert(error);
		return false;
	}
	else
	return true;
}

function getModel(makeid)
{
	url="<?php echo BASE_URL;?>util/utils.php?make_id="+makeid;
	$.post(url,function(data){
		//alert(data);
		$('#modelbox').html(data);
	});
}

function showMakeModel(val)
{
	if(val=='tpl')
	{
		if(document.getElementById("vehicle_use"))
			document.getElementById("vehicle_use").disabled = "";
		if(document.getElementById("make_id"))
			document.getElementById("make_id").disabled = "disabled";
		if(document.getElementById("model_id"))
			document.getElementById("model_id").disabled = "disabled";
		if(document.getElementById("nomake_id"))
			document.getElementById("nomake_id").style.display = "block";
		if(document.getElementById("makemsg"))
			document.getElementById("makemsg").style.display = "none";
	}
	if(val=='comp')
	{
		if(document.getElementById("vehicle_use"))
			document.getElementById("vehicle_use").disabled = "disabled";
		if(document.getElementById("make_id"))
			document.getElementById("make_id").disabled = "";
		if(document.getElementById("model_id"))
			document.getElementById("model_id").disabled = "";
		if(document.getElementById("nomake_id"))
			document.getElementById("nomake_id").style.display = "none";
		if(document.getElementById("makemsg"))
			document.getElementById("makemsg").style.display = "block";
	}
}

// fade out messages
var fade_out = function() {
  $("#errorDiv").fadeOut().empty();
}
setTimeout(fade_out, 3000);
</script>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 8px; margin-top: 10px;">

    <tr>

      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 10px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Create/Manage <?php if($_GET['view'] != "") echo ucwords($_GET['view']); else echo "Vehicle Make"; ?></strong></td>
	  <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 15px; padding-right: 0px; color: #FFFFFF;">
	  <a href="account.php?page=vehicle&view=make" class="linkBtn" <?php if($_GET['view'] == "make") echo "style='background-color: #f98923;'"; ?>>Make</a>&nbsp;
	  <a href="account.php?page=vehicle&view=model" class="linkBtn" <?php if($_GET['view'] == "model") echo "style='background-color: #f98923;'"; ?>>Model</a>&nbsp;
	  <a href="account.php?page=vehicle&view=type" class="linkBtn" <?php if($_GET['view'] == "type") echo "style='background-color: #f98923;'"; ?>>Type</a>
	  </td>
    </tr> 

  </table>
<?php 
if($view=='make' || $view=='')
{?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="262" valign="top" style="padding-right: 10px;">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Add/Edit Vehicle Make</strong></td>
          </tr>
        </table>
<form action="" method="post" name="makeform" onSubmit="return validateMake();">
        
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>

    <td style="padding-top: 5px;"><table width="100%" border="0" cellspacing="0" cellpadding="2">
     
      <tr>
        <td style="padding-left: 0px;">Make(EN):</td>
        <td style="padding-right: 0px;"><input name="make" type="text" class="textbox" id="make" style="width: 187px; font-weight: normal;" value="<?php echo getElementVal('make',$datalist); ?>"></td>
      </tr>
	  
	  <tr>
        <td style="padding-left: 0px;">Make(AR):</td>
        <td style="padding-right: 0px;"><input name="make_ar" type="text" class="textbox" id="make_ar" style="width: 187px; font-weight: normal;" value="<?php echo getElementVal('make_ar',$datalist); ?>"></td>
      </tr>
	  
	  <tr>
        <td style="padding-left: 0px;">Agency Repair Category:</td>
        <td style="padding-right: 0px;"><select name="agency_repair_cat" id="agency_repair_cat" style="width: 194px;" ><option value=""  >--Select Category--</option>
             <?php $sqll = mysql_query("SELECT * FROM ".AGENCYREPAIR." WHERE status = '1' ");
                   while($arr = mysql_fetch_array($sqll))
                   {?>
                   <option value="<?php echo $arr['id'];?>" <?php if($arr['id'] == getElementVal('agency_repair_cat',$datalist)){echo "selected";}?>><?php echo $arr['cat_name'];?></option>
                   <?php }?> </select></td>
      </tr>
      
      <tr>
        
        <td width="27%" style="padding-left: 0px;">Set Status:</td>
        
        <td width="73%" style="padding-right: 0px;"><select name="status" id="status" style="width: 193px; font-weight: normal;">
          
          <option value="1" <?php if(getElementVal('status',$datalist) == '1') echo "selected='selected'"; ?>>Active</option>
          
          <option value="0" <?php if(getElementVal('status',$datalist) == '0') echo "selected='selected'"; ?>>Inactive</option>
          
          </select></td>
        
      </tr>
      <tr>
        <td colspan="2" style="padding-left: 0px;padding-top: 10px;">
          <?php

	if($id != "" && $task == "edit"){

    ?>
          <input type="submit" name="update" id="update" value=" Update to List " class="actionBtn">
          <?php }else{ ?>
          <input type="submit" name="save" id="save" value=" Add to List " class="actionBtn">
          <?php } ?>
          <input type="button" name="cancel" id="cancel" value=" Reset " class="actionBtn" onclick="location.href='account.php?page=vehicle&view=make'">
        </td>
        </tr>

      </table>

  </td>

  </tr>

</table>
</form>
</td>

    <td width="438" valign="top">
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
  

  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr>
       <td  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='publishall';document.subject_fr.submit();" disabled="disabled"/>
         <input type="button" name="unpublishall" id="unpublishall" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='unpublishall';document.subject_fr.submit();" disabled="disabled"/></td>
       <td  align="right" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
       <form action="" method="post" name="search_fr" style="padding: 0px; margin: 0px;">
       <select name="agency_repair_cat" id="agency_repair_cat" style="width: 120px;" ><option value=""  >-Select category-</option>
             <?php $sqll = mysql_query("SELECT * FROM ".AGENCYREPAIR." WHERE status = '1' ");
                   while($arr = mysql_fetch_array($sqll))
                   {?>
                   <option value="<?php echo $arr['id'];?>" <?php if($arr['id'] == $_POST['agency_repair_cat']){echo "selected";}?>><?php echo $arr['cat_name'];?></option>
                   <?php }?> </select>
       <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 120px; font-weight: normal;" value="<?php echo $_POST['sertxt']; ?>">
         <input type="submit" name="search" id="search" value=" Search " class="actionBtn"/>
         </form>
       </td>
       </tr>
  </table>
  <form action="" method="post" name="subject_fr" style="padding: 0px; margin: 0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td style="border-top: 0px solid #99C; padding-left: 0px;">
	<input type="hidden" name="checked_id" id="checked_id" value=""/>
    <table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr style="color: #FFF;">

	  <td width="5%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
       <td width="34%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Make</strong></td>
        <td width="28%" align="center" bgcolor="#333333"><strong>Agency Repair Category</strong></td>
       <td width="15%" align="center" bgcolor="#333333"><strong>Status</strong></td>
        <td width="18%" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
       <?php
	   if(isset($_POST['search'])){
	   		$startpoint=0;
			 $whr="";
	    	$pwhr="";
			if(!empty($_POST["sertxt"]) && !empty($_POST["agency_repair_cat"]))
			{
				$whr[]= "make LIKE '%".$_POST["sertxt"]."%' and agency_repair_cat like '".$_POST["agency_repair_cat"]."'";
			}else if(!empty($_POST["sertxt"]))
			{
				$whr[] = "make LIKE '%".$_POST["sertxt"]."%' ";
			}
			else if(!empty($_POST["agency_repair_cat"]))
			{
				$whr[] = "agency_repair_cat like '".$_POST["agency_repair_cat"]."'";	
			}
			if(!empty($whr))
			{
				$where=" where ".implode("and",$whr);
				$pwhr=implode(" and",$whr);
			}
		  $rs=mysql_query("SELECT * FROM ".VMAKE." ".$where."  ORDER BY id DESC LIMIT ".$startpoint.",".$perpage); 
	   }else{
		   $rs=mysql_query("SELECT * FROM ".VMAKE." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	   }
		if(mysql_num_rows($rs) > 0){
			$i=0;
		while($row=mysql_fetch_array($rs)){
		$bgcolor = ($i%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			$i++;
		  ?>
      <tr <?php echo $bgcolor; ?>>
        <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');"/></td>
		<td align="left"  style="padding-left: 5px;"><?php echo stripslashes($row["make"]); ?></td>
        <td align="center"  style="padding-left: 5px;"><?php 
		$cattype = mysql_fetch_assoc(mysql_query("SELECT * FROM ".AGENCYREPAIR." where id='".$row["agency_repair_cat"]."' LIMIT 1"));
		echo (!empty($cattype['cat_name']))?stripslashes($cattype["cat_name"]):'N/A'; ?></td>
		<td width="15%" align="center" >
		  <?php if($row['status'] == 0) echo "Inactive"; else echo "Active"; ?></td>
        <td width="18%" align="center" ><a href="account.php?page=vehicle&view=make&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit User Profile" style="cursor: pointer;"></a>&nbsp;<a href="account.php?page=vehicle&view=make&task=delete&id=<?php echo $row["id"];  ?> " onclick="return confirm('Are You Sure To Delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;"></a></td>
  </tr>
        <?php }}else{
			?>
            <tr>
        <td colspan="4" align="center" >No Make Listed</td>
		</tr>
            <?php
		}?>
 </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td><input type="button" name="deleteall" id="deleteall1" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
  
      <input type="button" name="publishall" id="publishall1" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='publishall';document.subject_fr.submit();" disabled="disabled"/>

      <input type="button" name="unpublishall" id="unpublishall1" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='unpublishall';document.subject_fr.submit();" disabled="disabled"/>
  
      <input type="hidden" name="todo" id="todo" value=""/></td>
  </tr>
  <tr>
  	<td align="right">
		<?php
		if(isset($_POST['search']))
		{
			echo Paging(VMAKE,$perpage,"account.php?page=vehicle&view=make&",$pwhr);
		
		}else
		{
			echo Paging(VMAKE,$perpage,"account.php?page=vehicle&view=make&");
		} ?>
	</td>
  </tr>
</table>
<!-- @end users list -->
 </form>
   

  </td>

  </tr>

</table>
</td>

  </tr>

  <tr>

    <td colspan="2" valign="top" style="padding-top: 5px;">&nbsp;</td>

  </tr>

</table>
<?php }?>


<?php
if($view=='model')
{?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="262" valign="top" style="padding-right: 10px;">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Add/Edit Model</strong></td>
          </tr>
        </table>
<form action="" method="post" name="modelform" onSubmit="return validateModel();">
  
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>

    <td style="padding-top: 5px;"><table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td>Make</td>
		<td>
		<?php 
		if($makeno=mysql_num_rows($make)>0)
		{?>
			<select name="make_id" style="width: 193px; font-weight: normal;">
				<?php 
				while($makelist=mysql_fetch_array($make))
				{?>
					<option value="<?php echo $makelist['id'];?>" <?php if(getElementVal('make_id',$datalist)==$makelist['id'])echo 'selected="selected"';?>><?php echo $makelist['make'];?></option>
				<?php }
				?>
			</select>
		<?php }
		else
		{
			echo 'Please <a href="account.php?page=vehicle&view=make" style="text-decoration:underline">add make</a> first.';
		}?>
		</td>
	</tr>
      <tr>
        <td style="padding-left: 0px;">Model(En):</td>
        <td style="padding-right: 0px;">
			<input name="model" type="text" class="textbox" id="model" style="width: 187px; font-weight: normal;" value="<?php echo getElementVal('model',$datalist); ?>">
		</td>
      </tr>
	  
	  <tr>
        <td style="padding-left: 0px;">Model(Ar):</td>
        <td style="padding-right: 0px;"><input name="model_ar" type="text" class="textbox" id="model_ar" style="width: 187px; font-weight: normal;" value="<?php echo getElementVal('model_ar',$datalist); ?>"></td>
      </tr>
	  
	  
      <tr>
        
        <td width="26%" style="padding-left: 0px;">Set Status:</td>
        
        <td width="74%" style="padding-right: 0px;"><select name="status" id="status" style="width: 193px; font-weight: normal;">
          
          <option value="1" <?php if(getElementVal('status',$datalist) == '1') echo "selected='selected'"; ?>>Active</option>
          
          <option value="0" <?php if(getElementVal('status',$datalist) == '0') echo "selected='selected'"; ?>>Inactive</option>
          
          </select></td>
        
      </tr>
      <tr>
        <td colspan="2" style="padding-left: 0px;padding-top: 10px;">
          <?php
	if($makeno==0)	$btndis='disabled="disabled"';
	if($id != "" && $task == "edit"){

    ?>
          <input type="submit" name="update" id="update" value=" Update to List " class="actionBtn" <?php echo $btndis;?>>
          <?php }else{ ?>
          <input type="submit" name="save" id="save" value=" Add to List " class="actionBtn" <?php echo $btndis;?>>
          <?php } ?>
          <input type="button" name="cancel" id="cancel" value=" Reset " class="actionBtn" onclick="location.href='account.php?page=vehicle'">
        </td>
        </tr>

      </table>

  </td>

  </tr>

</table>
</form>
</td>

    <td width="438" valign="top">
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
  

  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr>
       <td  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='deleteall';document.subject_fr.submit();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='publishall';document.subject_fr.submit();" disabled="disabled"/>
         <input type="button" name="unpublishall" id="unpublishall" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='unpublishall';document.subject_fr.submit();" disabled="disabled"/></td>
       <td  align="right" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
       <form action="" method="post" name="search_fr" style="padding: 0px; margin: 0px;">
       <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 120px; font-weight: normal;" value="<?php echo $_POST['sertxt']; ?>">
         <input type="submit" name="search" id="search" value=" Search " class="actionBtn" />
         </form>
       </td>
       </tr>
  </table>
  <form action="" method="post" name="subject_fr" style="padding: 0px; margin: 0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td style="border-top: 0px solid #99C; padding-left: 0px;">
	<input type="hidden" name="checked_id" id="checked_id" value=""/>
    <table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr style="color: #FFF;">

	  <td width="6%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
       <td width="36%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Model Name</strong></td>
       <td width="20%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Make</strong></td>
       <td width="19%" align="center" bgcolor="#333333"><strong>Status</strong></td>
        <td width="19%" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
       <?php
	   if(isset($_POST['search'])){
		  $rs=mysql_query("SELECT * FROM ".VMODEL." WHERE model LIKE '%".$_POST["sertxt"]."%' ORDER BY id DESC LIMIT ".$startpoint.",".$perpage); 
	   }else{
		   $rs=mysql_query("SELECT * FROM ".VMODEL." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	   }
		if(mysql_num_rows($rs) > 0){
			$i=0;
		while($row=mysql_fetch_array($rs)){
		$bgcolor = ($i%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			$i++;
		  ?>
      <tr <?php echo $bgcolor; ?>>
        <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');"/></td>
		<td align="left"  style="padding-left: 5px;"><?php echo stripslashes($row["model"]); ?></td>
		<td align="left"  style="padding-left: 5px;"><?php echo getVehicleMake($row["make_id"]); ?></td>
		<td width="19%" align="center" >
		  <?php if($row['status'] == 0) echo "Inactive"; else echo "Active"; ?></td>
        <td width="19%" align="center" ><a href="account.php?page=vehicle&view=model&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit User Profile" style="cursor: pointer;"></a>&nbsp;<a href="account.php?page=vehicle&view=model&task=delete&id=<?php echo $row["id"];  ?> " onclick="return confirm('Are You Sure To Delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;"></a></td>
  </tr>
        <?php }}else{
			?>
            <tr>
        <td colspan="4" align="center" >No Model Listed</td>
		</tr>
            <?php
		}?>
 </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td><input type="button" name="deleteall" id="deleteall1" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='deleteall';document.subject_fr.submit();" disabled="disabled"/>
  
      <input type="button" name="publishall" id="publishall1" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='publishall';document.subject_fr.submit();" disabled="disabled"/>

      <input type="button" name="unpublishall" id="unpublishall1" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='unpublishall';document.subject_fr.submit();" disabled="disabled"/>
  
      <input type="hidden" name="todo" id="todo" value=""/></td>
  </tr>
<tr>
	<td align="right">
		<?php
		if(isset($_POST['search']))
		{
			echo Paging(VMODEL,$perpage,"account.php?page=vehicle&view=model&","model LIKE '%".$_POST['sertxt']."%' ORDER BY id DESC");
		
		}else
		{
			echo Paging(VMODEL,$perpage,"account.php?page=vehicle&view=model&");
		} ?>
	</td>
</tr>

</table>
<!-- @end users list -->
 </form>
   

  </td>

  </tr>

</table>
</td>

  </tr>

  <tr>

    <td colspan="2" valign="top" style="padding-top: 5px;">&nbsp;</td>

  </tr>

</table>
<?php }

if($view=='type')
{?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="262" valign="top" style="padding-right: 10px;">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Add/Edit Type</strong></td>
          </tr>
        </table>
<form action="" method="post" name="typeform" onSubmit="return validateType();">
        
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>

    <td style="padding-top: 5px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	  <tr>
	  	<td>Type :</td>
		<td>
			<input type="radio" name="is_tpl_comp" value="tpl" onclick="showMakeModel(this.value);" <?php if(getElementVal('is_tpl_comp',$datalist)=='comp'){}else{ echo 'checked="checked"';}?> />TPL
			<input type="radio" name="is_tpl_comp" value="comp" onclick="showMakeModel(this.value);" <?php if(getElementVal('is_tpl_comp',$datalist)=='comp'){ echo 'checked="checked"';}?>  />Comprehensive
		</td>
	  </tr>
	  <tr>
	  	<td>Make :</td>
		<td>
		<?php if($makeno=mysql_num_rows($make)>0)
		{?>
			<select name="make_id" id="make_id" style="width: 193px; font-weight: normal;" onchange="getModel(this.value);" <?php if(getElementVal('is_tpl_comp',$datalist)=='comp'){}else{echo 'disabled="disabled"';}?>>
			<option value="">Select</option>
				<?php 
				while($makelist=mysql_fetch_array($make))
				{?>
					<option value="<?php echo $makelist['id'];?>" <?php if(getElementVal('make_id',$datalist)==$makelist['id']){echo 'selected="selected"';}?>><?php echo $makelist['make'];?></option>
				<?php }
				?>
			</select>
		<?php }
		else
		{?>
			<select name="nomake_id" id="nomake_id" style="width: 193px; font-weight: normal;" disabled="disabled">
				<option>make</option>
			</select>
		<?php 
			echo '<span id="makemsg" style="display:none">Please <a href="account.php?page=vehicle&view=make" style="text-decoration:underline">add make</a> first.</span>';
		}?>
		</td>
	  </tr>
	  <tr>
	  	<td>Model :</td>
		<td id="modelbox">
		<?php 
		$lmake_id=$lmakeid[0];
		 if(getElementVal('make_id',$datalist))
		 	$lmake_id=getElementVal('make_id',$datalist);
		$model=mysql_query("SELECT * FROM ".VMODEL." WHERE make_id=".$lmake_id." ORDER BY id DESC");
		?>
		<select name="model_id" id="model_id" style="width: 193px; font-weight: normal;" <?php if(getElementVal('is_tpl_comp',$datalist)=='comp'){}else{echo 'disabled="disabled"';}?>>
			<option value="">Select</option>
		<?php 
		if($modelno=mysql_num_rows($model)>0)
		{?>
			
				<?php 
				while($model_list=mysql_fetch_array($model))
				{?>
					<option value="<?php echo $model_list['id'];?>" <?php if(getElementVal('model_id',$datalist)==$model_list['id']){echo 'selected="selected"';}?>><?php echo $model_list['model'];?></option>
				<?php }
				?>
			
		<?php }?>
		</select>
		</td>
	  </tr>
       <tr>
	  	<td>Vehicle Use :</td>
		<td>
		
			<select name="vehicle_use" id="vehicle_use" style="width: 193px; font-weight: normal;" <?php if(getElementVal('is_tpl_comp',$datalist)=='comp'){echo 'disabled="disabled"';}?>>
				<option value="">Select</option>
				<?php 
				$vehicle_usesql=mysql_query("SELECT * FROM ".POLICYUSE." WHERE status='1' ORDER BY id DESC");
				while($vehicle_use=mysql_fetch_array($vehicle_usesql))
				{?>
					<option value="<?php echo $vehicle_use['id'];?>" <?php if(getElementVal('vehicle_use',$datalist)==$vehicle_use['id']){echo 'Selected="selected"';} ?>><?php echo $vehicle_use['name'];?></option>
				<?php }
				?>
			</select>
		
		</td>
	  </tr>
      <tr>
        <td style="padding-left: 0px;" width="26%">Type Name(En):</td>
        <td style="padding-right: 0px;"><input name="type_name" type="text" class="textbox" id="type_name" style="width: 187px; font-weight: normal;" value="<?php echo getElementVal('type_name',$datalist); ?>"></td>
      </tr>
	  
	  <tr>
        <td style="padding-left: 0px;">Type Name(Ar):</td>
        <td style="padding-right: 0px;"><input name="type_name_ar" type="text" class="textbox" id="type_name_ar" style="width: 187px; font-weight: normal;" value="<?php echo getElementVal('type_name_ar',$datalist); ?>"></td>
      </tr>
	  
	  
      <tr>
        
        <td width="26%" style="padding-left: 0px;">Set Status:</td>
        
        <td width="74%" style="padding-right: 0px;"><select name="status" id="status" style="width: 193px; font-weight: normal;">
          
          <option value="1" <?php if(getElementVal('status',$datalist) == '1') echo "selected='selected'"; ?>>Active</option>
          
          <option value="0" <?php if(getElementVal('status',$datalist) == '0') echo "selected='selected'"; ?>>Inactive</option>
          
          </select></td>
        
      </tr>
      <tr>
        <td colspan="2" style="padding-left: 0px;padding-top: 10px;">
          <?php

	if($id != "" && $task == "edit"){

    ?>
          <input type="submit" name="update" id="update" value=" Update to List " class="actionBtn">
          <?php }else{ ?>
          <input type="submit" name="save" id="save" value=" Add to List " class="actionBtn">
          <?php } ?>
          <input type="button" name="cancel" id="cancel" value=" Reset " class="actionBtn" onclick="location.href='account.php?page=vehicle'">
        </td>
        </tr>

      </table>

  </td>

  </tr>

</table>
</form>
</td>

    <td width="438" valign="top">
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
  

  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr>
       <td  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='deleteall';document.subject_fr.submit();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='publishall';document.subject_fr.submit();" disabled="disabled"/>
         <input type="button" name="unpublishall" id="unpublishall" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='unpublishall';document.subject_fr.submit();" disabled="disabled"/></td>
       <td  align="right" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
       <form action="" method="post" name="search_fr" style="padding: 0px; margin: 0px;">
       <input name="sertxt" type="text" class="textbox" id="sertxt" style="width: 120px; font-weight: normal;" value="<?php echo $_POST['sertxt']; ?>">
         <input type="submit" name="search" id="search" value=" Search " class="actionBtn"/>
         </form>
       </td>
       </tr>
  </table>
  <form action="" method="post" name="subject_fr" style="padding: 0px; margin: 0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td style="border-top: 0px solid #99C; padding-left: 0px;">
	<input type="hidden" name="checked_id" id="checked_id" value=""/>
    <table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr style="color: #FFF;">

	  <td width="6%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
       <td width="40%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Type Name</strong></td>
       <td width="20%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Make</strong></td>
       <td width="20%" align="left" bgcolor="#333333" style="padding-left: 5px;"><strong>Model</strong></td>
       <td width="19%" align="center" bgcolor="#333333"><strong>Status</strong></td>
        <td width="19%" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
       <?php
	   if(isset($_POST['search'])){
		  $rs=mysql_query("SELECT * FROM ".VTYPE." WHERE type_name LIKE '%".$_POST["sertxt"]."%' ORDER BY id DESC LIMIT ".$startpoint.",".$perpage); 
	   }else{
		   $rs=mysql_query("SELECT * FROM ".VTYPE." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	   }
		if(mysql_num_rows($rs) > 0){
			$i=0;
		while($row=mysql_fetch_array($rs)){
		$bgcolor = ($i%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			$i++;
		  ?>
      <tr <?php echo $bgcolor; ?>>
        <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $i;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $i;?>');"/></td>
		<td align="left"  style="padding-left: 5px;"><?php echo stripslashes($row["type_name"]); ?></td>
		<td align="left"  style="padding-left: 5px;"><?php if($row["make_id"])echo getVehicleMake($row["make_id"]);else echo 'N/A'; ?></td>
		<td align="left"  style="padding-left: 5px;"><?php if($row["model_id"])echo getVehicleModel($row["model_id"]);else echo 'N/A'; ?></td>
		<td width="19%" align="center" >
		  <?php if($row['status'] == 0) echo "Inactive"; else echo "Active"; ?></td>
        <td width="19%" align="center" ><a href="account.php?page=vehicle&view=type&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit User Profile" style="cursor: pointer;"></a>&nbsp;<a href="account.php?page=vehicle&view=type&task=delete&id=<?php echo $row["id"];  ?> " onclick="return confirm('Are You Sure To Delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;"></a></td>
 	 </tr>
        <?php }}else{
			?>
            <tr>
        <td colspan="4" align="center" >No Type Listed</td>
		</tr>
            <?php
		}?>
 </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td><input type="button" name="deleteall" id="deleteall1" value="Delete" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='deleteall';document.subject_fr.submit();" disabled="disabled"/>
  
      <input type="button" name="publishall" id="publishall1" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='publishall';document.subject_fr.submit();" disabled="disabled"/>

      <input type="button" name="unpublishall" id="unpublishall1" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.subject_fr.todo.value='unpublishall';document.subject_fr.submit();" disabled="disabled"/>
  
      <input type="hidden" name="todo" id="todo" value=""/></td>
  </tr>
	<tr>
		<td align="right">
			<?php
			if(isset($_POST['search']))
			{
				echo Paging(VTYPE,$perpage,"account.php?page=vehicle&view=type&","type_name LIKE '%".$_POST['sertxt']."%' ORDER BY id DESC");
			
			}else
			{
				echo Paging(VTYPE,$perpage,"account.php?page=vehicle&view=type&");
			} ?>
		</td>
	</tr>
</table>
<!-- @end users list -->
 </form>
   

  </td>

  </tr>

</table>
</td>

  </tr>

  <tr>

    <td colspan="2" valign="top" style="padding-top: 5px;">&nbsp;</td>

  </tr>

</table>
<?php }?>





