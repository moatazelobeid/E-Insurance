<script type="text/javascript">

function checkall(str,str1)

{    

	var objCheckBoxes = document.forms[str].elements[str1];

	var countCheckBoxes = objCheckBoxes.length;
	

	// set the check value for all check boxes

	for(var i = 0; i < countCheckBoxes; i++)

	objCheckBoxes[i].checked = true;

}

function uncheckall(str,str1)

{

	var objCheckBoxes = document.forms[str].elements[str1];

	var countCheckBoxes = objCheckBoxes.length;
	

	// set the check value for all check boxes

	for(var i = 0; i < countCheckBoxes; i++)

	objCheckBoxes[i].checked = false;

}

function confirmInput()
 {
  var retVal = confirm("Do you want to Delete these News Letter ?");
   if( retVal == true ){
      
	   document.getElementById('task').value = 'del';document.page_list_form.submit();
	  return true;
   }else{
      
	  return false;
	
   }
 }
</script>



<?php

if($_GET['task']=='delete')

{ 

 $sqql2 = mysql_query("delete from ".NEWSLETTER." where id ='".$_GET['id']."'");

 if(mysql_affected_rows())

   {

       $msg="Successfully  Deleted ..!!";

   }

}

// delete record

if($_POST['chat_chk'] != "" && is_array($_POST['chat_chk']))

{

   if($_POST['task'] == "del")

	{

		$countDel = 0;

		foreach($_POST['chat_chk'] as $val)

		{

			// unblock

			$sq_del = "delete from ".NEWSLETTER." WHERE id = '".$val."'";

			$res = mysql_query($sq_del);

			if(mysql_affected_rows() > 0)

			{

				$countDel++;

			}

		}

		if($countDel > 0)

		$msg = "Total Selected <i><u>".count($_POST['chat_chk'])."</u></i> and Deleted <i><u>".$countDel."</u></i>";

		else

		$msg = "Total Selected <i><u>".count($_POST['chat_chk'])."</u></i> and Deleted nothing";

	}

}

$page = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);

$page = ($page == 0 ? 1 : $page);

$perpage = 25;//limit in each page

$startpoint = ($page * $perpage) - $perpage; 

if(isset($_POST["search"])){
		  $j = 0;
	 $ssql = mysql_query("SELECT * FROM ".NEWSLETTER." WHERE title like '%".$_POST["searchTxt"]."%' ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	  }
	  else{
		  $j = 0;
		  $ssql = mysql_query("SELECT * FROM ".NEWSLETTER." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
	  }

/*if($_POST['searchTxt']!=''){


$ssql=mysql_query("select * from ".NEWSLETTER." where title LIKE '%".$_POST['searchTxt']."%' order by id desc LIMIT $startpoint,$perpage"); 


}

else{

$ssql= mysql_query("select * from ".NEWSLETTER." LIMIT $startpoint,$perpage");

}
*/
?>

<!-- title -->

<table width="100%" align="center" border="0" cellspacing="0" cellpadding="3" style="margin-bottom: 8px;">

  <tr>

    <td width="3%" class="app_title"><img src="images/edit_icon.jpg" width="28" height="28"></td>

    <td width="46%" class="app_title">News Letter</td>

    <td width="51%" align="right">&nbsp; </td>

  </tr>
  <tr><td colspan="3" align="right"> <a href="account.php?page=newsletter_post">Send Newsletter</a>&nbsp;|  <a href="account.php?page=newsletter_create">Add News Letter</a> &nbsp;|
    
    <a href="account.php?page=newsletter_subscriber">Newsletter Subscribers</a>
	
<!--	&nbsp;|<a href="account.php?page=newsletter_catalog">Catalog Subscribers</a>
-->	</td></tr>

</table>

<?php

if($msg <> ""){

?>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="background-color: #FFFFCC; font-size: 10px; font-weight: bold; color: RED; text-align: center; margin-bottom: 5px; font-family: Verdana, Arial, Helvetica, sans-serif;">

  <tr>

    <td><?php echo $msg; ?></td>

  </tr>

</table>

<?php } ?>

<form name="searchForm" id="searchForm" method="post" action="">

<table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">

  <tr>

    <td width="201"><a  href="#" title="Delete is disabled" onClick="confirmInput();">Delete</a></td>

    <td width="562" align="right">Search Title: 

      <input name="searchTxt" type="text" id="searchTxt" size="18" value="<?php echo $_POST['searchTxt']; ?>"></td>

    <td width="177" align="right"><input type="submit" name="search" id="search" value=" Search " class="actionBtn" />&nbsp;&nbsp;<a href="account.php?page=newsletter_list"><span style="color:#FFFFFF" class="actionBtn">Reset</span></a></td>
  </tr>
</table>

</form>



<form action="" method="post" name="page_list_form">

<table width="100%" align="center" cellpadding="2" cellspacing="1" style="background-color: #FFFFFF;">

<tr bgcolor="#D9D9FF">

<td width="3%" align="center" bgcolor="#333333">

  <input type="checkbox" name="checkbox" class="checkbox" onclick="if(this.checked == true){checkall('page_list_form','chat_chk[]');}else{uncheckall('page_list_form','chat_chk[]');}"/></td>

<td width="3%" align="center" bgcolor="#333333"><span style="color:#FFFFFF;font-weight:bold">SL#</span></td>

<td width="12%" align="center" bgcolor="#333333" ><span style="color:#FFFFFF;font-weight:bold">Title</span></td>
<td width="13%" align="center" bgcolor="#333333" ><span style="color:#FFFFFF;font-weight:bold">User Type</span> </td>
<td width="13%" align="center" bgcolor="#333333" ><span style="color:#FFFFFF;font-weight:bold">Created On</span></td>

<td width="14%" align="center" bgcolor="#333333"><span style="color:#FFFFFF;font-weight:bold">Status</span></td>

<td width="16%" align="center" bgcolor="#333333"><span style="color:#FFFFFF;font-weight:bold">Published On</span></td>

<td width="9%" align="center" bgcolor="#333333"><span style="color:#FFFFFF;font-weight:bold">Action</span></td>
</tr>

<?php

      $slno=1;
	   if(($_GET["part"]==1) || ($_GET["part"]=='')){
		  $slno=1;}else{$slno=(25*($_GET["part"]-1))+1;}

	  $num=mysql_num_rows($ssql);

	  if($num>0){

	  while($arr = mysql_fetch_assoc($ssql)){
	  

	  $bgcolour=($bgcolour=='#FFFFFF')?'#E8FFFF':'#FFFFFF';

?>

<tr bgcolor="<?php echo $bgcolour;?>">

<td align="center"><input type="checkbox" name="chat_chk[]" value="<?php echo $arr['id']; ?>"/></td>

<td align="center"><span style="color:#2A3F55;"><?php echo $slno; ?></span></td>

<td><span style="color:#2A3F55;"><?php echo $arr['title'];?></span></td>
<td align="center"><span style="color:#2A3F55;"><?php echo $arr['user_type'];?></span></td>
<td align="center"><span style="color:#2A3F55;"><?php echo date('jS-M-Y',strtotime($arr['created_date']));?></span></td>

<td align="center"><?php if($arr['publish_number']=='0'){?><span style="color:#FF1F00;font-weight:bold;"><?php echo "Not Published";?></span><?php }else{?> <span style="color:#009F55;font-weight:bold;"><?php echo "Published(".$arr['publish_number'].")";}?></span></td>

<td align="center"><span style="color:#2A3F55;"><?php if($arr['publish_date'] && $arr['is_publish']==0) echo "-"; else echo date('jS-M-Y',strtotime($arr['publish_date']));?></span></td> 

<td align="center">

<a href="account.php?page=newsletter_create&task=edit&id=<?php echo $arr['id']; ?>" title="Edit"><img src="images/edit.gif" border="0" title="Edit" alt="Edit"/></a>&nbsp;
<a href="account.php?page=newsletter_list&task=delete&id=<?php echo $arr['id'];?>" onClick="return confirm('Are you sure to delete this News Letter?');" 
title="Delete"><img src="images/delete.png" border="0" title="Delete" alt="Delete" /></a></td>
</tr>
<?php $slno=$slno+1; } ?>
<tr>

  <td colspan="8" align="left"  style="padding: 5px;"><font color="#FF0000">Note:Search can possible only for Title .</font></td>
</tr>
<?php }else{?>

<tr>

  <td colspan="8" align="center" bgcolor="#FFFFCC" style="padding: 5px;"><span style="color:#FF1F55;">No News Letters Listed</span></td>
</tr><?php }?>

<input type="hidden" name="task" id="task" value="search">
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr><td align="center">&nbsp;</td>
</tr>
  <tr>

 <?php 
 
 if($_POST['searchTxt']!=''){

 $cond="title LIKE '%".$_POST['searchTxt']."%' order by id desc";

 }else{

 $cond="";

 }  

 ?>

 <td align="center"><?php echo paging(NEWSLETTER,$perpage,"account.php?page=newsletter_list&",$cond); ?></td>

 </tr>

 </table>


</form>