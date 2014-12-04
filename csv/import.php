<?php
if(isset($_POST['submit']))
{

	// get csv
	if($_FILES['csvfile']['name'] != "")
	{  
		// check file type
		$ffile=str_replace(" ","_",$_FILES['csvfile']['name']);
		$file = basename($_FILES['csvfile']['name']);
		$type = substr($file,strlen($file)-3,strlen($file));
		$target_dir="csvfile/".$ffile;
		if($type == "csv")
		{ 
		 if(move_uploaded_file($_FILES['csvfile']['tmp_name'], $target_dir)==true){ 
			// import
			$row = 1;
			if (($handle = fopen("csvfile/".$ffile, "r")) !== FALSE) 
			{
			    
			   
				 $abc=0;
			     $xyz=0;
				 $zz=1;
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
				{
				
					$num = count($data);
					$row++;
					//print_r($data);
					// create table
					if($row <= 2)
					{
						// check table
						/*$sqchk = mysql_query("SELECT COUNT(*) AS record FROM information_schema.tables WHERE table_schema = 'library' AND table_name = 'import'");
						if(mysql_fetch_object($sqchk)->record == 0)
						{
							// create table
							foreach($data as $val)
							{
								$fields .= '$val'.",";
								$fields = substr($fields,0,strlen($fields)-1);
							}
							mysql_query("");
						}*/
						continue;
					}
					else
					{   
						$i = 0;
						foreach($data as $val)
						{
							$i++;
							if($i == 1)
							{
								continue;
							}
							else
							{
							if($i==2){
							$vale=str_replace("'","",$val);
							$uid=$val;
							}if($i==3){
							$points=$val;
							}if($i==4){
							$mid=$val;
							}if($i==5){
						    $pdate=$val;
							}if($i==6){
							$edate=$val;
							}
							//$fields .= "'".$vale."'".",";
							}
						}
						 $fields = substr($fields,0,strlen($fields)-1);
						// insert record


  // $sql="insert into redeem_user_points (user_id,group_id,points,method_earned_id,point_date,exp_date,import_date) values($fields,curdate())";
  if(is_numeric($points)){
  $query12="select * from redeem_method_earned where id = '$mid'";
  $sadd2=$db->query($query12);
  if($db->num_rows($sadd2)> 0){
  $query123="select * from redeem_user_profile where user_id = '$uid'";
  $sadd=$db->query($query123);
  $objj=$db->fetch_object($sadd);
  $gid=$objj->user_group_id;
  if($db->num_rows($sadd)> 0){
  $sql="insert into redeem_user_points (user_id,group_id,points,method_earned_id,point_date,exp_date,import_date) values('$uid','$gid','$points','$mid','$pdate','$edate',curdate())";
  mysql_query($sql)or die(mysql_error());
 
  $abc = $abc + 1;
  }else{
  $xyz = $xyz + 1;
  $errors .= $xyz."> (Record No. ".$zz.") Acc # :".$uid." => not a valid Account..<br/>";

}}else{
  $xyz = $xyz + 1;
  $errors .= $xyz."> (Record No. ".$zz.") Method Earned id # :".$mid." => not a valid method earned ID. <br/>";
  }}else{
   $xyz = $xyz + 1;
  $errors .= $xyz."> (Record No. ".$zz.") Points : ".$points." => not a valid Point to Add. <br/>";
  
  }
			 
						
						$fields="";
						
						//if(mysql_affected_rows()>0){
						//echo "successfully saved...";
						//}else{
						//echo "can't saved at this time..";
						//}
						/*for ($c=0; $c < $num; $c++) 
						{
								// insert
								echo $data[$c] . "<br />\n";
						}*/
					}
					$zz++;
				
				
				
				
				}
				if($xyz==0){$error1="<font color='green'>No Errors Occured..!!</font>";}else{$error1="Following Errors Occured :<br/>".$errors;}
				$msg = "Total Records: ".$num."<br/>successfull : ".$abc."<br/>Failed : ".$xyz."<br/>".$error1;
				fclose($handle);
				//creating a txt file..............
				$path="error_logs/";
			   $myFile = $path.time()."Error_log.txt";
               $fh = fopen($myFile, 'w') or die("can't open file");
               $ccv=explode("<br/>",$msg);
			   $count=count($ccv);
			   for($p=0;$p < $count;$p++)
			   {
			     $stringData .= $ccv[$p].PHP_EOL;
			   }
	
               fwrite($fh, $stringData);
               fclose($fh);
			   $msg2= "<a href='download.php?f=error_logs/".$myFile."' target='_blank'>Download .txt file</a></script>";

				
				$qrr="select user_id from redeem_user_profile where status= '1'";
				$sss=$db->query($qrr);
				while($arr=$db->fetch_assoc($sss)){
				$rrr="select * from redeem_user_points where user_id = '".$arr['user_id']."'";
				$jj=$db->query($rrr);
				if($db->num_rows($jj)>0){
				$x=0;
				while($tt=$db->fetch_assoc($jj)){
				$x=$x+$tt['points'];
				$updd="update redeem_user_total_points set total_points = '$x',point_date = now() where user_id = '".$tt['user_id']."'";
				$db->query($updd);
				
				}
            
				}
				}
			    $qrr="select user_id from redeem_user_profile where status= '1'";
				$sss=$db->query($qrr);
				while($arr=$db->fetch_assoc($sss)){
				$rrr="select * from redeem_redeem_points where user_id = '".$arr['user_id']."'";
				$jj=$db->query($rrr);
				if($db->num_rows($jj)>0){
				$y=0;
				while($tt=$db->fetch_assoc($jj)){
				$y=$y+$tt['points'];
		        }
			
			 $updd="update redeem_user_total_points set total_points = total_points - '$y',point_date = now() where user_id = '".$arr['user_id']."'";
				 $db->query($updd);
                  
				}
				
				}
				
			
			
			}
			// end import
		}unlink($target_dir);
	}else{
	$msg2="Upload Propper CSV file.";
	}
	
	}

}

?>
<form name="form1" id="form1" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3" style="margin-bottom: 8px;">
  <tr>
    <td width="3%" class="app_title"><img src="images/edit_icon.jpg" width="28" height="28"></td>
    <td width="46%" class="app_title">Import CSV </td>
    <td width="51%" align="right"><a href="<?php echo __ADMIN_HOME; ?>?menu=manageuser_points"><strong><< Back</strong></a></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
    <td width="43%" align="right">&nbsp;</td>
    <td width="57%" align="left"><div id="access_div" style="color:#FF0000;font-weight:bold;"><strong><?php echo $msg2;?></strong></div></td>
  </tr>
  <?php if($_REQUEST['mode']=='edit'){$qerr="select * from glimmer_price where price_id='".$_REQUEST['id']."'";
	$rese=$db->query($qerr);
	$obbh=$db->fetch_object($rese);
	$catagory_id= $obbh->catagory_id;
	$price=$obbh->price;
	$product_id=$obbh->product_id;
	}
	?>
<tr>
  <td width="43%" align="right"><span style="color:#2A1FAA;font-weight:bold">Upload CSV :</span></td>
  <td width="57%" align="left"><input type="file" name="csvfile"  />&nbsp;</td>
</tr>


<tr>  
<td width="43%" align="right"><span style="color:#2A1FAA; font-size:14px;font-weight:bold"></span></td>
<td width="57%" align="left"><input type="submit" name="submit" id="submit" value="<?php if($_REQUEST['mode']=='edit'){echo "Update";}else{echo "Save";}?>" onclick="return validate();"/></td>
   
  </tr>
    
  <tr><td colspan="2" align="left" style="color:#FF0000;font-weight:600;font-size:12px;"><?php echo $msg;?></td></tr>
</table>

</form>
