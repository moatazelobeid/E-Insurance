<?php 
	if(empty($_SESSION['uid']))
	{
		header("location:index.php?page=sign-in");
	}else{
		$udata=mysql_fetch_assoc(mysql_query("select * from ".LOGINTBL." where uid='".$_SESSION['uid']."' and user_type='U' "));
		$userinfo=mysql_fetch_assoc(mysql_query("select * from ksa_user where id='".$_SESSION['uid']."' "));



$db = new dbFactory();


function getCoverTitle($id)
{
	$res = mysql_fetch_array(mysql_query("select cover_title from ".PRODUCTCOVERS." where id=".$id));
	return stripslashes($res['cover_title']);
}

function getPackageDetails($package_no)
{
	$res = mysql_fetch_object(mysql_query("select * from ".PACKAGE." where package_no='".$package_no."'"));
	return $res;
}


$policy_no = $_GET['policyno'];

$reg_user_deatil = $db->recordFetch($_SESSION['uid'],USERTBL.":".'id');
$customer_code = getElementVal('customer_code',$reg_user_deatil);

$policy_details_qry = "select a.*, b.insured_period_startdate, b.insured_period_enddate, b.doc_key from ".POLICYMOTOR." as a inner join ".POLICYMASTER." as b on a.policy_no = b.policy_no where a.policy_no='".$policy_no."' and a.customer_id= '".$customer_code."'";
$policy_details = mysql_fetch_object(mysql_query($policy_details_qry));


$package_no = $policy_details->package_no;

$pkg_covers = $db->recordArray($package_no,PACKAGECOVER.':package_no');

$pkg = getPackageDetails($package_no); 
?>

<div class="innrebodypanel">
        <div class="clearfix" style="height:15px;">.</div>
        <div class="innerwrap">
        
            <div class="breadcrumb" >
                <a itemprop="url" href="<?=BASE_URL?>">Home</a> 
                <span class="breeadset">&#8250;</span>
                <a itemprop="url" href="<?=BASE_URL.'index.php?page=user-dashboard'?>">Dashboard</a> 
                <span class="breeadset">&#8250;</span>
                <a itemprop="url" href="<?=BASE_URL.'index.php?page=mypolicies'?>">My Policies</a> 
                <span class="breeadset">&#8250;</span>
                <strong>Policy Coverage Details </strong>
            </div>
            
            <?php include_once('includes/dashboard-sidebar.php'); ?>
            <div class="lg-6">
                <div class="rightformpan innerTFl">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="policytab">
                <tr><td>
                <h2><?php echo stripslashes($pkg->package_title);?></h2>

				<?php 
                
                if(mysql_num_rows($pkg_covers)>0)
                {
                    echo '<ul>';
                    while($pkg_cover = mysql_fetch_array($pkg_covers))
                    {
                        echo '<li>'.getCoverTitle($pkg_cover['cover_id']).'</li>';
                    }
                    echo '</ul>';
                }
                else
                {
                    echo 'No coverage found.';	
                }?>
                </td></tr></table>
                </div>
            </div>
        <div class="clearfix"></div>
        </div>
       <div class="clearfix" style="height:15px;">.</div>
</div>
<?php } ?>