function USER_Building(data, fromDb, startBuildingTime, userBuildingId, level) {
	var self = this;
	if (fromDb) { // init from DB
		// console.log('USER_Building fromDb');
	} else { // init from knockoutObject
		// console.log('USER_Building from knockoutObject');
	}
	self.id = ko.observable(data.id());
	self.userBuildingId = ko.observable(userBuildingId);
	self.level = ko.observable(parseInt(level));
	self.name = ko.observable(data.name());
	self.description = ko.observable(data.description());
	self.buildTime = ko.observable(data.buildTime());
	self.buildTimeMultiplier = ko.observable(data.buildTimeMultiplier());
	self.powerMultiplier = ko.observable(data.powerMultiplier());
	self.resourceMultiplier = ko.observable(data.resourceMultiplier());
	self.powers = ko.observableArray(data.powers());
	self.resources = ko.observableArray(data.resources());
	self.realBuildTime = ko.computed(function() {
		var time = SpaceGame.multiplyValues(self.buildTime(), self.buildTimeMultiplier(), self.level());
		return time;
	});
	self.buildTimeText = ko.computed(function() {
		return SpaceGame.buildTimeString(self.realBuildTime());
	});
	self.upgradeStartTime = ko.observable(parseInt(startBuildingTime));

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
				"background: -moz-linear-gradient(left,  #01b623 0%, #01b623 " +parseInt(progress)+"%, rgba(255,255,255, 0) "+(parseInt(progress)+1)+"%, rgba(255,255,255, 0) 100%);"+
				"background: -webkit-linear-gradient(left,  #01b623 0%, #01b623 " +parseInt(progress)+"%, rgba(255,255,255, 0) "+(parseInt(progress)+1)+"%, rgba(255,255,255, 0) 100%);"+
				"background: linear-gradient(to right,  #01b623 0%, #01b623 " +parseInt(progress)+"%, rgba(255,255,255, 0) "+(parseInt(progress)+1)+"%, rgba(255,255,255, 0) 100%);"
				: "";
		return progressStr;
	});
	self.StartCounter = function(fresh, elapsed){
		if(fresh===true){
			// console.log("new Building timer!");
			SpaceGame.apiStatus('fetch');
			$.ajax({
				url: 'api/start_upgrade_user_building.php',
				data: {
					'userbuildingid': self.userBuildingId(),
					'startBuildingTime': (new Date()).getTime()
				},
				cache: false
			}).done(function(value) {
				// console.log(value);
				var obj = JSON3.parse(value);
				SpaceGame.apiStatus('done');
				// console.log('started!!');
			}).error(function(value) {
				// console.log("NEW AJAX ERROR!", value);
			});
		}
		// StartTimer
		self.elapsedTime(elapsed);
		self.isRunning(true);
		SpaceGame.sortBuildings();
		self.timerId = window.setInterval(function(){
			self.elapsedTime(self.elapsedTime()+1);
			if(self.remainingTime() <= 0){
				clearInterval(self.timerId);
				self.isRunning(false);
				self.UpgradeBuilding();
			}
		},1000);
	};
	self.StopCounter = function(){
		clearInterval(self.timerId);
		self.isRunning(false);
	};
	self.UpgradeBuilding = function(){
		self.level(self.level()+1);
		SpaceGame.apiStatus('fetch');
		$.ajax({
			url: 'api/upgrade_user_building.php',
			data: {
				'userbuildingid': self.userBuildingId(),
				'level': self.level()
			},
			cache: false
		}).done(function(value) {
			// console.log(value);
			var obj = JSON3.parse(value);
			SpaceGame.apiStatus('done');
			// console.log('upgraded!!');
		}).error(function(value) {
			// console.log("NEW AJAX ERROR!", value);
		});
	};

	if(self.upgradeStartTime() !== 0){
		var rightNow = (new Date()).getTime();
		if(rightNow - (self.upgradeStartTime() + (self.realBuildTime()*1000)) < 0){
			// console.log('buildtime:', (new Date()).getTime() - (self.upgradeStartTime() + (self.realBuildTime()*1000)));
			var elapsed = parseInt((rightNow - self.upgradeStartTime()) / 1000);
			self.StartCounter(false, elapsed);
		}else{
			self.UpgradeBuilding();
		}
	}
}
