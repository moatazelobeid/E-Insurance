// JavaScript Document
function mass_validate(){
	fn=document.maasmail_form;
	document.getElementById('mail_div').innerHTML='';
	if(fn.select_email.value==0){
		document.getElementById('mail_div').innerHTML='Select Email';
		fn.select_email.focus();
		fn.select_email.style.borderColor='red';
		return false;
		}else{
		fn.select_email.style.borderColor='';
		}	
	if(fn.e_subject.value.length==0){
		document.getElementById('mail_div').innerHTML='Enter Subject';
		fn.e_subject.focus();
		fn.e_subject.style.borderColor='red';
		return false;
		}else{
		fn.e_subject.style.borderColor='';
		}
	/*if(fn.e_messege.value.length==0){
		document.getElementById('mail_div').innerHTML='Enter Messege';
		fn.e_messege.focus();
		fn.e_messege.style.borderColor='red';
		return false;
		}else{
		fn.e_messege.style.borderColor='';
		}*/
	return true;
}// JavaScript Document