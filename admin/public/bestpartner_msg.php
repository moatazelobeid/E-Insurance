<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');



$id = $_GET["id"];
$msg=mysql_fetch_assoc(mysql_query("select * from ".COMPANYTBL." where id=".$id));
?>
<script type="text/javascript">
function validNote()
{
	var msg=document.getElementById("msg").value;
	var msg_ar=document.getElementById("msg_ar").value;
	if(msg=='')
	{
		form.msg.style.borderColor='Red';
		form.msg.focus();
		return false
	}
	else
	{
		var url="<?php echo BASE_URL;?>util/utils.php?bestpartner=<?php echo $id;?>&msg="+msg+"&msg_ar="+msg_ar;
		//alert(url);
		$.post(url,function(data){
			alert('Message added Sucessfully');
			location.href='<?php echo BASE_URL;?>account.php?page=company_list';
		});
	}
}
</script>
<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
 <tr>
    <td><strong>Best Partner Message:</strong></td>
  </tr>
  <tr>
    <td><textarea name="msg" id="msg" style="height:150px;width:450px;overflow:scroll;"><?php echo stripslashes($msg['bestpartner_msg']);?></textarea></td>
  </tr>
 <tr>
    <td><strong>Best Partner Message (Ar):</strong></td>
  </tr>
  <tr>
    <td><textarea name="msg_ar" id="msg_ar"  style="height:150px; width:450px;"><?php echo stripslashes($msg['bestpartner_msg_ar']);?></textarea></td>
  </tr>
  <tr>
    <td align="right"><input type="button" name="save_msg" value="Save" style="margin-right:35px;" onclick="return validNote();" /></td>
  </tr>
</table>
