<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");
include_once("../../classes/dbFactory.php");
include_once("../../paging/pagination.php");
if(siteAuth($_SESSION['atype']) == 2){
	header("location:index.php?log=1");
}
$id=$_GET["id"];
$sq = mysql_query("select * from ".COMPANYTBL." WHERE id='".$id."'");
$smq=mysql_fetch_array($sq);

$sq = mysql_query("select * from ".LOGINTBL." WHERE uid='".$id."' AND user_type = 'C'");
$smq1=mysql_fetch_array($sq);
?>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">

<tr>
		<td style="padding: 5px;">
          	<table width="70%" border="0" cellspacing="0" cellpadding="2">
          		<tr>
					
		<td align="left"><img src='../upload/company/<?php if($smq["comp_logo"]!= ''){ echo $smq["comp_logo"];}else {echo "no-image.jpg";} ?>' height="100" width="100"  /></td>
				</tr>
				
          	</table>
		</td>
	</tr>
	
	
    <tr>
      	<td width="50%" valign="top" style="padding-right: 10px;"> 
		
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
    	<td width="36%" align="left" style="border-bottom: 0px solid #99C; padding: 3px;"><strong>Company ID:</strong>		</td>
		<td width="64%"><?php echo $smq["comp_code"]; ?></td>
    </tr>
  </table>		
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
    <td width="36%" align="left" style="border-bottom: 0px solid #99C; padding: 3px;"><strong>Company Name:</strong>	</td>
	<td width="64%"><?php echo $smq["comp_name"]; ?></td>
    </tr>
    
</table>		

<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
    	<td style="padding: 5px;">
        	<table width="100%" border="0" cellspacing="6" cellpadding="0" style="margin-bottom: 0px;">
				<tr>
					<td width="36%" valign="top"><strong>Description:</strong></td>
					<td width="64%"><?php echo $smq["comp_description"]; ?></td>
				</tr>
				<tr>
    				<td><strong>Contact Person :</strong></td>
   					 <td><?php echo $smq["comp_contact_person"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Email:</strong></td>
    				<td><?php echo $smq["comp_email"]; ?></td>
  				</tr>
				
				<tr>
    				<td><strong>Address1:</strong></td>
    				<td><?php echo $smq["comp_address1"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Address2:</strong></td>
    				<td><?php echo $smq["comp_address2"]; ?></td>
  				</tr>
				
				<tr>
    				<td><strong>Phone(M):</strong></td>
    				<td><?php echo $smq["comp_phone1"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Phone(H):</strong></td>
    				<td><?php echo $smq["comp_phone2"]; ?></td>
  				</tr>
				
				<tr>
    				<td><strong>City:</strong></td>
    				<td><?php echo $smq["comp_city"]; ?></td>
  				</tr>
				
				<tr>
    				<td><strong>State:</strong></td>
    				<td><?php echo $smq["comp_state"]; ?></td>
  				</tr>
				
				<tr>
    				<td><strong>Country:</strong></td>
    				<td><?php echo $smq["comp_country"]; ?></td>
  				</tr>
				
				<tr>
    				<td><strong>Zip:</strong></td>
    				<td><?php echo $smq["comp_zip"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Fax:</strong></td>
    				<td><?php echo $smq["comp_fax"]; ?></td>
  				</tr>
			</table>
		</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Login Details:</strong>
	</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
    	<td style="padding: 5px;">
        	<table width="100%" border="0" cellspacing="6" cellpadding="0" style="margin-bottom: 0px;">
            	<tr>
					<td width="35%"><strong>Username:</strong></td>
					<td width="65%"><?php echo $smq1["uname"]; ?></td>
				</tr>
				<tr>
					<td><strong>Password:</strong></td>
					<td><?php echo base64_decode($smq1["pwd"]); ?></td>
				</tr>  
			</table>
		</td>
    </tr>
</table>

		</td>
	 
    </tr>
</table>
