<?php 

	if (isset($_POST["login_button"])) {

		$email = filter_var($_POST["login_email"], FILTER_SANITIZE_EMAIL); //Get email and sanitize it

		//Store the email in a session
		$_SESSION["login_email"] = $email;

		$password = md5($_POST["login_password"]); //Get password in md5 format - Password was saved into database in md5 format as well

		//Check database if the above details exists
		
		$checkQuery = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
		$run_checkQuery = mysqli_query ($connection, $checkQuery);

		//Check if data exists by counting the row data
		$rowCount = mysqli_num_rows($run_checkQuery);

		//If row count is 1 - Then data exists
		if ($rowCount == 1) {

			//Get the data in an array
			$dataRows = mysqli_fetch_array($run_checkQuery);

			//Fetch the username value from the array
			$username = $dataRows["username"];

			//If the account is closed (check database = user_closed) - Reactivate it when logged in
			
			//Select the email and user_closed values from database	
			$userClosedQuery = "SELECT * FROM users WHERE email = '$email' AND user_closed = 'yes'";
			$run_userClosedQuery = mysqli_query ($connection, $userClosedQuery);

			$countUserClosed = mysqli_num_rows($run_userClosedQuery);

			//Change the user_closed to no if $countUserClosed count found
			if ($countUserClosed == 1) {

				$activateQuery = "UPDATE users SET user_closed = 'no' WHERE email = '$email'";
				$run_activateQuery = mysqli_query ($connection, $activateQuery);

			}

			//Store the username in to a session
			$_SESSION["username"] = $username;			

			//Redirect to index.php page
			header ("Location: index.php");
			exit;

		} else {
			array_push($error_array, $loginFailed);
		}

	}

?>