 
<!-- logo area start   -->

<header class="head-lg1">
			
			  <?php if(isset($_SESSION['uid'])){
				 	$btnvalue =  'Sign Out';
				 	$signinlink = 'index.php?page=sign-in&logoff=1';
					$btnstyle = 'class="logoutpan"';
				 }else{ 
				 	$btnvalue =  'Sign In';
				 	$signinlink = 'index.php?page=sign-in';
					$btnstyle = 'class="loginpan"';
				 
				 }
				  ?>
        	<div class="wrapper_top1">
            	<figure class="logo">
                	<a href="<?php echo BASE_URL;?>" style="float:left; position:relative; bottom:3px; margin-top: 3px;"><img src="<?php echo SITE_URL; ?>images/logo.png" alt="" /></a>
                </figure>
                
                
                <figure class="navpan1" <?php if(isset($_SESSION['uid'])){ ?>style="margin-top: 13px;"<?php }else{?>style="margin-top: 29px;"<?php } ?>>
                <div style="text-align: center;"><?php if(isset($_SESSION['uid'])){ $reg_user_deatil = $db->recordFetch($_SESSION['uid'],USERTBL.":".'id'); echo "<strong>Welcome,</strong> ".$reg_user_deatil['fname']." | <a href='index.php?page=user-dashboard'>My Account</a>";  } ?></div>
					
					<div class="clearfix"></div>
                    
                   <button type="input" name="submit" value="<?=$btnvalue?>" class="btn btn-success btn-icon" style="float: right;margin-top: 7px;margin-left: 2px;height: 33.5px;border-radius: 3px;width: 89px;background-position: 8px 13px; display:none;">Sign In</button>
                    
                  <div class="newnav">
				  <a href="http://menacompare.com/alsagr/ar/" class="language">&#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577;</a>
                  		<?php /*?><select  class="language">
						 		<option selected="selected">&#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577;</option>
								<option>English</option>
						 </select><?php */?>
                         <div class="clearfix"></div>
                    	<ul>
                        	<li><a href="#" onmouseover="showpanl();" class="showactive" id="showactive">Products</a></li>
                            
                            <li><a href="index.php?page=information-center" onmouseover="showpanl_hide();">Information Center</a></li>
                            
                            <li><a href="index.php?page=claim-center" onmouseover="showpanl_hide();">Claim Center</a></li>
                            
                            <a href="<?=$signinlink?>" <?=$btnstyle?> ></a>
                        </ul>
                  </div>
                   
                </figure>
            </div>
            <div class="navfullpan Mrt-top" id="showpanl_div" onmouseout="showpanl_hide();" onmouseover="showpanl();" style="display:none; top:76px!important;">
                <ul>
                      <li class="heading">                            
                    	Motor
                	  </li>
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/caric01.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="index.php?page=product-details-comprehensive">Key Benefits</a>
                                    </li><li><a href="index.php?page=product-details-comprehensive">Terms &amp; Conditions</a>
                                    </li><li><a href="index.php?page=product-details-comprehensive">Get a Quote</a>
                                </ul>
                                <div class="clear"></div>
                                <a href="index.php?page=product-details-comprehensive" class="more23">More</a>
                                <a href="index.php?page=motor-insurance&step=1" class="more24">Buy Online</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
                </ul>
                
                <ul>
                    <li class="heading">                            
                        Medical
                    </li>
					<li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/medicalic01.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">Key Benefits</a>
                                    </li><li><a href="#">Terms &amp; Conditions</a>
                                    </li><li><a href="#">Get a Quote</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">More</a>
                                <a href="#" class="more24">Buy Online</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
                </ul>
                
                <ul>
                    <li class="heading">                            
                        Property
                    </li>
					<li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/property.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">Key Benefits</a>
                                    </li><li><a href="#">Terms &amp; Conditions</a>
                                    </li><li><a href="#">Get a Quote</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">More</a>
                                <a href="#" class="more24">Buy Online</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>	  
				
                </ul>
                
                <ul>
                    <li class="heading">                            
                        Travel
                    </li>
                    
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/travelico1.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">Key Benefits</a>
                                    </li><li><a href="#">Terms &amp; Conditions</a>
                                    </li><li><a href="#">Get a Quote</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">More</a>
                                <a href="#" class="more24">Buy Online</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
                </ul>
                
                <ul>
                    <li class="heading">                            
                        Marine Cargo
                    </li>
                    
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/marineico1.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">Key Benefits</a>
                                    </li><li><a href="#">Terms &amp; Conditions</a>
                                    </li><li><a href="#">Get a Quote</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">More</a>
                                <a href="#" class="more24">Get a Quote</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
				
							
                </ul>
                
                <ul>
                    <li class="heading">                            
                        Energy
                    </li>
                    
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/energyco1.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">Key Benefits</a>
                                    </li><li><a href="#">Terms &amp; Conditions</a>
                                    </li><li><a href="#">Get a Quote</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">More</a>
                                <a href="#" class="more24">Get a Quote</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
						  
                </ul>
                
                <ul>
                    <li class="heading">                            
                        Engineering
                    </li>
                    
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/enggico1.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">Key Benefits</a>
                                    </li><li><a href="#">Terms &amp; Conditions</a>
                                    </li><li><a href="#">Get a Quote</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">More</a>
                                <a href="#" class="more24">Get a Quote</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
						  
                </ul>
                
                <ul>
                    <li class="heading">                            
                        Casuality
                    </li>
					
                    <li>
                        <div id="catalog">
                          <div class="product">
                            <div class="image loaded" style="background-image:url(images/menucar.png); background-repeat:no-repeat;background-size: 100%;background-position: center center;">
                              <div class="image-overlay hover-text" style="left: 100%;">
                                <ul>
                                    <li><a href="#">Key Benefits</a>
                                    </li><li><a href="#">Terms &amp; Conditions</a>
                                    </li><li><a href="#">Get a Quote</a>
                                    
                                </ul>
                                <div class="clear"></div>
                                <a href="#" class="more23">More</a>
                                <a href="#" class="more24">Get a Quote</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                    </li>
                          
							
                </ul>  
                                      
                <span class="special_offer"><a title="Defaqto" href="#">See All...</a></span>
            </div>
        </header>
