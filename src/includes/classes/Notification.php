<?php 
	//Create a class for notifications
	class Notification {

		//Create variables as private
		private $user_obj;
		private $connection;

		//Write a constructor
		public function __construct($connection, $user) {
			//$this refers to the class name "User" and connection refers to the $connection private variable in User class - To this the function parameter $connection is assigned
			$this->connection = $connection;
			$this->user_obj = new User($connection, $user);
		} //End of constructor

		public function getUnreadNumber() {
			$userLoggedIn = $this->user_obj->getUsername();
			$query = mysqli_query ($this->connection, "SELECT * FROM notifications WHERE viewed = 'no' AND user_to='$userLoggedIn'");
			return mysqli_num_rows($query);
		}

		public function getNotifications($data, $limit) {

			$page=$data["page"];
			$userLoggedIn = $this->user_obj->getUsername();
			$return_string = "";

			if ($page == 1) {
				$start = 0;
			} else {
				$start = 4;
			}

			$set_viewed_query = mysqli_query ($this->connection, "UPDATE notifications SET viewed='yes' WHERE user_to = '$_SESSION[username]'");

			$query = mysqli_query ($this->connection, "SELECT * FROM notifications WHERE user_to='$userLoggedIn' ORDER BY id DESC");

			if (mysqli_num_rows($query) == 0) {
				echo "<p class='text-info text-center'>No More Notifications To Load!</p>";
				return; //End the function right here
			}

			$num_iterations = 0; //No. of messages checked
			$count = 1; //No. of messages posted

			while ($row = mysqli_fetch_array($query)) {

				if ($num_iterations++ < $start) {
					continue;
				}

				if ($count > $limit) {
					break;
				} else {
					$count++;
				}

				$user_from =$row['user_from'];

				$user_data_query = mysqli_query ($this->connection, "SELECT * FROM users WHERE username = '$user_from'");
				$user_data = mysqli_fetch_array($user_data_query);

				//Getting the timeframe for posts
				$date_time_now = date("Y-m-d H:i:s"); //Current time
				$start_date = new DateTime($row['datetime']); //Time of post - Class
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

				$opened = $row['opened'];
				$style = ($row['opened'] == 'no') ? "background-color: #DDEDFF;" : "";

				// $return_string .= "<a href='" . $row['link'] . "'>
				// 						<div class='resultDisplay resultDisplayNotification' style='" . $style . "'>
					// 						<div class='notificationsProfilePic'>
					// 							<img src='" . $user_data['profile_pic'] ."'>
					// 						</div>
					// 						<p class='timestamp_smaller' id='grey'>" . $time_message ."</p>" . $row['message'] . "
				// 						</div>
				// 					</a>";

				$return_string .= "<div class='col-md-12' style='" . $style . "'>
											<a class='row px-2 py-3 border' style='text-decoration: none;' href='" . $row['link'] . "'>
											<div class='col-md-3 pt-3'>
												<img width='50' class='rounded-circle' src='" . $user_data['profile_pic'] ."'>
											</div>
											<div class='col-md-9'><span class='text-info small'>
												<p class='text-muted'>" . $time_message ."</p><p class='text-muted'>" . $row['message'] . "</p>
											</div>
											</a>
											<hr class='p-0 m-0'>
									</div>";						
			}

			//If posts were loaded
			
			if ($count > $limit) {
				$return_string .= "<input type='hidden' class='nextPageDropdownData value='" . ($page + 1) . "'><input type='hidden' class='noMoreDropdownData' value='false'>";
			} else {
				$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'><p class='border text-info bg-light py-2' style='text-align: center;'>No More notifications To Load!</p>";
			}

			return $return_string;
		} //end of getNotifications()

		public function insertNotification ($post_id, $user_to, $type) {
			$userLoggedIn = $this->user_obj->getUsername();
			$userLoggedInName = $this->user_obj->getFirstNameAndLastName();

			$date_time = date("Y-m-d H:i:s");

			switch ($type) {

				case 'comment':
					$message = $userLoggedInName . " commented on your post";
					break;

				case 'like':
					$message = $userLoggedInName . " liked your post";
					break;

				case 'profile_post':
					$message = $userLoggedInName . " posted on your profile";
					break;

				case 'comment_non_owner':
					$message = $userLoggedInName . " commented on a post you commented on";
					break;

				case 'profile_comment':
					$message = $userLoggedInName . " commented on your profile post";
					break;	
								
			}

			$link = "post.php?id=" . $post_id;

			$insert_query = mysqli_query ($this->connection, "INSERT INTO notifications VALUES ('', '$user_to', '$userLoggedIn', '$message', '$link', '$date_time', 'no', 'no')");

		}//insertNotification

	}// End of Notification class	
?>