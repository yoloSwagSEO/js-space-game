function DB_Building(data) {
	self = this;
	this.id = ko.observable(data.id);
	this.name = ko.observable(data.name);
	this.description = ko.observable(data.description);
	this.powerMultiplier = ko.observable(data.powerMultiplier);
	this.resourceMultiplier = ko.observable(data.resourceMultiplier);
	this.powers = ko.observableArray();
	this.resources = ko.observableArray();
	$.each(data.powers, function(index, value) {
		self.powers.push(new DB_BuildingResource(value));
	});
	$.each(data.resources, function(index, value) {
		self.resources.push(new DB_BuildingResource(value));
	});
}

function DB_BuildingResource(data) {
	this.resourceId = ko.observable(data.resourceId);
	this.value = ko.observable(data.value);
}

function DB_Resource(data) {
	this.id = ko.observable(data.id);
	this.name = ko.observable(data.name);
	this.description = ko.observable(data.description);
}
