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
			data:{"From":From,"Body":SMSText,"format":"xml"},
			success:function(xml){
				$("#SMSResponse").empty();
				var data = $('Sms',xml).text();
  				$("#SMSResponse").html(data);
				var responseLength=$.trim($("#SMSResponse").html()).length;
				$("#SMSResponseCount").html(responseLength);
				$("#countPanel").removeClass("panel-danger");
				$("#responsePanel").removeClass("panel-danger");
				$("#countPanel").removeClass("panel-success");
				$("#responsePanel").removeClass("panel-success");
				if(responseLength>SMSCharacterLimit)
				{
					$("#countPanel").addClass("panel-danger");
					$("#responsePanel").addClass("panel-danger");
					$("#countHeading").html("Character Count is more than SMS character limit");
				}
				else
				{
					$("#countPanel").addClass("panel-success");
					$("#responsePanel").addClass("panel-success");
					$("#countHeading").html("Character Count:");
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
		
