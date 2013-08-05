$(document).ready(function(){	
	  $("#Submit").click(function(){
		var From=$("#SMSFrom").val();
		var SMSText=$("#SMSText").val();
		$("#SMSResponse").html("<div>Loading...</div>");
		$("#SMSResponseCount").html("<div>Loading...</div>");
		$.ajax({
			type:"GET",
			dataType: "xml",
  			url: BaseURI+"/simulator/getResponse",
			async: true,
			data:{"From":"123","Body":SMSText,"format":"xml"},
			success:function(xml){
				$("#SMSResponse").empty();
				var data = $('Sms',xml).text();
  				$("#SMSResponse").html(data);
				var responseLength=$.trim($("#SMSResponse").html()).length;
				$("#SMSResponseCount").html(responseLength);
				if(responseLength>SMSCharacterLimit)
				{
					$("#countPanel").addClass("panel-danger");
					$("#responsePanel").addClass("panel-danger");
				}
				else
				{
					$("#countPanel").addClass("panel-success");
					$("#responsePanel").addClass("panel-success");
				}
  			},
			error: function(){
				$("#SMSResponse").empty();
				$("#SMSResponseCount").empty();
				alert("Oops!Something went wrong.");
			}
		});
		return false;
	 });
});
		
