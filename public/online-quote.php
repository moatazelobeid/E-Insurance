<?php 
	if(isset($_POST['save']))
	{
		
		// save record
		unset($_POST['save']);
		
		$_POST['dob']=date('Y-m-d H:i:s',strtotime($_POST['dob']));
		$_POST['created_date']=date('Y-m-d H:i:s');
		$_POST['quote_key'] = uniqid();
		$_POST['status'] = 'Open';
		$_POST['country'] = (!empty($_POST['country']))?$_POST['country']:'UAE';
		$result = $db->recordInsert($_POST,POLICYQUOTES,'');
		$lastid = mysql_insert_id();
		$quotekeyid = 'AC/Q/'.date("Y").'/00'.$lastid;
		$insert = $db->recordUpdate(array("id" => $lastid),array("quote_key"=>$quotekeyid),POLICYQUOTES);
		if($insert)
		{
			$msg="<font color='#00CC33'>Qoutation send sucessfully</font>";	
		}else
		{
			$msg="<font color='red'>Qoutation sending Failed</font>";	
		}
	}

?>


<script type="application/javascript">
function get_vehiclemodels(val)
{

	 $.ajax({
         type: "POST",
         url: "util/utils.php",
         data: "vehicle_id="+ val,
         success: function(msg){
			if(msg ==0)
			{
			}
			else
			{
				$("#vehicle_models").html(msg);	
			}
		 }
		});
}
function getType(val)
{

	 $.ajax({
         type: "POST",
         url: "util/utils.php",
         data: "vehicle_modelid="+ val,
         success: function(msg){
			if(msg ==0)
			{
			}
			else
			{
				$("#vehicle_types").html(msg);	
			}
		 }
		});
}

function val_Form()
{
	var str = document.quotation_form;
	var error = "";
	var flag = false;
	var dataArray = new Array();
	var policytype = $('input[name=policy_type_id]:checked').val();
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if(str.first_name.value == "")
	{
		str.first_name.style.borderColor = "RED";
		error += "- Enter Firstname \n";
		flag = false;
		dataArray.push('first_name');
	}
	else
	{
		str.first_name.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.last_name.value == "")
	{
		str.last_name.style.borderColor = "RED";
		error += "- Enter Lastname \n";
		flag = false;
		dataArray.push('last_name');
	}
	else
	{
		str.last_name.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.email.value == "")
	{
		str.email.style.borderColor = "RED";
		error += "- Enter Your Email \n";
		flag = false;
		dataArray.push('email');
	}
	else if(str.email.value.search(filter) == -1)
	{
	    str.email.style.borderColor = "RED";
		error += "- Valid Email Address Is Required  \n";
		$("#email").focus();
		alert(error);
		return false;
		//dataArray.push('email');
	}
	else
	{
		str.email.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.mobile_no.value == "")
	{
		str.mobile_no.style.borderColor = "RED";
		error += "- Enter Phone(M) \n";
		flag = false;
		dataArray.push('mobile_no');
	}
	else if(isNaN(str.mobile_no.value)){
	
	    str.mobile_no.borderColor = "RED";
		error = "- Enter a Valid Phone(M) Number \n";
		$("#mobile_no").focus();
		alert(error);
		return false;

	}
	else
	{
		str.mobile_no.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.dob.value == "")
	{
		str.dob.style.borderColor = "RED";
		error += "- Enter Your Date of Birth \n";
		flag = false;
		dataArray.push('dob');
	}
	else
	{
		str.dob.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}
	if(str.country.value == "")
	{
		str.country.style.borderColor = "RED";
		error += "- Enter Your Country \n";
		flag = false;
		dataArray.push('country');
	}
	else
	{
		str.country.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}

	if(flag == false)
	{
		alert(error);
		str.elements[dataArray[0]].focus();
		
	}
	else
	{
		document.getElementById("quotation_form").submit();
	}
}

function showMakeModel(val)
{

	if(val==1)
	{
		$("#insurance_tpl").show();
		$("#insurance_comprehensive").hide();
	}
	if(val==2)
	{
		$("#insurance_tpl").hide();
		$("#insurance_comprehensive").show();
	}
}
</script>

<div id="signup-form">
<?php if(isset($msg))
		{ ?>
		<div><span><?=$msg?></span></div>
 <?php }?>
<!--BEGIN #subscribe-inner -->
        <div id="signup-inner">
        
        	<div class="clearfix" id="header">
                <h1>Insurance Quotation Form!</h1>
            </div>            
            <form id="quotation_form" name="quotation_form" action=""  method="post">
            	
                <p>
				 <label for="Insurance type">Insurance type *</label>
                <?php 
				$policysql = mysql_query("select * from ".POLICYTYPES." where policy_id='1'");
				 ?>
                 <input type="hidden" name="policy_class_id" id="policy_class_id" value="1"  />
                <?php while($row = mysql_fetch_array($policysql)): ?>
                <input type="radio" id="policy_typ_id" name="policy_type_id" class="radio" onclick="showMakeModel(this.value)" value="<?=$row['id']?>" <?=($row['id'] == 2)?'checked=checked':''?> style=" width: 13%;" /><span style=" margin-left: -18px; "><?php echo $row['policy_type']; ?></span>
                <?php endwhile; ?>
                </p>
                <span id="insurance_comprehensive">
                <p>
                <label for="Vehicle make">Vehicle make</label>
               <select name="vehicle_make" id="vehicle_make" onChange="get_vehiclemodels(this.value)" style="width:60%;">
               <option value="">-Select type-</option>
               <?php 
				$vehiclemakesql = mysql_query("select * from ".VMAKE." where status='1'");
				 ?>
				 <?php while($myrow = mysql_fetch_array($vehiclemakesql)): ?>
                	<option value="<?=$myrow["id"]?>"><?=$myrow["make"]?></option>
                <?php endwhile; ?>
               		
               </select>
                </p>
                <span id="vehicle_models">
                 <p>
                <label for="Vehicle model">Vehicle Model</label>
               <select name="vehicle_model" id="vehicle_model" disabled style="width:60%;">
                <option value="">-Select type-</option>
               </select>
                </p>
                </span>
                <span id="vehicle_types">
                 <p>
                <label for="Vehicle model">Vehicle Type</label>
               <select name="vehicle_type" id="vehicle_type_" disabled style="width:60%;">
                <option value="">-Select type-</option>
               </select>
                </p>
                </span>
                <p>

                <label for="email">Agency Repair </label>
                <input type="radio" id="radio" class="radio" name="vehicle_agency_repair" value="Yes" style=" width: 13%;" /><span>Yes</span> <input type="radio" class="radio" id="radio" name="vehicle_agency_repair" value="No" style=" width: 13%;" /><span>No</span>
                </p>
                
                <p>
                <label for="No Claim Discount">No Claim Discount (NCD) :</label>
               <select name="vehicle_ncd" id="vehicle_ncd" style="width:60%;">
                <option value="">-Select-</option>
             	<option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                
                </select>
                </p>
                
             
               </span>
                <span id="insurance_tpl" style="display:none;">
                	 <p>
                    <label for="Vehicle type">Vehicle Type :</label>
                   <select name="vehicle_type_tpl" id="vehicle_type_tpl"  style="width:60%;">
                   <option value="">-Select type-</option>
                   <?php 
                    $vehicletypesql = mysql_query("select * from ".VTYPE." where make_id='0'");
                     ?>
                     <?php while($myrow = mysql_fetch_array($vehicletypesql)): ?>
                        <option value="<?=$myrow["id"]?>"><?=$myrow["type_name"]?></option>
                    <?php endwhile; ?>
                        
                   </select>
                    </p>
                    
                     <p>
                    <label for="Vehicle cynlinder">Vehicle Cylinder :</label>
                   <select name="vehicle_cylender" id="vehicle_cylender"  style="width:60%;">
                   <option value="">-Select-</option>
                   <option value="4">4</option>
                    <option value="6">6</option>
                     <option value="8">8</option>
                      <option value="More than 8">More than 8</option>
                   </select>
                    </p>
                     <p>
                    <label for="Vehicle weights">Vehicle Weight(tons):</label>
                   <select name="vehicle_weight" id="vehicle_weight"  style="width:60%;">
                   <option value="">-Select-</option>
                   <option value="1">1</option>
                    <option value="2">2</option>
                     <option value="3">3</option>
                      <option value="4">4</option>
                   </select>
                    </p>
                     <p>
                    <label for="Vehicle cynlinder">Vehicle Seats :</label>
                   <select name="vehicle_seats" id="vehicle_seats"  style="width:60%;">
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
                    </p>
                </span>
                   <p>
                <label for="No Claim Discount">Purchase year :</label>
               <select name="vehicle_purchase_year" id="vehicle_purchase_year" style="width:60%;">
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
                </p>
                <h2 style="border-bottom: 1px solid #efefef;">Driver's Information!</h2>
                <p>
                <label for="Fname">Firstname *</label>
                <input id="first_name" type="text" name="first_name" value="" />
                </p>
                 <p>
                <label for="lname">Last Name *</label>
                <input id="last_name" type="text" name="last_name" value="" />
                </p>
                
                 <p>
                <label for="lname">Email *</label>
                <input id="email" type="text" name="email" value="" />
                </p>
                
                 <p>
                <label for="mobile_no">Mobile no *</label>
                <input id="mobile_no" type="text" name="mobile_no" value="" />
                </p>
                
                 <p>
                <label for="dob">Date of Birth *</label>
                <input id="dob" type="text" autocomplete="off" class="dateofbirth" name="dob" value="" />
                </p>
                 <p>
                <label for="Country">Country *</label>
                <input id="country" type="text" name="country" value="" />
                </p>
          
                <p>
				<input type="hidden" name="save" id="save" />
                <input type="button" value="Submit" onclick="val_Form();" name="save" id="save"  />
                </p>
                
            </form>
            
		<div id="required">
		<p>* Required Fields<br/></p>
		</div>


            </div>
        
        <!--END #signup-inner -->
        </div>
        
    <!--END #signup-form -->   
