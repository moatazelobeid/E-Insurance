<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/functions.php");
include_once("../../config/tables.php");
include_once("../../classes/dbFactory.php");

$id=$_GET['id'];
$motor_claim=mysql_fetch_assoc(mysql_query("select * from ".CLAIMMOTOR." where id='".$id."'"));
?>
<style>
#Menu li
{
  z-index:0;
}
.welcomearea_cd th, .welcomearea_cd td
{
	padding:4px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
</style>

<style type="text/css">
.innerpagearea_left_inner_d{width:100%;}
.your-quoatation1{width:100%;}
.your-quoatation-inner1{width:100%;}
.your-quoatation-inner{width:100%;}
.your-quoatation1:hover{width:100%;}
</style>

<div class="your-quoatation1">
 <div class="your-quoatation-inner1">
  <table width="540" border="0" cellpadding="2" cellspacing="4">
	<tr>
	  <td height="30" colspan="5" bgcolor="#F0F0F0" class="bluetxt-norm-14" style="padding-left:5px;" ><span class="formtxt_blue"><strong>Claim  Information</strong></span></td>
	</tr>
	
	<tr>
	  <td  style="text-align:left;"><strong>Claim No: </strong></td>
	  <td width="366" ><span class="item dateofbirth"><?php echo $motor_claim['claim_no'];?></span></td>
	  </tr>
	<tr>
	  <td  style="text-align:left;"><strong>Policy No: </strong></td>
	  <td ><span class="item dateofbirth"><?php echo $motor_claim['policy_no'];?></span></td>
	  </tr>
	<tr>
	  <td  style="text-align:left;"><strong>Date of Claim: </strong></td>
	  <td ><span class="item dateofbirth"><?php echo date("d/m/Y",strtotime($motor_claim['created_date']));?></span></td>
	  </tr>
	<tr>
	 <td width="114"  style="text-align:left;"><strong>Loss Date: </strong></td>
	 <td ><span class="item dateofbirth"><?php echo date("d/m/Y",strtotime($motor_claim['loss_date']));?></span></td>
	</tr>
	

	<tr>
	  <td  valign="top"><span class="form_txt1 fieldLabel1"><strong>Claim For: </strong></span></td>
	  <td  valign="top"><?php echo stripslashes($motor_claim['claim_for']); ?></td>
	</tr>
	
	<tr>
	  <td ><span class="form_txt1 fieldLabel1"><strong><span class="fieldLabel form_txt1">Claim Place</span>: </strong></span></td>
	  <td ><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['claim_place']);?></span></td>
	</tr>
	
	
	<tr>
	  <td ><span class="form_txt1 fieldLabel1"><strong><span class="fieldLabel form_txt1">Police Station</span>: </strong></span></td>
	  <td ><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['claim_police_station']);?></span></td>
	</tr>
	
	
	<tr>
	  <td ><span class="form_txt1 fieldLabel1"><strong><span class="fieldLabel form_txt1">FIR No</span>: </strong></span></td>
	  <td ><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['fir_no']);?></span></td>
	</tr>
	
	
	<tr>
	  <td colspan="2"  valign="top"><span class="form_txt1 fieldLabel1"><strong><span class="fieldLabel form_txt1">Brief Description of Accident/ Theft</span>: </strong></span></td>
	  </tr>
	<tr>
	  <td colspan="2"  valign="top"><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['brief_description']);?></span></td>
	  </tr>
	
	<tr>
	  <td colspan="2"  valign="top"><span class="form_txt1 fieldLabel1"><strong>Claim Description: </strong></span></td>
	  </tr>
	<tr>
	  <td colspan="2"  valign="top"><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['claim_details']);?></span></td>
	  </tr>
   </table>
</div>
</div>