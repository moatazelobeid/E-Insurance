<?php
$whr = '';

$sq ="select a.* from ".PAYMENTS." as a inner join ".USERTRAVELPOLICY." as b on a.policy_id=b.policy_no ".$whr." UNION select a.* from ".PAYMENTS." as a inner join ".USERHEALTHPOLICY." as b on a.policy_id=b.policy_no ".$whr." UNION select a.* from ".PAYMENTS." as a inner join ".USERAUTOPOLICY." as b on a.policy_id=b.policy_no ".$whr." UNION select a.* from ".PAYMENTS." as a inner join ".USERMALPRACTICEPOLICY." as b on a.policy_id=b.policy_no ".$whr."   order by id desc";
?>  
<?php

$sq_var="select * from ".GLOBALTBL." where cid='1'";

$res_var=mysql_query($sq_var);

$rs_var=mysql_fetch_object($res_var);



$id=$rs_var->cid;

$title=stripslashes(trim($rs_var->site_name));

$default_title=stripslashes(trim($rs_var->default_title));


$site_email=stripslashes(trim($rs_var->site_email));

$author_name=stripslashes(trim($rs_var->author_name));


$meta_tag=stripslashes(trim($rs_var->meta_tag));

$meta_keyword=stripslashes(trim($rs_var->default_keywords));
$copyright_info=stripslashes(trim($rs_var->copyright_info));
$copyright_info_ar=stripslashes(trim($rs_var->copyright_info_ar));
$phone=trim($rs_var->phone);
$email=stripslashes(trim($rs_var->email));
$fax=trim($rs_var->fax);
//$db_user=$rs_var->db_user;

$date=$rs_var->modified_date;
//update

if(isset($_POST['update']))

{

	$title = addslashes(trim($_POST['title']));

	$default_title=addslashes(trim($_POST['default_title']));


	$site_email=addslashes(trim($_POST['site_email']));
	$meta_tag=addslashes(trim($_POST['meta_tag']));

	$meta_keyword=addslashes(trim($_POST['meta_keyword']));

	
	$copyright_info=addslashes(trim($_POST['copyright_info']));
	$copyright_info_ar=addslashes(trim($_POST['copyright_info_ar']));
	$phone=$_POST['phone'];
	$email=addslashes(trim($_POST['email']));
	$fax=$_POST['fax'];

	//$date=$_POST['date'];

	//$msg = "";



 $sq_update = "Update ".GLOBALTBL." set 	site_name='$title',default_title='$default_title',default_keywords='$meta_keyword',meta_tag='$meta_tag',copyright_info='$copyright_info',copyright_info_ar='$copyright_info_ar',site_email='$site_email',modified_date = now(),phone='$phone',email='$email',fax='$fax' where cid='1'";
 
 //echo"Update ".GLOBALTBL." set 	site_name='$title',default_title='$default_title',default_keywords='$meta_keyword',meta_tag='$meta_tag',copyright_info='$copyright_info',site_email='$site_email',modified_date = now(),phone='$phone',email='$email',fax='$fax' where cid='1'";

  if($res_update=mysql_query($sq_update)){
	  
	  
	  $msg="<span style='color:green;font-weight:bold'>Update Success</span>";
	  }else{
	    $msg="<span style='color:red;font-weight:bold'>Update Failed</span>";
	  }
  

	}



?>

<script type="text/javascript">

function validate_config(){

var fn=document.global_form;

		document.getElementById('config_error').innerHTML='';

		if(fn.title.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Site Name';

		fn.title.focus();

		fn.title.style.borderColor='red';

		return false;

		}else{

		fn.title.style.borderColor='';

		}

		if(fn.default_title.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Default Title';

		fn.default_title.focus();

		fn.default_title.style.borderColor='red';

		return false;

		}else{

		fn.default_title.style.borderColor='';

		}

		

		if(fn.site_url.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Site URL';

		fn.site_url.focus();

		fn.site_url.style.borderColor='red';

		return false;

		}else{

		fn.site_url.style.borderColor='';

		}

		

		if(fn.admin_url.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Admin URL';

		fn.admin_url.focus();

		fn.admin_url.style.borderColor='red';

		return false;

		}else{

		fn.admin_url.style.borderColor='';

		}

		

		if(fn.site_email.value.length==0){

		document.getElementById('config_error').innerHTML='Enter SiteEmail';

		fn.site_email.focus();

		fn.site_email.style.borderColor='red';

		return false;

		}else{

		fn.site_email.style.borderColor='';

		}

		

		

		if(fn.content_type.value==''){

		document.getElementById('config_error').innerHTML='Select Content Type';

		fn.content_type.focus();

		fn.content_type.style.borderColor='red';

		return false;

		}else{

		fn.content_type.style.borderColor='';

		}



       if(fn.meta_tag.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Meta Description';

		fn.meta_tag.focus();

		fn.meta_tag.style.borderColor='red';

		return false;

		}else{

		fn.meta_tag.style.borderColor='';

		}

		if(fn.meta_keyword.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Meta Keyword';

		fn.meta_keyword.focus();

		fn.meta_keyword.style.borderColor='red';

		return false;

		}else{

		fn.meta_keyword.style.borderColor='';

		}
/*
		if(fn.language.value==''){

		document.getElementById('config_error').innerHTML='Select Language';

		fn.language.focus();

		fn.language.style.borderColor='red';

		return false;

		}else{

		fn.language.style.borderColor='';

		}*/

		if(fn.copyright_info.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Copyright Info';

		fn.copyright_info.focus();

		fn.copyright_info.style.borderColor='red';

		return false;

		}else{

		fn.copyright_info.style.borderColor='';

		}
		
		 if(fn.copyright_info_ar.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Copyright Info(Ar)';

		fn.copyright_info_ar.focus();

		fn.copyright_info_ar.style.borderColor='red';

		return false;

		}else{

		fn.copyright_info.style.borderColor='';
		}
		

		/*if(fn.server_name.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Server Name';

		fn.server_name.focus();

		fn.server_name.style.borderColor='red';

		return false;

		}else{

		fn.server_name.style.borderColor='';

		}*/

		/*if(fn.db_name.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Database Name';

		fn.db_name.focus();

		fn.db_name.style.borderColor='red';

		return false;

		}else{

		fn.db_name.style.borderColor='';

		}*/

		/*if(fn.db_user.value.length==0){

		document.getElementById('config_error').innerHTML='Enter DB User Name';

		fn.db_user.focus();

		fn.db_user.style.borderColor='red';

		return false;

		}else{

		fn.db_user.style.borderColor='';

		}*/

		/*if(fn.db_pwd.value.length==0){

		document.getElementById('config_error').innerHTML='Enter Password';

		fn.db_pwd.focus();

		fn.db_pwd.style.borderColor='red';

		return false;

		}else{

		fn.db_pwd.style.borderColor='';

		}*/

}

</script>
<?php
$employees=mysql_num_rows(mysql_query("select * from ".EMPLOYEETBL.""));
$agents=mysql_num_rows(mysql_query("select * from ".AGENTTBL.""));
$customers=mysql_num_rows(mysql_query("select * from ".USERTBL.""));
$companies=mysql_num_rows(mysql_query("select * from ".COMPANYTBL.""));
$companies=mysql_num_rows(mysql_query("select * from ".COMPANYTBL.""));
$auto_policy=mysql_num_rows(mysql_query("select * from ".POLICYMASTER.""));
//$health_policy=mysql_num_rows(mysql_query("select * from ".HEALTHPOLICY." where del_status='0'"));
//$malpractice_policy=mysql_num_rows(mysql_query("select * from ".MALPRACTICEPOLICY." where del_status='0'"));
//$travel_policy=mysql_num_rows(mysql_query("select * from ".TRAVELPOLICY." where del_status='0'"));
$policy=$auto_policy;
$active_auto_policy=mysql_num_rows(mysql_query("select * from ".POLICYMASTER." where status='Active'"));
//$active_health_policy=mysql_num_rows(mysql_query("select * from ".HEALTHPOLICY."  where status='1' and del_status='0'"));
//$active_malpractice_policy=mysql_num_rows(mysql_query("select * from ".MALPRACTICEPOLICY."  where status='1' and del_status='0'"));
//$active_travel_policy=mysql_num_rows(mysql_query("select * from ".TRAVELPOLICY."  where status='1' and del_status='0'"));
$active_policy=$active_auto_policy;
$inactive_auto_policy=mysql_num_rows(mysql_query("select * from ".POLICYMASTER." where status!='Active'"));
//$inactive_health_policy=mysql_num_rows(mysql_query("select * from ".HEALTHPOLICY."  where status='0' and del_status='0'"));
//$inactive_malpractice_policy=mysql_num_rows(mysql_query("select * from ".MALPRACTICEPOLICY."  where status='0' and del_status='0'"));
//$inactive_travel_policy=mysql_num_rows(mysql_query("select * from ".TRAVELPOLICY."  where status='0' and del_status='0'"));
$inactive_policy=$inactive_auto_policy;
$total_income_sql=mysql_query($sq);
while($row=mysql_fetch_array($total_income_sql))
{
  $agent_price=($row["amount_paid"]*$row["agent_commision"])/100;
  $admin_price=($row["amount_paid"]*$row["admin_commision"])/100;
  $agent_commision=$agent_commision+$agent_price;
  $admin_commision=$admin_commision+$admin_price;
  $total_income=$total_income+$row["amount_paid"];
  $company_price=$row["amount_paid"]-($agent_price+$admin_price);
  $company_total=$company_total+$company_price;
}

$cdate=date('Y-m-d');
$today_income=mysql_fetch_object(mysql_query("select sum(amount_paid) as total from ".PAYMENTS." where paid_on='".$cdate."'"));
?>
<center>
<div style="width:700px" align="center">
<div style="width: 300px; margin: 0 auto; margin-top: 10px; float:left">

<table width="100%" border="0" cellspacing="0" cellpadding="3" style="margin-bottom: 8px;">
  <tr>
    <td width="3%" class="app_title"><img src="images/edit_icon.jpg" width="28" height="28"></td>
    <td width="46%" class="app_title"><strong>Site Statistics </strong></td>
    <td width="51%" align="right"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
	<tr height="10"><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td width="59%" align="right" valign="middle" style="padding-left: 4px;">Number of Employees : </td>
		<td width="41%"  align="left" style="padding-left: 4px;"><?php echo $employees;?> </td>
	</tr>
	
	<tr>
		<td align="right" valign="middle" style="padding-left: 4px;">Number of Agents: </td>
		<td  align="left" style="padding-left: 4px;"><?php echo $agents;?></td>
	</tr>
	
	<tr>
		<td align="right" valign="middle" style="padding-left: 4px;">Number of Customers: </td>
		<td  align="left" style="padding-left: 4px;"><?php echo $customers;?></td>
	</tr>
	
	<tr>
	  <td align="right" valign="middle" style="padding-left: 4px;">Number of Quotes: </td>
	  <td  align="left" style="padding-left: 4px;"><?php echo mysql_num_rows(mysql_query("SELECT * FROM ".POLICYQUOTES."")); ?></td>
	  </tr>
	<tr>
		<td align="right" valign="middle" style="padding-left: 4px;">Number of Policy: </td>
		<td  align="left" style="padding-left: 4px;"><?php echo $policy;?></td>
	</tr>
	
	<tr>
		<td align="right" valign="middle" style="padding-left: 4px;">Number of Active Policy: </td>
		<td  align="left" style="padding-left: 4px;"><?php echo $active_policy;?></td>
	</tr>
	
	<tr>
		<td align="right" valign="middle" style="padding-left: 4px;">Number of Inactive Policy: </td>
		<td  align="left" style="padding-left: 4px;"><?php echo $inactive_policy;?></td>
	</tr>
	<tr>
	  <td align="right" valign="middle" style="padding-left: 4px;">Number of Claims: </td>
	  <td  align="left" style="padding-left: 4px;"><?php echo mysql_num_rows(mysql_query("SELECT * FROM ".CLAIMMOTOR."")); ?></td>
	  </tr>

	<?php /*?><tr>
		<td align="right" valign="middle" style="padding-left: 4px;">Total Income : </td>
		<td  align="left" style="padding-left: 4px;"><?php echo number_format($total_income);?></td>
	</tr>
	
	<tr>
		<td align="right" valign="middle" style="padding-left: 4px;">Today Income : </td>
		<td  align="left" style="padding-left: 4px;"><?php echo number_format($today_income->total);?></td>
	</tr><?php */?>
</table>
</div>
<div style="width: 400px; margin: 0 auto; margin-top: 10px;  float:left">

<table width="100%" border="0" cellspacing="0" cellpadding="3" style="margin-bottom: 8px;">

  <tr>

    <td width="3%" class="app_title"><img src="images/edit_icon.jpg" width="28" height="28"></td>

    <td width="46%" class="app_title"><strong>Global Configuration </strong></td>

    <td width="51%" align="right"></td>

  </tr>

</table>

<table width="100%" border="0" cellspacing="2" cellpadding="2">

	  <tr>

    <td align="right" width="29%">&nbsp;</td>

	<td width="71%" align="left"><div id="config_error" ><?php if($msg){echo $msg;}?></div></td>
</tr>

        <tr>

          <td width="29%" align="right" valign="middle" style="padding-left: 4px;">Site Name : </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php echo $title;?></td>
        </tr>

        <tr>

          <td align="right" valign="middle" style="padding-left: 4px;">Defult Title: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php echo $default_title;?></td>
        </tr>

      

       

        <tr>

          <td align="right" valign="middle" style="padding-left: 4px;">SiteEmail: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php echo $site_email;?></td>
        </tr>


        <tr>

          <td align="right" width="29%" valign="middle" style="padding-left: 4px;">Meta Descriptions: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php echo $meta_tag;?></td>
        </tr>
        <tr>

          <td align="right" width="29%" valign="middle" style="padding-left: 4px;">Meta Keywords: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php echo $meta_keyword;?></td>
        </tr>
        <tr>

          <td align="right" width="29%" valign="middle" style="padding-left: 4px;">Copyright info(En): </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php echo $copyright_info;?></td>
        </tr>
        <tr>

          <td align="right" width="29%" valign="middle" style="padding-left: 4px;">&nbsp;</td>

          <td colspan="2" align="left" style="padding-left: 4px;">&nbsp;</td>
        </tr>
		<tr>

          <td align="right" valign="middle" style="padding-left: 4px;">Phone no.: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php echo $phone;?></td>
        </tr>
		<tr>

          <td align="right" valign="middle" style="padding-left: 4px;">Email: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php echo $email;?></td>
        </tr>
		<tr>

          <td align="right" valign="middle" style="padding-left: 4px;">Fax: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php echo $fax;?></td>
        </tr>
</table>
</div>
</div></center>