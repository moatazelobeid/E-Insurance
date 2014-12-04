<?php
include("../../config/config.php");
include("../../config/tables.php");
$id = $_POST["id"];

	$rs=mysql_query("select * from ".PAGESTA." WHERE country_id = '".$id."' order by state_name");
	?>
    <select name="state_id" id="state_id" onChange="populateCity(this.value)" style="width: 205px;">
	<option value="" selected="selected" disabled="disabled">-- Select State --</option>
	<?php while($row=mysql_fetch_array($rs)){?>
    <option value="<?php echo $row["state_id"]; ?>"><?php echo stripslashes($row["state_name"]); ?></option>
	<?php }?>
    </select>