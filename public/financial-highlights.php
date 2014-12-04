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
                <a itemprop="url" href="<?=BASE_URL?>">Home</a> 
                <span class="breeadset">&#8250;</span>
                <strong>Financial Highlights </strong>
            </div>
            
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
                   <?=stripslashes($page->pg_detail);?>
                    
                    <div class="clearfix" style="height:15px;"></div>
                    
                    <table class="dwdpage"  border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                      <tr>
                      <?php $alldownloads=mysql_query("select * from  ".DOWNLOADS." where status ='1'"); 
                         if(!empty($alldownloads))
                         {
                             $cnt =1;
                             $totldownloads = mysql_num_rows($alldownloads);
                            while($row = mysql_fetch_array($alldownloads) ):
                            if($cnt%2==0){ $adddownload= '</tr><tr><td height="13" colspan="2" class="borderbottom"></td></tr><tr><td colspan="2" height="13"></td></tr>';}
                          ?>
                            
                                <td valign="top">
                                    <strong><?=$row['download_title']?></strong>
                                    <a href="<?php echo SITE_URL.'upload/downloads/'.$row['attachment'];?>" target="_blank">
                                        <img src="<?php echo SITE_URL; ?>images/pdf-icon.png" border="0" alt="Download">
                                        <br>
                                        <?=$row['attachment']?>
                                    </a>
                                </td>
                                <?=$adddownload?>						
                            
                          <?php 
                          $cnt++;
                          endwhile;
                         }?>
                    </tr>
                        
                        
                      </tbody>
                    </table>
                    
                </div>
            </div>
        
        <div class="clearfix"></div>
        </div>
        <div class="clearfix" style="height:15px;">.</div>
</div>
<?php } ?>