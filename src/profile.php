<?php
    require_once ("includes/header.php"); //Header file includes config.php, head section and body opening tag
    $message_obj = new Message($connection, $userLoggedIn);

    //profile_username was set in .htaccess - It was set to profile.php?profile_username=$1 - Check .htaccess file
    if (isset($_GET["profile_username"])) {
        $username = $_GET["profile_username"];
        $userDetailsQuery = "SELECT * FROM users WHERE username='$username'";
        $run_userDetailsQuery = mysqli_query ($connection, $userDetailsQuery);
        $user_array = mysqli_fetch_array($run_userDetailsQuery);

        //Get the no. of friends user has - substr_count - Counts the no. of values found after each comma.
        //Started the friend array with comma first, hence reducing the count by 1
        $num_friends = (substr_count($user_array["friend_array"], ",")-1);
    }

    //Remove friend
    if (isset($_POST["remove_friend"])) {
        $user = new User($connection, $userLoggedIn);
        $user->removeFriend($username);
    }

    //Add Friend
    if (isset($_POST["add_friend"])) {
        $user = new User($connection, $userLoggedIn);
        $user->sendRequest($username);
    }

    //Respond To friend Request
    if (isset($_POST["respond_request"])) {
        header ("Location: requests.php");
    }

    //For handling messages in profile-messages tab
    if (isset($_POST["post_message"])) {
        if (isset($_POST["message_body"])) {
            $body = mysqli_real_escape_string($connection, $_POST['message_body']);
            $date = date("Y-m-d H:i:s");
            $message_obj->sendMessage($username, $body, $date);
        }

        //Once message is sent, the page reloads to newsfeed instead of staying there -Fix solution below
        $link = '#profileTabs a[href="#messages_div"]';
        echo "<script>
                $(function () {
                    $('" . $link . "').tab('show');
                });
            </script>";
    }
    
?>      
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-3">
                    <div class="col-md-12 bg-white bg-1">
                        <div class="row bg-light">
                            <div class="col-md-12 py-2 text-center">
                                <img class="img img-fluid mt-3 rounded" src="<?php echo $user_array["profile_pic"]; ?>">
                            </div>
                            <div class="col-md-12 py-2 text-center">
                                <p class="text-muted"><?php echo "Posts: " . $user_array["num_posts"]; ?></p>
                                <p class="text-muted"><?php echo "Likes: " . $user_array["num_likes"]; ?></p>
                                <p class="text-muted"><?php echo "Friends: " . $num_friends; ?></p>
                            </div>
                            <div class="col-md-12 py-2 text-center">
                                <form action="<?php echo $username; ?>" method="POST">
                                    <?php

                                        $profile_user_obj = new User ($connection, $username);

                                        if ($profile_user_obj->isClosed()) {
                                            header ("Location: user_closed.php");
                                        }

                                        $logged_in_user_obj = new User ($connection, $userLoggedIn);

                                        if ($userLoggedIn != $username) {
                                            if ($logged_in_user_obj->isFriend($username)) {
                                                echo "<input type='submit' name='remove_friend' class='btn btn-danger' value='Remove Friend'>";
                                            } 
                                            elseif ($logged_in_user_obj->didReceiveRequest($username)) {
                                                echo "<input type='submit' name='respond_request' class='btn btn-info' value='Respond to Request'>";
                                            }
                                            elseif ($logged_in_user_obj->didSendRequest($username)) {
                                                echo "<input type='submit' name='' class='btn btn-secondary' value='Request Sent'>";
                                            }
                                            else {
                                                echo "<input type='submit' name='add_friend' class='btn btn-success' value='Add Friend'>";
                                            }         
                                        }

                                    ?>
                                </form>
                                <!-- Button trigger modal for posting to users or self-->
                                <div class="col-md-12 py-2 text-center">
                                    <input type="submit" class="btn btn-success my-3" data-toggle="modal" data-target="#post_form" value="Post Something">
                                </div>
                                <!-- Displaying Mutual friends -->    
                                <div class="col-md-12 py-2 text-center text-info">
                                    <?php 

                                        if ($userLoggedIn != $username) {
                                            echo $logged_in_user_obj->getMutualFriends($username). " Mutual friends";
                                        }

                                    ?>
                                </div> 
                                <!-- Modal for posts on profile page-->
                                <div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title ml-auto" id="exampleModalLabel">Post Something</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-muted">This will appear on the user's profile page and also their newsfeed for your friends to see!</p>
                                                <form class="profile_post" action='' method="POST">
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="post_body"></textarea>
                                                        <input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
                                                        <input type="hidden" name="user_to" value="<?php echo $username; ?>">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" name="post_button" id="submit_profile_post" >Post</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-9 bg-white bg-1 p-2'>
                    <ul class="nav nav-tabs mb-1" role="tablist" id="profileTabs">
                        <li class="nav-item">
                            <a class="text-info nav-link active" href="#newsfeed_div" aria-controls="newsfeed_div" role="tab" data-toggle="tab">Newsfeed</a>
                         </li>
                        <li class="nav-item">
                            <a class="text-info nav-link" href="#messages_div" aria-controls="messages_div" role="tab" data-toggle="tab">Messages</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active show" id="newsfeed_div">
                             <div class="posts_area">
                                <?php
                                    //Loading posts using ajax - infinite auto scroll 
                                    //$post = new Post ($connection, $userLoggedIn);
                                    //$post->loadPostsFriends();
                                ?>
                            </div>
                            <img class="img img-fluid" src="img/loading.gif" id="loading"><!-- gif image for posts loading indicator -->
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="messages_div">
                            <div class="col-md-12 bg-white loaded_messages clearfix" id="scroll_messages">
                                <?php 
                                        echo "<h4 class='my-3 text-center text-info'>You and <b><a class='text-info' href='".$_GET["profile_username"]."'>" . $profile_user_obj->getFirstNameAndLastName() . "</a></b></h4><hr>";
                                        echo "<div>";
                                                echo $message_obj->getMessages($_GET["profile_username"]); //profileUsername['username']
                                        echo "</div>";
                                ?>
                            </div>
                            <div class="col-md-12 bg-white message_post pt-3">
                                <form action="" method="POST">
                                    <div class='form-group'>
                                        <textarea class='form-control' name='message_body' id='message_textarea' placeholder='Write Your Message ...'></textarea>
                                    </div>
                                    <div class='form-group'>
                                        <input class='form-control  btn btn-success' type='submit' name='post_message' class='info' id='message_submit' value='Send'>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/register.js"></script>
        <script>
            //For Loading newsfeed posts in profile page
            var userLoggedIn = '<?php echo $userLoggedIn; ?>';

            var profileUsername = '<?php echo $username; ?>';

            $(document).ready(function() {

                $('#loading').show();

                //Original ajax request for loading first posts 
                $.ajax({
                    url: "includes/handlers/ajax_load_profile_posts.php",
                    type: "POST",
                    data: "page=1&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
                    cache:false,

                    success: function(data) {
                        $('#loading').hide();
                        $('.posts_area').html(data);
                    }
                });

                $(window).scroll(function() {
                    var height = $('.posts_area').height(); //Div containing posts
                    var scroll_top = $(this).scrollTop();
                    var page = $('.posts_area').find('.nextPage').val();
                    var noMorePosts = $('.posts_area').find('.noMorePosts').val();

                    if ($(window).scrollTop() == $(document).height() - $(window).height() && noMorePosts == 'false') {
                        $('#loading').show();

                        var ajaxReq = $.ajax({
                            url: "includes/handlers/ajax_load_profile_posts.php",
                            type: "POST",
                            data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
                            cache:false,

                            success: function(response) {
                                $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
                                $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 

                                $('#loading').hide();
                                $('.posts_area').append(response);
                            }
                        });

                    } //End if 

                    return false;

                }); //End (window).scroll(function())

            });
        </script>
        <script>
            //To fix the messages which refereshed and goes to top after sending messages in message.php instead of staying there fixed
            var div = document.getElementById("scroll_messages");
            div.scrollTop = div.scrollHeight;
        </script>
    </body>
</html>