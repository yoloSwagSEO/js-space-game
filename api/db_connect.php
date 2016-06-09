<?php

	// allinc
	// $hostname  = "dd1816.kasserver.com";
	// $database  = "d0206fb4";
	// $username  = "d0206fb4";
	// $password  = "uA6-MRX-b76-fGk";

	$hostname  = "localhost:8889";
	$database  = "js-space-game";
	$username  = "root";
	$password  = "root";

	//connection to the database
	$dbhandle = mysqli_connect($hostname, $username, $password, $database) or die("Unable to connect to mysqli");
	//select a database to work with
	//$selected = mysqli_select_db($database,$dbhandle) or die("Could not select examples");
?>
