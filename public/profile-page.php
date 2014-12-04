<?php 
	if(empty($_SESSION['uid']))
	{
		header("location:index.php?page=sign-in");
	}else{
?>


<div id="signup-form">

<!--BEGIN #subscribe-inner -->
		<div><span id="errmsg"></span></div>
        <div id="signup-inner">
        	<div class="clearfix" id="header">
                <h1>Welcome <?=$_SESSION['uname']?> to your dashboard</h1> <br />
                 <ul style="float:left;">
                	<li>
                        <a class="list-group-item" href="index.php?page=user-dashboard"><i class="icon-home icon-1x"></i>My dashboard</a>
                    </li>
                    <li>
                        <a class="list-group-item" href="index.php?page=edit-profile"><i class="icon-home icon-1x"></i>Edit your profile</a>
                    </li>
                     <li>
                        <a class="list-group-item" href="index.php?page=change-password"><i class="icon-home icon-1x"></i>Change Password</a>
                    </li>
                     <li>
                       <a href="index.php?page=sign-in&logoff=1">Logout</a>
                    </li>
                    
                </ul>
            </div>
            </div>
 <!--END #signup-inner -->
</div>


<? } ?>