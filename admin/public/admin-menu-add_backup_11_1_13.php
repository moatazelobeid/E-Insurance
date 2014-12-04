<?php
if($_REQUEST['task']=='delete')
{

 $sqql="delete from ".ADMMENU." where menu_id='".$_REQUEST['id']."'";

 $qrr=mysql_query($sqql);
}


if($_GET['task']=='edit'){

	$id=$_GET['id'];

	$sqlu=mysql_query("select * from ".ADMMENU." where menu_id='$id'");
	$sqldet=mysql_fetch_array($sqlu);

}

if($_GET['task']=='block'){

	$id=$_GET['id'];

	$sqlu=mysql_query("update ".ADMMENU." set status='0' where menu_id='$id'");

}

if($_GET['task']=='active'){

	 $id=$_GET['id'];

	$sqlp="update ".ADMMENU." set status='1' where menu_id='$id'";

	$resultp=mysql_query($sqlp);

}

 if($_GET['task']=='edit')

{

	$btn_name = "update";

	$btn_value = " Update ";

	$cancel = "<a href='account.php?page=admin-menu-add&manage=list'>Cancel</a>";

}

else
{
	
	$btn_name = "save";

	$btn_value = " Add  ";
	
}
	



// save record

if(isset($_POST['save']))

{

	// params

	$menuname = $_POST['menu_name'];

	$status = $_POST['status'];

	$msg = "";

	// save

	$sq_save = "INSERT INTO ".ADMMENU." (menu_name,status) VALUES('".$menuname."','".$status."')";

	$res_save = mysql_query($sq_save);

	

		header("location:account.php?page=admin-menu-add&manage=list");

	

}



// edit record





// update

if(isset($_POST['update']))

{

	// params

	$menunm = $_POST['menu_name'];
	//$catid = $_POST['selectcat'];

	//$content = addslashes(trim($_POST['content']));

	$status = $_POST['status'];

	$menu_id = $_POST['menu_id'];

	$msg = "";

	// save

	$sq_update = "UPDATE ".ADMMENU." SET menu_name = '".$menunm."',status = '".$status."' WHERE menu_id = '".$menu_id."'";

	$res_update = mysql_query($sq_update);

	
		header("location:account.php?page=admin-menu-add&manage=list");

	
}

$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 

?>

<script type="text/javascript" >

function form_validate()
{ 

	if(document.getElementById("menu_name").value=="")
	{
	alert("Please enter the menu name");
	document.getElementById("menu_name").focus();
	return false;
	}
	
}

</script>
	
<!-- app -->
<div style="width: 700px; margin: 0 auto; margin-top: 10px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td width="67%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Add/Edit Admin Menu</strong></td>
      
    </tr>
    <?php if($msg <> ""){
?>
  <div style="border: 1px solid #990; background-color: #FFC; padding: 2px; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="7%"><img src="../images/warning.png" width="32" height="32"></td>
<td width="93%"><?php echo $msg; ?></td>
</tr>
</table>
</div>
<?php } ?>
  </table>
  <form action="" method="post" name="partcat_form" onSubmit="return form_validate()">
  <table width="100%" border="0" cellspacing="0" cellpadding="3" >
  
  <tr>
    <td style="padding-right: 5px;" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0" height="18" bgcolor="#f2f2f2">
      <tr>
        <td>Add/Edit Menu</td>
      </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
        
        
        <tr>
        <td width="33%" height="42"><div align="right">Menu Name:</div></td>
        <td width="67%">
       <input name="menu_name" type="text" id="menu_name"  style="width: 187px;" class="textbox" value="<?php echo $sqldet['menu_name'] ; ?>" />
       </td>
    </tr>
    
      <tr>
        
        <td width="33%" style="padding-left: 0px;"><div align="right">Set Status:</div></td>
        
        <td width="67%" style="padding-right: 0px;"><select name="status" id="status" style="width: 193px; font-weight: normal;">
          
          <option value="1" <?php if($sqldet['status'] == '1') echo "selected='selected'"; ?>>Active</option>
          
          <option value="0" <?php if($sqldet['status'] == '0') echo "selected='selected'"; ?>>Inactive</option>
          
          </select></td>
        
      </tr>
  
      <tr>
        <td></td><td height="66" ><input name="<?php echo $btn_name; ?>" type="submit" id="<?php echo $btn_name; ?>" value="<?php echo $btn_value; ?>" class="actionBtn" />
          <span style="padding-left: 4px;">
            <input type="hidden" name="menu_id" value="<?php echo $_GET['id']; ?>" />
  &nbsp;&nbsp;<?php echo $cancel; ?></span></td>
      </tr>
    </table>
  </td>
  
        <td valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="2" align="left">
          <tr style="color: #FFF;">
            <td  align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td  align="left" bgcolor="#333333"><strong> Menu Name</strong></td>
           
            <!--<td width="13%" align="center" bgcolor="#333333"><strong>View</strong></td>-->
            <td  align="center" bgcolor="#333333"><strong>Status</strong></td>
            <td  align="center" bgcolor="#333333"><strong>Action</strong></td>
          </tr>
          		
		<?php 
		
		$sq = "select * from ".ADMMENU." ORDER BY menu_id LIMIT ".$startpoint.",".$perpage."";
					
		$rs=mysql_query($sq);
		
		$i=1;
	
		while($row=mysql_fetch_array($rs)){
		
		?>
          <tr <?php echo $bgcolor; ?>>
            <td align="center" ><strong><?php echo $i; ?></strong></td>
            
            <td ><?php echo $row["menu_name"]; ?></td>
            
           <!-- <td align="center" ><a id="fancy" href="public/faq_ans.php?id=<?php //echo $row['rid']; ?>"><img src="images/view_all.png" width="87" height="15" border="0"></a></td>-->
            <td align="center" ><?php 
			
			if($row["status"]=='0') { ?>
              <a href="account.php?page=admin-menu-add&task=active&manage=list&id=<?php echo $row["menu_id"]; ?>">In Active
              <?php } else {?>
              </a><a href="account.php?page=admin-menu-add&task=block&manage=list&id=<?php echo $row["menu_id"]; ?>">Active
                  
                  </a>
            <?php } ?></td>
            <td align="center" ><a href="account.php?page=admin-menu-add&task=edit&id=<?php echo $row["menu_id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a>&nbsp;<a href="account.php?page=admin-menu-add&task=delete&manage=list&id=<?php echo $row["menu_id"];  ?>" onclick="return confirm('ARE YOU SURE TO DELETE!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a></td>
          </tr>
          <?php $i=$i+1;} ?>
          <tr>
            <td colspan="7" align="center"><?php
			
				 
					echo Paging("".USRTBL."",$perpage,"account.php?page=admin-menu-add&");
					
			
			  ?></td>
          </tr>
        </table></td>
      </tr>
    
  </table>
  </form>
</div>
