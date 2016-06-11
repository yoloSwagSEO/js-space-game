<?php
require('api/db_connect.php');

//collect values from the url
$id = trim($_GET['x']);
$active = trim($_GET['y']);

//if id is number and the active token is not empty carry on
if(is_numeric($id) && !empty($active)){
	//update users record set the active column to Yes where the id and active value match the ones provided in the array
	$stmt = $db->prepare("UPDATE Users SET active = 'Yes' WHERE id = :id AND active = :active");
	$stmt->execute(array(
		':id' => $id,
		':active' => $active
	));

	//if the row was updated redirect the user
	if($stmt->rowCount() == 1){
		//redirect to login page
		header('Location: login.php?action=active');
		exit;
	} else {
		echo "Your account could not be activated!";
	}
}
?>
