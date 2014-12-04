<?php 
	if(empty($_SESSION['uid']))
	{
		header("location:index.php?page=sign-in");
	}else{
		$udata=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid='".$_SESSION['uid']."' and user_type='U' "));
		$userinfo=mysql_fetch_assoc(mysql_query("select * from ksa_user where id='".$_SESSION['uid']."' "));
		
?>

<div class="innrebodypanel">
        <div class="clearfix" style="height:15px;">.</div>
        <div class="innerwrap">
        
            <div class="breadcrumb" >
                <a itemprop="url" href="<?=BASE_URL?>">Home</a> 
                <span class="breeadset">&#8250;</span>
                <strong>Dashboard </strong>
            </div>
            
            <?php include_once('includes/dashboard-sidebar.php'); ?>
            <div class="lg-6">
                <div class="rightformpan innerTFl">
                    <div class="form_area_left_dash_heading1" style="font-family: Arial, Helvetica, sans-serif;">Welcome <?=$_SESSION['uname']?> to your dashboard<br />
                    <div class="clearfix" style="height:4px;"></div>
                    <span style="font-size: 12px;color: #FFFFFF;text-transform: none;">Last Login : <?= date("m/d/y g:i A", strtotime($udata['last_login']));?></span>
                    </div>
                    <div class="clearfix" style="height:10px"></div>
                    
                    <div class="wpcf7" id="wpcf7-f61-p12-o1" style="width:100%">
                       <div style="width: 47%; float:left;height: auto;">
                       <h2>
                        Customer Information
                   		</h2>
                        <div class="form-row">
                              <label for="your-email">Customer id :</label>
                              <span class="wpcf7-form-control-wrap your-email">
                              <?=$userinfo['customer_code']?>
                              </span>
                         </div>
                       <div class="form-row">
                              <label for="your-email">Name :</label>
                              <span class="wpcf7-form-control-wrap your-email">
                              <?=$userinfo['salutation']?> <?=$userinfo['fname']?> <?=$userinfo['lname']?> 
                              </span>
                         </div>
                         <div class="form-row">
                              <label for="your-email">Email :</label>
                              <span class="wpcf7-form-control-wrap your-email">
                              <?=$userinfo['email']?>
                              </span>
                         </div>
                         <div class="form-row">
                              <label for="your-email">Phone number :</label>
                              <span class="wpcf7-form-control-wrap your-email">
                              <?=$userinfo['phone_mobile']?>
                              </span>
                         </div>
                       </div> 
                       <div class="clear"></div>
                       <div style="width: 47%; float:right;">
                       <h2>
                        Statistics
                   		</h2>
                       <div class="form-row">
                              <label for="your-email">Number of Policy : </label>
                              <span class="wpcf7-form-control-wrap your-email">
                              <?php $utotalp=mysql_fetch_assoc(mysql_query("select count(*) as total_pol from ".POLICYMASTER." where customer_id='".$userinfo['customer_code']."' "));
							  echo $utotalp['total_pol'];
							  ?>
                              </span>
                         </div>
                         <div class="form-row">
                              <label for="your-email">Total Renewals :</label>
                              <span class="wpcf7-form-control-wrap your-email">
                              <?php $utotal_renewp=mysql_fetch_assoc(mysql_query("select count(*) as total_rpol from ".POLICYRENEWAL." where customer_id='".$userinfo['customer_code']."' "));
							  echo $utotal_renewp['total_rpol'];
							  ?>
                              </span>
                         </div>
                         <div class="form-row">
                              <label for="your-email">Total Payments :</label>
                              <span class="wpcf7-form-control-wrap your-email">
                               <?php $utotalpay=mysql_fetch_assoc(mysql_query("select sum(amount_paid) as total_payments from ".POLICYPAYMENTS." where customer_id='".$userinfo['customer_code']."' "));
							  echo (!empty($utotalpay['total_payments']))?$utotalpay['total_payments']:'0';
							  ?>
                              </span>
                         </div>
                         <div class="form-row">
                              <label for="your-email">Active Policy :</label>
                              <span class="wpcf7-form-control-wrap your-email">
                               <?php $utotalactpol=mysql_fetch_assoc(mysql_query("select count(*) as total_pol from ".POLICYMASTER." where customer_id='".$userinfo['customer_code']."' and status='Active' "));
							  echo $utotalactpol['total_pol'];
							  ?>
                              </span>
                         </div>
                       </div>
                       
                    </div>
                    
                </div>
            </div>
        <div class="clearfix"></div>
        </div>
       <div class="clearfix" style="height:15px;">.</div>
</div>
<?php } ?>