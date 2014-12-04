<?php 
// Get the Product ID //
$product_id = array_shift(mysql_fetch_array(mysql_query("SELECT id FROM ".PRODUCTS." WHERE policy_class_id = '".$_GET['policy_id']."' AND policy_type_id = '".$_GET['policytype']."'")));

if(isset($_POST['save']))
{
	$latest_qt = mysql_fetch_object(mysql_query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_NAME = '".PACKAGE."'"));
	$package_no = 'ALSPKG000'.$latest_qt->AUTO_INCREMENT;
	
	$PST = array();
	$PST['product_id'] = $product_id;
	$PST['package_no'] = $package_no;
	$PST['policy_type_id'] = $_GET['policytype'];
	$PST['policy_type'] = 'tpl';
	$PST['package_title'] = $_POST['package_title'];
	$PST['package_title_ar'] = $_POST['package_title_ar'];
	$PST['package_desc'] = $_POST['package_desc'];
	$PST['package_desc_ar'] = $_POST['package_desc_ar'];
		
	//$PST['vehicle_seats_tpl'] = $_POST['vehicle_seats_tpl'];
	//$PST['vehicle_weight_tpl'] = $_POST['vehicle_weight_tpl'];
	//$PST['vehicle_cylender_tpl'] = $_POST['vehicle_cylender_tpl'];
	$PST['vehicle_type_tpl'] = $_POST['vehicle_type_tpl'];
	$PST['driver_age'] = $_POST['driver_age'];
	$PST['policy_use'] = $_POST['policy_use'];
	
	
	$PST['package_amt'] = $_POST['package_amount'];
	//$PST['psngr_price'] = $_POST['psngr_price'];
	$PST['created_date'] = date("Y-m-d H:i:s");
	
	// INSERT into Package Table //
	$result = $db->recordInsert($PST,PACKAGE,'');
	
	//Insert package price for driver ages
	/*if(!empty($_POST['price']))
	{
		for($i=0; $i<count($_POST['price']);$i++)
		{
			$pkg_price = '';
			$pkg_price['package_no'] = $package_no;
			$pkg_price['driver_age'] = $_POST['driver_age'][$i];
			$pkg_price['price'] = $_POST['price'][$i];
			if(!empty($_POST['price'][$i]))
			{
				$db->recordInsert($pkg_price,PACKAGEPRICE,'');
			}
		}
	}*/
	
	
	// Intsert to Coverage Table //
	$sql_covers4 = mysql_query("SELECT * FROM ".PRODUCTCOVERS." WHERE product_id = '".$product_id."'");
	if(mysql_num_rows($sql_covers4) > 0)
	{
	  while($arr_covers4 = mysql_fetch_array($sql_covers4))
	  {
		  if($_POST['cover_'.$arr_covers4['id']] == '1')
		  {
			  $insert_qury = mysql_query("INSERT INTO ".PACKAGECOVER." (package_no, cover_id, cover_amt, coverage) VALUES ('".$package_no."', '".$arr_covers4['id']."', '".$_POST['cover_'.$arr_covers4['id'].'_amt']."', '".$_POST['cover_'.$arr_covers4['id'].'_note']."')") or die(mysql_error());  
		  }
	  }
	  if(mysql_affected_rows() > 0)
	  {
		 header("Location:account.php?page=package_list&added");  
	  }
	}
}



if(isset($_POST['update']))
{
	$latest_qt = mysql_fetch_object(mysql_query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_NAME = '".PACKAGE."'"));
	$package_no = 'ALSPKG000'.$latest_qt->AUTO_INCREMENT;
	
	$PST = array();
	$PST['policy_type'] = 'tpl';
	$PST['package_title'] = $_POST['package_title'];
	$PST['package_title_ar'] = $_POST['package_title_ar'];
	$PST['package_desc'] = $_POST['package_desc'];
	$PST['package_desc_ar'] = $_POST['package_desc_ar'];
		
	//$PST['vehicle_seats_tpl'] = $_POST['vehicle_seats_tpl'];
	//$PST['vehicle_weight_tpl'] = $_POST['vehicle_weight_tpl'];
	//$PST['vehicle_cylender_tpl'] = $_POST['vehicle_cylender_tpl'];
	$PST['vehicle_type_tpl'] = $_POST['vehicle_type_tpl'];
	$PST['driver_age'] = $_POST['driver_age'];
	$PST['policy_use'] = $_POST['policy_use'];
	$PST['package_amt'] = $_POST['policy_amount'];
	//$PST['psngr_price'] = $_POST['psngr_price'];
	
	$PST['created_date'] = date("Y-m-d H:i:s");
	
//print_r($PST);
		// Update into Package Table //
	$result = $db->recordUpdate(array('id'=>$_GET['id']),$PST,PACKAGE,'');
	
	// Get Package No.//
	$package_no = array_shift(mysql_fetch_array(mysql_query("SELECT package_no FROM ".PACKAGE." WHERE id = '".$_GET['id']."'")));
	
	//Update package price for driver ages
	
	//delete previous price setting
	/*$db->recordDelete(array('package_no' => $package_no),PACKAGEPRICE);
	
	if(!empty($_POST['price']))
	{
		for($i=0; $i<count($_POST['price']);$i++)
		{
			$pkg_price = '';
			$pkg_price['package_no'] = $package_no;
			$pkg_price['driver_age'] = $_POST['driver_age'][$i];
			$pkg_price['price'] = $_POST['price'][$i];
			if(!empty($_POST['price'][$i]))
			{
				$db->recordInsert($pkg_price,PACKAGEPRICE,'');
			}
		}
	}*/
	
	
	// Delete Old Covers  //
	mysql_query("DELETE FROM ".PACKAGECOVER." WHERE package_no = '".$package_no."'");
	
	
	// Intsert to Coverage Table //
	$sql_covers4 = mysql_query("SELECT * FROM ".PRODUCTCOVERS." WHERE product_id = '".$product_id."'");
	if(mysql_num_rows($sql_covers4) > 0)
	{
	  while($arr_covers4 = mysql_fetch_array($sql_covers4))
	  {
		  if($_POST['cover_'.$arr_covers4['id']] == '1')
		  {
			  $insert_qury = mysql_query("INSERT INTO ".PACKAGECOVER." (package_no, cover_id, cover_amt, coverage) VALUES ('".$package_no."', '".$arr_covers4['id']."', '".$_POST['cover_'.$arr_covers4['id'].'_amt']."', '".$_POST['cover_'.$arr_covers4['id'].'_note']."')") or die(mysql_error());  
		  }
	  }
	  if(mysql_affected_rows() > 0)
	  {
		 header("Location:account.php?page=package_list&updated");  
	  }
	}
}


if($_GET['task'] == 'package_edit' && $_GET['id'] != '')
{
  $sql_edit = mysql_fetch_object(mysql_query("SELECT * FROM ".PACKAGE." WHERE id = '".$_GET['id']."'"));
  $package_no = $sql_edit->package_no;
}
?>
<script type="text/javascript">
function checkShowStatus(this1)
{
	var thisid = this1.name;
	if(this1.value == 0)
	{
		//alert(0);
		document.getElementById(thisid + '_div').style.display = 'none';
	}else  if(this1.value == 1)
	{
		//alert(1);
		document.getElementById(thisid + '_div').style.display = 'block';
	}
}
function validatePackageForm()
{
  
	var form=document.package_form;
	if(form.package_title.value == "")
	{ 
		form.package_title.style.borderColor = "RED";
		form.package_title.focus();
		document.getElementById("invalid_title").innerHTML='Enter Title<br/>';
		return false;
	}
	else
	{
		form.package_title.style.borderColor = "";
		document.getElementById("invalid_title").innerHTML='';
	}
	if(form.package_desc.value == "")
	{ 
		form.package_desc.style.borderColor = "RED";
		form.package_desc.focus();
		document.getElementById("invalid_description").innerHTML='Enter Description<br/>';
		return false;
	}
	else
	{
		form.package_desc.style.borderColor = "";
		document.getElementById("invalid_description").innerHTML='';
	}
	
	
	
	
	
	if(form.policy_use.value == "")
	{ 
		form.policy_use.style.borderColor = "RED";
		form.policy_use.focus();
		document.getElementById("invalid_policy_use").innerHTML='Select Policy Use<br/>';
		return false;
	}
	else
	{
		form.policy_use.style.borderColor = "";
		document.getElementById("invalid_policy_use").innerHTML='';
	}
	
	if(form.vehicle_type_tpl.value == "")
	{ 
		form.vehicle_type_tpl.style.borderColor = "RED";
		form.vehicle_type_tpl.focus();
		document.getElementById("invalid_vehicle_type_tpl").innerHTML='Select Car Type<br/>';
		return false;
	}
	else
	{
		form.vehicle_type_tpl.style.borderColor = "";
		document.getElementById("invalid_vehicle_type_tpl").innerHTML='';
	}
	
	if(form.driver_age.value == "")
	{ 
		form.driver_age.style.borderColor = "RED";
		form.driver_age.focus();
		document.getElementById("invalid_driver_age").innerHTML='Select Driver age<br/>';
		return false;
	}
	else
	{
		form.driver_age.style.borderColor = "";
		document.getElementById("invalid_driver_age").innerHTML='';
	}
	
	if(form.policy_amount.value == "")
	{ 
		form.policy_amount.style.borderColor = "RED";
		form.policy_amount.focus();
		document.getElementById("invalid_policy_amount").innerHTML='Enter premium amount<br/>';
		return false;
	}
	else
	{
		
		/*if(form.policy_amount.value > "10000")
		{ 
			form.policy_amount.style.borderColor = "RED";
			form.policy_amount.focus();
			document.getElementById("invalid_policy_amount").innerHTML='Premium amount cannot exceed 10,000<br/>';
			return false;
		}*/
		form.policy_amount.style.borderColor = "";
		document.getElementById("invalid_policy_amount").innerHTML='';
	}
	
	if(form.vehicle_cylender_tpl.value == "")
	{ 
		form.vehicle_cylender_tpl.style.borderColor = "RED";
		form.vehicle_cylender_tpl.focus();
		document.getElementById("invalid_vehicle_cylender_tpl").innerHTML='Select Specifications (Cylender)<br/>';
		return false;
	}
	else
	{
		form.vehicle_cylender_tpl.style.borderColor = "";
		document.getElementById("invalid_vehicle_cylender_tpl").innerHTML='';
	}
	
	if(form.vehicle_weight_tpl.value == "")
	{ 
		form.vehicle_weight_tpl.style.borderColor = "RED";
		form.vehicle_weight_tpl.focus();
		document.getElementById("invalid_vehicle_weight_tpl").innerHTML='Select Weight of the Vehicle<br/>';
		return false;
	}
	else
	{
		form.vehicle_weight_tpl.style.borderColor = "";
		document.getElementById("invalid_vehicle_weight_tpl").innerHTML='';
	}
	
	if(form.vehicle_seats_tpl.value == "")
	{ 
		form.vehicle_seats_tpl.style.borderColor = "RED";
		form.vehicle_seats_tpl.focus();
		document.getElementById("invalid_vehicle_seats_tpl").innerHTML='Select Vehicle Seats<br/>';
		return false;
	}
	else
	{
		form.vehicle_seats_tpl.style.borderColor = "";
		document.getElementById("invalid_vehicle_seats_tpl").innerHTML='';
	}
	
	
	<?php 
	$sql_covers2 = mysql_query("SELECT * FROM ".PRODUCTCOVERS." WHERE product_id = '".$product_id."'");
	if(mysql_num_rows($sql_covers2) > 0)
	{
	  while($arr_covers2 = mysql_fetch_array($sql_covers2))
	  { ?>
	  
			if($('input:radio[name=cover_<?php echo $arr_covers2['id'];?>]:checked').val()== 1)
			{
				<?php if($arr_covers2['is_price'] == '1'){?>
				if(form.cover_<?php echo $arr_covers2['id'];?>_amt.value == '')
				{
					form.cover_<?php echo $arr_covers2['id'];?>_amt.style.borderColor = "RED";
					form.cover_<?php echo $arr_covers2['id'];?>_amt.focus();
					document.getElementById("invalid_cover_<?php echo $arr_covers2['id'];?>_amt").innerHTML='Enter Amount<br>';
					return false;
				}
				else
				{
					form.cover_<?php echo $arr_covers2['id'];?>_amt.style.borderColor = "";
					document.getElementById("invalid_cover_<?php echo $arr_covers2['id'];?>_amt").innerHTML='';
				}
					<?php }?>
			}
			
			
			
	 		if($('input:radio[name=cover_<?php echo $arr_covers2['id'];?>]:checked').val()== 1)
			{
				<?php if($arr_covers2['benefits_type'] == 'key'){?>
				if(form.cover_<?php echo $arr_covers2['id'];?>_note.value == '')
				{
					form.cover_<?php echo $arr_covers2['id'];?>_note.style.borderColor = "RED";
					form.cover_<?php echo $arr_covers2['id'];?>_note.focus();
					document.getElementById("invalid_cover_<?php echo $arr_covers2['id'];?>_note").innerHTML='Enter Coverage<br>';
					return false;
				}
				else
				{
					form.cover_<?php echo $arr_covers2['id'];?>_note.style.borderColor = "";
					document.getElementById("invalid_cover_<?php echo $arr_covers2['id'];?>_note").innerHTML='';
				}
				<?php }?>
			}
			
	  
	  <?php } }?>
	  getPolicyAmount();	
}

function getPolicyAmount()
{
	var form=document.package_form;
	var total=0;
	
	
	<?php 
	$sql_covers3 = mysql_query("SELECT * FROM ".PRODUCTCOVERS." WHERE product_id = '".$product_id."'");
	if(mysql_num_rows($sql_covers3) > 0)
	{
	  while($arr_covers3 = mysql_fetch_array($sql_covers3))
	  { ?>
	  
	  if($('input:radio[name=cover_<?php echo $arr_covers3['id'];?>]:checked').val()== 1 && form.cover_<?php echo $arr_covers3['id'];?>_amt.value != '')
	  total=total+parseInt(form.cover_<?php echo $arr_covers3['id'];?>_amt.value);
	  
	  <?php } }?>
	  form.policy_amount.value=total;
}


function getModel(makeid)
{
    //alert(makeid);
	url="<?php echo BASE_URL;?>util/utils.php?makeid_val="+makeid;

	$.post(url,function(data){
		//alert(data);
		$('#model_comp_div').html(data);
	});
}

function getType(model_id)
{
    //alert(makeid);
	url="<?php echo BASE_URL;?>util/utils.php?model_id="+model_id;
	$.post(url,function(data){
		//alert(data);
		$('#type_comp_div').html(data);
	});
}
function getPolicyType(use)
{
	var data = '';
	$('#vtype_section').html('Loading...');
	
	if(use!='')
	{
		var url = '<?php echo BASE_URL;?>/util/utils.php?use='+use; //alert(url);
		$.get(url,function(res)
		{
			//alert(res);
			if(res!=0)
			{
				data = res;
			}
			else
			{
				data = '<select id="vehicle_type_tpl" name="vehicle_type_tpl" class="dropdown" style="width: 335px; font-weight: normal;"><option value="">--SELECT--</option></select>';
			}
			$('#vtype_section').html(data);
		});
	}
	else
	{
		data = '<select id="vehicle_type_tpl" name="vehicle_type_tpl" class="dropdown" style="width: 335px; font-weight: normal;"><option value="">--SELECT--</option></select>';
		$('#vtype_section').html(data);
	}
}

</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<fieldset>
	<legend style="background-color: rgba(2, 2, 2, 0.33);">Basic Policy Information</legend>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="56%" valign="top" style="padding-right: 15px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="17%">Package Title (EN):</td>
            <td width="83%">
              <span id="invalid_title" class="invalimsg" style="color:#FF0000;"></span>
              <input name="package_title" type="text" class="textbox" id="package_title" style="width: 327px;" value="<?php echo stripslashes($sql_edit->package_title); ?>"/>
            </td>
          </tr>
          <tr>
            <td width="17%">Package Title (AR):</td>
            <td width="83%">
              
              <input name="package_title_ar" type="text" class="textbox" id="package_title_ar" style="width: 327px;" value="<?php echo stripslashes($sql_edit->package_title_ar); ?>"/>
            </td>
          </tr>
          
          <tr>
            <td valign="top">Package Description (EN): </td>
            <td>
            <span id="invalid_description" class="invalimsg" style="color:#FF0000;"></span>
              <textarea name="package_desc" id="package_desc" class="textbox" style="width: 327px;"><?php echo stripslashes($sql_edit->package_desc); ?></textarea>
            </td>
          </tr>
          
          <tr>
            <td valign="top">Package Description (AR): </td>
            <td>
              <textarea name="package_desc_ar" id="package_desc_ar" class="textbox" style="width: 327px;"><?php echo stripslashes($sql_edit->package_desc_ar); ?></textarea>
            </td>
          </tr>
          
          <tr>
            <td>Policy Use: </td>
            <td>
              <span style="color:#FF0000" id="invalid_policy_use"></span>
              <select name="policy_use" id="policy_use" class="generalTextBox_white required"  style="height:25px; width:335px;" onchange="getPolicyType(this.value);">
             <option value="">---SELECT---</option>
             <?php $puse_sqll = mysql_query("SELECT * FROM ".POLICYUSE." where status='1'");
                   while($puse = mysql_fetch_array($puse_sqll))
                   {?>
                   <option value="<?php echo $puse['id'];?>" <?php if($puse['id'] == $sql_edit->policy_use){echo 'selected="selected"';}?>><?php echo $puse['name'];?></option>
                   <?php }?> 
             </select>
           </td>
          </tr>
          <tr>
            <td>Car Type: </td>
            <td>
              <span style="color:#FF0000" id="invalid_vehicle_type_tpl"></span>
              <span id="vtype_section">
              <select name="vehicle_type_tpl" id="vehicle_type_tpl" class="generalTextBox_white required"  style="height:25px; width:335px;">
             <option value="">---SELECT---</option>
             <?php $sqll = mysql_query("SELECT * FROM ".VTYPE." WHERE status = '1' AND is_tpl_comp = 'tpl' and vehicle_use='".$sql_edit->policy_use."'");
                   while($arr = mysql_fetch_array($sqll))
                   {?>
                   <option value="<?php echo $arr['id'];?>" <?php if($arr['id'] == $sql_edit->vehicle_type_tpl){echo "selected";}?>><?php echo $arr['type_name'];?></option>
                   <?php }?> 
             </select>
             </span>
           </td>
          </tr>
          
          <tr>
            <td>Driver Age: </td>
            <td>
              <span style="color:#FF0000" id="invalid_driver_age"></span>
              <select name="driver_age" id="driver_age" class="generalTextBox_white required"  style="height:25px; width:335px;">
             <option value="">---SELECT---</option>
             <?php $drage_sqll = mysql_query("SELECT * FROM ".DRIVERAGE."");
                   while($driver_ages = mysql_fetch_array($drage_sqll))
                   {?>
                   <option value="<?php echo $driver_ages['id'];?>" <?php if($driver_ages['id'] == $sql_edit->driver_age){echo "selected";}?>><?php echo $driver_ages['age'];?></option>
                   <?php }?> 
             </select>
           </td>
          </tr>
          
      <tr>
         <td class="whitetxt" valign="middle">
         Premium Amount (SR):</td>
         <td class="whitetxt" valign="middle">
         <span style="color:#FF0000" id="invalid_policy_amount"></span>
         <input type="text" id="policy_amount" name="policy_amount"  class="textbox" value="<?php echo $sql_edit->package_amt;?>" style="width: 327px;"/>
         </td>
      </tr>
          
         <?php /*?> <tr>
            <td>Specification (Cylinders) : </td>
            <td>
            <span style="color:#FF0000" id="invalid_vehicle_cylender_tpl"></span>
             <select name="vehicle_cylender_tpl" id="vehicle_cylender_tpl" class="generalTextBox_white required"  style="height:25px; width:335px;">
              <option value="">---SELECT---</option>
              <option value="4" <?php if($sql_edit->vehicle_cylender_tpl == '4'){echo "selected";}?>>4</option>
              <option value="6" <?php if($sql_edit->vehicle_cylender_tpl == '6'){echo "selected";}?>>6</option>
              <option value="8" <?php if($sql_edit->vehicle_cylender_tpl == '9'){echo "selected";}?>>8</option>
              <option value="More than 8" <?php if($sql_edit->vehicle_cylender_tpl == 'More than 8'){echo "selected";}?>>More than 8</option>
              </select>
           </td>
          </tr>
          
          
            <tr>
            <td>Weight of the Vehicle (tons) : </td>
            <td>
            <span style="color:#FF0000" id="invalid_vehicle_weight_tpl"></span>
             <select name="vehicle_weight_tpl" id="vehicle_weight_tpl" class="generalTextBox_white required"  style="height:25px; width:335px;">
              <option value="">---SELECT---</option>
              <option value="1" <?php if($sql_edit->vehicle_weight_tpl == '1'){echo "selected";}?>>1</option>
              <option value="2" <?php if($sql_edit->vehicle_weight_tpl == '2'){echo "selected";}?>>2</option>
              <option value="3" <?php if($sql_edit->vehicle_weight_tpl == '3'){echo "selected";}?>>3</option>
              <option value="4" <?php if($sql_edit->vehicle_weight_tpl == '4'){echo "selected";}?>>4</option>
             </select>
			</td>
          </tr>
          
          
          <tr>
            <td>Number of Seats: </td>
            <td>
             <span style="color:#FF0000" id="invalid_vehicle_seats_tpl"></span>
             <select name="vehicle_seats_tpl" id="vehicle_seats_tpl" class="generalTextBox_white required" style="height:25px; width:335px;">
             <option value="">---SELECT---</option>
             <option value="1" <?php if($sql_edit->vehicle_seats_tpl == '1'){echo "selected";}?>>1</option>
             <option value="2" <?php if($sql_edit->vehicle_seats_tpl == '2'){echo "selected";}?>>2</option>
             <option value="3" <?php if($sql_edit->vehicle_seats_tpl == '3'){echo "selected";}?>>3</option>
             <option value="4" <?php if($sql_edit->vehicle_seats_tpl == '4'){echo "selected";}?>>4</option>
             <option value="5" <?php if($sql_edit->vehicle_seats_tpl == '5'){echo "selected";}?>>5</option>
             <option value="6" <?php if($sql_edit->vehicle_seats_tpl == '6'){echo "selected";}?>>6</option>
             <option value="7" <?php if($sql_edit->vehicle_seats_tpl == '7'){echo "selected";}?>>7</option>
             <option value="8" <?php if($sql_edit->vehicle_seats_tpl == '8'){echo "selected";}?>>8</option>
             </select>
			</td>
          </tr>
          <?php */?>
          
          
          
          
          
        </table>
		</td>
	  </tr>
	</table>
    </fieldset>
    
	<fieldset>
	<legend style="background-color: rgba(2, 2, 2, 0.33);">Coverage Details</legend>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
    <?php 
	$sql_covers = mysql_query("SELECT * FROM ".PRODUCTCOVERS." WHERE product_id = '".$product_id."'");
	if(mysql_num_rows($sql_covers) > 0)
	{
	  while($arr_covers = mysql_fetch_array($sql_covers))
	  { 
	  
	  
	    $radio_check = 0;
		$cover_amt = "";
		$cover_note = "";
		// if Edit, check Cover is applied or not //
		if($_GET['task'] == 'package_edit' && $_GET['id'] != '')
		{	
		  $sql_chk_cvr = mysql_query("SELECT * FROM ".PACKAGECOVER." WHERE package_no='".$sql_edit->package_no."' AND cover_id = '".$arr_covers['id']."'");
		  if(mysql_num_rows($sql_chk_cvr) > 0)
		   {
				$radio_check = 1;
				$objj = mysql_fetch_object($sql_chk_cvr);
				$cover_amt = $objj->cover_amt;
				$cover_note = $objj->coverage;
		  }
		}
	  
	  
	  ?>
	 <tr>
     <td class="whitetxt" width="22%">
	 <?php echo $arr_covers['cover_title'];?>:</td>
     <td valign="middle" width="78%" align="left">
     
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="13%">
        <input type="radio" name="cover_<?php echo $arr_covers['id'];?>" id="cover_<?php echo $arr_covers['id'];?>_1" value="1" checked="checked" onclick="return checkShowStatus(this);" <?php if($radio_check =='1') echo 'checked="checked"';?>/>
        Yes
        <input type="radio" name="cover_<?php echo $arr_covers['id'];?>" id="cover_<?php echo $arr_covers['id'];?>_2" onclick="return checkShowStatus(this);" value="0" <?php if($radio_check =='0') echo 'checked="checked"';?>/>  
        No</td>
        
        <td width="87%" id="cover_<?php echo $arr_covers['id'];?>_div" style=" <?php if($radio_check =='1'){?>style="display:block;"<?php }else{?>display:none;"<?php }?> >
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
       <tr>
        <td width="15%">Amount (SR): <?php if($arr_covers['is_price'] == '1'){echo '<font color="#FF0000">*</font>';}else{echo '&nbsp;';}?></td>
        <td width="17%">
        <span style="color:#FF0000" id="invalid_cover_<?php echo $arr_covers['id'];?>_amt"></span>
        <input type="text" id="cover_<?php echo $arr_covers['id'];?>_amt" name="cover_<?php echo $arr_covers['id'];?>_amt" style="width:100px;" onkeypress="return isNumberKey(event);" value="<?php echo $cover_amt;?>" class="textbox" />
        </td>
        <td width="16%" align="right"></td>
        <td width="52%">
        </td>
      </tr>
    </table></td>
      </tr>
    </table>	
    </td>
   </tr> 
	  <?php }
	  }else{ ?>
		
	  <?php }?>
      

	</table>
	<!--</fieldset>
    
    
    
    <fieldset>-->
	<!--<legend style="background-color: rgba(2, 2, 2, 0.33);">Optional and additional Coverage</legend>-->
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	  <tr>
      	<td colspan="2">
        	<table>
                <?php /*?><tr>
                    <td>Each Passenger Price</td> 
                    <td>
                        <input type="text" name="psngr_price" value="<?php echo $sql_edit->psngr_price;?>" maxlength="6"  onkeypress="return isNumberKey(event);" />
                    </td>
                </tr><?php */?>
                <?php /*?><tr height="10">
                	<td colspan="2"></td>
                </tr>
            	<tr>
                    <td width="200"><strong>Driver Age</strong></td>
                    <td align="center"><strong>Price (SR)</strong></td>
                </tr>
                <?php 
				$dages = mysql_query("select * from ".DRIVERAGE." where status='Active'");
				if(mysql_num_rows($dages) > 0)
				{
					while($dage = mysql_fetch_array($dages))
					{
						$price = "";
						if(!empty($package_no))
						{
							$driver_age = $dage['id'];
							$price = array_shift(mysql_fetch_array(mysql_query("SELECT price FROM ".PACKAGEPRICE." WHERE package_no = '".$package_no."' and driver_age = '".$driver_age."'")));
						}
						?>
                        <tr>
                            <td><?php echo stripslashes($dage['age']);?></td> 
                            <td>
                                <input type="hidden" name="driver_age[]" value="<?php echo $dage['id'];?>" />
                                <input type="text" name="price[]" value="<?php echo $price;?>" maxlength="6"  onkeypress="return isNumberKey(event);" />
                            </td>
                        </tr>
                        <?php 	
					}	
				}
				else
				{
					?>
                    <tr><td colspan="2">No driver age added.</td></tr>
                    <?php 
				}
				?><?php */?>
            </table>
        </td>
      </tr>	
	  	<tr>
		<td colspan="2" style="padding-top: 10px; padding-left: 0px;">
		<?php
		if($_GET['id'] != "" && $_GET['task'] == "package_edit"){
    	?>
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn" onclick="return validatePackageForm();" />
        <?php }else{ ?>
        <input type="submit" name="save" id="save" value=" Save  " class="actionBtn" onclick="return validatePackageForm();">
        <?php } ?>
		<input type="button" name="exit" id="exit" value=" Exit " class="actionBtn" onclick="location.href='account.php?page=package'">
		</td>
	  	</tr>
	</table>
    </fieldset>    

    
    
    </td>
  </tr>
</table>