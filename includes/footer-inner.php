<div class="footerpan">
        	<div class="innerwrap_top">
				<div class="fot_L">Copyright &copy; Alsagr Cooperative 2014. All Rights Reserved.</div>
				
				<div class="fot_R">
					<div class="footericons">
                <img src="<?=SITE_URL?>images/footericons.png" alt="" />
            </div>
					<?php $i = 1;
            $row=mysql_query("SELECT * FROM ".PAGEMENU." WHERE menu_position = '3' and footer_menu_position = '2' AND status='1' ORDER BY ordering ASC");
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
		 	<a href="<?php echo $menu_link;?>"<?php echo $cactiv;?>><?php echo stripslashes($menu_title);?></a>
            <?php if($count != $num_rows){echo '&nbsp;|&nbsp;';}?>
            <?php }?> 
				</div>
			</div>
        </div>
		<!--  Footer end  -->	
	</div>
     <script type="text/javascript">
 var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>