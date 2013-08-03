$(document).ready(function(){	
	  $("#Submit").click(function(){
		var From=$("#SMSFrom").val();
		var SMSText=$("#SMSText").val();
		$("#SMSResponse").html("<div>Loading...</div>");
		$.ajax({
			type:"GET",
  			url: BaseURI+"/simulator/getResponse",
			data:{"From":"123","Body":SMSText,"format":"html"},
			success:function(data){
				$("#SMSResponse").empty();
  				$("#SMSResponse").html(data);
  			},
			error: function(){
				$("#SMSResponse").empty();
				alert("Oops!Something went wrong.");
			}
		});
		return false;
	 });
});
		
