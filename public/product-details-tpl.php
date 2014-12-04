<?php
if(isset($_POST['submit']))
{
	unset($_POST['submit']);	
	unset($_POST['save_to_quote']);	
	
	$_POST['first_name'] = addslashes($_POST['first_name']);
	$_POST['last_name'] = addslashes($_POST['last_name']);
	$_POST['email'] = addslashes($_POST['email']);
	
	$_SESSION['motor']['step_2'] = '1';
	
	$_SESSION['motor']['Vehicle'] = $_POST;
	
	//$result = $db->recordInsert($_POST,POLICYMOTOR,'');
	if(!empty($_SESSION['motor']['Vehicle']))
	{
		header('Location: '.BASE_URL.'index.php?page=motor-insurance&step=2');	
	}
}
if(isset($_POST['save_to_quote']))
{
	unset($_POST['submit']);	
	unset($_POST['save_to_quote']);	
	
	/*unset($_POST['first_name']);	
	unset($_POST['last_name']);	
	unset($_POST['email']);	
	unset($_POST['dob']);	
	unset($_POST['country']);*/	
	
	$id = $_SESSION['get_a_quote_id'];
	
	
	$result = $db->recordUpdate(array("id" => $id),$_POST,POLICYQUOTES);
	
	if(!empty($result))
	{
		$msg = 'Saved to quote successfully.';
	}
	else
	{
		$errmsg = 'Failed to save.';	
	}
	
	
}
//get the product details
if($_GET['page']=='product-details-tpl'){
	$product_details = $db->recordFetch('3',PRODUCTS.':id');
	
}
?>


<style>
.msg_box
{
background: #D9DBDD;
padding: 8px 10px;
font-weight: bold;
font-size: 15px;
}
</style>
<script>
function getVehicleModel(vmake)
{
	var data = '';
	$('#vmodel_section').html('Loading...');
	
	if(vmake!='')
	{
		var url = '<?php echo BASE_URL;?>/util/vehicle.php?vehicle_id='+vmake; 
		$.get(url,function(res)
		{
			//alert(res);
			if(res!=0)
			{
				data = res;
			}
			else
			{
				data = '<select id="vehicle_model" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
			}
			$('#vmodel_section').html(data);
		});
	}
	else
	{
		data = '<select id="vehicle_model" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
		$('#vmodel_section').html(data);
	}
	getVehicleType('');
}
function getVehicleType(vmodel)
{
	var data = '';
	$('#vtype_section').html('Loading...');
	
	if(vmodel!='')
	{
		var url = '<?php echo BASE_URL;?>/util/vehicle.php?vehicle_modelid='+vmodel; //alert(url);
		$.get(url,function(res)
		{
			//alert(res);
			if(res!=0)
			{
				data = res;
			}
			else
			{
				data = '<select id="vehicle_model" name="vehicle_model" class="dropdown"><option value="">Select</option></select>';
			}
			$('#vtype_section').html(data);
		});
	}
	else
	{
		data = '<select id="vehicle_type" name="vehicle_type" class="dropdown"><option value="">Select</option></select>';
		$('#vtype_section').html(data);
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

function validTplForm()
{
	var form = document.tpl_form;
	var flag = true;
	var fields = new Array();

	if(form.vehicle_type_tpl.value == '')
	{
		form.vehicle_type_tpl.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_type_tpl');
	}
	else
	{
		form.vehicle_type_tpl.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_regd_place.value == '')
	{
		form.vehicle_regd_place.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_regd_place');
	}
	else
	{
		form.vehicle_regd_place.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_ownership.value == '')
	{
		form.vehicle_ownership.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_ownership');
	}
	else
	{
		form.vehicle_ownership.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_use.value == '')
	{
		form.vehicle_use.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_use');
	}
	else
	{
		form.vehicle_use.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_cylender.value == '')
	{
		form.vehicle_cylender.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_cylender');
	}
	else
	{
		form.vehicle_cylender.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_weight.value == '')
	{
		form.vehicle_weight.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_weight');
	}
	else
	{
		form.vehicle_weight.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_seats.value == '')
	{
		form.vehicle_seats.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_seats');
	}
	else
	{
		form.vehicle_seats.style.borderColor='#B6B6B6';
	}

	/*if(form.vehicle_agency_repair.value == '')
	{
		form.vehicle_agency_repair.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_agency_repair');
	}
	else
	{
		form.vehicle_agency_repair.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_ncd.value == '')
	{
		form.vehicle_ncd.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_ncd');
	}
	else
	{
		form.vehicle_ncd.style.borderColor='#B6B6B6';
	}*/

	if(form.vehicle_purchase_year.value == '')
	{
		form.vehicle_purchase_year.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_purchase_year');
	}
	else
	{
		form.vehicle_purchase_year.style.borderColor='#B6B6B6';
	}

	if(form.first_name.value == '')
	{
		form.first_name.style.borderColor='red';
		flag = false;	
		fields.push('first_name');
	}
	else
	{
		form.first_name.style.borderColor='#B6B6B6';
	}

	if(form.last_name.value == '')
	{
		form.last_name.style.borderColor='red';
		flag = false;	
		fields.push('last_name');
	}
	else
	{
		form.last_name.style.borderColor='#B6B6B6';
	}
	
	if(!validEmail(form.email.value))
	{
		form.email.style.borderColor='red';
		flag = false;	
		fields.push('email');
	}
	else
	{
		form.email.style.borderColor='#B6B6B6';
	}
	
	if(form.mobile_no.value == '')
	{
		form.mobile_no.style.borderColor='red';
		flag = false;	
		fields.push('mobile_no');
	}
	else
	{
		form.mobile_no.style.borderColor='#B6B6B6';
	}
	
	if(form.dob.value == '')
	{
		form.dob.style.borderColor='red';
		flag = false;	
		fields.push('dob');
	}
	else
	{
		form.dob.style.borderColor='#B6B6B6';
	}
	
	if(form.country.value == '')
	{
		form.country.style.borderColor='red';
		flag = false;	
		fields.push('country');
	}
	else
	{
		form.country.style.borderColor='#B6B6B6';
	}
	if(fields.length>0)
	{
		var fld = fields[0];
		
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}

function validQuoteForm()
{
	var form = document.tpl_form;
	var flag = true;
	var fields = new Array();

	if(form.vehicle_type_tpl.value == '')
	{
		form.vehicle_type_tpl.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_type_tpl');
	}
	else
	{
		form.vehicle_type_tpl.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_regd_place.value == '')
	{
		form.vehicle_regd_place.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_regd_place');
	}
	else
	{
		form.vehicle_regd_place.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_ownership.value == '')
	{
		form.vehicle_ownership.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_ownership');
	}
	else
	{
		form.vehicle_ownership.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_use.value == '')
	{
		form.vehicle_use.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_use');
	}
	else
	{
		form.vehicle_use.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_cylender.value == '')
	{
		form.vehicle_cylender.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_cylender');
	}
	else
	{
		form.vehicle_cylender.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_weight.value == '')
	{
		form.vehicle_weight.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_weight');
	}
	else
	{
		form.vehicle_weight.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_seats.value == '')
	{
		form.vehicle_seats.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_seats');
	}
	else
	{
		form.vehicle_seats.style.borderColor='#B6B6B6';
	}

	/*if(form.vehicle_agency_repair.value == '')
	{
		form.vehicle_agency_repair.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_agency_repair');
	}
	else
	{
		form.vehicle_agency_repair.style.borderColor='#B6B6B6';
	}

	if(form.vehicle_ncd.value == '')
	{
		form.vehicle_ncd.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_ncd');
	}
	else
	{
		form.vehicle_ncd.style.borderColor='#B6B6B6';
	}*/

	if(form.vehicle_purchase_year.value == '')
	{
		form.vehicle_purchase_year.style.borderColor='red';
		flag = false;	
		fields.push('vehicle_purchase_year');
	}
	else
	{
		form.vehicle_purchase_year.style.borderColor='#B6B6B6';
	}
	
	/*form.first_name.style.borderColor='#B6B6B6';
	form.last_name.style.borderColor='#B6B6B6';
	form.emil.style.borderColor='#B6B6B6';
	form.mobile_no.style.borderColor='#B6B6B6';
	form.dob.style.borderColor='#B6B6B6';
	form.country.style.borderColor='#B6B6B6';*/
	
	/*if(form.first_name.value == '')
	{
		form.first_name.style.borderColor='red';
		flag = false;	
		fields.push('first_name');
	}
	else
	{
		form.first_name.style.borderColor='#B6B6B6';
	}

	if(form.last_name.value == '')
	{
		form.last_name.style.borderColor='red';
		flag = false;	
		fields.push('last_name');
	}
	else
	{
		form.last_name.style.borderColor='#B6B6B6';
	}
	
	if(!validEmail(form.email.value))
	{
		form.email.style.borderColor='red';
		flag = false;	
		fields.push('email');
	}
	else
	{
		form.email.style.borderColor='#B6B6B6';
	}
	
	if(form.mobile_no.value == '')
	{
		form.mobile_no.style.borderColor='red';
		flag = false;	
		fields.push('mobile_no');
	}
	else
	{
		form.mobile_no.style.borderColor='#B6B6B6';
	}
	
	if(form.dob.value == '')
	{
		form.dob.style.borderColor='red';
		flag = false;	
		fields.push('dob');
	}
	else
	{
		form.dob.style.borderColor='#B6B6B6';
	}
	
	if(form.country.value == '')
	{
		form.country.style.borderColor='red';
		flag = false;	
		fields.push('country');
	}
	else
	{
		form.country.style.borderColor='#B6B6B6';
	}*/
	if(fields.length>0)
	{
		var fld = fields[0];
		
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}
</script>



<div class="innrebodypanel">
    <div class="clearfix" style="height:15px;">.</div>
    <div class="innerwrap">
    
        <div class="breadcrumb" >
            <a itemprop="url" href="<?php echo BASE_URL;?>">Home</a> 
            <span class="breeadset">&#8250;</span>
            <a itemprop="url" href="#">Motor Insurance</a> 
            <span class="breeadset">&#8250;</span>
            <strong>Third Party Liability Motor Insurance</strong>
        </div>
		<?php 
        //Policy quote msg
        $msg = ''; 
        if(!empty($_SESSION['get_a_quote_msg']))
        {
            $msg = $_SESSION['get_a_quote_msg'];	
            unset($_SESSION['get_a_quote_msg']);
        }
        if(!empty($msg))
        {?>
            <div class="msg_box"><?php echo $msg;?></div>
            <div class="clearfix" style="height:15px;"></div>
        <?php }?>
        <!--<div class="lg-3">
            <a href="#"><img src="images/carinsurance1.jpg" alt="" /></a>
            
            <div class="clearfix" style="height:15px;"></div>
            
            <div class="normallist1">
                <h1>Insurance Type</h1>
                <ul>
                    <li><a href="index.php?page=product-details-comprehensive" >Comprehensive </a></li>
                    <li><a href="index.php?page=product-details-tpl" class="active">Third Party Liability</a></li>
                </ul>
            </div>
            
            
            <div class="clearfix" style="height:18px;"></div>
            
            <div class="normallist1">
                <h1>Insurance Type</h1>
                <ul>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        </div>-->
        
        <div class="lg-4">
           <h2><?=stripslashes($product_details['product_title'])?></h2>
            <?=stripslashes($product_details['product_description'])?>
            
            <div id="accordion">
                <div>
                    <h3><a href="#">Key Benefits & Features</a></h3>
                    <div class="clients_expand_bg" style="height:auto;">
                      <?=stripslashes($product_details['product_key'])?>
                    </div>
                </div>
                
                <div>
                    <h3><a href="#">Terms & Conditions</a></h3>
                    <div class="clients_expand_bg" style="height:auto;">
                         <?=stripslashes($product_details['product_terms'])?>
                    </div>
                </div>
                
            </div>
            
            <br />
           
            <a href="<?php echo BASE_URL;?>index.php?page=motor-insurance&step=1">
            <button value="" class="buybtn">Buy Now</button>
            </a>
            <div class="clearfix" style="height:50px;"></div>
        </div>
        
        <div class="lg-5">
            <div class="rightformpan">
                <h1>Get Quote Now</h1>
                <div id="formpan">
					<?php if(!empty($msg))
                    {
                        echo '<font color="green"'.$msg.'</font>';	
                    }
                    if(!empty($errmsg))
                    {
                        echo '<font color="red"'.$errmsg.'</font>';	
                    }?>
                  <form method="post" name="tpl_form" id="tpl_form">
                    <input type="hidden" name="policy_class_id" value="1" />
                    <input type="hidden" name="policy_type_id" value="1" />
                    
                    <div class="row1">
                        <lable>Vehicle Type</lable>
                       <select name="vehicle_type_tpl" id="vehicle_type_tpl"  class="dropdown">
                           <option value="">-Select type-</option>
                           <?php 
                            $vehicletypesql = mysql_query("select * from ".VTYPE." where make_id='0'");
                             ?>
                             <?php while($myrow = mysql_fetch_array($vehicletypesql)): ?>
                            <option value="<?=$myrow["id"]?>"><?=$myrow["type_name"]?></option>
                        <?php endwhile; ?>
                            
                       </select>
                    </div>
                    
                    <div class="row1">
                        <lable>Vehicle Regd. Place</lable>
                        <input type="text" autocomplete="off" name="vehicle_regd_place" id="vehicle_regd_place" value="<?php echo $vehicle_regd_place;?>">
                    </div>
                    
                    <div class="row1">
                        <lable>Vehicle Ownership</lable>
                        <select id="vehicle_ownership" name="vehicle_ownership" class="dropdown">
                            <option value="">Select</option>
                            <option value="Financed" <?php if($vehicle_ownership == 'Financed'){echo 'selected="selected"';}?>>Financed</option>
                            <option value="Owned" <?php if($vehicle_ownership == 'Owned'){echo 'selected="selected"';}?>>Owned</option>
                            <option value="Leased" <?php if($vehicle_ownership == 'Leased'){echo 'selected="selected"';}?>>Leased</option>
                        </select>
                    </div>
                    
                    <div class="row1">
                        <lable>Vehicle Use</lable>
                        <?php /*?><input type="text" autocomplete="off" name="vehicle_use" id="vehicle_use" value="<?php echo $vehicle_use;?>"><?php */?>
                        <select id="vehicle_use" name="vehicle_use" class="dropdown">
                            <option value="">Select</option>
                            <option value="Private" <?php if($vehicle_use == 'Private'){echo 'selected="selected"';}?>>Private</option>
                            <option value="Business" <?php if($vehicle_use == 'Business'){echo 'selected="selected"';}?>>Business</option>
                            <option value="Occasional" <?php if($vehicle_use == 'Occasional'){echo 'selected="selected"';}?>>Occasional</option>
                        </select>
                    </div>
                    
                    <div class="row1">
                        <lable>Vehicle Cylinder </lable>
                        <select name="vehicle_cylender" id="vehicle_cylender"  class="dropdown">
                            <option value="">-Select-</option>
                            <option value="4">4</option>
                            <option value="6">6</option>
                            <option value="8">8</option>
                            <option value="More than 8">More than 8</option>
                        </select>
                    </div>
                    
                    <div class="row1">
                        <lable>Vehicle Weight </lable>
                        <select name="vehicle_weight" id="vehicle_weight"  class="dropdown">
                            <option value="">-Select-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    
                    <div class="row1">
                        <lable>Vehicle Seats</lable>
                        <select name="vehicle_seats" id="vehicle_seats"  class="dropdown">
                            <option value="">-Select-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    
                    <div class="row1">
                        <lable>Purchase year</lable>
                        <select id="vehicle_purchase_year" name="vehicle_purchase_year" class="dropdown">
                        	<option value="">-Select-</option>
                            <?php  $starting_year  =date('Y', strtotime('-20 year'));
                            $ending_year = date('Y'); 
                            
                            for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                if($starting_year == date('Y')) {
                                    echo '<option value="'.$starting_year.'" selected="selected">'.$starting_year.'</option>';
                                } else {
                                    echo '<option value="'.$starting_year.'">'.$starting_year.'</option>';
                                }
                            }  ?>
                        </select>
                    </div>
                    
                    <div class="row1">
                        <lable style="width:100%; font-size:13px; padding-bottom:15px;"><strong>Driver's Information!</strong></lable>
                    </div>
                    
                    <div class="row1">
                        <lable>First Name  *</lable>
                        <input type="text" autocomplete="off" name="first_name" id="first_name">
                    </div>
                    
                    <div class="row1">
                        <lable>Last name </lable>
                        <input type="text" autocomplete="off" name="last_name" id="last_name">
                    </div>
                    
                    <div class="row1">
                        <lable>Email   *</lable>
                        <input type="text" autocomplete="off" name="email" id="email">
                    </div>
                    
                    <div class="row1">
                        <lable>Mobile no   *</lable>
                        <input type="text" autocomplete="off" name="mobile_no" id="mobile_no"  onkeypress="return isNumberKey(event)">
                    </div>
                    
                    
                    <div class="row1">
                        <lable>Date of Birth *</lable>
                        <input type="text" autocomplete="off" class="date_picker" name="dob" id="dob">
                    </div>
                    
                    
                    <div class="row1">
                        <lable>Country  *</lable>
                        <select id="country" name="country" class="dropdown">
                            <option value="">-Select-</option>
                            <option value="AGRA">AGRA</option>
                            <option value="AHMEDABAD">AHMEDABAD</option>
                            <option value="AHMEDNAGAR">AHMEDNAGAR</option>
                            <option value="AJMER">AJMER</option>
                        </select>
                    </div>
                    
                    
                    <div style="font-size: 11px;clear: both; font-family:Arial, Helvetica, sans-serif; position:relative; top:8px;">
                      * Required Fields
                      <br /><br />
                    </div>
                    
                    <div class="clear" style="height:5px;">&nbsp;</div>
                    <?php 
                    //If policy quote added
                    if(!empty($_SESSION['get_a_quote_id']))
                    {?>
                        <input type="submit" class="submit_button" name="submit" value="submit" style="width: 49%;" onclick="return validTplForm();" />
                        <input type="submit" class="submit_button" name="save_to_quote" value="Save To Quote" style="width: 49%;" onclick="return validQuoteForm();" />
                    <?php }
                    else
                    {?>
                        <input type="submit" class="submit_button" name="submit" value="submit" onclick="return validTplForm();" />
                    <?php }?>
                    
                  </form>
                      <div class="clear" style="height:1px;"></div>
                    </div>
            
            </div>
        </div>
    
    <div class="clearfix"></div>
    </div>
    <div class="clearfix" style="height:15px;">.</div>
</div>