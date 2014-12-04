
<?php
// update
if(isset($_POST['update'])){
// validate title
if(!empty($_POST['pg_title']) && trim($_POST['pg_title']) != ""){
if(($_GET['id'] != "" && !empty($_GET['id'])) || ($_POST['pg_id'] != "" && !empty($_POST['pg_id']))){
// get param
$pg_title = addslashes($_POST['pg_title']);
$pg_title_ar = addslashes($_POST['pg_title_ar']);
$pg_keyword = addslashes($_POST['pg_keyword']);
$pg_desp = addslashes($_POST['pg_desp']);
$pg_detail = addslashes($_POST['pg_detail']);
$pg_detail_ar = addslashes($_POST['pg_detail_ar']);
$parent_item = addslashes($_POST['parent_item']);
$pg_status = $_POST['pg_status'];
$pg_section = $_POST['pg_section'];
$id = ($_GET['id'] == "")?$_POST['pg_id']:$_GET['id'];
$msg = "";

// check title
$sq = mysql_query("SELECT COUNT(*) AS total FROM ".PAGETBL." WHERE pg_title = '".$pg_title."' AND id != '".$id."'");
$rsobj = mysql_fetch_object($sq);
if($rsobj->total > 0){
$msg = "Page Title Already Exists!";
}else{
// update to database
mysql_query("UPDATE ".PAGETBL." SET pg_title = '".$pg_title."',pg_title_ar = '".$pg_title_ar."',pg_detail = '".$pg_detail."',pg_detail_ar = '".$pg_detail_ar."',pg_keyword = '".$pg_keyword."',pg_desp = '".$pg_desp."',parent_item = '".$parent_item."',pg_section = '".$pg_section."',pg_status = '".$pg_status."',update_date = now() WHERE id = '".$id."'");
if(mysql_affected_rows() > 0){
//redirect
header("location:account.php?page=view_page");
}else{
$msg = "Page Update Failed";
}
}
}else{
$msg = "Operation Aborted due to parameter insufficiency!";
}}else{
// error message
$msg = "Enter Page Title";
}
}

// trace page information from database
if($_GET['id'] != "" && !empty($_GET['id'])){
$sq = mysql_query("SELECT * FROM ".PAGETBL." WHERE id = '".$_GET['id']."'");
if(mysql_num_rows($sq) > 0){
$res = mysql_fetch_object($sq);
// get param
$pg_title = stripslashes($res->pg_title);
$pg_title_ar = stripslashes($res->pg_title_ar);
$pg_keyword = stripslashes($res->pg_keyword);
$pg_desp = stripslashes($res->pg_desp);
$pg_detail = stripslashes($res->pg_detail);
$pg_detail_ar = stripslashes($res->pg_detail_ar);
$parent_item = stripslashes($res->parent_item);
$pg_status = $res->pg_status;
$update_date = $res->update_date;
$pg_section = $res->pg_section;
}
}

// save
if(isset($_POST['save'])){
if(!empty($_POST['pg_title']) && trim($_POST['pg_title']) != ""){
// get param
$pg_title = addslashes($_POST['pg_title']);
$pg_title_ar = addslashes($_POST['pg_title_ar']);
$pg_keyword = addslashes($_POST['pg_keyword']);
$pg_desp = addslashes($_POST['pg_desp']);
$pg_detail = addslashes($_POST['pg_detail']);
$pg_detail_ar = addslashes($_POST['pg_detail_ar']);
$parent_item = addslashes($_POST['parent_item']);
$pg_section = $_POST['pg_section'];
$pg_status = $_POST['pg_status'];
$msg = "";

// check title
$sq = mysql_query("SELECT COUNT(*) AS total FROM ".PAGETBL." WHERE pg_title = '".$pg_title."'");
$rsobj = mysql_fetch_object($sq);
if($rsobj->total > 0){
$msg = "Page Title Already Exists!";
}else{
// save to database
mysql_query("INSERT INTO ".PAGETBL."(pg_title,pg_title_ar,pg_detail,pg_detail_ar,pg_keyword,pg_desp,pg_section,parent_item,pg_status,update_date) VALUES('".$pg_title."','".$pg_title_ar."','".$pg_detail."','".$pg_detail_ar."','".$pg_keyword."','".$pg_desp."','".$pg_section."','".$parent_item."','".$pg_status."',now())");

echo "INSERT INTO ".PAGETBL."(pg_title,pg_title_ar,pg_detail,pg_detail_ar,pg_keyword,pg_desp,pg_section,parent_item,pg_status,update_date) VALUES('".$pg_title."','".$pg_title_ar."','".$pg_detail."','".$pg_detail_ar."','".$pg_keyword."','".$pg_desp."','".$pg_section."','".$parent_item."','".$pg_status."',now())";
if(mysql_affected_rows() > 0){
//redirect
header("location:account.php?page=view_page");
}else{
$msg = "Page Saving Failed";
}
}
}else{
// error message
$msg = "Enter Page Title";
}
}
?>
<script type="text/javascript">
function valForm()
{
	var str=document.page_fr;
	if(str.pg_title.value=='')
	{
		document.getElementById("mtitle").innerHTML="Enter Page Title";
		str.pg_title.focus();
		return false;
	}else{
	document.getElementById("mtitle").innerHTML= "";
	}
	
	if(str.pg_title_ar.value=='')
	{
		document.getElementById("mtitle_ar").innerHTML="Enter Page Title in Arabic";
		str.pg_title.focus();
		return false;
	}else{
	document.getElementById("mtitle_ar").innerHTML= "";
	}
	return true;
}
</script>
<div style="width: 100%; margin: 0 auto; margin-top: 15px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Manage Pages/Articles</strong></td>
      <td align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=view_page"><div class="button_admin">View All Page</div></a></td>
    </tr>
  </table>
  <?php if($msg <> ""){
?>
  <div style="border: 1px solid #990; background-color: #FFC; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="4%"><img src="../images/warning.png" width="20" height="20"></td>
<td width="96%"><?php echo $msg; ?></td>
</tr>
</table>
</div>
<?php } ?>
  <form action="" method="post" name="page_fr" onsubmit="return valForm();">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="16%">Page Title(En):</td>
        <td width="84%"><input name="pg_title" type="text" class="textbox" id="pg_title" value="<?php echo $pg_title; ?>" style="width: 200px;"> <span id="mtitle" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
		
		<tr>
        <td width="16%">Page Title(Ar):</td>
        <td width="84%"><input name="pg_title_ar" type="text" class="textbox" id="pg_title_ar" value="<?php echo $pg_title_ar; ?>" style="width: 200px;"> <span id="mtitle_ar" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
		
		
      <tr>
        <td>Meta Keywords:</td>
        <td><input name="pg_keyword" type="text" class="textbox" id="pg_keyword" value="<?php echo $pg_keyword; ?>" style="width: 200px;"></td>
        </tr>
      <tr>
        <td>Meta Description: </td>
        <td><input name="pg_desp" type="text" class="textbox" id="pg_desp" value="<?php echo $pg_desp; ?>" style="width: 200px;"></td>
        </tr>
        <tr>
    <td colspan="2" style="padding-left: 3px;"><strong>Page Content Editor (En)</strong></td>
  </tr>
  <tr>
    <td colspan="2" style="padding-left: 3px;">
	<?php
	include_once("editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('pg_detail',300);
	$oFCKeditor->BasePath = 'editor/';
	$oFCKeditor->Config['EnterMode'] = 'br';
	$oFCKeditor->Value = $pg_detail;
	$oFCKeditor->Create(); 
	?>
	</td>
  </tr>
  
  <tr>
    <td colspan="2" style="padding-left: 3px;"><strong>Page Content Editor (Ar)</strong></td>
  </tr>
  
  <tr>
    <td colspan="2" style="padding-left: 3px;">
	<?php
	include_once("editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('pg_detail_ar',300);
	$oFCKeditor->BasePath = 'editor/';
	$oFCKeditor->Config['EnterMode'] = 'br';
	$oFCKeditor->Value = $pg_detail_ar;
	$oFCKeditor->Create(); 
	?>
	</td>
  </tr>
  
  
      <tr>
        <td>Parent Page:</td>
        <td><select name="parent_item" id="parent_item" style="width: 205px;">
      <option value="0">--- Select ---</option>
      <?php
	  if($_GET["id"] == ''){
		   $sqm = mysql_query("SELECT pg_title,id FROM ".PAGETBL." WHERE parent_item = '0'");}else{
	  $sqm = mysql_query("SELECT pg_title,id FROM ".PAGETBL." WHERE parent_item = '0' AND id <> '".$_GET["id"]."'");}
	 
	  while($res = mysql_fetch_array($sqm)){
	  ?>
      <option value="<?php echo $res['id']; ?>" <?php if($parent_item == $res['id']) echo "selected='selected'"; ?>><?php echo $res['pg_title']; ?></option>
      <?php
      }
      ?>
      </select> <span id="mpos" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td>
        </tr>
      <tr>
        <td valign="top">Select Section:</td>
        <td><select name="pg_section" id="pg_section" style="width: 205px; margin-bottom: 3px;">
          <option value="0" <?php if($pg_section == "0") echo "selected='selected'"; ?>>No Sections</option>
          <option value="1" <?php if($pg_section == "1") echo "selected='selected'"; ?>>FAQ</option>
          <option value="2" <?php if($pg_section == "2") echo "selected='selected'"; ?>>Home Top</option>
        </select>
          <br /><span style="color: #999;">(If &quot;No Section&quot;, then the page is under default section and can be assigned to menus)</span></td>
      </tr>
      <tr>
        <td valign="top">Status:</td>
        <td>
        <select name="pg_status" id="pg_status" style="width: 205px;">
      <option value="">--- Select ---</option>
      <option value="1" <?php if($pg_status == "1") echo "selected='selected'"; ?>>Published</option>
      <option value="0" <?php if($pg_status == "0") echo "selected='selected'"; ?>>Un Published</option>
    </select></td>
        </tr>
      <tr>
        <td colspan="2"><?php
	if($_GET['id'] == ""){
	?>
	<input name="save" type="submit" id="save" value=" Save " class="actionBtn">
	<?php
	}else{
	?>
	<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $pg_id; ?>">
	<input name="update" type="submit" id="update" value=" Update " class="actionBtn">
	<?php } ?>
	</td>
      </tr>
    </table>
  </td>
  </tr>
</table>
</form>
</div>