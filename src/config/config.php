<?php
    ob_start(); //Turns on output buffering 
    session_start();

    //By Default the time zone fetched is of the server. You ned to specify the timezone to be used
    date_default_timezone_set("Asia/Kolkata");
    
    $connection = mysqli_connect("localhost", "root", "", "besocial");

    if(!$connection) {
        echo mysqli_connect_error($connection). "<br>";
        echo mysqli_connect_errno($connection);
    }

?>   