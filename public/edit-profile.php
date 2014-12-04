<?php 
//echo date("Y-m-d H:i:s");;
if(empty($_SESSION['uid']))
{
	header("location:index.php?page=sign-in");
}else{
	$userid = $_SESSION['uid'];
	if(isset($_POST['update']))
	{ 
			$_POST['dob'] = date("Y-m-d H:i:s",strtotime($_POST['dob']));
			
			$update_arr =array("fname"=>$_POST['fname'],"accno"=>$_POST['accno'],"dob"=>$_POST['dob'],"lname"=>$_POST['lname'],"address1"=>$_POST['address'],"phone_mobile"=>$_POST['phone_mobile'],"phone_landline"=>$_POST['phone_landline']);
			$record_ins1 = $db->recordUpdate(array("id" => $userid),$update_arr,USERTBL);
			if(mysql_affected_rows() > 0)
			{
				$msg="<font color='#009933'></font><font color='#009933'>Your profile is updated sucessfully</font>";
	
			}else
			{
				$msg="<font color='red'></font><font color='#009933'>Profile updation failed</font>";
			}
	}



$datalists = $db->recordFetch($userid,USERTBL.":".'id');


?>
<script type="text/javascript">
function validForm(){ 

	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var str = document.quotation_form;
	var error = "";
	var flag = false;
	
	var dataArray = new Array();
	var fname = $("#fname").val();
	var lname = $("#lname").val();
	var phone_mobile = $("#phone_mobile").val();
	var dob = $("#dob").val();
	var phone_allow=/^[0-9 \.-]+$/;
	if(fname == '' || lname =='' || dob =='' || (phone_mobile=='' || !phone_allow.test(phone_mobile)))
	{
		if(fname =='')
		{
			$("#fname").css("border-color","red");
			$("#fname").focus();
			return false;
		}
		else
		{
			$("#fname").css("border-color","");
			
		}
		if(lname =='')
		{
			$("#lname").css("border-color","red");
			$("#lname").focus();
			return false;
		}
		else
		{
			$("#lname").css("border-color","");
			
		}
		if(phone_mobile =='')
		{
			$("#phone_mobile").css("border-color","red");
			$("#phone_mobile").focus();
			return false;
		}else if(!phone_allow.test(phone_mobile))
		{
			$("#phone_mobile").focus();
			$("#phone_mobile").attr('placeholder','Enter valid phone no');
			$("#phone_mobile").css("border-color", "#990000");
			return false;
		}
		else
		{
			$("#phone_mobile").css("border-color","");
			
		}
		if(dob =='')
		{
			$("#dob").css("border-color","red");
			$("#dob").focus();
			return false;
		}
		else
		{
			$("#dob").css("border-color","");
			
		}
	}
	else
	{
		document.getElementById("quotation_form").submit();
	}
}



</script>

<div id="signup-form">
<?php if(isset($msg))
		{ ?>
		<div><span><?=$msg?></span></div>
 <?php }?>
<!--BEGIN #subscribe-inner -->
		<div><span id="errmsg"></span></div>
        <div id="signup-inner">
        <div style="float:right;"><span id="errmsg"></span><a href="index.php?page=user-dashboard">&lt;&nbsp;Back to dashboard</a></div>
        	<div class="clearfix" id="header">
                <h1>Edit your profile!</h1>
            </div>
            <form id="quotation_form" name="pr_frm" action=""   method="post">   
             	<p>
                <label for="Username">Username or email :</label>
              	<span><?php  echo getElementVal('email',$datalists);  ?></span>
                </p> 
            	 <p>
                <label for="Account Number">Account number</label>
               <input name="accno" type="text" id="accno" tabindex="3" autocomplete="off" value="<?php  echo getElementVal('accno',$datalists);  ?>"  />
                </p>         
                <p>
                <label for="Fname">First Name *</label>
               <input name="fname" type="text" id="fname" tabindex="3" autocomplete="off" value="<?php  echo getElementVal('fname',$datalists);  ?>"  />
                </p>
                 <p>
                <label for="lname">Last Name *</label>
                 <input name="lname" type="text" id="lname" tabindex="3" autocomplete="off" value="<?php  echo getElementVal('lname',$datalists);  ?>"  />
                </p>
               
                
                 <p>
                <label for="mobile_no">Phone(M) *</label>
                <input id="phone_mobile" type="text" name="phone_mobile" value="<?php  echo getElementVal('phone_mobile',$datalists);  ?>" />
                </p>
                
                <p>
                <label for="mobile_no">Phone(L)</label>
                <input id="phone_landline" type="text" name="phone_landline" value="<?php  echo getElementVal('phone_landline',$datalists);  ?>" />
                </p>
                <p>
                <label for="mobile_no">Address</label>
                <textarea id="address1"  name="address" value="" ><?php  echo getElementVal('address1',$datalists);  ?></textarea>
                </p>
                 <p>
                <label for="dob">Date of Birth *</label>
                <input id="dob" type="text" autocomplete="off" class="dateofbirth" name="dob" value="<?php  echo date('d/m/y',strtotime(getElementVal('dob',$datalists)));  ?>" />
                </p>
                <p>
				<input type="hidden" name="update" id="update" />
                <input type="button" onclick="validForm();" value="Update"  name="update" id="save"  />
                </p>
                 
                  
            </form>
            
		<div id="required">
		<p>* Required Fields<br/></p>
		</div>


            </div>
        
        <!--END #signup-inner -->
        </div>
<?php } ?>