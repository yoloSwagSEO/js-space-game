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
	}
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
