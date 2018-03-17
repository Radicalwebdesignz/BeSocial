<?php 

	include ("../../config/config.php");
	include ("../classes/User.php");
	include ("../classes/Post.php");

	$query = $_POST["query"];
	$userLoggedIn = $_POST["userLoggedIn"];

	$names = explode(" ", $query);

	if (strpos($query, "_") !== false) {
		$usersReturned = mysqli_query ($connection, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
	} elseif (count($names) == 2) {
		$usersReturned = mysqli_query ($connection, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' AND last_name LIKE '%$names[1]%') AND user_closed='no' LIMIT 8");
	} else {
		$usersReturned = mysqli_query ($connection, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='no' LIMIT 8");
	}

	if ($query != "") {
		while ($row = mysqli_fetch_array($usersReturned)) {
			$user = new User ($connection, $userLoggedIn);

			if ($row['username'] != $userLoggedIn) {
				$mutual_friends = $user->getMutualFriends($row['username']) . " friends in common";
			} else {
				$mutual_friends ="";
			}

			if ($user->isFriend($row['username'])) {
				echo 	"<div class='resultDisplay'>
							<a class='row bg-light text-info' href='messages.php?u=" . $row['username'] . "' style='text-decoration: none;''>
								<div class='col-md-3 mt-3 liveSearchProfilePic text-center'>
									<img class='img img-fluid rounded-circle' width='50' src='". $row['profile_pic'] . "'>
								</div>
								<div class='col-md-9 mt-3 liveSearchText'>
									<span class='text-muted'>Name: </span>".$row['first_name'] . " " . $row['last_name']."
									<p><span class='text-muted'>Username: </span>".$row['username'] . "</p>
									<p class='m-0 p-0 text-muted'>".$mutual_friends . "</p>
								</div>
							</a><hr>			
						</div>";
			}
		} //End of while loop	
	}

?>

