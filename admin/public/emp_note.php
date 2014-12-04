<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");
include_once("../../classes/mailFactory.php");
include_once("../../classes/message.php");
include_once('../../paging/pagination.php');



$id = $_GET["id"];
$emp_notes=mysql_fetch_assoc(mysql_query("select emp_note from ".QUOTETBL." where id=".$id));
?>
<script type="text/javascript">
function validNote()
{
	var form=document.empnote;
	var note=form.emp_note.value;
	if(note=='')
	{
		form.emp_note.style.borderColor='Red';
		form.emp_note.focus();
		return false
	}
	else
	{
		var url="<?php echo BASE_URL;?>util/utils.php?quote_id=<?php echo $id;?>&note="+note;
		//alert(url);
		$.post(url,function(data){
			alert('Note added Sucessfully');
			location.href='<?php echo BASE_URL;?>account.php?page=quotes';
		});
	}
}
</script>
<form name="empnote" action="" method="post"> 
<table width="50%" border="0" cellpadding="4" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
  <tr>
    <td><strong>Note:</strong></td>
  </tr>
  <tr>
    <td><textarea style="width:400px; height:300px;" class="textbox" name="emp_note" id="emp_note"><?php echo $emp_notes['emp_note'];?></textarea></td>
  </tr>
  <tr>
    <td align="right"><input type="button" name="save_note" value="Save" style="margin-right:35px;" onclick="return validNote();" /></td>
  </tr>
</table>
</form>