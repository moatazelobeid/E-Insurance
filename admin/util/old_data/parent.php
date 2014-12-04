<?php  
include("../../config/config.php");
include_once("../../config/tables.php");

if(isset($_POST['id'])){?>
<select name="menu_parent" size="10" id="menu_parent" style="width:205px;">
          <option value="">--- Select Parent ---</option>
          <?php  
		  $acc=mysql_query("select * from ".PAGEMENU." WHERE menu_position = '".$_POST['id']."' ORDER BY menu_id ASC");
   while($acci=mysql_fetch_array($acc)){
	   ?>
           <option value="<?php echo $acci["menu_id"]; ?>" <?php if($menu_parent == $acci["menu_id"] ) echo "selected='selected'"; ?>><?php echo $acci["menu_title"]; ?></option>
          <?php }?>
        </select>
<?php

 } ?>