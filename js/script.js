console.log('start');
SpaceGame = function(){
	var self = this;
	SpaceGame.apiStatus = ko.observable();
	SpaceGame.db_buildings = ko.observableArray();
	SpaceGame.db_resources = ko.observableArray();

	SpaceGame.user_buildings = ko.observableArray();

	SpaceGame.apiStatus('fetch');

	// add static test-buildings TODO: load from DB
	SpaceGame.load_db_buildings = function(status){
		SpaceGame.apiStatus('fetch');
		$.ajax({
			url: 'api/init_db_data.php',
			data: {},
			cache: false
		}).done(function(data) {
			//console.log(data);
			var obj = JSON3.parse(data);
			SpaceGame.db_buildings.removeAll();
			$.each(obj.buildings, function(index, value) {
				SpaceGame.db_buildings.push(new DB_Building(value));
				console.log(index, value);
			});
			$.each(obj.resources, function(index, value) {
				SpaceGame.db_resources.push(new DB_Resource(value));
				console.log(index, value);
			});
			SpaceGame.apiStatus('done');
		}).error(function(data) {
			console.log("NEW AJAX ERROR!", data);
		});
	};
	SpaceGame.load_db_buildings();

	SpaceGame.calculat_build_time = function(buildTime, multiplier, level){
		level++;
		var time = Math.floor((buildTime*level)+Math.pow(buildTime, level/multiplier));
		console.log('calc', time);
		return time;
	};

	SpaceGame.buildTimeString = function(timeVal){
		var timeStr = "";
		if (timeVal > (60*60*24)){
			timeStr = (timeVal / 60 / 60 / 24).toFixed(1) + "d";
		} else if (timeVal > (60*60)){
			timeStr = (timeVal / 60 / 60).toFixed(1) + "h";
		} else if (timeVal > 60){
			timeStr = (timeVal / 60).toFixed(1) + "m";
		} else {
			timeStr = timeVal + "s";
		}
		return timeStr;
	};
};
ko.applyBindings(SpaceGame);
