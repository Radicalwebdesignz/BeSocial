<?php 

	require_once ("includes/header.php"); //Header file includes config.php, head section and body opening tag

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		$id = 0;
	}


?>

	<div class="container mt-2">
        <div class="row">
            <div class="col-md-3">
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
            </div>
            <div class='col-md-9 bg-white bg-1 p-2'>
                <div class="posts_area">
                    <?php 
						$post = new Post ($connection, $userLoggedIn);
						$post->getSinglePost($id);
					?>
                </div>
            </div>
        </div>
    </div>        