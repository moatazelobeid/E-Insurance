<?php
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
		$upd="update ".PAGEMENU." set ordering='".$ordx[$i]."' where menu_id='".$srvcid[$i]."' ";
		mysql_query($upd) or die(mysql_error());
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
					$db->recordDelete(array("menu_id" =>$id),PAGEMENU);
					//$db->recordDelete($id,array(PAGEMENU => 'menu_id'));
					$count++;
				
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("menu_id" => $id),array('status'=>'1'),PAGEMENU) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("menu_id" => $id),array('status'=>'0'),PAGEMENU) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
		}
		break;
	}
}
// delete individual users
if($_GET['id'] != "" && $_GET['action'] == "delete")
{
	mysql_query("DELETE FROM ".PAGEMENU." WHERE menu_id = '".$_GET['id']."'");
	if(mysql_affected_rows() > 0)
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
	else
	echo "<script>alert('Record Deletion Failed');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
	
}
if(isset($_GET["id"]) && $_GET["action"]=="block") {
$id=$_GET["id"];
$upd="update ".PAGEMENU." set status=1 where menu_id='$id'";
mysql_query($upd) or die(mysql_error());
if(mysql_affected_rows() > 0)
echo "<script>alert('Record Published Sucessfully');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
else
echo "<script>alert('Record Published Failed');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
}

if(isset($_GET["id"]) && $_GET["action"]=="activate") {
$id=$_GET["id"];
$upd="update ".PAGEMENU." set status=0 where menu_id='$id'";
mysql_query($upd) or die(mysql_error());
if(mysql_affected_rows() > 0)
echo "<script>alert('Record Unpublished Sucessfully');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
else
echo "<script>alert('Record Unpublished Failed');location.href='account.php?page=menu&part=".$_GET['part']."';</script>";
}

// update
if(isset($_POST['update'])){
// validate title
if(!empty($_POST['menu_title']) && trim($_POST['menu_title']) != ""){
if($_GET['id'] != "" && !empty($_GET['id'])){
	// get param
	$menu_title = addslashes($_POST['menu_title']);
    $menu_title_ar = addslashes($_POST['menu_title_ar']);
	$menu_allias = addslashes($_POST['menu_allias']);
	$menu_link = addslashes($_POST['menu_link']);
	$menu_position = addslashes($_POST['menu_position']);
	$footer_menu_position = addslashes($_POST['footer_menu_position']);
	//$menu_order = $_POST['ordering'];
	$menu_access=$_POST['menu_access'];
	$menu_parent=$_POST['menu_parent'];
	$menu_status=$_POST['menu_status'];
	$menu_assign=$_POST['menu_assign'];
	$menu_user = $_POST['assign_user'];
	
$id = $_GET["id"];
$msg = "";
// check title
if($menu_allias==""){
	$dallias=strtolower($menu_title);
	}else {
		$dallias=strtolower($menu_allias);
	}
	$menu_allias=str_replace(" ","-",$dallias);
	$aaw=mysql_fetch_object(mysql_query("SELECT COUNT(*) AS sam FROM ".PAGEMENU." WHERE allias = '".$menu_allias."' AND menu_position = '".$menu_position."' AND menu_id != '".$id."'"));
if($aaw->sam > 0){
$msg = "Allias Already Exists!";
}else{
	
// update to database
//echo "UPDATE ".PAGEMENU." SET menu_title = '".$menu_title."', menu_title_ar ='".$menu_title_ar."', allias = '".$menu_allias."',menu_link = '".$menu_link."',menu_position = '".$menu_position."',ordering = '".$menu_order."',menu_access = '".$menu_access."',menu_parent = '".$menu_parent."',menu_assign = '".$menu_assign."',status = '".$menu_status."',create_date = '".date("Y-m-d")."',footer_menu_position='".$footer_menu_position."', menu_user ='".$menu_user."' WHERE menu_id = '".$id."'";

mysql_query("UPDATE ".PAGEMENU." SET menu_title = '".$menu_title."', menu_title_ar ='".$menu_title_ar."',allias = '".$menu_allias."',menu_link = '".$menu_link."',menu_position = '".$menu_position."',ordering = '".$menu_order."',menu_access = '".$menu_access."',menu_parent = '".$menu_parent."',menu_assign = '".$menu_assign."',status = '".$menu_status."',create_date = '".date("Y-m-d")."',footer_menu_position='".$footer_menu_position."', menu_user ='".$menu_user."' WHERE menu_id = '".$id."'");


if(mysql_affected_rows() > 0){
//redirect
header("location:account.php?page=menu");
}else{
$msg = "Menu Update Failed!";
}
}
}else{
$msg = "Operation Aborted due to parameter insufficiency";
}}else{
// error message
$msg = "Enter Menu Title";
}
}

// trace page information from database
if($_GET['id'] != "" && !empty($_GET['id'])){
	$sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_id = '".$_GET['id']."'");
if(mysql_num_rows($sq) > 0){
$res = mysql_fetch_object($sq);
// get param
$menu_id=$res->menu_id;
$menu_title = stripslashes($res->menu_title);
$menu_title_ar = stripslashes($res->menu_title_ar);
$menu_allias = stripslashes($res->allias);
$menu_link = stripslashes($res->menu_link);
$menu_position = stripslashes($res->menu_position);
$footer_menu_position = stripslashes($res->footer_menu_position);
$menu_order = $res->ordering;
$menu_access = $res->menu_access;
$menu_parent = $res->menu_parent;
$menu_assign = $res->menu_assign;
$menu_user = $res->menu_user;
$menu_status = $res->status;
}
}


// save
if(isset($_POST['save'])){
if(!empty($_POST['menu_title']) && trim($_POST['menu_title']) != ""){
	// get param
	$menu_title = addslashes($_POST['menu_title']);
	$menu_title_ar = addslashes($_POST['menu_title_ar']);
	$menu_allias = addslashes($_POST['menu_allias']);
	$menu_link = addslashes($_POST['menu_link']);
	$menu_position = addslashes($_POST['menu_position']);
	$footer_menu_position = addslashes($_POST['footer_menu_position']);
	//$menu_order = $_POST['ordering'];
	$menu_access=$_POST['menu_access'];
	$menu_parent=$_POST['menu_parent'];
	$menu_status=$_POST['menu_status'];
	//$menu_assign=$_POST['menu_assign'];
	$menu_user = $_POST['assign_user'];
	$msg = "";
if($menu_allias==""){
	$dallias=strtolower($menu_title);
	}else {
		$dallias=strtolower($menu_allias);
	}
	$menu_allias=str_replace(" ","-",$dallias);
// check title
$aaw=mysql_fetch_object(mysql_query("SELECT COUNT(*) AS sam FROM ".PAGEMENU." WHERE allias = '".$menu_allias."' AND menu_position = '".$menu_position."'"));
$sq = mysql_query("SELECT COUNT(*) AS total FROM ".PAGEMENU." WHERE menu_title = '".$menu_title."' AND menu_position = '".$menu_position."'");
$rsobj = mysql_fetch_object($sq);

if($rsobj->total > 0){
$msg = "Menu Title Already Exists!";
}else

if($aaw->sam > 0){
$msg = "Allias Already Exists!";
}else{
	
// save to database
mysql_query("INSERT INTO ".PAGEMENU." ( menu_title, menu_title_ar, allias, menu_link, menu_position, menu_access, menu_parent, menu_user, status, create_date,footer_menu_position) VALUES('".$menu_title."', '".$menu_title_ar."', '".$menu_allias."','".$menu_link."','".$menu_position."','".$menu_access."','".$menu_parent."','".$menu_user."','".$menu_status."','".date("Y-m-d")."','".$footer_menu_position."')");
if(mysql_affected_rows() > 0){
header("location:account.php?page=menu");
}else{
$msg = "Menu Saving Failed!";
}
}
}else{
// error message
$msg = "Enter Menu Title";
}
}
?>
<script type="text/javascript">
function load_parent(id)
{    
if(id==3){
	$("#footerheader").show();
	}else{
	$("#footerheader").hide();
		
		}
    $.ajax({
         type: "POST",
         url: "util/parent.php",
         data: "id=" + id,
         success: function(msg){
			$("#parent").html(msg);
			        
			}    
		});
}
function valForm()
{
var str=document.menu_fr;
if(str.menu_title.value=='')
	{
		document.getElementById("mtitle").innerHTML="Enter Title";
		str.menu_title.focus();
		return false;
	}else{
	document.getElementById("mtitle").innerHTML="";
    }
	
	if(str.menu_title_ar.value=='')
	{
		document.getElementById("mtitle_ar").innerHTML="Enter Title For Arabic";
		str.menu_title_ar.focus();
		return false;
	}else{
	document.getElementById("mtitle_ar").innerHTML="";
    }
	
	
	if(str.menu_position.value=='')
	{
		document.getElementById("mpos").innerHTML="Select Position";
		str.menu_position.focus();
		return false;
	}else{
	document.getElementById("mpos").innerHTML="";
    }
}
function assign_menu(id)
{
	if(id == 1)
	{
		$("#assignuser").show();
	}
}
//check all
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
  var retVal = confirm("Do you want to Delete this Menu ?");
   if( retVal == true ){
      
	   document.chapter_fr.todo.value='deleteall';document.chapter_fr.submit();
	  return true;
   }else{
      
	  return false;
	
   }


 }
</script>
<?php if($_GET["task"]!='') {?>
<div style="width: 100%; margin: 0 auto; margin-top: 15px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Add/Edit Menu</strong></td>
      <td align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=menu"><img src="images/view_all.png" width="87" height="15" border="0" /></a></td>
    </tr>
  </table>
  <?php if($msg <> ""){
?>
  <div style="border: 1px solid #990; background-color: #FFC; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="6%"><img src="../images/warning.png" width="20" height="20"></td>
<td width="94%"><?php echo $msg; ?></td>
</tr>
</table>
</div>
<?php } ?>
  <form action="" method="post" name="menu_fr" onsubmit="return valForm();">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="18%">Menu Title (En):</td>
        <td width="82%"><input name="menu_title" type="text" class="textbox" id="menu_title" value="<?php echo $menu_title; ?>" style="width: 200px;"> <span id="mtitle" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
		
		<tr>
        <td width="18%">Menu Title (Ar):</td>
        <td width="82%"><input name="menu_title_ar" type="text" class="textbox" id="menu_title_ar" value="<?php echo $menu_title_ar; ?>" style="width: 200px;"> <span id="mtitle_ar" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
		
      <tr>
        <td>Menu Allias</span>:</td>
        <td><input name="menu_allias" type="text" class="textbox" id="menu_allias" value="<?php echo $menu_allias; ?>" style="width: 200px;" /></td>
        </tr>
      <tr>
        <td>Link: </td>
        <td><input name="menu_link" type="text" class="textbox" id="menu_link" value="<?php echo $menu_link; ?>" style="width: 200px;" />
          <span style="color:#F00; padding-left:2px;">(Used Only For developer)</span></td>
        </tr>
      <tr>
        <td>Position:</td>
        <td><select name="menu_position" size="1" id="menu_position" onchange="load_parent(this.value);" style="width: 205px;">
          <option selected="selected" value="">Select</option>
          <option value="1" <?php if($menu_position == "1") echo "selected='selected'"; ?>>top</option>
          <option value="2" <?php if($menu_position == "2") echo "selected='selected'"; ?>>right</option>
          <option value="3" <?php if($menu_position == "3") echo "selected='selected'"; ?>>bottom</option>
          <option value="4" <?php if($menu_position == "4") echo "selected='selected'"; ?>>left</option>
        </select> <span id="mpos" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
        <tr id="footerheader" <?php if($_GET['id']==''){?>style="display:none" <?php }?>>
        <td valign="top">Footer Header:</td>
        <td>
        <select name="footer_menu_position" id="footer_menu_position" style="width: 205px;">
		 
		  <option value="">Select Footer Position</option>
          <option value="1" <?php if($footer_menu_position == "1") echo "selected='selected'"; ?>>Quick Links</option>
          <option value="3" <?php if($footer_menu_position == "3") echo "selected='selected'"; ?>>Support Center</option>
		  <option value="2" <?php if($footer_menu_position == "2") echo "selected='selected'"; ?>>Bottom Footer</option>
		  
         <!-- <option value="4" <?php if($footer_menu_position == "4") echo "selected='selected'"; ?>>Right Bottom</option>-->

        </select></td>
        </tr>
        
      <tr>
        <td valign="top">Menu Access:</td>
        <td>
        <select name="menu_access" id="menu_access" style="width: 205px;" >
          <option value="0" <?php if($menu_access == "0") echo "selected='selected'"; ?>>Public</option>
          <option value="1" <?php if($menu_access == "1") echo "selected='selected'"; ?>>Registered</option>
          <option value="2" <?php if($menu_access == "2") echo "selected='selected'"; ?>>Both</option>
        </select></td>
        </tr>
      <tr>
        <td valign="top">Menu Parent:</td>
        <td><div id="parent"><select name="menu_parent" size="10" id="menu_parent" style="width:205px;">
          <option value="">--- Select Parent ---</option>
          <?php  
		  $acc=mysql_query("select * from ".PAGEMENU." WHERE menu_position = '".$menu_position."' ORDER BY menu_id ASC");
   while($acci=mysql_fetch_array($acc)){
	   ?>
           <option value="<?php echo $acci["menu_id"]; ?>" <?php if($menu_parent == $acci["menu_id"] ) echo "selected='selected'"; ?>><?php echo $acci["menu_title"]; ?></option>
          <?php }?>
        </select></div></td>
        </tr>
      <tr>
        <td>Assign Menu:</td>
        <td><select name="menu_assign" id="menu_assign" style="width: 205px;">
          <option value="">--- Select Pages ---</option>
          <?php  
		
	 	$rs=mysql_query("select * from ".PAGETBL." WHERE pg_section = '0' order by id");
	  	while($row=mysql_fetch_array($rs)){
			
		?>
          <option value="<?php echo $row["id"]; ?>" <?php if($menu_assign == $row["id"] ) echo "selected='selected'"; ?>>
            <?php echo stripslashes($row['pg_title']); ?>
            </option>
          <?php
		}
		?>
        </select> 
          <span style="color: #999;">(Select Pages to which the menu will assign)</span></td>
        </tr>
      <tr>
        <td>Status:</td>
        <td>
          <select name="menu_status" id="menu_status" style="width: 205px;">
            <option value="">--- Select ---</option>
            <option value="1" <?php if($menu_status == "1") echo "selected='selected'"; ?>>Active</option>
            <option value="0" <?php if($menu_status == "0") echo "selected='selected'"; ?>>Inactive</option>
          </select>
        </td>
        </tr>
      <tr>
        <td colspan="2"><?php
	if($task == "new" && $_GET['id'] == ""){
	?>
          <input name="save" type="submit" id="save" value=" Save "  class="actionBtn">
          <?php
	}else{
	?>
          <input name="update" type="submit" id="update" value=" Update "  class="actionBtn">
          <?php } ?></td>
      </tr>
    </table>
  </td>
  </tr>
</table>
</form>
</div>
<?php } else {
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 30;//limit in each page
$startpoint = ($part * $perpage) - $perpage;
?>
<div style="width: 100%; margin: 0 auto; margin-top: 25px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Menu Manager</strong></td>
      <td align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><a href="account.php?page=menu&task=new"><div class="button_admin">Add New Menu</div></a></td>
    </tr>
  </table>
   <form action="" method="post" name="chapter_fr" id="chapter_fr">
  <table width="100%" border="0" cellspacing="0" cellpadding="3" style="background-color: #f2f2f2;">
 
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="45%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
         <input type="button" name="unpublishall" id="unpublishall" value="Inactive " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/></td>
        <td width="24%" align="right">Menu Title:</td>
        <td width="23%" align="right" style="padding-left: 4px;"><input name="menu_title" type="text" class="textbox" id="menu_title" style="width: 200px;" value="<?php echo $_POST["menu_title"]; ?>"></td>
        <td width="8%" align="right"><input type="submit" name="search" id="search" value=" Search " class="actionBtn"></td>
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
        <td width="9%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
        <td width="4%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
        <td width="18%" align="left" bgcolor="#333333"><strong>Menu Title</strong></td>
        <td width="20%" align="center" bgcolor="#333333"><strong>Position</strong></td>
        <td width="11%" align="center" bgcolor="#333333"><strong>Access</strong></td>
        <td width="13%" align="center" bgcolor="#333333"><strong>Parent</strong></td>
        <td width="9%" align="center" bgcolor="#333333"><strong>Order</strong><input type="submit" name="save_order" style="background:url(<?php echo BASE_URL; ?>images/s_b.gif);border:none;cursor:pointer;margin-left:3px;background-repeat:no-repeat;" value="" /></td>
        <td width="11%" align="center" bgcolor="#333333"><strong>Status</strong></td>
        <td width="14%" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
      <?php
	  if(isset($_POST["search"])){
		  $j = 0;
		  $i = 0;
	 $sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_title LIKE '%".$_POST["menu_title"]."%' ORDER BY menu_id ASC LIMIT ".$startpoint.",".$perpage);
	  }
	  else{
		  $j = 0;
		  $i = 0;
		  $sq = mysql_query("SELECT * FROM ".PAGEMENU." ORDER BY menu_id ASC LIMIT ".$startpoint.",".$perpage);
	  }
	  if(mysql_num_rows($sq) > 0){
		  if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=(15*($_GET["part"]-1))+1;}
	  while($res = mysql_fetch_array($sq)){
		  $j++;
		   $bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
	  ?>
      <tr <?php echo $bgcolor; ?>>
        <td align="center"><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $j;?>" value="<?php echo $res['menu_id']; ?>" onclick="check_single('chkNo<?php echo $j;?>');" /></td>
        <td align="center"><strong><?php echo $j; ?></strong></td>
        <td align="left"><span style="text-transform: capitalize;"><?php echo $res["menu_title"]; ?></span></td>
        <td align="center">
		
		<?php $pos=$res["menu_position"];
		 if($pos==1){echo "Top";}if($pos==2){echo "Right";}if($pos==3){echo "Bottom";  $posf=$res["footer_menu_position"];
			if($posf==1){echo " (Quick Links)";} if($posf==2){echo " (Bottom Footer)";} if($posf==3){echo " (Support Center)";} if($posf==4){echo " (Right Bottom)";}}if($pos==4){echo "Left";}?>
			</td>
        <td align="center"><?php if($res["menu_access"] == 0){echo "Public";}if($res["menu_access"]==1){echo "Registered";} if($res["menu_access"]==2){echo "Both";}?></td>
        <td align="center">
			<?php $sjq=mysql_fetch_array(mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_id='".$res["menu_parent"]."'")); 
			echo $sjq["menu_title"]; 
			if(!$sjq["menu_title"])echo '-';?>
		</td>
		<td align="center"><input name="order_set[]" type="text" class="input" id="order_set" style="width: 40px; text-align: center;" value="<?php echo $res["ordering"]; ?>"><input  type="hidden" name="id[]"  value="<?php echo $res["menu_id"]; ?>" style="width:20px;" /></td>
        <td align="center"><?php if($res["status"]=='0') { ?>
          <a href="account.php?page=menu&amp;action=block&amp;id=<?php echo $res["menu_id"]; ?>&part=<?php echo $_GET['part']; ?>"><font color="#FF0000">InActive</font>
          <?php } else {?>
          </a><a href="account.php?page=menu&amp;action=activate&amp;id=<?php echo $res["menu_id"]; ?>&part=<?php echo $_GET['part']; ?>"><font color="#006633">Active </font></a>
          <?php } ?></td>
        <td align="center"><a href="account.php?page=menu&task=edit&id=<?php echo $res['menu_id']; ?>&part=<?php echo $_GET['part']; ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a>&nbsp;<a href="account.php?page=menu&action=delete&id=<?php echo $res['menu_id']; ?>&part=<?php echo $_GET['part']; ?>" onclick="return confirm('Are you sure to delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a></td>
        </tr>
      <?php
	  }}else{
		  ?>
          <tr>
        <td colspan="8" align="center" bgcolor="#F2FBFF">No Record Found</td>
        </tr>
			<?php
			}
			?>

          <tr>
        <td colspan="8" align="left" bgcolor="#F2FBFF"><input type="button" name="deleteall" id="deleteall1" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
      <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="publishall" id="publishall1" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span><span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
      <input type="button" name="unpublishall" id="unpublishall1" value="Inactive " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span>
      <input type="hidden" name="todo" id="todo" value=""/></td>
        <td align="left" bgcolor="#F2FBFF"></td>
          </tr>
       
      <tr>
            <td colspan="8" align="center">
<?php
			 if(isset($_POST['search'])){
				  echo Paging(PAGEMENU,$perpage,"account.php?page=menu&","menu_title LIKE '%".$_POST['menu_title']."%' ORDER BY menu_title DESC");
					
					}else{
					echo Paging(PAGEMENU,$perpage,"account.php?page=menu&");
					} 
			
			  ?>			
			
			</td>
          </tr>
          <tr><td colspan="8"><span style="color:red">Note: Search can be posible by menu name.</span></td></tr>
    </table>
	
	</td>
  </tr>
</table></form>
</div>
<?php } ?>

