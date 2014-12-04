<?php  
include("../../config/config.php");
//mysql_connect("mysql50-64.wc2.dfw1.stabletransit.com","526863_rea","Rea_mass123456");
//mysql_select_db("526863_rea");

if(isset($_POST['id'])){

$rs5=mysql_query("select * from bcf_menu where menu_position='".$_POST['id']."' ORDER BY menu_order ASC");
$i=1;
?>
<select name="menu_order" id="menu_order">
<option value="">--- Select Order ---</option>
<?php
while($row=mysql_fetch_array($rs5)){
?>
<option value="<?php echo $i; ?>"><?php echo $i. "  " .$row["menu_title"]; ?></option>
<?php $i=$i+1; } ?>
</select>
<?php

 } ?>