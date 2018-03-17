<?php 

	//Handler for user details update
	if (isset($_POST['update_details'])) {
		//$userLoggedIn = $_SESSION["username"];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];

		$email_check = mysqli_query ($connection, "SELECT * FROM users WHERE email='$email'");
		$row = mysqli_fetch_array($email_check);
		$matched_user = $row["username"];

		if ($matched_user == "" || $matched_user == $userLoggedIn) {
			$message = "<p class='alert alert-success'>Details Updated!</p>";

			$query = mysqli_query ($connection, "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email' WHERE username='$userLoggedIn'");
		} else {
			$message = "<p class='alert alert-success'>Updated email is already in use!!</p>";
		}

	} //end of if (isset($_POST['update_details']))
	else {
		$message = "";
	}

	//Handler for password change
	
	if (isset($_POST["update_password"])) {

		$old_password = strip_tags($_POST['old_password']);
		$new_password_1 = strip_tags($_POST['new_password_1']);
		$new_password_2 = strip_tags($_POST['new_password_2']);

		$password_query = mysqli_query ($connection, "SELECT password FROM users WHERE username='$userLoggedIn'");
		$row = mysqli_fetch_array($password_query);

		$db_password = $row["password"];

		if (md5($old_password) == $db_password) {

			if ($new_password_1 == $new_password_2) {

				if (strlen($new_password_1) <= 4) {
					$password_message = "<p class='alert alert-danger'>Sorry! Your password must be greater than 3 characters</p>";
				} else {
					$new_password_md5 = md5($new_password_1);

					$password_query = mysqli_query ($connection, "UPDATE users SET password = '$new_password_md5' WHERE username='$userLoggedIn'");
					$password_message = "<p class='alert alert-success'>Password Successfully Changed</p>";
				}

			} else {
				$password_message = "<p class='alert alert-danger'>Your two new passwords need to match!</p>";
			}

		} //if (md5($old_password) == $db_password)
		else {
			$password_message = "<p class='alert alert-danger'>The old password is incorrect</p>";
		}

	}//if (isset($_POST["update_password"]))
	else {
		$password_message = "";
	}

	//Handler for closing account
	
	if (isset($_POST["close_account"])) {
		header ("Location: close_account.php");
	}

?>