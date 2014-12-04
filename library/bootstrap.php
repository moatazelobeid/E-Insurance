<?php
// constants
if(!strstr($_SERVER['REQUEST_URI'],"admin") || !strstr($_SERVER['REQUEST_URI'],"ar"))
{
	include_once("config/session.php");
	include_once("config/config.php");
	require_once("config/tables.php");
	include_once("config/functions.php");
}
else 
{
	include_once("../config/session.php");
	include_once("../config/config.php");
	require_once("../config/tables.php");
	include_once("../config/functions.php");
}

?>