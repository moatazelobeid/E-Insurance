<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Al Sagr Cooperative</title>
<link href="<?php echo SITE_URL; ?>css/style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo SITE_URL; ?>css/menu.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="shortcut icon" type="images/png" href="<?php echo SITE_URL; ?>images/favicon.ico"/>
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/bjqs.css">
<link href="<?php echo SITE_URL; ?>css/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="<?php echo SITE_URL; ?>js/bjqs-1.3.js"></script>
<script src="<?php echo SITE_URL; ?>js/jquery.secret-source.min.js"></script>
<!--<script src="js/SpryTabbedPanels.js" type="text/javascript">-->
</script>
<style type="text/css">
/*.bjqs-markers li a{
	visibility: hidden;
}
...bjqs-slide {
	opacity:1 !important;
}*/
.TabbedPanelsContent:not(:first-child){
	display: none;
}
</style>
<script class="secret-source">
  

        jQuery(document).ready(function($) {
	         function createSlider(){
	          $('#banner-fade').bjqs({
	            height      : 300,
	            width       : 1000,
	            responsive  : true,
				animspeed   : 4000,
				hoverpause : true
		//		stop : true
	           });

	        }

        createSlider();
       /*$('ol.bjqs-markers li a').click(function(){

        		var r=$(this).text();
        		$('.TabbedPanelsTabGroup li').removeClass('TabbedPanelsTabSelected');
        		$('.TabbedPanelsTabGroup li:nth-child('+r+')').addClass('TabbedPanelsTabSelected');
        		$('.TabbedPanelsContentGroup div').removeClass('TabbedPanelsContentVisible').css('display','none');
        		$('.TabbedPanelsContentGroup div:nth-child('+r+')').addClass('TabbedPanelsContentVisible').show();
        	})
        	$('.TabbedPanelsTabGroup li').click(function(e){
                //alert('dd');
                 e.preventDefault();
                    var rr=$( this ).data('count');
                    console.log(rr);
                  
               $('.bjqs .bjqs-slide').fadeOut();
                   $('.bjqs .bjqs-slide:nth-child('+rr+')').css('opacity','1 !important').fadeIn();

                    	//$(this);
                   $('ol.bjqs-markers li').removeClass('active-marker');
                   $('ol.bjqs-markers li:nth-child('+rr+')').addClass('active-marker');
                   createSlider();


            })*/
        });


        $(function(){

        	
        	
        })

</script>

<!--<script src="<?php //echo SITE_URL; ?>js/jquery.min.js"></script>-->

<!--<script src="<?php //echo SITE_URL; ?>js/jquery.min.js"></script>-->
<script class="secret-source">
function showpanl(){
	$("#showpanl_div").show();
	$("#showactive").addClass('showactive');
}
function showpanl_hide(){
	$("#showpanl_div").hide();
	$("#showactive").removeClass('showactive');
}

/*
$(document).ready(function(e){
	$("div.hover-text").hide();
		$("div.gimage").hover(function(){
		$(this).find("div.hover-text").slideToggle(500);
	});
	
	$("div.gimage").css({'position' : 'relative'});
	$("div.hover-text").css({'position' : 'absolute','bottom' :0});	
});*/

function myFunction() {
    var myWindow = window.open("http://messenger.providesupport.com/messenger/alsagrcooperative.html", "", "width=550, height=600");
}
</script>


<link href="<?php echo SITE_URL; ?>css/language-switcher.css" type="text/css" rel="stylesheet">

<!--<script type="text/javascript" src="<?php // echo SITE_URL; ?>js/jquery.min.js"></script>-->
<script src="<?php echo SITE_URL; ?>js/jquery.polyglot.language.switcher.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
			effect: 'fade',
			testMode: true,
			onChange: function(evt){
			   // alert("The selected language is: "+evt.selectedItem);
			}
//                ,afterLoad: function(evt){
//                    alert("The selected language has been loaded");
//                },
//                beforeOpen: function(evt){
//                    alert("before open");
//                },
//                afterOpen: function(evt){
//                    alert("after open");
//                },
//                beforeClose: function(evt){
//                    alert("before close");
//                },
//                afterClose: function(evt){
//                    alert("after close");
//                }
		});
	});
</script>


<script src="<?php echo SITE_URL; ?>js/ams-21.min.js"></script><script>
$(document).ready(function(){AMS.init();});
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
	$( ".date_picker_calender" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:<?php echo date('Y');?>' , changeMonth: 'true',
	maxDate:0 } );
	
	var d = new Date();
	var maxdobyr = d.getFullYear() - 18;
	d.setFullYear(maxdobyr);
	
	$( ".dob_calender" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:'+maxdobyr , changeMonth: 'true',
defaultDate: d } );

	
	// phone number slidein
	
	 /*$('#call_us_icon').click(function() {
		var $marginLefty = $('.viewcntpan').next();
		$marginLefty.animate({
		  marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ?
			$marginLefty.outerWidth() :
			0
		});
	  });*/
  
	$("#call_us_icon").click(function(){
		$(".viewcntpan").toggle( "slow", function() {
			// Animation complete.
			$(".callus").css('background-position','-62px 0px');
		});
	});
});
</script>