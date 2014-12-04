<?php 
if($_GET['task']=="")
{		
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 25;//limit in each page
$startpoint = ($part * $perpage) - $perpage; 
	

?>
<script>
$(document).ready(function() {
$("a#viewtask").fancybox({
'zoomSpeedIn'           :    500,
'zoomSpeedOut'          :    500,
'frameWidth' : 400, 
'overlayShow'           :    true, 
'overlayOpacity' : 0.8,
'overlayColor' : '#000'
   });});
   </script>
<table width="693" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 8px; margin-top: 10px;">
    <tr>

      <td width="545" align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #F98923;"><strong>List/Manage Site Text </strong></td>
      <td width="148" align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;">
      
      <a href="account.php?page=site-text-list&task=add"><div class="actionBtn1" style="width:90px;">Add New Text</div></a>
      </td>

    </tr> 

  </table>
<table width="661" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="661" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>

    <td>
    <!-- users list -->
<form action="" method="post" name="chapter_fr" style="padding: 0px; margin: 0px;">
  
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
  <tr>
    <td style="border-top: 0px solid #99C; padding-left: 0px;">
    <table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr  bgcolor="#333333" style="color:#FFFFFF;">
	  <td width="22%" align="left"  style="padding-left: 5px;"><strong>Title</strong></td>
	   <td width="19%" align="center" >Site Title </td>
	   <td width="48%" align="center" ><strong>Body</strong></td>
       <td width="11%" align="center" ><strong>Action</strong></td>
      </tr>
       <?php 
		if(isset($_POST['search'])){
		$sq = "SELECT * FROM ".TBLPRE."site_text  where  (first_name LIKE '%".$_POST['sertxt']."%' OR last_name LIKE '%".$_POST['sertxt']."%' ) LIMIT ".$startpoint.",".$perpage;
		//echo $sq;
		}else{
		$sq = "SELECT * FROM ".TBLPRE."site_text  ORDER BY id LIMIT ".$startpoint.",".$perpage;
		}
		$rs = mysql_query($sq);
		if(mysql_num_rows($rs) > 0){
		if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$i=1;}else{$i=(15*($_GET["part"]-1))+1;}
		while($row=mysql_fetch_array($rs)){
		if($k%2!=0)
		 {
			 $bg="#F9F9F9";
		 }
		 else
		 {
			 $bg="#D5E9EA";
		 }
			  ?>
      <tr bgcolor="<?php echo $bg ; ?>">
        <td align="left"  bgcolor="<?php echo $bg ; ?>" style="padding-left: 5px;"><?php echo $row["title"]; ?></td>
		<td width="19%" align="center"  bgcolor="<?php echo $bg ; ?>"><?php echo $row["site_title"]; ?></td>
		<td width="48%" align="center"  bgcolor="<?php echo $bg ; ?>"> 
		<div style="display:none"><div id="data<?php echo $i;?>"><?php echo stripslashes($row['body']); ?> </div></div>
		 <a id="viewtask" href="#data<?php echo $i;?>"> <?php echo substr(strip_tags(stripslashes($row['body'])),0,50)."..."; ?> </a>       </td>
		<td width="11%" align="center"  bgcolor="<?php echo $bg ; ?>"> <a href="account.php?page=site-text-list&task=edit&id=<?php echo $row["id"];  ?>"><img src="images/edit.gif" alt="Edit" width="16" height="16" border="0" title="Edit" style="cursor: pointer;" /></a></td>
  </tr>
        <?php $k++;$i++;}}else{
			?>
            <tr>
        <td colspan="6" align="center"  bgcolor="<?php echo $bg ; ?>">No Record Listed</td>
		</tr>
            <?php
		}?>
 </table></td>
  </tr>
</table>

</form>
<!-- @end users list -->
  </td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td align="center" valign="top" style="padding-top: 10px;"><?php
			 if(isset($_POST['search'])){
				
				 echo Paging("".TBLPRE."site_text",$perpage,"account.php?page=site-text-list&"," (title LIKE '%".$_POST['sertxt']."%' OR body LIKE '%".$_POST['sertxt']."%')");
					
					} 
					else{
					echo Paging("".TBLPRE."site_text",$perpage,"account.php?page=site-text-list&");
					} 
			
			  ?></td>
  </tr>
  <!--<tr>
    <td align="left" valign="top" style="padding-top: 10px;">
	<span style="color:#FF0000">Note:-</span>Search can be posible by First Name , Last Name or Employee ID.
	</td>
  </tr>
  -->
</table>

<?php

}
// For add 0r edit 
if($_GET['task']=="add" or $_GET['task']=="edit")
{
if(isset($_POST['save']))
{
$title=$_POST['title'];	

$site_title=$_POST['site_title'];	
$body=addslashes($_POST['editor1']);
$title_ar=$_POST['title_ar'];	
$site_title_ar=$_POST['site_title_ar'];	
$body_ar=addslashes($_POST['editor1_ar']);

 $sql="insert into ".TBLPRE."site_text set title='$title',site_title='$site_title',body='$body',title_ar='$title_ar',site_title_ar='$site_title_ar',body_ar='$body_ar'";

$res=mysql_query($sql) or die(mysql_error());

if($res){
	echo "<script>alert('Record Added Successfully');location.href='account.php?page=site-text-list';</script>";
}
}


$mngr=get_values(TBLPRE."site_text",$_GET['id']);

if(isset($_POST['update']))
{
$title=$_POST['title'];	
$site_title=$_POST['site_title'];	

$body=addslashes($_POST['editor1']);

$title_ar=$_POST['title_ar'];	
$site_title_ar=$_POST['site_title_ar'];	
$body_ar=addslashes($_POST['editor1_ar']);


 $sql="update ".TBLPRE."site_text set title='$title',site_title='$site_title',body='$body',title_ar='$title_ar',site_title_ar='$site_title_ar',body_ar='$body_ar' where id='".$_GET['id']."'";

$res=mysql_query($sql) or die(mysql_error());

if($res){
	echo "<script>alert('Record Updated Successfully');location.href='account.php?page=site-text-list';</script>";
}
}



?>

<script language="javascript">

$(function(){
setTimeout(loadEditor(),1000);

});	

 function loadEditor() {
    var $editors = $("#editor1");
    if ($editors.length) {
        $editors.each(function() {
            var editorID = $(this).attr("id");
            var instance = CKEDITOR.instances[editorID];
            if (instance) { instance.destroy(true); }
            CKEDITOR.replace(editorID);
        });
    }
	$("td").click();
}

function velidetion()
{
	var code=document.form1;
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

	if(code.title.value=="")
	{
		alert("Please enter Title !");
		code.title.focus();
		return false ;
	}
	if(CKEDITOR.instances.editor1.getData()=='')
	{
	alert("Please enter body text.");
	CKEDITOR.instances.editor1.focus();
	return false;
	}
}

</script>
<table width="690" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 8px; margin-top: 10px;">
    <tr>
        <td width="356" align="left" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #F98923;"><strong>Add Small Text</strong></td>
        <td width="357" align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #F98923;">  <a href="account.php?page=site-text-list"><div class="actionBtn1" style="width:50px;">View All</div></a></td>
        <td width="1" align="right" style="border-bottom: 1px solid #CCC; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>
     </strong></tr>
<tr><td colspan="3">
<form action="" method="post" name="form1" onsubmit="return  velidetion()">
<table width="99%" border="0" cellspacing="0" cellpadding="4" align="center">

  <tr>
    <td align="left">Title (En):      </td>
    <td width="84%" align="left"><input name="title" type="text" id="title" style="width:400px;" class="generalTextBox" value="<?php echo $mngr->title; ?>" /></td>
  </tr>
   <tr>
    <td align="left">Title (Ar):       </td>
    <td width="84%" align="left"><input name="title_ar" class="generalTextBox" type="text" id="title_ar" style="width:400px;" value="<?php echo $mngr->title_ar; ?>" /></td>
  </tr>
	<tr>
    <td align="left">Site Title (En):</td>
    <td align="left"><input name="site_title" class="generalTextBox" type="text" id="site_title" style="width:400px;" value="<?php echo $mngr->site_title; ?>" /></td>
	</tr>
    
    <tr>
    <td align="left">Site Title (Ar):</td>
    <td align="left"><input name="site_title_ar" class="generalTextBox" type="text" id="site_title_ar" style="width:400px;" value="<?php echo $mngr->site_title_ar; ?>" /></td>
	</tr>
  <tr>
    <td align="left" style='font-size:14px;' colspan="2">Body Text (En)</td>
    <td width="1%">    </td>
  </tr>
  <tr>
   <td colspan="2"> 
       
<?php
	include_once("editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('editor1',220,'90%');
	$oFCKeditor->BasePath = 'editor/';
    $oFCKeditor->ToolbarSet = "Normal";
	$oFCKeditor->Config['EnterMode'] = 'br';
	$oFCKeditor->Value = stripslashes($mngr->body);
	$oFCKeditor->Create(); 
	?>            		</td>
  </tr>
  <tr>
    <td align="left" style='font-size:14px;' colspan="2">Body Text (Ar)</td>
    <td width="1%">    </td>
  </tr>
  <tr>
   <td colspan="2"> 
       
<?php
	include_once("editor/fckeditor.php");
	$oFCKeditor = new FCKeditor('editor1_ar',220,'90%');
	$oFCKeditor->BasePath = 'editor/';
    $oFCKeditor->ToolbarSet = "Normal";
	$oFCKeditor->Config['EnterMode'] = 'br';
	$oFCKeditor->Value = stripslashes($mngr->body_ar);
	$oFCKeditor->Create(); 
	?>            		</td>
  </tr>
  
  <tr>
    <td width="15%"><?php if($_GET['id']!=''){?>
   <input type="submit" name="update" class="actionBtn required" value="Update" /><?php } else{ ?>
   <input type="submit" name="save" class="actionBtn required" value="Save" /><?php } ?>  </tr>
</table>
</form></td>
</tr></table></span></span>

<?php } ?>