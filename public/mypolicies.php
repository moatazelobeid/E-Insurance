<?php 
	if(empty($_SESSION['uid']))
	{
		header("location:index.php?page=sign-in");
	}else{
		$udata=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid='".$_SESSION['uid']."' and user_type='U' "));
		$userinfo=mysql_fetch_assoc(mysql_query("select * from ksa_user where id='".$_SESSION['uid']."' "));

 	
$reg_user_deatil = $db->recordFetch($_SESSION['uid'],USERTBL.":".'id');
$customer_code = getElementVal('customer_code',$reg_user_deatil);

function getPackageDetails($package_no)
{
	$res = mysql_fetch_object(mysql_query("select package_title from ".PACKAGE." where package_no='".$package_no."'"));
	return $res->package_title;
}
?>
<script>
function SearchByTitle()
{
	if(document.getElementById('policy').value == '')
	{
		/*document.getElementById('policy').style.borderColor = 'red';
		document.getElementById('policy').focus();
		return false;*/
		var url = '<?php echo BASE_URL.'index.php?page=mypolicies';?>';	
		window.location.href = url;
	}
	else
	{
		var q = document.getElementById('policy').value;
		var url = '<?php echo BASE_URL.'index.php?page=mypolicies';?>&policy='+q;	
		window.location.href = url;
	}
}
</script>
<div class="innrebodypanel">
        <div class="clearfix" style="height:15px;">.</div>
        <div class="innerwrap">
        
            <div class="breadcrumb" >
                <a itemprop="url" href="<?=BASE_URL?>">Home</a> 
                <span class="breeadset">&#8250;</span>
                <a itemprop="url" href="<?=BASE_URL.'index.php?page=user-dashboard'?>">Dashboard</a> 
                <span class="breeadset">&#8250;</span>
                <strong>My Policies </strong>
            </div>
            
            <?php include_once('includes/dashboard-sidebar.php'); ?>
            <div class="lg-6">
                <div class="rightformpan innerTFl">
                    <h1>
                    My Policies</h1>
                    <form name="searchform" enctype="get" action="<?php echo BASE_URL.'index.php?page=mypolicies';?>">
					<table  style="width:280px;font-size:13px; float:right;" border="0" cellspacing="0" cellpadding="0" >
								  <tbody>
									<tr>
                                    <td>Search :</td>
                                    <td><input name="policy" id="policy" value="<?php echo $_GET['policy'];?>" placeholder="Policy number"  type="text" class="generalTextBox" style="width: 120px;"></td>
                                    <td><input type="button" id="search" class="sub_btn actionBtn" value="Search" style="position: relative;bottom: 4px;height: 33px;" onclick="return SearchByTitle();"></td>
                                  </tr>
                                  
									
								  </tbody>
								</table>
								
								<div class="clearfix" style="height:0px;"></div>
                    
					</form>
                    
                    
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="policytab">
                          
                          <tbody>
                            <tr>
                              <td>
                                 <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                    <tbody>
                                        <tr style="background-color:green; color:#FFF;">
                                            <td width="5%" align="center"><strong>SL#</strong></td>
                                            <td width="16%" align="center"><strong>Policy Number</strong></td>
                                            <td width="23%" align="left"><strong>Policy Name</strong></td>
                                            <td width="13%" align="left"><strong>Policy Type</strong></td>
                                            <td width="28%" align="center"><strong>Policy From - Policy To </strong></td>
                                            <td width="15%" align="center"><strong>Status</strong></td>
                                            <td width="15%" align="center"><strong>Coverage</strong></td>
                                        </tr>
                                        <?php 
										if(isset($_GET['policy']) && !empty($_GET['policy']))
										{
											$whr = ' and policy_no="'.$_GET['policy'].'"';	 
										}
										$mypolicies_qry = mysql_query('select * from '.POLICYMASTER.' where customer_id="'.$customer_code.'"'.$whr.' order by id desc');
										if(mysql_num_rows($mypolicies_qry) > 0)
										{
											$i==0;
											while($policy = mysql_fetch_array($mypolicies_qry))
											{
												$policy_link = '';
												$policy_link = BASE_URL.'index.php?page=policy-details&policyno='.$policy['policy_no'];
												if($i%2 ==0)
													$bgcolor = '#fff';
												else 
													$bgcolor = '#E3EEDD'; ?>
                                                <tr bgcolor="<?php echo $bgcolor;?>">
                                                    <td align="center"><?php echo $i+1;?></td>
                                                    <td align="center"><a href="<?php echo $policy_link;?>"><?php echo $policy['policy_no'];?></a></td>
                                                    <td align="left"><a href="<?php echo $policy_link;?>"><?php echo getPackageDetails($policy['package_no']);?></a></td>
                                                    <td><?php if($policy['policy_type_id']==1)echo 'TPL';else echo 'Comp';?></td>
                                                    <td align="center"><?php echo date('d-m-Y',strtotime($policy['insured_period_startdate']));?> to <?php echo date('d-m-Y',strtotime($policy['insured_period_enddate']));?></td>
                                                    <td><font color="green"><?php echo $policy['status'];?></font> &nbsp; </td>
                                                    <td>
                                                        <a href="<?php echo $policy_link;?>"><img src="images/b_browse.png" height="15" width="15" title="Policy Details"></a>
                                                    </td>
                                                </tr>
                                                <?php $i++;
											}
										}
										else
										{
											?>
											<tr>
											<td colspan="7" style=" text-align: center;">No Policy Found</td>
											</tr>
											<?php 	
										}?>	
                                        
                                    </tbody>
                                 </table>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                    
                    <div class="clearfix" style="height:100px;">.</div>
                </div>
            </div>
        <div class="clearfix"></div>
        </div>
       <div class="clearfix" style="height:15px;">.</div>
</div>
<?php } ?>