<?php 

	include ("includes/header.php");

	$message_obj = new Message ($connection, $userLoggedIn);

	//If user name is set in messages page then get username
	if (isset($_GET["u"])) {
		$user_to = $_GET["u"];
	} else {
		$user_to = $message_obj->getMostRecentUser(); //If not set, then get most recent user the person had interaction with
		if ($user_to == false) { //If no recent users found, then 
			$user_to ='new'; //If there are no recent interaction i.e - User is new - Send a new message
		}
	}

	if ($user_to != "new") {
		$user_to_obj = new User($connection, $user_to);
	}

	if (isset($_POST["post_message"])) {
		if (isset($_POST["message_body"])) {

			//mysqli_real_escape_string takes off all quotes - When a mysqli statement is run, if quotes are present in the $body, then mysqli statement will execute it as a new string - To negate this, real escape the string
			$body = mysqli_real_escape_string($connection, $_POST["message_body"]);
			$date = date("Y-m-d H:i:s");
			$message_obj->sendMessage($user_to, $body, $date);
		}
	}

?>

<div class="container mt-2">
    <div class="row messages_height">
        <div class="col-md-4">
            <div class="col-md-12 bg-white bg-1">
                <div class="row">
                    <div class="col-md-6 py-3 text-center">
                        <a href="<?php echo $userLoggedIn; ?>"><img class="img img-fluid rounded-circle" src="<?php echo $profilePic;?>"></a>
                    </div>
                    <div class="col-md-6 py-4 text-center">
                        <a href="<?php echo $userLoggedIn; ?>" class="text-info"><?php echo $userFname . " ". $userLname;?></a>
                        <a class="text-muted" href="#"><?php echo "Posts:" . $userPosts;?></a>
                        <a class="text-muted" href="#"><?php echo "Likes:" . $userLikes;?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 bg-white bg-1 mt-2">
                <div class="row">
                    <div class="col-md-12 pt-3 text-center">
						<h4 class='text-info'>Conversations</h4>
                    </div>
                    <div class="col-md-12 pb-3 text-center">
                    	<div class="row">
							<?php  echo $message_obj->getConvos(); ?>
						</div>
                    </div>
                    <div class="col-md-12 pb-3 text-center">
						<a class='btn btn-success' href="messages.php?u=new">New Message</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
        	<div class="col-md-12 bg-white bg-1 loaded_messages clearfix" id="scroll_messages">
		        <?php 

		        	if ($user_to != "new") {
		        		echo "<h4 class='my-3 text-center text-info'>You and <b><a class='text-info' href='$user_to'>" . $user_to_obj->getFirstNameAndLastName() . "</a></b></h4><hr>";
		        		echo "<div>";
		        				echo $message_obj->getMessages($user_to);
		        		echo "</div>";
		        	}

		        ?>
			</div>
			<div class="col-md-12 bg-white bg-1 clearfix">
		        <?php 

		        	if ($user_to == "new") {
		        		echo "<h4 class='text-center text-info pt-3'>New Message</h4>";
		        	}

		        ?>
			</div>
	        <div class="col-md-12 bg-white bg-1 message_post pt-3">
	        	<form action="" method="POST">
	        		<?php 

	        			if ($user_to == "new") {
	        				echo "<p class='lead my-3 text-center text-info'>Select the friend you would like to message</p>";
	        		?> 

	        				<p class='lead text-info'>To:</p> <div class='form-group'><input type='text' name='q' placeholder='Name' autocomplete='off' id='search_text_input' onkeyup='getUsers (this.value, "<?php echo $userLoggedIn; ?>")' class='form-control'></div>

	        		<?php
	        				echo "<div class='results col-md-12'></div>";
	        			} else {
	        				echo "<div class='form-group'><textarea class='form-control' name='message_body' id='message_textarea' placeholder='Write Your Message ...'></textarea></div>";
	        				echo "<div class='form-group'><input class='form-control  btn btn-success' type='submit' name='post_message' class='info' id='message_submit' value='Send'></div>";
	        			}

	        		?>
	        	</form>
	        </div>
	    </div>
	</div>    
</div>
<script>
	//To fix the messages which refereshed and goes to top after sending messages in message.php instead of staying there fixed
	var div = document.getElementById("scroll_messages");
	div.scrollTop = div.scrollHeight;
</script>

