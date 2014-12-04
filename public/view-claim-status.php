<?php 
	if(empty($_SESSION['uid']))
	{
		header("location:index.php?page=sign-in");
	}else{
		$udata=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid='".$_SESSION['uid']."' and user_type='U' "));
		$userinfo=mysql_fetch_assoc(mysql_query("select * from ksa_user where id='".$_SESSION['uid']."' "));

 	
$reg_user_deatil = $db->recordFetch($_SESSION['uid'],USERTBL.":".'id');
$customer_code = getElementVal('customer_code',$reg_user_deatil);
?>
<script type="application/javascript">
function validClaimForm()
{
	if($('#policy_no').val() == '')
	{
		$('#policy_no').css( "border-color", "red" );
			
		$('#policy_no').focus();
		return false;
	}
	else
	{
		$('#policy_no').css( "border-color", "#B6B6B6" );
		var q = document.getElementById('policy_no').value;
		var url = '<?php echo BASE_URL.'index.php?page=view-claim-status';?>&policy_no='+q;	
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
                <strong>View Claim Status </strong>
            </div>
            
            <?php include_once('includes/dashboard-sidebar.php'); ?>
            <div class="lg-6">
                <div class="rightformpan innerTFl">
                    <h1>View Claim Status</h1>
                    
                    <form name="claim_status_form" id="claim_status_form" method="post">
                    	 <table width="100%">
                              <tbody>
                              <?php $pno_qry = mysql_query("select * from ".CLAIMMOTOR." where customer_id='".$customer_code."'");
							  if(mysql_num_rows($pno_qry)>0)
							  {?>
                                <tr height="20">
                                  <td width="25%">Policy Number : </td>
                                  <td width="75%">
                                      
                                        <select name="policy_no" id="policy_no" class="generalDropDown" style="width:68%">
                                        	<option value="">[--Select--]</option>
										<?php 
										  while($pno_data = mysql_fetch_array($pno_qry))
										  {
											  $selected = '';
											  if($_GET['policy_no'] == $pno_data['policy_no'])
											  	$selected = 'selected="selected"';
												
											  echo '<option value="'.$pno_data['policy_no'].'" '.$selected.'>'.stripslashes($pno_data['policy_no']).'</option>';
										  }?>
                                            
                                          </select>
                                      
                                  </td>
                                </tr>
                                <tr height="20">
                                	<td width="25%"> </td>
                                	<td width="75%">
                                        <input name="submit" value="Submit" class="sub_btn dis_fld" type="button" onclick="validClaimForm();" style="text-align: center;width:20%; float:left;  height:35px; line-height:34px;">
                                    </td>
                                </tr>
                                <?php }
								else
								{?>
                                    <tr height="20">
                                        <td width="25%" colspan="2">
                                        You have not claimed any policy.
                                        </td>
                                    </tr>
                                
                                <?php }
								
								if(!empty($_GET['policy_no']))
								{
									$policy_no = $_GET['policy_no'];
									$policy_claim = mysql_fetch_object(mysql_query("select * from ".CLAIMMOTOR." where customer_id='".$customer_code."' and policy_no='".$policy_no."'"));
									
									if($policy_claim->status == 0)
										$cstatus = 'Open';
									if($policy_claim->status == 1)
										$cstatus = 'On Progress';
									if($policy_claim->status == 2)
										$cstatus = 'Closed';
									
									?>
                                   
                                    <tr height="20"><td colspan="2"></td></tr>
                                    <tr height="20">
                                        <td width="25%" colspan="2">
                                            <table id="policy_details_div" class="PLdetail21">
                                              <tbody>
                                                <tr>
                                                  <td width="269" height="25"><span class="fieldLabel form_txt1" style="padding-left:3px;"><strong>Claim Place :</strong></span></td>
                                                  <td width="30" height="25">&nbsp;</td>
                                                  <td style="width: 45%;" height="25"><span class="fieldLabel form_txt1" style="padding-left:3px;"><strong>Claim Police Station :</strong></span></td>
                                                </tr>
                                                <tr>
                                                  <td height="25">
                                                  
                                                      <span class="fieldsColumn1"><?php echo stripslashes($policy_claim->claim_place);?>
                                                   
                                                    </span>
                                                      </td>
                                                  <td>&nbsp;</td>
                                                  <td height="25"><span class="fieldsColumn1">
                                                    <?php echo stripslashes($policy_claim->claim_police_station);?>
                                                    </span></td>
                                                </tr>
                                                <tr>
                                                  <td width="50%" height="25"><strong>&nbsp;<span class="fieldLabel form_txt1">FIR No :</span></strong></td>
                                                  <td width="30" height="25">&nbsp;</td>
                                                  <td width="297" height="25"><strong>Loss Date :</strong></td>
                                                </tr>
                                                <tr>
                                                  <td height="25" align="left" valign="top"><span class="fieldsColumn1">
                                                    <?php echo stripslashes($policy_claim->fir_no);?>
                                                    </span></td>
                                                  <td>&nbsp;</td>
                                                  <td height="25"><span class="fieldsColumn1">
                                                    <?php echo date('d-m-Y',strtotime($policy_claim->loss_date));?>
                                                    </span></td>
                                                </tr>
                                                <tr>
                                                  <td width="50%" height="25">&nbsp;<span class="fieldLabel form_txt1"><strong>Claim for :</strong></span></td>
                                                  <td width="30" height="25">&nbsp;</td>
                                                  <td width="297" height="25"><strong>Claim Status :</strong></td>
                                                </tr>
                                                <tr>
                                                  <td height="25" align="left" valign="top"><span class="fieldsColumn1">
                                                    <?php echo stripslashes($policy_claim->claim_for);?>
                                                    </span></td>
                                                  <td>&nbsp;</td>
                                                  <td height="25"><span class="fieldsColumn1">
                                                    <?php echo $cstatus;?>
                                                    </span></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td colspan="3"></td>
                                                </tr>
                                        </tbody>
                                </table>
                                    	</td>
                                    </tr>
                                <?php }?>
                              </tbody>
                          </table>
                         
                    </form>
                        
                    
                    <div class="clearfix" style="height:100px;"></div>
                </div>
            </div>
        <div class="clearfix"></div>
        </div>
       <div class="clearfix" style="height:15px;">.</div>
</div>
<?php } ?>