<?php 

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
		<td colspan="1"><strong>Branch</strong></td>
	    <td colspan="1"><strong>Office</strong></td>
	    <td colspan="1"><strong>Business Type</strong></td>
	    <td colspan="1"><strong>Class</strong></td>
	    <td  colspan="1"><strong>Pol. Type</strong></td>
	    <td colspan="1"><strong>Doc Type</strong></td>
	  </tr>
	 <tr>
	    
	    <td width="13%"><?php 
		$branches = mysql_fetch_object(mysql_query("select * from ".BRANCHES." WHERE id='".getElementVal('branch_id',$policydetails)."'"));
		echo $branches->branch_name;?></td>
	    
	    <td width="15%"><?php 
		$offices = mysql_fetch_object(mysql_query("select * from ".OFFICES." WHERE id='".getElementVal('office_id',$policydetails)."'"));
		echo $offices->office_name;?></td>
	   
	    <td width="14%"><?php 
		$businesstype = mysql_fetch_object(mysql_query("select * from ".BUSINESSTYPE." WHERE id='".getElementVal('business_type_id',$policydetails)."'"));
		echo $businesstype->business_type;?></td>
	    <td width="12%"><?php 
		$policyclass = mysql_fetch_object(mysql_query("select * from ".POLICIES." WHERE id='".getElementVal('policy_class_id',$policydetails)."'"));
		echo $policyclass->title;?></td>
	    <td width="16%"><?php 
		$policytype_id = mysql_fetch_object(mysql_query("select * from ".POLICYTYPES." WHERE id='".getElementVal('policy_type_id',$policydetails)."'"));
		echo $policytype_id->policy_type;?></td>
	    
	    <td width="30%"><?php 
		$doctype = mysql_fetch_object(mysql_query("select * from ".DOCTYPES." WHERE id='".getElementVal('doc_type_id',$policydetails)."'"));
		echo $doctype->type_name;?></td>
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
		<td width="10%"><strong>Policy Period: </strong></td>
	   
	    </tr>
	  <tr>
     
	    <td width="90%" align="left"><?=date('m/d/Y',strtotime(getElementVal('insured_period_startdate',$policydetails)))?>&nbsp;-&nbsp;<?=date('m/d/Y',strtotime(getElementVal('insured_period_enddate',$policydetails)))?>&nbsp;</td>
        
	</table>
	</fieldset>
	</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>
	<fieldset>
	<legend style="background-color: rgba(2, 2, 2, 0.33);">Basic Information</legend>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="56%" valign="top" style="padding-right: 15px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="28%">Debit Account:</td>
            <td width="72%">&nbsp;</td>
          </tr>
          <tr>
            <td>Insured: </td>
            <td><!--<input name="insured_person" type="text" class="textbox" id="insured_person" style="width: 327px;" value="<?php echo getElementVal('insured_person',$datalist); ?>"/>-->
            </td>
          </tr>
          <tr>
            <td>Loss Payee/Financed By: </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Source Location: </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Business Source: </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Broker:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Agent:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" style="padding-top: 10px; padding-bottom: 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
			  <tr>
				<td align="left" style=""><strong>Insurance Period</strong></td>
			  </tr>
			</table>			</td>
            </tr>
          <tr>
            <td colspan="2" style="padding: 0px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="28%">Known?</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Policy Period:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Policy Active Dates:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Time Zone: </td>
    <td>&nbsp;</td>
  </tr>
</table>

			</td>
          </tr>
        </table>
		</td>
	    <td width="44%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="20%">Registry Date: </td>
            <td width="80%">&nbsp;</td>
          </tr>
           <tr>
            <td width="20%">Package ID: </td>
            <td width="80%">
            <span id="select_package" ><?php /*?><input name="package_no" type="text" class="textbox" id="package_no" style="width: 40px;" onBlur="getCodeVal('package_no','PACKAGE','package_name','package_title','package_no')" value="<?php echo getElementVal('package_no',$datalist); ?>"/>
              <input name="package_name" type="text" class="textbox" id="package_name" style="width: 150px;" readonly="readonly"/><?php */?>
          </span>
          </td>
          </tr>
          <tr>
            <td>Payment Term: </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>UW Year: </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Installment Term: </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Installment Desc.: </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Reference:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Remark:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Your Ref.: </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Surveyor/Adjuster: </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>File No: </td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
	  </tr>
	</table>
	
	
	</fieldset></td>
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