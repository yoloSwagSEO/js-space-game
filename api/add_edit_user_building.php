<?php
require_once('db_connect.php');

$userBuildingId = $_GET['userbuildingid']; // if NULL new building : upgradeBuilding
$userId = $userData->userId;
$buildingId = $_GET['buildingid'];
$timeStamp = $_GET['timestamp'];
$level = $_GET['level'];
//$status = $_GET['status'];
$error = null;
$status = null;

if($userBuildingId === '') {
	//creat New User Building
	$sql = "INSERT INTO userBuildings (userId, buildingId, upgradeStartTime, level) VALUES ('$userId', '$buildingId', '$timeStamp', '$level')";
	// 			$result = $db->query( $sql );
	try{
		$result = $db->prepare($sql);
		$result->execute();
		$userBuildingId = $db->lastInsertId();
		//var_dump($userBuildingId);
		$status = "created";
	} catch(PDOException $e) {
		$error = '<p class="bg-danger">'.$e->getMessage().'</p>';
		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
	}
} else {
	//update User Building
	$status = "updated";
}
if($error == null){
	$output = json_encode(
	[
		'userBuildingId' => $userBuildingId,
		'status' => $status
	], JSON_UNESCAPED_UNICODE);
	print $output;
}
?>
