<?php 

	require_once ("includes/header.php"); //Header file includes config.php, head section and body opening tag
	require_once ("includes/classes/User.php"); //Include User class file

	if (isset($_GET['q'])) {
		$query = $_GET['q'];
	} else {
		$query = "";
	}

	if (isset($_GET['type'])) {
		$type = $_GET['type'];
	} else {
		$type = "name";
	}

?>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 bg-white bg-1">
        	<?php 

				if ($query == "") {
					echo "<p class='text-info text-center'>You must enter something in the search box.</p>";
				} else {
					
					if ($type = 'username') {
						//If found an underscore but not at the beginning, run the code below
						$userReturnedQuery = mysqli_query ($connection, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
					} else {
						$names = explode(" ", $query);
						//If there are three words, assume they are first name , middle name and last name respectively and search for fname, lname
						if (count($names) == 3) {
							$userReturnedQuery = mysqli_query ($connection, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[2]%') AND user_closed='no'");
						}
						
						//If query has two words, search for first name and last name
						elseif (count($names) == 2) {
							$userReturnedQuery = mysqli_query ($connection, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no'");
						}

						else {
							$userReturnedQuery = mysqli_query ($connection, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no'");
						}
					} //End of 2nd else

					//Check if results were found
					if (mysqli_num_rows($userReturnedQuery) == 0) {
						echo "<p class='mt-3 lead text-center'>We can't find anyone with a " . $type . " like: " . $query . "</p>";
					} else {
						echo "<p class='mt-3 lead text-center'>" . mysqli_num_rows($userReturnedQuery) . " results found.</p>";
					}

					echo "<p class='text-muted text-center'>Try searching for: </p>";
					echo "<p class='text-info text-center'><a class='text-info' href='search.php?q=" . $query ."&type=name'>Names</a>, <a href='search.php?q=" . $query ."&type=username' class='text-info'>Usernames</a><p><hr>";

					while ($row = mysqli_fetch_array($userReturnedQuery)) {
						$user_obj = new User($connection, $_SESSION['username']);

						$button = "";
						$mutual_friends = "";

						if ($_SESSION['username'] != $row['username']) {
							//Generate button depending on friendship status
							if ($user_obj->isFriend($row['username'])) {
								$button = "<input type='submit' name='" . $row['username'] . "' class='form-control btn btn-danger' value='Remove Friend'>";
							} elseif ($user_obj->didReceiveRequest($row['username'])){
								$button = "<input type='submit' name='" . $row['username'] . "' class='form-control btn btn-warning' value='Respond to Request'>";
							} elseif ($user_obj->didSendRequest($row['username'])) {
								$button = "<input type='submit' class='form-control btn btn-info' value='Request Sent'>";
							} else {
								$button = "<input type='submit' name='" . $row['username'] . "' class='form-control btn btn-success' value='Add Friend'>";
							}

							$mutual_friends = $user_obj->getMutualFriends($row['username']) . " friends in common";

							//Button Functionality - add, remove
							
							if (isset($_POST[$row['username']])) {

								if ($user_obj->isFriend($row['username'])) {
									$user_obj->removeFriend($row['username']);
									header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
								}
								elseif ($user_obj->didReceiveRequest($row['username'])) {
									header ("Location: requests.php");
								}
								elseif ($user_obj->didSendRequest($row['username'])) {
									//Do nothing
								}
								else {
									$user_obj->sendRequest($row['username']);
									header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
								}
							}

						} //end of if ($user['username'] != $row['username'])

						echo "<div class='row p-3'>
								<div class='col-md-4'></div>	
								<div class='col-md-4 bg-light border'>
									<form action='' method='POST'>
										<div class='form-group pt-3'>
											" . $button . "
										</div>	
									</form>
									<div class='text-center'>
										<p><a href='" . $row['username'] . "'><img src='" . $row['profile_pic'] . "' style='height:100px'></a></p>
									
										<a class='text-info' href='" . $row['username'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "
										<p class='text-muted'>" . $row['username'] . "</p>
										</a>
										<p class='text-muted'>" . $mutual_friends . "</p>
									</div>
								</div>
								<div class='col-md-4'></div>
							</div><hr>";	

					} //End of while loop

				} //End of 1st else statement

			?>
        </div>
    </div>    	
</div>    
		
