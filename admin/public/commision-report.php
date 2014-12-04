<?php
if($_GET["s"])
{
	$j = 0;
	$i = 0;
	$where[]=" a.policy_id LIKE '%".$_GET["s"]."%'";
}
if($_GET["from"] )
{
	$j = 0;
	$i = 0;
	$from=date('Y-m-d',strtotime($_GET["from"]));
	if(!$_GET["to"])
		$where[]=" a.paid_on = '".$from."'";
}
if($_GET["to"])
{
	$j = 0;
	$i = 0;
	$to=date('Y-m-d',strtotime($_GET["to"]));
	if(!$_GET["from"] )
		$where[]=" a.paid_on = '".$to."'";
}
if($_GET["to"]!='' && $_GET['from']!='')
{
	$where[]=" a.paid_on between '".$from."' and '".$to."'";
}

if($_GET["agid"])
{
	$j = 0;
	$i = 0;
	$where[]=" a.payment_by_id = '".$_GET["agid"]."'";
}
if($_GET["cid"])
{
	$j = 0;
	$i = 0;
	$where[]=" b.comp_id = '".$_GET["cid"]."'";
}
if($where)
	$whr=" where ".implode(' and ',$where);
//$sq = "SELECT * FROM ".PAYMENTS." ".$where." ORDER BY paid_on DESC ";

$sq ="select a.* from ".PAYMENTS." as a inner join ".USERTRAVELPOLICY." as b on a.policy_id=b.policy_no ".$whr." UNION select a.* from ".PAYMENTS." as a inner join ".USERHEALTHPOLICY." as b on a.policy_id=b.policy_no ".$whr." UNION select a.* from ".PAYMENTS." as a inner join ".USERAUTOPOLICY." as b on a.policy_id=b.policy_no ".$whr." UNION select a.* from ".PAYMENTS." as a inner join ".USERMALPRACTICEPOLICY." as b on a.policy_id=b.policy_no ".$whr."   order by id desc";
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
	var ag_url='';
	var c_url='';
	if(form.stitle.value!='')
		s_url='&s='+form.stitle.value;
	if(form.from.value!='')
		from_url='&from='+form.from.value;
	if(form.to.value!='')
		to_url='&to='+form.to.value;	
		
	if(form.agid.value!='')
		ag_url='&agid='+form.agid.value;
		
	if(form.cid.value!='')
		c_url='&cid='+form.cid.value;

	var url='<?php echo BASE_URL;?>account.php?page=commision-report'+s_url+from_url+to_url+ag_url+c_url;
	
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

<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
<form action="" method="post" name="partcat_form" id="partcat_form">  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Commision Report </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=article"></a></td>
    </tr>
    <tr>
      <td colspan="3" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
	  <table height="100%" width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
		   <td align="right">From <input type="text" style="width:100px;" class="generalTextBox calender2" id="from" name="from" value="<?php echo $_GET["from"]; ?>">&nbsp;
		   To <input type="text" style="width:100px;" class="generalTextBox calender2" id="to" name="to" value="<?php echo $_GET["to"]; ?>">
		   	<select name="agid" class="" style="width:100px; height:30">
			<option value=""> - Agent - </option>
			<?php $aglist=mysql_query("select * from ".AGENTTBL."");
			while($agent=mysql_fetch_array($aglist))
			{?>
				<option value="<?php echo $agent['id'];?>" <?php if($_GET['agid']==$agent['id'])echo 'selected="selected"';?>><?php echo $agent['ag_fname'].' '.$agent['ag_lname'].'('.$agent['ag_code'].')';?></option>
			<?php }?>
		</select>
		   	<select name="cid" class="" style="width:100px; height:30">
			<option value=""> - Company - </option>
			<?php $clist=mysql_query("select * from ".COMPANYTBL."");
			while($company=mysql_fetch_array($clist))
			{?>
				<option value="<?php echo $company['id'];?>" <?php if($_GET['cid']==$company['id'])echo 'selected="selected"';?>><?php echo $company['comp_name'].'('.$company['comp_code'].')';?></option>
			<?php }?>
		</select>
		&nbsp;Policy No : 
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
            <td width="11%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="19%" align="left" bgcolor="#333333"><strong>Policy Number </strong></td>
            <td width="17%" align="center" bgcolor="#333333"><strong>Policy Amount </strong></td>
            <td width="16%" align="center" bgcolor="#333333"><strong>Agent Commision</strong></td>
            <td width="15%" align="center" bgcolor="#333333"><strong>KSA Commision</strong></td>
            <td width="22%" align="center" bgcolor="#333333"><strong>Amount For Company </strong></td>
          </tr>
			
	<?php $rs=mysql_query($sq);
		  if(mysql_num_rows($rs)>0)
		  {?>
		  <tr><td colspan="7"><div style="min-height:30; max-height:400px; overflow:auto"><table width="100%">
		  <?php 
		  while($row=mysql_fetch_array($rs)){
			  $j++;
			  $bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			  $agent_price=($row["amount_paid"]*$row["agent_commision"])/100;
			  $admin_price=($row["amount_paid"]*$row["admin_commision"])/100;
			  $company_price=$row["amount_paid"]-($agent_price+$admin_price);
			  $policy_amount_total=$policy_amount_total+$row["amount_paid"];
			  $agent_total=$agent_total+$agent_price;
			  $admin_total=$admin_total+$admin_price;
			  $company_total=$company_total+$company_price;
		  ?>
          <tr <?php echo $bgcolor; ?> height="24">
            <td align="center" width="11%" ><strong><?php echo $j+$startpoint; ?></strong></td>
            <td width="19%">
				<?php echo stripslashes($row["policy_id"]);?></a><?php  if($row["renew_id"]!='0') echo '(Renew)';?>
			</td>
            <td width="17%" align="center"><?php echo $row["amount_paid"]; ?></td>
            <td width="16%" align="center"><?php echo $agent_price.' ('.$row["agent_commision"].'%)';?></td>
            <td width="15%" align="center"><?php echo $admin_price.' ('.$row["admin_commision"].'%)';?></td>
            <td width="22%" align="center" ><?php echo $company_price;?></td>
          </tr>
          <?php $i=$i+1;}?></table></div></td></tr>
          <tr height="24" style="font-weight:bold">
            <td></td>
            <td align="center">Total:</td>
            <td align="center"><?php echo $policy_amount_total;?></td>
            <td align="center"><?php echo $agent_total;?></td>
            <td align="center"><?php echo $admin_total;?></td>
            <td align="center" ><?php echo $company_total;?></td>
          </tr>
		  <?php 
		  }
		  else
		  {?>
		  	<tr><td colspan="7" align="center" bgcolor="#F2FBFF" height="24">No Payment found.</td></tr>
		  <?php } ?>
          <tr>
            <td colspan="9" align="center">&nbsp; </td>
          </tr>
        </table></td>
      </tr>
    
  </table></form>
</div>
