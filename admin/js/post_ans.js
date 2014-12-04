// JavaScript Document
$(document).ready(function(){
	$("#postans_form").submit(function(){
		var ans = document.getElementById("ans").value;
		var pid = document.getElementById("pid").value;
		
		$("#post_div").ajaxStart(function(event, request, settings){
			$(this).html("Please Wait..");
		});
		$.ajax({
			type: "POST",
			url: "util/post_ans.php",
			data: "ans="+ans+"&pid="+pid,
			success: function(msg){
			$("#post_div").ajaxComplete(function(event, request, settings){
					 if(msg=='Error2'){
						$(this).html('Enter Your Answer!');
					}else if(msg=='OK'){
						$(this).html('Successfully Saved!');
						window.location.reload();
					}
			  });        
			}    
		});
		return false;		
	});							   
});
