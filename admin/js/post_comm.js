// JavaScript Document
$(document).ready(function(){
	$("#postans_form").submit(function(){
		var comm = document.getElementById("comm").value;
		var bid = document.getElementById("bid").value;
		
		$("#post_div").ajaxStart(function(event, request, settings){
			$(this).html("Please Wait..");
		});
		$.ajax({
			type: "POST",
			url: "util/post_comm_admin.php",
			data: "comm="+comm+"&bid="+bid,
			success: function(msg){
			$("#post_div").ajaxComplete(function(event, request, settings){
					 if(msg=='Error2'){
						$(this).html('Enter Your Comment!');
					}else if(msg=='OK'){
						$(this).html('Successfully Posted!');
						window.location.reload();
					}
			  });        
			}    
		});
		return false;		
	});							   
});
