<?php 


if(!empty($_GET['logoff']) && $_GET['logoff'] == 1)
{
	if(isset($_SESSION['uid']))
	{
		$todaytime = date('Y-m-d H:i:s');
		$update_login = $db->recordUpdate(array("uid" => $_SESSION['uid']),array('last_logout'=>$todaytime,'login_status'=>'0'),LOGINTBL);
		unset($_SESSION['uid']);
		unset($_SESSION['uname']);
		unset($_SESSION['uemail']);
	}
	header("location:index.php?page=sign-in&logout=1");
}

if(isset($_SESSION['uid']) && empty($_GET['logoff']))
{
	header("location:index.php?page=user-dashboard");
}

if(!empty($_GET['logout']) && $_GET['logout'] == 1)
{
	$msg ="sucessfully logged out";
}
if(isset($_POST['save']))
{
	
	$username= $_POST['uname'];
	$paswd = $_POST['password'];
	$check_user = mysql_query("select * from ".LOGINTBL." WHERE uname ='".$username."' AND pwd = '".base64_encode($paswd)."' ");

	if(mysql_num_rows($check_user) >0)
	{
		$userlogininfo = mysql_fetch_object($check_user);

		$userinfo = mysql_fetch_object(mysql_query("select * from ".USERTBL." where id='".$userlogininfo->uid."' limit 1 "));
		$todaytime = date('Y-m-d H:i:s');
		$update_login = $db->recordUpdate(array("id" => $userlogininfo->id),array('last_login'=>$todaytime,'login_status'=>'1'),LOGINTBL);
		$_SESSION['uid'] =  $userinfo->id;
		$_SESSION['uname'] =  $userinfo->fname;
		$_SESSION['uemail'] =  $userinfo->email;
		header("location:index.php?page=user-dashboard");
	}else{
		$errmsg = "Incorrect login credentials";	
	}
	
}


?>
<script type="application/javascript" >
function val_form()
{
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var str = document.quotation_form;
	var error = "";
	var flag = false;
	var dataArray = new Array();
	if(str.uname.value == "" || str.password.value == "")
	{
		if(str.uname.value == "")
		{
			str.uname.style.borderColor = "RED";
			str.uname.focus();
			document.getElementById("errmsg").innerHTML='Enter Username';
			return false;
		}
		else
		{
			str.uname.style.borderColor = "";
		}
		if(str.password.value == "")
		{
			str.password.style.borderColor = "RED";
			str.password.focus();
			document.getElementById("errmsg").innerHTML='Enter Password';
			return false;
		}
		else
		{
			str.password.style.borderColor = "";
		}
	}else
	{
		document.getElementById("quotation_form").submit();
		
	}
}
</script>
<div id="signup-form">

<!--BEGIN #subscribe-inner -->
		<div><span id="msgss" style=" font-size:12px;color:#093;"><?php if(isset($msg)){ echo $msg;} ?></span></div>
        <div id="signup-inner">
        	<div class="clearfix" id="header">
                <h1>Sign in </h1>
                </div>
                 <form id="quotation_form" name="quotation_form" action=""   method="post">            
                <p>
                <label for="Username">Username or email *</label>
               <input name="uname" type="text" id="uname" tabindex="3" autocomplete="off" value=""  />
                </p>
                 <p>
                <label for="lname">Password *</label>
                 <input name="password" type="password" id="password" tabindex="3" autocomplete="off" value=""  />
                </p>
                <div><span id="errmsg" style=" font-size:12px;color:#900;"><?php if(isset($errmsg)){ echo $errmsg;} ?></span></div>
                <div style="float:right;"><span id="errmsg" style=" font-size:12px;color:#900;"><a href="index.php?page=sign-up">Sign up Now</a></span></div>
              <input type="hidden" name="save" id="save" />
               <input type="button" onClick="val_form();"  value="Sumbit"  name="save" id="save"  />
                </form>
            </div>
         </div>
 <!--END #signup-inner -->
</div>