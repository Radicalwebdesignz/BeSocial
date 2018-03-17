<?php 

	//Set variables
    $fname = ""; //First Name
    $lname = ""; //Last Name
    $email = ""; //Email Name
    $confirmEmail = ""; //Confirm Email Name
    $password = ""; //Password Name
    $confirmPassword = ""; //Confirm Password
    $error_array = array(); //Holds error message

    //Set Variables for different error messages - These will be pushed to error_array and will be echoed in form
    $emailDuplicateError = "This Email has already been registered. Use Another<br>";
    $invalidEmailFormat = "Email format is invalid<br>";
    $emailMismatchError = "Emails Do Not Match<br>";
    $fnameLengthError = "First Name must be between 3 to 200 characters<br>";
    $lnameLengthError = "Last Name must be between 3 to 200 characters<br>";
    $passwordMismatchError = "Passwords Do Not Match<br>";
    $passwordFormatError = "Password must contain only letters and characters<br>";
    $passwordLengthError = "Password must be between 3 to 200 characters<br>";
    $accountCreatedSuccessfully = "Account Created Successfully. Login Now!!<br>";
    $loginFailed = "Email or Password is incorrect. Try Again<br>";

    //Set Date and Time
    
    //By Default the time zone fetched is of the server. You ned to specify the timezone to be used
    date_default_timezone_set("Asia/Kolkata");

    //Gets the current time of server
    $currentTime = time();

    //Format the time and/or date
    
    $date = strftime("%b-%d-%Y %H:%M:%S", $currentTime);

    //If the register button is activated run the code below
    if (isset($_POST["register_button"])) {

        //Get the first name field from the form 
        
        $fname = $_POST["register_fname"];
        $fname = strip_tags($fname); //Remove html tags
        $fname = str_replace(" ", "", $fname); //Remove spaces
        $fname = ucfirst(strtolower($fname)); //Convert fname to lowercase and convert the first char to upper
        $_SESSION["register_fname"] = $fname; // Created a session to store the first name - So that these values can be stored in their respective form fields when there is error

        //Get the last name field from the form 
        
        $lname = $_POST["register_lname"];
        $lname = strip_tags($lname); //Remove html tags
        $lname = str_replace(" ", "", $lname); //Remove spaces
        $lname = ucfirst(strtolower($lname)); //Convert fname to lowercase and convert the first char to upper
        $_SESSION["register_lname"] = $lname; // Created a session to store the last name - So that these values can be stored in their respective form fields when there is error

        //Get the email field from the form 
        
        $email = $_POST["register_email"];
        $email = strip_tags($email); //Remove html tags
        $email = str_replace(" ", "", $email); //Remove spaces
        $email = ucfirst(strtolower($email)); //Convert fname to lowercase and convert the first char to upper
        $_SESSION["register_email"] = $email; // Created a session to store the email - So that these values can be stored in their respective form fields when there is error

        //Get the confirm email field from the form 
        
        $confirmEmail = $_POST["register_cemail"];
        $confirmEmail = strip_tags($confirmEmail); //Remove html tags
        $confirmEmail = str_replace(" ", "", $confirmEmail); //Remove spaces
        $confirmEmail = ucfirst(strtolower($confirmEmail)); //Convert fname to lowercase and convert the first char to upper
        $_SESSION["register_cemail"] = $confirmEmail; // Created a session to store the confirm Email field - So that these values can be stored in their respective form fields when there is error

        //Get the password field from the form - Dont want to replace spaces or convert char to upper or lower on password
        
        $password = $_POST["register_password"];
        $password = strip_tags($password); //Remove html tags

        //Get the confirm password field from the form - Dont want to replace spaces or convert char to upper or lower on password
        
        $confirmPassword = $_POST["register_cpassword"];
        $confirmPassword = strip_tags($confirmPassword); //Remove html tags

        //Check if email and confirm email matches, is in valid format and email already exists
        if ($email == $confirmEmail) {

            //Validate the email
            if (filter_var ($email, FILTER_VALIDATE_EMAIL)) {

                $email = filter_var ($email, FILTER_VALIDATE_EMAIL);

                //Check if the email already exists
                $emailCheck = "SELECT email FROM users WHERE email='$email'";
                $run_emailCheck = mysqli_query ($connection, $emailCheck);

                //Count the number of rows returned from the above query
                $num_rows = mysqli_num_rows($run_emailCheck);

                if ($num_rows > 0) {

                    //Store the error message in array
                    array_push($error_array, $emailDuplicateError);

                } else{}

            } else {

                //Store the error message in array
                array_push($error_array, $invalidEmailFormat);

            }

        } else {

            //Store the error message in array
            array_push($error_array, $emailMismatchError);

        }

        //First Name length Check
        
        if (strlen($fname) > 200 || strlen($fname) < 3) {

            //Store the error message in array
            array_push($error_array, $fnameLengthError);

        } 

        //Last Name length Check
        
        if (strlen($lname) > 200 || strlen($lname) < 3) {

            //Store the error message in array
            array_push($error_array, $lnameLengthError);

        }

        //Check if password and confirm password matches and is in valid format
        
        if ($password != $confirmPassword ) {

            //Store the error message in array
            array_push($error_array, $passwordMismatchError);

        } else {
            if (preg_match('/[^A-Za-z0-9]/', $password)) {

                //Store the error message in array
                array_push($error_array, $passwordFormatError);

            }
        }

        //Check the password length
        
        if (strlen($password) > 200 || strlen($password) < 3) {

            //Store the error message in array
            array_push($error_array, $passwordLengthError);

        }

        //If the error_array is empty i.e no errors in the array - Execute this code
        if (empty($error_array)) {

            //Encrypt password
            $password =md5($password);
            
            //Create a username for the user
            
            $username = strtolower($fname . "_" . $lname);

            //Check to see if the username is already exists in the database
            
            $checkUsernameQuery = "SELECT username FROM users WHERE username='$username'";
            $run_checkUsernameQuery = mysqli_query ($connection, $checkUsernameQuery);

            //Count the numbers of username rows if found
            $usernameRowsFound = mysqli_num_rows($run_checkUsernameQuery);

            $i = 0;

            //If username is found - Add number to the username
            while ($usernameRowsFound) { //if username row is found - Then username already exists

                $i++; //Increment to 1
                $username = strtolower ($fname . "_" . $lname . "_" . $i); //If username already found - Change it to this

                //Repeat the query to check if the new username with added number exists - Repeats until username is not found
                $checkUsernameQuery = "SELECT username FROM users WHERE username='$username'";
                $run_checkUsernameQuery = mysqli_query ($connection, $checkUsernameQuery);
                $usernameRowsFound = mysqli_num_rows($run_checkUsernameQuery);

            }

            //Profile Picture assignment
            $rand = rand(1,16); //Generates a random number between 1 - 16

            //Assign the profile pics according to the random number generated

            if ($rand == 1) {
               $profile_pic = "img/profile_pics/default/head_alizarin.png";
            }
            elseif ($rand == 2) {
               $profile_pic = "img/profile_pics/default/head_amethyst.png";
            }
            elseif ($rand == 3) {
               $profile_pic = "img/profile_pics/default/head_belize_hole.png";
            }
            elseif ($rand == 4) {
               $profile_pic = "img/profile_pics/default/head_carrot.png";
            }
            elseif ($rand == 5) {
               $profile_pic = "img/profile_pics/default/head_deep_blue.png";
            }
            elseif ($rand == 6) {
               $profile_pic = "img/profile_pics/default/head_emerald.png";
            }
            elseif ($rand == 7) {
               $profile_pic = "img/profile_pics/default/head_green_sea.png";
            }
            elseif ($rand == 8) {
               $profile_pic = "img/profile_pics/default/head_nephritis.png";
            }
            elseif ($rand == 9) {
               $profile_pic = "img/profile_pics/default/head_pete_river.png";
            }
            elseif ($rand == 10) {
               $profile_pic = "img/profile_pics/default/head_pomegranate.png";
            }
            elseif ($rand == 11) {
               $profile_pic = "img/profile_pics/default/head_pumpkin.png";
            }
            elseif ($rand == 12) {
               $profile_pic = "img/profile_pics/default/head_red.png";
            }
            elseif ($rand == 13) {
               $profile_pic = "img/profile_pics/default/head_sun_flower.png";
            }
            elseif ($rand == 14) {
               $profile_pic = "img/profile_pics/default/head_turqoise.png";
            }
            elseif ($rand == 15) {
               $profile_pic = "img/profile_pics/default/head_wet_asphalt.png";
            }
            elseif ($rand == 16) {
               $profile_pic = "img/profile_pics/default/head_wisteria.png";
            }

            //Insert form values in to database
            
            $insertQuery = "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')";
            $run_insertQuery = mysqli_query ($connection, $insertQuery);

            //Once form data is submitted to the database, echo out a success message
            
            array_push($error_array, $accountCreatedSuccessfully);

            //Once the account is created successfully, clear the session which stores the fname, lname and email
            
            $_SESSION["register_fname"] = "";
            $_SESSION["register_lname"] = "";
            $_SESSION["register_email"] = "";
            $_SESSION["register_cemail"] = "";

        }
    }

?>