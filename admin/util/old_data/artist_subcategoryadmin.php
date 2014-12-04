<?php
include_once("../../config/config.php");
require_once("../../config/tables.php");
include_once("../../config/functions.php");
include_once("../../classes/dbFactory.php");
$db = new dbFactory();
$id = $_POST["id"];
$scat = $_POST['scat'];
  $rs=mysql_query("select * from ".SUBCATEGORYTBL." WHERE subject_id = '".$id."' order by id");
	?> 
	<option value="" >Select subcategory</option>
	<?php while($row=mysql_fetch_array($rs)){?>
    <option value="<?php echo $row["id"]; ?>" <?php if($row["id"] == $scat) {?> selected="selected" <?php } ?>><?php echo stripslashes($row["chapter_title"]); ?></option>
	<?php }?>