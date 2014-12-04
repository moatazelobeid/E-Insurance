<?php 
/*$sql_menu = mysql_query("SELECT * FROM ".SUBMENUTBL." WHERE (page = '".$_GET['page']."' || page like '".$_GET['page']."%') AND status = '1'");
if(mysql_num_rows($sql_menu) > 0)
{
	$ob = mysql_fetch_object($sql_menu);
	$main_menu = $ob->menu_name;
}
else{   // Set a Default Menu
	$main_menu = "CMS";
}

$sql_submenu = mysql_query("SELECT * FROM ".SUBMENUTBL." WHERE menu_name = '".$main_menu."' AND status = '1'");*/
?>
<?php /*?><div class="form_area_inner_dash_right">
           <div class="form_area_inner_dash_right_inner">
            <div style="float:left;">
            <span style="float:left;"  class="grey18"><?php echo $main_menu;?></span></div>
            <div class="clear" style="height:10px;"></div>
            <ul class="dash_left_sec">
            <?php while($ar_menu = mysql_fetch_assoc($sql_submenu))
			{?>
			<a style="color:#FFF;" href="<?php echo BASE_URL."account.php?page=".$ar_menu['page'];?>">
            <li <?php if($_GET['page'] == $ar_menu['page']){echo 'class="active"';}?>><?php echo $ar_menu['submenu_name'];?></li>
            </a>
			<?php }?>
             
            </ul>
          </div>
      </div><?php */?>
	 

<div class="form_area_inner_dash_right" id="left_dashlet" style="display: block;">	  
<div class="form_area_inner_dash_right_inner">
<div style="float:left;">
<?php if($_GET['page'] == "menu" || $_GET['page'] == "page" || $_GET['page'] == "view_page" || $_GET['page'] == "faqs" || $_GET['page'] == "downloads" || $_GET['page'] == "manage-banner"){ ?>
	<span style="float:left;" class="while18">CMS</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
	<a href="account.php?page=menu"><li <?php if($_GET['page'] == "menu") echo "class='active'"; ?>>Menus</li></a>
	<a href="account.php?page=view_page"><li <?php if($_GET['page'] == "page" || $_GET['page'] == "view_page") echo "class='active'"; ?>>Manage Pages</li></a>
	<a href="account.php?page=faqs&view=list"><li <?php if($_GET['page'] == "faqs") echo "class='active'"; ?>>FAQs</li></a>
	<a href="account.php?page=downloads"><li <?php if($_GET['page'] == "downloads") echo "class='active'"; ?>>Downloads</li></a>
	<a href="account.php?page=manage-banner"><li <?php if($_GET['page'] == "manage-banner") echo "class='active'"; ?>>Manage Banner</li></a>
	</ul>
<?php } ?>

<?php if($_GET['page'] == "package" || $_GET['page'] == "package_list"){ ?>
	<span style="float:left;" class="while18">Packages</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
	<a href="account.php?page=package"><li <?php if($_GET['page'] == "package") echo "class='active'"; ?>>Add New Package</li></a>
	<a href="account.php?page=package_list"><li <?php if($_GET['page'] == "package_list") echo "class='active'"; ?>>View/Manage Packages</li></a>
	</ul>
<?php } ?>

<?php if($_GET['page'] == "add_agent" || $_GET['page'] == "agent_list"){ ?>
	<span style="float:left;" class="while18">Brokers</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
	<a href="account.php?page=add_agent"><li <?php if($_GET['page'] == "add_agent") echo "class='active'"; ?>>Add New Broker</li></a>
	<a href="account.php?page=agent_list"><li <?php if($_GET['page'] == "agent_list") echo "class='active'"; ?>>View/Manage Brokers</li></a>
	</ul>
<?php } ?>

<?php if($_GET['page'] == "customer-list" || $_GET['page'] == "add-customers" || $_GET['page'] == "view_customer_details"){ ?>
        <span style="float:left;" class="while18">Customers</span></div>
        <div class="clear" style="height:10px;"></div>
        <ul class="dash_left_sec">
    	    <a href="account.php?page=customer-list"><li  <?php if($_GET['page'] == "customer-list" || $_GET['page'] == "add-customers" || $_GET['page'] == "view_customer_details") echo "class='active'"; ?>>Manage Customers</li></a>
        </ul>
    <?php } ?>

<?php /*?><?php if($_GET['page'] == "policy-quotes-request"){ ?>
        <span style="float:left;" class="while18">Quotes</span></div>
        <div class="clear" style="height:10px;"></div>
        <ul class="dash_left_sec">
        <a href="account.php?page=policy-quotes-request"><li <?php if($_GET['page'] == "policy-quotes-request") echo "class='active'"; ?>>Manage All Quotes</li></a>
        
        </ul>
    <?php } ?><?php */?>

<?php if($_GET['page'] == "admin_user" || $_GET['page'] == "create_user"){ ?>
	<span style="float:left;" class="while18">Admin Users</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
	<a href="account.php?page=create_user"><li <?php if($_GET['page'] == "create_user") echo "class='active'"; ?>>Add Admin Users</li></a>
	<a href="account.php?page=admin_user"><li <?php if($_GET['page'] == "admin_user") echo "class='active'"; ?>>View/Manage Admin Users</li></a>
	</ul>
<?php } ?>

<?php if($_GET['page'] == "add_employee" || $_GET['page'] == "employee_list" || $_GET['page'] == "emp_type"){ ?>
	<span style="float:left;" class="while18">Admin Users</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
	<a href="account.php?page=add_employee"><li <?php if($_GET['page'] == "add_employee") echo "class='active'"; ?>>Add New Employee</li></a>
	<a href="account.php?page=employee_list"><li <?php if($_GET['page'] == "employee_list") echo "class='active'"; ?>>View/Manage Employees</li></a>
	<a href="account.php?page=emp_type"><li <?php if($_GET['page'] == "emp_type") echo "class='active'"; ?>>Manage Employee Type</li></a>
	</ul>
<?php } ?>

<?php if($_GET['page'] == "config"){ ?>
	<span style="float:left;" class="while18">Settings</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
	<a href="account.php?page=config"><li <?php if($_GET['page'] == "config") echo "class='active'"; ?>>Site Settings</li></a>
	<a href="#"><li>Admin Menu Settings</li></a>
	<a href="#"><li>Access Control</li></a>
	</ul>
<?php } ?>

<?php if($_GET['page'] == "branches" || $_GET['page'] == "business-type" || $_GET['page'] == "doc-type" || $_GET['page'] == "vehicle" || $_GET['page'] == "offices" || $_GET['page'] == "policies"){ ?>
	<span style="float:left;" class="while18">Master Settings</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
	<a href="account.php?page=policies"><li <?php if($_GET['page'] == "policies") echo "class='active'"; ?>>Policies</li></a>
	<a href="account.php?page=branches"><li <?php if($_GET['page'] == "branches") echo "class='active'"; ?>>Branches</li></a>
	<a href="account.php?page=offices"><li <?php if($_GET['page'] == "offices") echo "class='active'"; ?>>Offices</li></a>
	<a href="account.php?page=business-type"><li <?php if($_GET['page'] == "business-type") echo "class='active'"; ?>>Business Types</li></a>
	<a href="account.php?page=doc-type"><li <?php if($_GET['page'] == "doc-type") echo "class='active'"; ?>>Document Types</li></a>
	<a href="account.php?page=vehicle"><li <?php if($_GET['page'] == "vehicle") echo "class='active'"; ?>>Veichles</li></a>
	</ul>
<?php } ?>

<?php if($_GET['page'] == "policy-master" || $_GET['page'] == "add-policy"|| $_GET['page'] == "view-policy" || $_GET['page'] == "policy-list" || $_GET['page'] == "renew-policy" || $_GET['page'] == "cancel-policy" || $_GET['page'] == "pay-premium" || $_GET['page'] == "edit-policy" || $_GET['page'] == "claim-center" || $_GET['page'] == "policy-quotes-request" || $_GET['page'] == "renewal-pending"){ ?>
	<span style="float:left;" class="while18">Policy Master</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
    <a href="account.php?page=policy-quotes-request"><li <?php if($_GET['page'] == "policy-quotes-request") echo "class='active'"; ?>>Manage All Quotes</li></a>
	<?php /*?><a href="account.php?page=add-policy"><li <?php if($_GET['page'] == "add-policy") echo "class='active'"; ?>>New Policy</li></a><?php */?>
	<a href="account.php?page=policy-list"><li <?php if($_GET['page'] == "policy-list" || $_GET['page'] == "view-policy" || $_GET['page'] == "edit-policy") echo "class='active'"; ?>>Manage Policies</li></a>
	<?php /*?><a href="account.php?page=renew-policy"><li <?php if($_GET['page'] == "renew-policy") echo "class='active'"; ?>>Renew Policy</li></a>
	<a href="account.php?page=pay-premium"><li <?php if($_GET['page'] == "pay-premium") echo "class='active'"; ?>>Quick Payment</li></a><?php */?>
    <?php /*?><a href="account.php?page=renewal-pending"><li <?php if($_GET['page'] == "renewal-pending") echo "class='active'"; ?>>Pending Policy Renewals</li></a><?php */?>
    <a href="account.php?page=claim-center"><li <?php if($_GET['page'] == "claim-center") echo "class='active'"; ?>>List All Claims</li></a>
	</ul>
<?php } ?>

<?php /*?><?php if($_GET['page'] == "claim-center"){ ?>
	<span style="float:left;" class="while18">Claim Center</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
	<a href="account.php?page=claim-center"><li <?php if($_GET['page'] == "claim-center") echo "class='active'"; ?>>List All Claims</li></a>
	</ul>
<?php } ?><?php */?>
<?php if($_GET['page'] == "sales-report" || $_GET['page'] == "sales-graph"){ ?>
	<span style="float:left;" class="while18">Reports</span></div>
	<div class="clear" style="height:10px;"></div>
	<ul class="dash_left_sec">
	<a href="account.php?page=sales-report"><li <?php if($_GET['page'] == "sales-report" || $_GET['page'] == "sales-graph") echo "class='active'"; ?>>Sales Report</li></a>
	</ul>
<?php } ?>
</div>
</div>	  
<div class="left-sidebar-strip"><img src="images/left-sidebar-collapse.png" width="21" height="40" class="GERAW0ABLV" onclick="paneltoggle()"></div>