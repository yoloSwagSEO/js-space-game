<?php
require_once("db_connect.php");
// var_dump($dbhandle);
// var_dump($userData);

$buildingQuery = "SELECT * FROM Buildings";
$buildingFind = mysqli_query($dbhandle, $buildingQuery);
// var_dump($buildingFind);
if ($buildingFind && mysqli_num_rows($buildingFind) != 0) {
	while ($buildingRow = mysqli_fetch_assoc($buildingFind)) {
		// var_dump($buildingRow);
		$db_buildings[] = new Building($buildingRow, $dbhandle);
	}
}else{
	echo "no Buildings found in DB!";
}

$resourceQuery = "SELECT * FROM Resources";
$resourceFind = mysqli_query($dbhandle, $resourceQuery);
// var_dump($resourceFind);
if ($resourceFind && mysqli_num_rows($resourceFind) != 0) {
	while ($resourceRow = mysqli_fetch_assoc($resourceFind)) {
		// var_dump($resourceRow);
		$resources[] = new Resource($resourceRow);
	}
}else{
	echo "no Resources found in DB!";
}

$output = json_encode(
[
	'db_buildings' => $db_buildings,
	'resources' => $resources
], JSON_UNESCAPED_UNICODE);
print $output;


/********************************************************
************************ CLASSES ************************
********************************************************/

Class Building {
	public $id;
	public $name;
	public $description;
	public $powerMultiplier;
	public $resourceMultiplier;
	public $powers;
	public $resources;

	public function __construct($data, $dbhandle) {
		$this->id = $data['id'];
		$this->name = $data['name'];
		$this->description = $data['description'];
		$this->buildTime = $data['buildTime'];
		$this->buildTimeMultiplier = $data['buildTimeMultiplier'];
		$this->powerMultiplier = $data['powerMultiplier'];
		$this->resourceMultiplier = $data['resourceMultiplier'];
		$this->powers = null;
		$this->resources = null;

		$powerQuery = "SELECT *, resourcePower as value FROM BuildingPowers WHERE buildingId = '$this->id';";
		$powerFind = mysqli_query($dbhandle, $powerQuery);
		// var_dump($powerFind);
		if ($powerFind && mysqli_num_rows($powerFind) != 0) {
			while ($powerRow = mysqli_fetch_assoc($powerFind)) {
				// var_dump($powerRow);
				$powers[] = new BuildingResource($powerRow);
			}
			$this->powers = $powers;
		}else{
			echo "no BuildingPowers found in DB!";
		}

		$resourceQuery = "SELECT *, resourceCost as value  FROM BuildingCosts WHERE buildingId = '$this->id';";
		$resourceFind = mysqli_query($dbhandle, $resourceQuery);
		// var_dump($resourceFind);
		if ($resourceFind && mysqli_num_rows($resourceFind) != 0) {
			while ($resourceRow = mysqli_fetch_assoc($resourceFind)) {
				// var_dump($resourceRow);
				$resources[] = new BuildingResource($resourceRow);
			}
			$this->resources = $resources;
		}else{
			echo "no BuildingCosts found in DB!";
		}
	}
}

Class BuildingResource {
	public $resourceId;
	public $value;

	public function __construct($data) {
		$this->resourceId = $data['resourceId'];
		$this->value = $data['value'];
	}
}

Class Resource {
	public $id;
	public $name;
	public $description;

	public function __construct($data) {
		$this->id = $data['id'];
		$this->name = $data['name'];
		$this->description = $data['description'];
	}
}
?>
