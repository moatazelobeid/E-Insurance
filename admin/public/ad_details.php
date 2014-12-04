<?php 
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");
include_once("../../classes/dbFactory.php");
include_once("../../paging/pagination.php");
if(siteAuth($_SESSION['atype']) == 2){
	header("location:index.php?log=1");
}
$id=$_GET["id"];
$sq = mysql_query("select * from ".ADVERTISEMENT." WHERE id='".$id."'");
$smq=mysql_fetch_array($sq);

//$sq = mysql_query("select * from ".LOGINTBL." WHERE uid='".$id."' AND user_type = 'C'");
//$smq1=mysql_fetch_array($sq);
?>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">

<tr>
		<td style="padding: 5px;">
          	<table width="70%" border="0" cellspacing="0" cellpadding="2">
          		<tr>
					
		<td align="left">
<?php  if($smq["type"]=='Image'){ ?>
		<img src='<?php if($smq["image_url"]!= ''){ echo $smq["image_url"];}else {echo "no-image.jpg";} ?>' height="300" width="300"  />
		<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
    <tr>
    	<td width="36%" align="left" style="border-bottom: 0px solid #99C; padding: 3px;"><strong>Img URL:</strong>		</td>
		<td width="64%"><?php echo $smq["url"]; ?></td>
    </tr>
  </table>
	<?php	}
		else
		{
		echo stripslashes($smq["script"]);}?>
		
		</td>
				</tr>
				
          	</table>
	
		
