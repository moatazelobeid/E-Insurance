<?php
error_reporting(1);
// database
if($_SERVER['HTTP_HOST'] == "localhost"){
	// database connection for xampp,wampp,lamp - localhost
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$db = "alsagr";
	$site_link = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
	$request_uri = str_replace(dirname($_SERVER['REQUEST_URI'])."/","",$_SERVER['REQUEST_URI']);
	$site_folder = "products/";
	$admin_folder = "admin/";
	//$corporate_folder = "corporate/";
}else if($_SERVER['HTTP_HOST'] == "192.168.1.29"){
	// database connection for localhost if the system is shared with other users
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$db = "alsagr";
	$site_link = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
	$request_uri = str_replace(dirname($_SERVER['REQUEST_URI'])."/","",$_SERVER['REQUEST_URI']);
	$site_folder = "products/";
	$admin_folder = "admin/";
	//$corporate_folder = "corporate/";
}else{
	$dbhost = "localhost";
	$dbuser = "alsagrinsurance";
	$dbpass = "Alsagr123456!";
	$db = "alsagrinsurance";
	$site_link = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
	$site_folder = "products/";
	$admin_folder = "admin/";
	//$corporate_folder = "corporate/";
}
// Identifier 
$link = mysql_connect($dbhost,$dbuser,$dbpass);
if(!$link)
echo "Connection Failed!";
else
mysql_select_db($db,$link) or die("ERROR: ".mysql_error());

// constants
if(strstr($_SERVER['REQUEST_URI'],"admin"))
{
	define(BASE_URL,"http://".$_SERVER['HTTP_HOST']."/".$site_folder.$admin_folder);
	//echo BASE_URL;
}
else if(strstr($_SERVER['REQUEST_URI'],"corporate/"))
{
	define(BASE_URL,"http://".$_SERVER['HTTP_HOST']."/".$site_folder.$corporate_folder);
}
else
{
	define(BASE_URL,"http://".$_SERVER['HTTP_HOST']."/".$site_folder);
}

$sq_var1="select * from ksa_config WHERE cid='1' ";
$data1=mysql_query($sq_var1);
$rs_var=mysql_fetch_array($data1);

/*if(strstr($_SERVER['REQUEST_URI'],"/ar/"))
{
	define(LANG,"ar");
}else{
    define(LANG,"en");
}
*/

if($_SESSION['lang'])
	define(LANG,"ar");
else
	define(LANG,"");
//echo LANG;



define(HOME_USER,"home.php"); 
define(HOME_PATH,"index.php"); 
define(ADMIN_PATH,"index.php");
define(CUSTOMER_PATH,"index.php");
define(ADMIN_HOME,"account.php");
define(UPLOAD_PATH,BASE_URL."upload/");
define(IMG_PATH,BASE_URL."images/");
define(LOGO_IMG,IMG_PATH."logo.png");
define(STYLE_SHEET,BASE_URL."css/");
define(SCRIPT_JS,BASE_URL."js/");
define(SCRIPT_SPRY,BASE_URL."plugins/SpryAssets/");
define(FANCY_SHEET,BASE_URL."plugins/fancybox/");
define(ADMIN_FANCY_SHEET,"../plugins/fancybox/");
define(LIGHTBOX,"lightbox/");
define(ADMIN_PAGING_SHEET,"../paging/");
define(SITE_EMAIL,$rs_var['site_email']);
define(VENDOR_EMAIL,"geniuskakesh@gmail.com");
define(TBLPRE,"ksa_");
define(APP_PAGE,basename($_SERVER['REQUEST_URI']));
define(SITE_URL,"http://".$_SERVER['HTTP_HOST']."/products/");
define(SITE_NAME,$rs_var['site_name']);
define(CURRENCY,"SR");

//get and define mottor setting variables
$motorsqlvar="select * from ksa_motor_settings WHERE id='1' ";
$motordatas=mysql_query($motorsqlvar);
$motorsetng=mysql_fetch_array($motordatas);
define(CARCOST_START_RANGE,$motorsetng['car_cost_frm']);
define(CARCOST_END_RANGE,$motorsetng['car_cost_to']);
define(ADDITIONALPERCENTAGE,$motorsetng['addn_percnt_cost_tpl']);
define(ADDITIONALPERCENTAGECOMP,$motorsetng['addn_percnt_cost_comp']);
define(COMP_PREMIUM_CAR_VALUE_PERCENT,$motorsetng['comp_prem_car_val_percent']);
define(MIN_COMP_PREMIUM_AMT,$motorsetng['min_comp_prem_amt']);

define(MAX_COMP_PREMIUM_AMT,$motorsetng['max_comp_prem_amt']);

define(MAX_AGENCY_REPAIR_COST,$motorsetng['max_agncy_repr_cost']);
define(PREM_CLAIM_PERCENT,$motorsetng['prem_grtr_claim_percnt']);
define(CLAIM_PREM_PERCENT,$motorsetng['claim_grtr_prem_percnt']);
define(ADD_DEDUCT_AMT,$motorsetng['addn_deduct_amnt']);


// query string params
@$page = $_GET['page'];
@$task = $_GET['task'];
@$action = $_GET['action'];
@$id = $_GET['id'];
@$option = $_GET['option'];
$default = "default";

// template


$config = array();
$config['charset'] = "utf-8"; 
$config['title'] = stripslashes($rs_var['default_title']);
$config['keyword'] = stripslashes($rs_var['default_keywords']);
$config['description'] = stripslashes($rs_var['meta_tag']);
$config['page'] = $_GET['page'];
$config['allias'] = $_GET['pid'];
$config['group_allias'] = $_GET['gid'];
$config['super_allias'] = $_GET['sid'];
$config['admintitle'] = "Alsagr Cooperative : Admin";
$config['companytitle'] = "Alsagr Cooperative : Admin Login";
$config['sessionid'] = "uid";        // general user 
$config['adminsessionid'] = "aid";   // Super Admin 
$config['empsessionid'] = "empid";   // Employee 
$config['companysessionid'] = "cid"; // Insurance Company
$config['agentsessionid'] = "agid"; // Insurance Company
$config['company_name'] = "Alsagr Cooperative";
$config['msgsub_suffix'] = "Alsagr Cooperative";
$config['teamtitle'] = "Alsagr Cooperative Team";
$config['copyright'] =  $rs_var['copyright_info'];
if(LANG == 'ar')
	$config['copyright'] =  $rs_var['copyright_info_ar'];
$config['footerText'] = "";
$config['option_default'] = "<span style='font-weight: bold; line-height: 18px;'>OOPS!! This page not found!<br>We think this page might be down or not avialable in the server.<br>Please try again! Or,<br>Contact Site Administrator.</span>";

?>