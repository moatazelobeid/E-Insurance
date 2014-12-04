<?php
if($_GET['id'] == "")

{

	// button variables

	$btn_name = "save";

	$btn_value = "Add New E-Mail";

}

else

{

	$btn_name = "update";

	$btn_value = " Update & Save ";

	$cancel = "<a href='account.php?page=manage-email&view=list'>Cancel</a>";

}



// edit record

if($_GET['id'] != "")

{

	$sq_var = "SELECT * FROM ".EMAILTEMP." WHERE id = '".$_GET['id']."'";

	$res_var = mysql_query($sq_var);

	$rs_var = mysql_fetch_object($res_var);

	

	// get vars

	$email_name = stripslashes($rs_var->email_name);
	$subject = stripslashes($rs_var->subject);
	$body = stripslashes($rs_var->body);

}



// update

if(isset($_POST['update']))

{

	// params

	$email_name = addslashes(trim($_POST['email_name']));
	$subject = addslashes(trim($_POST['subject']));
	$body = addslashes(trim($_POST['body']));
	$page_id = $_POST['page_id'];

	$msg = "";

	// save

	$sq_update = "UPDATE ".EMAILTEMP." SET email_name = '".$email_name."',subject = '".$subject."',body = '".$body."' WHERE id = '".$page_id."'";

	$res_update = mysql_query($sq_update);

	header("location:account.php?page=manage-email&view=list");
	
}

if(isset($_POST['save']))

{

	// params

	$email_name = addslashes(trim($_POST['email_name']));
	$subject = addslashes(trim($_POST['subject']));
	$body = addslashes(trim($_POST['body']));
	

	$msg = "";

	// save

	$sq_update = "insert into  ".EMAILTEMP."  (email_name,subject,body) values('".$email_name."','".$subject."','".$body."')";

	$res_update = mysql_query($sq_update);

	header("location:account.php?page=manage-email&view=list");
	
}
$part = (int) (!isset($_GET['part']) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 20;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 
if($_GET["view"]!="list"){
?>
<!-- app -->
<div style="width: 100%; margin: 0 auto; margin-top: 10px;" align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td width="67%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Edit Email Content </strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;">
	  
	  <input type="button" name="addnew" id="addnew" value="View All Content" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; cursor: pointer;" onclick="location.href='account.php?page=manage-email&view=list'"/>
	  </td>
    </tr>
    <?php if($msg <> "") { ?>
  <div style="border: 1px solid #990; background-color: #FFC; padding: 2px; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="7%"><img src="../images/warning.png" width="32" height="32"></td>
<td width="93%"><?php echo $msg; ?></td>
</tr>
</table>
</div>
<?php } ?>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="3" style="background-color: #f2f2f2;">
  <form action="" method="post" name="partcat_form" onSubmit="return masterValidate('partcat_form','Enter Page Title!')">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="14%">Email Title:</td>
        <td width="86%"><span style="padding-left: 4px;">
          <input name="email_name"  type="text"    id="email_name" value="<?php echo $email_name; ?>" style="width: 250px;" class="textbox"/>
        </span></td>
        </tr>
        <tr>
        <td width="14%">Email Subject:</td>
        <td width="86%"><span style="padding-left: 4px;">
          <input name="subject" type="text" id="subject" value="<?php echo $subject; ?>" style="width: 250px;" class="textbox"/>
        </span></td>
        </tr>
      <tr>
        <td colspan="2">
		<?php

			include_once("editor/fckeditor.php");

			$oFCKeditor = new FCKeditor('body',320);

			$oFCKeditor->BasePath = 'editor/';

			$oFCKeditor->Config['EnterMode'] = 'br';

			$oFCKeditor->Value = $body;

			$oFCKeditor->Create(); 

			?>
		
		  </td>
        </tr>
      <tr>
        <td colspan="2"><input name="<?php echo $btn_name; ?>" type="submit" id="<?php echo $btn_name; ?>" value="<?php echo $btn_value; ?>" class="actionBtn" />
          <span style="padding-left: 4px;">
            <input type="hidden" name="page_id" value="<?php echo $_GET['id']; ?>" />
  &nbsp;&nbsp;<?php echo $cancel; ?></span></td>
      </tr>
    </table>
  </td>
  </tr>
  </form>
</table>
</div>
<?php }else { ?>
<div style="width: 100%; margin: 0 auto; margin-top: 10px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td width="67%" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>List All Email Content</strong></td>
      <td width="33%" align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-right: 0px; font-size: 14px; color: #036;">
	 <!-- <input type="button" name="addnew" id="addnew" value="Add New" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; cursor: pointer;" onclick="location.href='account.php?page=manage-email'"/>-->
	  </td>
    </tr>
    <?php if($msg <> "") { ?>
    
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
            <td width="15%" align="center" bgcolor="#333333"><strong>SL#</strong></td>
            <td width="33%" align="center" bgcolor="#333333"><strong> Email Type </strong></td>
            <td width="35%" align="center" bgcolor="#333333"><strong>Subject</strong></td>
            <td width="17%" align="center" bgcolor="#333333"><strong>Action</strong></td>
          </tr>
          		
		<?php 
		  $sq = "select * from ".EMAILTEMP." ORDER BY id ASC LIMIT ".$startpoint.",".$perpage."";
		  $rs=mysql_query($sq);
		  if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $i=1;}else{$i=(20*($_GET["part"]-1))+1;}
		  while($row=mysql_fetch_array($rs)){
		  $bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
		  ?>
          <tr <?php echo $bgcolor; ?>>
            <td align="center" ><strong><?php echo $i; ?></strong></td>
            <td align="center"><?php echo $row["email_name"]; ?></td>
            <td align="center"><?php echo $row["subject"]; ?></td>
            <td align="center" ><a class="postcomment" href="public/email_view.php?id=<?php echo $row['id']; ?>" id="manager_list"><img src="images/view.png"  width="16" height="16" border="0" title="View" style="cursor: pointer;" /></a>&nbsp;<a href="account.php?page=manage-email&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;"></a></td>
          </tr>
          <?php $i=$i+1;} ?>
          <tr>
            <td colspan="7" align="center"><?php
			
				 
					echo Paging("".EMAILTEMP."",$perpage,"account.php?page=manage-email&view=list&");
					
			
			  ?></td>
          </tr>
        </table></td>
      </tr>
    </form>
  </table>
</div>
<?php } ?>