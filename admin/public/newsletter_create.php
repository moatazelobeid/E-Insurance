<?php

// save record

if(isset($_POST['save']))

{

	// params

	$title = addslashes(trim($_POST['title']));

	$subject = addslashes(trim($_POST['subject']));

	$message = addslashes(trim($_POST['message']));
	$user_type = addslashes(trim($_POST['user_type']));

	$msg = "";

	// save

	//checking duplicate title

	$check=mysql_query("select title from ".NEWSLETTER." where title = '$title'");

	if(mysql_num_rows($check)>0){

	$msg="Title Already Exists.Try Another.!!";

	}else{

	$sq_save = mysql_query("INSERT INTO ".NEWSLETTER." (title,subject,message,created_date,is_publish,publish_number,user_type) VALUES('".$title."','".$subject."','".$message."',now(),'0','0','".$user_type."')");

	if($sq_save)

	{

		// set nessage and redirection
		
		echo "<script>alert('Newsletter Added Sucessfully');location.href='account.php?page=newsletter_list';</script>";
		//$msg = "Submitted Sucessfully";
		
		$title = null;
		
		$subject = null;
		
		$message = null;

		//header("location:account.php?page=newsletter_list");

	}	

	else

	{

		$msg = "Saving Failed!";
		
		$title = null;
		
		$subject = null;
		
		$message = null;

	}

  }

}



// edit record

if($_GET['id'] != "")

{

	$sq_var = mysql_query("SELECT * FROM ".NEWSLETTER." WHERE id = '".$_GET['id']."'");

	$rs_var = mysql_fetch_object($sq_var);	

	// get vars

	$title = $rs_var->title;

	$message = stripslashes($rs_var->message);

	$subject=$rs_var->subject;
	$user_type=$rs_var->user_type;

}



// update

if(isset($_POST['update']))

{

	// params

	$title = addslashes(trim($_POST['title']));

	$subject = addslashes(trim($_POST['subject']));

	$message = addslashes(trim($_POST['message']));
	$user_type = addslashes(trim($_POST['user_type']));
	$msg = "";

	// save

	$sq_update = mysql_query("UPDATE ".NEWSLETTER." SET title = '".$title."',subject = '".$subject."',message = '".$message."',user_type = '".$user_type."' WHERE id = '".$_GET['id']."'");

	if($sq_update)

	{

		// set nessage and redirection

		$msg = "Updated Sucessfully";

		header("location:account.php?page=newsletter_list");

	}	

	else

	{

		$msg = "Updation Failed!";

	}

}

?>

<!-- title -->

<script type="text/javascript" src="js/datetimepicker.js"></script>

<script type="text/javascript">

function Validate()

{

var fn=document.partcat_form;

document.getElementById('error_div').innerHTML = '';

	if(fn.user_type.value == "")

	{

		document.getElementById('error_div').innerHTML='Select User Type';

		fn.user_type.focus();

		fn.user_type.style.borderColor='red';

		return false;

	}

	else

	{

		fn.user_type.style.borderColor='';

	}

if(fn.title.value == "")

	{

		document.getElementById('error_div').innerHTML='Enter Title';

		fn.title.focus();

		fn.title.style.borderColor='red';

		return false;

	}

	else

	{

		fn.title.style.borderColor='';

	}

	if(fn.subject.value == "")

	{

		document.getElementById('error_div').innerHTML='Enter Subject';

		fn.subject.focus();

		fn.subject.style.borderColor='red';

		return false;

	}

	else

	{

		fn.subject.style.borderColor='';

	}

}

</script>

<table width="100%" align="center" border="0" cellspacing="0" cellpadding="3" style="margin-bottom: 8px;">

  <tr>

    <td width="3%" class="app_title"><img src="images/edit_icon.jpg" width="28" height="28"></td>

    <td width="46%" class="app_title">Create News Letter </td>

    <td width="51%" align="right">	
    								
    <a href="account.php?page=newsletter_list">View All</a>
    
    </td>

  </tr>

</table>

<!-- message -->

<?php  if($msg <> "")  {  ?>

<table width="300" border="0" align="center" cellpadding="3" cellspacing="0" style="background-color: #FFFFCC; font-size: 10px; font-weight: bold; color: RED; text-align: center; margin-bottom: 5px; font-family: Verdana, Arial, Helvetica, sans-serif;">

  <tr>

    <td><?php echo $msg; ?></td>

  </tr>

</table>

<?php } ?>

<!-- app -->

<table width="100%" align="center" border="0" cellspacing="2" cellpadding="2">

	  <form action="" method="post" name="partcat_form" id="partcat_form" onSubmit="return Validate()">

	  <tr>

	  <td>&nbsp;</td>

	  <td><div id="error_div" style="color:#FF3F00;font-weight:bold"></div></td>

	  </tr>

        <tr>

          <td width="14%" align="right" bgcolor="#E8FFFF" style="padding-left: 4px;">User Type: </td>

          <td colspan="2" align="left" style="padding-left: 4px;">
		  <select name="user_type" id="user_type">
		  <option value=""  <?php if($user_type=="") { echo "selected='selected'"; } ?>>--- Select User Type ---</option>
		  <option value="Customer" <?php if($user_type=="Customer") { echo "selected='selected'"; } ?>>Customer</option>
		  <option value="Agent" <?php if($user_type=="Agent") { echo "selected='selected'"; } ?>>Agent</option>
		  <option value="Company" <?php if($user_type=="Company") { echo "selected='selected'"; } ?>>Company</option>
		  </select>
		  </td>

        </tr>
        <tr>

          <td width="14%" align="right" bgcolor="#E8FFFF" style="padding-left: 4px;">Admin Title: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="title" type="text" id="title" value="<?php echo $title; ?>" size="40" /></td>

        </tr>

		<tr>

          <td width="14%" align="right" bgcolor="#E8FFFF" style="padding-left: 4px;">Email Subject: </td>

          <td colspan="2" align="left" style="padding-left: 4px;"><input name="subject" type="text" id="subject" value="<?php echo $subject; ?>" size="40" /></td>

        </tr>

        <tr>

          <td align="right" valign="top" bgcolor="#E8FFFF" style="padding-left: 4px;">Details:</td>

          <td colspan="2" align="left" style="padding-left: 4px;"><?php

			include_once("editor/fckeditor.php");

			$oFCKeditor = new FCKeditor('message',320);

			$oFCKeditor->BasePath = 'editor/';

			$oFCKeditor->Config['EnterMode'] = 'br';

			$oFCKeditor->Value = $message;

			$oFCKeditor->Create(); 

			?></td>

        </tr>

        <tr>

          <td align="left" style="padding-left: 4px;">&nbsp;</td>

          <td colspan="2" align="left" style="padding-left: 4px;">
          
          <?php 
		  
		  if($_GET['id'] != "")
		  
		  {
			  
		  ?>
          
          <input name="update" type="submit" id="update" value="Update" />
          
          <?php
		  
		  }else{
			  
		  ?>
          
          <input name="save" type="submit" id="save" value="Create" />
          
          <?php } ?>        
          
          
          <input name="cancel" type="button" id="cancel" value="Cancel" onclick="location.href='account.php?page=newsletter_list'" />
          
          </td>

        </tr>

	  </form>

</table>

