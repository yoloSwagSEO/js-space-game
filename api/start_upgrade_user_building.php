<?php
require_once('db_connect.php');

$userBuildingId = $_GET['userbuildingid']; // if NULL new building : upgradeBuilding
$userId = $userData->userId;
$startBuildingTime = $_GET['startBuildingTime'];
//echo $userBuildingId.' - '.$startBuildingTime;
//$status = $_GET['status'];
$error = null;
$status = null;

//upgrade User Building
$sql = "UPDATE userbuildings SET upgradeStartTime='$startBuildingTime' WHERE userId='$userId' AND id='$userBuildingId';";
// 			$result = $db->query( $sql );
try{
	$result = $db->prepare($sql);
	$result->execute();
	//var_dump($userBuildingId);
	$status = "started";
} catch(PDOException $e) {
	$error = '<p class="bg-danger">'.$e->getMessage().'</p>';
	echo '<p class="bg-danger">'.$e->getMessage().'</p>';
}
if($error == null){
	$output = json_encode(
	[
		'status' => $status
	], JSON_UNESCAPED_UNICODE);
	print $output;
}
?>
