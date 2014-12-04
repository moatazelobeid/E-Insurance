 <?php
	   $whr="";
	    $pwhr="";
	   if(isset($_POST['search'])){
		   
			$whr[]=" ".POLICYMASTER.".policy_no = ".POLICYPAYMENTS.".policy_no ";
		   if(isset($_POST['stat']) && $_POST['stat']!='')
			  {
				  $status = $_POST['stat'];
				  $whr[]=" payment_status='$status'";
			  }
			 if(isset($_POST['policy_id']) && $_POST['policy_id']!='')
			  {
				  $policy_id = $_POST['policy_id'];
				  $whr[]=" policy_class_id='$policy_id'";
			  }
			  	  if($_POST['frmdate'] != '' && $_POST['todate']=='')
		{
			$frm_date=date('Y-m-d H:i:s',strtotime($_POST['frmdate']));
			$whr[]=" (registry_date BETWEEN '".$frm_date."' AND '".$frm_date."')";
		}	

		if($_POST['todate'] != '' && $_POST['frmdate'] == '')
		{
			$to_date=date('Y-m-d H:i:s',strtotime($_POST['todate']));
			$whr[]=" (registry_date BETWEEN '".$to_date."' AND '".$to_date."')";	
		}	   
		
		if($_POST['frmdate'] != '' && $_POST['todate'] != '')
		{
			$frm_date=date('Y-m-d H:i:s',strtotime($_POST['frmdate']));
			$to_date=date('Y-m-d H:i:s',strtotime($_POST['todate']));
		$whr[]=" (registry_date BETWEEN '".$frm_date."' AND '".$to_date."')";
		}
			 if(!empty($whr))
			{
				$where=" where ".implode("and",$whr);
				$pwhr=implode(" and",$whr);
			}
		
		  $rs=  mysql_query("SELECT * FROM ".POLICYMASTER.",".POLICYPAYMENTS." ".$where."  ORDER BY ".POLICYMASTER.".id DESC LIMIT ".$startpoint.",".$perpage);
	   }else{
		   $rs=mysql_query("SELECT * FROM ".POLICYMASTER.",".POLICYPAYMENTS." where ".POLICYMASTER.".policy_no = ".POLICYPAYMENTS.".policy_no ORDER BY ".POLICYMASTER.".id DESC");
		  
	   }
		if(mysql_num_rows($rs) > 0){
			$i=0;
			if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		  $amountarr = array();
		while($row=mysql_fetch_array($rs)){
		$bgcolor = ($i%2 == 0)?'bgcolor="#F2F2F2"':'bgcolor=""';
			$i++;
			$transactionval  =mysql_fetch_assoc(mysql_query("SELECT * FROM ".POLICYPAYMENTS." where policy_no = '".$row['policy_no']."' "));
			
			
			$pclass_details = mysql_fetch_object(mysql_query("SELECT * FROM ".POLICIES." WHERE id='".$row["policy_class_id"]."' limit 1"));
			$ptype_details = mysql_fetch_object(mysql_query("SELECT * FROM ".POLICYTYPES." WHERE id='".$row["policy_type_id"]."' limit 1"));
		
		
		$policy_pricedet = mysql_fetch_object(mysql_query("SELECT * FROM ".PACKAGE." WHERE package_no='".$row["package_no"]."' limit 1"));
		array_push($amountarr,$policy_pricedet->package_amt);
		
		  ?>
<?php }}else{
			?>
            
            <?php
		}?>

<?php
$rs = mysql_query("SELECT DATE(paid_date) FROM ksa_policy_payments GROUP BY DATE(paid_date)");
if(mysql_num_rows($rs) > 0){
	$xarray = array();
	while($result = mysql_fetch_array($rs)){
		array_push($xarray,$result['DATE(paid_date)']);
	}
}

$rss = mysql_query("SELECT SUM(amount_paid) FROM ksa_policy_payments GROUP BY DATE(paid_date)");
if(mysql_num_rows($rss) > 0){
	$yarray = array();
	while($resulta = mysql_fetch_array($rss)){
		array_push($yarray,round($resulta['SUM(amount_paid)'])); 
	}
}
//print_r($xarray);
?>
<script type="text/javascript">
// fade out messages
var fade_out = function() {
  $("#errorDiv").fadeOut().empty();
}
setTimeout(fade_out, 2000);


$(function() {
	$( "#strtdate" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' } );
	$( "#enddate" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:2020' , changeMonth: 'true' });
});

</script>


<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 5px; margin-top: 3px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Sales Report Graphical </strong></td>
      <td align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 12px; padding-left: 0px; font-size: 14px; color: #036;"><a href="account.php?page=sales-report" class="linkBtn <?php if($_GET['view'] == "sales-report") echo "active"; ?>">Tabular Report View</a></td>
    </tr> 
</table>
<?php if($msg <> ""){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;">
  <tr>
    <td width="2%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
    <td width="98%"><?php echo $msg; ?></td>
  </tr>
</table>
<?php } ?>
<?php if($errmsg <> ""){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #900;" id="errorDiv">
  <tr>
    <td width="2%" valign="top"><img src="<?php echo IMG_PATH; ?>warning.png" width="24" height="24" /></td>
    <td width="98%"><strong>Opps !! Following Errors has beed detected</strong><br />
      <?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>
<form action="" method="post" name="subject_fr" style="padding: 0px; margin: 0px;">

  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr>
      <?php $allrows=mysql_query("SELECT * FROM ".POLICYMASTER.",".POLICYPAYMENTS." where ".POLICYMASTER.".policy_no = ".POLICYPAYMENTS.".policy_no ORDER BY ".POLICYMASTER.".id DESC "); ?>
       <td width="19%" align="left" style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 0px; padding-right: 1px; font-size: 11px; color: #036;"><?php /*?><strong>Total: <?=mysql_num_rows($allrows)?> </strong><?php */?></td>
       <td width="75%" align="right" style="border-bottom: 0px; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
	   <?php /*?><input name="frmdate" type="text" class="textbox" id="strtdate" style="width: 120px; font-weight: normal;" placeholder="Enter start date" value="<?php echo $_POST['frmdate']; ?>">
       <input name="todate" type="text" class="textbox" id="enddate" style="width: 120px; font-weight: normal;" placeholder="Enter end date " value="<?php echo $_POST['todate']; ?>">
	   <select name="policy_id" style="width: 100px; font-weight: normal; padding: 3px 3px 3px 3px;">
		<option value="">Policy Type</option>
		<?php 
		$sql_class = mysql_query("SELECT id,title FROM ".POLICIES." WHERE status = '1'");
		if(mysql_num_rows($sql_class) > 0){
		while($result_class = mysql_fetch_array($sql_class))
		{
		?>
			<option value="<?php echo $result_class['id'];?>" <?php if($_POST['policy_id'] == $result_class['id'])echo 'selected="selected"';?>><?php echo $result_class['title'];?></option>
		<?php }} ?>
		</select>
		<select name="stat" style="width: 100px; font-weight: normal; padding: 3px 3px 3px 3px;">
		  <option value="">Status</option>
		  <option value="1" <?php if($_POST["stat"]=='1') echo 'selected="selected"';?>>Paid</option>
          <option value="0" <?php if($_POST['stat']=='0') echo 'selected="selected"';?>>Unpaid</option>
        </select>
	   <input type="submit" name="search" id="search" value=" Search " class="actionBtn" /><?php */?>
	   </td>
    </tr>
  </table>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            title: {
                text: 'Sales Graph',
                x: -20 //center
            },
            subtitle: {
                text: 'Motor Insurance Sales Analysis',
                x: -20
            },
            xAxis: {
                categories: <?=json_encode($xarray)?>
            },
            yAxis: {
                title: {
                    text: 'Amount (SR)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Sales',
                data: [<?php echo implode(',',$yarray); ?>]
            }],
			exporting: {
					enabled: false
					 }
        });
    });
</script>
  
  
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td valign="top" style="border-bottom: 1px solid #CCCCCC; padding-left: 0px; padding-right: 0px;">
	
	
	<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	
	<input type="hidden" name="checked_id" id="checked_id" value=""/>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
      
      <?php /*?><tr <?php echo $bgcolor; ?> style="padding-bottom:5px;padding-top:5px;">
		 <td  style="padding-left: 5px;" align="center"><?php echo $i; ?></td>
		<td  style="padding-left: 5px;"><?php echo $row["policy_no"]; ?></td>
        <td  style="padding-left: 5px;"><?php echo stripslashes($row["package_no"]); ?></td>
		<td  style="padding-left: 5px;"><?php echo stripslashes($row["insured_person"]); ?></td>
		<td  style="padding-left: 5px;"></td>
		<td align="center"  style="padding-left: 5px;"><?php 
		 ?></td>
        <td width="15%" align="center"><?php echo ($transactionval['transaction_id'] !='')?stripslashes($transactionval['transaction_id']):'N/A'; ?></td>
          <td width="13%" align="center">
				<?php echo ($transactionval['payment_status'] == 1)?'Paid':'Unpaid'; ?>
            </td>
		<td width="15%" align="center"><?php echo date("d/m/Y",strtotime($row["registry_date"])); ?></td> 
  </tr><?php */?>
        
 </table></td>
  </tr>
</table>
<!-- @end users list -->
</form>