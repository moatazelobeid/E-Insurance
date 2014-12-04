
function validEmail(x)
{ 
	var atpos=x.indexOf("@");

	var dotpos=x.lastIndexOf(".");

	if(atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
		return false;
	}
	else
	{
		return true;	
	}
}
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

 return true;
}

function addWife()
{
	var ischecked = $('#add_wife').is(':checked');
	//alert(ischecked);
	
	if(ischecked == true)
	{
		$('#add_wife_div').show(1000);	
	}	
	else
	{
		$('#add_wife_div').hide(1000);		
	}
}
function addChildren()
{
	var ischecked = $('#add_children').is(':checked');
	
	if(ischecked == true)
	{
		$('#add_children_div').show(1000);	
	}	
	else
	{
		$('#add_children_div').hide(1000);		
	}
}

function addInsuredPerson()
{
	var cnt = parseInt($('#total_insured_person').val());
	
	var new_cnt = cnt+1;
	
	var gender = '<select name="inp_gender[]" id="inp_gender_'+new_cnt+'"><option value="">Gender</option><option value="2">Male</option><option value="1">Female</option></select>';
	
	var existing_disability = '<select name="inp_gender[]" id="inp_gender_'+new_cnt+'"><option value="">Yes</option><option value="2">Male</option><option value="1">No</option></select>';
	
	
	var relship = '<select name="inp_rel[]" id="inp_rel_'+new_cnt+'">'+relationship_options+'</select>';
	
	if(new_cnt == 1)
	{
		var html = '<tr id="insured_person_'+new_cnt+'"><td><input type="text" autocomplete="off" name="inp_name[]" id="inp_name'+new_cnt+'"></td><td>'+gender+'</td><td>'+relship+'</td><td><input type="text" class="dob_calender" autocomplete="off" name="inp_dob[]" id="inp_dob_'+new_cnt+'"></td><td><input type="text" autocomplete="off" name="inp_occup[]" id="inp_occup_'+new_cnt+'"></td><td><input type="text" autocomplete="off" name="inp_iqma[]" id="inp_iqma_'+new_cnt+'"></td><td>'+existing_disability+'<a href="javaScript:void(0);" id="inpclose_'+new_cnt+'" onclick="removeInsuredPerson('+new_cnt+')">X</a></td></tr><tr id="inp_'+new_cnt+'"><td colspan="7" style="border-bottom:1px solid #e0e0e0"></td></tr>';	
		$('#inp_data').append(html);	
	}
	else
	{
		var html = '<tr id="inp_'+new_cnt+'"><td colspan="7" style="border-bottom:1px solid #e0e0e0"></td></tr><tr id="insured_person_'+new_cnt+'"><td><input type="text" autocomplete="off" name="inp_name[]" id="inp_name'+new_cnt+'"></td><td>'+gender+'</td><td>'+relship+'</td><td><input type="text" autocomplete="off" class="dob_calender"  name="inp_dob[]" id="inp_dob_'+new_cnt+'"></td><td><input type="text" autocomplete="off" name="inp_occup[]" id="inp_occup_'+new_cnt+'"></td><td><input type="text" autocomplete="off" name="inp_iqma[]" id="inp_iqma_'+new_cnt+'"></td><td>'+existing_disability+'<a href="javaScript:void(0);" id="inpclose_'+new_cnt+'" onclick="removeInsuredPerson('+new_cnt+')">X</a></td></tr>';	
		$('#insured_person_'+cnt).after(html);
		//$('#inp_data').append(html);
	}
	$('#total_insured_person').val(new_cnt);
	
	var d = new Date();
	var maxdobyr = d.getFullYear() - 18;
	d.setFullYear(maxdobyr);
	
	$( ".dob_calender" ).datepicker({dateFormat: 'dd-mm-yy' , changeYear: 'true' , yearRange: '1950:'+maxdobyr , changeMonth: 'true',
defaultDate: d  } );
	
}

function removeInsuredPerson(id)
{
	$('#insured_person_'+id).remove();
	$('#inp_'+id).remove();
	var cnt = parseInt($('#total_insured_person').val());
	var idval = '';
	
	for(var i=id; i<cnt; i++)
	{
		
		var idd = (parseInt(i)+1);
		
		idval = 'insured_person_'+i; 
		
		$('#insured_person_'+idd).attr('id',idval);	
		
		$('#inp_'+idd).attr('id','inp_'+i);
		
		$('#inpclose_'+idd).removeAttr('onclick'); 
		
		$('#inpclose_'+idd).attr('onClick', 'removeInsuredPerson('+i+')');
		
		$('#inpclose_'+idd).attr('id','inpclose_'+i);
		
		//$('#insured_person_'+idd+' a').attr('onclick',removeInsuredPerson(i));	
	}
	var new_cnt = cnt-1;
	$('#total_insured_person').val(new_cnt);
}

function validStep1Form()
{
	var form = document.step1_form;
	var flag = true;
	var fields = new Array();
	
	if(!/\S/.test(form.name.value))
	{
		$('#name').css( "border-color", "red" );
		flag = false;	
		fields.push('name');
	}
	else
	{
		$('#name').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.dob.value))
	{
		$('#dob1').css( "border-color", "red" );
		flag = false;	
		fields.push('dob1');
	}
	else
	{
		$('#dob1').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.occupation.value))
	{
		$('#occupation').css( "border-color", "red" );
		flag = false;	
		fields.push('occupation');
	}
	else
	{
		$('#occupation').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.iqma_no.value))
	{
		$('#iqma_no').css( "border-color", "red" );
		flag = false;	
		fields.push('iqma_no');
	}
	else
	{
		$('#iqma_no').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.nationality.value))
	{
		$('#nationality').css( "border-color", "red" );
		flag = false;	
		fields.push('nationality');
	}
	else
	{
		$('#nationality').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.gender.value))
	{
		$('#gender').css( "border-color", "red" );
		flag = false;	
		fields.push('gender');
	}
	else
	{
		$('#gender').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.network_class.value))
	{
		$('#network_class').css( "border-color", "red" );
		flag = false;	
		fields.push('network_class');
	}
	else
	{
		$('#network_class').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.chronoc_diseases.value))
	{
		$('#chronoc_diseases').css( "border-color", "red" );
		flag = false;	
		fields.push('chronoc_diseases');
	}
	else
	{
		$('#chronoc_diseases').css( "border-color", "#999" );
	}
	
	if(fields.length>0)
	{
		var fld = fields[0];
		
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}

function validStep2Form()
{
	var cnt = 0;
	
	if ($('input[name=package_no]:checked').length == 0)
	{
		cnt = 1;
	}
	if (cnt > 0) 
	{
		alert('Please select any package type');
		return false;
	}
}

function addAttchment()
{
	var atch_cnt = parseInt($('#atch_count').val());
	//alert(atch_cnt);
	var cnt = atch_cnt+1;
	
	var data = '<div id="atch_'+cnt+'"><div class="listcross"><div class="row1" style="float:left;width: 48%;clear: inherit;"><lable>Document Title *</lable><input type="text" name="atch_title[]" id="atch_title_'+cnt+'" /></div><div class="row1" style="float:left;width: 48%;clear: inherit;margin-left: 4%;height:70px;"><lable>Attachment *</lable><input type="file" name="atch_file[]" id="atch_file_'+cnt+'" /><span class="cross" onclick="delAttchment('+cnt+');">X</span></div></div>';	
	$('#atch_'+atch_cnt).after(data);
	$('#atch_count').val(cnt);
}

function delAttchment(id)
{
	$('#atch_'+id).remove();
	var atch_cnt = parseInt($('#atch_count').val());
	var cnt = atch_cnt-1;
	$('#atch_count').val(cnt);
}

function getPolicyEndDate(date1)
{
	var enddate = '';
	
	var dt  = date1.split('-');
	
	var day = dt[0];
	var month = dt[1];
	var year = dt[2];

	//enddate = month+'/'+day+'/'+(parseInt(year)+1);
	
	enddate = day+'-'+month+'-'+(parseInt(year)+1);
	
	$('#insured_period_enddate').val(enddate);	
	//alert(enddate);
}


function validStep3Form()
{
	var form = document.step3_form;
	var flag = true;
	var fields = new Array();
	
	if(!/\S/.test(form.title.value))
	{
		$('#title').css( "border-color", "red" );
		flag = false;	
		fields.push('title');
	}
	else
	{
		$('#title').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.name.value))
	{
		$('#name').css( "border-color", "red" );
		flag = false;	
		fields.push('name');
	}
	else
	{
		$('#name').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.dob.value))
	{
		$('#dob1').css( "border-color", "red" );
		flag = false;	
		fields.push('dob1');
	}
	else
	{
		$('#dob1').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.gender.value))
	{
		$('#gender').css( "border-color", "red" );
		flag = false;	
		fields.push('gender');
	}
	else
	{
		$('#gender').css( "border-color", "#999" );
	}
	if(!validEmail(form.email.value))
	{
		form.email.style.borderColor='red';
		flag = false;	
		fields.push('email');
	}
	else
	{
		form.email.style.borderColor='#B6B6B6';
	}
	if(!/\S/.test(form.phone_mobile.value))
	{
		$('#phone_mobile').css( "border-color", "red" );
		flag = false;	
		fields.push('phone_mobile');
	}
	else
	{
		$('#phone_mobile').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.country.value))
	{
		$('#country').css( "border-color", "red" );
		flag = false;	
		fields.push('country');
	}
	else
	{
		$('#country').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.state.value))
	{
		$('#state').css( "border-color", "red" );
		flag = false;	
		fields.push('state');
	}
	else
	{
		$('#state').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.drive_license_no.value))
	{
		$('#drive_license_no').css( "border-color", "red" );
		flag = false;	
		fields.push('drive_license_no');
	}
	else
	{
		$('#drive_license_no').css( "border-color", "#999" );
	}
	if(!/\S/.test(form.insured_period_startdate.value))
	{
		$('#insured_period_startdate').css( "border-color", "red" );
		flag = false;	
		fields.push('insured_period_startdate');
	}
	else
	{
		$('#insured_period_startdate').css( "border-color", "#999" );
	}
	
	if(fields.length>0)
	{
		var fld = fields[0];
		
		$('#'+fld).focus();
		flag = false;	
	}
	return flag;
}

function validStep4Form()
{
	if(document.getElementById('accept_terms').checked == false)
	{
		alert('Accept terms and conditions');
		return false;	
	}
}

