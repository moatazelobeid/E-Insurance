<?php

//Delete Individual Entry
if($_REQUEST['task']=='delete')
{
  $sqql="delete from ".SUBMENUTBL." where id='".$_REQUEST['id']."'";
  $qrr=mysql_query($sqql);
  ?>
    <script type="text/ecmascript">
	window.location="account.php?page=manage_sub_menu&view=list";
	</script>
<?php
}

//Block a menu
if($_GET['task']=='block'){
  $id=$_GET['id'];
  $sqlu=mysql_query("update ".SUBMENUTBL." set status='0' where id='$id'");
  ?>
    <script type="text/ecmascript">
	window.location="account.php?page=manage_sub_menu&view=list";
	</script>
<?php
}

//Activate a menu
if($_GET['task']=='active'){
 $id=$_GET['id'];
 $sqlp="update ".SUBMENUTBL." set status='1' where id='$id'";
 $resultp=mysql_query($sqlp);
 ?>
    <script type="text/ecmascript">
	window.location="account.php?page=manage_sub_menu&view=list";
	</script>
<?php
}


// Defining button value
if($_GET['id'] == "")
{
 // button variables
 $btn_name = "save";
 $btn_value = " Add New Submenu ";
}
else
{
 $btn_name = "update";
 $btn_value = " Update & Save ";
 $cancel = "<a href='account.php?page=faq&view=list'>Cancel</a>";
}

if($_GET['id'] != "")
{
	$dew = mysql_query("select * from ".SUBMENUTBL." where id = '".$_GET['id']."'");
	$dat = mysql_fetch_array($dew);
}


// save record
if(isset($_POST['save']))
{
    // params

	$menid    =   $_POST['menu_name'];
	
	$sqlmn    =   mysql_query("select menu_name from ".ADMMENU." where menu_id='".$menid."'"); 
	
	$menunm   =   mysql_fetch_assoc($sqlmn);
	
	$sqlsb    =   mysql_query("select max(submenu_id)+1 as mnid from ".SUBMENUTBL." where menu_id='".$menid."'"); 
	
	$sbid     =   mysql_fetch_assoc($sqlsb);
	
	//echo $sbid;
	if($sbid['mnid']=="") $sbid['mnid']=1;
	//echo $sbid['mnid'];
	$submenu=addslashes($_POST['submenu']);
	$pgnm= $_POST['pgnm'];

	$msg = "";

	// save

	$sq_save = "INSERT INTO ".SUBMENUTBL." (menu_id,menu_name,submenu_id,submenu_name,page) VALUES('".$menid."','".$menunm['menu_name']."','".$sbid['mnid']."','".$submenu."','".$pgnm."')";

	$res_save = mysql_query($sq_save);
    if($res_save) 
	{
	$msg="Submenu added successfully.";
	header("location:account.php?page=manage_sub_menu&view=list");
	}
	else $msg="Error";	
}



// edit record
if(isset($_POST['update']))
{
    // params
	$id  =   $_GET['id'];
	
	$sbm = $_GET['submenu'];
	
	$submenu=addslashes($_POST['submenu']);
	
	$pgnm= $_POST['pgnm'];	

	$msg = "";

	// save

	$sq_save = "update ".SUBMENUTBL." set submenu_name = '".$submenu."',page = '".$pgnm."' where id = '".$id."' and submenu_id = '".$sbm."'";

	$res_save = mysql_query($sq_save);
	
    if($res_save) 
	{
	$msg="Submenu Updated successfully.";
	header("location:account.php?page=manage_sub_menu&view=list");
	}
	else 
	
	$msg="Error";	
}


?>
<script type="text/javascript" >

function form_validate()
{ 

    var str = document.submenu_form;
	var error = "";
	var flag = true;
	var dataArray = new Array();
 gh=$("#msg").html();
 if(gh=="Page Name Already exists.")
 {
	 return false;
	 
	 }
	if(document.getElementById("menu_name").value=="")
	{
	  flag= false;
	  str.menu_name.style.borderColor = "RED";
	  error+=" - Select a menu \n";
	  dataArray.push('menu_name');
	  //return false;
	}
	
	
    if(document.getElementById("submenu").value=="")
	{
	  flag= false;
	  str.submenu.style.borderColor = "RED";
	  error+=" - Enter a Submenu \n";
	  dataArray.push('submenu');
	  //return false;
	}
	
	if(document.getElementById("pgnm").value=="")
	{
	  flag= false;
	  str.pgnm.style.borderColor = "RED";
	  error+=" - Enter a Page Name \n";
	  dataArray.push('pgnm');
	  //return false;
	}
	
	if(flag==false)
	{
	 str.elements[dataArray[0]].focus();
	 alert(error);
	  return false;
	}
	else if(document.getElementById("msg").innerHTML=="Page Name Already exists.")
	{
		return false;
	}
	else if(document.getElementById("msg1").innerHTML=="Submenu Already exists.")
	{
		return false;
	}
	  
	else
	{
		
		 return true;
	}
	
}

function check_pgnm(pg,con)
{	
	$.ajax({ 
	type: "POST",  
	url: "util/check_page.php",  
	data: "page="+pg+"&cond="+con,
	success: function(msg){
	if(msg==1)
	{
		alert("Page name already exists");
		$("#pgnm").val('');
	}
	}
   });  
}

function check_sbmn(pg,con)
{	
	var mn=document.getElementById("menu_name").value;
	$.ajax({ 
	type: "POST",  
	url: "util/check_page.php",  
	data: "page="+pg+"&cond="+con+"&mnid="+mn,
	success: function(msg){
	if(msg==2)
	{
		alert("Submenu name already exists");
		$("#submenu").val('');	 
	}
	}
   });
   
  
   
}

   //return false;
   </script>
	
<!-- app -->
<?php 
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage;

if($_GET["view"]!="list"){
?>
<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
  
     <tr><td colspan="2">

    	<?php if($msg <> "") { ?>
		<div style="border: 1px solid #990; background-color: #FFC; padding: 2px; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td id="msg1" ><?php echo $msg; ?></td>
                <div id="msg"> </div>
			</tr>
		</table>
		</div>
        
		<?php } ?>
        </td>
        </tr>
    <tr>
      <td width="72" align="right"><input type="button" value="Manage Menu" class="actionBtn" onclick="window.location.href='<?php echo BASE_URL;?>account.php?page=manage_sub_menu&view=list';" /></td>  
    </tr>
    <tr>
      <td bgcolor="#000" width="370" style="border-bottom: 1px solid #99C; color: #fff;"><strong>Manage Admin Submenu</strong></td>
    </tr>

  </table>
  <form action="" method="post" name="submenu_form" onSubmit="return form_validate()">
  <table width="100%" border="0" cellspacing="0" cellpadding="3"  >
  
  <tr> 
     <td > <table width="100%" border="0" cellspacing="4" cellpadding="0" align="left" vspace="5">
   

    <tr>
        <td width="30%"> Main Menu:</td>
        <td width="70%">
        <select  name="menu_name"  id="menu_name"  style="width:190px;" class="textbox"  >
        <option value="" >Select </option>
       <?php 
	   $menu=mysql_query("select * from ".ADMMENU." where status = 1");
	   while($rw=mysql_fetch_array($menu))
	   { ?>
       <option value="<?php echo $rw['menu_id']; ?>" <?php if($dat['menu_name']==$rw['menu_name']) { ?> selected="selected" <?php } ?> ><?php echo $rw['menu_name']; ?></option>
       <?php } ?>
       </select>
       </td>
     </tr>
      <tr>
        <td>Enter Submenu: </td>
        <td>
        <input  type="text" name="submenu" id="submenu" style="width:186px" value="<?php echo $dat['submenu_name']; ?>" onblur="return check_sbmn(this.value,'find_submenu')">
        </td>
        </tr>
        
      <tr>
        <td> Enter Page Name:</td >
        <td>
        <input  type="text" name="pgnm" style="width:186px" id="pgnm" value="<?php echo $dat['page']; ?>" onblur="return check_pgnm(this.value,'chk_pgnm')" >
        <div  name="pgnm1" id="pgnm1" ></div>
        </td>
     </tr>
  
  
      <tr>
        <td> </td>
        <?php if($_GET['task']=='edit')
		{
		?>
		<td height="66" ><input name="update" type="submit" id= "update" value="Update" class="actionBtn" />
        <?php
		}
		else
		{
		?>			
        <td height="66" ><input name="save" type="submit" id= "save" value="Save" class="actionBtn" />
        <?php
		}
		?>
 </td>
      </tr>
    </table>
  </td>
  

     </tr>
    
  </table>
  </form>
</div>


<?php }else { ?>
<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td width="67%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Admin Sub Menus</strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;"><a href="account.php?page=manage_sub_menu"><img src="images/add_new.png" width="87" height="15" border="0"></a></td>
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
    <form action="" method="post" name="partcat_form" id="partcat_form" onsubmit="return masterValidate('partcat_form','Enter Page Title!')">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr style="color: #FFF;">
            <td width="10%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="20%" align="left" bgcolor="#333333"><strong> Main Menu Name</strong></td>
            <td width="20%" align="left" bgcolor="#333333"><strong> Sub Menu Name</strong></td>
            <td width="18%" align="center" bgcolor="#333333"><strong>Page Name</strong></td>
            <!--<td width="13%" align="center" bgcolor="#333333"><strong>View</strong></td>-->
            <td width="18%" align="center" bgcolor="#333333"><strong>Status</strong></td>
            <td width="14%" align="center" bgcolor="#333333"><strong>Action</strong></td>
          </tr>
          		
		<?php  //(menu_id,menu_name,submenu_id,submenu_name,page)
		  $sq = "select * from ".SUBMENUTBL." ORDER BY id desc LIMIT ".$startpoint.",".$perpage."";
					
		  $rs=mysql_query($sq);
		  if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		  while($row=mysql_fetch_array($rs)){
		  $bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
		  $sq12 = "select * from ".FAQADMINTBL." where id=".$row['catid']."";
				
		  $rs12=mysql_query($sq12);
		  $row12=mysql_fetch_array($rs12);	
		  ?>
          <tr <?php echo $bgcolor; ?>>
            <td align="center" ><strong><?php echo $i; ?></strong></td>
            <td ><?php echo $row["menu_name"]; ?></td>
            <td ><?php echo $row["submenu_name"]; ?></td>
            <td align="center" ><?php echo $row["page"]; ?></td>
            <td align="center" ><?php 
			
		if($row["status"]=='0'){?>
        <a href="account.php?page=manage_sub_menu&task=active&view=list&id=<?php echo $row["id"]; ?>">In Active</a>
        <?php } else {?>
        <a href="account.php?page=manage_sub_menu&task=block&view=list&id=<?php echo $row["id"]; ?>">Active</a>
        <?php }?></td>
            <td align="center">
			<a href="account.php?page=manage_sub_menu&task=edit&id=<?php echo $row["id"]; ?>&submenu=<?php echo $row["submenu_id"]; ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a>&nbsp;
			
			<a href="account.php?page=manage_sub_menu&task=delete&view=list&id=<?php echo $row["id"];  ?>" onclick="return confirm('Deleting This Row May Cause Access Limitation Of Site.\n Are You Sure To Continue !!!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a>
			
			</td>
          </tr>
          <?php $i=$i+1;} ?>
          <tr>
            <td colspan="7" align="center"><?php
			
				 
					echo Paging("".SUBMENUTBL."",$perpage,"account.php?page=manage_sub_menu&view=list&");
					
			
			  ?></td>
          </tr>
        </table></td>
      </tr>
    </form>
  </table>
</div>
<?php } ?>