<?php 

	include ("includes/header.php");
	include ("includes/form_handlers/settings_handler.php");

?>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 bg-white bg-1">
        	<div class="row">
        		<div class="col-md-3"></div>
        		<div class="col-md-6 text-center py-3 bg-light p-3">

		        	<h4 class="text-info py-3">Account Settings</h4>
		        	<?php 
		        		echo "<img src='" . $userDetailsQueryRow['profile_pic'] . "' id='small_profile_pics'>";
		        	?>
		        	<a href="upload.php"><p class="small lead text-info pt-3">Upload New Profile Picture</p></a><hr>

		        	<h4 class="text-info">Update your details below</h4>
		        		<?php 
		        			//Get the user data for form values
		        			$user_data_query = mysqli_query ($connection, "SELECT * FROM users WHERE username='$userLoggedIn'");
							$row = mysqli_fetch_array($user_data_query);

		        			$first_name = $row["first_name"];
							$last_name = $row['last_name'];
							$email = $row['email'];

		        		?>
		        		<?php
		        			//Status message 
		        			echo $message;
		        		?>
		        	</p>
		        	<form action="settings.php" method="POST">
		    			<div class="form-group">
		    				<label>First Name:</label>
		    				<input class="form-control" type="text" name="first_name" value="<?php echo $first_name; ?>">
		    			</div>
		    			<div class="form-group">
		    				<label>Last Name:</label>
		    				<input class="form-control" type="text" name="last_name" value="<?php echo $last_name; ?>">
		    			</div>
		    			<div class="form-group">
		    				<label>Email:</label>
		    				<input class="form-control" type="email" name="email" value="<?php echo $email; ?>">
		    			</div>
		    			<div class="form-group">
		    				<input class="form-control btn btn-success" type="submit" name="update_details" id="save_details" value="Update Details">
		    			</div>
		        	</form><hr>

					<h4 class="text-info">Change Password</h4>
						<?php
		        			//Status message 
		        			echo $password_message;
		        		?>
		        	<form action="settings.php" method="POST">
		    			<div class="form-group">
		    				<label>Old Password:</label>
		    				<input class="form-control" type="password" name="old_password">
		    			</div>
		    			<div class="form-group">
		    				<label>New Password:</label>
		    				<input class="form-control" type="password" name="new_password_1">
		    			</div>
		    			<div class="form-group">
		    				<label>New Password:</label>
		    				<input class="form-control" type="password" name="new_password_2">
		    			</div>
		    			<div class="form-group">
		    				<input class="form-control btn btn-success" type="submit" name="update_password" id="save_password" value="Update Password">
		    			</div>
		        	</form><hr>

		        	<h4 class="text-info">Close Account</h4>
		        	<form action="settings.php" method="POST">
		    			<div class="form-group">
		    				<input class="form-control btn btn-danger" type="submit" name="close_account" id="close_account" value="Close Account">
		    			</div>
		        	</form>

	        	</div>
			</div>
			<div class="col-md-3"></div>
        </div>
    </div>
</div>        