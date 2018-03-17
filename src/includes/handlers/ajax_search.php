<?php  

	include("../../config/config.php");
	include("../classes/User.php");

	//query and userLoggedIn parameter values are passed in javascript  - See main.js

	//Get the query value and userLoggedIn value
	$query = $_POST['query'];
	$userLoggedIn = $_POST['userLoggedIn'];

	//Explode splits an element in to array- In this case split the search query value at every space " " in to array
	//ex: John Smith will be exploded in to $names array with $names[0] = John and $names[1] = smith
	
	$names = explode(" ", $query);

	//If the query contains underscore, assume user is searching for usernames - We auto generated the usernames for users with
	//fname and lname with an underscore inbetween
	
	//strpos - Searches the position of the string in the data  - Here it seaches the position of "_" in $query data
	//if "_" is found at the beginning then strpos returns strpos as 0(strpos starts at 0th index), 
	//if found at the second character it returns 1
	
	//We use type equality operator here because when strpos returns 0, 0 is false in != but it is not false in !==
	//We do not want to search for usernames beginning with _
	
	if (strpos($query, '_') !== false) {
		//If found an underscore but not at the beginning, run the code below
		
		$userReturnedQuery = mysqli_query ($connection, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");

	} 
	//If there are two words, assume they are first name and last name respectively
	elseif (count($names) == 2) {

		$userReturnedQuery = mysqli_query ($connection, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no' LIMIT 8");

	}
	//If query has one word only, search for first name or last name
	else {
		$userReturnedQuery = mysqli_query ($connection, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no' LIMIT 8");
	}

	if ($query != "") {

		while ($row = mysqli_fetch_array($userReturnedQuery)) {

			$user = new User($connection, $userLoggedIn);

			if ($row['username'] != $userLoggedIn) {
				$mutual_friends = $user->getMutualFriends($row['username']) . " friends in common";
			} else {
				$mutual_friends = "";
			}

			// echo "<div class='resultDisplay'>
			// 		<a href='" . $row['username'] . "' style='color: #1485BD'>
			// 			<div class='liveSearchProfilePic'>
			// 				<img src='" . $row['profile_pic'] . "'>
			// 			</div>
			// 			<div class='liveSearchText'>
			// 				" . $row['first_name'] . " " . $row['last_name'] . "
			// 				<p>" . $row['username'] . "</p>
			// 				<p id='grey'>" . $mutual_friends . "</p>
			// 			</div>
			// 		</a>
			// 	</div>";

			echo	"<div class='col-md-12 bg-white' id='searchFriends'>
						<a class='row px-2 py-3 border' style='text-decoration: none;' href='" . $row['username'] . "'>
							<div class='col-md-3 pt-2 text-center'>
								<img width='50' class='rounded-circle' src='" . $row['profile_pic'] . "'>
							</div>
							<div class='col-md-9 text-center'>
								<p class='text-info p-0 m-0'>" . $row['first_name'] . " " . $row['last_name'] . "</p>
								<span class='text-info small'>
									<p class='p-0 m-0 text-muted'>" . $row['username'] . "</p>
									<p>" . $mutual_friends . "</p>
								</span>	
							</div>
						</a>
						<hr class='p-0 m-0'>
					</div>";

		}//End of while loop		
		echo "<div class='width search_results_footer py-2'></div>";
		echo "<div class='width search_results_footer_empty'></div>";
	} //end of if ($query != "")

?>