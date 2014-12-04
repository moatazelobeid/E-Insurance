<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");
include_once("../../classes/dbFactory.php");
$id=$_GET["id"];
$sq12 = mysql_query("select * from ".PACKAGE." WHERE id='".$id."'");
$smq=mysql_fetch_array($sq12);
function getDriverAge($id)
{
	$res = mysql_fetch_object(mysql_query("select age from ".DRIVERAGE." where id=".$id));
	return $res->age;
}
function getVType($id)
{
	$res = mysql_fetch_object(mysql_query("select type_name from ".VTYPE." where id=".$id));
	return $res->type_name;
}

?>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
    <tr>
      	<td width="50%" valign="top" style="padding-right: 10px;"> 
		
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;"></table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2; font-size:14px;"><strong>Policy Details:</strong>
	</td>
    </tr>
</table>	
  
<table width="100%" border="0" cellspacing="0" cellpadding="2">  
    <tr>
    <td width="30%" style="padding-left: 10px;padding-bottom: 2px;"><strong>Policy Class:</strong></td>
    <td width="70%">
	<?php 
    echo array_shift(mysql_fetch_array(mysql_query("SELECT title FROM ".POLICIES." WHERE id IN (SELECT policy_class_id FROM ".PRODUCTS." WHERE id = '".$smq['product_id']."')")));
    ?></td>
    </tr>

    <tr>
    <td style="padding-left: 10px;padding-bottom: 2px;"><strong>Policy Type:</strong></td>
    <td><?php echo ($smq["policy_type"] == 'tpl')?"Third Party Liability":"Comprehensive"; ?></td>
    </tr>
</table>             
                	
		
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2; font-size:14px"><strong>Package Details:</strong>
	</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
    	<td style="padding: 5px;">
        	<table width="100%" border="0" cellspacing="6" cellpadding="0" style="margin-bottom: 0px;">
			  <tr>
    	        <td width="30%" align="left" style="border-bottom: 0px solid #99C;"><strong>Package No.</strong></td>
		        <td width="70%"><?php echo $smq["package_no"]; ?></td>
              </tr>
	
            	<tr>
                	<td width="30%"><strong>Package Title:</strong></td>
                  	<td width="70%"><?php echo $smq["package_title"]; ?></td>
                </tr>
				<tr>
    				<td><strong>Package Title (AR):</strong></td>
    				<td><?php echo $smq["package_title_ar"]; ?></td>
  				</tr>
				<tr>
					<td><strong>Package Description:</strong></td>
					<td><?php echo $smq["package_desc"]; ?></td>
				</tr>
				<tr>
    				<td><strong>Package Description (AR):</strong></td>
   					<td><?php echo $smq["package_desc_ar"]; ?></td>
  				</tr>
			
            <?php if($smq["policy_type"] == 'comp'){?>
                
                <tr>
                    <td valign="top"><strong>Vehicle Make: </strong></td>
                    <td>
                    <?php 
                    echo $make = array_shift(mysql_fetch_array(mysql_query("SELECT make FROM ".VMAKE." WHERE id = '".$smq["vehicle_make_comp"]."'")));
                    ?>
                    </td>
                </tr>
          
                <tr>
                <td valign="top"><strong>Vehicle Model:</strong></td>
                <td>
                <?php echo $sql2 = array_shift(mysql_fetch_array(mysql_query("SELECT model FROM ".VMODEL." WHERE id = '".$smq["vehicle_model_comp"]."'")));?>
                </td>
              </tr>
          
          		<tr>
            <td valign="top"><strong>Vehicle Type: </strong></td>
            <td><?php echo $sql3 = array_shift(mysql_fetch_array(mysql_query("SELECT type_name FROM ".VTYPE." WHERE id = '".$smq["vehicle_type_comp"]."'"))); ?></td>
          </tr>
           
        	    <tr>
            <td valign="top"><strong>Agency Repair: </strong></td>
            <td><?php echo $smq["is_agency_repair"] == '1'?'Yes':'No';?></td>
          </tr>
          
                <tr>
            <td valign="top"><strong>No Claims Certificate: </strong></td>
            <td><?php echo $smq["no_of_ncd"];?></td>
          </tr>
          
		    <?php }else{?>
           <tr>
            <td valign="top"><strong>Vehicle Type: </strong></td>
            <td><?php echo getVType($smq['vehicle_type_tpl']);?></td>
          </tr>
          
            <tr>
            <td valign="top"><strong>Driver Age:</strong></td>
            <td><?php echo (!empty($smq['driver_age']))?getDriverAge($smq['driver_age']):'N/A'; ?></td>
          </tr>
          
            <tr>
            <td valign="top"><strong>Premium Amount:</strong></td>
            <td><?php echo $smq['package_amt'];?> SR</td>
          </tr>

         <?php /*?> <tr>
            <td valign="top"><strong>Specification (Cylinders): </strong></td>
            <td><?php echo $smq['vehicle_cylender_tpl'];?></td>
          </tr>
          
          
            <tr>
            <td valign="top"><strong>Weight of the Vehicle (tons) :</strong></td>
            <td><?php echo $smq['vehicle_weight_tpl'];?></td>
          </tr>

          <tr>
            <td valign="top"><strong>Number of Seats: </strong></td>
            <td><?php echo $smq['vehicle_seats_tpl'];?></td>
          </tr><?php */?>
         <?php }?>
          
	  </table>
		</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2; font-size:14px;"><strong>Coverage Details:</strong>
	</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
    	<td style="padding: 5px;">
        	<table width="100%" border="0" cellspacing="6" cellpadding="0" style="margin-bottom: 0px;">
            <?php 
			$sq13 = mysql_query("select * from ".PACKAGECOVER." WHERE package_no='".$smq['package_no']."'") or die(mysql_error());
			if(mysql_num_rows($sq13) > 0)
			{
				while($arr = mysql_fetch_array($sq13))
				{
				
				  $cover_name = array_shift(mysql_fetch_array(mysql_query("SELECT cover_title FROM ".PRODUCTCOVERS." WHERE id = '".$arr['cover_id']."'")));
				  
				?>
				<tr>
					<td width="17%"><strong><?php echo $cover_name;?>:</strong></td>
					<td width="18%"><strong>Amount</strong>: <?php echo $arr["cover_amt"];?></td>
                    <td width="65%"><strong>coverage</strong>: <?php echo $arr["coverage"];?></td>
				</tr>
				<?php }
			}
			?>
			</table>
		</td>
    </tr>
</table>
<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2; font-size:14px;"><strong>Optional and additional Coverage:</strong>
	</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	  <tr>
      	<td colspan="2">
        	<table>
                <tr>
                    <td>Each Passenger Price</td> 
                    <td>
                        <?php echo $smq['psngr_price'];?> SR
                    </td>
                </tr>
                <tr height="10">
                	<td colspan="2"></td>
                </tr>
            	<tr>
                    <td width="200"><strong>Driver Age</strong></td>
                    <td align="center"><strong>Price (SR)</strong></td>
                </tr>
                <?php
				$package_no = $smq['package_no']; 
				//echo "SELECT a.*, b.age FROM ".PACKAGEPRICE." as a left join ".DRIVERAGE." as b on b.id = a.driver_age WHERE a.package_no = '".$package_no."'";
				
				$dages = mysql_query("SELECT a.*, b.age FROM ".PACKAGEPRICE." as a left join ".DRIVERAGE." as b on b.id = a.driver_age WHERE a.package_no = '".$package_no."'");
				if(mysql_num_rows($dages) > 0)
				{
					while($dage = mysql_fetch_array($dages))
					{
						?>
                        <tr>
                            <td><?php echo stripslashes($dage['age']);?></td> 
                            <td>
                                <?php echo $dage['price'];?>
                            </td>
                        </tr>
                        <?php 	
					}	
				}
				else
				{
					?>
                    <tr><td colspan="2">No price added for any driver age.</td></tr>
                    <?php 
				}
				?>
            </table>
        </td>
      </tr>	
	  <tr>
		<td colspan="2" style="padding-top: 10px; padding-left: 0px;">
		<?php
		if($_GET['id'] != "" && $_GET['task'] == "package_edit"){
    	?>
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn">
        <?php }else{ ?>
        <input type="submit" name="save" id="save" value=" Save  " class="actionBtn" onclick="return validatePackageForm();">
        <?php } ?>
		<input type="button" name="exit" id="exit" value=" Exit " class="actionBtn" onclick="location.href='account.php?page=package'">
		</td>
	  </tr>
	</table><?php */?>


		</td>
	 
    </tr>
</table>
