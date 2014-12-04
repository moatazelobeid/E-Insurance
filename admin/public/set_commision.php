<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");


$id = $_GET["id"];
$type = $_GET["type"];
if($type=='company')
	$tbl=COMPANYTBL;
if($type=='agent')
	$tbl=AGENTTBL;
$commision=mysql_fetch_assoc(mysql_query("select commision from ".$tbl." where id=".$id));
?>
<script type="text/javascript">
function validForm()
{
	var form=document.commisionForm;
	var commision=form.commision.value;
	if(commision=='')
	{
		form.commision.style.borderColor='Red';
		form.commision.focus();
		return false
	}
	else
	{
		var url="<?php echo BASE_URL;?>util/utils.php?id=<?php echo $id;?>&tbl=<?php echo $tbl;?>&task=setCommision&commision="+commision;
		//alert(url);
		$.post(url,function(data){
			alert('Commision added Sucessfully');
			location.href='<?php echo BASE_URL;?>account.php?page=<?php echo $type;?>_list';
		});
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
<form name="commisionForm" action="" method="post"> 
<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
  <tr height="30">
    <td colspan="2" align="center"><strong>SET COMMISION</strong></td>
  </tr>
  <tr>
  	<td><strong>Commision:</strong></td>
    <td><input type="text" class="textbox" name="commision" id="commision" onkeyup="document.getElementById('commision').style.borderColor='#BCBBBB';" value="<?php echo $commision['commision'];?>" onkeypress="return isNumberKey(event);" />&nbsp;(in %)</td>
  </tr>
  <tr>
    <td align="right" colspan="2"><input type="button" name="save" value="Save" style="margin-right:35px;" onclick="return validForm();" /></td>
  </tr>
</table>
</form>