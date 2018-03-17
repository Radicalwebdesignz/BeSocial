<?php 

	include ("../../config/config.php");
	include ("../classes/User.php");
	include ("../classes/Message.php");

	$limit = 4; //No. of messages to load

	$message = new Message ($connection, $_REQUEST["userLoggedIn"]);
	echo $message->getConvosDropdown($_REQUEST, $limit);

?>