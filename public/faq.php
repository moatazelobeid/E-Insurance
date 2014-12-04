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
<style>
.ui-accordion .ui-accordion-header a{background-size: 3%;}
</style>
<div class="innrebodypanel">
				<div class="clearfix" style="height:15px;">.</div>
				<div class="innerwrap">
				
					<div class="breadcrumb" >
						<a itemprop="url" href="<?php echo BASE_URL;?>">Home</a> 
						<span class="breeadset">&#8250;</span>
						<strong>FAQ </strong>
					</div>
					
					<div class="lg-3">
						<div class="normallist1">
							<h1>Need Help</h1>
							<ul>
								<li><a href="index.php?page=faq">FAQ</a></li>
								<li><a href="index.php?page=contact-us">Contact Us</a></li>
							</ul>
						</div>
					</div>
					
					<div class="lg-6">
						<div class="rightformpan innerTFl" >
                        	<h1><?=stripslashes($page->pg_title)?></h1>
                           <?php echo stripslashes($page->pg_detail); ?>
                            <div class="clearfix"></div>
                            
                            <div class="wpcf7" id="wpcf7-f61-p12-o1" style="width:100%;">
                                  <div id="accordion">
                                  <?php $allfaqs=mysql_query("select * from ".TBLFAQ." where status='1'");
								  	if(mysql_num_rows($allfaqs) >0)
									{
										
										while($row = mysql_fetch_array($allfaqs))
										{
									
								   ?>
                                        <div>
                                            <h3><a href="#"><?=stripslashes($row['quest'])?></a></h3>
                                            <div class="clients_expand_bg" style="height:auto;">
                                                
                                              <?=stripslashes($row['ans'])?>
                                                
                                            </div>
                                        </div>
                                    <?php 
										}
									}?>
                                  
                                </div>
                            </div>
                            
                        </div>
					</div>
				
				<div class="clearfix"></div>
				</div>
				<div class="clearfix" style="height:15px;">.</div>
		</div>
 <?php } ?>