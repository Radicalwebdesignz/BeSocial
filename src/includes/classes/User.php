<?php 
	//Create a class to fetch users first name and last name
	class User {

		//Create variables as private
		private $user;
		private $connection;

		//Write a constructor
		public function __construct($connection, $user) {
			//$this refers to the class name "User" and connection refers to the $connection private variable in User class - To this the function parameter $connection is assigned
			$this->connection = $connection;
			$userDetailsQuery = "SELECT * FROM users WHERE username='$user'"; //$user here will be fn parameter
			$run_userDetailsQuery = mysqli_query ($connection, $userDetailsQuery);
			$this->user = mysqli_fetch_array ($run_userDetailsQuery);
		}

		//Fetch the username
		public function getUsername () {
			return $this->user["username"];
		}

		public function getNumberOfFriendRequests () {
			$username = $this->user["username"];
			$query = "SELECT * FROM friend_requests WHERE user_to = '$username'";
			$run_query = mysqli_query ($this->connection, $query);
			return mysqli_num_rows($run_query);
		}

		//Fetch number of posts count
		public function getNumPosts () {
			$username = $this->user["username"];
			$query = "SELECT num_posts FROM users WHERE username = '$username'";
			$run_query = mysqli_query ($this->connection, $query);
			$row = mysqli_fetch_array ($run_query);
			return $row["num_posts"];
		}

		//Fetch the users first and last name
		public function getFirstNameAndLastName () {
			$username = $this->user["username"];
			$query = "SELECT first_name, last_name FROM users WHERE username = '$username'";
			$run_query = mysqli_query ($this->connection, $query);
			$row = mysqli_fetch_array ($run_query);
			return $row["first_name"] . " " . $row["last_name"];
		}

		public function getProfilePic () {
			$username = $this->user["username"];
			$query = "SELECT profile_pic FROM users WHERE username = '$username'";
			$run_query = mysqli_query ($this->connection, $query);
			$row = mysqli_fetch_array ($run_query);
			return $row["profile_pic"];
		}

		public function isClosed () {
			$username = $this->user["username"];
			$query = "SELECT user_closed FROM users WHERE username = '$username'";
			$run_query = mysqli_query ($this->connection, $query);
			$row = mysqli_fetch_array ($run_query);

			if ($row["user_closed"] == "yes") {
				return true;
			} else {
				return false;
			}

		}

		public function isFriend($username_to_check) {
			$usernameComma = "," . $username_to_check . ",";

			if ((strstr($this->user['friend_array'], $usernameComma) || $username_to_check == $this->user['username'])) {
				return true;
			} else {
				return false;
			}
		}

		public function didReceiveRequest($user_from) {
			$user_to = $this->user["username"];
			$checkRequestQuery = "SELECT * FROM friend_requests WHERE user_to = '$user_to' AND user_from='$user_from'";
			$run_checkRequestQuery = mysqli_query ($this->connection, $checkRequestQuery);

			if (mysqli_num_rows($run_checkRequestQuery) > 0) {
				return true;
			} else {
				return false;
			}
		}

		public function didSendRequest($user_to) {
			$user_from = $this->user["username"];
			$checkRequestQuery = "SELECT * FROM friend_requests WHERE user_to = '$user_to' AND user_from='$user_from'";
			$run_checkRequestQuery = mysqli_query ($this->connection, $checkRequestQuery);

			if (mysqli_num_rows($run_checkRequestQuery) > 0) {
				return true;
			} else {
				return false;
			}
		}

		public function removeFriend($user_to_remove) {
			$logged_in_user = $this->user["username"];
			$checkRemoveQuery = "SELECT friend_array FROM users WHERE username='$user_to_remove'";
			$run_checkRemoveQuery = mysqli_query ($this->connection, $checkRemoveQuery);
			$row = mysqli_fetch_array($run_checkRemoveQuery);
			$friend_array_username = $row["friend_array"];

			//Remove the friend from the users table
			$new_friend_array = str_replace($user_to_remove . ",", "", $this->user['friend_array']);
			$removeFriend = "UPDATE users SET friend_array='$new_friend_array' WHERE username='$logged_in_user'";
			$run_removeFriend = mysqli_query ($this->connection, $removeFriend);

			//Remove the friend from the removed users table
			$new_friend_array = str_replace($this->user["username"] . ",", "", $friend_array_username);
			$removeFriend = "UPDATE users SET friend_array='$new_friend_array' WHERE username='$user_to_remove'";
			$run_removeFriend = mysqli_query ($this->connection, $removeFriend);
		}

		public function sendRequest($user_to) {
			$user_from = $this->user["username"];
			$sendQuery = "INSERT INTO friend_requests VALUES('', '$user_to', '$user_from')";
			$run_sendQuery = mysqli_query ($this->connection, $sendQuery);
		}

		public function getFriendArray () {
			$username = $this->user["username"];
			$query = "SELECT friend_array FROM users WHERE username = '$username'";
			$run_query = mysqli_query ($this->connection, $query);
			$row = mysqli_fetch_array ($run_query);
			return $row["friend_array"];
		}

		public function getMutualFriends($user_to_check) {
		$mutualFriends = 0;
		$user_array = $this->user['friend_array'];
		$user_array_explode = explode(",", $user_array);

		$query = mysqli_query($this->connection, "SELECT friend_array FROM users WHERE username='$user_to_check'");
		$row = mysqli_fetch_array($query);
		$user_to_check_array = $row['friend_array'];
		$user_to_check_array_explode = explode(",", $user_to_check_array);

		foreach($user_array_explode as $i) {

			foreach($user_to_check_array_explode as $j) {

				if($i == $j && $i != "") {
					$mutualFriends++;
				}
			}
		}
		return $mutualFriends;

	}

	}//End of User Class

?>