<?php 

	include ("includes/header.php");

	if (isset($_POST["cancel"])) {
		header ("Location: settings.php");
	}

	if (isset($_POST["close_account"])) {
		$close_query = mysqli_query ($connection, "UPDATE users SET user_closed = 'yes' WHERE username='$userLoggedIn'");
		session_destroy();
		header ("Location: register.php");
	}

?>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 bg-white bg-1">
        	<h4 class="text-center text-info pt-3">Close Account</h4>
        	<p class="text-center lead">Are you sure you want to close your account?</p>
        	<p class="text-center text-muted">Closing your account will hide your profile and all your activity from other users.</p>
        	<p class="text-center text-muted">You can re-open your account at any time by simply logging in</p>
			<div class="row">
	        <div class="col-md-3"></div>
	        <div class="col-md-6 bg-white">	
	        	<form action="close_account.php" method="POST">
	    			<div class="form-group">
	    				<input type="submit" name="close_account" id="close_account" class="form-control btn btn-danger" value="Yes! Close it!">
	    			</div>
	    			<div class="form-group">
	    				<input type="submit" name="cancel" id="update_details" class="form-control btn btn-success" value="No way!">
	    			</div>
	        	</form>
	        </div>
	        <div class="col-md-3"></div>
	        </div>	
        </div>
    </div>    
</div>        