<?php		
include_once("config/session.php");
include_once("config/config.php");
include_once("config/tables.php");
include_once("config/functions.php");
include_once("classes/dbFactory.php");
include_once("paging/pagination.php");
include_once("paging/ftr_pagging.php");
// call class instance
$db = new dbFactory();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php  if($_GET['page'] == '')
        {
             include_once('includes/meta.php');
        }else
		{
			include_once('includes/meta-inner.php');
		}
        ?> 
<body>
<?php  if($_GET['page'] == '')
        {
?>
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
                <a href="#" class="phone">920001043</a>
                <a href="mailto:info@alsgr.com" class="emailid">info@alsgr.com</a>
            </div>
        
        </div>
    
    
  <?php } ?>
	<div class="outerdiv">
     <?php 
        if($_GET['page'] == '')
        {
             include_once('includes/head.php');
        }else
		{
			include_once('includes/head-inner.php');
		}
        ?>
  
		<div class="clearfix"></div>
        <!-- logo area end  --> 
        <?php 
        if($_GET['page'] == '')
        {
             include_once('includes/banner.php'); 
        }else
		{
			include_once('includes/main.php');	
		}
        ?>
         <?php 
        if($_GET['page'] == '')
        {
             include_once('includes/footer.php');
        }else
		{
			include_once('includes/footer-inner.php');
		}
        ?>
</body>
</head>
</html>
