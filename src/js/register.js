$(document).ready(function() {

	//Hide login button and show register button
	
	$("#login").on("click", function() {
		$("#first").slideUp("slow", function() {
			$("#second").slideDown("slow");
		});
	});

	//Hide signup button and show login button
	
	$("#signup").on("click", function() {
		$("#second").slideUp("slow", function() {
			$("#first").slideDown("slow");
		});
	});

});