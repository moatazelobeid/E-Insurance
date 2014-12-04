<?php  
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");

if(isset($_REQUEST['id']))
{
	if($_POST['id']=="")
	{
		echo '<span style="color:red">&nbsp;Enter User Name</span>';
	}
	else
	{
		$rs=mysql_query("select uname from ".LOGINTBL." where uname='".$_POST['id']."'")or die(mysql_error());
		if(mysql_num_rows($rs)>0)
		{
			//echo 'ERROR';
			echo '<span style="color:red">&nbsp;Not Available.</span>';
		}
		else
		{
			//echo 'OK';
			echo '<span style="color:green">&nbsp;Available.</span>';
		}
	}
}
?>