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
		document.getElementById("publishall").disabled = "";
		document.getElementById("unpublishall").disabled = "";
		document.getElementById("deleteall1").disabled = "";
		document.getElementById("publishall1").disabled = "";
		document.getElementById("unpublishall1").disabled = "";
		
		for(l=1;l<=num_tot;l++)
		{
			obj = document.getElementById('chkNo'+l);
			document.getElementById("chkNo" + l).checked = true;
		}
	}else{
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("publishall").disabled = "disabled";
		document.getElementById("unpublishall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		document.getElementById("publishall1").disabled = "disabled";
		document.getElementById("unpublishall1").disabled = "disabled";
		
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
		document.getElementById("publishall").disabled = "";
		document.getElementById("unpublishall").disabled = "";
		document.getElementById("deleteall1").disabled = "";
		document.getElementById("publishall1").disabled = "";
		document.getElementById("unpublishall1").disabled = "";
		}
	}else{
		for(l=1;l<=num_tot;l++){
			if(document.getElementById("chkNo" + l).checked == true)
			flag++;
		}
		if(flag == 0){
		// disable group add/edit/delete buttons
		document.getElementById("deleteall").disabled = "disabled";
		document.getElementById("publishall").disabled = "disabled";
		document.getElementById("unpublishall").disabled = "disabled";
		document.getElementById("deleteall1").disabled = "disabled";
		document.getElementById("publishall1").disabled = "disabled";
		document.getElementById("unpublishall1").disabled = "disabled";
		}
	}
}

function confirmInput()
 {
  var retVal = confirm("Do you want to Delete these Quotes ?");
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
					$db->recordDelete(array("id" => $id),QUOTETBL);
					$count++;
				
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=quotes';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=quotes';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=quotes';</script>";
		}
		break;
		case 'publishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'replied'),QUOTETBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Replied successfully');location.href='account.php?page=quotes';</script>";
			}else{
				echo "<script>alert('No Records Replied');location.href='account.php?page=quotes';</script>";
			}
		}else{
			echo "<script>alert('No Records Replied');location.href='account.php?page=quotes';</script>";
		}
		break;
		case 'unpublishall':
		if(is_array($_POST['chkNo']) && count($_POST['chkNo']) > 0){
			// delete
			$count = 0;
			foreach($_POST['chkNo'] as $id){
				// delete user record
				if($db->recordUpdate(array("id" => $id),array('status'=>'pending'),QUOTETBL) == 1){
					$count++;
				}
			}
			if($count > 0){
				echo "<script>alert('Records Pending successfully');location.href='account.php?page=quotes';</script>";
			}else{
				echo "<script>alert('No Pending Replied');location.href='account.php?page=quotes';</script>";
			}
		}else{
			echo "<script>alert('No Records Pending');location.href='account.php?page=quotes';</script>";
		}
		break;
		
	}
}

if($_GET['part'])
	$parturl="&part=".$_GET['part'];

if($_REQUEST['task']=='delete')
{

 $sqql="delete from ".QUOTETBL." where id='".$_REQUEST['id']."'";

 $qrr=mysql_query($sqql);
echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=quotes".$parturl."';</script>";
}

if($_GET['task']=='active'){

	 $id=$_GET['id'];
     $quotes = mysql_fetch_array(mysql_query("SELECT * FROM ".QUOTETBL." WHERE id = '".$id."'"));
	if($quotes['emp_note']=="") {
	echo "<script>alert('Add Note to Reply');location.href='account.php?page=quotes".$parturl."';</script>"; }
	
	else {
	$sqlp="update ".QUOTETBL." set status='replied' where id='$id'";

	$resultp=mysql_query($sqlp);
	if(mysql_affected_rows() > 0)
	{
		$detail = mysql_fetch_array(mysql_query("SELECT * FROM ".QUOTETBL." WHERE id = '".$id."'"));
		
		$to=$detail['email'];
		$email_data=getEmailTemplate(30);
		$subject = $email_data['0'];
		$message= setMailContent(array($detail['contact_person'], '', '', '', '', '', '', '', '', '', $detail['emp_note']), $email_data['1']);
		sendMail($to,$subject,$message);
		echo "<script>alert('Record Replied Sucessfully');location.href='account.php?page=quotes".$parturl."';</script>";
		
		
	}
	else
		echo "<script>alert('Record Replied Failed');location.href='account.php?page=quotes".$parturl."';</script>";
	}

}

if($_GET['task']=='inactive'){

	 $id=$_GET['id'];

	$sqlp="update ".QUOTETBL." set status='pending' where id='$id'";

	$resultp=mysql_query($sqlp);
	if(mysql_affected_rows() > 0)
		echo "<script>alert('Record Pending Sucessfully');location.href='account.php?page=quotes".$parturl."';</script>";
	else
		echo "<script>alert('Record Pending Failed');location.href='account.php?page=quotes".$parturl."';</script>";

}

$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 
?>  

<!-- app -->

<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
<form action="" method="post" name="partcat_form" id="partcat_form" onSubmit="return masterValidate()">  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Quotes </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=article"></a></td>
    </tr>
    <tr>
      <td width="29%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
		  <input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
		  <input type="button" name="publishall" id="publishall" value="Reply" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='publishall';document.partcat_form.submit();" disabled="disabled"/>
		  
         <input type="button" name="unpublishall" id="unpublishall" value="Pending" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='unpublishall';document.partcat_form.submit();" disabled="disabled"/>
	  </td>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
	  <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <td width="16%" align="right">Title:</td>
        <td width="74%" align="right" style="padding-left: 4px;"><input name="stitle" type="text" class="textbox" id="quest" style="width: 200px;" 
		value="<?php echo $_POST["stitle"]; ?>">&nbsp;&nbsp;OR&nbsp;&nbsp;
        <select name="search_by_status" id="search_by_status"><option value="">Status</option><option value="replied" <?php if($_POST["search_by_status"] == "replied") echo "selected='selected'"; ?>>Replied</option><option value="pending" <?php if($_POST["search_by_status"] == "pending") echo "selected='selected'"; ?>>Pending</option></select></td>
        <td width="10%" align="right"><input type="submit" name="search" id="search" value=" Search " class="actionBtn"></td>
        </tr>
      </table>
	  </td>
      </tr>
    <?php if($msg <> ""){
?>
    <div style="border: 1px solid #990; background-color: #FFC; padding: 2px; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
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
          <tr style="color: #FFF;">
            <td width="7%" align="center" bgcolor="#333333"><input type="checkbox" name="chkAll" id="chkAll" onclick="check_all();" /></td>
            <td width="8%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="26%" align="left" bgcolor="#333333"><strong>Company Name</strong></td>
            <td width="18%" align="left" bgcolor="#333333"><strong>Email</strong></td>
            <td width="15%" align="left" bgcolor="#333333"><strong>Phone Number</strong></td>
            <td width="12%" align="center" bgcolor="#333333"><strong>Status</strong></td>
            <td width="12%" align="center" bgcolor="#333333"><strong>Action</strong></td>
          </tr>
          		
				<?php 
if(isset($_POST["search"])){
		  $j = 0;
		  $i = 0;
		  if($_POST["search_by_status"]!="") {
	 	
		$sq = "SELECT * FROM ".QUOTETBL." WHERE status='".$_POST["search_by_status"]."' ORDER BY id desc LIMIT ".$startpoint.",".$perpage;
	 	//echo "SELECT * FROM ".QUOTETBL." WHERE company_name LIKE '%".$_POST["stitle"]."%' ORDER BY id ASC LIMIT ".$startpoint.",".$perpage;
	  }	
	  
	  else {
		$sq = "SELECT * FROM ".QUOTETBL." WHERE company_name LIKE '%".$_POST["stitle"]."%' or email LIKE '%".$_POST["stitle"]."%' or phone_no LIKE '%".$_POST["stitle"]."%' ORDER BY id desc LIMIT ".$startpoint.",".$perpage; }
}
	  else
	  {			
				
		  $sq = "select * from ".QUOTETBL." ORDER BY id desc LIMIT ".$startpoint.",".$perpage;}
					
		  $rs=mysql_query($sq);
		  if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		  while($row=mysql_fetch_array($rs)){
		  $j++;
		  $bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
			 
		  ?>
          <tr <?php echo $bgcolor; ?>>
            <td align="center" ><input type="checkbox" name="chkNo[]" id="chkNo<?php echo $j;?>" value="<?php echo $row['id']; ?>" onclick="check_single('chkNo<?php echo $j;?>');" /></td>
            <td align="center" ><strong><?php echo $j; ?></strong></td>
            <td ><?php echo stripslashes($row["company_name"]); ?></td>
            <td ><?php echo stripslashes($row["email"]); ?></td>
            <td ><?php echo stripslashes($row["phone_no"]); ?></td>
         
            <td align="center" >
			<?php 
			if($row["status"]=='pending') 
			{ ?>
              <a href="account.php?page=quotes&task=active&id=<?php echo $row["id"]; ?>"><font color="#FF0000">Pending</font></a>
             <?php } else {?>
              <a href="account.php?page=quotes&task=inactive&id=<?php echo $row["id"]; ?>"><font color="#006633">Replied</font></a>
            <?php } ?>
			</td>

            <td align="center" >
			<a href="public/quote_view.php?id=<?php echo $row['id']; ?>" id="fancy"><img src="images/view.png"  width="16" height="16" border="0" title="View Corporate Quote" style="cursor: pointer;" /></a>&nbsp;
				<a href="public/emp_note.php?id=<?php echo $row['id']; ?>" id="fancy"><img src="images/answer.png" width="16" height="16" border="0" style="cursor: pointer;" title="View Note"></a>&nbsp;
				<a href="account.php?page=quotes&task=delete&id=<?php echo $row["id"];  ?>" onclick="return confirm('ARE YOU SURE TO DELETE!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete Quote" style="cursor: pointer;"></a>
			</td>
          </tr>
          <?php $i=$i+1;} ?>
          <tr>
            <td colspan="8" align="left"><input type="button" name="deleteall" id="deleteall1" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
      <span style="border-bottom: 0px ; padding-bottom: 0px; padding-left: 1px; padding-right: 1px; font-size: 14px; color: #036;">
      <input type="button" name="publishall" id="publishall1" value="Reply" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='publishall';document.partcat_form.submit();" disabled="disabled"/>
	  <input type="button" name="unpublishall2" id="unpublishall1" value="Pending" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="document.partcat_form.todo.value='unpublishall';document.partcat_form.submit();" disabled="disabled"/>

      </span>
      <input type="hidden" name="todo" id="todo" value=""/></td>
          </tr>
          <tr>
            <td colspan="8" align="center"><?php
			
			 if(isset($_POST['search'])){
				  if($_POST["search_by_status"]!="") {
				  
				  echo Paging(QUOTETBL,$perpage,"account.php?page=quotes&","status='".$_POST["search_by_status"]."' ORDER BY id DESC"); }
				  else {
				   echo Paging(QUOTETBL,$perpage,"account.php?page=quotes&","company_name LIKE '%".$_POST['stitle']."%' or email LIKE '%".$_POST["stitle"]."%' or phone_no LIKE '%".$_POST["stitle"]."%' ORDER BY id DESC"); }
					
					
					}else{
					echo Paging(QUOTETBL,$perpage,"account.php?page=quotes&");
					} 
			
			  ?>
			
			
				 
					
			
			 </td>
          </tr>
           <tr>
            <td colspan="8" align="left">Search can be possible by Company Name or Email Id or Status .</td>
           </tr>
        </table></td>
      </tr>
    
  </table></form>
</div>
