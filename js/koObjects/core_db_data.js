function DB_Building(data) {
	var self = this;
	self.id = ko.observable(data.id);
	self.name = ko.observable(data.name);
	self.description = ko.observable(data.description);
	self.buildTime = ko.observable(data.buildTime);
	self.buildTimeMultiplier = ko.observable(data.buildTimeMultiplier);
	self.powerMultiplier = ko.observable(data.powerMultiplier);
	self.resourceMultiplier = ko.observable(data.resourceMultiplier);
	self.powers = ko.observableArray();
	self.resources = ko.observableArray();
	$.each(data.powers, function(index, value) {
		self.powers.push(new DB_BuildingResource(value));
	});
	$.each(data.resources, function(index, value) {
		self.resources.push(new DB_BuildingResource(value));
	});
	self.realBuildTime = ko.computed(function() {
		var time = SpaceGame.calculat_build_time(self.buildTime(), self.buildTimeMultiplier(), 0);
		return time;
	});
	self.buildTimeText = ko.computed(function() {
		return 'build time: ' + SpaceGame.buildTimeString(self.realBuildTime());
	});

	self.startBuilding = function(data, e){
		console.log('addNewUserBuilding', e, data);
		SpaceGame.user_buildings.push(new USER_Building(data, false));

		SpaceGame.apiStatus('fetch');
		$.ajax({
			url: 'api/add_edit_user_building.php',
			data: {
				'userid': '',
				'buildingid': '',
				'userbuildingid': '',
				'level': '',
				'timestamp': '',
				'status': ''
			},
			cache: false
		}).done(function(data) {
			console.log(data);
			// var obj = JSON3.parse(data);
			// SpaceGame.db_buildings.removeAll();
			// $.each(obj.buildings, function(index, value) {
			// 	SpaceGame.db_buildings.push(new DB_Building(value));
			// 	console.log(index, value);
			// });
			// $.each(obj.resources, function(index, value) {
			// 	SpaceGame.db_resources.push(new DB_Resource(value));
			// 	console.log(index, value);
			// });
			SpaceGame.apiStatus('done');
		}).error(function(data) {
			console.log("NEW AJAX ERROR!", data);
		});

	};
}

function DB_BuildingResource(data) {
	var self = this;
	self.resourceId = ko.observable(data.resourceId);
	self.value = ko.observable(data.value);
}

function DB_Resource(data) {
	var self = this;
	self.id = ko.observable(data.id);
	self.name = ko.observable(data.name);
	self.description = ko.observable(data.description);
}
