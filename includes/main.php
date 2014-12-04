<?php
$page=$_GET["page"];

 // Other page invokes...
    if(file_exists($files="public/".$page.".php"))
	{
	 
	 if(file_exists("classes/".$page.".class.php"))
	{
	  include_once("classes/".$page.".class.php");
	 }
	  include_once($files);
	}
	else
	{
	 include_once("includes/common.php");
    }

?>