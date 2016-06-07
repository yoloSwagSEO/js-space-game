function Building(data){
	var self = this;
	self.id = ko.observable(data[0]);
	self.level = ko.observable(data[1]);
	self.info = ko.observable(data[2]);
	self.baseTime = ko.observable(data[3]);
	self.multiplier = ko.observable(data[4]);
	self.upgradeTime = ko.computed(function() {
		var	x = self.level() + 1.0;
		var	y = self.multiplier();
		var	z	= self.baseTime();
		var time = Math.floor((z*x)+Math.pow(z, x/y));
		return time; //Math.floor((z*x)+Math.pow(z, x/y));
		// Math.floor((self.baseTime()*(self.level() + 1))+Math.pow(self.baseTime(), (self.level() + 1)/self.multiplier()));
	});

	// upgradeTimer
	self.upgradeStartTime = ko.observable(data[5]);
	self.timerId = 0;
	self.elapsedTime = ko.observable(0);
	self.initialTime = self.upgradeTime;
	self.remainingTime = ko.computed(function(){
			return self.initialTime() - self.elapsedTime();
	});
	self.isRunning = ko.observable(false);
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

	// check if Building is still building!
	// console.log('upgradeStartTime', self.upgradeStartTime());
	// console.log('currentTime', (new Date()).getTime());
	// console.log('buildingTime', self.upgradeTime()*1000);
	// console.log('compare', (new Date()).getTime() - self.upgradeStartTime());
	// console.log('compare', (new Date()).getTime() - (self.upgradeStartTime() + (self.upgradeTime()*1000)));

	if((new Date()).getTime() - (self.upgradeStartTime() + (self.upgradeTime()*1000)) < 0){
		self.StartCounter();
	}
}
