<?php

    require_once ("config/config.php");
    require_once ("includes/form_handlers/register_handler.php");
    require_once ("includes/form_handlers/login_handler.php");
    
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
        <title>Welcome To BESocial</title>
        <script src="js/jquery.min.js"></script>
    </head>

    <body class="wrapper">
        

        <?php 
            //If the register button is clicked while registering - Register form hides and goes to login form. To stop this, run the code below - This code requires jquery, hence loaded it in head section - Only for this
            if (isset($_POST["register_button"])) {
                echo '
                    <script>
                        $(document).ready(function(){
                            $("#first").hide();
                            $("#second").show();
                        });
                    </script>
                ';            
            }

        ?>

        <div class="container-fluid">
            <div class="row mt-4 position-center">
                <!-- Login Form -->
                <div class="col-md-6"></div>
                <div class="col-md-4 px-0 mt-2 bg-light form-style border-radius-top">
                    <h1 class="text-white bg-info text-center form-style p-2 border-radius-top">BeSocial!</h1>
                    <div id="first">
                        <div class="form-style bg-light p-3">
                            <h5 class="text-center Bellota-Bold">LOGIN</h5>
                            <form action="register.php" method="POST" class="px-3">
                                <div class="form-group">
                                    <!-- Error Message display-->
                                    <small class="text-danger">
                                        <?php if (in_array($loginFailed, $error_array)) { echo $loginFailed; }?>
                                    </small>
                                    <input type="email" name="login_email" placeholder="Email" class="form-control" required value="
                                    <?php
                                        //Input the value of session in values field in form
                                        if (isset($_SESSION["login_email"])) {
                                            echo $_SESSION["login_email"];
                                        }
                                    ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="login_password" placeholder="Password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="login_button" value="Login" class="btn btn-primary btn-block">
                                </div>
                            </form>
                            <h5 class="text-center"><a id="login" class="text-info font-italic" href="#">Need An account? Sign Up Here</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>

                <!-- Register Form -->
                <div class="col-md-6"></div>
                <div class="col-md-4 mb-5 px-0 bg-light form-style">
                    <div id="second">
                        <div class="form-style bg-light p-3">
                            <h5 class="text-center Bellota-Bold">REGISTER</h5>
                            <form action="register.php" class="px-3" method="POST">
                                <div class="form-group">
                                    <input type="text" name="register_fname" placeholder="First Name" class="form-control" required value="<?php
                                    //Input the value of session in values field in form
                                    if (isset($_SESSION["register_fname"])) {
                                        echo $_SESSION['register_fname'];
                                    }
                                    ?>">
                                    <!-- Error Message display-->
                                    <small class="text-danger">
                                        <?php if (in_array($fnameLengthError, $error_array)) { echo $fnameLengthError; }?>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="register_lname" placeholder="Last Name" class="form-control" required value="<?php
                                    //Input the value of session in values field in form
                                    if (isset($_SESSION["register_lname"])) {
                                        echo $_SESSION['register_lname'];
                                    }
                                    ?>">
                                    <!-- Error Message display-->
                                    <small class="text-danger">
                                        <?php if (in_array($lnameLengthError, $error_array)) { echo $lnameLengthError; }?>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="register_email" placeholder="Email" class="form-control" required value="
                                    <?php
                                    //Input the value of session in values field in form
                                    if (isset($_SESSION['register_email'])) {
                                        echo $_SESSION['register_email'];
                                    }
                                    ?>">
                                    <!-- Error Message display-->
                                    <small class="text-danger">
                                        <?php if (in_array($emailDuplicateError, $error_array)) { echo $emailDuplicateError; }?>
                                    </small>
                                    <!-- Error Message display-->
                                    <small class="text-danger">
                                        <?php if (in_array($invalidEmailFormat, $error_array)) { echo $invalidEmailFormat; }?>
                                    </small>
                                    <!-- Error Message display-->
                                    <small class="text-danger">
                                        <?php if (in_array($emailMismatchError, $error_array)) { echo $emailMismatchError; }?>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="register_cemail" placeholder="Confirm Email" class="form-control" required value="<?php
                                    //Input the value of session in values field in form
                                    if (isset($_SESSION['register_cemail'])) {
                                        echo $_SESSION['register_cemail'];
                                    }
                                    ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="register_password" placeholder="Password" class="form-control" required>
                                    <!-- Error Message display-->
                                    <small class="text-danger">
                                        <?php if (in_array($passwordMismatchError, $error_array)) { echo $passwordMismatchError; }?>
                                    </small>
                                    <!-- Error Message display-->
                                    <small class="text-danger">
                                        <?php if (in_array($passwordFormatError, $error_array)) { echo $passwordFormatError; }?>
                                    </small>
                                    <!-- Error Message display-->
                                    <small class="text-danger">
                                        <?php if (in_array($passwordLengthError, $error_array)) { echo $passwordLengthError; }?>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="register_cpassword" placeholder="Confirm Password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="register_button" value="Register" class="btn btn-primary btn-block">
                                </div>
                                <?php 
                                    //Display success message when account created successfully
                                    if (in_array($accountCreatedSuccessfully, $error_array)) {
                                        echo "<div class='text-center alert alert-success'>" . $accountCreatedSuccessfully . "</div>";
                                    }
                                ?>
                            </form>
                            <h5 class="text-center"><a id="signup" class="font-italic text-info" href="#">Already Have An account? Sign In Here</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/register.js"></script>
    </body>
</html>