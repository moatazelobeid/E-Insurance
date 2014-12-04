<header class="head-lg1">	
    <div class="innerwrap_top">
        <figure class="logo">
            <a href="<?php echo BASE_URL;?>" style="float:left; position:relative; bottom:3px; margin-top: 3px;"><img src="images/logo.png" alt="" /></a>
           <!--<a href="#" class="language"></a>-->
        </figure>
        
        <figure class="navpan1" <?php if(isset($_SESSION['uid'])){ ?>style="margin-top: 13px;"<?php }else{?>style="margin-top: 29px;"<?php } ?>>
            
            <div style="text-align: center;"><?php if(isset($_SESSION['uid'])){ $reg_user_deatil = $db->recordFetch($_SESSION['uid'],USERTBL.":".'id'); echo "<strong>Welcome,</strong> ".$reg_user_deatil['fname']." | <a href='index.php?page=user-dashboard'>My Account</a>";  } ?></div>
            <div class="clearfix"></div>
            <?php if(isset($_SESSION['uid'])){
				 	$btnvalue =  'Sign Out';
				 	$signinlink = 'index.php?page=sign-in&logoff=1';
					$btnstyle = 'class="logoutpan"';
				 }else{ 
				 	$btnvalue =  'Sign In';
				 	$signinlink = 'index.php?page=sign-in';
					if($_GET['page'] == 'sign-in'){
					$btnstyle = 'class="loginpan active"';
					}else{
					$btnstyle = 'class="loginpan"';
					}
				 }
		   ?>
           <button type="input" name="submit"value="<?=$btnvalue?>" class="btn btn-success btn-icon" style="float: right;margin-top: 7px;margin-left: 2px;height: 33.5px;border-radius: 3px;width: 89px;background-position: 8px 13px; display:none;">Sign In</button>
            
          <div class="newnav">
			
			<a href="http://menacompare.com/alsagr/ar/" class="language">&#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577;</a>
            <?php /*?><select  class="language">
						 		<option selected="selected">&#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577;</option>
								<option>English</option>
						 </select><?php */?>
                <ul>
                    <li><a href="#" onmouseover="showpanl();"  <?php if($_GET['page']=='product-details-comprehensive' || $_GET['page']=='product-details-tpl') { ?> class="showactive active" id="showactive" <?php } ?> >Products</a></li>
                    
                    <li><a href="index.php?page=information-center" onmouseover="showpanl_hide();" <?php if($_GET['page']=='information-center' || $_GET['page']=='company-profile' || $_GET['page']=='board-of-directors' || $_GET['page']=='risk-we-insure' || $_GET['page']=='need-consultant-help' || $_GET['page']=='tips' || $_GET['page']=='locate-your-branch') { ?> class="showactive active" id="showactive" <?php } ?>>Information Center</a></li>
                    
                    <li><a href="index.php?page=claim-center" onmouseover="showpanl_hide();" <?php if($_GET['page']=='claim-center' ) { ?> class="showactive active" id="showactive" <?php } ?>>Claim Center</a></li>
                   
                    <a href="<?=$signinlink?>" <?=$btnstyle?>></a>

                </ul>
          </div>
           
        </figure>
    </div>
    <!--<div class="navfullpan Mrt-top" id="showpanl_div" onmouseout="showpanl_hide();" onmouseover="showpanl();" style="display:none; top:75px!important;">
        <ul>
                  <li class="heading">                            
                Motor
            </li>
                  <li>
                            <div class="gimage" onmouseover="scrolldiv1()">
                            <img alt="Insurance umbrella" src="images/caric01.png" style="width:130px;" />
                            <div class="hover-text">
                                <ul>
                                    <li><a href="#">Key Benefits</a>
                                    <li><a href="#">Terms & Conditions</a>
                                    <li><a href="#">Get a Quote</a>
                                    <li><a href="#">Buy Online</a>
                                </ul>
                                <div class="clear"></div>
                                <a href="catagory-listing.html" class="more23">More...</a>
                            </div>
             </div>
                    </li>
        </ul>
        
        <ul>
            <li class="heading">                            
                Medical
            </li>
                  <li>
                        <div class="gimage" onmouseover="scrolldiv1()">
                            <img alt="Insurance umbrella" src="images/medicalic01.png" />
                            <div class="hover-text">
                                <ul>
                                     <li><a href="#">Key Benefits</a></li>
                                      <li><a href="#">Terms &amp; Conditions</a></li>
                                      <li><a href="#">Get a Quote</a></li>
                                      <li><a href="#">Buy Online</a></li>
                                </ul>
                                <div class="clear"></div>
                                <a href="catagory-listing.html" class="more23">More...</a>
                            </div>
             </div>
                    </li>
        </ul>
        
        <ul>
            <li class="heading">                            
                Property
            </li>
                  
                  <li>
                        <div class="gimage" onmouseover="scrolldiv1()">
                            <img alt="Insurance umbrella" src="images/property.png" />
                            <div class="hover-text">
                                <ul>
                                    <li><a href="#">Key Benefits</a></li>
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                    <li><a href="#">Get a Quote</a></li>
                                    <li><a href="#">Buy Online</a></li>
                                </ul>
                                <div class="clear"></div>
                                <a href="catagory-listing.html" class="more23">More...</a>
                            </div>
             </div>
                    </li>
        </ul>
        
        <ul>
            <li class="heading">                            
                Travel
            </li>
                  <li>
                    <div class="gimage" onmouseover="scrolldiv1()">
                            <img alt="Insurance umbrella" src="images/travelico1.png" />
                            <div class="hover-text">
                                <ul>
                                    <li><a href="#">Key Benefits</a></li>
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                    <li><a href="#">Get a Quote</a></li>
                                    <li><a href="#">Buy Online</a></li>
                                </ul>
                                <div class="clear"></div>
                                <a href="catagory-listing.html" class="more23">More...</a>
                            </div>
             </div>
                    </li>
        </ul>
        
        <ul>
            <li class="heading">                            
                Marine Cargo
            </li>
                  
                  <li>
                        <div class="gimage" onmouseover="scrolldiv1()">
                            <img alt="Insurance umbrella" src="images/marineico1.png" />
                            <div class="hover-text">
                                <ul>
                                    <li><a href="#">Key Benefits</a></li>
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                    <li><a href="#">Get a Quote</a></li>
                                    <li><a href="#">Buy Online</a></li>
                                </ul>
                                <div class="clear"></div>
                                <a href="catagory-listing.html" class="more23">More...</a>
                            </div>
             </div>
                    </li>
                    
        </ul>
        
        <ul>
            <li class="heading">                            
                Energy
            </li>
                  
                  <li>
                        <div class="gimage" onmouseover="scrolldiv1()">
                            <img alt="Insurance umbrella" src="images/energyco1.png" />
                            <div class="hover-text">
                                <ul>
                                    <li><a href="#">Key Benefits</a></li>
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                    <li><a href="#">Get a Quote</a></li>
                                    <li><a href="#">Buy Online</a></li>
                                </ul>
                                <div class="clear"></div>
                                <a href="catagory-listing.html" class="more23">More...</a>
                            </div>
             </div>
                    </li>
                
        </ul>
        
        <ul>
            <li class="heading">                            
                Engineering
            </li>
                  
                  <li>
                        <div class="gimage" onmouseover="scrolldiv1()">
                            <img alt="Insurance umbrella" src="images/enggico1.png" />
                            <div class="hover-text">
                                <ul>
                                    <li><a href="#">Key Benefits</a></li>
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                    <li><a href="#">Get a Quote</a></li>
                                    <li><a href="#">Buy Online</a></li>
                                </ul>
                                <div class="clear"></div>
                                <a href="catagory-listing.html" class="more23">More...</a>
                            </div>
             </div>
                    </li>
        </ul>
        
        <ul>
            <li class="heading">                            
                Casuality
            </li>
                  
                  <li>
                        <div class="gimage" onmouseover="scrolldiv1()">
                            <img alt="Insurance umbrella" src="images/menucar.png" />
                            <div class="hover-text">
                                <ul>
                                    <li><a href="#">Key Benefits</a></li>
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                    <li><a href="#">Get a Quote</a></li>
                                    <li><a href="#">Buy Online</a></li>
                                </ul>
                                <div class="clear"></div>
                                <a href="catagory-listing.html" class="more23">More...</a>
                            </div>
             </div>
                    </li>		
        </ul>  
                              
        <span class="special_offer"><a title="Defaqto" href="#">See All...</a></span>
    </div>-->
    
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