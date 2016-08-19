<div class="container">
	<h3>Database Buildings</h3>
	<div class="building_list row" data-bind="foreach: SpaceGame.db_buildings">
		<div class="building_frame col s12 m6">
			<div class="building">
				<span data-bind="text:id()" class="hidden"></span>
				<div class="info_layer">
					<span class="left">
						<span data-bind="text:name()" class="name"></span>
						<span data-bind="text:description()" class="description"></span>
					</span>
					<span class="right">
						<div class="power_table" data-bind="foreach: powers()">
							<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'+'+(value() * $parent.powerMultiplier()).toFixed(1)"></span></div>
						</div>
						
						<div class="ress">
							<span class="kind">Time</span>
							<span class="value"data-bind="text:buildTimeText()" class="buildTime"></span>
						</div>
					</span>
				</div>
				<div class="build_layer">
					<span class="left">
						<div class="power_table" data-bind="foreach: resources()">
							<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'-'+(value() * $parent.resourceMultiplier()).toFixed(1)"></span></div>
						</div>
					</span>
					<span class="right">
						<span data-bind="click: startBuilding" class="startBuilding">
							<i class="fa fa-gavel" aria-hidden="true"></i>
							<div data-bind="text:buildTimeText()" class="buildTime"></div>
						</span>
					</span>
				</div>
			</div>
		</div>
	</div>
	<!-- User Buildings -->
	<h3>USER Buildings</h3>
	<div class="building_list row" data-bind="foreach: SpaceGame.user_buildings">
		<div class="building_frame col s12 m6">
			<div class="building" data-bind="css: {running: isRunning()}">
				<span data-bind="text:id()" class="hidden"></span>
				<div class="info_layer" data-bind="attr: { style: progressWidth }">
					<span class="left">
						<span data-bind="text:name()" class="name"></span>
						<span data-bind="text:description()" class="description"></span>
						<span data-bind="text:level()" class="level"></span>
					</span>
					<span class="right">
						<div class="power_table" data-bind="foreach: powers(), visible: !isRunning()">
							<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'+'+(SpaceGame.multiplyValues(value(), $parent.powerMultiplier(), $parent.level())).toFixed(1)"></span></div>
						</div>
						<div class="ress" data-bind="visible: !isRunning()">
							<span class="kind">Time</span>
							<span class="value"data-bind="text:buildTimeText()" class="buildTime"></span>
						</div>
						<div data-bind="text:remainingTimeText() , visible: isRunning()" class="buildTime"></div>
					</span>
				</div>
				<div class="build_layer" data-bind="visible: !isRunning()">
					<span class="left">
						<div class="power_table" data-bind="foreach: resources()">
							<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'-'+(SpaceGame.multiplyValues(value(), $parent.powerMultiplier(), $parent.level())).toFixed(1)"></span></div>
						</div>
					</span>
					<span class="right">
						<span data-bind="click: function(e,d){ StartCounter(true, 0); console.log('wtf!!!'); }, visible: !isRunning()" class="startBuilding">
							<i class="fa fa-wrench" aria-hidden="true"></i
						</span>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
