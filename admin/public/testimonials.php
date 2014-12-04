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
  var retVal = confirm("Do you want to Delete these Testimonial ?");
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

function masterValidate()
{
	var str = document.str_form;
	var error = "";
	var flag = true;

	if(str.name.value =="")
	{
		str.name.style.borderColor = "RED";
		error += "- Enter Name \n";
		flag = false;
	
	}
	else
	{
		str.name.style.borderColor = "";

	}

	if(str.name_ar.value =="")
	{
		str.name_ar.style.borderColor = "RED";
		error += "- Enter Name (Ar) \n";
		flag = false;
	
	}
	else
	{
		str.name_ar.style.borderColor = "";

	}
	
	if(str.designation.value =="")
	{
		str.designation.style.borderColor = "RED";
		error += "- Enter Designation \n";
		flag = false;
	
	}
	else
	{
		str.designation.style.borderColor = "";

	}

	if(str.designation_ar.value == "")
	{
		str.designation_ar.style.borderColor = "RED";
		error += "- Enter Designation (Ar) \n";
		flag = false;
	
	}
	else
	{
		str.designation_ar.style.borderColor = "";

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
					$db->recordDelete(array("id" => $id),TESTIMONIALS);
					$count++;
				
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=testimonials&view=list';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=testimonials&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=testimonials&view=list';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),TESTIMONIALS) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=testimonials&view=list';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=testimonials&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=testimonials&view=list';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),TESTIMONIALS) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=testimonials&view=list';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='account.php?page=testimonials&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='account.php?page=testimonials&view=list';</script>";
		}
		break;
	}
}


if($_REQUEST['task']=='delete')
{

 $sqql="delete from ".TESTIMONIALS." where id='".$_REQUEST['id']."'";

 $qrr=mysql_query($sqql);
 header("location:account.php?page=testimonials&view=list");
}



if($_GET['task']=='block'){

	$id=$_GET['id'];

	$sqlu=mysql_query("update ".TESTIMONIALS." set status='0' where id='$id'");
if(mysql_affected_rows() > 0)
echo "<script>alert('Record Unpublished Sucessfully');location.href='account.php?page=testimonials&view=list&part=".$_GET['part']."';</script>";
else
echo "<script>alert('Record Unpublished Failed');location.href='account.php?page=testimonials&view=list&part=".$_GET['part']."';</script>";

}

if($_GET['task']=='active'){

	 $id=$_GET['id'];

	$sqlp="update ".TESTIMONIALS." set status='1' where id='$id'";

	$resultp=mysql_query($sqlp);
if(mysql_affected_rows() > 0)
echo "<script>alert('Record Published Sucessfully');location.href='account.php?page=testimonials&view=list&part=".$_GET['part']."';</script>";
else
echo "<script>alert('Record Published Failed');location.href='account.php?page=testimonials&view=list&part=".$_GET['part']."';</script>";

}
if($_GET['id'] == "")

{
	// button variables

	$btn_name = "save";

	$btn_value = " Add Testimonial ";
	$cancel = "<a href='account.php?page=testimonials&view=list'><u>Cancel</u></a>";
}

else

{

	$btn_name = "update";

	$btn_value = " Update & Save ";

	$cancel = "<a href='account.php?page=testimonials&view=list'>Cancel</a>";

}



// save record

if(isset($_POST['save']))

{
    // params

	$name        = addslashes(trim($_POST['name']));
	$name_ar     = addslashes(trim($_POST['name_ar']));
    $designation    = addslashes(trim($_POST['designation']));
	$designation_ar = addslashes(trim($_POST['designation_ar']));
    $testimonial         = addslashes(trim($_POST['testimonial']));
	$testimonial_ar = addslashes(trim($_POST['testimonial_ar']));
	$status       = $_POST['status'];
	
	if($_FILES['image']['name'])
	{
		$image = basename($_FILES['image']['name']);
		$dir = "../upload/testimonials/";
		$tmp_name = $_FILES['image']['tmp_name'];
		$_POST['image'] = ($image != "")?time().$image:'';
	}
	
	if($_POST['image']!= "")
	{
		$image=$_POST['image'];
		$sq_save = "INSERT INTO ".TESTIMONIALS." (`name`, `name_ar`, `designation`, `designation_ar`, `image`, `testimonial`, `testimonial_ar`, `status`, `created_date`) VALUES ('".$name."','".$name_ar."','".$designation."','".$designation_ar."','".$image."','".$testimonial."','".$testimonial_ar."','".$status."',now())";
		echo move_uploaded_file($tmp_name,$dir.$_POST['image']);
	}
	else
	{
		$sq_save = "INSERT INTO ".TESTIMONIALS." (`name`, `name_ar`, `designation`, `designation_ar`, `testimonial`, `testimonial_ar`, `status`, `created_date`) VALUES ('".$name."','".$name_ar."','".$designation."','".$designation_ar."','".$testimonial."','".$testimonial_ar."','".$status."',now())";
	}

//echo $sq_save; exit;
	$res_save = mysql_query($sq_save);
    header("location:account.php?page=testimonials&view=list");
}



// edit record

if($_GET['id'] != "")

{

	$sq_var = "SELECT * FROM ".TESTIMONIALS." WHERE id = '".$_GET['id']."'";

	$res_var = mysql_query($sq_var);

	$rs_var = mysql_fetch_object($res_var);

	

	// get vars

	$name = stripslashes($rs_var->name);
    $name_ar = stripslashes($rs_var->name_ar);
	
	$designation    = stripslashes($rs_var->designation);
	$designation_ar = stripslashes($rs_var->designation_ar);

	$testimonial    = stripslashes($rs_var->testimonial);
	$testimonial_ar = stripslashes($rs_var->testimonial_ar);

	$status = $rs_var->status;

}



// update

if(isset($_POST['update']))

{

	// params

	$name       = addslashes(trim($_POST['name']));
	$name_ar    = addslashes(trim($_POST['name_ar']));
    $designation    = addslashes(trim($_POST['designation']));
	$designation_ar = addslashes(trim($_POST['designation_ar']));
    $testimonial    = addslashes(trim($_POST['testimonial']));
	$testimonial_ar = addslashes(trim($_POST['testimonial_ar']));

	$status = $_POST['status'];

	$page_id = $_POST['page_id'];

	$msg = "";

	if($_FILES['image']['name'])
	{
		$image = basename($_FILES['image']['name']);
		$dir = "../upload/testimonials/";
		$tmp_name = $_FILES['image']['tmp_name'];
		$_POST['image'] = ($image != "")?time().$image:'';
	}
	
	// save
	if($_POST['image']!= "")
	{
		$image=$_POST['image'];
		$sq_update ="UPDATE ".TESTIMONIALS." SET `name` = '".$name."', `name_ar` = '".$name_ar."', `designation` = '".$designation."', `designation_ar` = '".designation_ar."', `image` = '".$image."',`testimonial` = '".$testimonial."', `testimonial_ar` = '".$testimonial_ar."', `status` = '".$status."' WHERE id = ".$page_id;	
		echo move_uploaded_file($tmp_name,$dir.$_POST['image']);
	}
	else
	{
		$sq_update ="UPDATE ".TESTIMONIALS." SET `name` = '".$name."', `name_ar` = '".$name_ar."', `designation` = '".$designation."', `designation_ar` = '".designation_ar."', `testimonial` = '".$testimonial."', `testimonial_ar` = '".$testimonial_ar."', `status` = '".$status."' WHERE id = ".$page_id;	
	}

	$res_update = mysql_query($sq_update);

	
		header("location:account.php?page=testimonials&view=list");

	
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
		$upd="update ".TESTIMONIALS." set ordering='".$ordx[$i]."' where id='".$srvcid[$i]."' ";
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
      <td width="67%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Add/Edit Testimonial </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=testimonials&view=list"><span class="button_admin_big">View All Testimonial</span></a></td>
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
        <td colspan="2"><strong>Name (En): </strong> 
          <input name="name" type="text" id="name" value="<?php echo $name; ?>" style="width: 564px; margin-left:38px;" class="textbox"/></td>
      </tr>
		
		<tr>
        <td colspan="2"><strong>Name (Ar):</strong>  
          <input name="name_ar" type="text" id="name_ar" value="<?php echo $name_ar; ?>" style="width: 564px; margin-left:38px;" class="textbox"/></td>
        </tr>
      <tr>
        <td colspan="2"><strong>Designation (En): </strong> 
          <input name="designation" type="text" id="designation" value="<?php echo $designation; ?>" style="width: 564px;" class="textbox"/></td>
      </tr>
		
		<tr>
        <td colspan="2"><strong>Designation (Ar):</strong>  
          <input name="designation_ar" type="text" id="designation_ar" value="<?php echo $designation_ar; ?>" style="width: 564px;" class="textbox"/></td>
        </tr>
		<tr>
        <td colspan="2"><strong>Image:</strong>  
          <input name="image" type="file" id="image" value="<?php echo $image; ?>" style="margin-left:64px; width:200px;" class="textbox"/>		</td>
        </tr>
		
				
		<tr>
        <td colspan="2"><strong>Testimonial (En) : </strong></td>
        </tr>
		
		
      <tr>
        <td colspan="2"><?php
	include_once("editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('testimonial',220,'86%');
	$oFCKeditor->BasePath = 'editor/';
    $oFCKeditor->ToolbarSet = "Normal";
	$oFCKeditor->Config['EnterMode'] = 'br';
	$oFCKeditor->Value = $testimonial;
	$oFCKeditor->Create(); 
	?>    </td>
        </tr>
		
		<tr>
        <td colspan="2"><strong>Testimonial (Ar) :</strong></td>
        </tr>
		
		<tr>
        <td colspan="2"><?php
	include_once("editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('testimonial_ar',220,'86%');
	$oFCKeditor->BasePath = 'editor/';
    $oFCKeditor->ToolbarSet = "Normal";
	$oFCKeditor->Config['EnterMode'] = 'br';
	$oFCKeditor->Value = $testimonial_ar;
	$oFCKeditor->Create(); 
	?>    </td>
        </tr>
		
		
		
		
      <tr>
        <td width="13%">Display Status:</td>
        <td width="87%">
        <select name="status" id="status" style="width: 250px;">
     
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
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Testimonials</strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=testimonials"><span class="button_admin_big">Add New Testimonial</span></a></td>
    </tr>
    <tr>
      <td width="29%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='publishall';document.partcat_form.submit();" disabled="disabled"/>
        <input type="button" name="unpublishall" id="unpublishall" value="Inactive" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='unpublishall';document.partcat_form.submit();" disabled="disabled"/></td>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
	  <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <td width="49%" align="right">Name:</td>
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
            <td width="6%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
            <td width="7%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="30%" align="left" bgcolor="#333333"><strong>name</strong></td>
            <td width="10%" align="center" bgcolor="#333333"><strong>Image</strong></td>
           <?php /*?> <td width="14%" align="center" bgcolor="#333333"><strong>Order</strong><input type="submit" name="save_order" style="background:url(<?php echo BASE_URL; ?>images/s_b.gif);border:none;cursor:pointer;margin-left:3px;background-repeat:no-repeat;" value="" /></td><?php */?>
            <td width="14%" align="center" bgcolor="#333333"><strong>Status</strong></td>
            <td width="14%" align="center" bgcolor="#333333"><strong>Create Date</strong></td>
            <td width="14%" align="center" bgcolor="#333333"><strong>Action</strong></td>
          </tr>
          		
				<?php 
if(isset($_POST["search"])){
		  $j = 0;
		  $i = 0;
		 $sq = "SELECT * FROM ".TESTIMONIALS." WHERE name LIKE '%".$_POST["stitle"]."%' ORDER BY id ASC LIMIT ".$startpoint.",".$perpage;
	  }	else
	  {			
				
		  $sq = "select * from ".TESTIMONIALS." ORDER BY id LIMIT ".$startpoint.",".$perpage;}
					
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
            <td ><?php echo $row["name"]; ?></td>
         	<td align="center">
				<?php 
				$image = '../upload/testimonials/'.$row["image"];
				if($row["image"]){?>
				<img src="<?php echo $image;?>" style="height:60px; width:60px;" />
				<?php }
				else
					echo "N/A";?>
			</td>
			<?php /*?><td align="center"><input name="order_set[]" type="text" class="input" id="order_set" style="width: 40px; text-align: center;" value="<?php echo $row["ordering"]; ?>"><input  type="hidden" name="id[]"  value="<?php echo $row["id"]; ?>" style="width:20px;" /></td><?php */?>
			
            <td align="center" ><?php 
			
			if($row["status"]=='0') { ?>
              <a href="account.php?page=testimonials&task=active&view=list&id=<?php echo $row["id"]; ?>"><font color="#FF0000">InActive</font>
              <?php } else {?>
              </a><a href="account.php?page=testimonials&task=block&view=list&id=<?php echo $row["id"]; ?>"><font color="#006633">Active</font>
                  
                  </a>
            <?php } ?></td>
			            <td align="center" ><?php echo date("d/m/Y",strtotime($row["created_date"])); ?></td>

            <td align="center" ><a href="public/testimonial_view.php?id=<?php echo $row['id']; ?>" id="fancy"><img src="images/view.png"  width="16" height="16" border="0" title="View" style="cursor: pointer;" /></a>&nbsp;<a href="account.php?page=testimonials&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a>&nbsp;<a href="account.php?page=testimonials&task=delete&view=list&id=<?php echo $row["id"];  ?>" onclick="return confirm('ARE YOU SURE TO DELETE!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a></td>
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
				  echo Paging(TESTIMONIALS,$perpage,"account.php?page=testimonials&view=list&","name LIKE '%".$_POST['stitle']."%' ORDER BY id DESC");
					
					}else{
					echo Paging(TESTIMONIALS,$perpage,"account.php?page=testimonials&view=list&");
					} 
			
			  ?>
			
			
				 
					
			
			 </td>
          </tr>
        </table></td>
      </tr>
    
  </table></form>
</div>
<?php } ?>