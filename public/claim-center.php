<?php
$alias=$_GET['page'];
$_GET['page'] = $alias;
$menu=mysql_fetch_object(mysql_query("select * from ".PAGEMENU." where allias='$alias'"));
$page=mysql_fetch_object(mysql_query("select * from  ".PAGETBL." where id ='".$menu->menu_assign."'"));
if(!$page)
{ 

 ?>
<div class="innrebodypanel">
				<div class="clearfix" style="height:15px;">.</div>
				<div class="innerwrap">
					
					<h1><?='Page not found'?></h1>
					<?='Page not found'?>				
				</div>
				<div class="clearfix" style="height:15px;">.</div>
		</div>

<?php }
else{ 
	if(isset($_GET['policy_id']))
	{
		$checkrow=mysql_fetch_object(mysql_query("select * from  ".POLICYMASTER." where policy_no ='".$_GET['policy_id']."' and status ='Active'"));
			if(!empty($checkrow))
			{
				$policyholderinfo =  mysql_fetch_object(mysql_query("select * from  ksa_user where customer_code ='".$checkrow->customer_id."'"));
				$showdetailsflag = 1;
				
			}else{
				
				$errmsg = '<font style=" color:#900;margin-left:5px;">Invalid Policy id or Inactive Policy id.</font>';	
			}
			
	}
	//check the policy submit.
	if(isset($_POST['checkPolicySubmit']))
	{
	
			$checkrow=mysql_fetch_object(mysql_query("select * from  ".POLICYMASTER." where policy_no ='".$_POST['policy_no']."' and status ='Active'"));
			if(!empty($checkrow))
			{
				$policyholderinfo =  mysql_fetch_object(mysql_query("select * from  ksa_user where customer_code ='".$checkrow->customer_id."'"));
				$showdetailsflag = 1;
				
			}else{
				
				$errmsg = '<font style=" color:#900;margin-left:5px;">Invalid Policy id or Inactive Policy id.</font>';	
			}
			
		
	}
	if(isset($_POST['send_claim']))
	{
			$claim_date_auto = date('Y-m-d H:i:s',strtotime($_POST['claim_date_auto']));
			$countrows = mysql_query("select * from  ".CLAIMMOTOR." where 1=1");
			$claimid = (mysql_num_rows($countrows)>0)?mysql_num_rows($countrows)+1:'1';
			$claim_no = 'AC/'.date('Y').'/'.$claimid;
			$claimed_by = 'customer';
			$checkrow=mysql_fetch_object(mysql_query("select * from  ".POLICYMASTER." where policy_no ='".$_POST['policy_id']."' and status ='Active'"));
			if(!empty($checkrow))
			{
				$checkclaim=mysql_fetch_object(mysql_query("select * from  ".CLAIMMOTOR." where policy_no ='".$_POST['policy_id']."' and customer_id ='".$checkrow->customer_id."' and status = '0'"));
				if(!empty($checkclaim))
				{
					$errmsg = '<font style=" color:#900;margin-left:5px;">Policy id is in open status .</font>';	
				}else{
				
					$save_arr = array("claim_no"=>$claim_no,"customer_id"=>$checkrow->customer_id,"claimed_by"=>$claimed_by,"policy_no"=>$_POST['policy_id'],"claim_for"=>$_POST['claim_for'],"loss_date"=>$claim_date_auto ,"claim_place"=>$_POST['claim_place'],"claim_police_station"=>$_POST['claim_police_station'],"fir_no"=>$_POST['fir_no'],"brief_description"=>addslashes($_POST['brief_description']),"claim_details"=>addslashes($_POST['claim_details']),"created_date"=>date('Y-m-d H:i:s'));
					$insert =  $db->recordInsert($save_arr,CLAIMMOTOR);
					if($insert)
					{
						header("location:index.php?page=claim-list&claimed=1");
					}else{
						$errmsg = '<font style=" color:#018d01;margin-left:5px;">Claim sending Failed. </font>';		
					}
				}
			}else{
				
				$errmsg = '<font style=" color:#900;margin-left:5px;">Invalid Policy id .</font>';	
			}
			
		
	}

?>
<script type="text/javascript">
	function validate_claim_enquiry()
	{
		var policy_no = $("#policy_no").val();
		if(policy_no == '')
		{
			$("#policy_no").css('border-color','#900');
			$("#policy_no").attr('placeholder','Enter Policy No.')
			return false;
		}else
		{
			$("#policy_no").css('border-color','');
		}
	}
	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
		else
		return true;
	}
	function loginnow()
	{
		var loginname= $("#uname").val();
		var passwrd= $("#pwd").val();
		var policy_id = $("#policy_no").val();
		if(loginname == '' || passwrd == '' || policy_id =='')
		{
			if(loginname == '')
			{
				$("#uname").css('border-color','#900');
				$("#uname").attr('placeholder','Enter Username or email.')
				return false;
			}else
			{
				$("#uname").css('border-color','');
			}
			if(passwrd == '')
			{
				$("#pwd").css('border-color','#900');
				$("#pwd").attr('placeholder','Enter Password.')
				return false;
			}else
			{
				$("#pwd").css('border-color','');
			}
		}else{
			
			$.ajax({
				type: "POST",
				url: "util/utils.php",
				data: "uname="+loginname+"&paswd="+passwrd+"&policy_id="+policy_id,
				success: function(msg){
					if(msg ==0)
					{
						$('#sucesslogin').css('color','#900');
						$("#sucesslogin").html('Invalid Login Credentials')
					}
					else
					{
						window.location.href='<?=BASE_URL?>index.php?page=claim-center&policy_id='+msg;
					}
				}
			});
		}
	}
	
	function validate_claim()
	{
		var policy_no = $("#policy_no").val();
		if($("#policy_no").val() == '')
		{
			$("#policy_no").css('border-color','#900');
			$("#policy_no").focus();
			$("#policy_no").attr('placeholder','Enter Policy no.')
			return false;
		}else
		{
			$("#policy_no").css('border-color','');
		}
		if($("#claim_place").val() == '')
		{
			$("#claim_place").css('border-color','#900');
			$("#claim_place").focus();
			$("#claim_place").attr('placeholder','Enter Claim Place.')
			return false;
		}else
		{
			$("#claim_place").css('border-color','');
		}
		if($("#claim_police_station").val() == '')
		{
			$("#claim_police_station").css('border-color','#900');
			$("#claim_police_station").focus();
			$("#claim_police_station").attr('placeholder','Enter Police Station.')
			return false;
		}else
		{
			$("#claim_police_station").css('border-color','');
		}
		if($("#fir_no").val() == '')
		{
			$("#fir_no").css('border-color','#900');
			$("#fir_no").focus();
			$("#fir_no").attr('placeholder','Enter Fir No.')
			return false;
		}else
		{
			$("#fir_no").css('border-color','');
		}
		if($("#claim_date_auto").val() == '')
		{
			$("#claim_date_auto").css('border-color','#900');
			$("#claim_date_auto").focus();
			$("#claim_date_auto").attr('placeholder','Enter Clain date.')
			return false;
		}else
		{
			$("#claim_date_auto").css('border-color','');
		}
		
		if($("#brief_description").val() == '')
		{
			$("#brief_description").css('border-color','#900');
			$("#brief_description").focus();
			$("#brief_description").attr('placeholder','Enter A breif desciption of the incident.')
			return false;
		}else
		{
			$("#brief_description").css('border-color','');
		}
		
	}
</script>
<div class="innrebodypanel">
    <div class="clearfix" style="height:15px;">.</div>
    <div class="innerwrap">
      <div class="breadcrumb"> <a itemprop="url" href="<?=BASE_URL?>">Home</a> <span class="breeadset">&#8250;</span> <strong><?=$page->pg_title?></strong> </div>
      <div class="leftbokpan">
        <h1><?=$page->pg_title?></h1>
        <?=stripslashes($page->pg_detail)?>
        <div class="clearfix" style="height:8px;">.</div>
       <?php if(isset($msg)){ ?> <div  style="height:26px;"><?php  echo $msg; ?></div> <?php } ?>
        <div id="formpan" class="formpan2" style="width:100%!important">
          
          <div class="row1">
            <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Policy Information</strong></lable>
          </div>
          <div class="your-quoatation-inner1">
          <div class="box_border_area">
          <form name="claim_enquiry" id="claim_enquiry" onsubmit="return validate_claim_enquiry();"  action="" method="post">
            <table width="100%" border="0" cellspacing="4">
              <tbody>
                <tr>
                  <td width="150" height="35" valign="middle"><strong>&nbsp;Enter Policy No:</strong> <span class="mandFieldIndicator1">*</span> </td>
                  <td width="650" height="25" colspan="2" valign="top"><span class="fieldsColumn1">
                    <input name="policy_no" type="text" id="policy_no" tabindex="3" maxlength="20" class="generalTextBox" autocomplete="off" style="width:79%; float:left;" value="<?=$checkrow->policy_no?>" onkeypress="return isNumberKey(event);">
                    &nbsp; &nbsp;
                    <input name="checkPolicySubmit" value="Submit" class="sub_btn" type="submit" style="float: right;position: relative;top: 5px;height: 32px;width: 16%;">
                    </td>
                </tr>
                <tr>
                	<td colspan="2"><span id="showmsg" style="font-size:12px;"><?php if(isset($errmsg)){ echo $errmsg;} ?></span></td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
     
      <div id="policy_content_div">
        <div class="form_area_left_dash" style=" width:100%;">
          <div class="form_area_left_dash_inner" style=" width:auto;">
            <div class="auto_insurarea" style="border: 1px solid #E7E7E7;background:none;border-radius: 4px;">
            <?php if(isset($showdetailsflag) && !empty($showdetailsflag)){?>
              <div class="form_area_left_dash_heading" style="width:100%; text-transform:none;">Policy Details </div>
              <?php } ?>
              <div class="auto_insurarea_inner" style="margin-left:9px; width:auto;">
                <div class="your-quoatation1">
                  <div class="your-quoatation-inner1">
                   <?php if(isset($showdetailsflag) && !empty($showdetailsflag))
					  	{
					   ?>
                      <form name="claim_form" id="claim_form" onsubmit="return validate_claim()" method="post">
                        <table id="policy_details_div">
                          <tbody>
                            <tr>
                              <td width="269" height="25"><span class="fieldLabel form_txt1" style="padding-left:3px;">Period From :</span></td>
                              <td width="30" height="25">&nbsp;</td>
                              <td style="width: 45%;" height="25"><span class="fieldLabel form_txt1" style="padding-left:3px;">Email :</span></td>
                            </tr>
                            <tr>
                              <td height="25"><table width="100%">
                                  <tbody>
                                    <tr>
                                    <?php ?>
                                      <td width="38%"><input name="policy_from_date" type="text" id="policy_from_date" tabindex="3" class="generalTextBox" autocomplete="off" readonly value="<?=date('d-m-Y',strtotime($checkrow->insured_period_startdate))?>"></td>
                                      <td width="18%" align="center">To</td>
                                      <td width="44%"><input name="policy_to_date" type="text" id="policy_to_date" tabindex="3" class="generalTextBox" autocomplete="off"  readonly="" value="<?=date('d-m-Y',strtotime($checkrow->insured_period_enddate))?>"></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                              <td>&nbsp;</td>
                              <td height="25"><span class="fieldsColumn1">
                                <input name="email" type="text" id="email" tabindex="3" class="generalTextBox" autocomplete="off" readonly value="<?=$policyholderinfo->email?>">
                                </span></td>
                            </tr>
                            <tr>
                              <td width="269" height="25">&nbsp;<span class="fieldLabel form_txt1">Name of Policy Holder :</span></td>
                              <td width="30" height="25">&nbsp;</td>
                              <td width="297" height="25">Address</td>
                            </tr>
                            <tr>
                              <td height="25" align="left" valign="top"><span class="fieldsColumn1">
                                <input name="insuredname" type="text" id="name" tabindex="3" class="generalTextBox" autocomplete="off" readonly value="<?=$checkrow->insured_person?>">
                                </span></td>
                              <td>&nbsp;</td>
                              <td height="25"><span class="fieldsColumn1">
                                <textarea name="address1" id="address1" readonly class="generalDropDown" style="height:45px;resize:none;width:98%;"><?=$policyholderinfo->address1?></textarea>
                                </span></td>
                            </tr>
                            <tr>
                              <td width="269" height="25">&nbsp;<span class="fieldLabel form_txt1">Date Of Birth :</span> </td>
                              <td width="30" height="25">&nbsp;</td>
                              <td width="297" height="25">Phone</td>
                            </tr>
                            <tr>
                              <td height="25" align="left"><span class="fieldsColumn1">
                                <input name="dob" type="text" tabindex="3" class="generalTextBox" autocomplete="off" readonly value="<?=date('d-m-Y',strtotime($policyholderinfo->dob))?>">
                                </span></td>
                              
                              <td height="25">&nbsp;</td>
                              <td><span class="fieldsColumn1"><input name="name" type="text" id="name" tabindex="3" class="generalTextBox" autocomplete="off" readonly value="<?=$policyholderinfo->phone_mobile?>"></span></td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                            </tr>
                          </tbody>
                        </table>
                    <?php } ?>
                      </div>
                    </div>
                  </div>
                  <div class="clear" style="height:5px;"></div>
                </div>
              </div>
            </div>
            <div class="form_area_left_dash">
              <div class="form_area_left_dash_inner" style=" width:auto;">
                <div class="auto_insurarea" style="border: 1px solid #E7E7E7;background:none;border-radius: 4px;">
                 <?php if(isset($showdetailsflag) && !empty($showdetailsflag)  && !isset($_SESSION['uid'])){?>
                  <div class="form_area_left_dash_heading" style="font-size:15px; text-transform:none;">Login Form </div>
                  <?php } ?>
                  <div class="auto_insurarea_inner" style="margin-left:9px; width:auto;">
                    <div class="your-quoatation1">
                      <div class="your-quoatation-inner1">
                       <?php if(isset($showdetailsflag) && !empty($showdetailsflag) && !isset($_SESSION['uid'])){?>
                        <table width="100%" border="0" cellspacing="8" cellpadding="0" style="position: relative;left: -10px;width: 105.5%;">
                          <tbody>
                            <tr>
                              <td align="center" colspan="2" class="error" style="display:none;"><div id="error_div">Please Login to Claim Against Your Insurance Policy..</div></td>
                            </tr>
                            <tr>
                              <td  style="width:15%;" align="left">User Id: <span class="mandFieldIndicator">*</span></td>
                              <td style="width: 45%;"><input name="uname" type="text" class="generalTextBox" id="uname" style="cursor:text;">
                              </td>
                            </tr>
                            <tr>
                              <td align="left">Password: <span class="mandFieldIndicator">*</span></td>
                              <td><input name="pwd" type="password" class="generalTextBox" id="pwd" style="cursor:text;"></td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center"><div class="clear"></div>
                                <input type="button" onClick="loginnow();" class="submit_button" value="Login" style="float: left;margin-left: 26.5%;width: 23%;"></td>
                              <td align="left"></td>
                            </tr>
                             <tr>
                                <td colspan="2"><span id="sucesslogin" style="font-size:12px;"></span></td>
                            </tr>
                          </tbody>
                        </table>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <div class="clear" style="height:5px;"></div>
                </div>
              </div>
            </div>
            <div class="clear" style="height:30px;"></div>
            <div class="form_area_left_dash claimformdetail" style=" width:100%;">
              <div class="form_area_left_dash_inner" style=" width:auto;">
                <div class="auto_insurarea" style="border: 1px solid #E7E7E7;background:none;border-radius: 4px;">
                <?php if(isset($showdetailsflag) && !empty($showdetailsflag) && isset($_SESSION['uid'])){?>
                  <div class="form_area_left_dash_heading" style="font-size:15px; width:100%; text-transform:none;">Policy Claim Detils</div>
                  <?php } ?>
                  <div class="auto_insurarea_inner" style="margin-left:9px; width:auto;">
                    <div class="your-quoatation1">
                      <div class="your-quoatation-inner1">
                       <?php if(isset($showdetailsflag) && !empty($showdetailsflag) && isset($_SESSION['uid'])){?>
                        <table style="width: 102%;position: relative;left: -7px;">
                          <tbody>
                            <tr>
                              <td height="25">&nbsp;<span class="fieldLabel form_txt1">Claim Place  :</span> <span class="mandFieldIndicator1">*</span></td>
                              <td height="25">&nbsp;</td>
                              <td width="297"><span class="fieldLabel form_txt1" style="padding-left: 2px;">Claim Police Station :</span> <span class="mandFieldIndicator1">*</span></td>
                            </tr>
                            <tr>
                              <td align="left"><span class="fieldsColumn1">
                                <input name="claim_place" type="text" id="claim_place" tabindex="3" class="generalTextBox" autocomplete="off">
                                <input type="hidden" name="policy_id" id="policy_id" value="<?php if(isset($_GET['policy_id'])){echo $_GET['policy_id'];}elseif(isset($checkrow->policy_no)){ echo $checkrow->policy_no;} ?>" />
                                </span></td>
                              <td>&nbsp;</td>
                              <td><span class="fieldsColumn1">
                                <input name="claim_police_station" type="text" id="claim_police_station" tabindex="3" class="generalTextBox" autocomplete="off">
                                </span></td>
                            </tr>
                            <tr>
                              <td width="269">&nbsp;<span class="fieldLabel form_txt1">FIR No.  :</span> <span class="mandFieldIndicator1">*</span> </td>
                              <td width="30" height="25">&nbsp;</td>
                              <td><span class="fieldLabel form_txt1" style="padding-left:2px;"> Loss Date:</span> <span class="mandFieldIndicator1">*</span></td>
                            </tr>
                            <tr>
                              <td align="left"><span class="fieldsColumn1">
                                <input name="fir_no" type="text" id="fir_no" tabindex="3" class="generalTextBox" autocomplete="off">
                                </span></td>
                              <td>&nbsp;</td>
                              <td style="width: 45%;"><span class="fieldsColumn1">
                                <input name="claim_date_auto" type="text" id="claim_date_auto" tabindex="3" class="generalTextBox calender123" autocomplete="off" >
                                </span></td>
                            </tr>
                            <tr>
                              <td height="25">&nbsp;<span class="fieldLabel form_txt1">Cliam for  :</span> <span class="mandFieldIndicator1">*</span> <span id="claim_for_error" style="color:#FF0000; font-family:Verdana, Arial, Helvetica, sans-serif;"></span> </td>
                              <td height="25">&nbsp;</td>
                              <td width="297">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="25" align="left"><span class="fieldsColumn1">
                                <input value="Accident" name="claim_for" type="radio" id="claim_for1">
                                <span class="form_txt">Accident</span>
                                <input value="Theft" name="claim_for" type="radio" id="claim_for2">
                                <span class="form_txt">Theft</span></span></td>
                              <td height="25">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="269" height="30">&nbsp;<span class="fieldLabel form_txt1">Brief Description of Accident/ Theft  :</span> <span class="mandFieldIndicator1">*</span> </td>
                              <td width="30" height="25">&nbsp;</td>
                              <td width="297" height="25">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="25" colspan="3" align="left"><textarea name="brief_description" class="generalDropDown" tabindex="3" style="width:99%; height:120px; resize:none;" id="brief_description"></textarea></td>
                            </tr>
                          </tbody>
                        </table>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <div class="mask" style="height:5px;"></div>
                </div>
              </div>
            </div>
            <div class="form_area_left_dash" style=" width:100%;">
              <div class="form_area_left_dash_inner" style=" width:100%;">
                <div class="auto_insurarea" style="border: 1px solid #E7E7E7;background:none;border-radius: 4px;">
                 <?php if(isset($showdetailsflag) && !empty($showdetailsflagflag) && isset($_SESSION['uid'])){?>
                  <div class="form_area_left_dash_heading" style="font-size:15px; width:100%; text-transform:none;">Claim Details </div>
                  <?php } ?>
                  <div class="auto_insurarea_inner" style="margin-left:9px; width:auto;">
                    <div class="your-quoatation1">
                      <div class="your-quoatation-inner1">
                       <?php if(isset($showdetailsflag) && !empty($showdetailsflag) && isset($_SESSION['uid'])){?>
                        <table style="width: 102%;position: relative;left: -8px;">
                          <tbody>
                            <tr>
                              <td height="30" colspan="3">&nbsp;<span class="fieldLabel form_txt1">Explain your Claim Details :</span></td>
                            </tr>
                            <tr>
                              <td height="80" colspan="3"><textarea name="claim_details" id="claim_details" class="generalDropDown" style="width:100%; height:120px; resize:none;" tabindex="3"></textarea></td>
                            </tr>
                            <tr>
                              <td colspan="3" height="10"></td>
                            </tr>
                            <tr class="fieldRow1">
                              <td colspan="3" class="fieldLabelsColumn1"><input type="submit" name="send_claim" class="submit_button" value="Send" style="float:right; position:relative; left:5px; width:15%;">
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                            </tr>
                          </tbody>
                        </table>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <div class="mask" style="height:5px;"></div>
                </div>
              </div>
            </div>
          </div>
         </form>
      <div class="clear" style="height:1px;"></div>
    </div>
  </div>

  <div class="lg-3" style="float: right;margin-top:2%;padding-top: 9px;">
    <div class="normallist1">
      <h1>Need Help</h1>
      <ul>
        <li><a href="index.php?page=faq">FAQ</a></li>
        <li><a href="index.php?page=contact-us">Contact Us</a></li>
      </ul>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<div class="clearfix" style="height:15px;"></div>
</div>
<?php }?>