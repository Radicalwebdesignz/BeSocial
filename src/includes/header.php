<?php
    require_once ("config/config.php");
    require_once ("includes/classes/User.php");
    require_once ("includes/classes/Post.php");
    require_once ("includes/classes/Message.php");
    require_once ("includes/classes/Notification.php");

    //If username session is not set i.e user not logged in - redirect to registar.php page
    if (isset($_SESSION["username"])) { //$_SESSION["username"] was set in login_handler.php
        $userLoggedIn = $_SESSION["username"];

        //Get the users first name
        $userDetailsQuery = "SELECT * FROM users WHERE username='$userLoggedIn'";
        $run_userDetailsQuery = mysqli_query($connection, $userDetailsQuery);

        $userDetailsQueryRow = mysqli_fetch_array ($run_userDetailsQuery);
        $userFname = $userDetailsQueryRow["first_name"];
        $userLname = $userDetailsQueryRow["last_name"];
        $profilePic = $userDetailsQueryRow["profile_pic"];
        $userPosts = $userDetailsQueryRow["num_posts"];
        $userLikes = $userDetailsQueryRow["num_likes"];


    } else {
        header ("Location: register.php");
    }
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/customStyle.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootbox.min.js"></script>
        <script src="js/jquery.jcrop.js"></script>
        <script src="js/jcrop_bits.js"></script>
        <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
        <script src="js/main.js"></script>
        <title>Welcome To BeSocial</title>
    </head>

    <body>
        <!-- Nav Section -->
        
        <nav class="navbar navbar-expand-md navbar-dark" id="bg-primary1">
            <?php 

                //unread Messages
                $messages = new Message($connection, $userLoggedIn);
                $num_messages = $messages->getUnreadNumber();

                //Unread Notifications
                $notifications = new Notification($connection, $userLoggedIn);
                $num_notifications = $notifications->getUnreadNumber();

                //Unread friends requests
                $user_obj = new User($connection, $userLoggedIn);
                $num_requests = $user_obj->getNumberOfFriendRequests();

            ?>
            <a href="index.php" class="navbar-brand pl-5"><h3 id="logo">BeSocial</h3></a>
            <div class="container">
                <button class="navbar-toggler" type="button" data-target="#navbarNav" data-toggle="collapse"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="search">
                        <form action="search.php" method="GET" class="form-inline" name="search_form">
                            <input class="form-control" id="search_text_input" placeholder="Search..." autocomplete="off" name="q" type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn?>')">
                            <div class="button_holder pt-1">
                                <img src="img/magnifying_glass.png" class="img img-fluid">
                            </div>
                        </form>
                    </div>
        
                <!--     <div class="search_results"></div>    
                    <div class="search_results_footer_empty"></div> -->
                    
                    <ul class="navbar-nav ml-auto text-center">
                        <li class="nav-item"><a title="Home" href="index.php" class="nav-link"><i class="fa fa-home fa-2x"></i></a></li>
                        <li class="nav-item">
                            <a title="Messages" href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')" class="nav-link">
                                <i class="fa fa-envelope  fa-2x"></i>
                                    <?php 
                                        if ($num_messages >= 0) {
                                            echo'<span class="d-none d-lg-inline notification_badge badge badge-pill badge-danger" id="unread_message">' . $num_messages . '</span>';
                                        }
                                    ?>
                            </a></li>
                        <li class="nav-item">
                            <a title="Notifications" href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')" class="nav-link">
                                <i class="fa fa-bell-o fa-2x"></i>
                                <?php 
                                    if ($num_notifications >= 0) {
                                        echo'<span class="d-none d-lg-inline notification_badge badge badge-pill badge-danger" id="unread_notification">' . $num_notifications . '</span>';
                                    }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a title="Users" href="requests.php" class="nav-link">
                                <i class="fa fa-users  fa-2x"></i>
                                <?php 
                                    if ($num_requests >= 0) {
                                        echo'<span class="d-none d-lg-inline notification_badge badge badge-pill badge-danger" id="unread_requests">' . $num_requests . '</span>';
                                    }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item"><a title="Settings" href="settings.php" class="nav-link"><i class="fa fa-cog fa-2x"></i></a></li>
                        <li class="nav-item"><a title="Signout" href="includes/handlers/logout.php" class="nav-link"><i class="fa fa-sign-out fa-2x"></i></a></li>
                        <li class="nav-item"><a title="Current User" href="<?php echo $userLoggedIn; ?>" class="nav-link pt-2">
                            <span id="user" class="pt-4">
                                <?php echo $userFname;?>
                            </span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="col-md-12 pb-2" id="bg-primary2"></div>

        <!-- Message Notification -->
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    
                </div>
                <div class="col-md-3">
                    <div class='dropdown_data_window dropdownMessage bg-light' style='height:0px;'></div>
                    <input type="hidden" id="dropdown_data_type" value=''>
                </div>
            </div>
        </div>
        
        <!-- users search -->
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                    <div class="search_results">
                       
                    </div>    
                     
                </div>
            </div>
        </div>

        
        
        <script>
    var userLoggedIn = '<?php echo $userLoggedIn; ?>';

    $(document).ready(function() {

        $('.dropdown_data_window').scroll(function() {
            var inner_height = $('.dropdown_data_window').innerHeight(); //Div containing data
            var scroll_top = $('.dropdown_data_window').scrollTop();
            var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
            var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

            if ((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') {

                var pageName; //Holds name of page to send ajax request to
                var type = $('#dropdown_data_type').val();


                if(type == 'notification')
                    pageName = "ajax_load_notifications.php";
                else if(type = 'message')
                    pageName = "ajax_load_messages.php"


                var ajaxReq = $.ajax({
                    url: "includes/handlers/" + pageName,
                    type: "POST",
                    data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                    cache:false,

                    success: function(response) {
                        $('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
                        $('.dropdown_data_window').find('.noMoreDropdownData').remove(); //Removes current .nextpage 


                        $('.dropdown_data_window').append(response);
                    }
                });

            } //End if 

            return false;

        }); //End (window).scroll(function())


    });

    </script>

        
        
    