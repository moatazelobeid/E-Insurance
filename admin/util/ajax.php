<?php  
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");

if($_POST['type'] == 'get_policy_type' && $_POST['id'] != '')
{
	$id=$_POST['id'];
	$sql=mysql_query("select * from ".POLICYTYPES." where policy_id='".$id."' AND status = '1'"); 
	if(mysql_num_rows($sql))
	{?>
	<select name="policy_type_id" id="policy_type_id" onchange="locadpackage_details(this.value, <?php echo $id?>);" style="width:193px;">
     <option value="">Select Policy Type</option>
	<?php 
	while($policy=mysql_fetch_array($sql))
	{?>
        <option value="<?php echo $policy['id'];?>"><?php echo $policy['policy_type'];?></option>
	<?php 
	}?>
	</select>
	<?php }
	else
	{
		echo 'No Policy Type Found.';
	}
}

if($_GET['task']=='setStatus' && $_GET['status']!='' && $_GET['reqid']!='')
{
	$status=$_GET['status'];
	$id=$_GET['reqid'];
	mysql_query("update ".REQUESTQUOTES." set status='".$status."' where id='".$id."'");
}
if($_GET['quote_id']!='')
{
	$quote_id=$_GET['quote_id'];
	$note=addslashes($_GET['note']);
	mysql_query("update ".QUOTETBL." set emp_note='".$note."' where id='".$quote_id."'");
}
if($_GET['quote_id']!='')
{
	$quote_id=$_GET['quote_id'];
	$note=addslashes($_GET['note']);
	mysql_query("update ".QUOTETBL." set emp_note='".$note."' where id='".$quote_id."'");
}
if($_GET['task']=='setCommision' && $_GET['id']!='')
{
	$id=$_GET['id'];
	$commision=$_GET['commision'];
	$tbl=$_GET['tbl'];
	mysql_query("update ".$tbl." set commision='".$commision."' where id='".$id."'");
}


// NEW UTILS
// Get Next Date
if($_POST['call_type'] == "gettermdates"){
	if($_POST['term'] != "" && $_POST['term_type'] != "" && $_POST['st_date'] != ""){
		echo date("d-m-Y",strtotime(getNextDate($_POST['term'],$_POST['term_type'],$_POST['st_date'])));
	}
}
?>