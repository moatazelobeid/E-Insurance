<?php
if($_GET['id'] != "" && $_GET['task'] == "delete")
{   
	  mysql_query("delete from ".NEWSSUBSCRIBER."   WHERE id = '".$_GET['id']."'");
	
	if(mysql_affected_rows() > 0)
	echo "<script>alert('Record Deleted Sucessfully');location.href='account.php?page=newsletter_subscriber';</script>";
	else
	echo "<script>alert('Record Deletion Failed');location.href='account.php?page=newsletter_subscriber';</script>";
	
}



$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage;
?>

<div style="width: 100%; margin: 0 auto; margin-top: 25px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
      <td align="left" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036;"><strong>Manage Newsletter Subscribers<br/>
      </strong></td>
      <td align="right" style="border-bottom: 1px solid #99C; padding-bottom: 5px; padding-left: 0px; font-size: 10px; color: #339;"><a href="account.php?page=newsletter_list">Manage Newsletter</a></td>
    </tr>
  </table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border-top: 1px solid #99C; padding-left: 0px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr style="color: #FFF;">
        <td align="center" bgcolor="#333333"><strong>SL#</strong></td>
        <td align="center" bgcolor="#333333"><strong>Email</strong></td>
        <td align="center" bgcolor="#333333"><strong>Action</strong></td>
      </tr>
      <?php
		$j = 0;
		$sq = mysql_query("select * from ".NEWSSUBSCRIBER."  ORDER BY id DESC");
	  	if(mysql_num_rows($sq) > 0){
		if(($_GET["part"]==1) || ($_GET["part"]=='')){
		$j=0;}else{$j=(15*($_GET["part"]-1));}
	  	while($res = mysql_fetch_array($sq)){
		$j++;
		$bgcolor = ($j%2 == 0)?'bgcolor="#F9F9F9"':'bgcolor="#F2FBFF"';
	  ?>
      <tr <?php echo $bgcolor; ?>>
        <td align="center"><strong><?php echo $j; ?></strong></td>
        <td align="center"><?php echo $res["email_id"]; ?></td>
        <td align="center">
        <a href="account.php?page=newsletter_subscriber&task=delete&id=<?php echo $res['id']; ?>" onclick="return confirm('Are you sure to delete!');"><img src="images/delete.png" alt="Delete" width="16" height="16" border="0" title="Delete" style="cursor: pointer;"></a></td>
        </tr>
      <?php
	  }}else{
		  ?>
          <tr>
        <td colspan="5" align="center" bgcolor="#F2FBFF">No Record Found</td>
        </tr>
          <?php
	  }
	  ?>
      <tr>
      	<td colspan="5" align="center">
		<?php 
		//echo Paging(ESCORT,$perpage,"account.php?page=newsletter_subscriber&");
		?>
        </td>
       </tr>
    </table></td>
  </tr>
</table>
</div>

<!--another--><!--agency-->