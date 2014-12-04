<?php
//echo $page;
// set content
//echo $_SERVER['REQUEST_URI'];


if($page != "")
{
  if($_SESSION['atype'] != 'S')
  {
    if(getAdminMenuAccess($_GET['page'],$_SESSION['emp_type']) == '1')
    {
       include("public/".$page.".php");
    }
	else
	{
	  include("public/unautorizeaccess.php");
	}
  }
  else
  {
	echo '<div id="body"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td id="left-block" valign="top" width="221">';
    include_once("includes/left-nav.php");
    echo '</td><td valign="top" style="padding-left: 22px;"> '; 
    include("public/".$page.".php");
	echo '</td></tr/></table></div>';
  }
}
else
{
  include("public/".$default.".php");
}


?>