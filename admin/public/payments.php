<?php
if($_GET['part'])
	$parturl="&part=".$_GET['part'];

$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 
$where="";
if($_GET["s"])
{
	$j = 0;
	$i = 0;
	$where.=" and a.policy_id LIKE '%".$_GET["s"]."%'";
	$sub_url.='&s='.$_GET["s"];
}
if($_GET["from"] )
{
	$j = 0;
	$i = 0;
	$from=date('Y-m-d',strtotime($_GET["from"]));
	if(!$_GET["to"])
		$where.=" and a.paid_on = '".$from."'";
	$sub_url.='&from='.$_GET["from"];
}
if($_GET["to"])
{
	$j = 0;
	$i = 0;
	$to=date('Y-m-d',strtotime($_GET["to"]));
	if(!$_GET["from"] )
		$where.=" and a.paid_on = '".$to."'";
	$sub_url.='&to='.$_GET["to"];
}
if($_GET["to"]!='' && $_GET['from']!='')
{
	$where.=" and a.paid_on between '".$from."' and '".$to."'";
}

if($_GET["type"])
{
	$j = 0;
	$i = 0;
	if($_GET["type"]=="purchase")
		$where.=" and a.renew_id = '0'";
	if($_GET["type"]=="renew")
		$where.=" and a.renew_id != '0'";
	$sub_url.='&type='.$_GET["type"];
}

if($_GET["ptype"])
{
	$j = 0;
	$i = 0;
		$where.=" and b.policy_type = '".$_GET["ptype"]."'";
	$sub_url.='&ptype='.$_GET["ptype"];
}

$view=$_GET['view'];
if($view=='agent')	
	$payment_by_type="A";
if($view=='user')	
	$payment_by_type="U";
	
//$sq = "SELECT * FROM ".PAYMENTS." WHERE payment_by_type='".$payment_by_type."' ".$where." ORDER BY paid_on DESC ";

$sq ="select a.* from ".PAYMENTS." as a inner join ".USERTRAVELPOLICY." as b on a.policy_id=b.policy_no WHERE a.payment_by_type='".$payment_by_type."' ".$where.$whr." UNION select a.* from ".PAYMENTS." as a inner join ".USERHEALTHPOLICY." as b on a.policy_id=b.policy_no WHERE a.payment_by_type='".$payment_by_type."' ".$where.$whr." UNION select a.* from ".PAYMENTS." as a inner join ".USERAUTOPOLICY." as b on a.policy_id=b.policy_no WHERE a.payment_by_type='".$payment_by_type."' ".$where.$whr." UNION select a.* from ".PAYMENTS." as a inner join ".USERMALPRACTICEPOLICY." as b on a.policy_id=b.policy_no WHERE a.payment_by_type='".$payment_by_type."' ".$where.$whr." order by id desc";

?>  
<script>
function calculate(val1, val2, msg) 
{
	var value1 = val1.split("-");
	var value2 = val2.split("-");
	if (value1 != "" && value2 != "") 
	{
		var day1 = parseFloat(value1[0]);
		var month1 = parseFloat(value1[1]);
		var year1 = parseFloat(value1[2]);
		var day2 = parseFloat(value2[0]);
		var month2 = parseFloat(value2[1]);
		var year2 = parseFloat(value2[2]);
		
		if ((year2 < year1) || (year2 == year1 && month2 < month1) || (year2 == year1 && month2 == month1 && day2 < day1) || (year2 == year1 && month2 == month1 && day2 == day1)) 
		{
			alert(msg);
			return false;
		}   
		else
			return true;     
	}
}

function searchPaymnts()
{
	var form=document.partcat_form;
	var s_url='';
	var to_url='';
	var from_url='';
	var type_url='';
	var ptype_url='';
	if(form.stitle.value!='')
		s_url='&s='+form.stitle.value;
	if(form.from.value!='')
		from_url='&from='+form.from.value;
	if(form.to.value!='')
		to_url='&to='+form.to.value;	
		
	if(form.type.value!='')
		type_url='&type='+form.type.value;
		
	if(form.ptype.value!='')
		ptype_url='&ptype='+form.ptype.value;
		
	var url='<?php echo BASE_URL;?>account.php?page=payments&view=<?php echo $view;?>'+s_url+from_url+to_url+type_url+ptype_url;
	
	if(form.from.value!='' && form.to.value!='')
	{
		if(calculate(form.from.value,form.to.value,'To Date Should greater than From Date.'))
			window.location.href=url;
	}
	else
	{
		window.location.href=url;
	}
}
</script>
<!-- app -->
<style>
.renew{
font-size:9px;
font-style:inherit;}
table td{
padding:3px;
font-size:11px;
}
</style>
<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
<form action="" method="post" name="partcat_form" id="partcat_form">  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Payments </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=article"></a></td>
    </tr>
    <tr>
      <td width="1%" style="border-bottom: 1px solid #99C; padding-bottom: 0px; padding-left: 0px; font-size: 14px; color: #036;">&nbsp;</td>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 0px; padding-left: 0px; font-size: 14px; color: #036;">
	  <table height="100%" width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
		   <td align="right">From <input type="text" style="width:100px;" class="generalTextBox calender2" id="from" name="from" value="<?php echo $_GET["from"]; ?>">&nbsp;
		   To <input type="text" style="width:100px;" class="generalTextBox calender2" id="to" name="to" value="<?php echo $_GET["to"]; ?>">
		   	<select name="type">
				<option value=""> - Status - </option>
				<option value="purchase" <?php if($_GET["type"]=='purchase') echo 'selected="selected"';?> >Purchase</option>
				<option value="renew" <?php if($_GET["type"]=='renew') echo 'selected="selected"';?>>Renew</option>
			</select>&nbsp;<select name="ptype" class="">
			<option value=""> - Type - </option>
			<option value="travel" <?php if($_GET['ptype']=='travel')echo 'selected="selected"';?>>Travel</option>
			<option value="medical" <?php if($_GET['ptype']=='medical')echo 'selected="selected"';?>>Medical</option>
			<option value="malpractice" <?php if($_GET['ptype']=='malpractice')echo 'selected="selected"';?>>Malpractice</option>
			<option value="auto" <?php if($_GET['ptype']=='auto')echo 'selected="selected"';?>>Auto</option>
		</select>&nbsp;Policy No : 
		   <input name="stitle" type="text" class="generalTextBox" id="quest" style="width: 120px;" 
		value="<?php echo $_GET["s"]; ?>">
        <input type="button" name="search" id="search" value=" Search " class="actionBtn" onclick="searchPaymnts();"></td>
        </tr>
      </table>
	  </td>
      </tr>
    <?php if($msg <> ""){
?>
    <div style="border: 1px solid #990; background-color: #FFC; padding: 2px; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="7%"><img src="../images/warning.png" width="32" height="32" /></td>
          <td width="93%"><?php echo $msg; ?></td>
        </tr>
      </table>
    </div>
    <?php } ?>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr style="color: #FFF;" height="24">
            <td width="7%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="24%" align="left" bgcolor="#333333"><strong>Name</strong></td>
            <td width="15%" align="left" bgcolor="#333333"><strong>Policy Number </strong></td>
            <td width="14%" align="left" bgcolor="#333333"><strong>Policy Amount </strong></td>
            <td width="11%" align="center" bgcolor="#333333"><strong>Discount</strong></td>
            <td width="11%" align="center" bgcolor="#333333"><strong>Amount Paid</strong></td>
            <td width="18%" align="center" bgcolor="#333333"><strong>Paid On</strong></td>
          </tr>
<?php 
		  $rs=mysql_query($sq." LIMIT ".$startpoint.", ".$perpage);
		  if(mysql_num_rows($rs)>0)
		  {
		  while($row=mysql_fetch_array($rs)){
		  $j++;
		  $bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			 
		  ?>
          <tr <?php echo $bgcolor; ?> height="24">
            <td align="center" ><strong><?php echo $j+$startpoint; ?></strong></td>
            <td><?php if($view=='agent') echo getAgentName($row["payment_by_id"]); else echo getUserName($row["payment_by_id"]); ?></td>
            <td>
				<a href="<?php echo BASE_URL;?>account.php?page=user_policy_details&view=<?php echo $view;?>&policy_no=<?php echo stripslashes($row["policy_id"]);?>"><?php echo stripslashes($row["policy_id"]);?></a><?php  if($row["renew_id"]!='0') echo '<span class="renew"> (Renew)</span>';?>
			</td>
            <td align="center"><?php echo stripslashes($row["policy_amt"]); ?></td>
            <td align="center"><?php if($row["discount_amt"]) echo $row["discount_amt"]; else echo '-'; ?></td>
            <td align="center"><?php echo stripslashes($row["amount_paid"]); ?></td>
            <td align="center" ><?php echo date('d-m-Y',strtotime($row["paid_on"]));?></td>
          </tr>
          <?php $i=$i+1;}
		  }
		  else
		  {?>
		  	<td colspan="7" align="center" bgcolor="#F2FBFF">No Payment found.</td>
		  <?php } ?>
          
          <tr>
            <td colspan="9" align="center"><?php  echo Paging("",$perpage,"account.php?page=payments&view=".$view.$sub_url."&","",$sq);?> </td>
          </tr>
        </table></td>
      </tr>
    
  </table></form>
</div>
