$(document).ready(function(){	
	  $("#Submit").click(function(){
		var From=$("#SMSFrom").val();
		var SMSText=$("#SMSText").val();
		$.ajax({
			type:"GET",
  			url: BaseURL+"/SMSinterface/",
			data:{"From":"123","Body":SMSText},
 			success:function(data){
  				$("#SMSResponse").html(data);
  			},
			error: function(){
				alert("Oops!Something went wrong.");
			}
		});
		return false;
	 });
});
		
