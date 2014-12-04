<?php 
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");
include_once("../../classes/dbFactory.php");
include_once("../../paging/pagination.php");

if(isset($_POST['chk_uname']) && ($_POST['type'] == 'admin')) // checking uname for admin
{
	$no=$_REQUEST['chk_uname'];
	if($_REQUEST['id'])
		$whr=" and uid!='".$_REQUEST['id']."'";
	$rs=mysql_query("select uname from ".LOGINTBL." where uname='$no' AND user_type = 'S'".$whr);
	
	if(mysql_num_rows($rs) > 0)
	{
		echo 'ERROR';
	}
	else{
		echo 'OK';
	}
}

if(isset($_POST['chk_uname']) && ($_POST['type'] == 'company')) // checking uname for company
{
	$no=$_REQUEST['chk_uname'];
	if($_REQUEST['id'])
		$whr=" and uid!='".$_REQUEST['id']."'";
	$rs=mysql_query("select uname from ".LOGINTBL." where uname='$no' AND user_type = 'C'".$whr);
	
	if(mysql_num_rows($rs) > 0)
	{
		echo 'ERROR';
	}
	else{
		echo 'OK';
	}
}
if(isset($_POST['chk_uname']) && ($_POST['type'] == 'customer')) // checking uname for customer
{
	$no=$_REQUEST['chk_uname'];
	$rs=mysql_query("select uname from ".LOGINTBL." where uname='$no' AND user_type = 'U' and uid!=".$_REQUEST['user_id']);
	
	if(mysql_num_rows($rs) > 0)
	{
		echo 'ERROR';
	}
	else{
		echo 'OK';
	}
}


if(isset($_POST['chk_uname']) && ($_POST['type'] == 'agent')) // checking uname for Agent
{
	$no=$_REQUEST['chk_uname'];
	if($_REQUEST['id'])
		$whr=" and uid!='".$_REQUEST['id']."'";
		
	$rs=mysql_query("select uname from ".LOGINTBL." where uname='$no' AND user_type = 'A'".$whr);
	
	if(mysql_num_rows($rs) > 0)
	{
		echo 'ERROR';
	}
	else{
		echo 'OK';
	}
}

if(isset($_POST['chk_uname']) && ($_POST['type'] == 'user')) // checking uname for User
{
	$no=$_REQUEST['chk_uname'];
	$rs=mysql_query("select uname from ".LOGINTBL." where uname='$no' AND user_type = 'U'");
	if($no=="")
	{
	  echo 'ERROR1';	
    }
	elseif(mysql_num_rows($rs) > 0)
	{
		echo 'ERROR';
	}
	else{
		echo 'OK';
	}
}



if(isset($_POST['chk_uname']) && ($_POST['type'] == 'employee')) // checking uname for Employee
{
	$no=$_REQUEST['chk_uname'];
	if($_REQUEST['id'])
		$whr=" and uid!='".$_REQUEST['id']."'";
	$rs=mysql_query("select uname from ".LOGINTBL." where uname='$no' AND user_type = 'E'".$whr);
	
	if(mysql_num_rows($rs) > 0)
	{
		echo 'ERROR';
	}
	else{
		echo 'OK';
	}
}

if(isset($_POST['chk_email']) && ($_POST['type'] == 'company'))  // checking email for company
{
	$no=$_REQUEST['chk_email'];
	if($no == '')
	{
	echo "BLANK";
	}else
	{
		if($_REQUEST['id'])
				$whr=" and id!='".$_REQUEST['id']."'";
		$rs=mysql_query("select comp_email from ".COMPANYTBL." where comp_email='$no'".$whr);
		
		if(mysql_num_rows($rs) > 0)
		{
			echo 'ERROR';
		}
		else{
			echo 'OK';
		}
	}
}

if(isset($_POST['chk_email']) && ($_POST['type'] == 'admin'))  // checking email for admin
{
	$no=$_REQUEST['chk_email'];
	if($no == '')
	{
	echo "BLANK";
	}else
	{
		if($_REQUEST['id'])
				$whr=" and id!='".$_REQUEST['id']."'";
		$rs=mysql_query("select mail_id from ".USRTBL." where mail_id='$no'".$whr);
		
		if(mysql_num_rows($rs) > 0)
		{
			echo 'ERROR';
		}
		else{
			echo 'OK';
		}
	}
}

if(isset($_POST['chk_email']) && ($_POST['type'] == 'agent'))  // checking email for agent
{
	$no=$_REQUEST['chk_email'];
	if($no == '')
	{
	echo "BLANK";
	}else
	{
		if($_REQUEST['id'])
			$whr=" and id!='".$_REQUEST['id']."'";
		$rs=mysql_query("select ag_email from ".AGENTTBL." where ag_email = '$no'".$whr);
		
		if(mysql_num_rows($rs) > 0)
		{
			echo 'ERROR';
		}
		else{
			echo 'OK';
		}
	}
}

if(isset($_POST['chk_email']) && ($_POST['type'] == 'user'))  // checking email for user
{
	$no=$_REQUEST['chk_email'];
	$id=$_REQUEST['id'];
	if($no=='')
	{
	  echo 'BLANK';
	}
	if($id)
		$rs=mysql_query("select email from ".USERTBL." where email = '$no' and id!='".$id."'");
	else
		$rs=mysql_query("select email from ".USERTBL." where email = '$no'");
	
	if(mysql_num_rows($rs) > 0)
	{
		echo 'ERROR';
	}
	else{
		echo 'OK';
	}
	
}

if(isset($_POST['chk_email']) && ($_POST['type'] == 'customer'))  // checking email for customer
{
	$no=$_REQUEST['chk_email'];
	$id=$_REQUEST['user_id'];
	$rs=mysql_query("select email from ".USERTBL." where email = '$no' and id!='".$id."'");
	
	
	if(mysql_num_rows($rs) > 0)
	{
		echo 'ERROR';
	}
	else{
		echo 'OK';
	}
	
}



if(isset($_POST['chk_email'])&& ($_POST['type'] == 'employee')) // checking email for employee
{
	$no=$_REQUEST['chk_email'];
	if($no == '')
	{
	echo "BLANK";
	}else
	{
		if($_REQUEST['id'])
				$whr=" and id!='".$_REQUEST['id']."'";
		$rs=mysql_query("select emp_email from ".EMPLOYEETBL." where emp_email='$no'".$whr);
		
		if(mysql_num_rows($rs) > 0)
		{
			echo 'ERROR';
		}
		else{
			echo 'OK';
		}
	}
}

if(isset($_POST['policy_Id']) && !empty($_POST['ptypeid'])) // checking uname for User
{
	$policyid=$_REQUEST['policy_Id'];
	$ptypeid = $_REQUEST['ptypeid'];
	$rs=mysql_query("select * from ".PRODUCTS." where  policy_class_id = '$policyid' AND policy_type_id='$ptypeid'");
	if(mysql_num_rows($rs) >0)
	{
	  echo 1;	
    }
	else{
		echo 0;
	}
}


?>