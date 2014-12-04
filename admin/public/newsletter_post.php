<?php
// save record
if(isset($_POST['subscribe']))

{
$nl_subscribe=0;
$to_type = $_POST['type'];
if($to_type =='Customer')
{
$nl_subscribe = $_POST['Customer'];
$tab_name="bv_news_letter_subscriber";
$mailno="email_id";
//$template="Template for Escort";

}
else if($to_type =='Agent')
{
$nl_subscribe = $_POST['Agent'];
$tab_name="bv_agent"; 
$mailno="ag_email";
//$template="Template for Member";
 
}

else if($to_type == 'Company')
{
$nl_subscribe = $_POST['Company'];
$tab_name="bv_company";
$mailno="comp_email";
//$template="Template for Agency";
}


	// params


	$sql="select * from ".NEWSLETTER." where id = '".$nl_subscribe."'";

	$qrr=mysql_query($sql);

	$ob=mysql_fetch_object($qrr);

	$e_subject=$ob->subject;

	$messege_content=$ob->message;

	$publish=$ob->publish_number;

	$sqluser="select * from ".$tab_name." ";

	$resultuser=mysql_query($sqluser);

	while($value=mysql_fetch_assoc($resultuser)){
		$uemail=$value[$mailno];
	//$mailnoq.=$uemail;
///////////////////////newsletter template///////////////

		/*$content = get_values(EMAILTBL,$template,'email_name');
		$message = stripslashes($content->body);
		$date=date("d-m-Y h:i:s");
		
		$message=str_replace("{date}",$date,$message);
		$message=str_replace("{Content}",$messege_content,$message);*/
		
		// send mail
		//sendMail($to,$subject,$message);
	
	///////////////////////newsletter template///////////////


		if(sendMail($uemail,$e_subject,$messege_content)){

		$msg= "Mail sucessfully sent to all users";

		$ss="update ".NEWSLETTER." set is_publish ='1',publish_date=now(),publish_number='".$publish++."' where id ='$nl_subscribe'";

		mysql_query($ss);

		}else{

		$msg= "Mail can not be sent at this time";

		}

	}
//echo $mailnoq;
}

?>

<!-- title -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
$(function(){

$("#snip").click(function(){ $(".snip").show(); $(".img").hide();  $(".snip1").hide(); });
$("#img").click(function(){ $(".snip").hide(); $(".snip1").hide(); $(".img").show(); });
$("#snip1").click(function(){ $(".snip1").show(); $(".img").hide(); $(".snip").hide(); });
$("#img").click()
<?php 
////////////used for edit purpose//////
/*if($type=='1'){?>
$("#img").click();

<?php } elseif($type=='2'){?>
$("#snip").click();
<?php } else if($type=='3'){?>
$("#snip1").click();
<?php }
*/
////end of edit////
?>
});
</script>

<?php
$to_type = $_POST['type'];
if($to_type =='escort')
{
$val_type="escort";
}
else if($to_type =='member')
{
$val_type="member";
}

else if($to_type == 'agency')
{
$val_type="agency";
}
 
?>
<script type="text/javascript">
function Validate()
{
var fn=document.partcat_form;
document.getElementById('error_div').innerHTML = '';
if(fn.Customer.value =="" && fn.Company.value=="" &&  fn.Agent.value=="")
	{

		document.getElementById('error_div').innerHTML='Select  News Letter';

		fn.Customer.focus();

		fn.Customer.style.borderColor='red';
		fn.Customer.focus();

		fn.Customer.style.borderColor='red';
		fn.Agent.focus();

		fn.Agent.style.borderColor='red';

		return false;

	}

	else

	{

		fn.Customer.style.borderColor='';
		fn.Company.style.borderColor='';
		fn.Agent.style.borderColor='';

	}

}

</script>
<?php //}?>

<table width="100%" align="center" border="0" cellspacing="0" cellpadding="3" style="margin-bottom: 8px;">

  <tr>

    <td width="3%" class="app_title"><img src="images/edit_icon.jpg" width="28" height="28"></td>

    <td width="46%" class="app_title"> Subscribe News Letter</td>

    <td width="51%" align="right"><a href="account.php?page=newsletter_subscriber">View All Subscribers</a> &nbsp;|
    
    							  <a href="account.php?page=newsletter_list">Manage Newsletter</a>
                                  
    </td>

  </tr>

</table>

<!-- message -->

<?php

if($msg <> ""){

?>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="background-color: #FFFFCC; font-size: 10px; font-weight: bold; color: RED; text-align: center; margin-bottom: 5px; font-family: Verdana, Arial, Helvetica, sans-serif;">

  <tr>

    <td><?php echo $msg; ?></td>

  </tr>

</table>

<?php } ?>

<!-- app -->

<table width="100%" align="center" border="0" cellspacing="2" cellpadding="2">

	  <form action="" method="post" name="partcat_form" id="partcat_form" onSubmit="return Validate()">

	  <tr>

	  <td width="31%">&nbsp;</td>

	  <td width="69%"><div id="error_div" style="color:#FF3F00;font-weight:bold"></div></td>

	  </tr>
	  <tr>

	  <td align="right" bgcolor="#E8FFFF" style="padding-left: 4px;">News Letter For:</td>

	  <td width="69%">
  <input type="radio" name="type" value="Customer" id="img">
  Customer
			<input type="radio" name="type" value="Agent" id="snip">
			Agent
		    <input type="radio" name="type" value="Company" id="snip1">
		    Company		  </td>

	  </tr>
	<tr class="img">
	<td align="right" bgcolor="#E8FFFF" style="padding-left: 4px;">Select Customer News Letter:</td>

          <td colspan="2" align="left" style="padding-left: 4px;">

		  <select name="Customer" id="Customer">

		  <option value=""  selected="selected">--- Select News Letter ---</option>

          <?php $sql1="select id,title from ".NEWSLETTER." where user_type='Customer'   order by id desc";

		        $res1=mysql_query($sql1);

				while($arr1=mysql_fetch_assoc($res1)){?> 

		        <option value="<?php echo $arr1['id'];?>"><?php echo $arr1['title'];?></option>

				<?php }?>

	        </select>
	  </td>

        </tr>
	<tr class="snip">
	<td align="right" bgcolor="#E8FFFF" style="padding-left: 4px;">Select Agent News Letter:</td>
		<td align="left" style="padding-left:5px;"><select name="Agent" id="Agent">
		  <option value=""  selected="selected">--- Select News Letter ---</option>

          <?php $sql2="select id,title from ".NEWSLETTER." where user_type='Agent'   order by id desc";

		        $res2=mysql_query($sql2);

				while($arr2=mysql_fetch_assoc($res2)){?> 

		        <option value="<?php echo $arr2['id'];?>"><?php echo $arr2['title'];?></option>

				<?php }?>
				
			</select></td>
	</tr>
	<tr class="snip1">
	<td align="right" bgcolor="#E8FFFF" style="padding-left: 4px;">Select Company News Letter:</td>
		<td align="left" style="padding-left:5px;">
			<select name="Company" id="Company">
		  <option value=""  selected="selected">--- Select News Letter ---</option>

          <?php $sql3="select id,title from ".NEWSLETTER." where user_type='Company'  order by id desc";

		        $res3=mysql_query($sql3);

				while($arr3=mysql_fetch_assoc($res3)){?> 

		        <option value="<?php echo $arr3['id'];?>"><?php echo $arr3['title'];?></option>

				<?php }?>
			</select></td>
	</tr>
        <tr>

          <td align="left" style="padding-left: 4px;">&nbsp;</td>

          <td colspan="2" align="left" style="padding-left: 4px;">
          
          <input name="subscribe" type="submit" id="subscribe" value="Send" />
          
          <input name="cancel" type="button" id="cancel" value="Cancel" onclick="location.href='account.php?page=newsletter_list'" />

		</td>

        </tr>

	  </form>

</table>

