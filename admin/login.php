<?php
echo get_header("A");
?>

    <?php
if(isset($_POST['sendps']))
{

	$email=$_POST['email'];
	
	$login= mysql_query("SELECT * FROM ksa_admin WHERE mail_id='$email'");
	$rows=mysql_fetch_array($login);
	if(mysql_num_rows($login)!=0)
	{
		
		$email= $rows['mail_id'];
		$adminuid = $rows['id'];
$adminps= mysql_query("SELECT * FROM ksa_login WHERE uid='$adminuid' and user_type in('S','A')");
	
	$adminrows=mysql_fetch_array($adminps);		
		$upw1 = $adminrows['pwd'];
		$password = base64_decode($upw1);
		$to= $_POST['email']; 
		$subject_user = "Password Details Request";
		
		$headers_user  = 'MIME-Version: 1.0' . "\r\n";
  $headers_user .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers_user .="From: ".$from;
  		$message_user= '<table width="100%" cellpadding="3" cellspacing="3">
  <tr><td colspan="2">Your have requested for Your Login details.<br/><br/>Check detais below:<br/></td></tr>

  <tr><td width="16%" align="left"><strong>Email:</strong></td><td width="84%" align="left">'.$email.'</td></tr>
  <tr><td align="left" valign="top"><strong>Password:</strong></td><td align="left">"'.$password.'"</td></tr>
 
  </table>';
 		$sentmail = mail($to,$subject_user,$message_user,$headers_user);
		if($sentmail)
		{
			
			$allmsg =  '<font color="#66FF66">Your password was sent to your email..</font>';
		}else
		{
			$allmsg =  '<font color="#66FF66">Password sending failed</font>';
		}
	}
	else
	{
		$allmsg = '<font color="#008000>you have entered wrong Email Id. Please Try Again.!!</font>';
	}
}
?>	
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo STYLE_SHEET; ?>css.css" rel="stylesheet" type="text/css">
<link href="<?php echo STYLE_SHEET; ?>font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo STYLE_SHEET; ?>bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo STYLE_SHEET; ?>uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo STYLE_SHEET; ?>select2.css" rel="stylesheet" type="text/css">
<link href="<?php echo STYLE_SHEET; ?>select2-metronic.css" rel="stylesheet" type="text/css">
<link href="<?php echo STYLE_SHEET; ?>login.css" rel="stylesheet" type="text/css">
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo STYLE_SHEET; ?>components.css" rel="stylesheet" type="text/css">
<link href="<?php echo STYLE_SHEET; ?>plugins.css" rel="stylesheet" type="text/css">
<link href="<?php echo STYLE_SHEET; ?>layout.css" rel="stylesheet" type="text/css">
<link id="style_color" href="<?php echo STYLE_SHEET; ?>default.css" rel="stylesheet" type="text/css">
<link href="<?php echo STYLE_SHEET; ?>custom.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?php echo BASE_URL;?>images/favicon.ico">
</head>
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<a class="logo-panel" href="<?php //echo site_url(); ?>">
	<img src="<?php echo BASE_URL;?>images/logo-big.png" alt="">
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="" method="post" validate enctype="multipart/form-data">
		<h3 class="form-title">Login to your account</h3>
		
		<?php if($error <> ""){ ?>
		<div class="alert alert-danger">
			<button class="close" data-close="alert"></button>
			<span><?php echo $error; ?> </span>
		</div>
		<?php } ?>
		<?php if($allmsg <> ""){ ?>
		<div class="alert alert-danger">
			<button class="close" data-close="alert"></button>
			<span><?php echo $allmsg; ?> </span>
		</div>
		<?php } ?>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>Enter your username and password. </span>
		</div>
		
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">I Am</label>
			<div class="input-icon">
				<i class="fa fa-users"></i>
				<select name="utype" id="utype" class="form-control inp-pop-dropdown">
				<option value="S">Administrator</option> 
				<option value="E">Employee</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="un">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="pa">
			</div>
		</div>
		<div class="form-actions">
			<label class="checkbox">
			<!--<div class="checker"><span><input type="checkbox" name="remember" value="1"></span></div> Remember me--> </label>
			<button type="submit" class="btn green pull-right" name="login" />
			Login <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<div class="forget-password">
			<h4>Forgot your password ?</h4>
			<p>
				 no worries, click <a href="javascript:;" id="forget-password">
				here </a>
				to reset your password.
			</p>
		</div>
	</form>
	<!-- END LOGIN FORM -->
    <!-- Php code for sending password to email-->
	  
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form class="forget-form" action="" method="post" validate enctype="multipart/form-data">
    	<?php if($allmsg <> ""){ ?>
		<div class="alert alert-danger">
			<button class="close" data-close="alert"></button>
			<span><?php echo $allmsg; ?> </span>
		</div>
		<?php } ?>
		<h3>Forget Password ?</h3>
		<p>
			 Enter your e-mail address below to reset your password.
		</p>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email">
			</div>
		</div>
        
		<div class="form-actions">
      
			<button type="button" id="back-btn" class="btn">
			<i class="m-icon-swapleft"></i> Back </button>
			<button type="submit" class="btn green pull-right" name="sendps" />
	    	Submit <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	 <?php echo date('Y'); ?> &copy;  Alsagr Cooperative. Admin Dashboard.</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script type="text/javascript" async src="<?php echo SCRIPT_JS; ?>login/dc.js"></script><script src="<?php echo SCRIPT_JS; ?>login/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>login/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>login/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>login/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>login/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>login/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>login/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>login/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo SCRIPT_JS; ?>login/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo SCRIPT_JS; ?>login/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo SCRIPT_JS; ?>login/metronic.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>login/layout.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>login/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
		jQuery(document).ready(function() {     
		  Metronic.init(); // init metronic core components
		  Layout.init(); // init current layout
		  Login.init();
		});
	</script>
<!-- END JAVASCRIPTS -->
<!-- END BODY -->
<!-- @end login -->
</body>
</html>