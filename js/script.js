console.log('start');
Game = function(){
	if(Game.buildings === undefined){
		var self = this;
		Game.apiStatus = ko.observable();
		Game.buildings = ko.observableArray();
		Game.countDown = ko.observable();
		Game.apiStatus('fetch');

		// add static test-buildings TODO: load from DB
		Game.initBetaData = function(){
			var currentTime = new Date().getTime();
			Game.buildings.push(new Building([1, 1, 'Titan Mine', 10, 4, 11]));//(new Date()).getTime()
			Game.buildings.push(new Building([2, 1, 'Solar Energy Power Plant', 15, 4, 11]));//(new Date()).getTime()
			// console.log(Game.buildings());
			console.log('FAIL!!!');
		};
		Game.initBetaData();
	}else{
		console.log('WTF');
	}
};
ko.applyBindings(Game);
