<?php

	// live
	// $hostname  = "dd1816.kasserver.com";
	// $hostport  = "";
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

	// define('DBHOST','dd1816.kasserver.com');
	// define('DBUSER','d02260f9');
	// define('DBPASS','JRv-Qp4-M3h-UxJ');
	// define('DBNAME','d02260f9');
	// define('DBPORT', '');

	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', 'root');
	define('DBNAME', 'js-space-game');
	define('DBPORT', '8889');

	//application address
	define('DIR','http://onmyown.at/jsgame/');
	define('SITEEMAIL','noreply@onmyown.at');
	ob_start();
	session_start();
	try {
		//create PDO connection
		$db = new PDO("mysql:host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME, DBUSER, DBPASS); //check port
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} catch(PDOException $e) {
		//show error
		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		exit;
	}

	include('classes/user.php');
	$user = new User($db);
	$userData = (object) array(
		'loggedIn' => $_SESSION['loggedin'],
		'userName' => $_SESSION['username'],
		'userId' => $user->findIdbyName($_SESSION['username'])
	);
?>
