function valid_form()
{
	var str = document.art_edit;
	var error = "";
	var flag = true;
	var dataArray = new Array();
	
	//alert("hi");
	
	if(str.category.value == "")
	{
		str.category.style.borderColor = "RED";
		error += "- Select Category\n";
		flag = false;
		dataArray.push('category');
	}
	else
	{
		str.category.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	 if(str.subcat.value == "")
	{
		str.subcat.style.borderColor = "RED";
		error += "- Select Sub_category \n";
		flag = false;
		dataArray.push('subcat');
	}
	else
	{
		str.subcat.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	} 
	if(str.type.value == "")
	{
		str.type.style.borderColor = "RED";
		error += "- Select Type\n";
		flag = false;
		dataArray.push('type');
	}
	else
	{
		str.type.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
	if(str.atitle.value == "")
	{
		//alert("hi");
		str.atitle.style.borderColor = "RED";
		error += "- Enter Art Title\n";
		flag = false;
		dataArray.push('atitle');
	}
	
	else
	{
		str.atitle.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
	if(str.part_num.value == "")
	{
		str.part_num.style.borderColor = "RED";
		error += "- Enter Part Number\n";
		flag = false;
		dataArray.push('part_num');
	}
	
	else
	{
		str.part_num.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
	/*if(str.height.value == "")
	{
		str.height.style.borderColor = "RED";
		error += "- Enter height\n";
		flag = false;
		dataArray.push('height');
	}
	else
	{
		str.height.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}

	if(str.width.value == "")
	{
		str.width.style.borderColor = "RED";
		error += "- Enter width\n";
		flag = false;
		dataArray.push('width');
	}
	else
	{
		str.width.style.borderColor = "";
		flag = true;
		dataArray.pop();
	}*/
	
	if(str.qnty.value == "")
	{
		str.qnty.style.borderColor = "RED";
		error += "- Enter quantity\n";
		flag = false;
		dataArray.push('qnty');
	}
	else
	{
		str.qnty.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
	
	if(str.price.value == "")
	{
		str.price.style.borderColor = "RED";
		error += "- Enter price\n";
		flag = false;
		dataArray.push('price');
	}
	else
	{
		str.price.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
	
	/*if(str.hidden.value == "")
	{
		$("#photo").css("border","1px solid red");
		error += "- Upload a Photo\n";
		flag = false;
		dataArray.push('hidden');
	}
	else
	{
		$("#photo").css("border","0px");
		//str.photo.style.borderColor = "";
		//flag = true;
		//dataArray.pop();
	}
		*/
	if(flag == false){
		alert(error);
		str.elements[dataArray[0]].focus();
		return false;
	}else{
		return true;
	}
}

 function checkIt(evt)
{
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
       alert('This field accepts numbers only');
        return false;
    }
    status = "";
    return true;
}

function add_pht()

{
	
	var phttr=document.createElement("tr");
	
	var phttd=document.createElement("td");
	
	var elm=document.createElement("input");
	
	elm.setAttribute('type','file');
	
	elm.setAttribute('name','photos[]');
	
	elm.setAttribute('size','17');
	
	phttd.appendChild(elm);
	
	phttr.appendChild(phttd);
	
	document.getElementById("mpht").appendChild(phttr);
	
}


function remove_pht()

{
	 
           
            var table = document.getElementById("mpht");
            var rowCount = table.rows.length;
			
			//alert(rowCount);
			
			table.deleteRow(rowCount-1);	
}

function check_file(v){
$("#hidden").val(v);		
}