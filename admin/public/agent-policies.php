<?php 
$where="";
if($_GET["s"])
{
	$j = 0;
	$i = 0;
	$where.=" and policy_no LIKE '%".$_GET["s"]."%'";
	$sub_url.='&s='.$_GET["s"];
}
if($_GET["agid"] )
{
	$j = 0;
	$i = 0;
	$where.=" and agent_id = '".$_GET["agid"]."'";
	$sub_url.='&agid='.$_GET["agid"];
}
if($_GET["type"])
{
	$j = 0;
	$i = 0;
	$where.=" and policy_type = '".$_GET["type"]."'";
	$sub_url.='&type='.$_GET["type"];
}
?>
<script language="javascript" type="text/javascript">
function check_all()
{
//alert(123);
	var num_tot = document.getElementsByName('chkNo[]').length;
		//alert(num_tot);

	var l,m,obj;
	if(document.getElementById("chkAll").checked == true)
	{
		// enable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "";
		document.getElementById("deleteall1").disabled = "";
		
		for(l=1;l<=num_tot;l++)
		{
			obj = document.getElementById('chkNo'+l);
			document.getElementById("chkNo" + l).checked = true;
		}
	}else{
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		
		for(m=1;m<=num_tot;m++)
		{
			document.getElementById("chkNo" + m).checked = false;
		}
	}
}


function check_single(checkid){
	var num_tot = document.getElementsByName('chkNo[]').length;
	var l,m;
	var flag = 0;
	if(document.getElementById(checkid).checked == true)
	{
		for(l=1;l<=num_tot;l++){
			if(document.getElementById("chkNo" + l).checked == true)
			flag++;
		}
		if(flag == 1){
		// enable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "";
		document.getElementById("deleteall1").disabled = "";
		}
	}else{
		for(l=1;l<=num_tot;l++){
			if(document.getElementById("chkNo" + l).checked == true)
			flag++;
		}
		if(flag == 0){
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		}
	}
}

function searchPolicy()
{
	var form=document.partcat_form;
	var s_url='';
	var ag_url='';
	var type_url='';
	if(form.stitle.value!='')
		s_url='&s='+form.stitle.value;
	if(form.agid.value!='')
		ag_url='&agid='+form.agid.value;
	if(form.type.value!='')
		type_url='&type='+form.type.value;
	var url='<?php echo BASE_URL;?>account.php?page=agent-policies'+s_url+ag_url+type_url;
	
	window.location.href=url;
}

function checkUpdate(val,id)
{
$.ajax({
   			 type: "POST",
  			 url: "util/utils.php",
  			 data: "status="+val+"&id="+id,
  			 success: function(msg) 
			 { 
					if(msg == 'OK')
					{
						alert ("Status changed Successfully")
					}
					else if(msg == 'ERROR')
					{
						alert("Error in updating status");
					}
			 }
		});

}

function confirmInput()
 {
  var retVal = confirm("Do you want to Delete these Agent Policy ?");
   if( retVal == true ){
      
	   document.partcat_form.todo.value='deleteall';document.partcat_form.submit();
	  return true;
   }else{
      
	  return false;
	
   }
 }
</script>

<?php
//delete--all
// delete all users
if(isset($_POST['todo'])){
	// case
	switch($_POST['todo']){
		case 'deleteall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
					$sqql=mysql_query("update ".USERPOLICY." set del_status='1' where id='".$id."'");
					$count++;
				
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=agent-policies';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=agent-policies';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=agent-policies';</script>";
		}
		break;
		
	}
}

if($_GET['part'])
	$parturl="&part=".$_GET['part'];

if($_REQUEST['task']=='delete')
{

 $sqql="update ".USERPOLICY." set del_status='1' where id='".$_REQUEST['id']."'";

 $qrr=mysql_query($sqql);
echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=agent-policies".$parturl."';</script>";
}

$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 
?>  

<!-- app -->

<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
<form action="" method="post" name="partcat_form" id="partcat_form" onSubmit="return masterValidate()">  <table width="100%" border="0" cellspacing="2" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Policies </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=article"></a></td>
    </tr>
    <tr>
      <td width="20%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
	    <input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/></td>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
	  <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
           
        <td align="right">
		<select name="type" class="">
			<option value=""> - Type - </option>
			<option value="travel" <?php if($_GET['type']=='travel')echo 'selected="selected"';?>>Travel</option>
			<option value="medical" <?php if($_GET['type']=='medical')echo 'selected="selected"';?>>Medical</option>
			<option value="malpractice" <?php if($_GET['type']=='malpractice')echo 'selected="selected"';?>>Malpractice</option>
			<option value="auto" <?php if($_GET['type']=='auto')echo 'selected="selected"';?>>Auto</option>
		</select>&nbsp;
		 <select name="agid" class="">
			<option value=""> - Agent - </option>
			<?php $aglist=mysql_query("select * from ".AGENTTBL."");
			while($agent=mysql_fetch_array($aglist))
			{?>
				<option value="<?php echo $agent['id'];?>" <?php if($_GET['agid']==$agent['id'])echo 'selected="selected"';?>><?php echo $agent['ag_fname'].' '.$agent['ag_lname'].'('.$agent['ag_code'].')';?></option>
			<?php }?>
		</select>
		<input name="stitle" type="text" class="textbox" id="quest" style="width: 200px;" 
		value="<?php echo $_GET["s"]; ?>"></td>
        <td width="14%" align="right"><input type="button" name="search" id="search" value=" Search " class="actionBtn" onclick="searchPolicy();"></td>
        </tr>
      </table>
	  </td>
      </tr>
  </table>
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr style="color: #FFF;">
            <td width="5%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
            <td width="6%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="13%" align="left" bgcolor="#333333"><strong>Policy Number </strong></td>
            <td width="24%" align="left" bgcolor="#333333"><strong>Name</strong></td>
            <td width="16%" align="left" bgcolor="#333333"><strong>Policy Type</strong></td>
            <td width="14%" align="center" bgcolor="#333333"><strong>Status</strong></td>
            <td width="12%" align="center" bgcolor="#333333"><strong>Action</strong></td>
          </tr>
          		
<?php 
		  $sq= "select * from ".USERPOLICY." where del_status='0' and created_by='agent' ".$where." ORDER BY id desc";
			
		  $rs=mysql_query($sq." LIMIT ".$startpoint.",".$perpage);
		  if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		  if($row=mysql_num_rows($rs)>0)
		  {
		  while($row=mysql_fetch_array($rs)){
		  $j++;
		  $bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			 
		  ?>
          <tr <?php echo $bgcolor; ?>>
            <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $j;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $j;?>');" /></td>
            <td align="center" ><strong><?php echo $j+$startpoint; ?></strong></td>
            <td ><?php echo stripslashes($row["policy_no"]); ?></td>
            <td ><?php echo stripslashes($row["fname"]).' '.stripslashes($row["lname"]); ?></td>
            <td ><?php echo ucwords(stripslashes($row["policy_type"])); if($row["policy_type"]=='auto')echo ' ('.autoPolicyType($row["policy_no"]).')'; ?></td>
         
            <td align="center" >
				<select name="status" class="generalDropDown" onchange="checkUpdate(this.value,<?php echo $row["id"]; ?>);">
					<option value="1" <?php if($row["status"]=='1') echo 'selected="selected"';?>>Active</option>
					<option value="0" <?php if($row["status"]=='0') echo 'selected="selected"';?>>Expired</option>
					<option value="2" <?php if($row["status"]=='2') echo 'selected="selected"';?>>Cancelled</option>
				</select>
			</td>

            <td align="center" >
			<a href="account.php?page=user_policy_details&id=<?php echo $row['id']; ?>&type=agent"><img src="images/view.png"  width="16" height="16" border="0" title="View" style="cursor: pointer;" /></a>&nbsp;
			<a href="account.php?page=edit-policy&policy_no=<?php echo $row["policy_no"];  ?>&type=agent"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a>
				&nbsp;
				<a href="account.php?page=agent-policies&task=delete&id=<?php echo $row["id"];  ?>&type=agent" onclick="return confirm('ARE YOU SURE TO DELETE!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a>
			</td>
          </tr>
          <?php $i=$i+1;} ?>
		 
          <tr>
            <td colspan="8" align="left"><input type="button" name="deleteall" id="deleteall1" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
              <input type="hidden" name="todo" id="todo" value=""/></td>
          </tr>
		  <?php  }
		  else
		  {?>
		  		<tr bgcolor="#F2FBFF"><td colspan="8" align="center">No Policy found.</td></tr>
		  <?php }?>
          <tr>
            <td colspan="8" align="center"><?php  echo Paging("",$perpage,"account.php?page=agent-policies".$sub_url."&","",$sq);?>
						
			 </td>
          </tr>
        </table></td>
      </tr>
    
  </table></form>
</div>
