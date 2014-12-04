<?php
if(isset($_POST['subm']))
{
	
	$fblink=$_POST['fblink'];
		$lilink=$_POST['lilink'];
			$twlink=$_POST['twlink'];
	
$res=mysql_query("update ".SOCIALLINKSTBL." set fb_link='".$_POST['fb_link']."',li_link='".$_POST['li_link']."',tw_link='".$_POST['tw_link']."', message = '".$_POST['message']."', rss = '".$_POST['rss']."'  where id=1");	

if($res)
{
	$msg="<span style='color:green'>Social Links Updated</span>";
	
}
}

$lis=mysql_fetch_object(mysql_query("select * from ".SOCIALLINKSTBL." where id=1"));
?>



<form id="sociallinks_fr" name="sociallinks_fr" method="post" action="" style="padding:0px; margin:0px;" onsubmit="return valid()">
                     <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
                       <tr>
                         <td width="73%" align="left" valign="top" style="border-bottom:1px dashed #6699CC"><h2 class="titletext" style="font-weight: normal;">Manage Social Links</h2></td>
                         <td width="27%" align="left" valign="top" style="border-bottom:1px dashed #6699CC">&nbsp;</td>
                       </tr>
					    <tr>
                               <td colspan="3" align="right" style="color: #066; font-size: 11px; padding: 0px;"><?php
if($msg <> ""){
?>
<div style="border: 1px solid #990; background-color: #FFC; padding: 2px; font-weight: bold; margin-top: 5px; margin-bottom: 5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="7%"><img src="images/warning.png" width="32" height="32"></td>
<td width="93%"><?php echo $msg; ?></td>
</tr>
</table>
</div>
<?php } ?></td>
                             </tr>
                       <tr>
                         <td colspan="2" align="left" valign="top">
						 
						 <table width="100%" border="0" cellspacing="2" cellpadding="2">


        <tr>

          <td align="right" bgcolor="#FFFFFF" style="padding-left: 4px;">&nbsp;</td>

          <td width="42%" align="left" style="padding-left: 4px;"><div id="web_error" style="color:#FF3F00;font-weight:bold"></div></td>
          <td width="40%" align="left" style="padding-left: 4px;color:#036">&nbsp;</td>
        </tr>

        <tr>

          <td width="18%" align="right" valign="top" style="padding-left: 4px;">Facebook Link: </td>
<td align="left" style="padding-left: 4px;"><input type="text" name="fb_link" id="fb_link" size="40" value="<?php echo $lis->fb_link; ?>" /></td>
          <td align="left" style="padding-left: 4px;">&nbsp;</td>
        </tr>
        
         <tr>

          <td width="18%" align="right" valign="top" style="padding-left: 4px;">Linkedin Link: </td>

          <td align="left" style="padding-left: 4px;">
          <input type="text" name="li_link" value="<?php echo $lis->li_link; ?>" id="li_link"  size="40" />          </td>
          <td align="left" style="padding-left: 4px;">&nbsp;</td>
         </tr>
        
         <tr>

          <td width="18%" align="right" valign="top" style="padding-left: 4px;">Twitter Link: </td>

          <td align="left" style="padding-left: 4px;">
          <input type="text" name="tw_link" value="<?php echo $lis->tw_link; ?>" id="tw_link" size="40" />          </td>
          <td align="left" style="padding-left: 4px;">&nbsp;</td>
         </tr>
        
		
		<tr>

          <td width="18%" align="right" valign="top" style="padding-left: 4px;">Email Link: </td>

          <td align="left" style="padding-left: 4px;">
          <input type="text" name="message" value="<?php echo $lis->message; ?>" id="tw_link" size="40" />          </td>
          <td align="left" style="padding-left: 4px;">&nbsp;</td>
         </tr>
		 
		 
		 <tr>

          <td width="18%" align="right" valign="top" style="padding-left: 4px;">RSS Link: </td>

          <td align="left" style="padding-left: 4px;">
          <input type="text" name="rss" value="<?php echo $lis->rss; ?>" id="tw_link" size="40" />          </td>
          <td align="left" style="padding-left: 4px;">&nbsp;</td>
         </tr>

        <tr>

          <td height="54" align="left" style="padding-left: 4px;">&nbsp;</td>

          <td colspan="2" align="left" style="padding-left: 4px;">

           <input type="submit" name="subm" value="Update" class="actionBtn" />      </td>
        </tr>
</table></td>
                       </tr>
                     </table>
</form>
