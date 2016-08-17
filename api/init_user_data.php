<?php
require_once("db_connect.php");
// var_dump($dbhandle);
// var_dump($userData);

$buildingQuery = "SELECT * FROM userbuildings WHERE userId = '$userData->userId';";
$buildingFind = mysqli_query($dbhandle, $buildingQuery);
// var_dump($buildingFind);
if ($buildingFind && mysqli_num_rows($buildingFind) != 0) {
	while ($buildingRow = mysqli_fetch_assoc($buildingFind)) {
		// var_dump($buildingRow);
		$user_buildings[] = new UserBuilding($buildingRow, $dbhandle);
	}
}else{
	echo "no Buildings found in DB!";
}

$output = json_encode(
[
	'user_buildings' => $user_buildings
], JSON_UNESCAPED_UNICODE);
print $output;


/********************************************************
************************ CLASSES ************************
********************************************************/

Class UserBuilding {
	public $id;
	public $buildingId;
	public $startBuildingTime;
	public $level;

	public function __construct($data) {
		$this->id = $data['id'];
		$this->buildingId = $data['buildingId'];
		$this->startBuildingTime = $data['upgradeStartTime'];
		$this->level = $data['level'];
	}
}
?>
