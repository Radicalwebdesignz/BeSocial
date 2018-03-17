<?php
include ('../../config/config.php');
include ("../classes/User.php");
include ("../classes/Notification.php");

$limit = 4; //Number of messages to load

$notification = new Notification($connection, $_REQUEST['userLoggedIn']);
echo $notification->getNotifications($_REQUEST, $limit);

?>