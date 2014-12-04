<?php  
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
$rs=mysql_query("select state_id,state_name from ".PAGESTA." where country_id='".$_POST['id']."' order by state_name");
?>
<select  name="state" id="state" onchange="load_city(this.value);" style="width:200px;" >
<option value="">--- Select State ---</option>
<?php
while($row=mysql_fetch_row($rs)){
?>
<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
<?php } ?>
</select>