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

function confirmInput()
 {
  var retVal = confirm("Do you want to Delete these Contacts ?");
   if( retVal == true ){
      
	   document.partcat_form.todo.value='deleteall';document.partcat_form.submit()
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
					$db->recordDelete(array("id" => $id),CONTACTS);
					$count++;
				
			}
			if($count > 0){
				echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=contacts';</script>";
			}else{
				echo "<script>alert('No Records Deleted');location.href='account.php?page=contacts';</script>";
			}
		}else{
			echo "<script>alert('No Records Found To Delete');location.href='account.php?page=contacts';</script>";
		}
		break;
	}
}

if($_GET['part'])
	$parturl="&part=".$_GET['part'];

if($_REQUEST['task']=='delete')
{

 $sqql="delete from ".CONTACTS." where id='".$_REQUEST['id']."'";

 $qrr=mysql_query($sqql);
echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=contacts".$parturl."';</script>";
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
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Contacts </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=article"></a></td>
    </tr>
    <tr>
      <td width="29%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
		  <input type="button" name="deleteall" id="deleteall" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
	  </td>
      <td colspan="2" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
	  <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <td width="33%" align="right">Name:</td>
           <td width="35%" align="right" style="padding-left: 4px;"><input name="stitle" type="text" class="textbox" id="quest" style="width: 200px;" 
		value="<?php echo $_POST["stitle"]; ?>"></td>
        <td width="32%" align="right"><input type="submit" name="search" id="search" value=" Search " class="actionBtn">&nbsp;&nbsp;<a href="account.php?page=contacts"><span style="color:#FFFFFF" class="actionBtn">Reset</span></a></td>
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
            <td width="26%" align="left" bgcolor="#333333"><strong>Name</strong></td>
            <td width="18%" align="left" bgcolor="#333333"><strong>Email</strong></td>
            <td width="15%" align="left" bgcolor="#333333"><strong>Phone Number</strong></td>
            <td width="15%" align="left" bgcolor="#333333"><strong>Contact Date</strong></td>
            <td width="12%" align="center" bgcolor="#333333"><strong>Action</strong></td>
          </tr>
          		
				<?php 
if(isset($_POST["search"])){
		  $j = 0;
		  $i = 0;
	 	$sq = "SELECT * FROM ".CONTACTS." WHERE name LIKE '%".$_POST["stitle"]."%' ORDER BY id ASC LIMIT ".$startpoint.",".$perpage;
	  }	else
	  {			
				
		  $sq = "select * from ".CONTACTS." ORDER BY id LIMIT ".$startpoint.",".$perpage;}
					
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
            <td ><?php echo stripslashes($row["name"]); ?></td>
            <td ><?php echo stripslashes($row["email"]); ?></td>
            <td ><?php echo stripslashes($row["phone"]); ?></td>
            <td ><?php echo date('d/m/Y',strtotime($row["contact_date"])); ?></td>
            <td align="center" >
			<a href="public/contact_view.php?id=<?php echo $row['id']; ?>" id="fancy"><img src="images/view.png"  width="16" height="16" border="0" title="View" style="cursor: pointer;" /></a>&nbsp;
				<a href="account.php?page=contacts&task=delete&id=<?php echo $row["id"];  ?>" onclick="return confirm('ARE YOU SURE TO DELETE!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a>			</td>
          </tr>
          <?php $i=$i+1;} ?>
          <tr>
            <td colspan="8" align="left"><input type="button" name="deleteall" id="deleteall1" value="Delete " style="font-family: Verdana, Geneva, sans-serif; font-size: 11px;" onclick="confirmInput();" disabled="disabled"/>
      <input type="hidden" name="todo" id="todo" value=""/></td>
          </tr>
          <tr>
            <td colspan="8" align="center"><?php
			
			 if(isset($_POST['search'])){
				  echo Paging(CONTACTS,$perpage,"account.php?page=contacts&","name LIKE '%".$_POST['stitle']."%' ORDER BY id DESC");
					
					}else{
					echo Paging(CONTACTS,$perpage,"account.php?page=contacts&");
					} 
			
			  ?>
			
			
				 
					
			
			 </td>
          </tr>
        </table></td>
      </tr>
    
  </table></form>
</div>
