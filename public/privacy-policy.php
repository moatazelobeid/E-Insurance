<?php
$alias=$_GET['page'];
$_GET['page'] = $alias;
$menu=mysql_fetch_object(mysql_query("select * from ".PAGEMENU." where allias='$alias'"));
$page=mysql_fetch_object(mysql_query("select * from  ".PAGETBL." where id ='".$menu->menu_assign."'"));
if(!$page)
{  ?>
<div class="innrebodypanel">
				<div class="clearfix" style="height:15px;">.</div>
				<div class="innerwrap">
					
					<h1><?='Page not found'?></h1>
					<?='Page not found'?>				
				</div>
				<div class="clearfix" style="height:15px;">.</div>
		</div>

<?php }
else{ ?>
<div class="innrebodypanel">
				<div class="clearfix" style="height:15px;">.</div>
				<div class="innerwrap">
				
					<div class="breadcrumb" >
						<a itemprop="url" href="<?php echo BASE_URL;?>">Home</a> 
						<span class="breeadset">&#8250;</span>
						<strong><?=stripslashes($page->pg_title)?></strong>
					</div>
					
					<h1><?=$page->pg_title;?></h1>
					
					<?php echo stripslashes($page->pg_detail); ?>
					
				</div>
				<div class="clearfix" style="height:15px;">.</div>
		</div>
 <?php } ?>