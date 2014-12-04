<?php 
function getDriverAge($id)
{
	$res = mysql_fetch_object(mysql_query("select age from ".DRIVERAGE." where id=".$id));
	return $res->age;
}
function getVehicleUse($type_id)
{
	//$res = mysql_fetch_object(mysql_query("select a.age from ".DRIVERAGE." as a inner join ".VTYPE." as b on a.id=b.vehicle_use where b.id=".$type_id));
	$res = mysql_fetch_object(mysql_query("select name from ".POLICYUSE." where id=".$type_id));
	return $res->name;
}

function getNationalityName($id)
{
	$res = mysql_fetch_array(mysql_query("select nationality from ".NATIONALITY." where id=".$id));
	return stripslashes($res['nationality']);
}
function getNetorkClassName($id)
{
	$res = mysql_fetch_array(mysql_query("select nw_class from ".NETWORKCLASS." where id=".$id));
	return stripslashes($res['nw_class']);
}

if(isset($_GET["id"]))
{
	$id=$_GET["id"];
	$part = $_GET['part'];
	$sq = mysql_query("select * from ".POLICYMASTER." WHERE id='".$id."'");
}elseif(isset($_GET["policyid"])){
	
	$policyid=$_GET["policyid"];
	$part = '';
	$sq = mysql_query("select * from ".POLICYMASTER." WHERE policy_no='".$policyid."'");
}else{	
	header('Location:account.php?page=policy-list');
}
$policydetails=mysql_fetch_assoc($sq);
$customerinfo = mysql_fetch_assoc(mysql_query("Select * from ksa_user where customer_code ='".getElementVal('customer_id',$policydetails)."'"));
$medicalinfo = mysql_fetch_assoc(mysql_query("Select * from ".POLICYMEDICAL." where policy_no ='".getElementVal('policy_no',$policydetails)."'"));

$policytype = getElementVal('policy_type_id',$policydetails);

if(mysql_num_rows($sq)>0)
{

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
      <td align="left" style=" padding-left: 0px; font-size: 14px; color: #036;">&nbsp;</td>
      <td align="right" style="  padding-right: 0px;">
	  <a href="account.php?page=policy-list&<?=(!empty($part))?'part='.$part:''?>" class="linkBtn <?php if($_GET['page'] == "view-policy") echo "active"; ?>">&#8592;Back to policy list</a>
	  </td>
    </tr>
  </table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td style="padding-top: 5px;">
	<fieldset>
	<legend align="center">Policy Details</legend>
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
	  <tr>
		<td colspan="1"><strong>Policy Class</strong></td>
	    <td  colspan="1"><strong>Pol. Type</strong></td>
	    <td colspan="1"><strong>Doc Type</strong></td>
	  </tr>
	 <tr>
	    
	    <td width="13%"><?php 
		$policyclass = mysql_fetch_object(mysql_query("select * from ".POLICIES." WHERE id='".getElementVal('policy_class_id',$policydetails)."'"));
		echo (!empty($policyclass->title))?$policyclass->title:'Motor';?></td>
	    <td width="15%"><?php 
		$policytype_id = mysql_fetch_object(mysql_query("select * from ".POLICYTYPES." WHERE id='".getElementVal('policy_type_id',$policydetails)."'"));
		echo (!empty($policytype_id->policy_type))?$policytype_id->policy_type:'N/A';?></td>
	    
	    <td width="72%"><?php 
		$doctype = mysql_fetch_object(mysql_query("select * from ".DOCTYPES." WHERE id='".getElementVal('doc_type_id',$policydetails)."'"));
		echo (!empty($doctype->type_name))?$doctype->type_name:'N/A';?></td>
	  </tr>
	</table>
	
	<table width="100%" border="0" cellpadding="2" style="margin-top:10px" cellspacing="0">
	  <tr>
		<td width="13%"><strong>Policy No </strong></td>
	    <td width="15%"><strong>Policy Year </strong></td>
	    <td width="14%" style="padding-left: 5px;"><strong>Doc. Key</strong></td>
	    <td width="58%"><strong>Quotation Key </strong></td>
	    </tr>
	  <tr>
	    <td><?php echo getElementVal('policy_no',$policydetails); ?></td>
	    <td><?php echo getElementVal('policy_year',$policydetails);?></td>
	    <td style="padding-left: 5px;"><?php echo getElementVal('doc_key',$policydetails); ?></td>
	    <td><?php echo getElementVal('quotation_key',$policydetails); ?></td>
	    </tr>
	</table>
    <table width="100%" border="0" cellpadding="2" style="margin-top:10px" cellspacing="0">
	  <tr>
		<td width="16%"><strong>Policy Period: </strong></td>
	   <td  <?php if($policytype == 2){ ?>width="17%"<?php }else{ ?>width="80%" <?php } ?>><strong>Policy Amount (SR): </strong></td>
       	<?php if($policytype == 2){ ?>
       <td width="67%"><strong>Comprehensive Deduct Amount </strong></td>
       <?php } ?>
	    </tr>
	  <tr>
     	
	    <td width="16%" align="left"><?=date('m/d/Y',strtotime(getElementVal('insured_period_startdate',$policydetails)))?>&nbsp;-&nbsp;<?=date('m/d/Y',strtotime(getElementVal('insured_period_enddate',$policydetails)))?>&nbsp;</td>
        <td><?php 
		/*$policy_pricedet = mysql_fetch_object(mysql_query("SELECT * FROM ".PACKAGE." WHERE package_no='".$row["package_no"]."' limit 1"));
		echo number_format($policy_pricedet->package_amt,2); */

		$policy_pricedet = mysql_fetch_object(mysql_query("SELECT * FROM ".POLICYPAYMENTS." WHERE policy_no='".getElementVal('policy_no',$policydetails)."' limit 1"));
		echo number_format($policy_pricedet->amount_paid,2);
		
		?></td>
        <?php if($policytype == 2){ ?>
        <td><?php

		echo getElementVal('agency_deduct_amt',$policydetails);
		?></td>
        <?php } ?>
     </tr>   
	</table>
	</fieldset>
	</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="0">
     <fieldset>
	<legend style="background-color: rgba(2, 2, 2, 0.33);">Policy Holder's Information</legend>
	  <tr>
     
		<td width="56%" valign="top" style="padding-right: 15px;">
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
          <?php /*?><tr>
            <td width="28%">Customer Type:</td>
            <td width="72%">
			<?php if($customerinfo['customer_type'] == 1)echo 'Individual';
			if($customerinfo['customer_type'] == 2)echo 'Commercial';
			?>
            </td>
          </tr><?php */?>
       
          <tr>
            <td width="28%">Name:</td>
            <td width="72%"><?=stripslashes($customerinfo['fname'])?> <?=stripslashes($customerinfo['lname'])?></td>
          </tr>
       
          <tr>
            <td>Date Of Birth </td>
            <td> <?=date('d/m/Y',strtotime($customerinfo['dob']))?></td>
          </tr>
          <tr>
            <td>Occupation</td>
            <td> <?=stripslashes($medicalinfo['occupation'])?></td>
          </tr>
         
          <tr>
            <td>Nationality</td>
            <td> <?=getNationalityName($medicalinfo['nationality'])?></td>
          </tr>
         
          <tr>
            <td>Network Class</td>
            <td> <?=getNetorkClassName($medicalinfo['network_class'])?></td>
          </tr>
         
          <tr>
            <td>Pre- Existing / Chronoc Diseases</td>
            <td> <?=stripslashes($medicalinfo['chronoc_diseases'])?></td>
          </tr>
         
          <tr>
            <td>Gender: </td>
            <td> <?=($customerinfo['gender'] == 'm')?'Male':'Female'?></td>
          </tr>
          <tr>
            <td>Email : </td>
            <td><?=stripslashes($customerinfo['email'])?></td>
          </tr>
          <tr>
            <td>Phone (M) :</td>
            <td><?=stripslashes($customerinfo['phone_mobile'])?></td>
          </tr>
          <?php /*?><tr>
            <td>Address (Primary):</td>
            <td><?=stripslashes($customerinfo['address1'])?></td>
          </tr><?php */?>
          <tr>
            <td>Country:</td>
            <td><?=stripslashes($customerinfo['country'])?></td>
          </tr>
          <tr>
            <td>State:</td>
            <td><?=stripslashes($customerinfo['state'])?></td>
          </tr>
          <tr>
            <td>IQMA No:</td>
            <td><?=stripslashes($customerinfo['iqma_no'])?></td>
          </tr>
          <tr>
            <td>Driving License No:</td>
            <td><?=stripslashes($customerinfo['drive_license_no'])?></td>
          </tr>
           <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </fieldset>
			<?php if(getElementVal('policy_class_id',$policydetails) == 1)
			{?>
            <td colspan="2" style="padding-right: 15px;padding-top: 18px;">
                <table width="100%" border="0" cellspacing="2" cellpadding="3">
    <fieldset>
	<legend style="background-color: rgba(2, 2, 2, 0.33);">Vehicle Information</legend>
    	<?php if($policytype == 2){ ?>
                  <tr>
                    <td width="28%">Vehicle Make :</td>
                    <td><?php $maketype = mysql_fetch_object(mysql_query("select * from ".VMAKE." WHERE id='".$motordetails['vehicle_make']."'"));
		echo (!empty($maketype->make))?$maketype->make:'N/A';?></td>
                    </tr>
                  <tr>
                    <td>Vehicle Model:</td>
                    <td><?php $modeltype = mysql_fetch_object(mysql_query("select * from ".VMODEL." WHERE id='".$motordetails['vehicle_model']."'"));
		echo (!empty($modeltype->model))?$modeltype->model:'N/A';?></td>
                  </tr>
        <?php } ?>
        <?php if($policytype == 1){ ?>
        <tr>
                    <td>Vehicle Use:</td>
                    <td><?php echo (!empty($motordetails['vehicle_use']))?getVehicleUse($motordetails['vehicle_use']):'N/a'; ?></td>
                  </tr>
                  <tr>
                    <td>Vehicle Type:</td>
                    <td><?php 
					$vechcleidtype = (!empty($motordetails['vehicle_type']))?$motordetails['vehicle_type']:$motordetails['vehicle_type_tpl'];
					$vehicletype = mysql_fetch_object(mysql_query("select * from ".VTYPE." WHERE id='".$vechcleidtype."'"));
		echo (!empty($vehicletype->type_name))?$vehicletype->type_name:'N/A';?></td>
                  </tr>
                
        <?php } ?>
                  
                  <?php if($policytype == 2){ ?>
                  <tr>
                    <td>Purchase Year:</td>
                    <td><?=(!empty($motordetails['vehicle_purchase_year']))?stripslashes($motordetails['vehicle_purchase_year']):'N/A'?></td>
                  </tr>
                  <tr>
                    <td width="49%">Car Value:</td>
                    <td width="51%"><?php echo (!empty($motordetails['car_value']))?$motordetails['car_value']:'N/A'; ?></td>
                    </tr>
                    <tr>
                    <td width="49%">Agency Repair:</td>
                    <td width="51%"><?php echo (!empty($motordetails['vehicle_agency_repair']))?$motordetails['vehicle_agency_repair']:'N/A'; ?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td> Manufacture Year: </td>
                    <td><?=(!empty($motordetails['vehicle_year_made']))?stripslashes($motordetails['vehicle_year_made']):'N/A'?></td>
                  </tr>
                   <tr>
                    <td>Vehicle Color: </td>
                    <td><?=(!empty($motordetails['vehicle_color']))?stripslashes($motordetails['vehicle_color']):'N/A'?></td>
                  </tr>
                   <tr>
                    <td>Chassis No: </td>
                    <td><?=(!empty($motordetails['chassic_no']))?stripslashes($motordetails['chassic_no']):'N/A'?></td>
                  </tr>
                   <tr>
                    <td>Engine No: </td>
                    <td><?=(!empty($motordetails['engine_no']))?stripslashes($motordetails['engine_no']):'N/A'?></td>
                  </tr>
                   <tr>
                    <td width="49%">Vehicle Ownership:</td>
                    <td width="51%"><?php echo (!empty($motordetails['vehicle_ownership']))?$motordetails['vehicle_ownership']:'N/A'; ?></td>
                    </tr>
                    <tr>
                    <td width="49%">Vehicle Regd. Place:</td>
                    <td width="51%"><?php echo (!empty($motordetails['vehicle_regd_place']))?$motordetails['vehicle_regd_place']:'N/A'; ?></td>
                    </tr>
                   
                     <tr>
                    <td width="49%">Driver Age:</td>
                    <td width="51%"><?php echo (!empty($motordetails['driver_age']))?getDriverAge($motordetails['driver_age']):'N/A'; ?></td>
                    </tr>
                    <tr>
                    <td width="49%">Driver License issuing Date:</td>
                    <td width="51%"><?php echo (!empty($motordetails['driver_license_issue_date']))?date('d/m/Y',strtotime($motordetails['driver_license_issue_date'])):'N/A'; ?></td>
                    </tr>
                 
                      <tr>
                    <td width="49%">Claim Paid:</td>
                    <td width="51%"><?php echo (!empty($motordetails['vehicle_ncd']))?$motordetails['vehicle_ncd']:'N/A'; ?></td>
                    </tr>
                    
                    
              </fieldset>
                </table>
            </td>
            <?php }?>
            
          </tr>
          <tr>
          <td colspan="2" style="padding-right: 15px;padding-top: 18px;">
                <table width="100%" border="0" cellspacing="2" cellpadding="3">
    <fieldset>
	<legend style="background-color: rgba(2, 2, 2, 0.33);">Additional Covers</legend>
    <?php $coverdetails = mysql_query("Select * from ".POLICYCOVERS." where policy_no ='".getElementVal('policy_no',$policydetails)."'"); 
			if(mysql_num_rows($coverdetails)>0)
			{
		while($row1 = mysql_fetch_array($coverdetails)): ?>

                  <tr>
                    <td width="47%"> <?php $productn = mysql_fetch_object(mysql_query("select * from ".PRODUCTCOVERS." WHERE id='".$row1['cover_id']."'"));
		echo (!empty($productn->cover_title))?$productn->cover_title:'N/A';?> :</td>
                    <td width="53%"><?=$row1['cover_amt']?> SR</td>
                    </tr>
     <?php endwhile; 
			}else{?>
        			<tr>
                    <td ><span style="color:#900; font-size:12px;">No Covers found</span></td>
                    <td></td>
                    </tr>
      <?php } ?>    
              </fieldset>
                </table>
            </td>
          </tr>
        </table>
		</td>
	    <td width="44%" valign="top">
        <table width="100%" border="0" cellspacing="2" cellpadding="3">
          <tr>
            <td width="23%">Registry Date: </td>
            <td width="77%"><?php echo date("d/m/Y",strtotime($policydetails["registry_date"])); ?></td>
          </tr>
           <tr>
            <td width="23%">Package ID: </td>
            <td width="77%">
            <span id="select_package" ><?php echo $policydetails['package_no']?>          </span>          </td>
          </tr>
          <tr>
            <td>Payment Term: </td>
            <td><?php echo $policydetails['payment_term']?></td>
          </tr>
          <tr>
            <td>UW Year: </td>
            <td><?php echo $policydetails['uw_year']?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php /*?><tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr><?php */?>
          <tr>
          <td colspan="2" style="padding-right: 15px;padding-top: 18px;">
                <table width="100%" border="0" cellspacing="2" cellpadding="3">
    <fieldset>
	<legend style="background-color: rgba(2, 2, 2, 0.33);">Policy Attachments</legend>
    <?php $attachmentdet = mysql_query("Select * from ".POLICYATTACHMENTS." where policy_no ='".getElementVal('policy_no',$policydetails)."'"); ?>
    <?php $p = 0;
		if(mysql_num_rows($attachmentdet)>0)
		{
			?>
            <tr>
                <td><strong>SL No</strong></td>
                <td><strong>Attachment</strong></td>
                <td></td>
            </tr>
            <?php 
			while($row = mysql_fetch_array($attachmentdet)): $p++;?>
				  <tr>
                  	<td><?php echo $p;?></td>
					<td width="28%"><?=$row['atch_title']?></td>
					<td>
                    	<a href="<?php echo SITE_URL;?>download.php?dir=upload/motr-attchment/&f=<?php echo $row['atch_file'];?>">Download</a>
                    </td>
					</tr>
		<?php endwhile; 
			}
		else{?>
        			<tr>
                    <td ><span style="color:#900; font-size:12px;">No Attachments found</span></td>
                    <td></td>
                    </tr>
      <?php } ?>
              </fieldset>
                </table>            </td>
            </tr>
        </table>
        </td>
	  </tr>
	</table>
	
	
	</td>
  </tr>
</table>
<?php }else{ ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
      <td align="left" style=" padding-left: 0px; font-size: 14px; color: #036;">&nbsp;</td>
      <td align="right" style="  padding-right: 0px;">
	  <a href="account.php?page=policy-list&<?=(!empty($part))?'part='.$part:''?>" class="linkBtn <?php if($_GET['page'] == "view-policy") echo "active"; ?>">&#8592;Back to policy list</a>
	  </td>
    </tr>
  </table>
	<table width="100%" border="0" align="center" style="padding-top: 10px;" cellpadding="3" cellspacing="0">
  <tr>
    <td>
	<fieldset>
	<legend style="background-color: rgba(2, 2, 2, 0.33);" align="center">No results found</legend>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="56%" valign="top" style="padding-right: 15px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="28%"><span  style="color:#C00;font-size: 14px; font-weight:bold;">Invalid Policy Number.</span></td>
            <td width="72%">&nbsp;</td>
          </tr>  
        </table></td>
	  </tr>
	</table>
	
	
	</fieldset></td>
  </tr>
</table>
<?php } ?>