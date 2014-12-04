<?php
// includes
include_once("../config/session.php");
include_once("../config/config.php");
include_once("../config/tables.php");
include_once("../config/functions.php");
include_once("../classes/dbFactory.php");
// call class instance
$db = new dbFactory();
include_once("../paging/pagination.php");
include_once("../paging/ftr_pagging.php");
// check page status

if(siteAuth($_SESSION['atype']) == 2){
	header("location:index.php?log=1");
}
//print_r($_SESSION);exit;
// get user info
$user = getUser('',$_SESSION['atype']);
echo get_header($_SESSION['atype']);
?>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo STYLE_SHEET; ?>css.css" rel="stylesheet" type="text/css">
<link href="<?php echo STYLE_SHEET; ?>font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->

<link href="<?php echo STYLE_SHEET; ?>admin_account.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SCRIPT_JS; ?>jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery-1.7.2.min.js"></script>

<script src="<?php echo SCRIPT_JS; ?>jquery.validate.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery-ui-1.8.21.custom.min.js"></script>
<link type="text/css" href="<?php echo SITE_URL;?>css/smoothness/jquery-ui-1.8.21.custom.css" rel="stylesheet" />


<script src="<?php echo SCRIPT_JS; ?>rmenu.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_JS; ?>rmenu_display.js" type="text/javascript"></script>
<link href="<?php echo STYLE_SHEET; ?>rmenu.css" rel="stylesheet" type="text/css" />
<link href="<?php echo STYLE_SHEET; ?>dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?php echo STYLE_SHEET; ?>ddlevelsmenu-base.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STYLE_SHEET; ?>ddlevelsmenu-topbar.css" />
<link rel="stylesheet" type="text/css" href="../paging/style1.css" />
<script type="text/javascript" src="<?php echo SCRIPT_JS; ?>ddlevelsmenu.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_JS; ?>jquery.jclock.js"></script>
<link rel="stylesheet" href="<?php echo SCRIPT_JS; ?>jqcalender/jquery.ui.core.css">
<link rel="stylesheet" href="<?php echo SCRIPT_JS; ?>jqcalender/jquery.ui.datepicker.css">
<link rel="stylesheet" href="<?php echo SCRIPT_JS; ?>jqcalender/jquery.ui.theme.css">
<script src="<?php echo SCRIPT_JS; ?>jqcalender/jquery.ui.core.js"></script>
<script src="<?php echo SCRIPT_JS; ?>jqcalender/jquery.ui.widget.js"></script>
<script src="<?php echo SCRIPT_JS; ?>jqcalender/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_JS; ?>dhtmlgoodies_calendar.js"></script>
<script src="<?php echo SCRIPT_JS; ?>SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="<?php echo SCRIPT_JS; ?>SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

<!--<script type="text/javascript" src="fancybox/jquery.box.js"></script>
    <link href="fancybox/fancybox.css" rel="stylesheet" type="text/css"  media="screen" />
-->
<script type="text/javascript" src="<?php echo BASE_URL; ?>fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript">
function createCookie(name,value,days) 
    {
        if ( days) 
        {
                var date = new Date( );
                date.setTime( date.getTime( )+( days*24*60*60*1000));
                var expires = "; expires="+date.toGMTString( );
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }
function readCookie(name) 
    {
        var nameEQ = name + "=";
        var ca = document.cookie.split( ';');
        for( var i=0;i < ca.length;i++) 
        {
                var c = ca[i];
                while ( c.charAt( 0)==' ') c = c.substring( 1,c.length);
                if ( c.indexOf( nameEQ) == 0) return c.substring( nameEQ.length,c.length);
        }
        return null;
    }
    
</script>
<script type="text/javascript">
function closePanel()
{
	var str = document.getElementById('rmenu').style.display;
	if(str == "block")
	{
		document.getElementById('rmenu').style.display = "none";
		document.getElementById('appmain').style.width = "955px";
	}
	if(str == "none")
	{
		document.getElementById('rmenu').style.display = "block";
		document.getElementById('appmain').style.width = "755px";
	}
}

$(document).ready(function() {

$('.calender').datepicker({
inline: true,
dateFormat: "dd-mm-yy",
minDate : 0
});

$('.calender2').datepicker({
inline: true,
dateFormat: "dd-mm-yy",
});
	
$('.dob').datepicker({
	inline: true,
	yearRange: "-100:+0", 
	dateFormat: "dd-mm-yy",
	changeMonth:true,
	changeYear:true,
});

$('#dob').datepicker({
	inline: true,
	yearRange: "-100:+0", 
	dateFormat: "dd-mm-yy",
	changeMonth:true,
	changeYear:true,
});
$('.claim').datepicker({
	inline: true,
	yearRange: "-5:+0", 
	dateFormat: "dd-mm-yy",
	changeMonth:true,
	changeYear:true,
});

$("a#box1").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 460, 
'frameHeight' : 550,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'

   });
   
 $("a#box1_policy").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 750, 
'frameHeight' : 550,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'

   });
$("a#boxadmin").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 450, 
'frameHeight' : 280,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
$("a#boxadmin1").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 450, 
'frameHeight' : 200,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
 $(document).ready(function() {
		$("a#show_artadmin").fancybox({
		'opacity'		: true,
		'overlayShow'	: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'none'
	});
});
$("a#box2").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 400, 
'frameHeight' : 600,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
$("a#imgview").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 400, 
'frameHeight' : 600,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
   $("a#box3").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 900, 
'frameHeight' : 400,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
$("a#fancy").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 500, 
'frameHeight' : 310,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
$("a#fancy_policy").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 720, 
'frameHeight' : 410,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
$("a#fancy_framing").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 500, 
'frameHeight' : 310,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000',
'onClosed': function() { parent.location.reload(); }
   });
$("a#fancyblog").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 500, 
'frameHeight' : 310,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
$("a#answer").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 500, 
'frameHeight' : 500,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });

$("a#fancy2").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' 			: 500, 
'frameHeight' 			: 400,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
   $("a#fancy1").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' 			: 500, 
'frameHeight' 			: 150,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
    $("a#shippingadd").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' 			: 500, 
'frameHeight' 			: 200,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
	
	 $("a#orderquery").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' 			: 400, 
'frameHeight' 			: 400,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
	  $("a#sendemail").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' 			: 600, 
'frameHeight' 			: 300,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
	    $("a#itemdetails").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' 			: 700, 
'frameHeight' 			: 400,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
   $("a#enquery").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' 			: 500, 
'frameHeight' 			: 200,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
$("a#pdetail").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 600, 
'frameHeight' : 500,
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });
$("a.newsdetails").fancybox({ 
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth'			: 	 500, 
'frameHeight'			: 	 300,
'overlayShow'           :    true, 	
'overlayOpacity'		:	 0.8,
'overlayColor'			:	 '#000'
});

$("a.postcomment").fancybox({ 
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth'			: 	 550, 
'frameHeight'			: 	 400,
'overlayShow'           :    true, 	
'overlayOpacity'		:	 0.8,
'overlayColor'			:	 '#000'
});
$("a#add_cattofaq").fancybox({ 
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth'			: 	 370, 
'frameHeight'			: 	 370,
'overlayShow'           :    true, 	
'overlayOpacity'		:	 0.8,
'overlayColor'			:	 '#000',
'onClosed': function() { parent.location.reload(); }
});

$(".video_view").fancybox({
	'width'				: 300,
	'height'			: 172,
	'autoScale'			: false,
	'transitionIn'		: 'elastic',
	'transitionOut'		: 'elastic',
	
	});
	
$("a.iframe").fancybox({ 
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth'			: 	 500, 
'frameHeight'			: 	 180,
'overlayShow'           :    true, 	
'overlayOpacity'		:	 0.8,
'overlayColor'			:	 '#000',
'type'                   :  'iframe',
'onClosed': function() { parent.location.reload(); }
});

$("a.claim_reply").fancybox({ 
       
		'autoScale'			: true,
		'transitionIn'		: 'elastic',
		'transitionOut'		: 'elastic',
	    'hideOnOverlayClick':false,
        'hideOnContentClick':false
	});	



$("a.iframe").fancybox
});
$(function($) {
  var options1 = {format: '%A, %d %B %Y - %I:%M:%S %p' // 12-hour
  }
  $('#jclock1').jclock(options1);
});
$(function(){
$(".pop").hide();
$(".pop").eq(readCookie('slide')).show();
$(".pop li a").css("color","#333");
$(".slide").css("cursor","pointer");
$(".slide").click(function() {
	$(".pop").each(function(){
	$(this).hide();
	});
	 index = $(".slide").index(this);
	createCookie('slide',index);
    $(this).parent().find(".pop").slideToggle();
});
});
function resizeHeight(){
	var viewportwidth;
	var viewportheight;
	// the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
	if (typeof window.innerWidth != 'undefined')
	{
	viewportwidth = window.innerWidth,
	viewportheight = window.innerHeight
	}
	// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
	else if (typeof document.documentElement != 'undefined'
	&& typeof document.documentElement.clientWidth !=
	'undefined' && document.documentElement.clientWidth != 0)
	{
	viewportwidth = document.documentElement.clientWidth,
	viewportheight = document.documentElement.clientHeight
	}
	// older versions of IE
	else
	{
	viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
	viewportheight = document.getElementsByTagName('body')[0].clientHeight
	}
	$('.main').css("height",viewportheight - 122);
	//alert(viewportheight - 122);
}

function paneltoggle(){
	if(document.getElementById("left_dashlet").style.display == "block"){
		document.getElementById("left_dashlet").style.display = "none";
		$(".left-sidebar-strip").css('left','0px');
		$("#left-block").attr('width','0');
		$(".left-sidebar-strip").html('<img src="images/left-sidebar-expand.png" width="21" height="40" class="GERAW0ABLV" onclick="paneltoggle()">');
	}else if(document.getElementById("left_dashlet").style.display == "none"){
		document.getElementById("left_dashlet").style.display = "block";
		$(".left-sidebar-strip").css('left','212px');
		$("#left-block").attr('width','221');
		$(".left-sidebar-strip").html('<img src="images/left-sidebar-collapse.png" width="21" height="40" class="GERAW0ABLV" onclick="paneltoggle()">');
	}
}
</script>
<script type="text/javascript" src="<?php echo BASE_URL;?>jqmedia/jquery.metadata.js"></script> 
<script type="text/javascript" src="<?php echo BASE_URL;?>jqmedia/jquery.usermedia.js"></script> 
<script type="text/javascript" src="<?php echo BASE_URL;?>jqmedia/swfobject.js"></script>
<?php include_once(BASE_URL."includes/fancybox_new.php"); ?>
<script type="text/javascript">
    jQuery(function() {
        jQuery('a.media').media();
    });
	function submit_searchfrm(){
		var searchid = $("#searchid").val();
		if(searchid == '')
		{
			$("#searchid").css('border-color','red');
			$("#searchid").focus();
			return false;
		}else{
			
			window.location.href='account.php?page=view-policy&policyid='+searchid;
		}
		
		
	}
	
</script>


</head>
<?php 
	if(isset($_POST['searchid']))
	{
		header('Location: account.php?page=view-policy&policyid='.$_POST['searchid']);
		
	}
?>
<body onLoad="resizeHeight()">
<!-- container -->
<div class="container">
<!-- header -->
<div id="header_container">
<div class="header">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="134" height="37" style="color:#FFFFFF;font-weight:bold;font-size:24px;padding-bottom:5px;font-family:Calibri; padding-top: 5px; padding-left: 12px;">
	<div style="width: 115px;">
	<img src="<?php echo BASE_URL;?>images/logo-big.png" alt="" style="width: 100%;">	</div>	</td>
	<td width="200" align="center">&nbsp;</td>
    <td width="10%" align="center" class="header_links" style="width: 110px;"><a href="account.php?page=policy-list"><i class="fa fa-folder"></i>Policy Master</a></td>
    <td width="13%" align="center" class="header_links" style="width: 130px;">
	<form action="" onSubmit="submit_searchfrm();" method="post" name="policy_search">
      <i class="fa fa-search"></i><input type="text" name="searchid" style="color:#ffffff;"  value="<?=$_GET["policyid"]?>" id="searchid" placeholder="Policy No.">
    </form>
	</td>
    <td width="9%" align="center" class="header_links" style="width: 95px;"><a href="account.php?page=create_user&task=edit&view=myaccount&id=<?php echo $user->id;  ?>"><i class="fa fa-wrench"></i>My Account</a></td>
    <td width="7%" align="center" class="header_links" style="width: 70px;"><a href="index.php?st=logout"><i class="fa fa-power-off"></i>Logout</a></td>
    <td width="15%" class="header_welcome" style="background-color: rgba(77, 74, 74, 0.57); width: 150px;">
      <strong>User:</strong> <?php echo ucfirst($user->uname); ?> [<?php if($_SESSION['atype']=='E'){echo ucfirst($user->emp_fname)." ".ucfirst($user->emp_lname);}else {echo ucfirst($user->fname)." ".ucfirst($user->lname); }?>]<br>
      <strong>Date:</strong>
      <span style="font-size: 11px; color: #FFFFFF;"><?php echo date("d/m/Y"); ?></span></td>
  </tr>
</table>
</div>
<div class="topnav">
  <?php include_once("includes/nav.php"); ?>
</div>
</div>
<!-- main -->
<div class="main">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div style="margin-left:0px;">
<?php 
include("includes/main.php"); ?>
</div></td>
  </tr>
</table>


</div>
<!-- footer -->
<?php echo site_footer("A"); ?>
</div>
<!-- @end container -->
<!-- @end page content -->

</body>
</html>
