<script type="text/javascript">
function get_policy_type(field_val)
{
    $.ajax({
	type: "POST",
	url: "util/ajax.php",
	data: "type=get_policy_type&id="+field_val,
	success: function(msg){
	if(msg != ""){
		//alert(msg);
		$(".ajax_policy_type").html(msg);
	}			       
	}});
}
function locadpackage_details(policy_type, policy_id)
{
	window.location.href='account.php?page=package&task=package_add&policy_id='+policy_id+'&policytype='+policy_type;
}
</script>

<script type="text/javascript">
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}
</script>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 8px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #CCC; padding-left: 0px; font-size: 14px; color: #036;">
      <strong>Create/Manage Underwritting </strong></td>
      <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 12px; padding-right: 0px; padding-top: 5px;">
	  <a href="account.php?page=package_list" class="linkBtn">View/Manage Underwritting</a>
	  </td>
    </tr> 
</table>
<form action="" method="post" name="package_form" id="package_form">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-bottom: 10px;">
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
	<tr>
        <td style="padding-left: 0px;"> Select Policy Class:</td>
        <td style="padding-right: 0px;">
        
		<select name="policy_id" style="width: 193px; font-weight: normal;" onchange="get_policy_type(this.value);" <?php if($_GET['id'] != '' && $_GET['task'] = 'package_edit'){?> disabled="disabled" <?php }?>>
			<option value="">Select Class</option>
			<?php 
			$sql_class = mysql_query("SELECT id,title FROM ".POLICIES." WHERE status = '1'");
			if(mysql_num_rows($sql_class) > 0){
				while($result_class = mysql_fetch_array($sql_class))
				{
				?>
					<option value="<?php echo $result_class['id'];?>" <?php if($_GET['policy_id']==$result_class['id'])echo 'selected="selected"';?>><?php echo $result_class['title'];?></option>
				<?php
				}
			}
			?>
		</select>
		</td>
      </tr>
      <?php $policysql = mysql_query("select * from ".POLICYTYPES." where status ='1' and policy_id ='".$_GET['policy_id']."' ");?>
      <tr>
      <td width="12%" style="padding-left: 0px;">Select Policy Type:</td>
				   <td width="88%">
                   <span class="ajax_policy_type"> 
				   <select name="policy_type_id" id="policy_type_id" onchange="locadpackage_details(this.value, <?php echo $_GET['policy_id'];?>);" style="width:193px;" <?php if($_GET['id'] != '' && $_GET['task'] = 'package_edit'){?> disabled="disabled" <?php }?>>
				   <option value="">Select Policy Type</option>
				   <?php 
						while($row1 = mysql_fetch_array($policysql)):
				   ?>
				   <option value="<?=$row1['id']?>" <?=($policy_type_id == $row1['id'])?'Selected':''?> <?=(isset($_GET['policytype']) && $_GET['policytype'] == $row1['id'] )?'Selected':''?>><?=$row1['policy_type']?></option>
				   <?php endwhile; ?>
				   </select>
          </span></td>
	    </tr>
	</table>
	</td>
  </tr>
</table>

<?php if($_GET['policytype'] != '' && $_GET['policy_id'] != '')
{
 if($_GET['policytype'] == '2')	
 include_once('public/package_comprehensive.php'); 	
 
 if($_GET['policytype'] == '1')	
 include_once('public/package_tpl.php'); 
 
 if($_GET['policy_id'] == '3')	
 include_once('public/package_medical.php'); 
 
  if($_GET['policy_id'] == '8')	
 include_once('public/package_travel.php'); 
 

}?> 
