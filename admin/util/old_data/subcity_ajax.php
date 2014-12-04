<?php  
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
//mysql_connect("mysql50-64.wc2.dfw1.stabletransit.com","526863_rea","Rea_mass123456");
//mysql_select_db("526863_rea");

$rs=mysql_query("select city_id,city_name from ".PAGECITY." where state_id='".$_POST['id']."' order by city_name");
?>
<select name="city" id="city" style="width:200px;">
<option value="">--- Select City ---</option>
<?php
while($row=mysql_fetch_row($rs)){
?>
<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
<?php } ?>
</select>