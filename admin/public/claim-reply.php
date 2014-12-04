<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");

$id=$_GET['id'];
$motor_claim=mysql_fetch_assoc(mysql_query("select * from ".CLAIMMOTOR." where id='".$id."'"));
$admin_reply =  stripslashes($motor_claim['admin_reply']);
?>
<style>
#Menu li
{
  z-index:0;
}
.welcomearea_cd th, .welcomearea_cd td
{
	padding:4px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
</style>

<style>
.innerpagearea_left_inner_d{width:100%;}
.your-quoatation1{width:100%;}
.your-quoatation-inner1{width:98%;}
.your-quoatation-inner{width:98%;}
.your-quoatation1:hover{width:100%;}
</style>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
function save_reply()
{
  var reply = document.getElementById("admin_reply").value;
  //alert(reply);
  if(reply == '')
  {
   document.getElementById("admin_reply").style.borderColor = 'red';
   document.getElementById("state_div").innerHTML = '<font color="red">Please Enter Your Reply..!!</font>';
  }
  else
  { 
  	var url = "<?php echo BASE_URL;?>util/claim_reply.php?reply=" + reply +"&id=<?php echo $id;?>&type=<?php echo $policy_type;?>";
	$.post(url,function(data)
	{	
	    alert(data);
		$("#state_div").html(data);
		parent.location.reload();
	});
    document.getElementById("admin_reply").style.borderColor = '';
	
  }
}
</script>
<?php if($admin_reply!= ''){?>
                     <table width="100%" border="0" cellpadding="2" cellspacing="4">
					 <tr>
                         <td height="40" colspan="3">&nbsp;<span class="fieldLabel form_txt1">Replied Against Claim :</span></td>
					 </tr>
					
					  <tr>
						 <td width="500" height="30" valign="top">
						 <?php echo $admin_reply;?>
						 </td>
						  
						</tr>
					
						  </table>

<?php  }else{?>
<form name="reply_form" method="post">
<table>
							   <tr>
                                 <td height="40" colspan="3">&nbsp;<span class="fieldLabel form_txt1">Reply Against Claim :</span></td>
						      </tr>
							   <tr>
                         <td colspan="3" id="state_div"></td></tr>
							   <tr>
                                 <td  colspan="3"><textarea name="admin_reply" id="admin_reply" style="width:450px; height:110px; resize:none;" tabindex="3"></textarea></td>
						      </tr>
							

							<tr class="fieldRow1">
							<td colspan="3" class="fieldLabelsColumn1">
						<input name="Btn_Submit" value="Submit" class="submit_btn" type="button" style="float:right;" tabindex="3" onclick="return save_reply();" />
									 	
								 </td>
                       		  </tr>
							   <tr>
								 <td colspan="3"></td>
							   </tr>
							</table>
						  </form>

<?php }?>


		 