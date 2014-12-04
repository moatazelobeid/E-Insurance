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

<div class="innrebodypanel">
        <div class="clearfix" style="height:15px;">.</div>
        <div class="innerwrap">
        
            <div class="breadcrumb" >
                <a itemprop="url" href="<?=BASE_URL?>">Home</a> 
                <span class="breeadset">&#8250;</span>
                <a itemprop="url" href="<?=BASE_URL.'index.php?page=user-dashboard'?>">Dashboard</a> 
                <span class="breeadset">&#8250;</span>
                <strong>My Policies </strong>
            </div>
            
            <?php include_once('includes/dashboard-sidebar.php'); ?>
            <div class="lg-6">
                <div class="rightformpan innerTFl">
                    <h1>
                    Policy Renewal</h1>
                    
                    Policy Renewal Service will be coming soon
                        
                    
                    <div class="clearfix" style="height:100px;"></div>
                </div>
            </div>
        <div class="clearfix"></div>
        </div>
       <div class="clearfix" style="height:15px;">.</div>
</div>
<?php } ?>