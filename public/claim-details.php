<?php 
	if(empty($_SESSION['uid']))
	{
		header("location:index.php?page=sign-in");
	}else{
		if(!isset($_GET['id']))
		{
			header("location:index.php?page=claim-list");
		}else{
		$id=$_GET['id'];
		$motor_claim=mysql_fetch_assoc(mysql_query("select * from ".CLAIMMOTOR." where id='".$id."'"));
?>
<div class="innrebodypanel">
    <div class="clearfix" style="height:15px;">.</div>
    <div class="innerwrap">
      <div class="breadcrumb"> <a itemprop="url" href="<?=BASE_URL?>">Home</a> <span class="breeadset">&#8250;</span> <a itemprop="url" href="index.php?page=User-dashboard">Dashboard</a><span class="breeadset">&#8250;</span><strong>Claim Details</strong> </div>
      <div class="leftbokpan">
        <h1>Claim Details</h1>
        <div id="formpan" class="formpan2" style="width:100%!important">
          <form>
          <div class="row1">
            <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Claim Details Information</strong></lable>
          </div>
          <div class="your-quoatation-inner1">
          <div class="box_border_area">
          <form name="claim_form" id="claim_form" onSubmit="return " method="post">
            <table width="100%" border="0" cellpadding="2" cellspacing="4">
                <tbody>
                <tr>
                  <td width="200" valign="top"><span class="form_txt1 301"><strong>Claim No: : </strong></span></td>
                  <td width="851" height="30" valign="top"><?php echo stripslashes($motor_claim['claim_no']); ?></td>
                </tr>
                <tr>
                  <td width="200" valign="top"><span class="form_txt1 301"><strong>Policy No : </strong></span></td>
                  <td width="851" height="30" valign="top"><?php echo stripslashes($motor_claim['policy_no']); ?></td>
                </tr>
                <tr>
                 <td width="200" height="30" style=" text-align:left;"><strong>Date of Claim : </strong></td>
                 <td width="400" height="30">&nbsp;<span class="item dateofbirth"><?php echo date('d/m/y',strtotime($motor_claim["created_date"])); ?></span></td>
                </tr> 
                <tr>
                  <td width="200" valign="top"><span class="form_txt1 301"><strong>Cliam for : </strong></span></td>
                  <td width="851" height="30" valign="top"><?php echo stripslashes($motor_claim['claim_for']); ?></td>
                </tr>  
                <tr>
                  <td width="200"><span class="form_txt1 301"><strong><span class="30 form_txt1">Claim Place </span> : </strong></span></td>
                  <td height="30"><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['claim_place']); ?></span></td>
                </tr>
                <tr>
                  <td width="200"><span class="form_txt1 301"><strong><span class="30 form_txt1">Police Station</span> : </strong></span></td>
                  <td height="30"><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['claim_police_station']); ?></span></td>
                </tr>
                <tr>
                  <td width="200"><span class="form_txt1 301"><strong><span class="30 form_txt1">FIR No.</span> : </strong></span></td>
                  <td height="30"><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['fir_no']); ?></span></td>
                </tr>                
                <tr>
                  <td width="200" valign="top"><span class="form_txt1 301"><strong><span class="30 form_txt1">Brief Description of Accident/ Theft</span> : </strong></span></td>
                  <td height="30" valign="top"><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['brief_description']); ?></span></td>
                </tr>
                
                <tr>
                  <td width="500" valign="top"><span class="form_txt1"><strong>Claim Description : </strong></span></td>
                  <td height="30" valign="top"><span class="fieldsColumn1"><?php echo stripslashes($motor_claim['claim_details']); ?></span></td>
                </tr>
               </tbody>
           </table>
          </form>
        </div>
      </div>
      	  </form>
      <div class="clear" style="height:1px;"></div>
    </div>
  </div>
  <div class="lg-3" style="float: right;margin-top:2%;padding-top: 9px;">
    <div class="normallist1">
      <h1>Need Help</h1>
      <ul>
         <li><a href="index.php?page=faq">FAQ's</a></li>
        <li><a href="index.php?page=contact-us">Contact Us</a></li>
      </ul>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<div class="clearfix" style="height:15px;"></div>
</div>
<?php

		}
 } ?>