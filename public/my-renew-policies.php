<?php 
	if(empty($_SESSION['uid']))
	{
		header("location:index.php?page=sign-in");
	}else{
		$udata=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid='".$_SESSION['uid']."' and user_type='U' "));
		$userinfo=mysql_fetch_assoc(mysql_query("select * from ksa_user where id='".$_SESSION['uid']."' "));

 	
$reg_user_deatil = $db->recordFetch($_SESSION['uid'],USERTBL.":".'id');
$customer_code = getElementVal('customer_code',$reg_user_deatil);

function getPackageDetails($policy_no)
{
	$res = mysql_fetch_object(mysql_query("select b.package_title from ".POLICYMASTER." as a left join ".PACKAGE." as b on a.package_no = b.package_no where a.policy_no='".$policy_no."'"));
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
		
		var url = '<?php echo BASE_URL.'index.php?page=my-renew-policies';?>';	
		window.location.href = url;
	}
	else
	{
		var q = document.getElementById('policy').value;
		var url = '<?php echo BASE_URL.'index.php?page=my-renew-policies';?>&policy='+q;	
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
                <strong>My Renew Policies </strong>
            </div>
            
            <?php include_once('includes/dashboard-sidebar.php'); ?>
            <div class="lg-6">
                <div class="rightformpan innerTFl">
                    <h1>
                    My Renew Policies</h1>
                    <form name="searchform" enctype="get" action="<?php echo BASE_URL.'index.php?page=my-renew-policies';?>">
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
                                            <td width="15%" align="center"><strong>Renew Date</strong></td>
                                            
                                        </tr>
                                        <?php 
										if(isset($_GET['policy']) && !empty($_GET['policy']))
										{
											$whr = ' and policy_no="'.$_GET['policy'].'"';	 
										}
										$mypolicies_qry = mysql_query('select * from '.POLICYRENEWAL.' where customer_id="'.$customer_code.'"'.$whr.' order by id desc');
										if(mysql_num_rows($mypolicies_qry) > 0)
										{
											$i==0;
											while($policy = mysql_fetch_array($mypolicies_qry))
											{
												if($i%2 ==0)
													$bgcolor = '#fff';
												else 
													$bgcolor = '#E3EEDD'; ?>
                                                <tr bgcolor="<?php echo $bgcolor;?>">
                                                    <td align="center"><?php echo $i+1;?></td>
                                                    <td align="center"><?php echo $policy['policy_no'];?></td>
                                                    <td align="left"><?php echo getPackageDetails($policy['policy_no']);?></td>
                                                    <td><?php if($policy['policy_type_id']==1)echo 'TPL';else echo 'Comp';?></td>
                                                    <td align="center"><?php echo date('d-m-Y',strtotime($policy['policy_insured_startdate']));?> to <?php echo date('d-m-Y',strtotime($policy['policy_insured_enddate']));?></td>
                                                    
                                                    <td>
                                                        <?php echo date('d-m-Y',strtotime($policy['renew_date']));?>
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