<?php
if(isset($_POST['submit']))
{
	mysql_query("delete from ".ACCTBL);
	
	$emp_sql=mysql_query("select * from ".EMPTYPE." where status='1'");
	while($emp=mysql_fetch_array($emp_sql))
	{
		$id=$emp['id'];
		$menus=$_POST['menu-'.$id];
		foreach($menus as $acc_data)
		{
			//echo $acc_data;
			$acc_gal_data=explode("-",$acc_data);
			//echo $acc_gal_data['0'];
			$res=mysql_query("insert into ".ACCTBL." set emp_id='".$id."',menu='".$acc_gal_data['0']."',submenu='".$acc_gal_data['1']."'");
		}
	}
	$msg = "Access Limitation Saved";
}

$emp_sql=mysql_query("select * from ".EMPTYPE." where status='1'");
$count=mysql_num_rows($emp_sql);

?>


<form id="sociallinks_fr" name="sociallinks_fr" method="post" action="" style="padding:0px; margin:0px;" onsubmit="return valid()">
<table width="<?php echo $count*220;?>" border="0" align="center" cellspacing="0" cellpadding="0">
	<tr>
    	<td width="73%" align="left" valign="top" style="border-bottom:1px dashed #6699CC"><h2 class="titletext" style="font-weight: normal;">Manage Access Settings</h2></td>
        <td width="27%" align="left" valign="top" style="border-bottom:1px dashed #6699CC">&nbsp;</td>
    </tr>
	<tr>
    	<td colspan="3" align="right" style="color: #066; font-size: 11px; padding: 0px;">
		<?php if($msg <> "") { ?>
		<div style="border: 1px solid #990; background-color: #FFC; padding: 2px; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td width="93%"><?php echo $msg; ?></td>
			</tr>
		</table>
		</div>
		<?php } ?>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="left" valign="top">
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
 			<tr>
			<?php 
			while($emp=mysql_fetch_array($emp_sql))
			{?>
          	  <td width="220">
 				<table width="100%" border="0" cellspacing="0" cellpadding="5">
  					<tr>
     					<td align="left" bgcolor="#336699" style="padding-left: 4px; font-size: 12px; color: #FFF;"><strong><?php echo $emp['emp_type'];?></strong></td>       
  					</tr>
                    
                    <?php 
					$query = mysql_query("select distinct menu_name from ".SUBMENUTBL." order by id");
					while($data = mysql_fetch_array ($query)){
					?>
  					<tr>
     				<td align="left" bgcolor="#FFFFFF" style="padding-left: 4px; color: #F00;"><strong><?php echo $data['menu_name']; ?></strong></td>       
  					</tr>
                    <?php
                    $q = mysql_query("select * from ".SUBMENUTBL." where menu_name = '".$data['menu_name']."'");
					while($d = mysql_fetch_array ($q)){
					?>
  					<tr>
     				<td align="left" bgcolor="#FFFFFF" style="padding-left: 4px;">
                    <?php $num=mysql_num_rows(mysql_query("select * from ".ACCTBL." where emp_id='".$emp['id']."' and menu='".$d['menu_id']."' and submenu='".$d['submenu_id']."'"));
					?>
                    <input type="checkbox" name="menu-<?php echo $emp['id']; ?>[]" value="<?php echo $d['menu_id']."-".$d['submenu_id']; ?>" <?php if($num==1){?> checked="checked" <?php } ?>/><?php echo $d['submenu_name']; ?>
                    </td>       
  					</tr>
                    <?php }} ?>
				</table>
			</td>
 			<?php }?>
			</tr> 
 		<tr>
        <td height="54" align="left" style="padding-left: 4px;"><input type="submit" name="submit" value="Save" class="actionBtn" /></td>
        </tr>
        </table>
     </td>
    </tr>
</table>
</form>