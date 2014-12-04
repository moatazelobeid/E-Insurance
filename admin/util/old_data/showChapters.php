<?php
include("../../config/config.php");
include("../../config/tables.php");
$id = $_POST["id"];
$rs=mysql_query("select * from ".CHAPTERTBL." WHERE subject_id = '".$id."' AND status = '1' order by chapter_title");
?>

    <select name="chapter_id" id="chapter_id" style="width: 193px; font-weight: normal;">

	<option value="" selected="selected">-- Select --</option>

	<?php while($row=mysql_fetch_array($rs)){?>

    <option value="<?php echo $row["id"]; ?>"><?php echo stripslashes($row["chapter_title"]); ?></option>

	<?php }?>

    </select>