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
	$PST['policy_type'] = 'comp';
	$PST['package_title'] = $_POST['package_title'];
	$PST['package_title_ar'] = $_POST['package_title_ar'];
	$PST['package_desc'] = $_POST['package_desc'];
	$PST['package_desc_ar'] = $_POST['package_desc_ar'];
	$PST['vehicle_make_comp'] = $_POST['vehicle_make_comp'];
	$PST['vehicle_model_comp'] = $_POST['vehicle_model_comp'];
	$PST['vehicle_type_comp'] = $_POST['vehicle_type_comp'];
	$PST['is_agency_repair'] = $_POST['is_agency_repair'];
	$PST['no_of_ncd'] = $_POST['no_of_ncd'];
	$PST['no_of_ncd'] = $_POST['no_of_ncd'];
	$PST['created_date'] = date("Y-m-d H:i:s");
	$PST['package_amt'] = $_POST['policy_amount'];
	
	// INSERT into Package Table //
	$result = $db->recordInsert($PST,PACKAGE,'');
	
	//Insert package price for driver ages
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
	}
	
	
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
	
	$PST = array();
	$PST['policy_type'] = 'comp';
	$PST['package_title'] = $_POST['package_title'];
	$PST['package_title_ar'] = $_POST['package_title_ar'];
	$PST['package_desc'] = $_POST['package_desc'];
	$PST['package_desc_ar'] = $_POST['package_desc_ar'];
	$PST['vehicle_make_comp'] = $_POST['vehicle_make_comp'];
	$PST['vehicle_model_comp'] = $_POST['vehicle_model_comp'];
	$PST['vehicle_type_comp'] = $_POST['vehicle_type_comp'];
	$PST['is_agency_repair'] = $_POST['is_agency_repair'];
	$PST['no_of_ncd'] = $_POST['no_of_ncd'];
	$PST['no_of_ncd'] = $_POST['no_of_ncd'];
	$PST['created_date'] = date("Y-m-d H:i:s");
	$PST['package_amt'] = $_POST['policy_amount'];
	
	// Update into Package Table //
	$result = $db->recordUpdate(array('id'=>$_GET['id']),$PST,PACKAGE,'');
	
	
	// Get Package No.//
	$package_no = array_shift(mysql_fetch_array(mysql_query("SELECT package_no FROM ".PACKAGE." WHERE id = '".$_GET['id']."'")));
	
	
	//Update package price for driver ages
	
	//delete previous price setting
	$db->recordDelete(array('package_no' => $package_no),PACKAGEPRICE);
	
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
	}
	
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
	
	if(form.vehicle_make_comp.value == "")
	{ 
		form.vehicle_make_comp.style.borderColor = "RED";
		form.vehicle_make_comp.focus();
		document.getElementById("invalid_vehicle_make_comp").innerHTML='Select Vehicle Make<br/>';
		return false;
	}
	else
	{
		form.vehicle_make_comp.style.borderColor = "";
		document.getElementById("invalid_vehicle_make_comp").innerHTML='';
	}
	
	if(form.vehicle_model_comp.value == "")
	{ 
		form.vehicle_model_comp.style.borderColor = "RED";
		form.vehicle_model_comp.focus();
		document.getElementById("invalid_vehicle_model_comp").innerHTML='Select Vehicle Model<br/>';
		return false;
	}
	else
	{
		form.vehicle_model_comp.style.borderColor = "";
		document.getElementById("invalid_vehicle_model_comp").innerHTML='';
	}
	
	if(form.vehicle_type_comp.value == "")
	{ 
		form.vehicle_type_comp.style.borderColor = "RED";
		form.vehicle_type_comp.focus();
		document.getElementById("invalid_vehicle_type_comp").innerHTML='Select Vehicle Type<br/>';
		return false;
	}
	else
	{
		form.vehicle_type_comp.style.borderColor = "";
		document.getElementById("invalid_vehicle_type_comp").innerHTML='';
	}
	
	if((document.getElementById("is_agency_repair0").checked  == false) && (document.getElementById("is_agency_repair1").checked  == false)) 
	{
		document.getElementById("invalid_is_agency_repair").innerHTML='Select Agency Repair<br/>';
		
		return false;
	}
	else
	{
		document.getElementById("invalid_is_agency_repair").innerHTML='';
	}
	
	if(form.no_of_ncd.value == "")
	{ 
		form.no_of_ncd.style.borderColor = "RED";
		form.no_of_ncd.focus();
		document.getElementById("invalid_no_of_ncd").innerHTML='Select No. of No Claim cerificates<br/>';
		return false;
	}
	else
	{
		form.no_of_ncd.style.borderColor = "";
		document.getElementById("invalid_no_of_ncd").innerHTML='';
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
            <td width="18%">Package Title (EN):</td>
            <td width="82%">
            <span id="invalid_title" class="invalimsg" style="color:#FF0000;"></span>
            
              <input name="package_title" type="text" class="textbox" id="package_title" style="width: 327px;" value="<?php echo stripslashes($sql_edit->package_title);?>"/>
              <input type="hidden" name="package_type" id="package_type" value="comprehensive" />
            </td>
          </tr>
          
          <tr>
            <td width="18%">Package Title (AR):</td>
            <td width="82%">
              <input name="package_title_ar" type="text" class="textbox" id="package_title_ar" style="width: 327px;" value="<?php echo stripslashes($sql_edit->package_title_ar);?>"/>
            </td>
          </tr>
          
          <tr>
            <td valign="top">Package Description (EN): </td>
            <td>
              <span id="invalid_description" class="invalimsg" style="color:#FF0000;"></span>
              <textarea name="package_desc" id="package_desc" class="textbox" style="width: 327px;"><?php echo stripslashes($sql_edit->package_desc);?></textarea>
            </td>
          </tr>
          
          <tr>
            <td valign="top">Package Description (AR): </td>
            <td>
              <textarea name="package_desc_ar" id="package_desc_ar" class="textbox" style="width: 327px;"><?php echo stripslashes($sql_edit->package_desc_ar);?></textarea>
            </td>
          </tr>
          
          <tr>
            <td>Vehicle Make: </td>
            <td>
            <span id="invalid_vehicle_make_comp" class="invalimsg" style="color:#FF0000;"></span>
              <select name="vehicle_make_comp" id="vehicle_make_comp" class="textbox"  style="width: 335px;" onchange="getModel(this.value)">
				<option selected="selected" disabled="disabled" value="">Select Vehicle Make</option>
			    <?php $sqll = mysql_query("SELECT * FROM ".VMAKE." WHERE status = '1'");
                       while($arr = mysql_fetch_array($sqll))
                       {
                       if($arr['id'] == $sql_edit->vehicle_make_comp){$make_id = $arr['id'];}
                       ?>
                       <option value="<?php echo $arr['id'];?>" <?php if($arr['id'] == $sql_edit->vehicle_make_comp){echo "selected";}?>><?php echo $arr['make'];?></option>
                       <?php }?> 
						 
                  </select>
                        
           </td>
          </tr>
          
          <tr>
            <td>Vehicle Model: </td>
            <td>
               <span id="invalid_vehicle_model_comp" class="invalimsg" style="color:#FF0000;"></span>
               <div id="model_comp_div" style="float:left;">
               <select name="vehicle_model_comp" id="vehicle_model_comp" class="textbox"  style="width:335px;">
               <option value="">Select Vehicle Model</option>
                   <?php $sql2 = mysql_query("SELECT * FROM ".VMODEL." WHERE status = '1' AND make_id = '$make_id'");
                       while($arr2 = mysql_fetch_array($sql2))
                       {
                       if($arr2['id'] == $sql_edit->vehicle_model_comp){$model_id = $arr2['id'];}
                       ?>
                       <option value="<?php echo $arr2['id'];?>" <?php if($arr2['id'] == $sql_edit->vehicle_model_comp){echo "selected";}?>><?php echo $arr2['model'];?></option>
                       <?php }?>
                 </select>
				 </div>
           </td>
          </tr>
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
     <td width="78%" valign="middle">
     
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="13%" align="left">
        <input type="radio" name="cover_<?php echo $arr_covers['id'];?>" id="cover_<?php echo $arr_covers['id'];?>_1" value="1" checked="checked" onclick="return checkShowStatus(this);" <?php if($radio_check =='1') echo 'checked="checked"';?>/> Yes
        <input type="radio" name="cover_<?php echo $arr_covers['id'];?>" id="cover_<?php echo $arr_covers['id'];?>_2" onclick="return checkShowStatus(this);" value="0" <?php if($radio_check =='0') echo 'checked="checked"';?> />  
        No</td>
        
        <td width="87%" id="cover_<?php echo $arr_covers['id'];?>_div" <?php if($radio_check =='1'){?>style="display:block;"<?php }else{?> style="display:none;"<?php }?>>
        <table  width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td width="16%">Amount (SR): <?php if($arr_covers['is_price'] == '1'){echo '<font color="#FF0000">*</font>';}else{echo '&nbsp;';}?></td>
        <td width="18%">
        <span style="color:#FF0000" id="invalid_cover_<?php echo $arr_covers['id'];?>_amt"></span>
        <input type="text" id="cover_<?php echo $arr_covers['id'];?>_amt" name="cover_<?php echo $arr_covers['id'];?>_amt" style="width:100px;" onkeypress="return isNumberKey(event);" onkeyup="getPolicyAmount()" value="<?php echo $cover_amt;?>" class="textbox" />
        </td>
        <td width="13%" align="right"></td>
        <td width="53%">
        </td>
      </tr>
    </table></td>
      </tr>
    </table>	
    </td>
   </tr> 
	  <?php }
	}
	?>
	  <tr>
		<td colspan="2" style="padding-top: 10px; padding-left: 0px;">
		<?php
		if($_GET['id'] != "" && $_GET['task'] == "package_edit"){
    	?>
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn">
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
</form>