
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
		//document.getElementById("deleteall").disabled = "";
		document.getElementById("publishall").disabled = "";
		document.getElementById("unpublishall").disabled = "";
		//document.getElementById("deleteall1").disabled = "";
		document.getElementById("publishall1").disabled = "";
		document.getElementById("unpublishall1").disabled = "";
		
		for(l=1;l<=num_tot;l++)
		{
			obj = document.getElementById('chkNo'+l);
			document.getElementById("chkNo" + l).checked = true;
		}
	}else{
		// disable group add/edit/delete buttons
		//document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("publishall").disabled = "disabled";
		document.getElementById("unpublishall").disabled = "disabled";
		//document.getElementById("deleteall1").disabled = "disabled";
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
		//document.getElementById("deleteall").disabled = "";
		document.getElementById("publishall").disabled = "";
		document.getElementById("unpublishall").disabled = "";
		//document.getElementById("deleteall1").disabled = "";
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
		//document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("publishall").disabled = "disabled";
		document.getElementById("unpublishall").disabled = "disabled";
		//document.getElementById("deleteall1").disabled = "disabled";
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
	//var callouttext=str.content[].value;
	
	if(str.position.value =="")
	{
		str.position.style.borderColor = "RED";
		error += "- Enter Callout Title \n";
		flag = false;
	
	}
	else
	{
		str.position.style.borderColor = "";

	}
	
	/*if(callouttext =="")
	{
		str.content.style.borderColor = "RED";
		error += "- Enter Callout Text \n";
		flag = false;
	
	}
	else
	{
		str.content.style.borderColor = "";

	}*/
		
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

      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

</script>

<!--<script>
function generateRow() {
var d=document.getElementById("showtxtbox");
d.innerHTML+="<input name='content[]' type='text' id='content' style='width: 250px;' class='textbox' /><br /><br />";
}
</script>-->

<script type="text/javascript">
var i=0;
function createtext() {
    i++;
    $('<div id="field'+i+'"><input type="text" name="content[]" id="content" style="width: 250px;" class="textbox" /> <a href="#" onclick="removeField(\'field'+i+'\');">Remove</a></div><br />').appendTo('#showtxtbox');
}
function removeField (id) {
    $('#'+id).remove();
	//$('#'+id).css("display", "inline");
	//$('#'+id).attr("style", "display:inline");
}
</script>

<!--<script type="text/javascript">
function removeData(val,delid)
{   
	if(delid!='' && val!='')
	{
	  $.post('util/utilAjax.php?val=' + val +'&delid=' + delid, function(success){
		  
	  });
	}
}
</script>-->

<?php
//delete--all
// delete all users
if(isset($_POST['todo'])){
	// case
	switch($_POST['todo']){
		/*case 'deleteall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
					$db->recordDelete(array("id" =>$id),HOMEMIDIMAGES);
					$count++;
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=homepage_midimg&view=list';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=homepage_midimg&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=homepage_midimg&view=list';</script>";
		}
		break;*/
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'1'),HOMEMIDIMAGES) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Published successfully');location.href='account.php?page=homepage_midimg&view=list';</script>";
			}else{
				echo "<script>alert('No Records Published');location.href='account.php?page=homepage_midimg&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Published');location.href='account.php?page=homepage_midimg&view=list';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'0'),HOMEMIDIMAGES) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=homepage_midimg&view=list';</script>";
			}else{
				echo "<script>alert('No Records Unpublished');location.href='account.php?page=homepage_midimg&view=list';</script>";
			}
		}else{
			echo "<script>alert('No Records Unpublished');location.href='account.php?page=homepage_midimg&view=list';</script>";
		}
		break;
	}
}


/*if($_REQUEST['task']=='delete')
{

 $sqql="delete from ".HOMEMIDIMAGES." where id='".$_REQUEST['id']."'";

 $qrr=mysql_query($sqql);
}*/

if($_REQUEST['task']=='delete_icon')
{

 $sql_del="update ".HOMEMIDIMAGES." set image='' where id='".$_REQUEST['id']."'";

 $sql_del1=mysql_query($sql_del);
}



if($_GET['task']=='block'){

	$id=$_GET['id'];

	$sqlu=mysql_query("update ".HOMEMIDIMAGES." set status='0' where id='$id'");
	if(mysql_affected_rows() > 0)
echo "<script>alert('Record Unpublished Sucessfully');location.href='account.php?page=homepage_midimg&view=list&part=".$_GET['part']."';</script>";
else
echo "<script>alert('Record Unpublished Failed');location.href='account.php?page=homepage_midimg&view=list&part=".$_GET['part']."';</script>";


}

if($_GET['task']=='active'){

	 $id=$_GET['id'];

	$sqlp="update ".HOMEMIDIMAGES." set status='1' where id='$id'";

	$resultp=mysql_query($sqlp);
		if(mysql_affected_rows() > 0)
echo "<script>alert('Record Published Sucessfully');location.href='account.php?page=homepage_midimg&view=list&part=".$_GET['part']."';</script>";
else
echo "<script>alert('Record Published Failed');location.href='account.php?page=homepage_midimg&view=list&part=".$_GET['part']."';</script>";

}

if($_GET['id'] == "")
{
	// button variables
	$btn_name = "save";
	$btn_value = " Save ";
	$cancel = "<a href='account.php?page=homepage_midimg&view=list'><u>Cancel</u></a>";
}
else
{
	$btn_name = "update";
	$btn_value = " Update & Save ";
	$cancel = "<a href='account.php?page=homepage_midimg&view=list'><u>Cancel</u></a>";
}

// save record

if(isset($_POST['save']))

{
$image_path="../upload/homepage_image/";
	// params
	
	$position = addslashes(trim($_POST['position']));

	
	
    $image = $_FILES["image"]["name"];
	$extension = explode(".",$image);
    $ext = $extension[count($extension)-1];
	
	   // substr($image,-4);
	$status = $_POST['status'];
	
	$msg = "";
	// save
    $sq_save = "INSERT INTO ".HOMEMIDIMAGES." (`status`) VALUES('".$status."')";
	$res_save = mysql_query($sq_save) or die(mysql_error());
    $id=mysql_insert_id();
	
	
	
 if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif") || ($ext == "PNG")) 
    {
		echo $newfile= $image_path .time().$id .".". $ext;
		echo $newfile1= time().$id .".". $ext;
		echo $update=mysql_query("update ".HOMEMIDIMAGES."  set `image`='".$newfile1."' where id='".$id."' ") or die(mysql_error());   
		move_uploaded_file($_FILES["image"]["tmp_name"], $newfile);
    }
		
    header("location:account.php?page=homepage_midimg&view=list");
	
}



// edit record

if($_GET['id'] != "")

{

	$sq_var = "SELECT * FROM ".HOMEMIDIMAGES." WHERE id = '".$_GET['id']."'";

	$res_var = mysql_query($sq_var);

	$rs_var = mysql_fetch_object($res_var);


	// get vars
	
	$position = stripslashes($rs_var->position);
	$image=$rs_var->image;
	$status=$rs_var->status;
	

}



// update

if(isset($_POST['update']))

{
$image_path="../upload/homepage_image/";
	// params
	$position = addslashes(trim($_POST['position']));
	//$callout_text = addslashes(trim($_POST['content']));
	
	$callout_text = implode(", ",$_POST['content']);
    $image = $_FILES["image"]["name"];
	$extension = explode(".",$image);
    $ext = $extension[count($extension)-1];
	$status = $_POST['status'];
	$page_id = $_POST['page_id'];
	$var_id=$_GET['id'];
	$msg = "";
    
	// save
	
	 if(!$image) 
{
$sq_update = "UPDATE ".HOMEMIDIMAGES." SET `status` = '".$status."' WHERE `id` = '".$page_id."'";
$res_update = mysql_query($sq_update) or die(mysql_error());
$var_test=mysql_affected_rows();
	
    /*if($res_update)
	{
		header("location:account.php?page=homepage_midimg&view=list");

	}*/
}
else
{
 if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif") || ($ext == "PNG")) 
    {
		echo $newfile= $image_path .time().$id .".". $ext;
		echo $newfile1= time().$id .".". $ext;

$sq_update = "UPDATE ".HOMEMIDIMAGES." SET `image` = '".$newfile1."',`status` = '".$status."' WHERE `id` = '".$page_id."'";
    move_uploaded_file($_FILES["image"]["tmp_name"], $newfile);
	$res_update = mysql_query($sq_update) or die(mysql_error());
	$var_test=mysql_affected_rows();
    }
}

header("location:account.php?page=homepage_midimg&view=list");	
	
}

$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 
if($_GET["view"]!="list"){
?>
<!-- app -->  

<div style="width: 800px; margin: 0 auto; margin-top: 10px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td width="67%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Manage Homepage Mid Icons </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=homepage_midimg&view=list"><img src="images/view_all.png" width="87" height="15" border="0"></a></td>
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
  <tr>
    <td style="padding-left: 0px; padding-right: 0px;">
	<form action="" method="post" name="partcat_form" enctype="multipart/form-data" id="partcat_form" onSubmit="return masterValidate();">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
    
		
    	<tr>
      	 <td width="18%">Callout Title:</td>
        <td width="82%"><span style="padding-left: 0px;">
        <input name="position" type="text" id="position" value="<?php echo $position; ?>" style="width: 250px;" class="textbox" />
        </span></td>
		</tr>
       
	   <tr>
        <td width="18%">Callout Icon:</td>
        <td width="82%"><span style="padding-left: 0px;">
          <input name="image" type="file" id="image" />
        </span></td>
        </tr>
		
      
      <tr>
        <td>Display Status:</td>
        <td><span style="padding-left: 0px;">
        <select name="status" id="status" style="width: 257px;">
      <option value="1" <?php if($status == "1") echo "selected='selected'"; ?>>Active</option>
      <option value="0" <?php if($status == "0") echo "selected='selected'"; ?>>Inactive</option>
    </select></span></td>
        </tr>
		
      <tr>
        <td colspan="2" style="padding-top: 8px;"><input name="<?php echo $btn_name; ?>" type="submit" id="<?php echo $btn_name; ?>" value="<?php echo $btn_value; ?>" class="actionBtn" />
          <span style="padding-left: 0px;">
            <input type="hidden" name="page_id" value="<?php echo $_GET['id']; ?>" /><?php echo $cancel; ?></span></td>
      </tr>
    </table>
	</form>
  </td>
  </tr>
</table>
</div>
<?php }else { ?>
<form action="" method="post" name="partcat_form" enctype="multipart/form-data" id="partcat_form">
<div style="width: 900px; margin: 0 auto; margin-top: 10px;">

  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Homepage Mid Icons </strong></td>
      <td width="10%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><!--<a href="account.php?page=homepage_midimg"><img src="images/add_new.png" width="77" height="15" border="0"></a>--></td>
    </tr>
    <tr>
      <td width="64%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036; padding-top: 5px;"><!--<input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onClick="document.partcat_form.todo.value='deleteall';document.partcat_form.submit();" disabled="disabled"/>-->
         <input type="button" name="publishall" id="publishall" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onClick="document.partcat_form.todo.value='publishall';document.partcat_form.submit();" disabled="disabled"/>
        <input type="button" name="unpublishall" id="unpublishall" value="Inactive" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onClick="document.partcat_form.todo.value='unpublishall';document.partcat_form.submit();" disabled="disabled"/></td>
     
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
            <td width="3%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onClick="check_all();" /></td>
            <td width="3%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="16%" align="left" bgcolor="#333333"><strong>Callout Title</strong></td>
            <td width="7%" align="left" bgcolor="#333333"><strong>Callout Icon</strong></td>
            
            <td width="8%" align="center" bgcolor="#333333"><strong>Status</strong></td>
            <td width="6%" align="center" bgcolor="#333333"><strong>Action</strong></td>
			
          </tr>
          		
				<?php 
				$i=0;
				$j=0;
				
	  if(isset($_POST["search"])){
		  $j = 0;
	 $rs= mysql_query("select * from ".HOMEMIDIMAGES." WHERE position like '%".$_POST["searchtxt"]."%' ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	  }
	  else{
		  $j = 0;
		  $rs = mysql_query("select * from ".HOMEMIDIMAGES." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	  }
					//$sq = "select * from ".HOMEMIDIMAGES." ORDER BY id LIMIT ".$startpoint.",".$perpage."";
					
		  //$rs=mysql_query($sq) or die(mysql_error());
		  	 $count=mysql_num_rows($rs);

		  if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		  while($row=mysql_fetch_array($rs)){
		  //echo "123";
		  $j++;
		  $bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			 
		  ?>
          <tr <?php echo $bgcolor; ?>>
            <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $j;?>" value="<?php echo $row['id']; ?>" onClick="check_single('chkNo<?php echo $j;?>');" /></td>
            <td align="center" ><strong><?php echo $j; ?></strong></td>
			<td ><?php echo stripslashes($row['position']); ?></td>
			<td ><?php if($row['image']!="") { ?><a id="imgview" href="<?php echo "../upload/homepage_image/".$row['image']?>"><img src="images/view.png" height="20" width="20" title="View" /></a><?php } else echo ""; ?></td>
          
            
            <td align="center" ><?php 
			
			if($row["status"]=='0') { ?>
              <a href="account.php?page=homepage_midimg&task=active&view=list&id=<?php echo $row["id"]; ?>"><font color="#FF0000">InActive</font>
              <?php } else {?>
              </a><a href="account.php?page=homepage_midimg&task=block&view=list&id=<?php echo $row["id"]; ?>"><font color="#006633">Active</font>
                  
                  </a>
            <?php } ?></td>
            <td align="center" ><a href="account.php?page=homepage_midimg&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a><!--&nbsp;<a href="account.php?page=homepage_midimg&task=delete&view=list&id=<?php //echo $row["id"];  ?>" onClick="return confirm('ARE YOU SURE TO DELETE!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a>--></td>
			
          </tr>
          <?php $i=$i+1;} ?>
          <tr>
            <td colspan="9" align="left" style="padding-bottom: 5px; padding-top: 5px; padding-left: 0px;"><!--<input type="button" name="deleteall" id="deleteall1" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onClick="document.partcat_form.todo.value='deleteall';document.partcat_form.submit();" disabled="disabled"/>-->
              <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
              <input type="button" name="publishall2" id="publishall1" value="Active" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onClick="document.partcat_form.todo.value='publishall';document.partcat_form.submit();" disabled="disabled"/>
              </span><span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
      <input type="button" name="unpublishall2" id="unpublishall1" value="Inactive" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" 
	  onClick="document.partcat_form.todo.value='unpublishall';document.partcat_form.submit();" disabled="disabled"/>
      </span>
      <input type="hidden" name="todo"  id="todo" value="" /></td>
	  </tr>
         
        </table></td>
      </tr>
    
  </table>
</div>
<?php } ?></form>