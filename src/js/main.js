$(document).ready(function() {

	//animate the width of the search button
	$("#search_text_input").on("focus", function() {
		if (window.matchMedia("(min-width: 800px)").matches) { //If the window width is minimum 800 px or larger
			$(this).animate({
				"width":"250px"
			}, 500);
		}
	});
	
	//On click search the document for form name = search_form and submit
	$('.button_holder').on('click', function () {
		document.search_form.submit();
	});

	//Ajax call for submitting post on profile page
	$("#submit_profile_post").on("click", function() {
		$.ajax({
			type: "POST",
			url: "includes/handlers/ajax_submit_profile_post.php",
			data: $("form.profile_post").serialize(),
			success: function (msg) {
				$("#post_form").modal("hide");
				location.reload();	
			},
			error: function (jqXHR, exception) {
				if (jqXHR.status === 0) {
		            alert('Not connect.\n Verify Network.');
		        } else if (jqXHR.status == 404) {
		            alert('Requested page not found. [404]');
		        } else if (jqXHR.status == 500) {
		            alert('Internal Server Error [500].');
		        } else if (exception === 'parsererror') {
		            alert('Requested JSON parse failed.');
		        } else if (exception === 'timeout') {
		            alert('Time out error.');
		        } else if (exception === 'abort') {
		            alert('Ajax request aborted.');
		        } else {
		            alert('Uncaught Error.\n' + jqXHR.responseText);
		        }
			}
		});
	});

});

//hide the search friends, notifications and message dropdown on clicking outside these window
$(document).click(function(e){

	if(e.target.class != "search_results" && e.target.id != "search_text_input") {

		$(".search_results").html("");
		$('.search_results_footer').html("");
		$('.search_results_footer').toggleClass("search_results_footer_empty");
		$('.search_results_footer').toggleClass("search_results_footer");
	}

	if(e.target.className != "dropdown_data_window") {

		$(".dropdown_data_window").html("");
		//$(".dropdown_data_window").css({"padding" : "0px", "height" : "0px"});
	}


});

function getUsers (value, user) {
	$.post("includes/handlers/ajax_friend_search.php", {query:value, userLoggedIn:user}, function (data) {
		$(".results").html(data);
	});
}

//Get the data  on navbar for notifications and messages as dropdown
function getDropdownData (user, type) {
	if ($(".dropdown_data_window").css("height") == "0px") {
		var pageName;

		if (type == 'notification') {

			pageName = "ajax_load_notifications.php";
			$("span").remove("#unread_notification");

		} else if (type == 'message') {

			pageName = "ajax_load_messages.php";
			$("span").remove("#unread_message");

		}

		var ajaxreq = $.ajax ({
			url: "includes/handlers/" + pageName,
			type: "POST",
			data: "page=1&userLoggedIn=" + user,
			cache: false,

			success: function (response) {
				$(".dropdown_data_window").html(response);
				$(".dropdown_data_window").css({"padding" : "0px", "height": "auto"});
				$("#dropdown_data_type").val(type);
			}
		});
	}
	else {
		$(".dropdown_data_window").html("");
		$(".dropdown_data_window").css({"padding" : "0px", "height": "0px"});
	}
}

//Get the data on navbar for users search dropdown
function getLiveSearchUsers (value, user) {

	//$.post - Post ajax call -Sends the data to the ajax_search.php file with parameter values of the function 
	//as query and userloggedin and on return run the function with the data which will be query and userloggedin
	
	$.post("includes/handlers/ajax_search.php", {query:value, userLoggedIn: user}, function(data){

		if ($(".search_results_footer_empty")[0]) {

			$(".search_results_footer_empty").toggleClass("search_results_footer");
			$(".search_results_footer_empty").toggleClass("search_results_footer_empty");
		}

		$('.search_results').html(data);
		$('.search_results_footer').html("<a href='search.php?q=" + value + "'>See All Results</a>");

		if (data == "") {

			$('.search_results_footer').html("");
			$('.search_results_footer').toggleClass("search_results_footer_empty");
			$('.search_results_footer').toggleClass("search_results_footer");

		}

	});
}




