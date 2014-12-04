<?php  
include("../../config/config.php");
 $id=$_POST["id"];

	$rs=mysql_query("select * from master_city where country_id='$id' order by city_name");?>
    <select name="city_id" id="city_id" onChange="red_c()">
	<option value="" selected="selected" disabled="disabled">-- Select City --</option>
	<?php while($row=mysql_fetch_assoc($rs)){?>
    <option value="<?php echo $row["city_id"]; ?>"><?php echo stripslashes($row["city_name"]); ?></option>
	<?php }?>
    </select>
	