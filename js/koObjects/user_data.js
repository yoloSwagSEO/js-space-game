function USER_Building(data, fromDb) {
	var self = this;
	if (fromDb) { // init from DB
		self.id = ko.observable(data.id);
		self.level = ko.observable(/* TODO value from DB */);
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
			return 'upgrade time: ' + SpaceGame.buildTimeString(self.realBuildTime());
		});
		self.upgradeStartTime = ko.observable(/* TODO: value from DB */);
	} else { // init from knockoutObject
		self.id = ko.observable(data.id());
		self.level = ko.observable(0);
		self.name = ko.observable(data.name());
		self.description = ko.observable(data.description());
		self.buildTime = ko.observable(data.buildTime());
		self.buildTimeMultiplier = ko.observable(data.buildTimeMultiplier());
		self.powerMultiplier = ko.observable(data.powerMultiplier());
		self.resourceMultiplier = ko.observable(data.resourceMultiplier());
		self.powers = ko.observableArray();
		self.resources = ko.observableArray();
		$.each(data.powers(), function(index, value) {
			self.powers.push(new DB_BuildingResource(value));
		});
		$.each(data.resources(), function(index, value) {
			self.resources.push(new DB_BuildingResource(value));
		});
		self.realBuildTime = ko.computed(function() {
			var time = SpaceGame.calculat_build_time(self.buildTime(), self.buildTimeMultiplier(), self.level());
			return time;
		});
		self.buildTimeText = ko.computed(function() {
			return 'upgrade time: ' + SpaceGame.buildTimeString(self.realBuildTime());
		});
		self.upgradeStartTime = ko.observable((new Date()).getTime());
	}

	// upgradeTimer
	self.timerId = 0;
	self.elapsedTime = ko.observable(0);
	self.initialTime = ko.computed(function(){
			return self.realBuildTime();
	});
	self.remainingTime = ko.computed(function(){
			return self.initialTime() - self.elapsedTime();
	});
	self.remainingTimeText = ko.computed(function() {
		return SpaceGame.buildTimeString(self.remainingTime());
	});
	self.isRunning = ko.observable(false);
	self.progressWidth = ko.computed(function() {
		var progress = ((self.elapsedTime() * 100) / self.initialTime()).toFixed(0);
		var progressStr = self.isRunning() ?
				"background: -moz-linear-gradient(left,  #d0d0d0 0%, #d0d0d0 " +parseInt(progress)+"%, rgba(255,255,255, 0.45) "+(parseInt(progress)+1)+"%, rgba(255,255,255, 0.45) 100%);"+
				"background: -webkit-linear-gradient(left,  #d0d0d0 0%, #d0d0d0 " +parseInt(progress)+"%, rgba(255,255,255, 0.45) "+(parseInt(progress)+1)+"%, rgba(255,255,255, 0.45) 100%);"+
				"background: linear-gradient(to right,  #d0d0d0 0%, #d0d0d0 " +parseInt(progress)+"%, rgba(255,255,255, 0.45) "+(parseInt(progress)+1)+"%, rgba(255,255,255, 0.45) 100%);"
				: "";
		return progressStr;
	});
	self.StartCounter = function(){
		self.elapsedTime(0);
		self.isRunning(true);
		self.timerId = window.setInterval(function(){
			self.elapsedTime(self.elapsedTime()+1);
			if(self.remainingTime() <= 0){
				clearInterval(self.timerId);
				self.isRunning(false);
				self.Callback();
			}
		},1000);
	};
	self.StopCounter = function(){
		clearInterval(self.timerId);
		self.isRunning(false);
	};
	self.Callback = function(){
		console.log('upgraded!!');
		self.level(self.level()+1);
	};

	if((new Date()).getTime() - (self.upgradeStartTime() + (self.realBuildTime()*1000)) < 0){
		self.StartCounter();
	}
}