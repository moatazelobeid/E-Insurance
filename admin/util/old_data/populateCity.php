<?php
include("../../config/config.php");
include("../../config/tables.php");
$id = $_POST["id"];

	$rs=mysql_query("select * from ".PAGECITY." WHERE state_id = '".$id."' order by city_name");
	?>
    <select name="city_id" id="city_id" style="width: 205px;">
	<option value="" selected="selected" disabled="disabled">-- Select City --</option>
	<?php while($row=mysql_fetch_array($rs)){?>
    <option value="<?php echo $row["city_name"]; ?>"><?php echo stripslashes($row["city_name"]); ?></option>
	<?php }?>
    </select>