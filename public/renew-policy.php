<?php $db = new dbFactory();

include('paypal/paypalfunctions.php');
include('PHPMailer/PHPMailerAutoload.php');

if(empty($_SESSION['uid']))
{
	header("location:index.php?page=sign-in");
}
else
{
	if(isset($_SESSION['Renew_Policy']) && !empty($_SESSION['Renew_Policy']))
	{
		
		//if(!empty($_POST['txn_id']))
		//{
			
			if(!empty($_POST['txn_id']))
				$transaction_id =  $_POST['txn_id'];
			else
				$transaction_id =  rand();
			
			//on payment success
			
			$policy_data = $_SESSION['Renew_Policy'];
			
			$total_payment_amount = $policy_data['payment_amount'];
			
			$policy_no = $policy_data['policy_no'];
					
			$renew_data = '';
			
			$renew_data['customer_id'] = $policy_data['customer_id'];
			$renew_data['policy_no'] = $policy_data['policy_no'];
			$renew_data['policy_class_id'] = 1;
			$renew_data['policy_type_id'] = $policy_data['policy_type_id'];
			$renew_data['policy_insured_startdate'] = date('Y-m-d',strtotime($policy_data['policy_insured_startdate']));
			$renew_data['policy_insured_enddate'] = date('Y-m-d',strtotime($policy_data['policy_insured_enddate']));
			$renew_data['renew_date'] = date('Y-m-d H:i:s');
				
			//Insert into policy renew table	
			$insert_policy_renew = $db->recordInsert($renew_data,POLICYRENEWAL,'');
				
			if($insert_policy_renew == 1)
			{		
				$renew_id = mysql_insert_id();
				
				if(!empty($_POST['payment_status']))
				{
					if(($_POST['payment_status'] == 'Completed') || ($_POST['payment_status'] == 'Paid'))
					{
						$payment_status = '1';
					}
					else
					{
						$payment_status = '0';
					}
				}
				else
				{
					$payment_status = '1';
				}
				
				
				//Insert into payment table
				$payment_data = '';
				$payment_data['policy_no'] = $policy_data['policy_no'];
				$payment_data['customer_id'] = $policy_data['customer_id'];
				$payment_data['policy_amount'] = $total_payment_amount;
				$payment_data['amount_paid'] = $total_payment_amount;
				$payment_data['transaction_id'] = $transaction_id;
				$payment_data['payment_mode'] = 'online';
				$payment_data['payment_processor'] = 'paypal';
				$payment_data['payment_status'] = $payment_status;
				$payment_data['paid_date'] = date('Y-m-d H:i:s');
				$payment_data['renew_id'] = $renew_id;
				
				$insert_policy_payment = $db->recordInsert($payment_data,POLICYPAYMENTS,'');
				
				if($insert_policy_payment == 1)
				{
					//Email to user
					$email = $_POST['email'];
					$user_subject = 'Policy Renewal Confirmation.';
					$user_email_msg = 'Dear '.$fname.'<br><br>Your Motor Policy(<strong>'.$policy_no.'</strong>) is successfully renewed at '.SITE_NAME.
					'<br><br>Regards,<br>'.SITE_NAME;
				
					//Email account details to the customer
					//mail($email,$subject,$msg);	
		
					$user_mail = new PHPMailer;
					
					$user_mail->From = SITE_EMAIL;
					$user_mail->FromName = SITE_NAME;
					$user_mail->addAddress($email, $fname);
					
					$user_mail->isHTML(true);  // Set email format to HTML
					
					$user_mail->Subject = $user_subject;
					
					$user_mail->Body    = $user_email_msg;
					
					if(!$user_mail->send()) { }
					
					
					$_SESSION['Renew_Policy_Msg'] = 'Your policy is renewed successfully.';
				}
			}
			unset($_SESSION['Renew_Policy']);
			unset($_SESSION['nvpReqArray']);
			
			//header('Location: '.BASE_URL.'index.php?page=renew-policy');
		
		//}
		/*else
		{
			$error_msg = 'Your payment transaction is failed. Try again';
		}*/
		
	}
	
	if(!empty($_SESSION['Renew_Policy_Msg']))
	{
		$msg = $_SESSION['Renew_Policy_Msg'];
		
		unset($_SESSION['Renew_Policy_Msg']);	
	}
	
	
	if(isset($_POST['renew']))
	{
		unset($_POST['renew']);
		
		//get policy amount
		$customer_id = $_POST['customer_id'];
		
		$policy_no = $_POST['policy_no'];
		
		$fname = $_POST['name'];
		
		$total_payment_amount = $_POST['payment_amount'];
		
		if(($total_payment_amount == '0.00') || empty($total_payment_amount))
		{
			$total_payment_amount = '0.01';	
		}
		
		$_POST['payment_amount'] = $total_payment_amount;
		$_SESSION['Renew_Policy'] = $_POST;
		
		// PayPal Settings
		$email 	= 'moataz.elobeid@gmail.com';
		//$email 	= 'idbehera11@gmail.com';
		$return 	= BASE_URL.'index.php?page=renew-policy';
		$cancel 	= BASE_URL.'index.php?page=payment-cancelled';
		//$notify 	= BASE_URL.'paypal_ipn.php';
		
		$name = "Motor Insurance Policy";
		
		$custom=json_encode($_POST);
		
		// Firstly Append paypal account to querystring
		$querystring .= "?business=".urlencode($email)."&";	
	
		//Appending the subscription type for payment
		$querystring .= "cmd=".urlencode("_xclick")."&";
		
		//Append amount& currency & subsequent details to quersytring so it cannot be edited in html
		$querystring .= "currency_code=".urlencode("USD")."&";
		$querystring .= "no_note=".urlencode("1")."&";
		$querystring .= "no_shipping=".urlencode("1")."&";
			
		//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
		$querystring .= "item_name=".urlencode($name)."&";
		$querystring .= "amount=".urlencode($total_payment_amount)."&";
		
		$querystring .= "custom=".$custom."&";
		
        // Append paypal return addresses
		$querystring .= "rm=".urlencode("2")."&";
		$querystring .= "return=".urlencode(stripslashes($return))."&";
		$querystring .= "cancel_return=".urlencode(stripslashes($cancel))."&";
		$querystring .= "notify_url=".urlencode($return.'&notify=1');
		
		//Redirect to paypal IPN
		header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
		//header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
		exit();
	}	
	
	
$reg_user_deatil = $db->recordFetch($_SESSION['uid'],USERTBL.":".'id');
$customer_code = getElementVal('customer_code',$reg_user_deatil);


?>

<script type="application/javascript">
$(document).ready(function() {
						   
	   $( "#policy_insured_startdate" ).datepicker({
		
		dateFormat: 'dd-mm-yy' , 
		changeYear: 'false' , 
		yearRange: '<?php echo date('Y');?>:<?php echo date('Y');?>' , 
		changeMonth: 'true' 
				
		
		} );
	   
	   
});

function getPolicyNos(ptype)
{
	var data = '';
	$('#pno_section').html('Loading...');
	$('#pdetail_section').html('');
	if(ptype!='')
	{
		var url = '<?php echo BASE_URL;?>/util/vehicle.php?task=getPolicyNos&ptype='+ptype+'&cid=<?php echo $customer_code;?>'; //alert(url);
		$.get(url,function(res)
		{
			//alert(res);
			if(res!=0)
			{
				data = res;
			}
			else
			{
				data = '<select id="policy_no" name="policy_no" class="dropdown" disabled="disabled"><option value="">[--Select--]</option></select>';
			}
			$('#pno_section').html(data);
		});
	}
	else
	{
		data = '<select id="policy_no" name="policy_no" class="dropdown" disabled="disabled"><option value="">[--Select--]</option></select>';
		$('#pno_section').html(data);
	}
}

function getPolicyDetail(pno)
{
	var data = '';
	$('#pdetail_section').html('Loading...');
	if(pno!='')
	{
		var url = '<?php echo BASE_URL;?>/util/vehicle.php?task=getPolicyDetails&pno='+pno; //alert(url);
		$.get(url,function(res)
		{
			//alert(res);
			if(res!=0)
			{
				data = res;
			}
			
			getPaymentAmount(pno);
			
			$('#pdetail_section').html(data);
			$('.dis_fld').removeAttr('disabled');
			
			data.slideDown(1000);
			
		});
	}
	else
	{
		$('#pdetail_section').html('');
		$('.dis_fld').attr('disabled','disabled');
	}
}

function getPaymentAmount(pno)
{
	var url = '<?php echo BASE_URL;?>/util/vehicle.php?task=getPaymentAmount&pno='+pno+'&cus_id=<?php echo $customer_code;?>'; //alert(url);
	$.get(url,function(res)
	{
		//alert(res);
		var res_val = res.split('.');
		
		if(res_val[1] < 10)
		{
			res = res+'0';	
		}
		
		$('#payment_amount').val(res);
		$('#payment_amount_div').html('<br>Total Policy Amount: <b>'+res+'</b> SR<br><br>');
	});
}

function validRenewForm()
{
	var form = document.renew_form;
	var flag = true;
	var fields = new Array();
	
	if(form.policy_type_id.value == '')
	{
		form.policy_type_id.style.borderColor='red';
		flag = false;	
		fields.push('policy_type_id');
	}
	else
	{
		form.policy_type_id.style.borderColor='#B6B6B6';
		
		if(form.policy_no.value == '')
		{
			form.policy_no.style.borderColor='red';
			flag = false;	
			fields.push('policy_no');
		}
		else
		{
			form.policy_no.style.borderColor='#B6B6B6';
			
			if(form.policy_insured_startdate.value == '')
			{
				form.policy_insured_startdate.style.borderColor='red';
				flag = false;	
				fields.push('policy_insured_startdate');
			}
			else
			{
				form.policy_insured_startdate.style.borderColor='#B6B6B6';
			}
			
			/*var cno = $('#card_no').val();
			
			if($('#card_no').val() == '')
			{
				$('#card_no').css( "border-color", "red" );
				flag = false;	
				fields.push('card_no');
			}
			else
			{
				var res = Mod10(cno);
				if(res == 0)
				{
					alert("Enter a Valid Card Number");
					flag = false;	
					fields.push('card_no');
				}
				else
				{
					$('#card_no').css( "border-color", "#999" );
				}
			}
	
			if($('#card_exp_mm').val() == '')
			{
				$('#card_exp_mm').css( "border-color", "red" );
				flag = false;	
				fields.push('card_exp_mm');
			}
			else
			{
				$('#card_exp_mm').css( "border-color", "#999" );
			}
			
			if($('#card_exp_yy').val() == '')
			{
				$('#card_exp_yy').css( "border-color", "red" );
				flag = false;	
				fields.push('card_exp_yy');
			}
			else
			{
				$('#card_exp_yy').css( "border-color", "#999" );
			}
			
			if($('#cvv_no').val() == '')
			{
				$('#cvv_no').css( "border-color", "red" );
				flag = false;	
				fields.push('cvv_no');
			}
			else
			{
				$('#cvv_no').css( "border-color", "#999" );
			}*/
		}
		
	}
	

	if(fields.length>0)
	{
		var fld = fields[0];
		
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}

function getPolicyEndDate(date1)
{
	var enddate = '';
	
	var dt  = date1.split('-');
	
	var day = dt[0];
	var month = dt[1];
	var year = dt[2];

	//enddate = month+'/'+day+'/'+(parseInt(year)+1);
	
	enddate = day+'-'+month+'-'+(parseInt(year)+1);
	
	$('#policy_insured_enddate').val(enddate);	
	//alert(enddate);
}
function validStep5Form()
{
	var flag = true;
	var fields = new Array();
	var cno = $('#card_no').val();
	
	if($('#card_no').val() == '')
	{
		$('#card_no').css( "border-color", "red" );
		flag = false;	
		fields.push('card_no');
	}
	else
	{
		var res = Mod10(cno);
		if(res == 0)
		{
			alert("Enter a Valid Card Number");
			flag = false;	
			fields.push('card_no');
		}
		else
		{
			$('#card_no').css( "border-color", "#999" );
		}
	}
	
	if($('#card_exp_mm').val() == '')
	{
		$('#card_exp_mm').css( "border-color", "red" );
		flag = false;	
		fields.push('card_exp_mm');
	}
	else
	{
		$('#card_exp_mm').css( "border-color", "#999" );
	}
	
	if($('#card_exp_yy').val() == '')
	{
		$('#card_exp_yy').css( "border-color", "red" );
		flag = false;	
		fields.push('card_exp_yy');
	}
	else
	{
		$('#card_exp_yy').css( "border-color", "#999" );
	}
	
	if($('#cvv_no').val() == '')
	{
		$('#cvv_no').css( "border-color", "red" );
		flag = false;	
		fields.push('cvv_no');
	}
	else
	{
		$('#cvv_no').css( "border-color", "#999" );
	}
	
	if(fields.length>0)
	{
		var fld = fields[0];

		$('#'+fld).focus();
		return false;
	}
	else
	{
		document.renew_form.submit();
	}
}

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	
	return true;
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
                    <strong>Renew Policy</strong>
                </div>
                
                <?php include_once('includes/dashboard-sidebar.php'); ?>
                <div class="lg-6">
                
                	<?php if(!empty($msg))
					{?>
						<div style=" text-align:center; width:100%; font-size:20px; color:green">
							<?php echo $msg;?>
                        </div>
					<?php }?>
                
                	<?php if(!empty($error_msg))
					{?>
						<div style=" text-align:center; width:100%; font-size:20px; color:red">
							<?php echo $error_msg;?>
                        </div>
					<?php }?>
                
                	<form name="renew_form" id="renew_form" method="post">
                    	<input type="hidden" name="customer_id" value="<?php echo $customer_code;?>" />
                    	<input type="hidden" name="policy_class_id" value="1" />
                        <input type="hidden" name="payment_amount" id="payment_amount" value="0" />
                        <div class="rightformpan innerTFl">
                            <h1>Renew Policy</h1>
                            <table width="100%">
                              <tbody>
                                <tr height="20">
                                  <td width="25%">Policy Type : </td>
                                  <td width="75%">
                                    <select name="policy_type_id" id="policy_type_id" class="generalDropDown" onchange="getPolicyNos(this.value);" style="width:68%; float:left;">
                                      <option value="">[--Select--]</option>
                                      <?php $ptypes_qry = mysql_query("select * from ".POLICYTYPES." where status='1'");
                                      while($ptype = mysql_fetch_array($ptypes_qry))
                                      {
                                          echo '<option value="'.$ptype['id'].'">'.stripslashes($ptype['policy_type']).'</option>';
                                      }?>
                                    </select>
                                  </td>
                                </tr>
                                
                                <tr height="20">
                                  <td width="25%">Policy Number : </td>
                                  <td width="75%">
                                      <span id="pno_section">
                                        <select name="policy_no" id="policy_no" class="generalDropDown" style="width:68%" disabled="disabled">
                                            <option value="">[--Select--]</option>
                                          </select>
                                      </span>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2" id="details"></td>
                                </tr>
                                <tr>
                                  <td width="100%" colspan="20" id="pdetail_section">
                                  
                                </td>
                                </tr>
                                
                                
                                
                                <tr>
                                    <td colspan="2">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tbody><tr height="40" class="3">
                                  <td width="25%" class="3">Policy From Date : </td>
                                  <td width="75%">
                                    <input type="text" name="policy_insured_startdate" onchange="getPolicyEndDate(this.value);" id="policy_insured_startdate" disabled="disabled" value="" autocomplete="off" class="generalTextBox calender dis_fld" tabindex="3" style="width:69%; float:left; cursor:text;"  />
                                  </td>
                                </tr>
                                
                                    <tr height="40">
                                      <td>Policy To Date : </td>
                                      <td><div>
                                          <input type="text" name="policy_insured_enddate" id="policy_insured_enddate" readonly="readonly" value="" autocomplete="off" class="generalTextBox calender dis_fld" disabled="disabled" tabindex="3" style="width:69%; float:left; cursor:text;">
                                        </div>
                                        &nbsp;
                                        <div id="date_loading" style="float:left; display:none;"><img src="images/loading.gif" style="height:25px;"></div></td>
                                    </tr>
                                </tbody></table>
                                    </td>
                                </tr>
                                
                              </tbody>
                            </table>
                            
                            <div>
                                <!--<div class="form_area_left_dash_heading" style="width:100%; text-transform:none;">Paypal Payment</div>-->
                                <div class="clearfix" style="height:10px;"></div>
                                <div id="payment_amount_div" style="font-size: 15px;"></div>
                                <div class="clearfix" style="height:10px;"></div>
                                
                                <div style="color: rgb(173, 169, 169);">
                                * Click on the <strong>"Renew"</strong> button to pay using paypal method.
                                </div>
                                <div class="clearfix" style="height:20px;"></div>
                                <?php /*?><div class="row1">
                                    <lable>Card Type</lable>
                                    <div class="clearfix"></div>
                                    <select id="card_type" name="card_type" class="dropdown dis_fld" style="width:61%;" disabled="disabled">
                                        <option value="Visa" selected="selected">Visa</option>
                                        <option value="Master Card">Master Card</option>
                                        <option value="American Express">American Express</option>
                                    </select>
                                </div>
                                
                                <div class="clearfix" style="height:5px;"></div>
                                
                                <div class="row1">
                                    <lable>Card Number</lable>
                                    <div class="clearfix"></div>
                                    <input type="text" name="card_no" autocomplete="off"  id="card_no" class="dis_fld" onkeypress="return isNumberKey(event)" style="width:60%; float:left; cursor:text;" disabled="disabled" />
                                </div>
                                
                                <div class="row1">
                                    <lable>Card Expires</lable>
                                    <div class="clearfix" style="height:5px;"></div>
                                    <input type="text" style="width:27%; float:left;cursor:text;" maxlength="2" class="dis_fld" placeholder="MM" name="card_exp_mm" id="card_exp_mm" onkeypress="return isNumberKey(event)" disabled="disabled" />
                                    
                                    <span style="float:left; padding:13px 15px 0px 15px;font-size: 19px;color: gray;"> / </span>
                                    
                                    <input type="text" style="width:27%; float:left;cursor:text;" placeholder="YYYY" class="dis_fld" maxlength="4" name="card_exp_yy" id="card_exp_yy" onkeypress="return isNumberKey(event)" disabled="disabled" />
                                </div>
                                
                                <div class="clearfix" style="height:10px;"></div>
                                
                                <div class="row1">
                                    <lable>CVV NO</lable>
                                    <div class="clearfix" style="height:5px;"></div>
                                    <input type="text" style="width:37%; float:left;margin-right: 2%;cursor:text;" class="dis_fld" name="cvv_no" id="cvv_no" onkeypress="return isNumberKey(event)" disabled="disabled" />
                                    <img src="images/ccv.png" alt="Security Code Location" style="width: 21%;padding-top: 5px;">
                                </div><?php */?>
                                
                                <input name="renew" value="Renew" class="sub_btn dis_fld" type="submit" onclick="return validRenewForm();" style="text-align: center;width:20%; float:left;  height:35px; line-height:34px;">
                                
                                <div class="clear" style="height:25px;">&nbsp;</div>
                                
                                
                            
                            </div>
                            
                          </div>
                    </form>
                </div>
            <div class="clearfix"></div>
            </div>
           <div class="clearfix" style="height:15px;">.</div>
    </div>
<?php } ?>