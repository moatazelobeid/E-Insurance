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
$sq = mysql_query("select * from ".AGENTTBL." WHERE id='".$id."'");
$smq=mysql_fetch_array($sq);

$sq = mysql_query("select * from ".LOGINTBL." WHERE uid='".$id."' AND user_type = 'A'");
$smq1=mysql_fetch_array($sq);

$sq = mysql_query("select * from ".COMPANYTBL." WHERE id='".$smq['comp_id']."'");
$smq2 = mysql_fetch_array($sq);
?>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
    <tr>
      	<td width="50%" valign="top" style="padding-right: 10px;"> 
		
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    
  </table>		
		
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Broker Details:</strong>
	</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
    	<td style="padding: 5px;">
        	<table width="100%" border="0" cellspacing="6" cellpadding="0" style="margin-bottom: 0px;">
			  <tr>
    	        <td width="42%" align="left" style="border-bottom: 0px solid #99C;"><strong>Broker ID:</strong></td>
		        <td width="58%"><?php echo $smq["ag_code"]; ?></td>
              </tr>
	
            	<tr>
                	<td width="42%"><strong>First Name:</strong></td>
                  	<td width="58%"><?php echo $smq["ag_fname"]; ?></td>
                </tr>
				<tr>
    				<td><strong>Last Name:</strong></td>
    				<td><?php echo $smq["ag_lname"]; ?></td>
  				</tr>
				<tr>
					<td><strong>Date Of Birth:</strong></td>
					<td><?php echo $smq["ag_dob"]; ?></td>
				</tr>
				<tr>
    				<td><strong>Gender:</strong></td>
   					 <td><?php if($smq["ag_sex"]=="M") {echo "Male";} else echo "Female"; ?></td>
  				</tr>
				
				<tr>
    				<td><strong>Address1:</strong></td>
    				<td><?php echo $smq["ag_address1"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Address2:</strong></td>
    				<td><?php echo $smq["ag_address2"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Email:</strong></td>
    				<td><?php echo $smq["ag_email"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Phone(M):</strong></td>
    				<td><?php echo $smq["ag_phone1"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Phone(H):</strong></td>
    				<td><?php echo $smq["ag_phone2"]; ?></td>
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
					<td width="42%"><strong>Username:</strong></td>
					<td width="58%"><?php echo $smq1["uname"]; ?></td>
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
