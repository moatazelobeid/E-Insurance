<?php
// create policies
if(empty($_GET['policy_id'])){
	 header('location:account.php?page=policies');
}else
{
	$policyid = $_GET['policy_id'];
	$policydetails = $db->recordFetch($_GET['policy_id'],POLICIES.":".'id');
}

if(isset($_POST['save']))
{
	// post params
	unset($_POST['save']);
	
	$photo=$_FILES['product_image']['name'];
	if($photo!='')
	{
      $photo1=time().$photo;
	  $_POST['product_image'] = $photo1;
      $tmp=$_FILES['product_image']['tmp_name'];
      move_uploaded_file ($tmp,"../upload/policy_images/".$photo1);
    }

	
	$_POST['policy_class_id'] = $policyid;
	$_POST['date_modified'] = date("Y-m-d H:i:s");
	$record_ins1 = $db->recordInsert($_POST,PRODUCTS);
	
	if(mysql_affected_rows() > 0)
	{
		// create mail
		 header('location:account.php?page=policies&view=policy_details&policy_details&policy_id='.$_GET['policy_id'].'&task=edit');
		 $msg="Policy Saved sucessfully";
	}else
	{
	  	$msg="Record Not Saved";
	}
	
	

}

// update policy information
if(isset($_POST['update']))
{
		$updteproductid = $_POST['uproduct_id'];
		$check = mysql_fetch_array(mysql_query("select * from ".PRODUCTS." WHERE policy_class_id = '".$policyid."'"));
		$datalists = $db->recordFetch($updteproductid,PRODUCTS.":".'id');	
		if(count($check) >0)
		{
			unset($_POST['update']);
			unset($_POST['uproduct_id']);
			$_POST['policy_class_id'] = $policyid;
			$_POST['date_modified'] = date("Y-m-d H:i:s");
			$resultq=$db->recordUpdate(array("id" => $updteproductid),$_POST,PRODUCTS);
			
			$photo=$_FILES['product_image']['name'];
	
			//upload photo
			if($photo!=''){
			
				$photo1=time().$photo;
				$tmp=$_FILES['product_image']['tmp_name'];
				move_uploaded_file ($tmp,"../upload/policy_images/".$photo1);
				$photopath=getElementVal('product_image',$datalists);
				unlink("../upload/policy_images/$photopath");
				$resultq=$db->recordUpdate(array("id" => $updteproductid),array("product_image"=>$photo1),PRODUCTS);
			}
			if($resultq ==1)
			{
				$msg="Policy Updated sucessfully";
			}
		}else{
			$msg="Your Record Updation failed";
		}

}



//redirectuser();
if($_GET['task'] == "edit" && $_GET['policy_id'] != "")
{
	if(isset($_GET['policytype']) && !empty($_GET['policytype']))
	{
		$sq = mysql_query("select * from ".PRODUCTS." where policy_type_id = '".$_GET['policytype']."' and policy_class_id ='".$_GET['policy_id']."'");
		$datalists = mysql_fetch_assoc($sq);
	}else
	{
		$datalists = $db->recordFetch($_GET['policy_id'],PRODUCTS.":".'policy_class_id');
	}	
	$productid = getElementVal('id',$datalists);
	$product_description = getElementVal('product_description',$datalists);
	$product_description_ar = getElementVal('product_description_ar',$datalists);
	$product_terms = getElementVal('product_terms',$datalists);
	$product_terms_ar = getElementVal('product_terms_ar',$datalists);
	$policy_type_id = getElementVal('policy_type_id',$datalists);
	$product_image = getElementVal('product_image',$datalists); 
	$product_key = getElementVal('product_key',$datalists); 
	$product_key_ar = getElementVal('product_key_ar',$datalists); 
}
$policytypesql = mysql_query("select * from ".POLICYTYPES." where status = '1' and policy_id ='".$_GET['policy_id']."'");

?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
function validatepolicy()
{
	var str = document.p_fr;
	var error = "";
	var flag = true;
	//var dataArray = new Array();
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	//var e = checkEmail(str.emp_email.value);
	//var u = checkUname(str.uname.value);
	<?php if(mysql_num_rows($policytypesql)>0)
	{ ?>
	if(str.policy_type_id.value == "")
	{
		str.policy_type_id.style.borderColor = "RED";
		error += "- Select Product Type \n";
		flag = false;
	     //dataArray.push('emp_id');
	}
	else
	{
		str.policy_type_id.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	<? }?>
	if(str.product_title.value == "")
	{
		str.product_title.style.borderColor = "RED";
		error += "- Enter Product Title \n";
		flag = false;
	     //dataArray.push('emp_id');
	}
	else
	{
		str.product_title.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}

	if(flag == false)
	{
		alert(error);
		//str.elements[dataArray[0]].focus();
		return false;
	}
	else{
	//checkEmail(str.emp_email.value);
	return true;
	}
	
}

function changepolicy_type(val)
{

	var policyid='<?php echo $_GET['policy_id'];?>';  
	 $.ajax({
         type: "POST",
         url: "util/ajax-chk.php",
         data: "policy_Id="+ policyid + "&ptypeid="+val,
         success: function(msg){
			if(msg ==1)
			{
				window.location.href='account.php?page=policies&view=policy_details&policy_id='+policyid+'&task=edit&policytype='+val;		
			}
			else if(msg == 0)
			{
				window.location.href='account.php?page=policies&view=policy_details&policy_id='+policyid+'&policytype='+val;		
			}
		 }
		});
}

function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode;
         if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

</script>




<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="border-bottom: 1px solid #CCC; margin-top: 10px;">
  <tr>
    <td width="471" style="padding-bottom: 2px; padding-left: 0px; font-size: 14px; color: #036;"><strong><?php if($_GET['policy_id']!="" && $_GET['task']=='edit') { echo "Edit Product Details (For ".getElementVal('title',$policydetails).")"; } else {echo "Add Product Details (For ".getElementVal('title',$policydetails).")";} ?> </strong></td><td width="38" valign="top" style="padding-bottom: 5px; padding-left: 0px; font-size: 14px; color: #036; "></td>
    <?php if($productid !="" && $_GET['task']=='edit') { ?>
    <td width="500" align="right" style="padding-bottom: 15px; padding-right: 5px;">
	  <a href="account.php?page=policies&view=policy-covers&product_id=<?php echo $productid;?>" class="linkBtn ">Add Covers</a>
	  </td>
    <td width="141" align="right" style="padding-bottom: 15px; padding-right: 5px;">
	  <a href="account.php?page=policies&view=policy-attachments&product_id=<?php echo $productid;?>" class="linkBtn ">Add Attachments</a>
	  </td>
      <?php } ?>
    <td width="156" align="right" style="padding-bottom: 15px; padding-right: 0px;">
	  <a href="account.php?page=policies" class="linkBtn ">&#8592; Back to Policies</a>
	  </td>
  </tr>
</table>
<?php if($msg <> ""){ ?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 0px; <?php if(isset($msg)){?>background-color: #F1F8E9;<?php }?> line-height: 15px; color: #900;">
  <tr>
    
    <td width="98%"><?php echo $msg; ?></td>
  </tr>
</table>
<?php } ?>

<?php if($errmsg <> ""){ ?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-bottom: 0px; <?php if(isset($errmsg)){?>background-color: #F1F8E9;<?php }?> line-height: 15px; color: #900;">
  <tr>
    <td width="98%"><?php echo $errmsg; ?></td>
  </tr>
</table>
<?php } ?>


<form action="" method="post" name="p_fr" id='p_fr' onSubmit="return validatepolicy();" enctype="multipart/form-data">

  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
    <tr>
      <td width="50%" valign="top" style="padding-right: 10px;">

        
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td style="padding: 5px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom: 0px;">
                <?php 
				$policysql = mysql_query("select * from ".POLICYTYPES." where status ='1' and policy_id ='".$_GET['policy_id']."' ");
					if(mysql_num_rows($policysql))
					{
				  ?>
					<tr>
					 <td width="29%" style="padding-left: 0px;">Select Policy Type:</td>
				   <td width="71%">
				   <select name="policy_type_id" id="policy_type_id" onchange="changepolicy_type(this.value);" style="width:208px;">
				   <option value="">Select Type</option>
				   <?php 
						while($row1 = mysql_fetch_array($policysql)):
				   ?>
				   <option value="<?=$row1['id']?>" <?=($policy_type_id == $row1['id'])?'Selected':''?> <?=(isset($_GET['policytype']) && $_GET['policytype'] == $row1['id'] )?'Selected':''?>><?=$row1['policy_type']?></option>
				   <?php endwhile; ?>
				   </select></td>
				  </tr>
				  <?php }else
				  { ?>
				  <input type="hidden" name="policy_type_id" value="0" id="default_policy_id" />
				  <?php }?>
                <tr>
                  <td style="padding-left: 0px;">Policy title(EN):</td>
                  <td><input name="product_title" type="text" class="textbox" id="product_title" style="width: 200px;" value="<?php  echo getElementVal('product_title',$datalists);  ?>" /></td>
                </tr>
				<tr>
                  <td style="padding-left: 0px;padding-bottom:5px;">Policy title(AR):</td>
                  <td><input name="product_title_ar" type="text" class="textbox" id="product_title_ar" style="width: 200px;" value="<?php echo getElementVal('product_title_ar',$datalists); ?>" /></td>
                </tr>
				
                 <tr>
                  <td style="padding-left: 0px;" valign="top" colspan="2"><strong>Product Description(EN):</strong></td>
                 </tr>
                 <tr>
                  <td style="padding-left: 0px;" colspan="2"><?php
						include_once("editor/fckeditor.php");
						$oFCKeditor = new FCKeditor('product_description',200);
						$oFCKeditor->BasePath = 'editor/';
						$oFCKeditor->ToolbarSet = "Basic";
						$oFCKeditor->Config['EnterMode'] = 'br';
						$oFCKeditor->Value = $product_description;
						$oFCKeditor->Create(); 
						?> </td>
                </tr>
                <tr>
                  <td style="padding: 6px;padding-left: 0px;" valign="top" colspan="2"><strong>Product Terms(EN):</strong></td>
                </tr>
                <tr>
                  <td style="padding-left: 0px;" colspan="2"><?php
							include_once("editor/fckeditor.php");
							$oFCKeditor = new FCKeditor('product_terms',200);
							$oFCKeditor->BasePath = 'editor/';
							$oFCKeditor->ToolbarSet = "Basic";
							$oFCKeditor->Config['EnterMode'] = 'br';
							$oFCKeditor->Value = $product_terms;
							$oFCKeditor->Create(); 
							?> </td>
                </tr>
              </table></td>
          </tr>
             <tr>
				  <td valign="top" colspan="2"><strong>Product Key benefits(EN):</strong></td>
				 </tr>
                     <tr>
					 
					  <td colspan="2"><?php
							include_once("editor/fckeditor.php");
							$oFCKeditor = new FCKeditor('product_key',200);
							$oFCKeditor->BasePath = 'editor/';
							$oFCKeditor->ToolbarSet = "Basic";
							$oFCKeditor->Config['EnterMode'] = 'br';
							$oFCKeditor->Value = $product_key;
							$oFCKeditor->Create(); 
							?></td>
					</tr>
				<tr>
        </table>
        </td>
	
      <td width="50%" valign="top">
      <?php if(isset($_GET['task']) && !empty($product_image)){$style='style="margin-top: -2px;"';}else{$style='style="margin-top: 20px;"';}?>
	 <table width="100%" border="0" cellpadding="3" cellspacing="2" <?=$style?> >
     		<?php if(isset($_GET['task']) && !empty($product_image)){ ?>
            <tr>
            	<td>&nbsp;</td>
            	<td  ><img width="70" height="50"  src="<?php echo SITE_URL.'upload/policy_images/'.$product_image;?>"/></td>
            </tr>
             <?php } ?>
     		 <tr>
                  <td style="padding-left: 0px;">Policy Image:</td>
                  <td><input name="product_image" class="textbox" id="product_image" type="file"  style="width: 200px;"/>
                 <?php  if($_GET['task'] == "edit" && $_GET['policy_id'] != "") { ?>
                  		<input type="hidden" name="uproduct_id" value="<?=$productid?>" id="uproduct_id" />
                 <?php } ?>
                  </td>
          	</tr>
			 <tr>
				  <td valign="top" colspan="2"><strong>Product Description(AR):</strong></td>
				 </tr>
		  
			  <tr>
					 
					  <td colspan="2"><?php
						include_once("editor/fckeditor.php");
						$oFCKeditor = new FCKeditor('product_description_ar',200);
						$oFCKeditor->BasePath = 'editor/';
						$oFCKeditor->ToolbarSet = "Basic";
						$oFCKeditor->Config['EnterMode'] = 'br';
						$oFCKeditor->Value = $product_description_ar;
						$oFCKeditor->Create(); 
						?></td>
					</tr>
				<tr>
				  <td valign="top" colspan="2"><strong>Product Terms(AR):</strong></td>
				 </tr>
					<tr>
				   
					  <td colspan="2"><?php
							include_once("editor/fckeditor.php");
							$oFCKeditor = new FCKeditor('product_terms_ar',200);
							$oFCKeditor->BasePath = 'editor/';
							$oFCKeditor->ToolbarSet = "Basic";
							$oFCKeditor->Config['EnterMode'] = 'br';
							$oFCKeditor->Value = $product_terms_ar;
							$oFCKeditor->Create(); 
							?></td>
					</tr>
                    <tr>
				  <td valign="top" colspan="2"><strong>Product Key benefits(AR):</strong></td>
				 </tr>
                     <tr>
					 
					  <td colspan="2"><?php
							include_once("editor/fckeditor.php");
							$oFCKeditor = new FCKeditor('product_key_ar',200);
							$oFCKeditor->BasePath = 'editor/';
							$oFCKeditor->ToolbarSet = "Basic";
							$oFCKeditor->Config['EnterMode'] = 'br';
							$oFCKeditor->Value = $product_key_ar;
							$oFCKeditor->Create(); 
							?></td>
					</tr>
                 
	</table>

</td>
    </tr>
    
    <tr>
      <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
        </table></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" style="padding: 5px;">
	  	<?php
		if($_GET['policy_id'] != "" && $_GET['task'] == "edit"){
    	?>
        <input type="submit" name="update" id="update" value=" Update" class="actionBtn">
        <?php }else{ ?>
        <input type="submit" name="save" id="save" value="Save" class="actionBtn">
        <?php } ?>
        <input type="button" name="cancel" id="cancel" value="Cancel" class="actionBtn" onclick="location.href='account.php?page=policies'" />
        <!--<input type="button" name="list" id="list" value="Back To List" class="actionBtn" onclick="location.href='account.php?page=emplist'">-->        
        </td>
    </tr>
  </table>
</form>