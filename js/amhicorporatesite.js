  var nVer = navigator.appVersion; var nAgt = navigator.userAgent; var bN = navigator.appName; var fullV = "" + parseFloat(navigator.appVersion); var majorV = parseInt(navigator.appVersion, 10); var nameOffset, verOffset, ix; if ((verOffset = nAgt.indexOf("Opera")) !== -1) { bN = "Opera"; fullV = nAgt.substring(verOffset + 6); if ((verOffset = nAgt.indexOf("Version")) !== -1) { fullV = nAgt.substring(verOffset + 8) } } else { if ((verOffset = nAgt.indexOf("MSIE")) !== -1) { bN = "IE"; fullV = nAgt.substring(verOffset + 5) } else { if ((verOffset = nAgt.indexOf("Chrome")) !== -1) { bN = "Chrome"; fullV = nAgt.substring(verOffset + 7) } else { if ((verOffset = nAgt.indexOf("Safari")) !== -1) { bN = "Safari"; fullV = nAgt.substring(verOffset + 7); if ((verOffset = nAgt.indexOf("Version")) !== -1) { fullV = nAgt.substring(verOffset + 8) } } else { if ((verOffset = nAgt.indexOf("Firefox")) !== -1) { bN = "Firefox"; fullV = nAgt.substring(verOffset + 8) } else { if ((nameOffset = nAgt.lastIndexOf(" ") + 1) < (verOffset = nAgt.lastIndexOf("/"))) { bN = nAgt.substring(nameOffset, verOffset); fullV = nAgt.substring(verOffset + 1); if (bN.toLowerCase() == bN.toUpperCase()) { bN = navigator.appName } } } } } } } if ((ix = fullV.indexOf(";")) !== -1) { fullV = fullV.substring(0, ix) } if ((ix = fullV.indexOf(" ")) !== -1) { fullV = fullV.substring(0, ix) } majorV = parseInt("" + fullV, 10); if (isNaN(majorV)) { fullV = "" + parseFloat(navigator.appVersion); majorV = parseInt(navigator.appVersion, 10) }
  document.getElementsByTagName("body")[0].className += " " + bN + " " + bN + majorV + " cmsHTML cmsHTML5";
  function UserDetails(Heading,SubHeading) {  
    window.open("/Buyonline/GetUserDetails.aspx?ProductName=" + Heading + "&ProductVariant=" + SubHeading, '', 'width=450,height=600')  
};

$(document).ready(function (){  
  $("#MenuSelector").change(function () {        
    var path = this.value;        
    document.location.href = path;
  });   
  
  var ulCount=$('.articleLinks ul').length;
  if(ulCount>1){
    $('.articleLinks ul li:not(ul li ul li)').css({'font-weight' : 'bold', 'list-style' : 'none'});
	$('.articleLinks ul li ul li a').css({'font-weight' : 'normal'});    
    }  
   $("#accordion").accordion({heightStyle: "content"});
  $(".prod-listing:last").css("border-bottom","none");
});

//Expand collapse as per irda
$(document).ready(function(){
$('.expCol').click(function(){
	var a=$('.expCol img').attr('src');
	if(a=='images/pluss.png'){
		$('.expCol img').attr('src', 'images/minus.png');
		$('.expandCollapse').slideToggle();
		return false;
		}
	else
	$('.expCol img').attr('src', 'images/pluss.png');
		$('.expandCollapse').slideToggle();
		return false;
	});
});

$(document).ready(function(){
$('.expCol1').click(function(){
	var a=$('.expCol1 img').attr('src');
	if(a=='/images/pluss.png'){
		$('.expCol1 img').attr('src', '/images/minus.png');
		$('.expandCollapse1').slideToggle();
		return false;
		}
	else
	$('.expCol1 img').attr('src', '/images/pluss.png');
		$('.expandCollapse1').slideToggle();
		return false;
	});
});

// Home Box JS
$(document).ready(function(){
	$('.homeBox').mouseover(function(){
		$(this).find('.knwMore li').removeClass('bg').addClass('hover');
        $(this).find('.knwMore li a').css('color', '#ffffff');				
        var src = $(this).find('img').attr("src").match(/[^\.]+/) + "Hover.png";
		$(this).find('img').attr("src", src);
		return false;
			}).mouseout(function() { 
            $(this).find('.knwMore li').removeClass('hover').addClass('bg');
            $(this).find('.knwMore li a').css('color', '');           			
            var src = $(this).find('img').attr("src").replace("Hover.png", ".png");
            $(this).find('img').attr("src", src);
			return false;
			});
			
		$(function() {
            var offset = $(".socialIcons").offset();
            var topPadding = 15;
            $(window).scroll(function() {
                if ($(window).scrollTop() > offset.top) {
                    $(".socialIcons").stop().animate({
                        marginTop: $(window).scrollTop() - offset.top + topPadding
                    });
                } else {
                    $(".socialIcons").stop().animate({
                        marginTop: 0
                    });
                };
            });
        });
  
      $('.homeBox').click(function(){
      var lnk=$(this).find('.heading a').attr('href');
      window.location=lnk;
      });
		
	});

// Home Box JS

// MENU BORDER RIGHT FOR IE
$(document).ready(function(){
$('.megamenu .mega .subCMSListMenuUL li:last-child').css('border','none');
$('footer .container li:last').css('border','none');
});
// MENU BORDER RIGHT FOR IE

// Product Plan Page jQuery //
$(document).ready(function(){
	$('.prodAccord .accordStuff a').click(function(e){
		$('.prodAccord .accordStuff div').slideUp('slow');
		$('.prodAccord .accordStuff span').removeClass('txtOrng');
		$('.prodAccord .accordStuff img').attr('src','/images/iconPlus.png');
		var src = $(this).find('img').attr("src");
		if(src!='/images/iconPlusSel.png'){
		var src = $(this).find('img').attr("src").match(/[^\.]+/) + "Sel.png";
		$(this).find('img').attr("src", src);
		}
		$(this).find('span').addClass('txtOrng');
		$(this).next().slideToggle('slow');
		e.preventDefault();
		});  
	});

// Product Plan Page jQuery //
//End