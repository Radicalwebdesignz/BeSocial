<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/customStyle.css">

        <title>Welcome To BeSocial</title>
    </head>
<body class='bg-light'>
	<?php
	    require_once ("config/config.php");
	    require_once ("includes/classes/User.php"); //Include User class file
	    require_once ("includes/classes/Post.php"); //Include Posts class file
	    require_once ("includes/classes/Notification.php"); //Include Notification class file

	    //If username session is not set i.e user not logged in - redirect to registar.php page
	    if (isset($_SESSION["username"])) { //$_SESSION["username"] was set in login_handler.php
	        $userLoggedIn = $_SESSION["username"];

	        //Get the users first name
	        $userDetailsQuery = "SELECT * FROM users WHERE username='$userLoggedIn'";
	        $run_userDetailsQuery = mysqli_query($connection, $userDetailsQuery);
	        $userDetailsQueryRow = mysqli_fetch_array ($run_userDetailsQuery);
	    } else {
	        header ("Location: register.php");
	    }

	    //Get the id # of the post
		if (isset($_GET["post_id"])) {
			$post_id = $_GET["post_id"];
		}

		//Get the likes and added by from posts table
		$get_likes = "SELECT likes, added_by FROM posts WHERE id='$post_id'";
		$run_get_likes = mysqli_query($connection, $get_likes);
		$row = mysqli_fetch_array($run_get_likes);
		$total_likes = $row["likes"];
		$user_liked = $row["added_by"];

		$userDetailsQuery = "SELECT * FROM users WHERE username='$user_liked'";
		$run_userDetailsQuery = mysqli_query($connection, $userDetailsQuery);
		$row = mysqli_fetch_array($run_userDetailsQuery);
		$total_user_likes = $row["num_likes"];

		//Like Button
		if (isset($_POST["like_button"])) {
			//Increment the like to 1
			$total_likes++;

			//Update the likes field in likes table
			$query = "UPDATE posts SET likes='$total_likes' WHERE id = '$post_id'";
			$run_query = mysqli_query($connection, $query);

			$total_user_likes++;
			$user_likes = "UPDATE users SET num_likes='$total_user_likes' WHERE username = '$user_liked'";
			$run_user_likes = mysqli_query($connection, $user_likes);

			$insertUser = "INSERT INTO likes VALUES ('', '$userLoggedIn', '$post_id')";
			$run_insertUser = mysqli_query($connection, $insertUser);

			//Insert Notification
			
			if ($user_liked != $userLoggedIn) {
				$notification = new Notification ($connection, $userLoggedIn);
				$notification->insertNotification($post_id, $user_liked, "like");
			}
			
		}

		//Ubnlike Button
		if (isset($_POST["unlike_button"])) {
			//decrement the like to 1
			$total_likes--;

			//Update the likes field in likes table
			$query = "UPDATE posts SET likes='$total_likes' WHERE id = '$post_id'";
			$run_query = mysqli_query($connection, $query);

			$total_user_likes--;
			$user_likes = "UPDATE users SET num_likes='$total_user_likes' WHERE username = '$user_liked'";
			$run_user_likes = mysqli_query($connection, $user_likes);

			$insertUser = "DELETE FROM likes WHERE username = '$userLoggedIn' AND post_id='$post_id'";
			$run_insertUser = mysqli_query($connection, $insertUser);

			//Insert Notification
			
		}

		//Check for previous likes
		$checkQuery = "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'";
		$run_checkQuery = mysqli_query($connection, $checkQuery);
		$num_rows = mysqli_fetch_array($run_checkQuery);

		//Like and unlike forms to display
		if ($num_rows > 0) {
			echo '<form action="like.php?post_id=' . $post_id . '" method="POST" class="likeUnlikeForm">
					<input type="submit" class="comment_unlike text-info" name="unlike_button" value="Unlike">
					<div class="like_value">
						'. $total_likes .' Likes
					</div>
				</form>';
		} else {
			echo '<form action="like.php?post_id=' . $post_id . '" method="POST" class="likeUnlikeForm">
					<input type="submit" class="comment_like text-info" name="like_button" value="Like">
					<div class="like_value">
						'. $total_likes .' Likes
					</div>
				</form>';
		}

	?>

	<script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>