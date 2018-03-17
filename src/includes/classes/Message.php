<?php 
	//Create a class for messages
	class Message {

		//Create variables as private
		private $user_obj;
		private $connection;

		//Write a constructor
		public function __construct($connection, $user) {
			//$this refers to the class name "User" and connection refers to the $connection private variable in User class - To this the function parameter $connection is assigned
			$this->connection = $connection;
			$this->user_obj = new User($connection, $user);
		} //End of constructor

		public function getMostRecentUser () {
			$userLoggedIn = $this->user_obj->getUsername();
			$query = mysqli_query($this->connection, "SELECT user_to, user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC LIMIT 1");

			if (mysqli_num_rows($query) == 0) {
				return false;
			}

			$row = mysqli_fetch_array ($query);
			$user_to = $row["user_to"];
			$user_from = $row["user_from"];

			if ($user_to != $userLoggedIn) {
				return $user_to;
			} else {
				return $user_from;
			}

		} // End of getMostRecentUser

		public function sendMessage ($user_to, $body, $date) {
			if ($body != "") {
				$userLoggedIn = $this->user_obj->getUsername();
				$query = mysqli_query ($this->connection, "INSERT INTO messages VALUES ('', '$user_to', '$userLoggedIn', '$body', '$date', 'no', 'no', 'no')");
			}
		}

		public function getMessages ($otherUser) {
			$userLoggedIn = $this->user_obj->getUsername();
			$data = "";

			$query = mysqli_query ($this->connection, "UPDATE messages SET opened='yes' WHERE user_to='$userLoggedIn' AND user_from='$otherUser'");

			$get_messages_query = mysqli_query ($this->connection, "SELECT * FROM messages WHERE (user_to='$userLoggedIn' AND user_from='$otherUser') OR (user_from='$userLoggedIn' AND user_to='$otherUser')");

			while ($row = mysqli_fetch_array($get_messages_query)) {
				$user_to = $row["user_to"];
				$user_from = $row["user_from"];
				$body = $row["body"];

				//If statement - If message is from the user itself, then change div color to green else to blue
				$div_top = ($user_to == $userLoggedIn) ? "<span class='py-1 px-2 float-left text-white my-1 rounded message bg-info' id='green'>" : "<span class='float-right py-1 px-2 text-white my-1 rounded message bg-success' id='blue'>";

				$data = $data . $div_top . $body . "</span><br><br>";
			}

			return $data;

		} //End of getMessages

		public function getLatestMessage ($userLoggedIn, $user2) {
			$details_array = array();

			$query = mysqli_query ($this->connection, "SELECT body, user_to, date FROM messages WHERE (user_to='$userLoggedIn' AND user_from='$user2') OR (user_to='$user2' AND user_from='$userLoggedIn') ORDER BY id DESC LIMIT 1");
			$row = mysqli_fetch_array($query);

			$sent_by = ($row["user_to"] == $userLoggedIn) ? "They said: " : "You said: ";

			//Getting the timeframe
			$date_time_now = date("Y-m-d H:i:s"); //Current time
			$start_date = new DateTime($row["date"]); //Time of post - Class
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

			array_push($details_array, $sent_by);
			array_push($details_array, $row["body"]);
			array_push($details_array, $time_message);

			return $details_array;

		}//end of getLatestMessage

		public function getConvos() {
			$userLoggedIn = $this->user_obj->getUsername();
			$return_string = "";
			$convos = array();

			$query = mysqli_query ($this->connection, "SELECT user_to, user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC");

			while ($row = mysqli_fetch_array($query)) {
				$user_to_push = ($row["user_to"] != $userLoggedIn) ? $row["user_to"] : $row["user_from"];

				if (!in_array($user_to_push, $convos)) {
					array_push($convos, $user_to_push);
				}
			}

			foreach ($convos as $username) {
				$user_found_obj = new User ($this->connection, $username);
				$latest_message_details = $this->getLatestMessage($userLoggedIn, $username);

				$dots = (strlen($latest_message_details[1]) >= 12) ? "..." : "";
				$split = str_split($latest_message_details[1], 12);
				$split = $split[0] . $dots;

				// $return_string .= "<a href='messages.php?u=$username'> <div class='user_found_messages'>
				// 					<img src='". $user_found_obj->getProfilePic() . "'>
				// 					" . $user_found_obj->getFirstNameAndLastName() . "
				// 					<span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
				// 					<p id='grey'>" . $latest_message_details[0] . $split . " </p>
				// 					</div>
				// 					</a>";

				$return_string .= "<div class='col-md-12'>
											<a class='row px-2 py-3 bg-light' style='text-decoration: none;' href='messages.php?u=$username'>
											<div class='col-md-3'>
												<img width='60' class='rounded-circle' src='". $user_found_obj->getProfilePic() . "'>
											</div>
											<div class='col-md-9'><span class='text-info'>
												" . $user_found_obj->getFirstNameAndLastName() . "</span> 
												<span class='small text-muted'> " . $latest_message_details[2] . "</span>

												<p class='text-muted'>" . $latest_message_details[0] . $split . " </p>
											</div>
											</a>
											<hr class='p-0 m-0'>
									</div>";						
			}

			return $return_string;

		}//End of getConvos

		public function getConvosDropdown($data, $limit) {

			$page=$data["page"];
			$userLoggedIn = $this->user_obj->getUsername();
			$return_string = "";
			$convos = array();

			if ($page == 1) {
				$start = 0;
			} else {
				$start = 4;
			}

			$set_viewed_query = mysqli_query ($this->connection, "UPDATE messages SET viewed='yes' WHERE user_to = '$_SESSION[username]'");

			$query = mysqli_query ($this->connection, "SELECT user_to, user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC");

			while ($row = mysqli_fetch_array($query)) {
				$user_to_push = ($row["user_to"] != $userLoggedIn) ? $row["user_to"] : $row["user_from"];

				if (!in_array($user_to_push, $convos)) {
					array_push($convos, $user_to_push);
				}
			}

			$num_iterations = 0; //No. of messages checked
			$count = 1; //No. of messages posted


			foreach ($convos as $username) {

				if ($num_iterations++ < $start) {
					continue;
				}

				if ($count > $limit) {
					break;
				} else {
					$count++;
				}

				$is_unread_query = mysqli_query($this->connection, "SELECT opened FROM messages WHERE user_to='$userLoggedIn' AND user_from='$username' ORDER BY id DESC");
				$row = mysqli_fetch_array($is_unread_query);
				$style = ($row['opened'] == 'no') ? "background-color: #DDEDFF;" : "";
		
				$user_found_obj = new User ($this->connection, $username);
				$latest_message_details = $this->getLatestMessage($userLoggedIn, $username);

				$dots = (strlen($latest_message_details[1]) >= 12) ? "..." : "";
				$split = str_split($latest_message_details[1], 12);
				$split = $split[0] . $dots;

				// $return_string .= "<a href='messages.php?u=$username'> <div class='user_found_messages'>
				// 					<img src='". $user_found_obj->getProfilePic() . "'>
				// 					" . $user_found_obj->getFirstNameAndLastName() . "
				// 					<span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
				// 					<p id='grey'>" . $latest_message_details[0] . $split . " </p>
				// 					</div>
				// 					</a>";

				$return_string .= "<div class='col-md-12' style='" . $style . "'>
											<a class='row px-2 py-3 border' style='text-decoration: none;' href='messages.php?u=$username'>
											<div class='col-md-3 pt-2'>
												<img width='50' class='rounded-circle' src='". $user_found_obj->getProfilePic() . "'>
											</div>
											<div class='col-md-9'><span class='text-info small'>
												" . $user_found_obj->getFirstNameAndLastName() . "</span> 
												<span class='small text-muted'> " . $latest_message_details[2] . "</span>

												<p class='text-muted'>" . $latest_message_details[0] . $split . " </p>
											</div>
											</a>
											<hr class='p-0 m-0'>
									</div>";						
			}

			//If posts were loaded
			
			if ($count > $limit) {
				$return_string .= "<input type='hidden' class='nextPageDropdownData value='" . ($page + 1) . "'><input type='hidden' class='noMoreDropdownData' value='false'>";
			} else {
				$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'><p class='border text-info bg-light py-2' style='text-align: center;'>No More Messages To Load!</p>";
			}

			return $return_string;
		} //end of getConvosDropdown

		public function getUnreadNumber() {
			$userLoggedIn = $this->user_obj->getUsername();
			$query = mysqli_query ($this->connection, "SELECT * FROM messages WHERE viewed = 'no' AND user_to='$_SESSION[username]'");
			return mysqli_num_rows($query);
		}

} //End of Message class

?>
