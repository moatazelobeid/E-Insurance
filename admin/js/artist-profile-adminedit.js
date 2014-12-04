// JavaScript Document
function validate_fields()
{
	var str = document.artist_profile_edit;
	var error = "";
	var flag = false;
	var dataArray = new Array();
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;	
	
	if(str.fname.value == "")
	{
		str.fname.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter your first name";
		return false;
	}
	else
	{
		str.fname.style.borderColor = "";
	}
	
	if(str.lname.value == "")
	{
		str.lname.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter your Last name";
		return false;
	}
	else
	{
		str.lname.style.borderColor = "";
	}
	
	if(str.address1.value == "")
	{
		str.address1.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter address1";
		return false;
	}
	else
	{
		str.address1.style.borderColor = "";
	}
	

	if(str.city.value == "")
	{
		str.city.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter your city";
		return false;
	}
	else
	{
		str.city.style.borderColor = "";
	}
	
	if(str.state.value == "")
	{
		str.state.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Select your state";
		return false;
	}
	else
	{
		str.state.style.borderColor = "";
	}
	
	if(str.country.value == "")
	{
		str.country.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Select your country";
		return false;
	}
	else
	{
		str.country.style.borderColor = "";
	}
	
	if(str.zip.value == "")
	{
		str.zip.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter zip code";
		return false;
	}
	else
	{
		str.zip.style.borderColor = "";
	}
	
	if(str.phone1.value == "")
	{
		str.phone1.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter your phone number";
		return false;
	}
	else
	{
		str.phone1.style.borderColor = "";
	}
	
	if(str.phone2.value == "")
	{
		str.phone2.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter your phone number";
		return false;
	}
	else
	{
		str.phone2.style.borderColor = "";
	}
	
	if(str.phone3.value == "")
	{
		str.phone3.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter your phone number";
		return false;
	}
	else
	{
		str.phone3.style.borderColor = "";
	}
	if(str.email.value == "")
	{
		str.email.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter your email ID";
		return false;
	}
	else if(reg.test(str.email.value) == false) 
	{
		str.email.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter valid email ID";
		return false;
	}
	else
	{
		str.email.style.borderColor = "";
	}	
	if(str.uname.value == "")
	{
		str.uname.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter your username";
		return false;
	}
	else
	{
		str.uname.style.borderColor = "";
	}
	if(str.password.value == 0)
	{
		str.password.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter password";
		return false;
	}
	else
	{
		str.password.style.borderColor = "";
	}
	if(str.desc.value == "")
	{
		str.desc.style.borderColor = "RED";
		document.getElementById("error").innerHTML = "Enter your description";
		return false;
	}
	else
	{
		str.desc.style.borderColor = "";
	}
}

function check_uname_exists(uname,ses)
{ 
if(uname != '')
{
	$.ajax({
         type: "POST",
         url: "util/artist_edit_admincheck.php",
         data: "uname="+ uname+"&ses="+ ses,
         success: function(msg){
		 if(msg == 'ERROR')
			{
				document.getElementById("uname").style.borderColor = 'RED';
				document.getElementById("error").innerHTML = "This username is already taken";
				document.getElementById('uname').value = "";
				document.getElementById('uname').focus();
			}else if(msg == 'OK')
			{ 
				document.getElementById("error").style.display = 'none';
			}
			}    
		});
}
}

function isNumberKey(evt)
{
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
	 else
     return true;
}
function checkEmail(id,artid)
    {    
    $.ajax({
         type: "POST",
         url: "util/check_artistadmin_email.php",
         data: "email="+ id+"&ses="+ artid,
         success: function(msg){
		 if(msg == 'ERROR')
			{
				
				document.getElementById("error").innerHTML = "This email ID is already registered";
				document.getElementById('email').style.borderColor = 'RED' ;
				document.getElementById('email').value = '' ;	
		  } else if(msg == 'OK')
			{
				document.getElementById("error").style.borderColor = '';
				document.getElementById('email').style.borderColor = '' ;
			}  
		 }
		});
	}
