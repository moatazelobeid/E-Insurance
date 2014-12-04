<?php
$alias=$_GET['page'];
$_GET['page'] = $alias;
$menu=mysql_fetch_object(mysql_query("select * from ".PAGEMENU." where allias='$alias'"));
$page=mysql_fetch_object(mysql_query("select * from  ".PAGETBL." where id = '".$menu->menu_assign."' "));

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
						<a itemprop="url" href="<?=BASE_URL?>">Home</a> 
						<?php if($_GET['page'] == 'information-center'){ ?>
						<span class="breeadset">&#8250;</span>
						<strong><a href="index.php?page=information-center">Information Center</a></strong>
						<?php } ?>
						<span class="breeadset">&#8250;</span>
						<strong><?=$page->pg_title?> </strong>					</div>
					
					<div class="lg-3">
						<div class="normallist1 innerleft allpage">
							<h1>Quick Links</h1>
							<ul>
                             <?php $i = 1;
								$row=mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_position = '4'  AND status='1' ORDER BY ordering ASC");
								$num_rows=mysql_num_rows($row);
								$count = 0;
								while($ress=mysql_fetch_array($row))
								{
								$count++;
								$menu_title = $ress['menu_title'];
								if($ress['menu_link'] != ""){
									$menu_link=$ress['menu_link'];
								}else{
									$menu_link= BASE_URL.strtolower($ress['allias']);
								}
								?>
								<li><a href="<?php echo $menu_link;?>" <?=($ress['allias'] == $_GET['page'] || ($_GET['page']== 'information-center' && $ress['allias']=='downloads'))?'class="active"':''?>><?php echo strip_tags(stripslashes($menu_title));?></a></li>
							   
								<?php }?> 
                                <!--<li><a href="#">FAQ's</a></li>
								<li><a href="#" class="active">Downloads</a></li>
								<li><a href="#">The Risk We Insure</a></li>
								<li><a href="#">Board of Directors</a></li>-->
							</ul>
						</div>
						
					</div>
					
					<div class="lg-6">
						<div class="rightformpan innerTFl">
                        	<h1><?=$page->pg_title;?></h1>
						<p><?php echo stripslashes($page->pg_detail); ?></p>
                        </div>
					</div>
				
				<div class="clearfix"></div>
				</div>
	
				<div class="clearfix" style="height:15px;">.</div>
		</div>
<?php } ?>