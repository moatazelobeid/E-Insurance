<?php
// Plugin Name: Banner Management
// Author: Maastrix Solutions (P) LTD

// includes
include_once('../plugins/paging/pagination.php');

// Create New Record
if(isset($_POST['save']))
{
	unset($_POST['id']);
	// check for duplicate record
	/*if($db->isExists('banner_title',$_POST,HOMEBANNER)){
		$errmsg = "-  Banner title already exists";
	}else{*/
	// save record
		// Unset button variable
		unset($_POST['save']);
		
		if($_FILES['banner_img']['name']!='')
		{
		$_POST['banner_img'] = time().$_FILES['banner_img']['name'];
		move_uploaded_file($_FILES['banner_img']['tmp_name'],"../upload/banners/".$_POST['banner_img']);
		}
		
		$_POST['created_date'] = date("Y-m-d");
		$insert = $db->recordInsert($_POST,HOMEBANNER,'');
		
		if($insert)
		{
		?>
		<script type="text/javascript">
		alert("Banner Added Successfully");
		window.location="account.php?page=manage-banner";
		</script>
		<?php
		}
	//}
}

// Update Record
if(isset($_POST['update']))
{
	$id = $_POST['id'];
	// check for duplicate record
	/*if($db->isExists('banner_title',$_POST,HOMEBANNER,$id,'id')){
		$errmsg = "-  Banner title already exists";
	}else{*/
		// Unset button variable
		unset($_POST['update']);
		
		if($_FILES['banner_img']['name']!='')
		{
			$_POST['banner_img']=time().$_FILES['banner_img']['name'];
			move_uploaded_file($_FILES['banner_img']['tmp_name'],"../upload/banners/".$_POST['banner_img']);
		}
		
		$_POST['modified_date'] = date("Y-m-d");
		unset($_POST['id']);
		
		$update = $db->recordUpdate(array('id'=>$id),$_POST,HOMEBANNER);
		if($update)
		{
			?>
			<script type="text/javascript">
			alert("Banner Updated Successfully");
			window.location="account.php?page=manage-banner";
			</script>
			<?php
		}
	//}
}

// Save Record Order
if(isset($_POST['todo']) && $_POST['todo']=='saveOrder')
{
	//print '<pre>';print_r($_REQUEST);exit;
	foreach($_REQUEST['order'] as $key => $value){
		$recodupdate=$db->recordUpdate(array('id'=>$key),array('banner_order'=>$value),HOMEBANNER);
	}
	header("location:account.php?page=manage-banner");
}

// Delete all selected record
if(isset($_POST['todo']) && $_POST['todo']=='deleteall')
{
	if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
		// delete
		$count = 0;
		foreach($_POST['chkNo'] as $id){
			// delete user record
			$delteres = $db->recordDelete(array('id'=>$id),HOMEBANNER);
			$count++;
		}
		if($count > 0){
			echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
		}else{
			echo "<script>alert('No Records Deleted');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
		}
	}else{
	echo "<script>alert('No Records Found To Delete');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
	}
}

// Publish all selected records
if(isset($_POST['todo']) && $_POST['todo']=='publishall')
{
	if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
		// delete
		$count = 0;
		foreach($_POST['chkNo'] as $id){
			// delete user record
			$query= $db->recordUpdate(array('id'=>$id),array('status'=>1),HOMEBANNER); 
			$count++;
		}
		
		if($count > 0)
		echo "<script>alert('Records Published successfully');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
		else
		echo "<script>alert('No Records Published');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
	
	}else{
		echo "<script>alert('No Records Published');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
	}
}

// Unpublish all selected records
if(isset($_POST['todo']) && $_POST['todo']=='unpublishall')
{
	if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
		// delete
		$count = 0;
		foreach($_POST['chkNo'] as $id){
			// delete user record
			$query= $db->recordUpdate(array('id'=>$id),array('status'=>0),HOMEBANNER); 
			$count++;
		}
		
		if($count > 0)
		echo "<script>alert('Records Unpublished successfully');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
		else
		echo "<script>alert('No Records Unpublished');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
		
	}else{
		echo "<script>alert('No Records Unpublished');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
	}
}

// delete individual record
if($_GET['id'] != "" && $_GET['action'] == "delete")
{
	$delete = $db->recordDelete(array('id'=>$_GET['id']),HOMEBANNER);
	if($delete)
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
	else
	echo "<script>alert('Record Deletion Failed');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
}

// inactive individual record
if(isset($_GET["id"]) && $_GET["action"]=="block") 
{
	$id=$_GET["id"];
	$updquery = $db->recordUpdate(array('id'=>$id),array('status'=>1),HOMEBANNER); 

	if($updquery)
	echo "<script>alert('Record Published Sucessfully');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
	else
	echo "<script>alert('Record Published Failed');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
}

// active individual record
if(isset($_GET["id"]) && $_GET["action"]=="activate") {
	$id=$_GET["id"];
	$activateres = $db->recordUpdate(array('id'=>$id),array('status'=>0),HOMEBANNER); 
	if($activateres)
	echo "<script>alert('Record Unpublished Sucessfully');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
	else
	echo "<script>alert('Record Unpublished Failed');location.href='account.php?page=manage-banner&part=".$_GET['part']."';</script>";
}

// Fetch record for update
if($_GET['id'] != "" && !empty($_GET['id'])){
	$sq = mysql_query("SELECT * FROM ".HOMEBANNER." WHERE id = '".$_GET['id']."'");
	if(mysql_num_rows($sq) > 0){
		$res = mysql_fetch_object($sq);
		// get param
		$id=$res->id;
		$banner_title = stripslashes($res->banner_title);
		$banner_description = stripslashes($res->banner_desp);
		$banner_img = stripslashes($res->banner_img);
		$banner_link = stripslashes($res->banner_link);
		$banner_order = stripslashes($res->banner_order);
		$status = stripslashes($res->status);
		$created_date = date("d-m-Y",strtotime($res->created_date));
		$modified_date = ($res->modified_date !="0000-00-00 00:00:00")?date("d-m-Y",strtotime($res->modified_date)): "N/A";
		$target = stripslashes($res->target);
	}
}
?>
<script type="text/javascript">

function valForm()
{
	var banner_title=$("#banner_title").val();
	var banner_img=$("#banner_img").val();	
	var banner_link =$("#banner_link").val();
	var status=$("#status").val();	
	var error = "";
	var flag = false;
	var target = $("#target").val();
	var filter = /^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/;
	var dataArray = new Array();
	if(banner_title=='')
	{
		$("#banner_title").css("border-color","#F00");
		error = "- Enter Banner Title\n";
		flag = false;
		dataArray.push('banner_title');
	}
	else
	{
		$("#banner_title").css("border-color","");
		flag = true;
		dataArray.pop();
	}
	if(banner_img=='')
	{
		$("#banner_img").css("border-color","#F00");
		error += "- Enter Banner Image\n";
		flag = false;
		dataArray.push('banner_img');
	}
	else
	{
		$("#banner_img").css("border-color","");
		flag = true;
		dataArray.pop();
	}

	if(status=='')
	{
		$("#status").css("border-color","#F00");
		error += "- Enter status\n";
		flag = false;
		dataArray.push('status');
	}
	else
	{
		$("#status").css("border-color","");
		flag = true;
		dataArray.pop();
	}
	if(target=='')
	{
		$("#target").css("border-color","#F00");
		error += "- Enter Target\n";
		flag = false;
		dataArray.push('target');
	}
	else
	{
		$("#target").css("border-color","");
		flag = true;
		dataArray.pop();
	}
	if(flag == false)
	{
		alert(error);
		document.baner_fr.elements[dataArray[0]].focus();
		return false;
	}
	else
	return true;
	
}
$(document).ready( function() {
     
	  $('#banner_img').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            $('#banner_img').attr('disabled', false);
			$("#error_div").html("");
            break;
        default:
            $("#error_div").html("This is not the allowed file type");
			$('#banner_img').focus();
            this.value = '';
    }
});
});
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
//function active_inactive(flag,id){
//alert(flag);
//  $.post("http://192.168.0.118/aupair/app/webroot/admin/account.php?page=manage-banner",{'todo':'active_inactive','flag':flag,'id':id},function(response){
//                      //$('#dv1').html(response).css('border','solid 1px green').css('color','blue');
//         });
//		 if(flag==1){
//		 $('#active_span').html('Inactive');
//		 }else{
//		 $('#active_span').html('Active');
//		 }
//		 
//}

</script>
<?php if($_GET["task"]!='') {?>
<div style="width: 100%; margin: 0 auto; margin-top: 0px;">
 <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 8px; margin-top: 10px;">
   <tr>
      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 10px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Create/Manage Banner</strong></td>
      <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 15px; padding-right: 0px;">
	 <a href="account.php?page=manage-banner"><img src="images/view_all.png" width="87" height="15" border="0"></a>
	  </td>
    </tr> 
</table>
  <?php if($msg <> ""){?>
  <div style="border: 1px solid #990; background-color: #FFC; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
    <td width="6%"><img src="<?php echo BASE_URL; ?>images/warning.png" width="20" height="20"></td>
    <td width="94%"><?php echo $msg; ?></td>
    </tr>
    </table>
  </div>
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
  <form action="" method="post" name="baner_fr" id="baner_fr" onsubmit="return valForm();" enctype="multipart/form-data"> 
  <input name="id" value="<?php echo $id; ?>" type="hidden"  />
    <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-top:8px;">
            <tr>
        <td width="10%">Banner Title:</td>
        <td width="90%"><input name="banner_title" type="text" class="textbox" id="banner_title" value="<?php echo $banner_title; ?>" style="width: 200px;"> 
        <span id="mtitle" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span>
         
        </td>
        
        </tr>
     
        <tr>
    <td colspan="2"><strong>Banner Description </strong>
    <?php if($_GET['id'] != "" || $task == "" || $task != "new")echo " - Last Modified: ".$modified_date; ?></td>
    </tr>
    <tr>
    <td colspan="2">
    <?php
    include_once("editor/fckeditor.php");
    $oFCKeditor = new FCKeditor('banner_desp',200,500);
    $oFCKeditor->ToolbarSet = 'Basic';
    $oFCKeditor->BasePath = 'editor/';
    $oFCKeditor->Config['EnterMode'] = 'br';
    $oFCKeditor->Value = $banner_description;
    $oFCKeditor->Create(); 
    ?>
    </td>
    </tr>
    <tr>
        <td>Banner Image: </td>
        <td> <input  name="banner_img"  type="file" class="textbox" <?php if($banner_img==''){?>id="banner_img" <?php }?>  style="width: 200px;"  onchange="prev_img();" />
        </td>
        </tr>
        <tr><td colspan="2">
        <?php if($banner_img!=''){?>
        <div id="prev_img">
        <img src="<?php echo SITE_URL.'upload/banners/'.$banner_img; ?>" alt="N/A"  height="80" width="80">
        <input  name="banner_img"  type="hidden"  value="<?php echo $banner_img;?>" />
        </div>
        <?php } ?>
        </td>
    </tr>
     <tr>
        <td width="10%">Banner Link:</td>
        <td width="90%"><input name="banner_link" type="text" class="textbox" id="banner_link" value="<?php echo $banner_link; ?>" style="width: 200px;"> 
        <span id="mtitle" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:10px;">(e.g- http://www.abcd.com)</span>  
        </td>
        
     </tr>
        <tr>
        <td>Target:</td>
        <td>
          <select name="target" id="target" style="width: 205px;" >
            <option value="">--- Select ---</option>
            <option value="same"  <?php if($target == "same") echo "selected='selected'"; ?> >Same Window</option>
            <option value="other" <?php if($target == "other") echo "selected='selected'"; ?> >Different Window</option>
          </select>
        </td>
        </tr>
    <tr>
        <td>Status:</td>
        <td>
          <select name="status" id="status" style="width: 205px;" >
            <option value="">--- Select ---</option>
            <option value="1"  <?php if($status == "1") echo "selected='selected'"; ?> >Active</option>
            <option value="0" <?php if($status == "0") echo "selected='selected'"; ?> >Inactive</option>
          </select>
        </td>
        </tr>
    <tr>
        <td colspan="2"><?php
        $task=$_REQUEST['task'];
    if($task == "new"){
    ?>
          <input name="save" type="submit" id="save" value=" Save "  class="actionBtn">
          <?php
    }else{
    ?>
    
          <input name="update" type="submit" id="update" value=" Update "  class="actionBtn">
          <?php } ?></td>
      </tr>
    </table>
</form>
</div>
<?php } else {
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 12;//limit in each page
$startpoint = ($part * $perpage) - $perpage;
?>
<div style="width: 100%; margin: 0 auto; margin-top: 0px;">
  <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style=" margin-top: 10px;">
   <tr>
      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Create/Manage Banner</strong></td>
      <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-right: 0px;">
      <a href="account.php?page=manage-banner&task=new"><img src="images/add_new.png" width="87" height="15" border="0"></a>
	  </td>
    </tr> 
</table>
   <form action="" method="post" name="chapter_fr" id="chapter_fr">
  <table width="100%" border="0" cellspacing="0" cellpadding="3" style="background-color: #FFFFFF;">
 
  <tr>
         <td width="45%"  align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;"><input type="button" name="deleteall" id="deleteall" value="Delete Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='deleteall';document.chapter_fr.submit();" disabled="disabled"/>
         <input type="button" name="publishall" id="publishall" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
        <input type="button" name="unpublishall" id="unpublishall" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="58%" align="right">&nbsp;</td>
        <td width="31%" align="right" style="padding-left: 4px;"><input name="content_title" type="text" class="textbox" id="menu_title" style="width: 200px;" placeholder="Search By Banner Title" value="<?php echo $_POST["content_title"]; ?>"></td>
        <td width="11%" align="right"><input type="submit" name="search" id="search" value=" Search " class="actionBtn"></td>
		<td width="10%" align="right"><input type="button" name="reset" onclick="location.href='account.php?page=manage-banner';" id="reset" value=" Reset " class="actionBtn" ></td>
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
       <td width="37" align="left" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
        <td width="52"  align="left" bgcolor="#333333"><strong>SL#</strong></td>
        <td width="318" align="left" bgcolor="#333333"><strong>Banner Title <?php if(isset($_GET['bantitle']) && $_GET['order']=="asc"){?><a href="account.php?page=manage-banner&bantitle=1&order=desc">
        <img src="images/desnd.png" alt="N/A" width="10"  height="10" border="0"></a><?php }else{?><a href="account.php?page=manage-banner&bantitle=1&order=asc"><img src="images/asdn.png" alt="N/A" width="10"  height="10" border="0"></a><?php }?></strong></td>
        
        <td width="278" align="center" bgcolor="#333333"><strong>Banner Images</strong></td>
        <td width="104" align="left" bgcolor="#333333" style="width:80px;"><strong>Order&nbsp;<?php if(isset($_GET['banorder']) && $_GET['order']=="asc"){?><a href="account.php?page=manage-banner&banorder=1&order=desc"><img src="images/desnd.png" alt="N/A" width="10"  height="10" border="0"></a><?php }else{?><a href="account.php?page=manage-banner&banorder=1&order=asc"><img src="images/asdn.png" alt="N/A" width="10"  height="10" border="0"></a>
		<?php
		 }?>
          <img src="images/save.png" height="11" width="15%" onclick="document.chapter_fr.todo.value='saveOrder';document.chapter_fr.submit();" style="cursor:pointer" title="Save" ></strong></td>
          <td width="216" align="center" bgcolor="#333333"><strong>Status</strong></td>
          <td width="152" align="center" bgcolor="#333333"><strong>Created Date<?php if(isset($_GET['createdate']) && $_GET['order']=="asc"){?><a href="account.php?page=manage-banner&createdate=1&order=desc">
          <img src="images/desnd.png" alt="N/A" width="10"  height="10" border="0"></a><?php }else{?><a href="account.php?page=manage-banner&createdate=1&order=asc"><img src="images/asdn.png" alt="N/A" width="10"  height="10" border="0"></a>
		<?php
		 }?></strong></td>
      	
        <td width="130" align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
      <?php
	  	  $order='';
		  if(isset($_GET['bantitle']) && $_GET['order']=="asc")
		  {
			  $order="order by banner_title desc";
		  }
		  else if(isset($_GET['bantitle']) && $_GET['order']=="desc")
		  {
			  $order="order by banner_title asc";
		  }
		  else if(isset($_GET['banorder']) && $_GET['order']=="asc"){
			$order="order by banner_order desc";  
		  }
		   else if(isset($_GET['banorder']) && $_GET['order']=="desc"){
			$order="order by banner_order asc";  
		  }
		  else if(isset($_GET['createdate']) && $_GET['order']=="asc"){
			  $order="order by created_date desc";  
		  }
		   else if(isset($_GET['createdate']) && $_GET['order']=="desc"){
			  $order="order by created_date asc";  
		  }
		    else if(isset($_GET['modifydate']) && $_GET['order']=="asc"){
			  $order="order by modified_date desc";  
		  }
		   else if(isset($_GET['modifydate']) && $_GET['order']=="desc"){
			  $order="order by modified_date asc";  
		  }
		 else
		  {
			  $order="order by id desc";
		  }
	  if(isset($_POST["search"])){
	 	  $j = 0;
		  $i = 0;
	 $sq = mysql_query("SELECT * FROM ".HOMEBANNER." WHERE banner_title LIKE '%".$_POST["content_title"]."%' ".$order." LIMIT ".$startpoint.",".$perpage);
	  }
	  else{
		  $j = 0;
		  $i = 0;
	
		  
		  $sq = mysql_query("SELECT * FROM ".HOMEBANNER." ".$order." LIMIT ".$startpoint.",".$perpage);
	  }
	//  print "SELECT * FROM ".PAGESLIDER." ORDER BY content_title ASC LIMIT ".$startpoint.",".$perpage;exit;
	   if(mysql_num_rows($sq) > 0){
		  if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=(15*($_GET["part"]-1))+1;}
	  while($res = mysql_fetch_array($sq)){
		  $j++;
		   $bgcolor = ($j%2 == 0)?'bgcolor="#F2FBFF"':'bgcolor="#FFFFFF"';
	  ?>
      <tr <?php echo $bgcolor; ?>>
       <td align="left"><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $j;?>" value="<?php echo $res['id']; ?>" onclick="check_single('chkNo<?php echo $j;?>');" /></td>
        <td align="left"><strong><?php echo $j; ?></strong></td>
        <td align="left"><span style="text-transform: capitalize;"><?php echo stripslashes($res["banner_title"]); ?></span></td>
      
        <td align="center">
        <?php if($res['banner_img'] != ""){ ?>
        <img src="<?php echo SITE_URL; ?>upload/banners/<?php echo $res['banner_img']; ?>" alt="N/A"  height="60" width="100">
        <?php }else{echo "N/A";} ?>
        </td>
        <td align="center"><span style="text-transform: capitalize;"><input type="text" class="textbox" id="<?php echo $res["id"]?>" name="order[<?php echo $res["id"]?>]" style="width: 40px; text-align:center;" value="<?php echo $res["banner_order"]; ?>"/></span></td>
        <td align="center">
		<?php if($res["status"]=='0') { ?>
          <a href="account.php?page=manage-banner&amp;action=block&amp;id=<?php echo $res["id"]; ?>&amp;part=<?php echo $_GET['part']; ?>">
          <font color="#FF0000">InActive</font></a>
          <?php } else {?>
          <a href="account.php?page=manage-banner&amp;action=activate&amp;id=<?php echo $res["id"]; ?>&amp;part=<?php echo $_GET['part']; ?>">
          <font color="#006633">Active</font></a>
          <?php } ?>
          </td>
       	<td align="center"><span style="text-transform: capitalize;"><?php if($res["created_date"]!="0000-00-00 00:00:00"){echo date("d-m-Y",strtotime($res["created_date"])); }else{echo "N/A";}?></span></td>
        <td align="center">
			
		<a href="account.php?page=manage-banner&task=edit&id=<?php echo $res['id']; ?>&part=<?php echo $_GET['part']; ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a>&nbsp;
		 
		<a href="account.php?page=manage-banner&action=delete&id=<?php echo $res['id']; ?>" onclick="return confirm('Are you sure to delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a> <?php } ?></td>
        </tr>
      <?php
	  }else{
		  ?>
          <tr>
        <td colspan="10" align="center" bgcolor="#F2FBFF" style="padding: 5px;">No Record Found</td>
        </tr>
			<?php
			}
			?>

          <tr>
        <td colspan="10" align="left"><input type="button" name="deleteall" id="deleteall1" value="Delete Selected" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='deleteall';document.chapter_fr.submit();" disabled="disabled"/>
      <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="publishall" id="publishall1" value="Publish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='publishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span><span style="border-bottom: 0px ; padding-bottom: 0px;font-size: 14px; color: #036;">
      <input type="button" name="unpublishall" id="unpublishall1" value="Unpublish" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.chapter_fr.todo.value='unpublishall';document.chapter_fr.submit();" disabled="disabled"/>
      </span>
      <input type="hidden" name="todo" id="todo" value=""/></td>

        
          </tr>
       
      <tr>
            <td colspan="10" align="center">
<?php
			 if(isset($_POST['search'])){
				  echo Paging(HOMEBANNER,$perpage,"account.php?page=manage-banner&","banner_title LIKE '%".$_POST['content_title']."%' ORDER BY banner_title DESC");
					
					}else{
					//print 'hwew';exit;
					echo Paging(HOMEBANNER,$perpage,"account.php?page=manage-banner&");
					} 
			
			  ?>			
			
			</td>
          </tr>
          <tr><td colspan="8"><span style="color:red">Note: Search can be posible by content Title.</span></td></tr>
    </table>
	
	</td>
  </tr>
</table></form>
</div>
<?php } 



?>





