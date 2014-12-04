<?php
include_once("../config/config.php");
include_once("../config/functions.php");
include_once("../config/tables.php");
include_once("../classes/dbFactory.php");

?>
<link href="<?php echo SITE_URL; ?>css/style.css" rel="stylesheet" type="text/css" media="screen" />
<?php 
$_GET['page'] = 'terms-and-conditions';
$alias=$_GET['page'];
$_GET['page'] = $alias;
$menu=mysql_fetch_object(mysql_query("select * from ".PAGEMENU." where allias='$alias'"));
$page=mysql_fetch_object(mysql_query("select * from  ".PAGETBL." where id ='".$menu->menu_assign."'"));
if(!$page)
{  ?>
<div class="innrebodypanel">
				
				<div class="innerwrap">
					
					<h1><?='Page not found'?></h1>
					<?='Page not found'?>				
				</div>
				<div class="clearfix" style="height:15px;">.</div>
		</div>

<?php }
else{ ?>
<div class="innrebodypanel">
				
				<div class="innerwrap">
				
					<?php /*?><div class="breadcrumb" >
						<a itemprop="url" href="<?php echo BASE_URL;?>">Home</a> 
						<span class="breeadset">&#8250;</span>
						<strong><?=$page->pg_title;?></strong>
					</div><?php */?>
					
					<h1><?=$page->pg_title;?></h1>
					<?=stripslashes($page->pg_detail);?>
					
				</div>
				
		</div>
<?php } ?>