<?php /*?><ul id="MenuBar1" class="MenuBarHorizontal">
<?php
$menu= "Dashboard";
$dashsql=mysql_query("select * from ".ADMMENU." where status='1' and menu_name='$menu'");
$dashres=mysql_fetch_array($dashsql);
if($dashres>0)
{?>
    <li><a href="account.php">Dashboard</a></li>   
<?php }else{
	?>
    <li><a href="#">Dashboard</a></li>  
    
	<?php }
?>
    
    <?php $emp_type_id='';
	if($_SESSION['atype'] =='E')
	{ 
		$emp_type_id=$_SESSION['emp_type'];
	}
	
	$query = mysql_query("select menu_name from ".ADMMENU." where status='1' and menu_name!='$menu' order by menu_id");
	while($data = mysql_fetch_array ($query)){
		
	$mid = mysql_fetch_array(mysql_query("select * from ".SUBMENUTBL." where menu_name = '".$data['menu_name']."' and status = '1' order by menu_id"));
	$number=mysql_num_rows(mysql_query("select * from ".ACCTBL." where emp_id='".$emp_type_id."' and menu='".$mid['menu_id']."'"));
	if(!empty($emp_type_id) && $number>0){?> 
       
    <li><a href="#"><?php echo $data['menu_name']; ?></a> <?php } else if(empty($emp_type_id)) { ?>
    <li><a href="#"><?php echo $data['menu_name']; ?></a> <?php } ?>   
        <ul>
    
    	<?php
    	$q = mysql_query("select * from ".SUBMENUTBL." where menu_name = '".$data['menu_name']."' and status = '1'");
		while($d = mysql_fetch_array ($q)){
		$num=mysql_num_rows(mysql_query("select * from ".ACCTBL." where emp_id='".$emp_type_id."' and menu='".$d['menu_id']."' and submenu='".$d['submenu_id']."'"));
		if(!empty($emp_type_id) && $num==1)
		{?>
			<li><a href="account.php?page=<?php echo $d['page']; ?>"><?php echo $d['submenu_name']; ?></a></li>
		<?php } else if(empty($emp_type_id)) 
		{ ?>
        	<li><a href="account.php?page=<?php echo $d['page']; ?>"><?php echo $d['submenu_name']; ?></a></li>
    
        <?php }} ?>
    	</ul>
    </li> 
    <?php } ?>   
</ul><?php */?>

  <ul id="MenuBar1" class="MenuBarHorizontal MenuBarActive">
    <li><a href="account.php" class=""><i class="fa fa-home"></i>Dashboard</a></li>   
    
        <li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-bars"></i>CMS</a>    
        <ul class="">
    
    	        	<li><a href="account.php?page=menu">Menus</a></li>
    
                	<li><a href="account.php?page=view_page">Manage Pages</a></li>
    
                	<li><a href="account.php?page=faqs">FAQs</a></li>
					<li><a href="account.php?page=downloads">Downloads</a></li>
					<?php /*?><li><a href="account.php?page=manage-banner">Manage Banner</a></li><?php */?>
    
                	<?php /*?><li><a href="#">News Feeds </a></li><?php */?>
       	  </ul>
    </li> 
        
		<li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-sitemap"></i>Underwritting</a>    
				<ul>
							<li><a href="account.php?page=package">Add New Underwritting</a></li>
							<li><a href="account.php?page=package_list">View/Manage Underwritting</a></li>
				  </ul>
			</li> 
        
        <li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-user"></i>Customers</a>    
        <ul>
    
    	        	<li><a href="account.php?page=customer-list">View/Manage Customers</a></li>
    
       	  </ul>
    </li> 
        <li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-question-circle"></i>Quotes</a>    
        <ul>
    
    	        	<li><a href="account.php?page=policy-quotes-request">Manage Motor Quotes</a></li>
     	        	<li><a href="account.php?page=medical-quotes-request">Manage Medical Quotes</a></li>
   
       	  </ul>
    </li>  
        <li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-list-alt"></i>Reports</a>    
        <ul class="">
    	<li><a href="account.php?page=sales-report" class="">Sales Report</a></li>
       	</ul>
    </li> 
        <li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-pencil-square-o"></i>Claim Center</a>    
        <ul class="">
    				<!--<li><a href="#" class="">Register a New Claim</a></li>-->
    	        	<li><a href="account.php?page=claim-center" class="">List All Claims</a></li>
    
       	  </ul>
    </li>
	<li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-ticket"></i>Brokers</a>    
        <ul>
			<li><a href="account.php?page=add_agent">Add New Broker</a></li>
			<li><a href="account.php?page=agent_list">View/Manage Brokers</a></li>
       	</ul>
    </li> 
	<li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-user"></i>Admin Users</a>    
        		<ul class="">
    	        	<li><a href="account.php?page=create_user">Add Admin Users</a></li>
                	<li><a href="account.php?page=admin_user">View/Manage Admin Users</a></li>
            	</ul>
    </li> 
	
        <li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-users"></i>Employees</a>    
        <ul class="">
    
    	        	<li><a href="account.php?page=add_employee">Add New Employee</a></li>
    
                	<li><a href="account.php?page=employee_list">View/Manage Employees</a></li>
    
                	<li><a href="account.php?page=emp_type">Manage Employee Type</a></li>
    
       	  </ul>
    </li>
	
        <li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-cog"></i>Settings</a>    
        <ul class="">
    
    	        	<li><a href="account.php?page=config" class="">Site Settings </a></li>
    
                	<li><a href="#" class="">Admin Menu Settings</a></li>
    				<li><a href="account.php?page=motor-insurance-settings">Motor Insurance Settings</a></li>
                	<?php /*?><li><a href="account.php?page=manage_sub_menu" class="">Manage Sub Menu</a></li><?php */?>
    
                	<li><a href="#" class="">Admin Access Control </a></li>
    
       	  </ul>
    </li> 
	<li><a href="#" class="MenuBarItemSubmenu"><i class="fa fa-tasks"></i>Master</a>    
        <ul class="">
    				<li><a href="account.php?page=policies">Policies</a></li>
    	        	<?php /*?><li><a href="account.php?page=branches">Branches</a></li>
    				<li><a href="account.php?page=offices">Offices</a></li>
                	<li><a href="account.php?page=business-type">Business Types</a></li>
					<li><a href="account.php?page=doc-type">Document Types</a></li><?php */?>
   	                <li><a href="account.php?page=vehicle">Vehicle</a></li>
                    <li><a href="account.php?page=agency-repair-category">Agency Repair Category</a></li>
                    <li><a href="account.php?page=driver">Driver Age</a></li>
                     <li><a href="account.php?page=deductable-packages">Deductable Packages</a></li>
      </ul>
    </li>  
       
</ul>

<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>