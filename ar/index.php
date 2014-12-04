<?php		
include_once("../config/session.php");
include_once("../config/config.php");
include_once("../config/tables.php");
include_once("../config/functions.php");
include_once("../classes/dbFactory.php");
include_once("../paging/pagination.php");
include_once("../paging/ftr_pagging.php");
// call class instance
$db = new dbFactory();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Al Sagr Cooperative</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/menu.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="shortcut icon" type="images/png" href="asish/images/favicon.ico"/>
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bjqs.css">
<link href="css/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="js/bjqs-1.3.js"></script>
<script src="js/jquery.secret-source.min.js"></script>
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
				animspeed   : 4000
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

<script src="js/jquery.min.js"></script>

<script src="js/jquery.min.js"></script>
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


<link href="css/language-switcher.css" type="text/css" rel="stylesheet">



<script src="js/ams-21.min.js"></script><script>
$(document).ready(function(){AMS.init();});
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
	$( ".date_picker_calender" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:<?php echo date('Y');?>' , changeMonth: 'true',
	maxDate:0 } );
	
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

<body>
	<div class="outerdiv">
    
    	
        <div class="socialIcons">
          <ul>
                              
            <li class="socialSprite chat" title="Live Chat">
              <a target="_blank" onclick="myFunction()">
              <img src="<?php echo SITE_URL; ?>images/socialTransparent.png" width="30" height="30">
              </a>
            </li>
            <li class="socialSprite fb" title="Facebook">
              <a target="_blank" href="#" rel="nofollow">
              <img src="<?php echo SITE_URL; ?>images/socialTransparent.png" width="30" height="30">
              </a>
            </li>
            <li class="socialSprite tw" title="Twitter">
              <a target="_blank" href="#" rel="nofollow">
              <img src="<?php echo SITE_URL; ?>images/socialTransparent.png" width="30" height="30">
              </a>
            </li>
            <li class="socialSprite in" title="Linked In">
              <a target="_blank" href="#" rel="nofollow">
              <img src="<?php echo SITE_URL; ?>images/socialTransparent.png" width="30" height="30">
              </a>
            </li>
            <li class="socialSprite uTube" title="Youtube">
              <a target="_blank" href="#" rel="nofollow">
              <img src="<?php echo SITE_URL; ?>images/socialTransparent.png" width="30" height="30">
              </a>
            </li>
            <li class="socialSprite gPlus" title="Google Plus">
              <a target="_blank" href="#" rel="nofollow">
              <img src="<?php echo SITE_URL; ?>images/socialTransparent.png" width="30" height="30">
              </a>
            </li>
            
          </ul>
        </div>
        
    	<div class="socialIcons1">
          <ul>
            <li class="socialSprite callus" title="Call Us">
              <img id="call_us_icon" src="<?php echo SITE_URL; ?>images/socialTransparent.png" width="30" height="30">
            </li>
          </ul>
          
            <div class="viewcntpan" style="display:none;">
                <a href="#" class="">920001043</a>
            </div>
        
        </div>
        
        <!-- logo area start   -->
		
		<header class="head-lg1">
			
			
        	<div class="wrapper_top1">
            	<figure class="logo">
                	<a href="http://menacompare.com/alsagr/" style="float:left; position:relative; bottom:3px;"><img src="images/logo.png" alt="" /></a>
                </figure>
                
                <figure class="navpan1" style="margin-top: 29px; ">
					<div class="clearfix"></div>
                    
                   <button type="input" name="submit" value="signIn" class="btn btn-success btn-icon" style="float: right;margin-top: 7px;margin-left: 2px;height: 33.5px;border-radius: 3px;width: 89px;background-position: 8px 13px; display:none;">Sign In</button>
                    
                  <div class="newnav">
                         <a href="http://menacompare.com/alsagr/" class="language" style="font-weight: normal;">English</a>
                         <div class="clearfix"></div>
                    	<ul>
                        	<li><a href="#" onmouseover="showpanl();" class="showactive" id="showactive">&#1575;&#1604;&#1605;&#1606;&#1578;&#1580;&#1575;&#1578;</a></li>
                            
                            <li><a href="http://menacompare.com/alsagr/index.php?page=information-center" onmouseover="showpanl_hide();">&#1605;&#1585;&#1603;&#1586; &#1575;&#1604;&#1605;&#1593;&#1604;&#1608;&#1605;&#1575;&#1578;</a></li>
                            
                            <li><a href="http://menacompare.com/alsagr/index.php?page=claim-center" onmouseover="showpanl_hide();">&#1605;&#1585;&#1603;&#1586; &#1575;&#1604;&#1605;&#1591;&#1575;&#1604;&#1576;&#1577;</a></li>
                            
                            <a href="http://menacompare.com/alsagr/index.php?page=sign-in" class="loginpan"></a>
                        </ul>
                  </div>
                   
                </figure>
            </div>
            <div class="navfullpan Mrt-top" id="showpanl_div" onmouseout="showpanl_hide();" onmouseover="showpanl();" style="display:none; top:76px!important;">
                <ul>
                      <li class="heading">                            
                    	&#1575;&#1604;&#1605;&#1585;&#1603;&#1576;&#1575;&#1578;
                	  </li>
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/caric01.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="http://menacompare.com/alsagr/index.php?page=product-details-comprehensive">&#1575;&#1604;&#1601;&#1608;&#1575;&#1574;&#1583; &#1575;&#1604;&#1585;&#1574;&#1610;&#1587;&#1610;&#1577;</a>
                                    </li><li><a href="http://menacompare.com/alsagr/index.php?page=product-details-comprehensive">&#1575;&#1604;&#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1604;&#1571;&#1581;&#1603;&#1575;&#1605;</a>
                                    </li><li><a href="http://menacompare.com/alsagr/index.php?page=product-details-comprehensive">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                                </ul>
                                <div class="clear"></div>
                                <a href="http://menacompare.com/alsagr/index.php?page=product-details-comprehensive" class="more23">&#1571;&#1603;&#1579;&#1585;</a>
                                <a href="http://menacompare.com/alsagr/index.php?page=motor-insurance&step=1" class="more24">&#1588;&#1585;&#1575;&#1569; &#1593;&#1576;&#1585; &#1575;&#1604;&#1573;&#1606;&#1578;&#1585;&#1606;&#1578;</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
                </ul>
                
                <ul>
                    <li class="heading">                            
                        &#1591;&#1576;&#1610;
                    </li>
					<li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/medicalic01.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">&#1575;&#1604;&#1601;&#1608;&#1575;&#1574;&#1583; &#1575;&#1604;&#1585;&#1574;&#1610;&#1587;&#1610;&#1577;</a>
                                    </li><li><a href="#">&#1575;&#1604;&#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1604;&#1571;&#1581;&#1603;&#1575;&#1605;</a>
                                    </li><li><a href="#">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">&#1571;&#1603;&#1579;&#1585;</a>
                                <a href="#" class="more24">&#1588;&#1585;&#1575;&#1569; &#1593;&#1576;&#1585; &#1575;&#1604;&#1573;&#1606;&#1578;&#1585;&#1606;&#1578;</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
                </ul>
                
                <ul>
                    <li class="heading">                            
                        &#1605;&#1605;&#1578;&#1604;&#1603;&#1575;&#1578;
                    </li>
					<li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/property.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">&#1575;&#1604;&#1601;&#1608;&#1575;&#1574;&#1583; &#1575;&#1604;&#1585;&#1574;&#1610;&#1587;&#1610;&#1577;</a>
                                    </li><li><a href="#">&#1575;&#1604;&#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1604;&#1571;&#1581;&#1603;&#1575;&#1605;</a>
                                    </li><li><a href="#">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">&#1571;&#1603;&#1579;&#1585;</a>
                                <a href="#" class="more24">&#1588;&#1585;&#1575;&#1569; &#1593;&#1576;&#1585; &#1575;&#1604;&#1573;&#1606;&#1578;&#1585;&#1606;&#1578;</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>	  
				
                </ul>
                
                <ul>
                    <li class="heading">                            
                        &#1587;&#1601;&#1585;
                    </li>
                    
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/travelico1.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">&#1575;&#1604;&#1601;&#1608;&#1575;&#1574;&#1583; &#1575;&#1604;&#1585;&#1574;&#1610;&#1587;&#1610;&#1577;</a>
                                    </li><li><a href="#">&#1575;&#1604;&#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1604;&#1571;&#1581;&#1603;&#1575;&#1605;</a>
                                    </li><li><a href="#">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">&#1571;&#1603;&#1579;&#1585;</a>
                                <a href="#" class="more24">&#1588;&#1585;&#1575;&#1569; &#1593;&#1576;&#1585; &#1575;&#1604;&#1573;&#1606;&#1578;&#1585;&#1606;&#1578;</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
                </ul>
                
                <ul>
                    <li class="heading">                            
                        &#1575;&#1604;&#1588;&#1581;&#1606; &#1575;&#1604;&#1576;&#1581;&#1585;&#1610;
                    </li>
                    
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/marineico1.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">&#1575;&#1604;&#1601;&#1608;&#1575;&#1574;&#1583; &#1575;&#1604;&#1585;&#1574;&#1610;&#1587;&#1610;&#1577;</a>
                                    </li><li><a href="#">&#1575;&#1604;&#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1604;&#1571;&#1581;&#1603;&#1575;&#1605;</a>
                                    </li><li><a href="#">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">&#1571;&#1603;&#1579;&#1585;</a>
                                <a href="#" class="more24">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
				
							
                </ul>
                
                <ul>
                    <li class="heading">                            
                        &#1591;&#1575;&#1602;&#1577;
                    </li>
                    
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/energyco1.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">&#1575;&#1604;&#1601;&#1608;&#1575;&#1574;&#1583; &#1575;&#1604;&#1585;&#1574;&#1610;&#1587;&#1610;&#1577;</a>
                                    </li><li><a href="#">&#1575;&#1604;&#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1604;&#1571;&#1581;&#1603;&#1575;&#1605;</a>
                                    </li><li><a href="#">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">&#1571;&#1603;&#1579;&#1585;</a>
                                <a href="#" class="more24">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
						  
                </ul>
                
                <ul>
                    <li class="heading">                            
                        &#1607;&#1606;&#1583;&#1587;&#1577;
                    </li>
                    
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/enggico1.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">&#1575;&#1604;&#1601;&#1608;&#1575;&#1574;&#1583; &#1575;&#1604;&#1585;&#1574;&#1610;&#1587;&#1610;&#1577;</a>
                                    </li><li><a href="#">&#1575;&#1604;&#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1604;&#1571;&#1581;&#1603;&#1575;&#1605;</a>
                                    </li><li><a href="#">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">&#1571;&#1603;&#1579;&#1585;</a>
                                <a href="#" class="more24">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
						  
                </ul>
                
                <ul>
                    <li class="heading">                            
                        &#1575;&#1604;&#1581;&#1608;&#1575;&#1583;&#1579; &#1575;&#1604;&#1588;&#1582;&#1589;&#1610;&#1577;
                    </li>
					
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/menucar.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">&#1575;&#1604;&#1601;&#1608;&#1575;&#1574;&#1583; &#1575;&#1604;&#1585;&#1574;&#1610;&#1587;&#1610;&#1577;</a>
                                    </li><li><a href="#">&#1575;&#1604;&#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1604;&#1571;&#1581;&#1603;&#1575;&#1605;</a>
                                    </li><li><a href="#">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">&#1571;&#1603;&#1579;&#1585;</a>
                                <a href="#" class="more24">&#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
                          
							
                </ul>  
                                      
                <span class="special_offer"><a title="Defaqto" href="#">See All...</a></span>
            </div>
        </header>
		
		<div class="clearfix"></div>
        <!-- logo area end  --> 
        
        <section class="sldierbanner">
			
			<div> 
				<div id="banner-fade">

				<!-- start Basic Jquery Slider -->
					<ul class="bjqs">
						<li data-text="<span><img src='images/motorinsurance.png'>&#1578;&#1571;&#1605;&#1610;&#1606; <br> &#1575;&#1604;&#1605;&#1585;&#1603;&#1576;&#1575;&#1578;</span>">
							<img src="images/Motor-Insurance.jpg" title="">
						</li>
						
						<li data-text="<span><img src='images/medicalinsurance.png'>&#1575;&#1604;&#1578;&#1571;&#1605;&#1610;&#1606; <br>&#1575;&#1604;&#1591;&#1576;&#1610;</span>">
							<img src="images/Health.jpg" title="">
						</li>
						
						<li data-text="<span><img src='images/travelinsurance.png'>&#1578;&#1571;&#1605;&#1610;&#1606; <br>&#1575;&#1604;&#1587;&#1601;&#1585;</span>">
							<img src="images/TravelInsurance-sldier.jpg" title="">
						</li>
						
						<li data-text="<span><img src='images/malprct.png'>&#1575;&#1582;&#1591;&#1575;&#1569; <br> &#1575;&#1604;&#1605;&#1607;&#1606; &#1575;&#1604;&#1591;&#1576;&#1610;&#1577;</span>">
							<img src="images/Medicalmalpractice-sldier.jpg" title="">
						</li>
					</ul>
                    
				<!-- end Basic jQuery Slider -->
                
                <div class="TabbedPanelsContentGroup">
                    <div class="TabbedPanelsContent">
                      	<?php /*?><div>
                             <div id="home-form" class="yakeendown brownbox">
                                <h2 id="getquote" style="text-align:center;">
                                    &#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;
                                </h2>
                                <form id="get_a_quote" name="get_a_quote" method="post">
									<input type="hidden" name="policy_class_id" value="1">
									<div id="step-1">
										<!--<div class="form-row-medical">
											<input id="first_name" name="first_name" placeholder="First Name" type="text">
										</div>
										<div class="form-row-medical">
											<input id="last_name" name="last_name" placeholder="Last Name" type="text">
										</div>
										<div class="form-row-medical">
											<input id="email" name="email" placeholder="Email" type="text">
										</div>
										<div class="form-row-medical">
											<input id="iqma_no" name="iqma_no" placeholder="IQMA Number/Saudi/Company Id" type="text">
										</div>-->
										<div class="form-row-medical">
											<select name="policy_type_id" id="policy_type_id" onchange="showVehicleColumn(this.value);">
												<!--<option value="">Insurance type</option>-->
																			<option value="2">&#1588;&#1575;&#1605;&#1604;</option>
																			<option value="1">&#1581;&#1586;&#1576; &#1575;&#1604;&#1605;&#1587;&#1572;&#1608;&#1604;&#1610;&#1577; &#1575;&#1604;&#1579;&#1575;&#1604;&#1579;</option>
																	</select>
										</div>
										
										
														
										<div class="row1 vtype_comp">
												<!--<lable>Vehicle Make</lable>-->
												<select id="vehicle_make" name="vehicle_make" class="dropdown" onchange="getVehicleModel(this.value);">
													<option value="">&#1606;&#1608;&#1593; &#1575;&#1604;&#1587;&#1610;&#1575;&#1585;&#1577;</option>
													<option value="6">&#1607;&#1610;&#1608;&#1606;&#1583;&#1575;&#1610;</option>
													<option value="7">&#1571;&#1608;&#1583;&#1610;</option>
												</select>
										  </div>
											
										<div class="row1 vtype_comp">
											<!--<lable>Vehicle Model</lable>-->
											<span id="vmodel_section">
											<select id="vehicle_model" name="vehicle_model" class="dropdown" onchange="getVehicleType(this.value);">
												<option value="">&#1575;&#1604;&#1587;&#1610;&#1575;&#1585;&#1577; &#1605;&#1608;&#1583;&#1610;&#1604;</option>
																	</select>
											</span>
										</div>
										
										<div class="row1 vtype_comp">
											<!--<lable>Vehicle Type</lable>-->
											<span id="vtype_section">
											<select id="vehicle_type" name="vehicle_type" class="dropdown">
												<option value="">&#1606;&#1608;&#1593; &#1575;&#1604;&#1587;&#1610;&#1575;&#1585;&#1577;</option>
											</select>
											</span>
										</div>
										
								
										<div class="row1 vtype_tpl" style="display:none;">
											<!--<lable>Vehicle Type</lable>-->
										   <select name="vehicle_type_tpl" id="vehicle_type_tpl" class="dropdown">
											   <option value="">&#1606;&#1608;&#1593; &#1575;&#1604;&#1587;&#1610;&#1575;&#1585;&#1577;</option>
												<option value="1">&#1587;&#1610;&#1575;&#1585;&#1577; &#1589;&#1575;&#1604;&#1608;&#1606;</option>
												<option value="2">&#1581;&#1575;&#1601;&#1604;&#1577;</option>
												<option value="3">&#1588;&#1575;&#1581;&#1606;&#1577; &#1589;&#1594;&#1610;&#1585;&#1577;</option>
										   </select>
										</div>
								
										<div class="row1 vtype_tpl" style="display:none;">
											<!--<lable>Vehicle Cylinder </lable>-->
											<select name="vehicle_cylender" id="vehicle_cylender" class="dropdown">
												<option value="">&#1575;&#1604;&#1587;&#1610;&#1575;&#1585;&#1577; &#1575;&#1587;&#1591;&#1608;&#1575;&#1606;&#1577;</option>
												<option value="4">4</option>
												<option value="6">6</option>
												<option value="8">8</option>
												<option value="More than 8">&#1571;&#1603;&#1579;&#1585; &#1605;&#1606; 8</option>
											</select>
										</div>
										
										<div class="row1 vtype_tpl" style="display:none;">
										   <!-- <lable>Vehicle Weight </lable>-->
											<select name="vehicle_weight" id="vehicle_weight" class="dropdown">
												<option value="">&#1608;&#1586;&#1606; &#1575;&#1604;&#1587;&#1610;&#1575;&#1585;&#1577;</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
											</select>
										</div>
										
										<div class="row1 vtype_tpl" style="display:none;">
											<!--<lable>Vehicle Seats</lable>-->
											<select name="vehicle_seats" id="vehicle_seats" class="dropdown">
												<option value="">&#1605;&#1602;&#1575;&#1593;&#1583; &#1575;&#1604;&#1587;&#1610;&#1575;&#1585;&#1577;</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
											</select>
										</div>
										
														
										<div class="row1 agency_rpr_div vtype_comp">
											<lable class="agency_rpr">&#1575;&#1589;&#1604;&#1575;&#1581; &#1603;&#1575;&#1604;&#1577; </lable>
											<div class="radoipan" style="float:left !important;">
												<input type="radio" id="vehicle_agency_repair" class="radio" name="vehicle_agency_repair" value="Yes" style=" width: 13%;">
												<span>&#1606;&#1593;&#1605;</span>
												
												<input type="radio" id="vehicle_agency_repair2" class="radio" name="vehicle_agency_repair" value="No" style=" width: 13%;">
												<span>&#1604;&#1575;</span>
											</div>
										</div>
										
										<div class="row1 vtype_comp">
										   <!-- <lable>No Claim Discount (NCD)</lable>-->
											<select id="vehicle_ncd" name="vehicle_ncd" class="dropdown">
												<option value="">&#1604;&#1575; &#1575;&#1604;&#1605;&#1591;&#1575;&#1604;&#1576;&#1577; &#1575;&#1604;&#1582;&#1589;&#1605; (NCD)</option>
												<option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>                    </select>
										</div>
									
																
										<div class="form-row-medical">
											<input id="mobile_no" name="mobile_no" placeholder="&#1585;&#1602;&#1605; &#1575;&#1604;&#1580;&#1608;&#1575;&#1604;" type="text" onkeypress="return isNumberKey(event)">
										</div>
										
										<div style="margin-top:10px;"></div>
										<div class="form-row" style="margin-top: 10px;" id="CartSubmit">
											<button type="submit" id="submit3" name="submit_quote" class="submit" style="position: inherit; margin-left: 25%;" onclick="return validGetAQuoteForm();">
												&#1575;&#1581;&#1589;&#1604; &#1593;&#1604;&#1609; &#1575;&#1604;&#1587;&#1593;&#1585;
											</button>
										</div>
									</div>
								</form>
                                <div id="SponsorDivToolTip" style="left: 220px; display: none;">
                                    A verification code will be sent to this mobile number
                                </div>
                            </div>
                          </div><?php */?>
                          <?php include_once("includes/get-a-quote.php");?>
                    </div>
						  
                    <div class="TabbedPanelsContent">
                      	<div>
                                <div id="home-form" class="yakeendown greenbox">
                                  <h2 id="getquote" style="text-align:center;">
                                    &#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;
                                  </h2>
                                  <form id="step1" name="step1" method="post">
                                    <div id="step-1">
								
									 <div class="form-row-medical">
										<input value="" class="date_picker_calender" type="text" placeholder="&#1578;&#1575;&#1585;&#1610;&#1582; &#1575;&#1604;&#1605;&#1610;&#1604;&#1575;&#1583;">
										</div>
										
									  <?php /*?><div class="form-row-medical">
									  <select name="type_of_coverage" id="type_of_coverage" onchange="showVehicleColumn(this.value);">
									  		<option selected="selected">Type of Coverage</option>
											<option value="2">Single</option>
											<option value="1">Multiple</option>
										</select>
										</div><?php */?>
										
									  <div class="form-row-medical">
										<select name="gender" id="gender" onchange="showVehicleColumn(this.value);">
									  		<option selected="selected">&#1580;&#1606;&#1587;</option>
											<option value="2">&#1584;&#1603;&#1585;</option>
											<option value="1">&#1571;&#1606;&#1579;&#1609;</option>
										</select>
										</div>
									  <div class="form-row-medical">
										<select name="network_class" id="network_class" onchange="showVehicleColumn(this.value);">
									  		<option selected="selected">&#1601;&#1574;&#1577; &#1575;&#1604;&#1588;&#1576;&#1603;&#1577;</option>
											<option value="2">&#1588;&#1582;&#1589;&#1610;&#1577; &#1605;&#1607;&#1605;&#1577;</option>
											<option value="1">&#1601;&#1574;&#1577; A</option>
											<option value="1">&#1601;&#1574;&#1577; B</option>
											<option value="1">&#1601;&#1574;&#1577; C</option>
										</select>
										</div>
									<div class="form-row-medical">
									<input value="" class="mobile" type="text" placeholder="&#1571;&#1605;&#1585;&#1575;&#1590; &#1605;&#1608;&#1580;&#1608;&#1583;&#1577; &#1605;&#1606; &#1602;&#1576;&#1604; / &#1575;&#1604;&#1605;&#1586;&#1605;&#1606;">
									</div>
									<div class="form-row-medical">
									<input value="" class="mobile" type="text" placeholder="&#1604;&#1575; &#1575;&#1604;&#1606;&#1602;&#1575;&#1604;&#1577;">
									</div>
									<div class="clearfix"></div>
                                      <div class="form-row" style="margin-top: 10px;" id="CartSubmit">
                                        <button type="submit" id="submit3" class="submit" style="position: inherit; margin-left: 25%;">
                                        &#1575;&#1581;&#1589;&#1604;  &#1593;&#1604;&#1609; &#1587;&#1593;&#1585;
                                        </button>
                                      </div>
                                      <br clear="all">
                                    </div>
                                  </form>
                                  <div id="SponsorDivToolTip" style="left: 220px; display: none;">
                                    &#1587;&#1610;&#1578;&#1605; &#1573;&#1585;&#1587;&#1575;&#1604; &#1585;&#1605;&#1586; &#1575;&#1604;&#1578;&#1581;&#1602;&#1602; &#1573;&#1604;&#1609; &#1607;&#1584;&#1575; &#1575;&#1604;&#1585;&#1602;&#1605; &#1575;&#1604;&#1605;&#1581;&#1605;&#1608;&#1604;
                                  </div>
                                </div>
                          </div>
                    </div>
						  
                    <div class="TabbedPanelsContent">
                      	<div>
                                <div id="home-form" class="yakeendown yellowbox">
                                  <h2 id="getquote" style="text-align:center;">
                                    &#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;
                                  </h2>
                                  <form id="step1" name="step1" method="post">
                                    <div id="step-1">
									<div class="form-row-medical">
									<input value="" class="date_picker_calender" type="text" placeholder="&#1578;&#1575;&#1585;&#1610;&#1582; &#1575;&#1604;&#1587;&#1601;&#1585;">
									  </div>
									  <?php /*?><div class="form-row-medical">
									  <select name="policy_type_id" id="policy_type_id" onchange="showVehicleColumn(this.value);">
									  		<option selected="selected">Insurance Type</option>
											<option value="2">Short Term Cover</option>
											<option value="1">Annual Cover</option>
										</select>
										</div><?php */?>
									  <div class="form-row-medical">
									  <select name="policy_type_id" id="policy_type_id" onchange="showVehicleColumn(this.value);">
									  		<option selected="selected">&#1606;&#1608;&#1593; &#1585;&#1581;&#1604;&#1577;</option>
											<option value="2">&#1608;&#1581;&#1610;&#1583;</option>
											<option value="1">&#1605;&#1578;&#1593;&#1583;&#1583;</option>
										</select>
										</div>
									  <div class="form-row-medical">
									  <select name="policy_type_id" id="policy_type_id" onchange="showVehicleColumn(this.value);">
									  		<option selected="selected">&#1575;&#1604;&#1578;&#1594;&#1591;&#1610;&#1577; &#1575;&#1604;&#1580;&#1594;&#1585;&#1575;&#1601;&#1610;&#1577;</option>
											<option value="1">&#1601;&#1610; &#1580;&#1605;&#1610;&#1593; &#1571;&#1606;&#1581;&#1575;&#1569; &#1575;&#1604;&#1593;&#1575;&#1604;&#1605;</option>
                                           <option value="3">&#1583;&#1608;&#1604; &#1588;&#1606;&#1594;&#1606;</option>
                                           <option value="4">&#1608;&#1576;&#1575;&#1587;&#1578;&#1579;&#1606;&#1575;&#1569; &#1575;&#1604;&#1608;&#1604;&#1575;&#1610;&#1575;&#1578; &#1575;&#1604;&#1605;&#1578;&#1581;&#1583;&#1577; &#1575;&#1604;&#1571;&#1605;&#1585;&#1610;&#1603;&#1610;&#1577; &#1608;&#1603;&#1606;&#1583;&#1575; &#1601;&#1610; &#1580;&#1605;&#1610;&#1593; &#1571;&#1606;&#1581;&#1575;&#1569; &#1575;&#1604;&#1593;&#1575;&#1604;&#1605;</option>
										</select>
										</div>
									<div class="form-row-medical">
									<input value="" class="mobile" type="text" placeholder="&#1604;&#1575; &#1575;&#1604;&#1606;&#1602;&#1575;&#1604;&#1577;">
									</div>
                                      <div class="form-row" style="margin-top: 10px;" id="CartSubmit">
                                        <button type="submit" id="submit3" class="submit" style="position: inherit; margin-left: 25%;">
                                        &#1575;&#1581;&#1589;&#1604;  &#1593;&#1604;&#1609; &#1587;&#1593;&#1585;
                                        </button>
                                      </div>
                                      <br clear="all">
                                    </div>
                                  </form>
                                  <div id="SponsorDivToolTip" style="left: 220px; display: none;">
                                    A verification code will be sent to this mobile number
                                  </div>
                                </div>
                          </div>
                    </div>
					
					<div class="TabbedPanelsContent">
                      	<div>
                                <div id="home-form" class="yakeendown graybox">
                                  <h2 id="getquote" style="text-align:center;">
                                    &#1575;&#1588;&#1575;&#1585;&#1577; &#1587;&#1585;&#1610;&#1593;&#1577;
                                  </h2>
                                  <form id="step1" name="step1" method="post">
                                    <div id="step-1">
									  <div class="form-row-medical">
									  <select name="period_of_insurance" id="period_of_insurance">
									  		<option selected="selected">&#1575;&#1604;&#1605;&#1607;&#1606;&#1577; &#1575;&#1604;&#1591;&#1576;&#1610;&#1577;</option>
											<option value="2">&#1605;&#1605;&#1585;&#1590;&#1577;</option>
											<option value="1">&#1605;&#1582;&#1578;&#1576;&#1585; / &#1605;&#1587;&#1575;&#1585; &#1578;&#1603;&#1606;&#1608;&#1604;&#1608;&#1580;&#1610;&#1575;</option>
											<option value="1">&#1575;&#1604;&#1605;&#1587;&#1581; &#1578;&#1603;</option>
											<option value="1">&#1575;&#1604;&#1571;&#1588;&#1593;&#1577; &#1575;&#1604;&#1587;&#1610;&#1606;&#1610;&#1577; &#1604;&#1604;&#1578;&#1603;&#1606;&#1608;&#1604;&#1608;&#1580;&#1610;&#1575;</option>
											<option value="1">&#1588;&#1576;&#1607; &#1591;&#1576;&#1610;</option>
											<option value="1">&#1575;&#1604;&#1593;&#1604;&#1575;&#1580; &#1575;&#1604;&#1591;&#1576;&#1610;&#1593;&#1610;</option>
											<option value="1">&#1573;&#1582;&#1589;&#1575;&#1574;&#1610; &#1593;&#1604;&#1605; &#1575;&#1604;&#1571;&#1605;&#1585;&#1575;&#1590;</option>
											<option value="1">&#1593;&#1575;&#1604;&#1605; &#1575;&#1604;&#1578;&#1594;&#1584;&#1610;&#1577;</option>
											<option value="1">&#1575;&#1604;&#1602;&#1575;&#1576;&#1604;&#1575;&#1578;</option>
											<option value="1">&#1575;&#1591;&#1601;&#1575;&#1604; (&#1594;&#1610;&#1585; &#1587;&#1608;&#1585;&#1594;)</option>
											<option value="1">&#1603;&#1604;&#1609;</option>
											<option value="1">Ophtalmologist</option>
											<option value="1">&#1591;&#1576;&#1610;&#1576; &#1593;&#1575;&#1605;</option>
											<option value="1">&#1591;&#1576;&#1610;&#1576; &#1606;&#1601;&#1587;&#1575;&#1606;&#1610;</option>
											<option value="1">&#1591;&#1576; &#1573;&#1588;&#1593;&#1575;&#1593;&#1610;</option>
											<option value="1">&#1591;&#1576;&#1610;&#1576; &#1571;&#1587;&#1606;&#1575;&#1606;</option>
											<option value="1">&#1575;&#1604;&#1580;&#1585;&#1575;&#1581;</option>
										</select>
										</div>			  
									  <div class="form-row-medical">
									  <select name="limit_of_indemnity" id="limit_of_indemnity">
									  		<option selected="selected">&#1575;&#1604;&#1581;&#1583; &#1605;&#1606; &#1575;&#1604;&#1578;&#1593;&#1608;&#1610;&#1590;</option>
											<option value="2">100,000</option>
											<option value="1">250,000</option>
											<option value="1">500,000</option>
											<option value="1">1,000,000</option>
										</select>
										</div>	
									  <div class="form-row-medical">
									  <select name="year_of_experience" id="year_of_experience">
									  		<option selected="selected">&#1587;&#1606;&#1577; &#1575;&#1604;&#1582;&#1576;&#1585;&#1577;</option>
											<option value="1">0-5 &#1587;&#1606;&#1608;&#1575;&#1578;</option>
											<option value="1">6-10 &#1587;&#1606;&#1608;&#1575;&#1578;</option>
											<option value="1">11 &#1573;&#1604;&#1609; 20 &#1587;&#1606;&#1608;&#1575;&#1578;</option>
											<option value="1">&#1571;&#1603;&#1579;&#1585; &#1605;&#1606; 20 &#1587;&#1606;&#1608;&#1575;&#1578;</option>
										</select>
										</div>	
									  <div class="form-row-medical">
                                      <input value="" class="date_picker_calender" type="text" placeholder="&#1578;&#1575;&#1585;&#1610;&#1582; &#1575;&#1604;&#1605;&#1610;&#1604;&#1575;&#1583;">
									  </div>
									<div class="form-row-medical">
                                      <input value="" class="mobile" type="text" placeholder="&#1604;&#1575; &#1575;&#1604;&#1606;&#1602;&#1575;&#1604;&#1577;">
									  </div>
									  <div class="clearfix"></div>
									  
                                      <div class="form-row" style="margin-top: 10px;" id="CartSubmit">
                                        <button type="submit" id="submit3" class="submit" style="position: inherit; margin-left: 25%;">
                                        &#1575;&#1581;&#1589;&#1604;  &#1593;&#1604;&#1609; &#1587;&#1593;&#1585;
                                        </button>
                                      </div>
                                      <br clear="all">
                                    </div>
                                  </form>
                                  <div id="SponsorDivToolTip" style="left: 220px; display: none;">
                                    A verification code will be sent to this mobile number
                                  </div>
                                </div>
                          </div>
                    </div>
                </div>

      			</div>
				
	  		</div>
		
        </section>
		
		
		<!--  Footer start  -->
		<div class="footerpan">
        	<div class="wrapper">
				<div class="fot_L">&#1581;&#1602;&#1608;&#1602; &#1575;&#1604;&#1578;&#1571;&#1604;&#1610;&#1601; &#1608;&#1575;&#1604;&#1606;&#1588;&#1585; &copy; Alsagr &#1575;&#1604;&#1578;&#1593;&#1575;&#1608;&#1606;&#1610; &#1593;&#1575;&#1605; 2014. &#1580;&#1605;&#1610;&#1593; &#1575;&#1604;&#1581;&#1602;&#1608;&#1602; &#1605;&#1581;&#1601;&#1608;&#1592;&#1577;.</div>
                
			  <div class="fot_R">
                	<div class="footericons">
                        <img src="images/footericons.png" alt="" />
                    </div>
                    
					<a href="http://menacompare.com/alsagr/index.php?page=privacy-policy">&nbsp; &#1587;&#1610;&#1575;&#1587;&#1577; &#1575;&#1604;&#1582;&#1589;&#1608;&#1589;&#1610;&#1577;</a>&nbsp; | &nbsp;<a href="http://menacompare.com/alsagr/index.php?page=terms-and-conditions">&#1588;&#1585;&#1608;&#1591; &#1575;&#1604;&#1575;&#1587;&#1578;&#1582;&#1583;&#1575;&#1605;</a>&nbsp; | &nbsp;<a href="http://menacompare.com/alsagr/index.php?page=contact-us">&#1575;&#1604;&#1575;&#1578;&#1589;&#1575;&#1604; &#1576;&#1606;&#1575; </a>&nbsp; | <a href="http://menacompare.com/alsagr/index.php?page=faq">&nbsp;&#1575;&#1604;&#1578;&#1593;&#1604;&#1610;&#1605;&#1575;&#1578; </a>			  </div>
			</div>
        </div>
		<!--  Footer end  -->
		
	</div>
	


</body>


</head>
</html>
