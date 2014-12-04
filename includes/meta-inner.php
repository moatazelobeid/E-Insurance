<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Alsagr Cooperative</title>

<head>

<link href="<?php echo SITE_URL; ?>css/style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo SITE_URL; ?>css/menu.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="shortcut icon" type="images/png" href="<?php echo SITE_URL; ?>images/favicon.ico"/>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>


<?php /*?><script src="<?php echo SITE_URL; ?>js/jquery.min.js"></script><?php */?>

<script class="secret-source">
function showpanl(){
	$("#showpanl_div").show();
	$("#showactive").addClass('showactive');
}
function showpanl_hide(){
	$("#showpanl_div").hide();
	$("#showactive").removeClass('showactive');
}


</script>


<link href="<?php echo SITE_URL; ?>css/language-switcher.css" type="text/css" rel="stylesheet">

<?php /*?><script type="text/javascript" src="js/jquery.min.js"></script>
<script src="<?php echo SITE_URL; ?>js/jquery.polyglot.language.switcher.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
			effect: 'fade',
			testMode: true,
			onChange: function(evt){
			}
		});
	});
</script><?php */?>


<?php /*?><script type="text/javascript" src="<?php echo SITE_URL; ?>js/jquery-1.8.2.min.js"></script>
<?php */?>




<?php if($_GET['page']=='product-details-comprehensive' || $_GET['page']=='faq' || $_GET['page']=='product-details-tpl' || $_GET['page']=='motor-insurance'  || $_GET['page']=='medical-insurance'  || $_GET['page']=='renew-policy')
	{ ?>
	<link href="<?php echo SITE_URL; ?>css/jquery-ui-1.8.24.custom.css" rel="stylesheet" type="text/css" media="screen"/>

<?php if(($_GET['page']=='product-details-comprehensive'))
{?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<?php }?>

<?php if($_GET['page']!='motor-insurance'  && $_GET['page']!='medical-insurance'  && $_GET['page']!='renew-policy')
{?>
<script type="text/javascript" src="<?php echo SITE_URL; ?>js/jquery-ui-1.8.24.custom.min.js"></script>
<?php }?>
<script type="text/javascript">
		$(function(){

			// Accordion
			$("#accordion").accordion({ header: "h3", autoHeight: false });
			$( "#accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: false,
				active: false
			});
			
			$("#accordion1").accordion({ header: "h3", autoHeight: false });
			$( "#accordion1" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: false,
				active: false
			});
			
			$('.product .image').hover(function(){
				$(this).find('.hover-text').animate({'left':'14px'});
			},function(){

				$(this).find('.hover-text').animate({'left':'100%'});
			})
		});
		
</script>
<link href="<?php echo SITE_URL; ?>/css/detailstab.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITE_URL; ?>/js/detailstab.js" type="text/javascript"></script>
<?php }else
{ 
//if($_GET['page']!='motor-insurance')
//{?>
<script src="<?php echo SITE_URL; ?>/js/ams-21.min.js"></script>

<script>
$(document).ready(function(){AMS.init();});
</script>

<?php //} 
}?>



<?php if(($_GET['page']=='motor-insurance') || ($_GET['page']=='medical-insurance') || ($_GET['page']=='renew-policy'))
{?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<?php }?>


<script type="text/javascript" src="<?php echo BASE_URL; ?>admin/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>admin/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>admin/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript">
$(document).ready(function() {
						   
	
	$("a.fancy").fancybox({
	'zoomSpeedIn'           :    500,
	'zoomSpeedOut'          :    500,
	
	'overlayShow'           :    true, 
	'overlayOpacity' : 0.8,
	'overlayColor' : '#000'
	
	   });
	   
	   
});
</script>




<link href="<?php echo SITE_URL; ?>/js/datepicker/styles/glDatePicker.default.css" rel="stylesheet" type="text/css">
<script src="<?php echo SITE_URL; ?>/js/datepicker/glDatePicker.min.js"></script>


<script type="text/javascript">
	$(window).load(function()
	{
		$('.date_picker').glDatePicker({
			dateFormat:'yy-mm-dd',
			
		});
			
		$('#dob').glDatePicker({dateFormat:'dd-mm-yy'});
		$('#claim_date_auto').glDatePicker({dateFormat:'dd-mm-yy'});
	});
</script>




</head>
