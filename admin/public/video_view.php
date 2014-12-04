<?php
include_once("../../config/session.php");
include_once("../../config/config.php");
include_once("../../config/tables.php");
include_once("../../config/functions.php");
include_once("../../classes/dbFactory.php");
$id=$_GET['id'];
if(siteAuth($_SESSION['atype']) == 2){
	header("location:index.php?log=1");
}
$query=mysql_query("SELECT * FROM ".MEDIATBL." WHERE id='$id'");
$row=mysql_fetch_array($query);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>jqmedia/jquery.metadata.js"></script> 
<script type="text/javascript" src="<?php echo BASE_URL;?>jqmedia/jquery.usermedia.js"></script> 
<script type="text/javascript" src="<?php echo BASE_URL;?>jqmedia/swfobject.js"></script>

<script type="text/javascript">

window.load = loadScript();
function loadScript(){

$('a.media').media();

}

   /* $(document).ready(function() {
        $('a.media').media();
    });*/
</script>
<table width="61%" height="161" border="0" align="left" cellpadding="0" cellspacing="8px;">
<?php if($row['type']=='Script'){?>
<tr><td><?php echo stripslashes($row['script']);?></td></tr>
<?php }else if($row['type']=='File'){?>
<tr><td>

<a class="media {width:540, height:320}" href="<?php echo SITE_URL.'upload/video/'.stripslashes($row['video_file']); ?>"></a>
</td></tr>	
	<?php }?>
</table>



