<?php
$part = (int) (!isset($_GET["part"]) ? 1 : $_GET["part"]);
$part = ($part == 0 ? 1 : $part);
$perpage = 15;//limit in each page
$startpoint = ($part * $perpage) - $perpage;
 $udata=mysql_fetch_assoc(mysql_query("select * from ksa_user where id='".$_SESSION['uid']."'  "));

?>
<?php 
	if(empty($_SESSION['uid']))
	{
		header("location:index.php?page=sign-in");
	}else{
		
		
?>
<div class="innrebodypanel">
			<div class="clearfix" style="height:15px;"></div>
				<div class="innerwrap">
					<div class="breadcrumb">
						<a itemprop="url" href="<?=BASE_URL?>">Home</a> 
						<span class="breeadset">&#8250;</span>
						<a itemprop="url" href="index.php?page=user-dashboard">Dashboard</a> 
						<span class="breeadset">&#8250;</span>
						<strong>Claim List</strong>
					</div>
					
					<?php include_once('includes/dashboard-sidebar.php'); ?>					
					<div class="lg-6">
						<div class="rightformpan innerTFl">
                        	<h1>Claim List</h1>
							<form action="" method="post" name="subject_fr" style="padding: 0px; margin: 0px;">	
                            <?php if(isset($_GET['claimed'])){?>
                            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 5px; background-color: #F1F8E9; line-height: 15px; color: #666;">
                              <tr>
                                <td width="2%"><img src="<?php echo IMG_PATH; ?>correct.gif" width="24" height="24" /></td>
                                <td width="98%"><?php echo 'You have sucessfully claimed a policy'; ?></td>
                              </tr>
                            </table>
                            <?php } ?>
								<table  style="width:280px;font-size:13px; float:right;" border="0" cellspacing="0" cellpadding="0" >
								  <tbody>
									<tr>
                                    <td>Search :</td>
                                    <td><input name="sertxt"  type="text" class="generalTextBox" placeholder="Policy id or Claim No" id="sertxt" style="width: 120px;" value="<?=$_POST['sertxt']?>"></td>
                                    <td><input type="submit" name="search" id="search" class="sub_btn actionBtn" value="Search" style="position: relative;bottom: 4px;height: 33px;"></td>
                                  </tr>
                                  
									
								  </tbody>
								</table>
								
								<div class="clearfix" style="height:12px;"></div>
                            
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="policytab">
								  
								  <tbody>
									<tr>
									  <td>
									  	 <table width="100%" border="0" cellspacing="1" cellpadding="1">
											<tbody>
												<tr style="background-color:green; color:#FFF;">
													<td width="5%" align="center"><strong>SL#</strong></td>
													<td width="13%" align="center"><strong>Claim Number</strong></td>
                                                    <td width="14%" align="center"><strong>Policy Number</strong></td>
													<td width="25%" align="left"><strong>Policy Name</strong></td>
													<td width="12%" align="center"><strong>Status</strong></td>
													<td width="13%" align="center"><strong>Claimed On</strong></td>
													<td width="18%" align="center"><strong>Action</strong></td>
												</tr>
												  <?php
													   $whr="";
													   $pwhr="";
													   if(isset($_POST['search']))
													   {
														   $whr[] = "customer_id = '".$udata['customer_code']."'";
 															if(isset($_POST['sertxt']))
															{
															
																$whr[]="(policy_no like '%".$_POST['sertxt']."%' or claim_no like '%".$_POST['sertxt']."%' )";
															}
															if(!empty($whr))
															{
																$where=" where ".implode(" AND ",$whr);
																$pwhr=implode(" AND ",$whr);
															}
															
														  $rs=  mysql_query("SELECT * FROM ".CLAIMMOTOR.$where." ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
													   }else{
														   $rs=mysql_query("SELECT * FROM ".CLAIMMOTOR." where customer_id = '".$udata['customer_code']."' ORDER BY id DESC LIMIT ".$startpoint.",".$perpage);
													   }
												 if(mysql_num_rows($rs) > 0)
												   {
														$i=0;
														if(($_GET["part"]==1) || ($_GET["part"]=='')){$i=1;}else{$i=(15*($_GET["part"]-1))+1;}
														while($row=mysql_fetch_array($rs)){
														$bgcolor = ($i%2 == 0)?'bgcolor="#F2F2F2"':'bgcolor=""';
														
														// Get Policy Details
														$policy_deatil = $db->recordFetch($row["policy_no"],POLICYMASTER.":".'policy_no');
														
												  ?>
                                                
												<tr bgcolor="#fff">
													<td align="center"><?=$i?></td>
													<td align="center"><a href="index.php?page=claim-details&id=<?=$row["id"]?>"><?php echo $row["claim_no"]; ?></a></td>
                                                    <td align="center"><a href="index.php?page=claim-details&id=<?=$row["id"]?>"><?php echo $row["policy_no"]; ?></a></td>
													<td><?php
														$policy_class_title = get_value('title',constant('POLICIES'),$policy_deatil["policy_class_id"],'id');
														$ptype_title = get_value('policy_type',constant('POLICYTYPES'),$policy_deatil["policy_type_id"],'id');
														echo stripslashes($policy_class_title).' ('.stripslashes($ptype_title).')';
														?></td>
                                                    <td><?php if($row["status"] == 0){echo 'Open';}else if($row["status"] == 1){echo 'On Progress';}else if($row["status"] == 2){echo 'Closed';}?></td>
													<td><?php echo date('d/m/y',strtotime($row["created_date"])); ?></td>
													<td><a href="#" class="claimpopup"><?=(!empty($row["admin_reply"]))?'Replied':'Not Replied'?></a></td>
													
													<!--<div id="login-box" class="claimpanel">
														<a href="#login-box" class="close">X</a>
														  <form method="" class="signin" action="">
																<div>
																	<h1>Action Details</h1>
																	<div height="20" colspan="5" class="poptext">
																		<strong>Policy Holder's detail</strong>
																		<br />
																		<strong>Date of Claim : </strong> 31-12-1969 <br />
																		<strong>Claim Place : </strong> Foierts<br />
																		<strong>Police Station : </strong> psum static<br />
																		<br />
																		<strong>Date of Claim : </strong> 31-12-1969 <br />
																		<strong>Claim Place : </strong> Foierts<br />
																		<strong>Police Station : </strong> psum static<br />
																	</div>
																	<a href="#login-box" class="close">X</a>
																</div>
														  </form>
													</div>-->
													
												</tr>
                                                <?php $i++;}}else{
													?>
													<tr>
												<td colspan="9" align="center">No Record Listed</td>	
												</tr>
													<?php
													}?>
											</tbody>
										 </table>
									  </td>
									</tr>
								  </tbody>
								</table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
                                  <tr>
                                    <td width="6%"></td>
                                    <td width="19%">&nbsp;</td>
                                    
                                    <td width="75%" align="right">
                                    <?php if(isset($_POST['search'])){ ?>
                                    <?php echo Paging(POLICYTYPES,$perpage,"index.php?page=claim-list&",$pwhr);?>
                                    <?php }else{?>
                                    <?php echo Paging(POLICYTYPES,$perpage,"index.php?page=claim-list&");?>
                                    <?php } ?>
                                    </td>
                                  </tr>
                                </table>
							</form>
                            <div class="clearfix" style="height:100px;">.</div>
                        </div>
						
					</div>
				<div class="clearfix"></div>
				<div class="clearfix" style="height:15px;"></div>
				</div>
		<div class="clearfix" style="height:20px;"></div>
		
	</div>
   <?php } ?>