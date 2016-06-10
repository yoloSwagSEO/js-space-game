<?php

	// live
	// $hostname  = "dd1816.kasserver.com";
	// $database  = "d02260f9";
	// $username  = "d02260f9";
	// $password  = "JRv-Qp4-M3h-UxJ";

	// localhost
	$hostname  = "localhost";
	$hostport  = "8889";
	$database  = "js-space-game";
	$username  = "root";
	$password  = "root";

	//connection to the database
	$dbhandle = mysqli_connect($hostname, $username, $password, $database, $hostport) or die("Unable to connect to mysqli");
	//select a database to work with
	//$selected = mysqli_select_db($database,$dbhandle) or die("Could not select examples");
?>
