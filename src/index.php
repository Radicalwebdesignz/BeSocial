<?php
    require_once ("includes/header.php"); //Header file includes config.php, head section and body opening tag
    require_once ("includes/classes/User.php"); //Include User class file
    require_once ("includes/classes/Post.php"); //Include Posts class file

    //Activate the postSubmit button
    if (isset($_POST["postSubmit"])) {

        //File upload
        $uploadOk = 1; // This will be status message to check if it is ok to upload or not
        $imageName = $_FILES['fileToUpload']['name'];
        $errorMessage = "";

        if ($imageName != "") {

            $targetDir = "img/posts/";
            //uniqueid() - Creates a unique string
            //The new $imageName or path will be as below  = img/posts/uniqueidimg.jpg
            $imageName = $targetDir . uniqid() . basename($imageName);

            //pathinfo - gets the path info of $imageName - PATHINFO_EXTENSION - gets the extension og $PATHINFO_EXTENSION like jpg png
            $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

            if ($_FILES['fileToUpload']['size'] > 10000000) { //Size in bytes
                $errorMessage = "Sorry Your file is too large";
                $uploadOk = 0;
            }

            if (strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
                $errorMessage = "Sorry, Only jpeg, jpg and png files are allowed";
                $uploadOk = 0;
            }

            //Check if all the above checks pass and $uploadOk is 1
            //['tmp_name'] - Gives a temp name while uploading
            
            if ($uploadOk) {
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) { 
                    //image uploaded
                } else {
                    //Image did not upload
                    $uploadOk = 0;
                }
            }

        } //if ($imageName != "")

        if ($uploadOk) {
            $post = new Post ($connection, $userLoggedIn);
            $post->submitPost ($_POST["postText"], "none", $imageName);
        }else {
            echo "<div class='text-center alert alert-danger'>
                    $errorMessage
                </div>";
        }

    }
    
?>      
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-3">
                    <!-- left section - User details -->
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
                    <!-- Popular trending section -->
                    <div class="col-md-12 bg-white bg-1 mt-2 pb-3">
                        <h5 class='text-info pt-3 text-center'>Trending Words</h5>
                        <?php 

                            $query = mysqli_query ($connection, "SELECT * FROM trends ORDER BY hits DESC LIMIT 9");
                            //For each row in the $query
                            foreach ($query as $row) {

                                $word = $row['title'];
                                $word_dot = strlen($word) >= 14 ? "..." : "";

                                $trimmed_word = str_split ($word, 14);
                                $trimmed_word = $trimmed_word[0];
                                echo "<p class='text-muted text-center p-0 m-0'>";
                                echo $trimmed_word . $word_dot;
                                echo "</p>";
                            }
                        ?>
                    </div>
                </div>
                <!-- Add new post section -->
                <div class="col-md-9">
                    <div class="col-md-12 bg-white bg-1">
                        <form action="index.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-7 pt-3">
                                    <div class="form-group">
                                        <textarea name="postText" rows="1" class="form-control" placeholder="Got Something To Say?"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3 pt-3">
                                    <div class="form-group form-check">
                                        <input type="file" class="small form-check-input" name="fileToUpload">
                                    </div>
                                </div>
                                <div class="col-md-2 pt-3">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-info form-control" name="postSubmit" value="Post">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Posts Section -->
                    <div class='col-md-12 bg-white bg-1 p-2 my-3'>
                        <div class="posts_area">
                            <?php
                                //Loading posts using ajax - infinite auto scroll 
                                //$post = new Post ($connection, $userLoggedIn);
                                //$post->loadPostsFriends();
                            ?> -->
                        </div>
                        <img class="img img-fluid" src="img/loading.gif" id="loading"><!-- gif image for posts loading indicator -->
                    </div>
                </div>
            </div>
        </div>

        
        <!-- <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/register.js"></script> -->
        <script src="js/infiniteautoscroll.js"></script>
    </body>
</html>