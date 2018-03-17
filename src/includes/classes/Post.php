<?php 
	//Create a class to submit posts
	class Post {

		//Create variables as private
		private $user_obj;
		private $connection;

		//Write a constructor
		public function __construct($connection, $user) {
			//$this refers to the class name "User" and connection refers to the $connection private variable in User class - To this the function parameter $connection is assigned
			$this->connection = $connection;
			$this->user_obj = new User($connection, $user);
		} //End of constructor

		//
		public function submitPost ($body, $user_to, $imageName) {
			$body = strip_tags($body); //Removes html tags
			$body = mysqli_real_escape_string($this->connection, $body); //Removes "'" from body text
			$check_empty = preg_replace('/\s+/', '', $body); //Deletes all spaces

			//If post is not ecpty
			if ($check_empty != "") {

				//Posting youtube videos
				
				//splits the body array in to an array at each space
				$body_array = preg_split("/\s+/", $body);

				foreach($body_array as $key => $value) {
					
					//Checks if www.youtube.com/watch?v= is in value
					if(strpos($value, "www.youtube.com/watch?v=") !== false) {

						//Split the $value which is url at & - & is contained in the url if the video is from playlist
						//if there is & in the url - videos will not be embedded - To overcome this, split the url at & - This will split in to an array and use the first index of this array i.e $link[0]
						//https://www.youtube.com/watch?v=bUTsVY6VUQA&list=PL7pEw9n3GkoVPFsAylfniAT3QQcjWGl5C - url form playlist
						//https://www.youtube.com/watch?v=HqIkddLfCAk - Normal url
						
						$link = preg_split("!&!", $value);
						//Replace watch?v= to embed\ - which will embed the video instead of watch
						$value = preg_replace("!watch\?v=!", "embed/", $link[0]);
						$value = "<div class='embed-responsive embed-responsive-16by9'>
									<br><iframe class='embed-responsive-item' width=\'420\' height=\'315\' src=\'" . $value ."\'></iframe><br>
								</div>";
						$body_array[$key] = $value;

						// <div class='col-md-12' embed-responsive embed-responsive-1by1 p-0'>
						// 	<iframe height='300px' class='embed-responsive-item col-md-12 bg-white' src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
						// </div>

					}

				}
				$body = implode(" ", $body_array);

				//Get current date and time
				$date_added = date("Y-m-d H:i:s");

				//Get Username
				$added_by = $this->user_obj->getUsername();

				//If user in on own profile then user_to is "none"
				if ($user_to == $added_by) {
					$user_to = "none";
				}

				//Insert Post to database
				$insertQuery = "INSERT INTO posts VALUES ('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0', '$imageName')";
				$run_insertQuery = mysqli_query ($this->connection, $insertQuery);

				//Get the post id
				$returned_id = mysqli_insert_id($this->connection);

				//Insert Notifications
				
				if ($user_to != 'none') {
					$notification = new Notification ($this->connection, $added_by);
					$notification->insertNotification($returned_id, $user_to, "profile_post");
				}
				
				//Update Post count for user
				$num_posts = $this->user_obj->getNumPosts();
				$num_posts++;
				$updateQuery = "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'";
				$run_updateQuery = mysqli_query ($this->connection, $updateQuery);

				header ("Location: index.php");

				//Trending section
				
				$stopWords = "a about above across after again against all almost alone along already
				 also although always among am an and another any anybody anyone anything anywhere are 
				 area areas around as ask asked asking asks at away b back backed backing backs be became
				 because become becomes been before began behind being beings best better between big 
				 both but by c came can cannot case cases certain certainly clear clearly come could
				 d did differ different differently do does done down down downed downing downs during
				 e each early either end ended ending ends enough even evenly ever every everybody
				 everyone everything everywhere f face faces fact facts far felt few find finds first
				 for four from full fully further furthered furthering furthers g gave general generally
				 get gets give given gives go going good goods got great greater greatest group grouped
				 grouping groups h had has have having he her here herself high high high higher
			     highest him himself his how however i im if important in interest interested interesting
				 interests into is it its itself j just k keep keeps kind knew know known knows
				 large largely last later latest least less let lets like likely long longer
				 longest m made make making man many may me member members men might more most
				 mostly mr mrs much must my myself n necessary need needed needing needs never
				 new new newer newest next no nobody non noone not nothing now nowhere number
				 numbers o of off often old older oldest on once one only open opened opening
				 opens or order ordered ordering orders other others our out over p part parted
				 parting parts per perhaps place places point pointed pointing points possible
				 present presented presenting presents problem problems put puts q quite r
				 rather really right right room rooms s said same saw say says second seconds
				 see seem seemed seeming seems sees several shall she should show showed
				 showing shows side sides since small smaller smallest so some somebody
				 someone something somewhere state states still still such sure t take
				 taken than that the their them then there therefore these they thing
				 things think thinks this those though thought thoughts three through
		         thus to today together too took toward turn turned turning turns two
				 u under until up upon us use used uses v very w want wanted wanting
				 wants was way ways we well wells went were what when where whether
				 which while who whole whose why will with within without work
				 worked working works would x y year years yet you young younger
				 youngest your yours z lol haha omg hey ill iframe wonder else like 
	             hate sleepy reason for some little yes bye choose";

	             //$stopWords = preg_split(" ", $stopWords); - Splits at each space
	             $stopWords = preg_split("/[\s,]+/", $stopWords); - //Splits at each space and line breaks

	            //Remove all punctionation and replace with blank in $body
				$no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $body);

				if (strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {

					$no_punctuation = preg_split("/[\s,]+/", $no_punctuation);

					foreach ($stopWords as $value) {
						foreach ($no_punctuation as $key => $value2) {
							if (strtolower($value) == strtolower($value2)) {
								$no_punctuation[$key] = "";
							}
						}
					}

					foreach ($no_punctuation as $value) {
						$this->calculateTrend($value);
					}

				} //if (strpos($no_punctuation, "height")

			}
		} //End of submit post function

		//Calculate trend function
		
		public function calculateTrend ($term) {

			if ($term != "") {
				$query = mysqli_query ($this->connection, "SELECT * FROM trends WHERE title='$term'");

				if (mysqli_num_rows($query) == 0) {
					$insert_query = mysqli_query ($this->connection, "INSERT INTO trends (title, hits) VALUES ('$term', '1')");
				} else {
					$insert_query = mysqli_query ($this->connection, "UPDATE trends SET hits = hits+1 WHERE title='$term'");
				}
			}

		}

		//Load submitted posts
		
		public function loadPostsFriends ($data, $limit) {
			$page = $data["page"];
			$userLoggedIn = $this->user_obj->getUsername();

			if ($page == 1) 
				$start = 0;
			 else 
				$start = ($page - 1) * $limit;
			

			$str =""; //String to return

			$dataQuery = "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC ";
			$run_dataQuery = mysqli_query ($this->connection, $dataQuery);

			if (mysqli_num_rows($run_dataQuery) > 0) {

				$num_iterations = 0; //Numbers of results checked (Not necessarily posted)
				$count = 1;

			while ($row = mysqli_fetch_array($run_dataQuery)) {
				$id = $row["id"];
				$body = $row["body"];
				$added_by = $row["added_by"];
				$date_time = $row["date_added"];
				$imagePath = $row["image"];
			
			//Set the user_to value to be included in the submitted post data
			if ($row["user_to"] == "none") {
				$user_to = ""; //If the posts are added by the user but not to any other user
			} else {
				$user_to_obj = new User($this->connection, $row["user_to"]);
				$user_to_name = $user_to_obj->getFirstNameAndLastName();
				$user_to = "  to <a class='text-info' href='".$row['user_to']."'>" . $user_to_name . "</a>";
			}

			//Check if the user who posted has their account closed
			$added_by_obj = new User ($this->connection, $added_by);

			if ($added_by_obj->isClosed()) {
				continue;
			}

			//Check if the user is friends with others
			$user_logged_obj = new User ($this->connection, $_SESSION["username"]);
			
			if ($user_logged_obj->isFriend($added_by)) {
					

				if ($num_iterations++ < $start)
					continue;
				
				//Once 10 posts have been loaded, then break
				
				if ($count > $limit) {
					break;
				} else {
					$count++;
				}

				//Delete button for deleting own posts
				
				if ($_SESSION["username"] == $added_by) {
					$delete_button = "<button class='btn-sm delete_button btn btn-danger p-0' id='post$id'><i class='p-2 fa fa-trash-o' aria-hidden='true'></i></button>";
				} else {
					$delete_button = "";
				}


				$userDetailsQuery = "SELECT first_name, last_name, profile_pic FROM users WHERE username = '$added_by'";
				$run_userDetailsQuery = mysqli_query ($this->connection, $userDetailsQuery);
				$user_row = mysqli_fetch_array($run_userDetailsQuery);

				$first_name = $user_row["first_name"];
				$last_name = $user_row["last_name"];
				$profile_pic = $user_row["profile_pic"];

				?>
				
				<script>
					//Which comments to show
					function toggle<?php echo $id; ?>() {

						//When user clicks on the first name and last name take to profile page without showing the comments first
						var target = $(event.target);

						//If the target is to the href a link where span is inside this a, then do not show comments else, show comments
						if(!target.is("span")) { //

							if(!target.is("i")) { //When user clicks on delete post take to delete post without showing the comments first

							var element = document.getElementById ("toggleComment<?php echo $id; ?>");
					
							if (element.style.display == "block") {
								element.style.display = "none";
							} else {
								element.style.display = "block";
							}

							}
						}
					}
				</script>

				<?php

				//Showing No. of comments
				
				$commentsCheck = "SELECT * FROM post_comments WHERE post_id = '$id'";
				$run_commentsCheck = mysqli_query ($this->connection, $commentsCheck);
				$commentsCheckNum = mysqli_num_rows($run_commentsCheck);

				//Getting the timeframe for posts
				$date_time_now = date("Y-m-d H:i:s"); //Current time
				$start_date = new DateTime($date_time); //Time of post - Class
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

				if ($imagePath != "") {
					$imageDiv = "<div class='postedImage pb-3 text-center'>
									<img class='img img-fluid' src='$imagePath'>
								</div>";
					} else {
						$imageDiv = "";
					}

				$str .="<div class='row no-gutters' onClick='javascript:toggle$id()'>
							<div class='col-md-2 text-center my-1 bg-light p-4'>
								<img id='postImage' class='img img-fluid' src='$profile_pic' width='75'>
							</div>
							<div class='col-md-10 my-1 bg-light p-4'>
								<a href='$added_by'><span class='text-info'>$first_name $last_name</span></a>$user_to &nbsp;&nbsp;<span class='text-muted'>$time_message</span>&nbsp;&nbsp;&nbsp;$delete_button
								<div class='pt-2'>$body</div>
								$imageDiv
								<div class='col-md-12 text-info'>
									<p class='commentsPointer d-inline'>Comments</p>($commentsCheckNum) &nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' id='likes_iframe' scrolling='no'></iframe>
								</div>
							</div>
						</div>	
						<div class='row no-gutters post_comment' id='toggleComment$id' style='display:none'>
							<div class='col-md-12' embed-responsive embed-responsive-1by1 p-0'>
								<iframe height='300px' class='embed-responsive-item col-md-12 bg-white' src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
						</div>";

			} //End of - Check if the user is friends with others	 

			?>
			
			<script>
				//Confirmation message for delete post on click - Using bootbox.min.js for confirmation message 
				$(document).ready(function() {
					$('#post<?php echo $id; ?>').on("click", function() {
						bootbox.confirm("Are you sure you want to delete this post?", function(result) {
							$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});
							if (result) {
								location.reload();
							}
						});
					});
				});
			</script>

			<?php	

		} //While Loop End

		if ($count > $limit) {
			$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) ."'><input type='hidden' class='noMorePosts' value='false'>";
		} else {
			$str .= "<input type='hidden' class='noMorePosts' value='true'><p class='text-center'>No More Posts To Show!</p>";
		}

	} //end of mysqli_num_rows($run_dataQuery) > 0
		echo $str;

	}//End of loadPostsFriends

	//Load submitted posts in profile
		
		public function loadProfilePosts ($data, $limit) {
			$page = $data["page"];
			$profileUser = $data["profileUsername"];
			$userLoggedIn = $this->user_obj->getUsername();

			if ($page == 1) 
				$start = 0;
			 else 
				$start = ($page - 1) * $limit;
			

			$str =""; //String to return

			$dataQuery = "SELECT * FROM posts WHERE deleted='no' AND ((added_by='$profileUser' AND user_to='none') OR user_to='$profileUser') ORDER BY id DESC";
			$run_dataQuery = mysqli_query ($this->connection, $dataQuery);

			if (mysqli_num_rows($run_dataQuery) > 0) {

				$num_iterations = 0; //Numbers of results checked (Not necessarily posted)
				$count = 1;

			while ($row = mysqli_fetch_array($run_dataQuery)) {
				$id = $row["id"];
				$body = $row["body"];
				$added_by = $row["added_by"];
				$date_time = $row["date_added"];

				if ($num_iterations++ < $start)
					continue;
				
				//Once 10 posts have been loaded, then break
				
				if ($count > $limit) {
					break;
				} else {
					$count++;
				}

				//Delete button for deleting own posts
				
				if ($_SESSION["username"] == $added_by) {
					$delete_button = "<button class='btn-sm delete_button btn btn-danger p-0' id='post$id'><i class='p-2 fa fa-trash-o' aria-hidden='true'></i></button>";
				} else {
					$delete_button = "";
				}


				$userDetailsQuery = "SELECT first_name, last_name, profile_pic FROM users WHERE username = '$added_by'";
				$run_userDetailsQuery = mysqli_query ($this->connection, $userDetailsQuery);
				$user_row = mysqli_fetch_array($run_userDetailsQuery);

				$first_name = $user_row["first_name"];
				$last_name = $user_row["last_name"];
				$profile_pic = $user_row["profile_pic"];

				?>
				
				<script>
					//Which comments to show
					function toggle<?php echo $id; ?>() {

						//When user clicks on the first name and last name take to profile page without showing the comments first
						var target = $(event.target);

						//If the target is to the href a link where span is inside this a, then do not show comments else, show comments
						if(!target.is("span")) { //

							if(!target.is("i")) {
								var element = document.getElementById ("toggleComment<?php echo $id; ?>");
						
								if (element.style.display == "block") {
									element.style.display = "none";
								} else {
									element.style.display = "block";
								}
							}
						}
					}
				</script>

				<?php

				//Showing No. of comments
				
				$commentsCheck = "SELECT * FROM post_comments WHERE post_id = '$id'";
				$run_commentsCheck = mysqli_query ($this->connection, $commentsCheck);
				$commentsCheckNum = mysqli_num_rows($run_commentsCheck);

				//Getting the timeframe for posts
				$date_time_now = date("Y-m-d H:i:s"); //Current time
				$start_date = new DateTime($date_time); //Time of post - Class
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

				$str .="<div class='row no-gutters' onClick='javascript:toggle$id()'>
							<div class='col-md-2 text-center my-1 bg-light p-4'>
								<img id='postImage' class='img img-fluid' src='$profile_pic' width='75'>
							</div>
							<div class='col-md-10 my-1 bg-light p-4'>
								<a href='$added_by'><span class='text-info'>$first_name $last_name</span></a>&nbsp;&nbsp;<span class='text-muted'>$time_message</span>&nbsp;&nbsp;&nbsp;$delete_button
								<p class='pt-2'>$body</p>
								<div class='col-md-12 text-info'>
									<p class='commentsPointer d-inline'>Comments</p>($commentsCheckNum) &nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' id='likes_iframe' scrolling='no'></iframe>
								</div>
							</div>
						</div>	
						<div class='row no-gutters post_comment' id='toggleComment$id' style='display:none'>
							<div class='col-md-12' embed-responsive embed-responsive-1by1 p-0'>
								<iframe height='300px' class='embed-responsive-item col-md-12 bg-white' src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
						</div>";

			?>
			
			<script>
				//Confirmation message for delete post on click - Using bootbox.min.js for confirmation message 
				$(document).ready(function() {
					$('#post<?php echo $id; ?>').on("click", function() {
						bootbox.confirm("Are you sure you want to delete this post?", function(result) {
							$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});
							if (result) {
								location.reload();
							}
						});
					});
				});
			</script>

			<?php	

		} //While Loop End

		if ($count > $limit) {
			$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) ."'><input type='hidden' class='noMorePosts' value='false'>";
		} else {
			$str .= "<input type='hidden' class='noMorePosts' value='true'><p class='text-center'>No More Posts To Show!</p>";
		}

	} //end of mysqli_num_rows($run_dataQuery) > 0
		echo $str;

	}//end of loadProfilePosts

	public function getSinglePost ($post_id) {
		$userLoggedIn = $this->user_obj->getUsername();

		$opened_query = mysqli_query ($this->connection, "UPDATE notifications SET opened='yes' WHERE user_to='$userLoggedIn' AND link LIKE '%=$post_id'");

		$str =""; //String to return

		$dataQuery = "SELECT * FROM posts WHERE deleted='no' AND id = '$post_id'";
		$run_dataQuery = mysqli_query ($this->connection, $dataQuery);

		if (mysqli_num_rows($run_dataQuery) > 0) {

			$row = mysqli_fetch_array($run_dataQuery);
			$id = $row["id"];
			$body = $row["body"];
			$added_by = $row["added_by"];
			$date_time = $row["date_added"];
		
		//Set the user_to value to be included in the submitted post data
		if ($row["user_to"] == "none") {
			$user_to = ""; //If the posts are added by the user but not to any other user
		} else {
			$user_to_obj = new User($this->connection, $row["user_to"]);
			$user_to_name = $user_to_obj->getFirstNameAndLastName();
			$user_to = "  to <a class='text-info' href='".$row['user_to']."'>" . $user_to_name . "</a>";
		}

		//Check if the user who posted has their account closed
		$added_by_obj = new User ($this->connection, $added_by);

		if ($added_by_obj->isClosed()) {
			return;
		}

		//Check if the user is friends with others
		$user_logged_obj = new User ($this->connection, $_SESSION["username"]);
		
		if ($user_logged_obj->isFriend($added_by)) {
				
			//Delete button for deleting own posts
			
			if ($_SESSION["username"] == $added_by) {
				$delete_button = "<button class='btn-sm delete_button btn btn-danger p-0' id='post$id'><i class='p-2 fa fa-trash-o' aria-hidden='true'></i></button>";
			} else {
				$delete_button = "";
			}


			$userDetailsQuery = "SELECT first_name, last_name, profile_pic FROM users WHERE username = '$added_by'";
			$run_userDetailsQuery = mysqli_query ($this->connection, $userDetailsQuery);
			$user_row = mysqli_fetch_array($run_userDetailsQuery);

			$first_name = $user_row["first_name"];
			$last_name = $user_row["last_name"];
			$profile_pic = $user_row["profile_pic"];

			?>
			
			<script>
				//Which comments to show
				function toggle<?php echo $id; ?>() {

					//When user clicks on the first name and last name take to profile page without showing the comments first
					var target = $(event.target);

					//If the target is to the href a link where span is inside this a, then do not show comments else, show comments
					if(!target.is("span")) { //

						if(!target.is("i")) { //When user clicks on delete post take to delete post without showing the comments first

						var element = document.getElementById ("toggleComment<?php echo $id; ?>");
				
						if (element.style.display == "block") {
							element.style.display = "none";
						} else {
							element.style.display = "block";
						}

						}
					}
				}
			</script>

			<?php

			//Showing No. of comments
			
			$commentsCheck = "SELECT * FROM post_comments WHERE post_id = '$id'";
			$run_commentsCheck = mysqli_query ($this->connection, $commentsCheck);
			$commentsCheckNum = mysqli_num_rows($run_commentsCheck);

			//Getting the timeframe for posts
			$date_time_now = date("Y-m-d H:i:s"); //Current time
			$start_date = new DateTime($date_time); //Time of post - Class
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

			$str .="<div class='row no-gutters' onClick='javascript:toggle$id()'>
						<div class='col-md-2 text-center my-1 bg-light p-4'>
							<img id='postImage' class='img img-fluid' src='$profile_pic' width='75'>
						</div>
						<div class='col-md-10 my-1 bg-light p-4'>
							<a href='$added_by'><span class='text-info'>$first_name $last_name</span></a>$user_to &nbsp;&nbsp;<span class='text-muted'>$time_message</span>&nbsp;&nbsp;&nbsp;$delete_button
							<p class='pt-2'>$body</p>
							<div class='col-md-12 text-info'>
								<p class='commentsPointer d-inline'>Comments</p>($commentsCheckNum) &nbsp;&nbsp;&nbsp;
								<iframe src='like.php?post_id=$id' id='likes_iframe' scrolling='no'></iframe>
							</div>
						</div>
					</div>	
					<div class='row no-gutters post_comment' id='toggleComment$id' style='display:none'>
						<div class='col-md-12' embed-responsive embed-responsive-1by1 p-0'>
							<iframe height='300px' class='embed-responsive-item col-md-12 bg-white' src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
						</div>
					</div>";



			?>
			
			<script>
				//Confirmation message for delete post on click - Using bootbox.min.js for confirmation message 
				$(document).ready(function() {
					$('#post<?php echo $id; ?>').on("click", function() {
						bootbox.confirm("Are you sure you want to delete this post?", function(result) {
							$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});
							if (result) {
								location.reload();
							}
						});
					});
				});
			</script>

	<?php
		} //End of - Check if the user is friends with others
		else {
			echo "<p class='text-info text-center pt-5'>You cannot view this post because you are not friends with this user.</p>";
			return;
		}	

	} //end of mysqli_num_rows($run_dataQuery) > 0
	else {
		echo "<p class='text-info text-center pt-5'>No post found. If you have clicked a link, it may be broken or Deleted.</p>.";
		return;
	}
		echo $str;
	} //End of getSinglePost()

} //End of Post class

?>
