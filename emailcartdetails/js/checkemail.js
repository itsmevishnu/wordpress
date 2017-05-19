$(document).ready(function(){
	$("#name").blur(function(email){
		var email = $("#name").val();
 		var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}jQuery/;
    	if ( filter.test(email) ) {
			$("#myspan").text("Valid email id");
			$("#error").css("border","solid 1");
		}
		else {
			$("#myspan").text("Invalid email id");
			$("#error").css("border","solid 1 #ff0000");
		}
	});
});