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
		document.getElementById("publishall").disabled = "";
		document.getElementById("unpublishall").disabled = "";
		document.getElementById("publishall1").disabled = "";
		document.getElementById("unpublishall1").disabled = "";
		
		for(l=1;l<=num_tot;l++)
		{
			obj = document.getElementById('chkNo'+l);
			document.getElementById("chkNo" + l).checked = true;
		}
	}else{
		// disable group add/edit/delete buttons
		document.getElementById("publishall").disabled = "disabled";
		document.getElementById("unpublishall").disabled = "disabled";
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
		document.getElementById("publishall").disabled = "";
		document.getElementById("unpublishall").disabled = "";
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
		document.getElementById("publishall").disabled = "disabled";
		document.getElementById("unpublishall").disabled = "disabled";
		document.getElementById("publishall1").disabled = "disabled";
		document.getElementById("unpublishall1").disabled = "disabled";
		}
	}
}

function masterValidate()
{
	var str = document.partcat_form;
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
		
	if(flag == false)
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
		
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),HOMECONTENTS) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=content&view=list';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=content&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=content&view=list';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),HOMECONTENTS) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=content&view=list';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='account.php?page=content&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='account.php?page=content&view=list';</script>";
		}
		break;
	}
}


if($_GET['task']=='block'){

	$id=$_GET['id'];

	$sqlu=mysql_query("update ".HOMECONTENTS." set status='0' where id='$id'");
if(mysql_affected_rows() > 0)
echo "<script>alert('Record Unpublished Sucessfully');location.href='account.php?page=content&view=list&part=".$_GET['part']."';</script>";
else
echo "<script>alert('Record Unpublished Failed');location.href='account.php?page=content&view=list&part=".$_GET['part']."';</script>";

}

if($_GET['task']=='active'){

	 $id=$_GET['id'];

	$sqlp="update ".HOMECONTENTS." set status='1' where id='$id'";

	$resultp=mysql_query($sqlp);
if(mysql_affected_rows() > 0)
echo "<script>alert('Record Published Sucessfully');location.href='account.php?page=content&view=list&part=".$_GET['part']."';</script>";
else
echo "<script>alert('Record Published Failed');location.href='account.php?page=content&view=list&part=".$_GET['part']."';</script>";

}
if($_GET['id'] == "")

{
	// button variables

	$btn_name = "save";

	$btn_value = " Add New Content ";
	$cancel = "<a href='account.php?page=content&view=list'><u>Cancel</u></a>";
}

else

{

	$btn_name = "update";

	$btn_value = " Update & Save ";

	$cancel = "<a href='account.php?page=content&view=list'>Cancel</a>";

}



// save record

if(isset($_POST['save']))

{
    // params

	$title        = addslashes(trim($_POST['title']));
	$title_ar     = addslashes(trim($_POST['title_ar']));
    $desc         = addslashes(trim($_POST['description']));
	$desc_ar = addslashes(trim($_POST['description_ar']));
	$status       = $_POST['a_status'];

	$msg = "";

	// save

	$sq_save = "INSERT INTO ".HOMECONTENTS." (`title`, `title_ar`, `desc`, `desc_ar`, `status`) VALUES ('".$title."','".$title_ar."','".$desc."','".$desc_ar."','".$status."')";

//echo $sq_save; exit;
	$res_save = mysql_query($sq_save);
    header("location:account.php?page=content&view=list");
}



// edit record

if($_GET['id'] != "")

{

	$sq_var = "SELECT * FROM ".HOMECONTENTS." WHERE id = '".$_GET['id']."'";

	$res_var = mysql_query($sq_var);

	$rs_var = mysql_fetch_object($res_var);

	

	// get vars

	$title = $rs_var->title;
    $title_ar = $rs_var->title_ar;

	$description    = stripslashes($rs_var->desc);
	$description_ar = stripslashes($rs_var->desc_ar);

	$status = $rs_var->status;
	//$catfaq=$rs_var->catid;

}



// update

if(isset($_POST['update']))

{

	// params

	$title       = addslashes(trim($_POST['title']));
	$title_ar    = addslashes(trim($_POST['title_ar']));
    $smalltext    = addslashes(trim($_POST['smalltext']));
	$smalltext_ar = addslashes(trim($_POST['smalltext_ar']));
    $desc    = addslashes(trim($_POST['description']));
	$desc_ar = addslashes(trim($_POST['description_ar']));

	$status = $_POST['a_status'];

	$page_id = $_POST['page_id'];

	$msg = "";

	// save

	$sq_update ="UPDATE ".HOMECONTENTS." SET `title` = '".$title."', `title_ar` = '".$title_ar."', `desc` = '".$desc."', `desc_ar` = '".$desc_ar."', `status` = '".$status."' WHERE id = ".$page_id;	

	$res_update = mysql_query($sq_update);

	
		header("location:account.php?page=content&view=list");

	
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
      <td width="67%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Add/Edit Content</strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=content&view=list"><div class="button_admin">View All Content</div></a></td>
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
<form action="" method="post" name="partcat_form" id="partcat_form" onSubmit="return masterValidate()">  <tr>
    <td style="padding-left: 0px; padding-right: 0px;"><table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr align="center">
        <td colspan="2"><?php if($_GET['sus']==yes){?>
          <span style="color:#06F">New Category Added</span>
          <?php }?></td>
        </tr>
    
      <tr>
        <td colspan="2"><strong>Title (En): </strong> 
          <input name="title" type="text" id="title" value="<?php echo stripslashes($title); ?>" style="width: 610px;" class="textbox"/></td>
      </tr>
		
		<tr>
        <td colspan="2"><strong>Title (Ar):</strong>  
          <input name="title_ar" type="text" id="title_ar" value="<?php echo stripslashes($title_ar); ?>" style="width: 610px;" class="textbox"/></td>
        
        </tr>
		<tr>
        <td colspan="2"><strong>Description (En) : </strong></td>
        </tr>
		
		
      <tr>
        <td colspan="2"><?php
	include_once("editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('description',220,'86%');
	$oFCKeditor->BasePath = 'editor/';
    $oFCKeditor->ToolbarSet = "Normal";
	$oFCKeditor->Config['EnterMode'] = 'br';
	$oFCKeditor->Value = $description;
	$oFCKeditor->Create(); 
	?>
    </td>
        </tr>
		
		<tr>
        <td colspan="2"><strong>Description (Ar) :</strong></td>
        </tr>
		
		<tr>
        <td colspan="2"><?php
	include_once("editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('description_ar',220,'86%');
	$oFCKeditor->BasePath = 'editor/';
    $oFCKeditor->ToolbarSet = "Normal";
	$oFCKeditor->Config['EnterMode'] = 'br';
	$oFCKeditor->Value = $description_ar;
	$oFCKeditor->Create(); 
	?>
    </td>
        </tr>
		
		
		
		
      <tr>
        <td width="13%">Display Status:</td>
        <td width="87%">
        <select name="a_status" id="a_status" style="width: 250px;">
     
      <option value="1" <?php if($status == "1") echo "selected='selected'"; ?>>Published</option>
      <option value="0" <?php if($status == "0") echo "selected='selected'"; ?>>UnPublished</option>
    </select></td>
        </tr>
      <tr>
        <td colspan="2"><input name="<?php echo $btn_name; ?>" type="submit" id="<?php echo $btn_name; ?>" value="<?php echo $btn_value; ?>" class="actionBtn" />
          <span style="padding-left: 4px;">
            <input type="hidden" name="page_id" value="<?php echo $_GET['id']; ?>" />
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
      <td colspan="3" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Contents</strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=content"><div class="button_admin">Add New Content</div></a></td>
    </tr>
    <tr>
      <td width="29%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><input type="button" name="publishall" id="publishall" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='publishall';document.partcat_form.submit();" disabled="disabled"/>
        <input type="button" name="unpublishall" id="unpublishall" value="Inactive" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='unpublishall';document.partcat_form.submit();" disabled="disabled"/></td>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
	  <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <td width="49%" align="right">Title:</td>
        <td width="37%" align="right" style="padding-left: 4px;"><input name="stitle" type="text" class="textbox" id="quest" style="width: 200px;" 
		value="<?php echo $_POST["stitle"]; ?>"></td>
        <td width="14%" align="right"><input type="submit" name="search" id="search" value=" Search " class="actionBtn"></td>
        </tr>
      </table>	  </td>
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
            <td width="6%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
            <td width="7%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="30%" align="left" bgcolor="#333333"><strong>Title</strong></td>
           
            <!--<td width="13%" align="center" bgcolor="#333333"><strong>View</strong></td>-->
            <td width="14%" align="center" bgcolor="#333333"><strong>Status</strong></td>
            <td width="14%" align="center" bgcolor="#333333"><strong>Action</strong></td>
          </tr>
          		
				<?php 
if(isset($_POST["search"])){
		  $j = 0;
		  $i = 0;
	 	$sq = "SELECT * FROM ".HOMECONTENTS." WHERE title LIKE '%".$_POST["stitle"]."%' ORDER BY id ASC LIMIT ".$startpoint.",".$perpage;
	  }	else
	  {			
				
		  $sq = "select * from ".HOMECONTENTS." ORDER BY id LIMIT ".$startpoint.",".$perpage;}
					
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
            <td ><?php echo stripslashes($row["title"]); ?></td>
         
            <td align="center" ><?php 
			
			if($row["status"]=='0') { ?>
              <a href="account.php?page=content&task=active&view=list&id=<?php echo $row["id"]; ?>"><font color="#FF0000">InActive</font>
              <?php } else {?>
              </a><a href="account.php?page=content&task=block&view=list&id=<?php echo $row["id"]; ?>"><font color="#006633">Active</font>
                  
                  </a>
            <?php } ?></td>
			           

            <td align="center" ><a href="public/content_view.php?id=<?php echo $row['id']; ?>" id="fancy"><img src="images/view.png"  width="16" height="16" border="0" title="View" style="cursor: pointer;" /></a>&nbsp;<a href="account.php?page=content&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a></td>
          </tr>
          <?php $i=$i+1;} ?>
          <tr>
            <td colspan="8" align="left">
      <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="publishall" id="publishall1" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='publishall';document.partcat_form.submit();" disabled="disabled"/>
      </span>
      <span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
      <input type="button" name="unpublishall2" id="unpublishall1" value="Inactive" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='unpublishall';document.partcat_form.submit();" disabled="disabled"/>
      </span>
      <input type="hidden" name="todo" id="todo" value=""/></td>
          </tr>
          <tr>
            <td colspan="7" align="center"><?php
			
			 if(isset($_POST['search'])){
				  echo Paging(HOMECONTENTS,$perpage,"account.php?page=content&view=list&","title LIKE '%".$_POST['stitle']."%' ORDER BY id DESC");
					
					}else{
					echo Paging(HOMECONTENTS,$perpage,"account.php?page=content&view=list&");
					} 
			
			  ?>
			
			
				 
					
			
			 </td>
          </tr>
        </table></td>
      </tr>
    
  </table></form>
</div>
<?php } ?>