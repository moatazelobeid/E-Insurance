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
$sq = mysql_query("select * from ".EMPLOYEETBL." WHERE id='".$id."'");
$smq=mysql_fetch_array($sq);

$sq = mysql_query("select * from ".LOGINTBL." WHERE uid='".$id."' AND user_type = 'E'");
$smq1=mysql_fetch_array($sq);

$sql_emptype= mysql_query("SELECT * FROM ".EMPTYPE." WHERE id = '".$smq['emp_type_id']."'");
$row_emptype= mysql_fetch_array($sql_emptype);
if($row_emptype)
  {
		  $employeetype=$row_emptype['emp_type'];
  }
  else
  {
		  $employeetype="Not Assigned";
  }
?>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">

<tr>
		<td style="padding: 5px;">
          	<table width="70%" border="0" cellspacing="0" cellpadding="2">
          		<tr>
				<?php 
				if($smq["emp_photo"]!= 0)
					$pimage=SITE_URL.'upload/user/'.$smq['emp_photo'];
				else
					$pimage=SITE_URL.'upload/user/no-image.jpg';
				?>	
		<td align="left"><img src='<?php echo $pimage; ?>' height="100" width="100"  /></td>
				</tr>
				
          	</table>
		</td>
	</tr>
	
	
    <tr>
      	<td width="50%" valign="top" style="padding-right: 10px;"> 
		
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
    	<td width="42%" align="left" style="border-bottom: 0px solid #99C; padding: 3px;"><strong>Employee ID:</strong>		</td>
		<td width="58%"><?php echo $smq["emp_code"]; ?></td>
    </tr>
  </table>		
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
    <td width="42%" align="left" style="border-bottom: 0px solid #99C; padding: 3px;"><strong>Employee Type:</strong>	</td>
	<td width="58%"><?php echo $employeetype;  
	//if($smq["emp_type_id"]=="9") {echo "Super Admin";} else if($smq["emp_type_id"]=="10") {echo "Service Engineer";} else if($smq["emp_type_id"]=="25") {echo "Accountant";} else echo "Not Assigned"; ?></td>
    </tr>
    
</table>		
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Employee Details:</strong>
	</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
    	<td style="padding: 5px;">
        	<table width="100%" border="0" cellspacing="6" cellpadding="0" style="margin-bottom: 0px;">
            	<tr>
                	<td width="42%"><strong>First Name:</strong></td>
                  	<td width="58%"><?php echo $smq["emp_fname"]; ?></td>
                </tr>
				<tr>
    				<td><strong>Last Name:</strong></td>
    				<td><?php echo $smq["emp_lname"]; ?></td>
  				</tr>
				<tr>
					<td><strong>Date Of Birth:</strong></td>
					<td><?php echo $smq["emp_dob"]; ?></td>
				</tr>
				<tr>
    				<td><strong>Gender:</strong></td>
   					 <td><?php if($smq["emp_sex"]=="M") {echo "Male";} else echo "Female"; ?></td>
  				</tr>
				<tr>
    				<td><strong>Blood Group:</strong></td>
    				<td><?php echo $smq["emp_blood_group"]; ?></td>
  				</tr>
				
				<tr>
    				<td><strong>Address1:</strong></td>
    				<td><?php echo $smq["emp_address1"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Address2:</strong></td>
    				<td><?php echo $smq["emp_address2"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Email:</strong></td>
    				<td><?php echo $smq["emp_email"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Phone(M):</strong></td>
    				<td><?php echo $smq["emp_phone1"]; ?></td>
  				</tr>
				<tr>
    				<td><strong>Phone(H):</strong></td>
    				<td><?php echo $smq["emp_phone2"]; ?></td>
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



<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
	<tr>
    <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Office detail:</strong>
	</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
    	<td style="padding: 5px;">
        	<table width="100%" border="0" cellspacing="6" cellpadding="0" style="margin-bottom: 0px;">
            	<tr>
					<td width="42%"><strong>Date Of Joining:</strong></td>
					<td width="58%"><?php echo $smq["date_of_join"]; ?></td>
				</tr>
				<tr>
					<td><strong>Date Of Leave:</strong></td>
    				<td><?php echo $smq["date_of_leave"]; ?></td>
    			</tr>    
				<tr>
        			<td><strong>Employee status:</strong></td>
       				<td><?php if($smq1["is_active"]=="1") {echo "Active";} else if($smq["is_active"]=="0") {echo "In Active";} else echo "Status Not Available"; ?></td>
        		</tr>  
			</table>
		</td>
    </tr>
</table>











		</td>
	 
    </tr>
</table>
