<?php 
if(empty($_GET['product_id'])){
	 header('location:account.php?page=policies');
}else
{
	$productid = $_GET['product_id'];
	$pproductdetails = $db->recordFetch($_GET['product_id'],PRODUCTS.":".'id');
}
if($_GET['attachment_id'] != "" && $_GET['task'] == "delete")
{
	if($db->recordDelete(array('id' => $_GET['attachment_id']),PRODUCTATTACHMENTS) == 1){
	// delete user login record
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=policies&view=policy-attachments&product_id=$productid';</script>";
	}
}
if(isset($_POST['save']))
{
	// post params
	$checksql = mysql_query("select * FROM ".PODUCTCOVERS." WHERE product_id ='".$productid."'");
	
	$sq = mysql_query("DELETE FROM ".PRODUCTATTACHMENTS." WHERE product_id ='".$productid."'");

	unset($_POST['save']);
	$err=array_filter($_REQUEST['attachment_title']);
	$i=0;
	//insert all fresh datas 
	$attachment_title = $_POST['attachment_title'];
	$attachment_title_ar = $_POST['attachment_title_ar'];
	$product_id = $_POST['id'];
	$status = $_POST['status'];
	$order = $_POST['ordering'];
	foreach($err as $er){
			
		$dest_file = $_FILES['attachment']['name'][$i];
		$file_type = $_FILES['attachment']['type'][$i];
		$file=$_FILES['attachment']['tmp_name'][$i];
		if(!empty($dest_file)){
			$result = $db->recordInsert(array(product_id=>$product_id,attachment_title=>$attachment_title[$i],attachment_title_ar=>$attachment_title_ar[$i],attachment=>$dest_file,file_type=>$file_type,status=>$status[$i],attachment_order=>$order[$i]),PRODUCTATTACHMENTS,'');
			move_uploaded_file ($file,"../upload/attachments/".$dest_file);
		}else{
			$attachments = $_POST['attachments'][$i];
			$filetype = $_POST['filetype'][$i];
			$result = $db->recordInsert(array(product_id=>$product_id,attachment_title=>$attachment_title[$i],attachment_title_ar=>$attachment_title_ar[$i],file_type=>$filetype,attachment=>$attachments,status=>$status[$i],attachment_order=>$order[$i]),PRODUCTATTACHMENTS,'');
		}
		
		$i++;
	}
	if(mysql_affected_rows() >0)
	{
		if(mysql_num_rows($checksql)<1)
		{
			$msg = "Policy Attachments Saved sucessfully";
		}else{
			$msg = "Policy Attachments Updated sucessfully";
		}
		
	}	

}

?>

<script type="text/javascript">
//check all

$(document).ready( function() {
$('INPUT[type="file"]').change(function () {
var ext = this.value.match(/\.(.+)$/)[1];
switch (ext) {
case 'pdf':
case 'PDF':
case 'doc':
case 'docx':
$('#attachment').attr('disabled', false);
break;
default:
alert('This is not an allowed file type.');
this.value = '';
}
}); });
function dothat()
{
	var count = $("#slider_count").val();
	count = parseInt(count) + 1;
	$("#slider_count").val(count);
	$("#showtxtbox").append('<tr id="new_box' + count + '"><td width="18%"><input name="attachment_title[]" type="text" class="textbox" id="attachment_title' + count + '" value="" style="width: 170px;" ></td><td width="17%"><input name="attachment_title_ar[]" type="text" class="textbox" id="attachment_title_ar' + count + '" value="" style="width: 170px;" ></td><td width="24%"> <input name="attachment[]"  id="attachment' + count + '" type="file" class="textbox" style="width: 180px;float:right;" /><span id="error_img"></span></td><td width="13%" align="center"><input name="ordering[]" type="text" class="textbox" id="ordering' + count + '"  value="" style="width: 60px;" /><span id="mpos" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span></td><td width="15%"  align="center"><select name="status[]" id="status' + count + '" style="width: 120px;"><option value="">---Select---</option><option value="1">Active</option><option value="0">Inactive</option></select></td> <td width="9%" align="center"><input type="button" onclick="closeInfoDesc(' + count + ')" value="&times;" /></td></tr>');
}


function closeInfoDesc(num_val)
{
	var count = $("#slider_count").val();
	$("#slider_count").val(num_val-1);
	$("#new_box" + num_val).remove().find('input:text').val('');
	$("#new_div" + num_val).remove().find('input:button').val('');
	/*document.getElementById('location_' + val).value = '';
	$('#location_' + val).attr("id", "del_info_desc");
	$('#location_' + val).attr("title", "del_infodesc_id[]");*/
}
function valForm(){
	
	var num_tot = document.getElementsByName('attachment_title[]').length;
	for(var i=1;i<=num_tot;i++)
		{
			
			var attachment_title = $("#attachment_title"+i).val();
			
			var order = $("#ordering"+i).val();
			var status = $("#status"+i).val();
			
			if(attachment_title == ''){
				alert('Enter title '+i);
				$("#attachment_title"+i).css('border-color', 'red');
				 $("#attachment_title"+i).focus();
					return false;
			}else{
				$("#attachment_title"+i).css('border-color', '');
			}
			
			 if(order == ''){
				alert('Enter Order '+i);
				$("#ordering"+i).css('border-color', 'red');
				$("#ordering"+i).focus();
					return false;

			}else{
				$("#ordering"+i).css('border-color', '');
			}
			 if(status ==''){
				alert('enter Status '+i);
				$("#status"+i).css('border-color', 'red');
				$("#status"+i).focus();
					return false;
			}else{
				$("#status"+i).css('border-color', '');
			}
		
		}

}


function isNumberKey(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode;
	 if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	
	 return true;
}
</script>
<div style="width: 100%; margin: 0 auto;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 10px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Add Policy Attachments</strong></td>
      <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 15px; padding-right: 0px;">
	  <a href="account.php?page=policies" class="linkBtn <?php if($_GET['view'] == "policy-type") echo "active"; ?>">&#8592;Back to policies</a>
	  </td>
    </tr>
  </table>
  <?php if($msg <> ""){ ?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 0px; <?php if(isset($msg)){?>background-color: #F1F8E9;<?php }?> line-height: 15px; color: #900;">
  <tr>
    
    <td width="98%"><?php echo $msg; ?></td>
  </tr>
</table>
<?php } ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-top: 15px;">
  <tr class="rowHead">
        <td width="18%" align="center"><strong>Attachment Title (EN)</strong></td>
      <td width="18%" align="center"><strong>Attachment Title (AR)</strong></td>
       <td width="25%" align="center"><strong>Add Attachment</strong></td>
       <td width="12%" align="center"><strong>Order</strong></td>
       <td width="14%" align="center"><strong>Status</strong></td>
       <td width="13%" align="center"><strong>Action</strong></td>
    </tr>
  </table>

<?php
$j = 0;
$i = 0;
// trace page information from database
$sq = mysql_query("SELECT * FROM ".PRODUCTATTACHMENTS." where product_id = '".$productid."' ORDER BY id ASC");
$num_rows = mysql_num_rows($sq);
?>

  <form action="" onsubmit="return valForm();"  method="post" name="p_fr" id='p_fr'  enctype="multipart/form-data"> 
  <input name="id" value="<?php echo $productid; ?>" type="hidden"/>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
	<span id='error_msg'></span>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
	<?php
	if($num_rows  > 0){  
	while($res = mysql_fetch_array($sq)){
		  $j++;
		  $i++;
		   $bgcolor = ($j%2 == 0)?'bgcolor="#F2F2F2"':'bgcolor="#F2F2F2"'; ?>
          <tr>
        <td width="18%"><input name="attachment_title[]" type="text" class="textbox" id="attachment_title<?php echo $i; ?>" value="<?php echo $res["attachment_title"]; ?>"  style="width: 170px;" ></td>
		<td width="17%"><input name="attachment_title_ar[]" type="text" class="textbox" id="attachment_title_ar<?php echo $i; ?>" value="<?php echo $res["attachment_title_ar"]; ?>" style="width: 170px;" ></td>
    	<td width="24%"><?php if(!empty($res['attachment'])){ ?><a href="<?php echo SITE_URL.'upload/attachments/'.$res['attachment'];?>" target="_blank"><img src="images/download.png" alt="Delete" width="16" height="16" border="0" title="Download attchment" style="cursor: pointer; margin-top:10px;margin-left:52px;"></a><?php } ?><input type="hidden" name="attachments[]" id ="attachments" value ="<?php echo $res['attachment'];?>" /><input type="hidden" name="filetype[]" id ="filetype" value ="<?php echo $res["file_type"];?>" /> <input name="attachment[]"  id="attachment" type="file" class="textbox"  style="width: 180px;float:right;" />
        <span id='error_img'></span>
		</td>
		<td width="13%" align="center">
			<input name="ordering[]" type="text" class="textbox" id="ordering<?php echo $i; ?>" onKeyUp="isNumberKey(this.value);"  value="<?php echo $res["attachment_order"]; ?>" style="width: 60px;" />
           <span id="mpos" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span>
		 </td>
        <td width="15%" align="center">
          <select name="status[]" id="status<?php echo $i; ?>" style="width: 120px;">
            <option value="">--- Select ---</option>
            <option value="1"  <?php if($res["status"] == "1") echo "selected='selected'"; ?> >Active</option>
            <option value="0" <?php if($res["status"] == "0") echo "selected='selected'"; ?> >Inactive</option>
          </select>
        </td>
		
	   <td width="9%" align="center">
	   <a href="account.php?page=policies&view=policy-attachments&product_id=<?php echo $productid; ?>&attachment_id=<?php echo $res['id']; ?>&task=delete" onClick="return confirm('Are you sure to delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete User" style="cursor: pointer;"></a>
		</td>
		
		</tr> <?php }} else{?>
		<tr>
        <td width="18%"><input name="attachment_title[]" type="text" class="textbox" id="attachment_title1" value="" style="width: 170px;" ></td>
        <td width="17%"><input name="attachment_title_ar[]" type="text" class="textbox" id="attachment_title_ar1" value="" style="width: 170px;" ></td>
        <td width="24%"> <input name="attachment[]"  id="attachment1" type="file" class="textbox"  style="width: 180px;float:right;" />
        <span id='error_img'></span>
		</td>
		<td width="13%" align="center">
			<input name="ordering[]" type="text" class="textbox" id="ordering1"  onKeyUp="isNumberKey(this.value);" value="" style="width: 60px;" />
           <span id="mpos" style="font:Arial, Helvetica, sans-serif; color:#930; font-size:12px;"></span>
		 </td>
        <td width="15%" align="center">
          <select name="status[]" id="status1" style="width: 120px;">
            <option value="">--- Select ---</option>
            <option value="1"  <?php if($res["status"] == "1") echo "selected='selected'"; ?> >Active</option>
            <option value="0" <?php if($res["status"] == "0") echo "selected='selected'"; ?> >Inactive</option>
          </select>
        </td>
		
	   <td width="9%" align="center">
	   
		</td>
		
		</tr><?php } ?>
		<input type="hidden" name="slider_count" id="slider_count" value="<?php echo $num_rows; ?>" />
	 <tr ><td colspan="8"><table width="100%" border="0" id="showtxtbox" cellspacing="0" cellpadding="2"></table></td></tr>
		
    </table>
</td>
</tr>
<tr>
     <td colspan="2">
          <input name="save" type="submit" id="save" value=" Save "  class="actionBtn">
		  <input type="button" class="actionBtn" value="+Add More"  onclick="dothat();"/>
	</td>
 </tr>

</table>
   </form>
</div>