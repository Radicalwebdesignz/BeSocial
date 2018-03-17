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
<body>
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
	?>

	<script>

		function toggle () {
			var element = document.getElementById ("comment_section");
			
			if (element.style.display == "block") {
				element.style.display = "none";
			} else {
				element.style.display = "block";
			}

		}

	</script>

	<?php 

		//Get the id # of the post
		if (isset($_GET["post_id"])) {
			$post_id = $_GET["post_id"];
		}

		$userQuery = "SELECT added_by, user_to FROM posts WHERE id = '$post_id'";
		$run_userQuery = mysqli_query ($connection, $userQuery);
		$row = mysqli_fetch_array($run_userQuery);
		$posted_to = $row["added_by"];
		$user_to = $row['user_to'];

		//Post the comments
		if (isset($_POST["postComment" . $post_id])) {
			$post_body = $_POST["post_body"];
			$post_body = mysqli_real_escape_string($connection, $post_body);
			$date_time_now = date("Y-m-d H:i:s");
			$insertPost = "INSERT INTO post_comments VALUES ('', '$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')";
			$run_insertPost = mysqli_query ($connection, $insertPost);

			//Insert Notifications
			
			if ($posted_to != $userLoggedIn) {
				$notification = new Notification ($connection, $userLoggedIn);
				$notification->insertNotification($post_id, $posted_to, "comment");
			} 
			
			if ($user_to != 'none' && $user_to != $userLoggedIn) {
				$notification = new Notification ($connection, $userLoggedIn);
				$notification->insertNotification($post_id, $user_to, "profile_comment");
			}

			$get_commenters = mysqli_query ($connection, "SELECT * FROM post_comments WHERE post_id='$post_id'");
			if (!$get_commenters) {
    printf("Error: %s\n", mysqli_error($connection));
    exit();
}
			$notified_users = array();

			while($row = mysqli_fetch_array($get_commenters)) {

				if ($row['posted_by'] != $posted_to && $row['posted_by'] != $user_to && $row['posted_by'] != $userLoggedIn && !in_array($row['posted_by'], $notified_users)) {
						$notification = new Notification ($connection, $userLoggedIn);
						$notification->insertNotification($post_id, $row['posted_by'], "comment_non_owner");

						array_push($notified_users, $row['posted_by']);
				}

			} //end of while ($row = mysqli_fetch_query($get_commenters))

			echo "<p class='text-center small pt-2 alert alert-success'>Comment Posted!</p>";
			} // end of (isset($_POST["postComment" . $post_id]))

	?>
	
	<!-- Comments section -->
	<form class="my-3" action="comment_frame.php?post_id=<?php echo $post_id; ?>" method="POST" id="comment_form" name="postComment<?php echo $post_id; ?>">
		<div class="row no-gutters">
			<div class="form-group col-md-9 px-2">
				<textarea rows="1" class="form-control" placeholder="Post Comments" name="post_body"></textarea>	
			</div>
			<div class="form-group col-md-3 px-2">
				<input class="form-control btn btn-info" type="submit" value="Post Comments" name="postComment<?php echo $post_id; ?>">
			</div>
		</div>	
	</form>
	
	<!-- Load Comments -->
	<?php 

		$getComments = "SELECT * FROM post_comments WHERE post_id = '$post_id' ORDER BY id ASC";
		$run_getComments = mysqli_query($connection, $getComments);
		$count = mysqli_num_rows($run_getComments);

		if ($count != 0) {
			while ($comment = mysqli_fetch_array($run_getComments)) {
				$comment_body = $comment["post_body"];
				$posted_to = $comment["posted_to"];
				$posted_by = $comment["posted_by"];
				$date_added = $comment["date_added"];
				$removed = $comment["removed"];

				//Getting the timeframe for posts
				$date_time_now = date("Y-m-d H:i:s"); //Current time
				$start_date = new DateTime($date_added); //Time of post - Class
				$end_date = new DateTime($date_time_now); //Current Time - Class
				$interval = $start_date->diff($end_date); //Gets the difference between current time and post time

				//Years message under post
				if ($interval->y >=1) {
					if ($interval == 1)  
						$time_message = $interval->y . " year ago"; //If year = 1 say just year ago
					 else 
						$time_message = $interval->y . " years ago"; //If year > 1 say years ago
					
				}

				//Months message under post
				elseif ($interval->m >=1) {
					if ($interval->d == 0) {
						$days = " day"; //if day=0 or 1 - say day ago
					} elseif($interval->d == 1) {
						$days = $interval->d . " day ago"; //if day=0 or 1 - say day ago
					} else {
						$days = $interval->d . " days ago"; //if day > 1 - say days ago
					}

					if ($interval->m == 1) {
						$time_message = $interval->m . " month" . $days; //if month =  1 - say month ago
					} else {
						$time_message = $interval->m . " months" . $days; //if month > 1 - say months ago
					}
				}

				elseif ($interval->d >=1) {
					if($interval->d == 1) {
						$time_message = "Yesterday"; //if day = 1 - say yesterday ago
					} else {
						$time_message = $interval->d . " days ago"; //if day > 1 - say days ago
					}
				}
				elseif ($interval->h >=1) {
					if($interval->h == 1) {
						$time_message = $interval->h . " hour ago"; //if hour = 1 - say hour ago
					} else {
						$time_message = $interval->h . " hours ago"; //if hour > 1 - say hours ago
					}
				}
				elseif ($interval->i >=1) {
					if($interval->i == 1) {
						$time_message = $interval->i . " minute ago"; //if minutes = 1 - say minute ago
					} else {
						$time_message = $interval->i . " minutes ago"; //if minutes > 1 - say minutes ago
					}
				}
				else {
					if($interval->s < 30) {
						$time_message = "Just now"; //if seconds < 30 seconds- say just now
					} else {
						$time_message = $interval->s . " seconds ago"; //if seconds > 30 - say seconds ago
					}
				}

				$user_obj = new User($connection, $posted_by);

				?>

				<div class="comment_section row no-gutters">
					<div class='col-xs-2 text-center pl-4'>
						<a href="<?php echo $posted_by; ?>" target="_parent"><img width="50" class="img img-fluid rounded-circle" src="<?php echo $user_obj->getProfilePic(); ?>" title="<?php echo $posted_by;?>"></a>
					</div>
					<div class='col-xs-10 pl-3'>
						<a href="<?php echo $posted_by; ?>" target="_parent"><b><?php echo $user_obj->getFirstNameAndLastName(); ?></b></a>
						<?php echo $time_message . "<br>" . $comment_body; ?>
					</div>
				</div><hr>

				<?php

			} //End Of While Loop
		}

		else {
			echo "<center class='text-muted'><br><br><br>No Comments To Show</center>";
		}

	?>



	<script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>