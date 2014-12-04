<?php
// template
/* header */
function get_header($type="U")
{
	global $config;
	
	$temp_header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=';
	$temp_header .= $config['charset'];
	
	$alias=$_GET['page'];
	$menu=mysql_fetch_object(mysql_query("select * from ".PAGEMENU." where allias='$alias' and status ='1'"));
	$page=mysql_fetch_object(mysql_query("select * from ".PAGETBL." where id ='".$menu->menu_assign."' and pg_status = '1'"));
	$article=mysql_fetch_object(mysql_query('select * from '.ARTICLETBL.' where title ="'.str_replace('-',' ',$alias).'" and status = 1'));
	// title switching between admin and user and company
	
	if($type == 'C')
	{
		$title = $config['companytitle'];
		$keyword=$config['keyword'];
		$description=$config['description'];
	}
	else
	{
		if($article)
		{
			$title =$article->title; 
			$keyword=$config['keyword'];
			$description=$config['description'];
		}
		if($page)
		{
			$title =$page->pg_title; 
			$keyword=$page->pg_keyword; 
			$description=$page->pg_desp;
		}
		if(!$page && !$article)
		{ 
			$title = ($type == "A")?$config['admintitle']:$config['title'];
			$keyword=$config['keyword'];
			$description=$config['description'];
		}
	}
	
	$temp_header .= '" /><meta content="'.$keyword.'" name="keywords" />
    <meta content="'.$description.'" name="description" /><title>';
	$temp_header .= $title;
	$temp_header .= '</title>';
	return $temp_header;
}
/* header top */
function get_top()
{
	global $page;
	if($page == "taketest")
	$temp_top = "</head><body onKeyPress='return disableCtrlKeyCombination(event);' onKeyDown='return disableCtrlKeyCombination(event);showKeyCode(event);'>";
	else
	$temp_top = "</head><body onKeyPress='return disableCtrlKeyCombination(event);' onKeyDown='return disableCtrlKeyCombination(event);showKeyCode(event);'>";
	return $temp_top;
}
/* footer */
function get_footer()
{
	$temp_footer = '</body></html>';
	return $temp_footer;
}

	
	function getAdminMenuAccess($page,$emp_type_id)
	{
	  $arry = array();
	  
	  $sql = mysql_query("SELECT * FROM ".SUBMENUTBL." WHERE page = '$page'");
	  if(mysql_num_rows($sql) > 0)
	  {
	    $arr = mysql_fetch_object($sql);
		//echo "SELECT * FROM ".ACCTBL." WHERE submenu = '".$arr->submenu_id."' AND menu = '".$arr->menu_id."' AND emp_id = '".$atype."'";
	    $sqlil = mysql_query("SELECT * FROM ".ACCTBL." WHERE submenu = '".$arr->submenu_id."' AND menu = '".$arr->menu_id."' AND emp_id = '".$emp_type_id."'");
		if(mysql_num_rows($sqlil) > 0)
		{
		  return 1;
		}
		else
		{
		return 0;
		}
	  }else
	  {
	    return 0;
	  }
	
	}
	


/* site header */
function site_header($type = "user")
{
	if($type == "admin"){
	$temp_header = '<div style="margin-top: 10px;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; text-decoration: none; color: #FFF;"><span></div>
    <div class="line" style="margin-top: 10px;"><img src="images/line.jpg" width="347" height="2" /></div>';
	}
	else
	{
		$temp_header = '<img src="images/header.jpg" alt="" width="894" height="217" />';
	}
	return $temp_header;
}
/* site footer */
function site_footer($type = "U")
{
	global $config;
	if($type == "A"){
	$temp_footer = '<div class="footer"><table width="99%" border="0" cellspacing="0" cellpadding="0"><tr><td width="37%">'.$config['copyright'].'</td><td width="23%" align="center">&nbsp;</td><td width="40%" align="right"><!--Powered By <strong>Maastrix Solutions Pvt. Ltd.</strong>--></td></tr></table></div>';
	}
	else
	{
		$temp_footer = 'includes/footer.php';
	}
	return $temp_footer;
}
// Authentication
function siteAuth($utype = 'U')
{
	global $config;
	
	switch($utype)
	{
	  case 'S':  // superadmin
	  $session = $_SESSION[$config['adminsessionid']];
	  break;
	  
	  case 'E':   //Employee
	  $session = $_SESSION[$config['empsessionid']];
	  break;
	  
	  case 'U':  // user
	  $session = $_SESSION[$config['sessionid']];
	  break;
	  
	  case 'C':  // agencies
	  $session = $_SESSION[$config['companysessionid']];
	  break;
	  
	  case 'A':  // agencies
	  $session = $_SESSION[$config['agentsessionid']];
	  break;
	  
	}
	
	if(isset($session) || !empty($session))
	$flag = 1;
	else
	$flag = 2;
	return $flag;
}

// login
function setLogin($un,$pa,$utype = 'U')
{
	global $config;
	if($utype == "S")
	{
	$table=USRTBL;
	}
	if($utype == "E")
	{
	$table=EMPLOYEETBL;
	}
	if($utype == "U")
	{
	$table=USERTBL;
	}
	if($utype == "C")
	{
	$table=COMPANYTBL;
	}
	if($utype == "A")
	{
	$table=AGENTTBL;
	}
	
	$query = "SELECT COUNT(*) AS total,uid,user_type FROM ".LOGINTBL." WHERE uname = '$un' AND pwd = '".base64_encode($pa)."' AND user_type = '$utype' AND is_active = '1' AND uid IN (select id from ".$table.")";
	$sq = mysql_query($query);
	$res = mysql_fetch_object($sq);
	
	if($res->total > 0)
	{
		date_default_timezone_set("Asia/Aden");
		 $cur_date=date('Y-m-d H:i:s');
		mysql_query("UPDATE ".LOGINTBL." SET last_login = '$cur_date',login_status=1 WHERE uname = '$un'");
		switch($utype)
		{
			case 'S':  // Super Admin
			$_SESSION[$config['adminsessionid']] = $res->uid;
			$_SESSION['atype'] = 'S';
			$flag = 1;
			break;
			
			case 'E':  // Employee
			$_SESSION[$config['empsessionid']] = $res->uid;
			$_SESSION['atype'] = 'E';
			$flag = 1;
			break;
			
			
			case 'C':  // Company
			$_SESSION[$config['companysessionid']] = $res->uid;
			$_SESSION['ctype'] = 'C';
			$flag = 1;
			break;
			
			
		  
			case 'U':  // User/ Customer
			$_SESSION[$config['sessionid']] = $res->uid;
			$_SESSION['utype'] = 'U';
			$flag = 1;
			break;
			
			case 'A':  // Agent
			$_SESSION[$config['agentsessionid']] = $res->uid;
			$_SESSION['utype'] = 'A';
			$flag = 1;
			break;
		}
	}
	else
	{
		$flag = 2;
	}
	return $flag;
}
// get user info
function getUser($id = 0,$utype = 'U')
{
	global $config;
	if($utype == "S") // Admin
	{
		if(siteAuth($utype) == 1)
		{
			$uid = ($id != 0)? $id:$_SESSION[$config['adminsessionid']];
			$sq = mysql_query("SELECT c1.*,c2.* FROM ".LOGINTBL." AS c1,".USRTBL." AS c2 WHERE c1.uid = '$uid' AND c1.uid = c2.id AND c1.user_type = '$utype'");
			
			//echo "SELECT c1.*,c2.* FROM ".LOGINTBL." AS c1,".USRTBL." AS c2 WHERE c1.uid = '$uid' AND c1.uid = c2.id AND c1.user_type = '$utype'";
		
		}
	}
	else if($utype == "E") // Employee
	{
	   if(siteAuth($utype) == 1)
	    {
			$uid = ($id != 0)? $id:$_SESSION[$config['empsessionid']];
			$sq = mysql_query("SELECT c1.*,c2.* FROM ".LOGINTBL." AS c1,".EMPLOYEETBL." AS c2 WHERE c1.uid = '$uid' AND c1.uid = c2.id AND c1.user_type = '$utype'");
	  
	    }
	}
	
	else if($utype == "U") // User/Customer
	{
	   if(siteAuth($utype) == 1)
	    {
			$uid = ($id != 0)? $id:$_SESSION[$config['sessionid']];
			$sq = mysql_query("SELECT c1.*,c2.* FROM ".LOGINTBL." AS c1,".USERTBL." AS c2 WHERE c1.uid = '$uid' AND c1.uid = c2.id AND c1.user_type = '$utype'");
	    }
	}
	else if($utype == "C") // Company
	{
	   if(siteAuth($utype) == 1)
	    {
			$uid = ($id != 0)? $id:$_SESSION[$config['companysessionid']];
			$sq = mysql_query("SELECT c1.*,c2.* FROM ".LOGINTBL." AS c1,".COMPANYTBL." AS c2 WHERE c1.uid = '$uid' AND c1.uid = c2.id AND c1.user_type = '$utype'");
	  
	    }
	}
	
	else if($utype == "A") // Agent
	{
	   if(siteAuth($utype) == 1)
	    {
			$uid = ($id != 0)? $id:$_SESSION[$config['agentsessionid']];
			$sq = mysql_query("SELECT c1.*,c2.* FROM ".LOGINTBL." AS c1,".AGENTTBL." AS c2 WHERE c1.uid = '$uid' AND c1.uid = c2.id AND c1.user_type = '$utype'");
	  
	    }
	}
	
	
	if(mysql_num_rows($sq) > 0){$res = mysql_fetch_object($sq); return $res;}
}
function getCustomerInfo($id=0,$utype='U')
{
	$sq = mysql_query("SELECT c1.*,c2.* FROM ".LOGINTBL." AS c1,".USERTBL." AS c2 WHERE c1.uid = '$id' AND c1.uid = c2.id AND c1.user_type = '$utype'");
	if(mysql_num_rows($sq) > 0){$res = mysql_fetch_object($sq); return $res;}		
}

// logout
function setLogout($utype = 'U')
{
	global $config;
	
	if($_SESSION['travel'])
		unset($_SESSION['travel']);

	if($utype == 'S'){   // Super Admin
		$session = $_SESSION[$config['adminsessionid']];
		$sess_type = $_SESSION['atype'];
		
	}elseif($utype == 'A'){   // Agent
		$session = $_SESSION['agid'];
		$sess_type = $_SESSION['utype'];
		
	}elseif($utype =='U'){  // User
		$session = $_SESSION[$config['sessionid']];
		$sess_type = $_SESSION['utype'];
		
	}elseif($utype == 'C'){   // Company
		$session = $_SESSION['cid'];
		$sess_type = $_SESSION['ctype'];
		
		
	}elseif($utype == 'E'){   // Agent
		$session = $_SESSION['empid'];
		$sess_type = $_SESSION['atype'];
		
	}
	// siteAuth('$utype');
	if(isset($session)){
	// update logout time
		mysql_query("UPDATE ".LOGINTBL." SET last_logout = now(),login_status=0 WHERE uid = '".$session."' and user_type ='$utype'");
		//session_destroy();
		 if($utype == 'S'){        // super admin
		   unset($_SESSION['atype']);
		   unset($_SESSION['aid']);
		   
	     }else if($utype == 'E'){  // Employee
		   unset($_SESSION['atype']);
		   unset($_SESSION['empid']);
		   
		 }else if($utype == 'C'){  // Company
		   unset($_SESSION['ctype']);
		   unset($_SESSION['cid']);
		   
		 }elseif($utype == 'A'){  //Agent
		   unset($_SESSION['utype']);
		   unset($_SESSION['agid']);
		   
	     }elseif($utype =='U'){   //  User
		   unset($_SESSION['utype']);
		   unset($_SESSION['uid']);
	     }
		
	}
	
}
function checkLogins(){
	if(($_SESSION['atid'] != '') && ($_SESSION['aid'] != '')){
		$flag = 2;
	}else{
		$flag = 1;
	}
	return $flag;
	
}
// forgot password
function forgotPass($un,$utype = 'U')
{
	global $config;
	if($type == 'M'){
	//echo "SELECT $field FROM ".$config['usertable']." WHERE username = '".$un."'";
	$sqq = mysql_query("SELECT pwd FROM ".AGTBL." WHERE email_id = '".$un."'");
	if(mysql_num_rows($sqq) > 0){
	$res = mysql_fetch_object($sqq);

	// message body
	$msg = "Dear User,<br><br>Your requested password info is given below.<br>--------------------------------------<br>username: ".$un."<br>Password: ".base64_decode($res->pwd)."<br>--------------------------------------<br><br>Best Regards,<br>".$config['teamtitle'];
	return sendMail($un,"Password Recovery - ".$config['msgsub_suffix'],$msg);
	}else{
	return 2;
	}}
	else
	{
	//echo "SELECT $field FROM ".$config['usertable']." WHERE username = '".$un."'";
	$sqq = mysql_query("SELECT pwd FROM ".LOGINTBL." WHERE uname = '".$un."'");
	if(mysql_num_rows($sqq) > 0){
	$res = mysql_fetch_object($sqq);

	// message body
	$msg = "Dear User,<br><br>Your requested password info is given below.<br>--------------------------------------<br>username: ".$un."<br>Password: ".base64_decode($res->pwd)."<br>--------------------------------------<br><br>Best Regards,<br>".$config['teamtitle'];
	return sendMail($un,"Password Recovery - ".$config['msgsub_suffix'],$msg);
	}else
	{
	return 2;
	}
	}
}


function setMailContentAgent($data, $content)
{
	//echo '<pre>'; print_r($data); echo '</pre>'; exit;
	$result=$content;
	if($data['0']!='')
		$result = str_replace('{fname}', $data['0'], $result);
	if($data['1']!='')
		$result = str_replace('{companyname}', $data['1'], $result);
	if($data['2']!='')
		$result = str_replace('{siteurl}', $data['2'], $result);
	if($data['3']!='')
		$result = str_replace('{username}', $data['3'], $result);
	if($data['4']!='')
		$result = str_replace('{password}', $data['4'], $result);
	
	//echo $result;	
	return $result;
}


// send mail
function sendMail($to,$subject,$message,$from = SITE_EMAIL)
{
	// header
	// To send HTML mail, the Content-type header must be set
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= 'From: '.$from . "\r\n";
	$headers .= "From: Broker Vision <".$from.">\r\n";

	$site_fullpath = realpath(dirname(__FILE__));
	$site_path= str_replace('config','',$site_fullpath);
	$templet_path=$site_path.'template';

	$file=$templet_path."/ksa_mail_sent.html";
	if(LANG=='ar')
		$file=$templet_path."/ksa_mail_sent_ar.html";
	$fp=fopen($file,'r');
	$vcontent=fread($fp,filesize($file));
	$content=ereg_replace('mnmfmfmg',$message,$vcontent);

	$content=$content;
	// send mail
	$flag = (mail($to,$subject,$content,$headers) == true)?1:0;
	return $flag;	
}
function sendMail1($to,$subject,$message,$from = SITE_EMAIL)
{
	// header
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

	// Additional headers
	$headers .= 'From: '.$from . "\r\n";
	
	
	
	// send mail
	$flag = (mail($to,$subject,$message,$headers) == true)?1:0;
	return $flag;	
}

// page CMS controller
function pageInfo()
{
	global $config;
	if($config['page'] != "" && $config['allias'] != ""){
	$result = array();
	if($config['super_allias'] == "callout"){
		// chech for page allias
	$chk_allias = mysql_fetch_object(mysql_query("SELECT COUNT(*) AS total,id FROM nfa_callout WHERE title = '".str_replace("-"," ",trim($config['allias']))."'"));
	if($chk_allias->total > 0){
			$sq = mysql_query("SELECT * FROM nfa_callout WHERE id = '".$chk_allias->id."'");
			if(mysql_num_rows($sq) > 0)
			{
				$res = mysql_fetch_assoc($sq);
				$result[0] = "";
				$result[1] = "";
				$result[2] = "";
				$result[3] = $res;
				return $result;
			}
		}
		return 0;
	}
	// check for menu allias
	$chk_allias = mysql_fetch_object(mysql_query("SELECT COUNT(*) AS total,menu_assign FROM ".PAGEMENU." WHERE allias = '".$config['allias']."'"));
	if($chk_allias->total > 0){
		$sq = mysql_query("SELECT c1.*,c2.menu_id,c2.menu_title,c2.allias,c2.menu_parent FROM ".PAGETBL." AS c1,".PAGEMENU." AS c2 WHERE c1.id = '".$chk_allias->menu_assign."' AND c1.pg_status='1' AND c1.id = c2.menu_assign");
		if(mysql_num_rows($sq) > 0)
		{
			$res = mysql_fetch_assoc($sq);
			$result[0] = $res;
			return $result;
		}
		else
		{
			$sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE allias='".$config['allias']."'");
			if(mysql_num_rows($sq) > 0)
			{
				$res = mysql_fetch_assoc($sq);
				$result[0] = "";
				$result[1] = $res;
				return $result;
			}
		}
	}
	// chech for page allias
	$chk_allias = mysql_fetch_object(mysql_query("SELECT COUNT(*) AS total,id FROM ".PAGETBL." WHERE pg_title = '".str_replace("-"," ",trim($config['allias']))."'"));
	if($chk_allias->total > 0){
		$sq = mysql_query("SELECT * FROM ".PAGETBL." WHERE id = '".$chk_allias->id."'");
		if(mysql_num_rows($sq) > 0)
		{
			$res = mysql_fetch_assoc($sq);
			$result[0] = "";
			$result[1] = "";
			$result[2] = $res;
			return $result;
		}
	}
	return 0;
	}else{
	return 0;
	}
}
function breadcomb($title,$parent,$type)
{
	global $config;
	global $db;
	if($type == "page"){
		$breadcomb = array();
		$default = "<a href='".BASE_URL.HOME_PATH."' class='bluee11'>Home</a> > ";
		array_push($breadcomb,$default);
		if($parent != 0){
			$parent_title = $db->recordFetch($parent,PAGETBL.":".'id');
			//$parent_link = "<a href='".BASE_URL.str_replace(" ","-",$parent_title['pg_title'])."' class='bluee11'>".ucwords($parent_title['pg_title'])."</a> > ";
			$parent_link = "<a class='grey11'>".ucwords($parent_title['pg_title'])."</a> > ";
			array_push($breadcomb,$parent_link);
		}
		if($title != ""){
			$title = "<a class='grey11'>".ucwords($title)."</a>";
			array_push($breadcomb,$title);
		}
	}
	if($type == "menu"){
		$breadcomb = array();
		$default = "<a href='".BASE_URL.HOME_PATH."' class='bluee11'>Home</a> > ";
		array_push($breadcomb,$default);
		if($parent != 0){
			$parent_title = $db->recordFetch($parent,PAGEMENU.":".'menu_id');
			//$parent_link = "<a href='".BASE_URL.$parent_title['allias']."' class='bluee11'>".ucwords($parent_title['menu_title'])."</a> > ";
			$parent_link = "<a class='grey11'>".ucwords($parent_title['menu_title'])."</a> > ";
			array_push($breadcomb,$parent_link);
		}
		if($title != ""){
			$title = "<a class='grey11'>".ucwords($title)."</a>";
			array_push($breadcomb,$title);
		}
	}
	
	// get breadcomb
	return implode("",$breadcomb);
}
// populate data to the fields
function getElementVal( $element, $datalist )
{
	return $datalist[$element];
}
function links($res)
{
	if($res["menu_link"]!='')
	{
		$link=str_replace("'","",$res["menu_link"]);
	}else
	{
		$link=  str_replace("'","",$res["allias"]);
	}
	return $link;	
}
function test_menu($id)
{
	$sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_position = '1' AND menu_parent <> '' AND status = '1'");
	if(mysql_num_rows($sq) > 0)
	{
		while($res = mysql_fetch_array($sq)){
		$pos=$res["menu_parent"];
			if($pos==$id)
			{
				return 1;
			}
	}
	}

}
function main_menu($place)
{
	$sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_position = '1' AND status = '1' order by ordering asc");
	//echo "SELECT * FROM ".PAGEMENU." WHERE menu_position = '1' AND status = '1' order by menu_id asc";
	if(mysql_num_rows($sq) > 0)
	{ //echo LANG;
		while($res = mysql_fetch_array($sq))
		{
			$menu_title = $res['menu_title'];
			$BASE_URL = BASE_URL;
			if(LANG == 'ar')
				$menu_title = $res['menu_title_ar'];
				
			$pos=$res["menu_parent"];
			$user_type = $res["menu_user"];
			$link=links($res);
			$aces=$res["menu_access"];
			//echo $link;
			
			if($res["menu_id"] == '22')
			{
				if ($_GET['page'] == '')
				{
					$var_status='class="selected"';
				}
				if ($_GET['page'] == 'user-dashboard')
				{
					$var_status='class="selected"';
				}
				
				$var_img="<img  src='".SITE_URL."images/icon_home_menu.png' />&nbsp; ";
			}
			else if ($link == $_GET['page'])
			{
			   $var_status='class="selected"';
			}
			else
			{
			
			  $var_status="";
			 
			}
				
			if(($aces==1 || $aces==2) && ($_SESSION['uid'] != '' || $_SESSION['agid'] != ''))
			{    
				if($place == 'top')
				{
					if($res["menu_id"] == '22')
					{
					    if($_SESSION['uid'] != ''){
						echo '<li><a href="'.$BASE_URL.'user-dashboard" '.$var_status.'>';
						}else if ($_SESSION['agid'] != ''){
						echo '<li><a href="'.$BASE_URL.'agent-dashboard" '.$var_status.'>';
						}
						// 
						if(LANG == 'ar'){echo "&#1604;&#1608;&#1581;&#1577; &#1571;&#1580;&#1607;&#1586;&#1577; &#1575;&#1604;&#1602;&#1610;&#1575;&#1587;";}else{echo "Dashboard";}

				  		//echo "Dashboard";
				  		echo '</a></li>';
					}
					else if($res["menu_id"] == '2')
					{
					   if($_SESSION['agid'] == ''){
					   
							echo '<li><a href="#" '.$var_status.'>';
							echo $menu_title;
							echo '</a>';
							echo submenu();
							echo '</li>';
						}
					}
					else
					{
						echo '<li><a href="'.$BASE_URL.$link.'"'.' '.$var_status.'>';
						echo $menu_title;
						echo '</a></li>';
					}
				}
				else if($place == 'bottom') 
				{
					echo '<a href="'.$BASE_URL.$link.'">'.$menu_title.'</a> |';
				}
			}
			else if(($aces==0 || $aces==2) && ($_SESSION['uid'] == ''))
			{
				if($place == 'top')
				{
				   if($res["menu_id"] == '2')
					{
						echo '<li><a href="#" class="active">';
				  		echo $menu_title;
				  		echo '</a>';
						echo submenu();
						echo '</li>';
					}else{
						echo '<li><a href="'.$BASE_URL.$link.'"'.' '.$var_status.'>';
						echo $menu_title;
						echo '</a></li>';
				   	}
				    
				}
				else if($place == 'bottom') 
				{
					echo '<a href="'.$BASE_URL.$link.'">'.$menu_title.'</a> | ';
				}
			}
		}
	}
}


function submenu()
{
  $sql = mysql_query("SELECT * FROM ".CATEGORY." WHERE status = '1' order by id asc");

  $return = "";
  if(mysql_num_rows($sql) > 0)
  {
  $return.= '<ul style="display: none; top: 40px; visibility: visible;">';
  
  while($arr=mysql_fetch_array($sql))
  {
    //if(LANG == 'en'){$cat_name = $arr['cat_name']; $SITE_URL = SITE_URL;}else{ $cat_name = $arr['cat_name_ar']; $SITE_URL = SITE_URL_AR;}
	
	$cat_name = $arr['cat_name'];
	$SITE_URL = SITE_URL;
	if(LANG == 'ar')
		$cat_name = $arr['cat_name_ar'];
	
	$sql2 = mysql_query("SELECT * FROM ".SUBCATEGORY." WHERE cat_id = '".$arr['id']."' AND Status = '1'");
	if(mysql_num_rows($sql2) > 0)
	{
	  $return.= '<li><a href="#">'.$cat_name.'</a>';
	  $return.= '<ul style="display: none; top: 40px; visibility: visible;">';
	  while($arr2 = mysql_fetch_assoc($sql2))
	  {
	  //  if(LANG == 'ar'){$subcat_name = $arr2['subcat_name_ar'];}else{ $subcat_name = $arr2['subcat_name'];}
	  
	$subcat_name = $arr2['subcat_name'];
	if(LANG == 'ar')
		$subcat_name = $arr2['subcat_name_ar'];
	  
	    if(strpos(strtolower($arr2['subcat_name']),'insurance')!== false){$add_stn = "";}else{$add_stn = "-insurance";}
		 
		 if(strpos(strtolower($arr2['subcat_name']),'agent')!== false){
			 
	       if($_SESSION['agid'] != ''){$lgnn = "agent-dashboard";}else{$lgnn = "login";}
		   if(!$_SESSION['uid'])
		  	 $return.= '<li><a href="'.$SITE_URL.$lgnn.'">'.$subcat_name.'</a></li>';
		   
		 }else{
		   $return.= '<li><a href="'.$SITE_URL.trim(strtolower(str_replace(" ","-",$arr2['subcat_name']))).$add_stn.'">'.$subcat_name.'</a></li>';
		 }
	    
	  }
	  $return.= '</ul>';
	}else{
	   $return.= '<li><a href="'.$SITE_URL.trim(strtolower(str_replace(" ","-",$arr['cat_name']))).'">'.$cat_name.'</a>';
	}
	$return.= '</li>';
  }
  $return.= '</ul>';
  }
  return $return;
}


function footer_menu($id)
{
if($id!= 0)
{
$sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_position = '3' AND status = '1' and footer_menu_position = '".$id."' order by ordering asc");
}else{
$sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_position = '1'  AND  footer_menu_position = '1' AND status = '1' and ((menu_id != '5') && (menu_id != '3')) order by ordering asc");
}

	$num=mysql_num_rows($sq);
	$i=1;
	$fncyid = '';
	if($num > 0)
	{
	while($res = mysql_fetch_array($sq)){
	
	    //if(LANG == 'en'){$menu_title = $res["menu_title"]; $BASE_URL = BASE_URL;}else{$menu_title = $res["menu_title_ar"]; $BASE_URL = BASE_URL_AR;}
		
		$menu_title = $res['menu_title'];
		$BASE_URL = BASE_URL;
		if(LANG == 'ar')
			$menu_title = $res['menu_title_ar'];
		
		$link=links($res);
		$aces=$res["menu_access"];
		if(($aces==1 || $aces==2) && ($_SESSION['uid'] != ''))
				{
				  if($id == '2')
				  {
				   echo '<li><a href="'.$BASE_URL.$link.'">'.$menu_title.'</a></li>';
				   if($num != $i){echo '<li>|</li>';}
				  }else{
				   echo '<li><a href="'.$BASE_URL.$link.'">'.$menu_title.'</a></li>';
				  }    
			     
		        }
			    else if(($aces==0 || $aces==2) && ($_SESSION['uid'] == ''))
				{
				  if($id == '2')
				  {
				    echo '<li><a href="'.$BASE_URL.$link.'">'.$menu_title.'</a></li>';
				   if($num != $i){echo '<li>|</li>';}
				  }else{
				   echo '<li><a href="'.$BASE_URL.$link.'">'.$menu_title.'</a></li>';
				  } 
				}
			$i++;}
}
}



function midFooter()
{
 $sqlss = mysql_query("SELECT * FROM ".CATEGORY." WHERE status = '1' order by id asc");
						  $return = "";
						  if(mysql_num_rows($sqlss) > 0)
						  {
						   while($arrss=mysql_fetch_array($sqlss))
						   { 
						   //if(LANG == 'en'){$cat_name = $arrss['cat_name']; $BASE_URL = BASE_URL;}else{$cat_name = $arrss['cat_name_ar']; $BASE_URL = BASE_URL_AR;}
						   
							$cat_name = $arrss['cat_name'];
							$BASE_URL = BASE_URL;
							if(LANG == 'ar')
								$cat_name = $arrss['cat_name_ar'];
						   
						   if($arrss['cat_name'] == 'Auto Insurance'){
						   $return.='<li><a href="'.$BASE_URL.'comprehensive-insurance">'.$cat_name.'</a></li>';
						   }else if($arrss['cat_name'] == 'Group Insurance'){
						   $return.='<li><a href="'.$BASE_URL.'corporate-insurance">'.$cat_name.'</a></li>';
						   }else{
							$return.='<li><a href="'.$BASE_URL.strtolower(str_replace(" ","-",$arrss['cat_name'])).'">'.$cat_name.'</a></li>';
							}
						   }
						   }
						   return $return;

}

function show_profile_pic1($id,$class)// Used for favorite AD
{
	($id=='')?$id=$_SESSION['uid']:'';
    $file=get_value('profile_pic',MEMBERTBL,$id);
	$gender=get_value('gender',MEMBERTBL,$id);
	

	if(!file_exists("images/avatar/resize_image/".$file) || ($file==''))
	{
        
		if($gender == 'F')
		{
		$file='thumb_user_nophoto_female.png';
		}else{
		$file='thumb_user_nophoto_male.png';
		}
	}
	$img_src=IMG_PATH.'avatar/'.$file;
    echo '<img class="'.$class.'" src="'.$img_src.'" />';
}


function find_date($tb1_name,$data,$iid,$id)
{
	$ss=mysql_query("select $data from $tb1_name where $iid='".$id."'");
	
	$ssq=mysql_fetch_array($ss);
	return $ssq[$data];
	
	
}

function footer_menu_right($id=0){
if($id!= 0)
{
$sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_position = '3' AND status = '1' and footer_menu_position = '".$id."' order by ordering asc");
}	
	$num=mysql_num_rows($sq);
	$i=1;
	if($num > 0)
	{
	while($res = mysql_fetch_array($sq)){
		$link=links($res);
		$aces=$res["menu_access"];
		
			if($aces==0 || $aces==2)
			{
				echo '<a href="'.BASE_URL.$link.'">';
		       if($i!=1){echo " | ";} echo $res["menu_title"]."</a>";
			}
	
	$i=$i+1; }
	}
	}
/*generates a random code*/
function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
}

function getState($id,$abbr = 0)
{
   $ss=mysql_query("select * from ".PAGESTA." where state_id='".$id."'");
   $ssq=mysql_fetch_array($ss);
   if($abbr == 1)
   {
      return $ssq['abbrev'];
   }else
   {
    return $ssq['state_name'];
   }
  
}
function getCountry($id,$abbr = 0)
{
   $ss=mysql_query("select * from ".PAGECON." where country_id = '".$id."'");
   $ssq=mysql_fetch_array($ss);
   if($abbr == 1)
   {
     return $ssq['iso'];
   }else
   {
    return $ssq['printable_name'];
   }
}
function getCity($id,$abbr = 0)
{
   $ss=mysql_query("select * from ".PAGECITY." where city_id = '".$id."'");
   $ssq=mysql_fetch_array($ss);
   if($abbr == 1)
   {
     return $ssq['iso'];
   }else
   {
    return $ssq['city_name'];
   }
}
function getLast_login($id , $type){
	$date = array_shift(mysql_fetch_array(mysql_query("select last_logout from ".LOGINTBL." where uid = '$id' and user_type = '$type'")));
	$time = date('Y-m-d', strtotime($date));
	if($date == '0000-00-00 00:00:00'){
		$out = '...';
	}else if($time == date('Y-m-d')){
		$out = date('h:i:s A',strtotime($date));
	}
	else{
		$out = date('m/d/Y',strtotime($date));
	}
	return $out;
}

function getSessionStatus($type = 'U')
{
	 global $config;
	 if($type == 'A')
	 {
	 
	  if(isset($_SESSION['agid']) && !empty($_SESSION['agid']))
	     {
	         return 1;
	     }
	     else{ 
			 header("location:".BASE_URL);
			 return 2;
	    }
	 
	 }else if ($type == 'U')
	 {
	     if(isset($_SESSION['uid']) && !empty($_SESSION['uid']))
	     {
	         return 1;
	     }
	     else{ 
			 header("location:".BASE_URL);
			 return 2;
	    }
	 }
	
}
function getCustomerSessionStatus()
{
	 global $config;
	 if(isset($_SESSION['uid']) && !empty($_SESSION['uid']))
	 {
	   return 1;
	 }
	 else{ 
	   header("location:".BASE_URL);
	   return 2;
	 }
 
}
function get_value($field,$tbl,$pkey_value,$pkey='id')
{
	return @array_shift(mysql_fetch_array(mysql_query("select $field from $tbl where $pkey='$pkey_value' limit 1")));
}

function get_values($tbl,$pkey_value,$pkey='id')
{
	return mysql_fetch_object(mysql_query("select * from $tbl where $pkey='$pkey_value' limit 1"));
}
function get_ad($tbl,$pkey_value,$pkey='id')
{
	return mysql_fetch_object(mysql_query("select * from $tbl where $pkey='$pkey_value' order by 'id' limit 1"));
}
function remove_qs_key($url, $key) {
	$url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $url);
	return $url;
}






function createPwd($characters) {
                /* list all possible characters, similar looking characters and vowels have been removed */
                $possible = '23456789bcdfghjkmnpqrstvwxyz';
                $code = '';
                $i = 0;
                while ($i < $characters) {
                        $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
                        $i++;
                }
                return $code;
}

function reference_id()
{
	$resno=mysql_query("Select cust_id from bv_user order by id desc");
	if(mysql_num_rows($resno)==0)
	$res="CUS10001";
	else
	{
	$no=mysql_fetch_row($resno);
	$resnum=explode("CUS",$no[0]);
	//print_r($resnum);
	$res=$resnum[1]+1;
	$res="CUS".$res;
	}

return $res;
}




	// random number generator
	function randomPrefix($length,$table,$field)
	{
		global $db;	
		$random= "";
		srand((double)microtime()*1000000);
		$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
		$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
		$data .= "0FGH45OP89";
		for($i = 0; $i < $length; $i++)
		{
			$random .= substr($data, (rand()%(strlen($data))), 1);
		}
		$query="select $field from $table where $field='$random'";
		$res=mysql_query($query);
		if(mysql_num_rows($res)>0)
		{
			randomPrefix($length,$table,$field);
		}
		else
		{
			return $random;	
		}
    }

	
	
	function getAge($iTimestamp){ 
    $iAge = date('Y') - date('Y', $iTimestamp);  
    if(date('n') < date('n', $iTimestamp)){ 
        return --$iAge; 
    }  
    elseif(date('n') == date('n', $iTimestamp)){ 
        if(date('j') < date('j', $iTimestamp)){ 
            return $iAge - 1; 
        }  
        else{ 
            return $iAge; 
        } 
    }else
	{ 
        return $iAge; 
    } 
    }





	
	function dateDiffOnly($day_1,$day_2)
    {
      $diff = strtotime($day_2) - strtotime($day_1) + 1; //Find the number of seconds
      $day_difference = round($diff / (60*60*24)) ;  //Find how many days that is
      return $day_difference;
    }
	
	function getEmailTemplate($id) 
	{
	   $sql = mysql_fetch_array(mysql_query("SELECT * FROM ".EMAILTEMP." WHERE id = '$id'"));
	   $sdf = array();
	   array_push($sdf,stripslashes($sql['subject']),stripslashes($sql['body']));
	   return $sdf;
	}
	
	 function GetSiteText($id)
	{
	  $sql = array_shift(mysql_fetch_array(mysql_query("SELECT body FROM ".SITETEXT." WHERE id = '$id'")));
	  return stripslashes($sql);
	}
	
	function getVehicleMake($id)
	{
		$make=mysql_fetch_assoc(mysql_query("select make from ".VMAKE." where id=".$id));
		return stripslashes($make['make']);
	}
	
	function getVehicleModel($id)
	{
		$make=mysql_fetch_assoc(mysql_query("select model from ".VMODEL." where id=".$id));
		return stripslashes($make['model']);
	}
	
	function getPartnerOfMonth()
	{
		$partners=mysql_fetch_assoc(mysql_query("select * from ".COMPANYTBL." where partner_of_month=1"));
		return $partners;
	}
	function getPromotions($comp_id = 0)
	{
		if($comp_id != '' || $comp_id != '0')
		{
			//$sql=mysql_query("select * from ".PROMOTION." where status=1");
		$sql=mysql_query("select * from ".OFFERS." where status = '1' AND ((from_date <= CURDATE()) && (to_date >= CURDATE())) AND comp_id = '".$comp_id."' AND ((comp_policy_id in (SELECT comp_policy_id FROM ".AUTOPOLICY." where status ='1' and del_status='0')) OR (comp_policy_id in (SELECT comp_policy_id FROM ".HEALTHPOLICY." where status ='1' and del_status='0')) OR (comp_policy_id in (SELECT comp_policy_id FROM ".MALPRACTICEPOLICY." where status ='1' and del_status='0')) OR (comp_policy_id in (SELECT comp_policy_id FROM ".TRAVELPOLICY." where status ='1' and del_status='0'))) order by RAND() LIMIT 0,2");
		}else{
			//$sql=mysql_query("select * from ".PROMOTION." where status=1");
		$sql=mysql_query("select * from ".OFFERS." where status = '1' AND ((from_date <= CURDATE()) && (to_date >= CURDATE())) AND comp_id in (SELECT uid FROM ".LOGINTBL." WHERE is_active = '1' AND user_type = 'C') AND ((comp_policy_id in (SELECT comp_policy_id FROM ".AUTOPOLICY." where status ='1' and del_status='0')) OR (comp_policy_id in (SELECT comp_policy_id FROM ".HEALTHPOLICY." where status ='1' and del_status='0')) OR (comp_policy_id in (SELECT comp_policy_id FROM ".MALPRACTICEPOLICY." where status ='1' and del_status='0')) OR (comp_policy_id in (SELECT comp_policy_id FROM ".TRAVELPOLICY." where status ='1' and del_status='0'))) order by RAND() LIMIT 0,2");
		}
		
		//echo "select * from ".OFFERS." where status = '1' AND ((from_date < CURDATE()) && (to_date > CURDATE())) order by RAND() LIMIT 0,5";
		return $sql;
	}
	
	function getCorpAmt($val)
	{
	  if($_POST[$val] == '1'){
         $_POST[$val.'_amt'] = $_POST[$val.'_amt'];
	  }else{
        $_POST[$val.'_amt']  = "";
     }
	 return $_POST[$val.'_amt'];
	   
	}
	
	function getCorpNote($val)
	{
	  if($_POST[$val] == '1'){
         
	     $_POST[$val.'_note'] = addslashes($_POST[$val.'_note']);
     }else{
       
	    $_POST[$val.'_note'] = "";
     }
	 return $_POST[$val.'_note'];
	   
	}
	
	function getAutoPolicyType($id)
	{
	    //echo "select coverage_type from ".AUTOPOLICY." where id=".$id; 
		$type=mysql_fetch_assoc(mysql_query("select coverage_type from ".AUTOPOLICY." where id=".$id));
		if($type['coverage_type']=='tpl')
			$type='tpl';
		if($type['coverage_type']=='comp')
			$type='comprehensive';
		return $type;
	}
	
	function getCompanyDetails($id)
	{
		$res=mysql_fetch_assoc(mysql_query("select * from ".COMPANYTBL." where id=".$id));
		return $res;
	}
	
	function getCountryName($id)
	{
		$res=mysql_fetch_assoc(mysql_query("select country from ".COUNTRY." where id=".$id));
		if(LANG=='ar')
			return $res['country_ar'];
		else
			return $res['country'];
	}
	
	function getStateName($id)
	{
		$res=mysql_fetch_assoc(mysql_query("select state from ".STATE." where id=".$id));
		if(LANG=='ar')
			return $res['state_ar'];
		else
			return $res['state'];
	}
	
	function getPolicyAmount($id, $tbl)
	{
		$sql = "select policy_amount from ".$tbl." where comp_policy_id = '".$id."'";
		$res=mysql_fetch_array(mysql_query($sql));
		return $res['policy_amount'];
	}
	
	function getCoverageType($id)
	{
		if($id=='1')
			$res='Worldwide including US and Canada';
		if($id=='2')
			$res='Worldwide excluding US and Canada';
		if($id=='3')
			$res='Regional';
		if($id=='4')
			$res='Local';
		return $res;
	}
	
	function getOfferDetail($id)
	{
		$res=mysql_fetch_assoc(mysql_query("SELECT * FROM ".OFFERS." WHERE id = '".$id."'"));
		return $res;
	}
	
	function calculatePayment($amount, $discount)
	{
		$discount_amount=($amount*$discount)/100;
		$res=number_format($amount-$discount_amount,2);
		return $res;
	}
	
	function autoPolicyType($policy_no)
	{
		$res=mysql_fetch_assoc(mysql_query("select coverage_type from ".USERAUTOPOLICY." where policy_no='".$policy_no."'"));
		if($res['coverage_type']=='tpl')
			return 'TPL';
		if($res['coverage_type']=='comp')
			return 'Comprehensive';
	}
	function getUserName($id)
	{
		$res=mysql_fetch_assoc(mysql_query("select * from ".USERTBL." where id='".$id."'"));
		return stripslashes($res['fname']).' '.stripslashes($res['lname']);
	}
	function getAgentName($id)
	{
		$res=mysql_fetch_assoc(mysql_query("select * from ".AGENTTBL." where id='".$id."'"));
		return stripslashes($res['ag_fname']).' '.stripslashes($res['ag_lname']);
	}
	function getCompanyIdFromPolicyId($id)
	{
			
			$sql=mysql_query("select * from ".AUTOPOLICY." where comp_policy_id='".$id."'");
			if(mysql_num_rows($sql) > 0)
			{
				$row=mysql_fetch_array($sql);
				return 	$row['comp_id'];
			}
			else 
			{
				$sql=mysql_query("select * from ".HEALTHPOLICY." where comp_policy_id='".$id."'");
				if(mysql_num_rows($sql) > 0)
				{
					$row=mysql_fetch_array($sql);
					return 	$row['comp_id'];
				}
				else
				{
					$sql=mysql_query("select * from ".MALPRACTICEPOLICY." where comp_policy_id='".$id."'");
					if(mysql_num_rows($sql) > 0)
					{
						$row=mysql_fetch_array($sql);
						return 	$row['comp_id'];
					}	
					else
					{
							$sql=mysql_query("select * from ".TRAVELPOLICY." where comp_policy_id='".$id."'");
							if(mysql_num_rows($sql) > 0)
							{
								$row=mysql_fetch_array($sql);
								return 	$row['comp_id'];
							}
							else
							{
								return '0';	
							}
					}
				}	
			}
	}
	
function getCommision($id, $tbl)
{
	$commision=mysql_fetch_assoc(mysql_query("select commision from ".$tbl." where id=".$id));
	return $commision['commision'];
}
function getPaymentId($policy_no)
{
	$res=mysql_fetch_assoc(mysql_query("select max(id) as maxid from ".PAYMENTS." where policy_id=".$policy_no));
	return $res['maxid'];
}

function getNumberOfPolicy()
{
	if($_SESSION['cid'] && (strpos(BASE_URL, 'corporate')==true))
	{
		$sql="select a.* from ".USERPOLICY." as a inner join ".USERTRAVELPOLICY." as b on a.policy_no=b.policy_no where b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".USERPOLICY." as a inner join ".USERHEALTHPOLICY." as b on a.policy_no=b.policy_no where b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".USERPOLICY." as a inner join ".USERMALPRACTICEPOLICY." as b on a.policy_no=b.policy_no where b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".USERPOLICY." as a inner join ".USERAUTOPOLICY." as b on a.policy_no=b.policy_no where b.comp_id='".$_SESSION['cid']."'";
		$total=mysql_num_rows(mysql_query($sql));
	}
	else
	{
		if($_SESSION['uid'])
			$whr=" where uid='".$_SESSION['uid']."'";
		if($_SESSION['agid'])
			$whr=" where agent_id='".$_SESSION['agid']."'";
		$res=mysql_fetch_assoc(mysql_query("select count(*) as total from ".USERPOLICY.$whr)); 
		$total=$res['total'];
	}
	return $total;
}

function getTotalRenewalPolicy()
{
	if($_SESSION['cid'] && (strpos(BASE_URL, 'corporate')==true))
	{
		$sql="select a.* from ".RENEWPOLICY." as a inner join ".USERTRAVELPOLICY." as b on a.policy_no=b.policy_no where b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".RENEWPOLICY." as a inner join ".USERHEALTHPOLICY." as b on a.policy_no=b.policy_no where b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".RENEWPOLICY." as a inner join ".USERMALPRACTICEPOLICY." as b on a.policy_no=b.policy_no where b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".RENEWPOLICY." as a inner join ".USERAUTOPOLICY." as b on a.policy_no=b.policy_no where b.comp_id='".$_SESSION['cid']."'";
		$total=mysql_num_rows(mysql_query($sql));
	}
	else
	{
		if($_SESSION['agid'])
		{
			$sql="select count(*) as total from ".RENEWPOLICY." as a inner join ".PAYMENTS." as b on a.policy_no=b.policy_id where b.payment_by_id='".$_SESSION['agid']."' and b.payment_by_type='A' and b.renew_id!='0'";
			//$sql="select count(*) as total from ".RENEWPOLICY." as a inner join ".AGENTPOLICY." as b on a.policy_no=b.policy_id where b.agent_id='".$_SESSION['agid']."'";
		}
		if($_SESSION['uid'])
			$sql="select count(*) as total from ".RENEWPOLICY." where uid='".$_SESSION['uid']."'";
			
		$res=mysql_fetch_assoc(mysql_query($sql));
		$total=$res['total'];
	}
	return $total;
}

function getTotalPayments()
{
	if($_SESSION['cid'] && (strpos(BASE_URL, 'corporate')==true))
	{
		$sql="select a.* from ".PAYMENTS." as a inner join ".USERTRAVELPOLICY." as b on a.policy_id=b.policy_no where b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".PAYMENTS." as a inner join ".USERHEALTHPOLICY." as b on a.policy_id=b.policy_no where b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".PAYMENTS." as a inner join ".USERMALPRACTICEPOLICY." as b on a.policy_id=b.policy_no where b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".PAYMENTS." as a inner join ".USERAUTOPOLICY." as b on a.policy_id=b.policy_no where b.comp_id='".$_SESSION['cid']."'";
		$total=mysql_num_rows(mysql_query($sql));
	}
	else
	{
		if($_SESSION['uid'])
			$id=$_SESSION['uid'];
		if($_SESSION['agid'])
			$id=$_SESSION['agid'];
			
		$whr=" where payment_by_id='".$id."' and policy_id!=''";
		$res=mysql_fetch_assoc(mysql_query("select count(*) as total from ".PAYMENTS.$whr));
		$total=$res['total'];
	}
	return $total;
}

function getTotalActivePolicy()
{
	if($_SESSION['cid'] && (strpos(BASE_URL, 'corporate')==true))
	{
		$sql="select a.* from ".USERPOLICY." as a inner join ".USERTRAVELPOLICY." as b on a.policy_no=b.policy_no where a.status='1' and b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".USERPOLICY." as a inner join ".USERHEALTHPOLICY." as b on a.policy_no=b.policy_no where a.status='1' and b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".USERPOLICY." as a inner join ".USERMALPRACTICEPOLICY." as b on a.policy_no=b.policy_no where a.status='1' and b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".USERPOLICY." as a inner join ".USERAUTOPOLICY." as b on a.policy_no=b.policy_no where a.status='1' and b.comp_id='".$_SESSION['cid']."'";
		$total=mysql_num_rows(mysql_query($sql));
	}
	else
	{
		if($_SESSION['uid'])
			$whr=" and uid='".$_SESSION['uid']."'";
		if($_SESSION['agid'])
			$whr=" and agent_id='".$_SESSION['agid']."'";
		
		$res=mysql_fetch_assoc(mysql_query("select count(*) as total from ".USERPOLICY." where status='1'".$whr));
		$total=$res['total'];
	}
	return $total;
}

function getTotalExpiredPolicy()
{
	if($_SESSION['cid'] && (strpos(BASE_URL, 'corporate')==true))
	{
		$sql="select a.* from ".USERPOLICY." as a inner join ".USERTRAVELPOLICY." as b on a.policy_no=b.policy_no where a.status='0' and b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".USERPOLICY." as a inner join ".USERHEALTHPOLICY." as b on a.policy_no=b.policy_no where a.status='0' and b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".USERPOLICY." as a inner join ".USERMALPRACTICEPOLICY." as b on a.policy_no=b.policy_no where a.status='0' and b.comp_id='".$_SESSION['cid']."' UNION select a.* from ".USERPOLICY." as a inner join ".USERAUTOPOLICY." as b on a.policy_no=b.policy_no where a.status='0' and b.comp_id='".$_SESSION['cid']."'";
		$total=mysql_num_rows(mysql_query($sql));
	}
	else
	{
		if($_SESSION['uid'])
			$whr=" and uid='".$_SESSION['uid']."'";
		if($_SESSION['agid'])
			$whr=" and agent_id='".$_SESSION['agid']."'";
		
		$res=mysql_fetch_assoc(mysql_query("select count(*) as total from ".USERPOLICY." where status='0'".$whr));
		$total=$res['total'];
	}
	return $total;
}

function setMailContent($data, $content)
{
	//echo '<pre>'; print_r($data); echo '</pre>'; exit;
	$result=$content;
	if($data['0']!='')
		$result = str_replace('{fname}', $data['0'], $result);
	if($data['1']!='')
		$result = str_replace('{username}', $data['1'], $result);
	if($data['2']!='')
		$result = str_replace('{password}', $data['2'], $result);
	//echo $result;	
	return $result;
}

function getNews()
{
	$res=mysql_fetch_assoc(mysql_query("select * from ".TBLNEWS." where status='1' order by rand() limit 0, 1"));	
	$title=$res['title'];
	if(LANG == 'ar')
		$title=$res['title_ar'];
	return substr($title,0,100);
}

function getFlagLink()
{
	$domain = $_SERVER['HTTP_HOST'];
	$http = ($_SERVER['HTTPS'] ? 'https://' : 'http://');
	$url = $http . $domain . $_SERVER['REQUEST_URI'];
	return $url;
}



function sitemap_menu($id)
{
if($id!= 0)
{
$sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_position = '3' AND status = '1' and footer_menu_position = '".$id."' order by ordering asc");
}else{
$sq = mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_position = '1'  AND  footer_menu_position = '1' AND status = '1' and ((menu_id != '5') && (menu_id != '3')) order by ordering asc");
}

	$num=mysql_num_rows($sq);
	$i=1;
	$fncyid = '';
	if($num > 0)
	{
	while($res = mysql_fetch_array($sq)){
	
	    //if(LANG == 'en'){$menu_title = $res["menu_title"]; $BASE_URL = BASE_URL;}else{$menu_title = $res["menu_title_ar"]; $BASE_URL = BASE_URL_AR;}
		
		$menu_title = $res['menu_title'];
		$BASE_URL = BASE_URL;
		if(LANG == 'ar')
			$menu_title = $res['menu_title_ar'];
		
		$link=links($res);
		$aces=$res["menu_access"];
		if(($aces==1 || $aces==2) && ($_SESSION['uid'] != ''))
				{
				  if($id == '2')
				  {
				   echo '<li><a href="'.$BASE_URL.$link.'">'.$menu_title.'</a></li>';
				   if($num != $i){echo '<li><a href="#">I</a></li>';}
				  }else{
				   echo '<div class="sitemapcontent"><a href="'.$BASE_URL.$link.'">'.$menu_title.'</a></div>';
				  }    
			     
		        }
			    else if(($aces==0 || $aces==2) && ($_SESSION['uid'] == ''))
				{
				  if($id == '2')
				  {
				    echo '<li><a href="'.$BASE_URL.$link.'">'.$menu_title.'</a></li>';
				   if($num != $i){echo '<li><a href="#">I</a></li>';}
				  }else{
				   echo '<div class="sitemapcontent"><a href="'.$BASE_URL.$link.'">'.$menu_title.'</a></div>';
				  } 
				}
			$i++;}
}
}


function midsitemap()
{
 $sqlss = mysql_query("SELECT * FROM ".CATEGORY." WHERE status = '1' order by id asc");
						  $return = "";
						  if(mysql_num_rows($sqlss) > 0)
						  {
						   while($arrss=mysql_fetch_array($sqlss))
						   { 
						   //if(LANG == 'en'){$cat_name = $arrss['cat_name']; $BASE_URL = BASE_URL;}else{$cat_name = $arrss['cat_name_ar']; $BASE_URL = BASE_URL_AR;}
						   
							$cat_name = $arrss['cat_name'];
							$BASE_URL = BASE_URL;
							if(LANG == 'ar')
								$cat_name = $arrss['cat_name_ar'];
						   
						   if($arrss['cat_name'] == 'Auto Insurance'){
						   $return.='<div class="sitemapcontent"><a href="'.$BASE_URL.'comprehensive-insurance">'.$cat_name.'</a></div>';
						   }else if($arrss['cat_name'] == 'Group Insurance'){
						   $return.='<div class="sitemapcontent"><a href="'.$BASE_URL.'corporate-insurance">'.$cat_name.'</a></div>';
						   }else{
							$return.='<div class="sitemapcontent"><a href="'.$BASE_URL.strtolower(str_replace(" ","-",$arrss['cat_name'])).'">'.$cat_name.'</a></div>';
							}
						   }
						   }
						   return $return;

}

function getPageContent($alias)
{
	$menu=mysql_fetch_object(mysql_query("select * from ".PAGEMENU." where allias='$alias' and status ='1'"));
	$page=mysql_fetch_object(mysql_query("select * from ".PAGETBL." where id ='".$menu->menu_assign."' and pg_status = '1'"));
	$page_detail=$page->pg_detail;
	if(LANG == 'ar')
		$page_detail=$page->pg_detail_ar;
		
	if(strlen($page_detail) > 90)
	return substr(strip_tags(stripslashes($page_detail)),0,90)." .......";
	else
	return  strip_tags(stripslashes($page_detail));
}

function getJobOpportunity()
{
	$cdate=date('Y-m-d');
	$sql = mysql_query("SELECT * FROM ".JOBOPPORTUNITY." WHERE status = '1' and display_date <='".$cdate."' and expiry_date >= '".$cdate."' order by rand() LIMIT 0,1");
	return $sql;
}
function homePageMidImages($position)
{
	$sql = mysql_query("SELECT image FROM ".HOMEMIDIMAGES." WHERE position = '".$position."' AND status = '1'");
	if(mysql_num_rows($sql) > 0)
	{
		$img = array_shift(mysql_fetch_array($sql));
		$image_url = BASE_URL."upload/homepage_image/".$img;
		
	}else{
	$image_url = BASE_URL."images/prod_ico.png";	
	}
	return $image_url;
}
function canDeleteCustomer($cust_id)
{
    $sql=mysql_query("select * from ".USERPOLICY." where uid='".$cust_id."' and policy_no in (select policy_id from ".PAYMENTS.")");    if(mysql_num_rows($sql)>0)
    {
	
	return 0;//This can be deleted
    }
    else
    {
	return 1;//This cannot be deleted
    }

}
function canDeleteAgent($agent_id) 
{
    $sql=mysql_query("select * from ".POLICYCUSTOMERS." where broker_id='".$agent_id."' ");    
	if(mysql_num_rows($sql)>0)
    {
		return 0;//This can be deleted
    }
    else
    {
		return 1;//This cannot be deleted
    }
}
	
//function to display banners in homepage
if ( ! function_exists( 'show_siteText' ) ) :
function show_siteText($id,$type){
	global $wpdb;
	$query = mysql_query("SELECT * from ".TBLPRE."site_text  where id='".$id."'")or die(mysql_error());
	$result=mysql_fetch_object($query);
	return	stripslashes($result->$type);
}
endif;	





/* NEW FUNCTIONS */
if( !function_exists('getNextDate') ):
// code creator
function getNextDate($term,$term_type,$start_date)
{
	$startdate = date("Y-m-d",strtotime($start_date));
    $nextdate = date('Y-m-d', strtotime($startdate. '+'.$term.' '.$term_type));
	return $nextdate;
}
endif;

if( !function_exists('get_code') ):
// code creator
function get_code($table,$ufield,$record_id,$whre="")
{
    if($whre!= ''){
		$sq = mysql_query("SELECT MAX($ufield) AS scode FROM $table $whre ORDER BY $record_id DESC LIMIT 0,1");
	}else{
		$sq = mysql_query("SELECT MAX($ufield) AS scode FROM $table ORDER BY $record_id DESC LIMIT 0,1");
	}
	
	// get code
	$res = mysql_fetch_object($sq);
	$s_code = $res->scode;
	if(isset($s_code)){
		$scode = $s_code + 1;
	}else{
		$scode = "100001";
	}
	return $scode;
}
endif;

if( !function_exists('ucodeGen') ):
// unique Code generator
function ucodeGen($table,$ufield,$record_id,$prefix,$suffixlen,$whre="")
{
    if($whre!= ''){
		$sq = mysql_query("SELECT MAX($ufield) AS scode FROM $table $whre ORDER BY $record_id DESC LIMIT 0,1");
	}else{
		$sq = mysql_query("SELECT MAX($ufield) AS scode FROM $table ORDER BY $record_id DESC LIMIT 0,1");
	}
	if(mysql_num_rows($sq) > 0)
	{
		// get max scheme code
		$res = mysql_fetch_object($sq);
		$s_code = $res->scode;
		$s_code = str_replace($prefix,"",$s_code);
		$s_code = $s_code + 1;

		$slen = $suffixlen - strlen($s_code);
		if($slen > 0){	
		for($j = 0; $j < $slen; $j++)
		{
			$sj .= "0";
		}
		$s_suffix = $sj.$s_code;
		}else{
		$s_suffix = $sj.$s_code;
		}
		 
		$scode = $prefix.$s_suffix;
	}
	else
	{
		for($j = 0; $j < $suffixlen-1; $j++)
		{
			$sj .= "0";
		}
		$s_suffix = $sj."1";
		$scode = $prefix.$s_suffix;
	}
	return $scode;
}
endif;

function flash( $name = '', $message = '', $class = 'success fadeout-message' )
{
    //We can only do something if the name isn't empty
    if( !empty( $name ) )
    {
        //No message, create it
        if( !empty( $message ) && empty( $_SESSION[$name] ) )
        {
            if( !empty( $_SESSION[$name] ) )
            {
                unset( $_SESSION[$name] );
            }
            if( !empty( $_SESSION[$name.'_class'] ) )
            {
                unset( $_SESSION[$name.'_class'] );
            }
 
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        }
        //Message exists, display it
        elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
        {
            $class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
            echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}
?>