<div class="container">
	<h3>Database Buildings</h3>
	<div class="building_list row" data-bind="foreach: SpaceGame.db_buildings">
		<div class="building_frame col s12 m6 l4">
			<div class="building">
				<span data-bind="text:id()" class="hidden"></span>
				<div class="info_layer">
						<div data-bind="text:name()" class="name"></div>
						<div data-bind="text:description()" class="description"></div>
				</div>
				<div class="build_layer">
					<span class="left">
						<span class="powers">
							<div class="power_table" data-bind="foreach: powers()">
								<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'+'+(value() * $parent.powerMultiplier()).toFixed(1)"></span></div>
							</div>
						</span>
						<span class="costs">
							<div class="power_table" data-bind="foreach: resources()">
								<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'-'+(value() * $parent.resourceMultiplier()).toFixed(1)"></span></div>
							</div>
						</span>
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
		<div class="building_frame col s12 m6 l4">
			<div class="building">
				<span data-bind="text:id()" class="hidden"></span>
				<div class="info_layer" data-bind="attr: { style: progressWidth }">
						<div data-bind="text:name()" class="name"></div>
						<div data-bind="text:description()" class="description"></div>
				</div>
				<div class="build_layer">
					<span class="left">
						<span class="powers">
							<div class="ress"><span class="kind level">Level</span><span class="value" data-bind="text:level()"></span></div>
							<div class="power_table" data-bind="foreach: powers()">
								<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'+'+(value() * $parent.powerMultiplier()).toFixed(1)"></span></div>
							</div>
						</span>
						<span class="costs">
							<div class="power_table" data-bind="foreach: resources()">
								<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'-'+(value() * $parent.resourceMultiplier()).toFixed(1)"></span></div>
							</div>
						</span>
					</span>
					<span class="right">
						<span data-bind="click: function(e,d){ StartCounter(true, 0); console.log('wtf!!!'); }, visible: !isRunning()" class="startBuilding">
							<i class="fa fa-wrench" aria-hidden="true"></i>
							<span class="value"data-bind="text:buildTimeText()" class="buildTime"></span>
						</span>
						<div data-bind="text:remainingTimeText() , visible: isRunning()" class="buildTime"></div>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
