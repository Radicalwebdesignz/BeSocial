<?php
    require_once ("includes/header.php"); //Header file includes config.php, head section and body opening tag
    require_once ("includes/classes/User.php"); //Include User class file
    require_once ("includes/classes/Post.php"); //Include Posts class file
?>    

	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center mt-4 bg-white py-4">
				<h2 class="text-info">Friend Requests</h2>
				<?php 

				$friendRequestQuery = "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'";
				$run_friendRequestQuery = mysqli_query ($connection, $friendRequestQuery);

				if (mysqli_num_rows($run_friendRequestQuery) == 0) {
					echo "You have no friend requests at this time!";
				} else {
					while ($row = mysqli_fetch_array($run_friendRequestQuery)) {
						$user_from = $row["user_from"];
						$user_from_obj = new User ($connection, $user_from);
						
						echo $user_from_obj->getFirstNameAndLastName() . " sent you a friend request";
						$user_from_friend_array = $user_from_obj->getFriendArray();

						if (isset($_POST["accept_request" . $user_from])) {

							//Update friend array to new friend
							$addFriendQuery = "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') WHERE username='$userLoggedIn'";
							$run_addFriendQuery = mysqli_query ($connection, $addFriendQuery);

							//Update friend array of new friend to logged in user
							$addFriendQuery = "UPDATE users SET friend_array=CONCAT(friend_array, '$userLoggedIn,') WHERE username='$user_from'";
							$run_addFriendQuery = mysqli_query ($connection, $addFriendQuery);

							//Delete the friend request from table once accepted
							$delete_query = mysqli_query ($connection, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from ='$user_from'");
							echo "You are now friends!";
							header ("Location: requests.php");

						}
						if (isset($_POST["ignore_request" . $user_from])) {
							//Ignore friend request
							
							//Delete the friend request from table
							$delete_query = mysqli_query ($connection, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from ='$user_from'");
							echo "Request Ignored!";
							header ("Location: requests.php");

						}

				?>		
						<form action="requests.php" method="POST" class="form-inline">
							<div class="form-group ml-auto p-3">
								<input type="submit" class="btn btn-success" name="accept_request<?php echo $user_from; ?>" value="Accept">
							</div>
							<div class="form-group mr-auto p-3">
								<input type="submit" class="btn btn-danger" name="ignore_request<?php echo $user_from; ?>" value="Ignore">
							</div>
						</form>
				<?php		

					} //End of while loop
				} //End of else

				?>

			</div>	
		</div>
	</div>

	<script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
