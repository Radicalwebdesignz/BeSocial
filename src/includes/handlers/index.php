/*

	When trying to post from user profile page, the server is giving error message
	404 page not found -> http://localhost/BeSocial/src/includes/handlers/index.php

	Here the javascript is pulling the action attribute from the form which is set to action=''.
	since the root file is index.php it is taking the action as index.php and trying to send data to that url with an AJAX request.
	which means your JavaScript will try to submit this information to http://localhost/BeSocial/src/includes/handlers/index.php,this page doesn't exist, so it's throwing a 404 error. 

	Here, if you want to get rid of the 404 error, you could change the action to /index.html. It still won't process your form, but you should no longer see this error.

	But the action='' should be left blank. if left blank, the form gets the data from the current page which is profile.php..In our case, the profile.php changes to profile.php/username - See htaccess file where we have set this action

	Fix - Instead of changing the action to index.html, placed an empty index.html in handlers folder for javascript to find it.

 */