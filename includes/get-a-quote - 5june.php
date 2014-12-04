<?php
// call class instance
$db = new dbFactory();

if(isset($_POST['submit_quote']))
{
	unset($_POST['submit_quote']);	
	$_POST['created_date']=date('Y-m-d H:i:s');
	$_POST['first_name'] = addslashes($_POST['first_name']);
	$_POST['last_name'] = addslashes($_POST['last_name']);
	$_POST['email'] = addslashes($_POST['email']);
	$_POST['iqma_no'] = addslashes($_POST['iqma_no']);
	$_POST['quote_key'] = uniqid();
	
	//Insert into policy quote table
	$result = $db->recordInsert($_POST,POLICYQUOTES,'');
	
	if(!empty($result))
	{
		$lastid = mysql_insert_id();
		$quotekeyid = 'AC/Q/'.date("Y").'/00'.$lastid;
		$insert = $db->recordUpdate(array("id" => $lastid),array("quote_key"=>$quotekeyid),POLICYQUOTES);
		
		$_SESSION['get_a_quote_id'] = $lastid;
		$_SESSION['get_a_quote_msg'] = '<font color="#00CC33">Qoutation send sucessfully.</font>';
	}
	else
	{
		$_SESSION['get_a_quote_msg'] = '<font color="#00CC33">Qoutation sending Failed.</font>';	
	}
	if($_POST['policy_type_id'] == 1)
		header('Location: '.BASE_URL.'index.php?page=product-details-tpl');	
	if($_POST['policy_type_id'] == 2)
		header('Location: '.BASE_URL.'index.php?page=product-details-comprehensive');	
}
?>
<script>

function showColumn(val, id)
{
	if(val == 1)
	{
		$('.vtype_comp_'+id).hide();
		$('.vtype_tpl_'+id).show();
	}	
	if(val == 2)
	{
		$('.vtype_comp_'+id).show();
		$('.vtype_tpl_'+id).hide();
	}	
}
function getVehicleModel(vmake,id)
{
	var data = '';
	$('#vmodel_section_'+id).html('Loading...');
	
	if(vmake!='')
	{
		var url = '<?php echo BASE_URL;?>/util/vehicle.php?vehicle_id='+vmake+'&vno='+id; 
		$.get(url,function(res)
		{
			//alert(res);
			if(res!=0)
			{
				data = res;
			}
			else
			{
				data = '<select id="vehicle_model_'+id+'" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
			}
			$('#vmodel_section_'+id).html(data);
		});
	}
	else
	{
		data = '<select id="vehicle_model_'+id+'" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
		$('#vmodel_section_'+id).html(data);
	}
	getVehicleType('',id);
}
function getVehicleType(vmodel,id)
{
	var data = '';
	$('#vtype_section_'+id).html('Loading...');
	
	if(vmodel!='')
	{
		var url = '<?php echo BASE_URL;?>/util/vehicle.php?vehicle_modelid='+vmodel+'&vno='+id; //alert(url);
		$.get(url,function(res)
		{
			//alert(res);
			if(res!=0)
			{
				data = res;
			}
			else
			{
				data = '<select id="vehicle_model_'+id+'" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
			}
			$('#vtype_section_'+id).html(data);
		});
	}
	else
	{
		data = '<select id="vehicle_type_'+id+'" name="vehicle_type" class="dropdown"><option value="">Select</option></select>';
		$('#vtype_section_'+id).html(data);
	}
}

function validEmail(x)
{ 
	var atpos=x.indexOf("@");

	var dotpos=x.lastIndexOf(".");

	if(atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
		return false;
	}
	else
	{
		return true;	
	}
}
      
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

 return true;
}
	  
function validGetAQuoteForm()
{
	var form = document.get_a_quote;
	var flag = true;
	var fields = new Array();
	if(form.first_name.value == '')
	{
		form.first_name.style.borderColor='red';
		flag = false;	
		fields.push('first_name');
	}
	else
	{
		form.first_name.style.borderColor='#FFF';
	}
	if(form.last_name.value == '')
	{
		form.last_name.style.borderColor='red';
		flag = false;	
		fields.push('last_name');
	}
	else
	{
		form.last_name.style.borderColor='#FFF';
	}
	if(!validEmail(form.email.value))
	{
		form.email.style.borderColor='red';
		flag = false;	
		fields.push('email');
	}
	else
	{
		form.email.style.borderColor='#FFF';
	}
	if(form.mobile_no.value == '')
	{
		form.mobile_no.style.borderColor='red';
		flag = false;	
		fields.push('mobile_no');
	}
	else
	{
		form.mobile_no.style.borderColor='#FFF';
	}
	if(form.iqma_no.value == '')
	{
		form.iqma_no.style.borderColor='red';
		flag = false;	
		fields.push('iqma_no');
	}
	else
	{
		form.iqma_no.style.borderColor='#FFF';
	}
	if(form.policy_type_id.value == '')
	{
		form.policy_type_id.style.borderColor='red';
		flag = false;	
		fields.push('policy_type_id');
	}
	else
	{
		form.policy_type_id.style.borderColor='#FFF';
	}

	if(fields.length>0)
	{
		var fld = fields[0];
		
		//form.first_name.focus();
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}
</script>
<style>
select
{
	height: 29px;
	width: 194px;
	margin: 3px 0 4px 0;	
}
</style>
<div>
    <div id="home-form" class="yakeendown brownbox">
        <h2 id="getquote" style="text-align:center;">
            Get A Quote
        </h2>
        <form id="get_a_quote" name="get_a_quote" method="post">
        	<input type="hidden" name="policy_class_id" value="1" />
            <div id="step-1">
                <div class="form-row-medical">
                	<input id="first_name" name="first_name" placeholder="First Name" type="text">
                </div>
                <div class="form-row-medical">
                	<input id="last_name" name="last_name" placeholder="Last Name" type="text">
                </div>
                <div class="form-row-medical">
                	<input id="email" name="email" placeholder="Email" type="text">
                </div>
                <div class="form-row-medical">
                	<input id="mobile_no" name="mobile_no" placeholder="Mobile Number" type="text" onkeypress="return isNumberKey(event)">
                </div>
                <div class="form-row-medical">
                	<input id="iqma_no" name="iqma_no" placeholder="IQMA Number/Saudi/Company Id" type="text">
                </div>
                <div class="form-row-medical">
                	<select name="policy_type_id" id="policy_type_id">
                    	<option value="">Insurance type</option>
						<?php
                        $policy_types_sql = "select a.* from ".POLICYTYPES." as a inner join ".PRODUCTS." as b on a.policy_id=b.id where a.status='1' order by a.policy_type asc";
						$policy_types = mysql_query($policy_types_sql);
						while($policy_type = mysql_fetch_array($policy_types))
						{?>
                        	<option value="<?php echo $policy_type['id'];?>"><?php echo $policy_type['policy_type'];?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div style="margin-top:10px;"></div>
                <div class="form-row" style="margin-top: 10px;" id="CartSubmit">
                    <button type="submit" id="submit3" name="submit_quote" class="submit" onclick="return validGetAQuoteForm();">
                    	Submit
                    </button>
                </div>
            </div>
        </form>
        <div id="SponsorDivToolTip" style="left: 220px; display: none;">
            A verification code will be sent to this mobile number
        </div>
    </div>
</div>
