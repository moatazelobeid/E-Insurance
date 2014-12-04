<?php 

if(isset($_GET["id"]))
{
	$id=$_GET["id"];
	$part = $_GET['part'];
	$sq = mysql_query("select * from ksa_user WHERE id='".$id."'");
	$loginsql = mysql_query("select * from ksa_login WHERE uid='".$id."' and user_type = 'U'");
}
$customerdetails=mysql_fetch_assoc($sq);
$logindetails = mysql_fetch_assoc($loginsql);
if(mysql_num_rows($sq)>0)
{

?><table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
      <td align="left" style=" padding-left: 0px; font-size: 14px; color: #036;">&nbsp;</td>
      <td align="right" style="  padding-right: 0px;">
	  <a href="account.php?page=customer-list&<?=(!empty($part))?'part='.$part:''?>" class="linkBtn <?php if($_GET['page'] == "view-policy") echo "active"; ?>">&#8592;Back to customer list</a>
	  </td>
    </tr>
  </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
    <tr>
        <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Customer Details:</strong></td>
      </tr>
    </table>		
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 2px;">
          
                <tr>
                	<td width="11%"  height="35" style="padding-left: 2px;"><strong>Customer Id:</strong></td>
                  <td width="37%"  height="35" style=" padding-left: 2px;"><?=$customerdetails['customer_code']?></td>
                  <td width="16%" align="left" style="border-bottom: 0px solid #99C; "><strong>Customer Type:</strong></td>
                  <td width="36%" height="35" colspan="2"><?php if($customerdetails['customer_type'] == 1){echo 'Individual';}else{echo 'Commercial';}?></td>
                </tr>
              
	  </table>
	
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
        <tr>
          <td width="48%" valign="top" style="padding-right: 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
              <tr>
           <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Personal  Details</strong></td>
        </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td style="padding-top: 5px;"><table width="100%" border="0" cellspacing="0" cellpadding="2">
            
            	<?php /*?><tr>
                  <td style="padding-left: 0px; padding-top:5px">Salutation:</td>
                  <td><?=$customerdetails['salutation']?></td>
                </tr> <?php */?>               
                <tr>
                  <td style="padding-left: 0px;padding-top:5px">Name:</td>
                  <td><?=$customerdetails['fname']?></td>
                </tr>
                <?php /*?><tr>
                  <td width="19%" style="padding-left: 0px;padding-top:5px;">Last Name:</td>
                  <td width="81%"><?=$customerdetails['lname']?>
				  </td>
                </tr><?php */?>
              
                <tr>
                  <td style="padding-left: 0px;padding-top:5px;">Date of Birth:</td>
                  <td><?=date('d/m/Y',strtotime($customerdetails['dob']))?></td>
                </tr>
            	<tr>
                  <td width="24%" style="padding-left: 0px;padding-top:5px;">Gender:</td>
                  <td width="76%" style="padding-left: 0px;"><?=($customerdetails['gender'] == 'm')?'Male':'Female'?> </td> 
                </tr>
                <tr>
                  <td width="19%" style="padding-left: 0px;padding-top:5px;">Email:</td>
                  <td width="81%"><?=$customerdetails['email']?>
				  </td>
                </tr>
                <?php /*?><tr>
                  <td width="19%" style="padding-left: 0px;padding-top:5px;">Occupation:</td>
                  <td width="81%"><?=$customerdetails['occupation']?>
				  </td>
                </tr><?php */?>
               
                <?php if(isset($_GET['id'])){?>
                <tr>
                  <td style="padding-left: 0px;padding-top:5px;">Status:</td>
                  <td><?php if($logindetails['is_active'] == '1'){ echo "Active";}else{echo "Inactive";} ?></td>
                </tr>
                <?php }?>
                <?php if(!empty($customerdetails['cus_photo']))
				{?>
                <tr>
                  <td style="padding-left: 0px;padding-top:5px; " colspan="2"><img width="50" height="50"  src="<?php echo SITE_URL.'upload/user/'.$customerdetails['cus_photo'];?>"/></td>
                </tr>
                <?php } ?>
                
              </table></td>
          </tr>
           <tr >
            <td align="left"  style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Account Information</strong></td>
          </tr>
           <tr>
          <td><table width="100%" cellpadding="3" >
             	  <tr>
                  <td width="24%" style="padding-left: 0px; padding-top:5px">Account Name:</td>
                  <td width="76%"><?=$customerdetails['accname']?></td>
                </tr>
                <tr>
                  <td width="24%" style="padding-left: 0px;padding-top:5px">Account Number:</td>
                  <td width="76%"><?=$customerdetails['accno']?></td>
                </tr>
  				<tr>
                  <td width="24%" style="padding-left: 0px;padding-top:5px">Driving License No:</td>
                  <td width="76%"><?=$customerdetails['drive_license_no']?></td>
                </tr>
          </table></td>
          </tr>
        </table></td>
      <td width="52%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
      
          <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Address Details</strong></td>
          </tr>
          <tr>
            <td align="left"><table width="100%" cellpadding="3">
              <?php /*?>  <tr>
                  <td style="padding-left: 0px;">Username :</td>
                  <td>
				  <div id='err_uname' align="left" style="font-size:12px;color:#FF0000; padding-bottom:3px;"></div>
				  <input name="uname" type="text" class="textbox" id="u_id" style="width: 200px;" value="<?php echo $result->uname?>" readonly="readonly" onkeyup="checkUname(this.value);" autocomplete="off"/>
                    <span id="parent" style="font-weight: bold; font-size:10px;padding-left:5px;">*</span></td>
                </tr><?php */?>
                 
                    <?php /*?><tr>
                  <td width="28%"  style=" padding-top:5px;">Address (Primary):</td>
                  <td width="72%" style=" padding-top:5px;"><?=stripslashes($customerdetails['address1'])?>
				  </td>
                </tr>
                <tr>
                  <td width="28%"  style="padding-left: 0px;padding-top:5px;">Address (Secondary):</td>
                  <td width="72%" style="padding-left: 0px; padding-top:5px;"><?=stripslashes($customerdetails['address2'])?>
				  </td>
                </tr><?php */?>
                  <tr>
                  <td style="padding-top:5px;;">Phone(M):</td>
                   <td width="72%" style="padding-left: 0px; padding-top:5px;"><?=stripslashes($customerdetails['phone_mobile'])?>
				  </td>
                </tr>
                <?php /*?><tr>
                  <td style="padding-top:5px;">Phone(L):</td>
                  <td style="padding-top:5px;"><?=stripslashes($customerdetails['phone_landline'])?></td>
                </tr><?php */?>
                <tr>
                  <td style="padding-top:5px;">IQMA Number:</td>
                  <td style=" padding-top:5px;"><?=stripslashes($customerdetails['iqma_no'])?></td>
                </tr>
                 <tr>
                  <td style="padding-top:5px;">Country:</td>
                  <td style="padding-top:5px;"><?=stripslashes($customerdetails['country'])?>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top:5px;">State:</td>
                  <td style="padding-top:5px;"><?=stripslashes($customerdetails['state'])?>
                  </td>
                </tr>
              </table>
              </td>
          </tr><?php if(isset($_GET['id'])){?>
            <tr>
            <td align="left" style="border-bottom: 0px solid #99C; padding: 3px; background-color: #f2f2f2;"><strong>Login details</strong></td>
          </tr>
           <tr>
          <td><table width="100%" cellpadding="3">
                  <tr>
                  <td width="28%" style="padding-top:5px;">Username:</td>
                  <td width="72%"><?=stripslashes($logindetails['uname'])?></td>
                </tr>
               
                <tr>
                  <td width="28%" style="padding-top:5px;">Password:</td>
                  <td width="72%"><?=stripslashes(base64_decode($logindetails['pwd']))?></td>
                </tr>
               
               
          </table></td>
          </tr>
           <?php } ?>
        </table></td>
    </tr>
    
    
  </table>
<?php } ?>